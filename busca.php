<?
include('topo.php');
require_once('scripts/conexao.php');
require_once('scripts/funcoes.php');
require_once('scripts/mysql.php');

#categorias
unset($a);
$contador = 0;

$palavras = explode(' ',$busca);
foreach($palavras as $termo){

	if($contador == 0){
		$a[] = " where (";
	} else {
		$a[] = " or (";
	}

	$a[] = "(titulo like '%".$termo."%') or ";
	$a[] = "(descricao like '%".$termo."%') ";
	$a[] = ")";

	$contador++;
}

$possibilidades = join(" ",$a);
$cond = $possibilidades;

$sql = mysql_query("select * from ".CATEGORIAS." ".$cond);
if(mysql_num_rows($sql) > 0){
	while($rs = mysql_fetch_object($sql)){
		$retorno[] =  array('titulo' => $rs->titulo,
							'link' => ($rs->idioma!='br'?$rs->idioma.'/':'').$rs->slug.'/',
							'categoria' => $_rotulos['produtos']);
	}
}

#produtos
unset($a);
$contador = 0;

$palavras = explode(' ',$busca);
foreach($palavras as $termo){

	if($contador == 0){
		$a[] = " where (";
	} else {
		$a[] = " or (";
	}

	$a[] = "(p.titulo_completo like '%".$termo."%') or ";
	$a[] = "(p.titulo like '%".$termo."%') or ";
	$a[] = "(p.subtitulo like '%".$termo."%') or ";
	$a[] = "(p.descricao like '%".$termo."%') ";
	$a[] = ")";

	$contador++;
}

$possibilidades = join(" ",$a);
$cond = $possibilidades;

$sql = mysql_query("select distinct
						p.*,
						c.slug as slug_cat
					from
						".PRODUTOS." p
						left join ".CATEGORIAS." c on (p.idcategoria = c.idcategoria)
					".$cond);

if(mysql_num_rows($sql) > 0){
	while($rs = mysql_fetch_object($sql)){
		$retorno[] =  array('titulo' => $rs->titulo_completo,
							'link' => ($rs->idioma!='br'?$rs->idioma.'/':'').$rs->slug_cat.'/'.$rs->slug.'/'.$rs->idproduto.'/',
							'categoria' => $_rotulos['produtos']);
	}
}

#noticias
unset($a);
$contador = 0;

$palavras = explode(' ',$busca);
foreach($palavras as $termo){

	if($contador == 0){
		$a[] = " where (";
	} else {
		$a[] = " or (";
	}

	$a[] = "(n.titulo like '%".$termo."%') or ";
	$a[] = "(n.breve like '%".$termo."%') or ";
	$a[] = "(n.descricao like '%".$termo."%') ";
	$a[] = ")";

	$contador++;
}

$possibilidades = join(" ",$a);
$cond = $possibilidades;

$sql = mysql_query("select
						n.*,
						c.slug as slug_cat
					from
						".NOTICIAS." n
						left join ".CATEGORIAS." c on (n.idcategoria = c.idcategoria)
					".$cond."
					order by n.data desc");

if(mysql_num_rows($sql) > 0){
	while($rs = mysql_fetch_object($sql)){
		$retorno[] =  array('titulo' => $rs->titulo,
							'link' =>  $_links['noticia'].$rs->slug_cat.'/'.converteData($rs->data,'Y/m/d').'/'.$rs->slug.'/',
							'categoria' => $_rotulos['novidades']);
	}
}

# --- #

# resultado
$total = count($retorno);
if ($total > 0) ksort($retorno);

# --- #
# paginacao
if ($total > 0){
	$qtd = 15;
	$atual = (isset($_GET['pagina'])) ? intval($_GET['pagina']) : 1;
	$pagArquivo = array_chunk($retorno,$qtd);
	$contar = count($pagArquivo);
	$resultado = $pagArquivo[$atual-1];
}
?>
	<div class="central">
		<div class="conteudo">

			<h1><?=$_rotulos['resultados busca']?> <?=$busca?></h1>
            <div class="resultados-busca">
            	<?
				if($total > 0){

					foreach($resultado as $rs){
						$categoria = '<span>'.$rs['categoria'].'</span>';

						echo '<div class="item">';
						echo '<a href="'.$rs['link'].'">'.$categoria.$rs['titulo'].'</a>';
						echo '</div>';
					}

				} else {
					echo '<p class="centraliza">Nenhum resultado encontrado para essa busca!</p>';
				}
				?>
			</div>
            <?
			#paginacao
			if($total > $qtd){
				echo '<div class="paginacao">';
				echo '<div class="pag-resultados">';
					if ($atual != 1){
						echo '<a href="'.$http.'busca/'.$busca.'/'.($atual-1).'/" class="seta anterior"></a>';
					}

					for ($i = 1; $i <= $contar; $i++){
						if($i == $atual){
							echo '<a href="#" class="atual">',$i,'</a>';
						} elseif (($i >= ($atual - 2)) && (($i <= ($atual + 2)))){
							echo '<a href="',$http,'busca/',$busca,'/',$i,'">',$i,'</a>';
						}
					}

					if ($atual != ($i-1)){
						echo '<a href="'.$http.'busca/'.$busca.'/'.($atual+1).'/" class="seta proximo"></a>';
					}
				echo '</div>';
				echo '</div>';
			}
			?>
		</div>
	</div>

<? include('rodape.php') ?>