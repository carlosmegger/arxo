<?
include("include-topo.php");

$path_temp = '../img/clientes/temp/';
$path = '../img/clientes/';
?>
<div id="conteudo">
	<div class="topo">
		<h1>Clientes</h1>
		<div>
        <? if($acao == ''){ ?>
			<a href="?acao=adicionar" class="adicionar">adicionar</a>
		<? } else { ?>
        	<a href="javascript:history.back()" class="voltar">&laquo; voltar</a>
		<? } ?>
		</div>
	</div>

	<?
    if($acao == ''){

		$query = mysql_query("select * from ".CLIENTES." order by posicao desc");

		if(mysql_num_rows($query) == 0){ ?>
			<p>N&atilde;o há itens cadastrados!</p>
		<? } else { ?>
        	<div class="listagem">
                <div class="cabecalho">
                    <span class="preview">Preview</span>
                    <span class="titulo">Título</span>
                    <span class="ativo">Ativo</span>
                    <span class="editar">Editar</span>
					<span class="remover">Remover</span>
                    <span class="posicao">Ordenar</span>
					<div class="clear"></div>
				</div>
                <div id="sortable">
                	<input type="hidden" name="tabela" id="tabela" value="<?=CLIENTES?>" />
                    <input type="hidden" name="campo" id="campo" value="idcliente" />
                    <?
                    while($rs = mysql_fetch_assoc($query)){
                        $ativo = ($rs['ativo'] == 'S') ? 'ico-ativo-on.png' : 'ico-ativo-off.png';
						
						if($rs['url'] != '' && $rs['url'] != 'http://'){
							$linka = '<a href="'.$rs['url'].'" target="_blank">';
							$linkf = '</a>';
						} else {
							$linka = '';
							$linkf = '';
						}
					?>
                    <div class="caixa-cliente posiciona" data-id="<?=$rs['idcliente']?>">
                        <span class="preview"><?=$linka?><img src="<?=$path.$rs['imagem']?>" title="<?=$rs['titulo']?>" border="0" /><?=$linkf?></span>
                        <span class="titulo"><?=$rs['titulo']?></span>
                        <span class="ativo"><img src="../img/sistema/<?=$ativo?>" longdesc="<?=CLIENTES?>-<?=$rs['idcliente']?>-idcliente" class="ativo cursor" /></span>
                        <span class="editar"><a href="?acao=editar&id=<?=$rs['idcliente']?>"><img src="../img/sistema/ico-editar.png" alt="editar" border="0" /></a></span>
						<span class="remover"><a href="javascript:void(0)" onClick="remover(<?=$rs['idcliente']?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" /></a></span>
						<span class="posicao"></span>
					</div>
					<? } ?>
				</div>
			</div>
			<?
		}
	}
	elseif($acao == 'adicionar'){

		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-clientes.php');
			echo '</div>';
		} else {
			
			$titulo = seguranca($_POST['titulo']);
			$imagem = $_FILES['imagem'];
			$url = seguranca($_POST['url']);
			$ativo = seguranca($_POST['ativo']);
			$posicao = seguranca($_POST['posicao']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';

			$campos = "titulo,url,ativo,posicao";
			$valores = "'".$titulo."','".$url."','".$ativo."','".$posicao."'";
			inserir(CLIENTES,$campos,$valores);
			$ultimo = ultimoID();
			
			if($imagem['name'] != ''){
				$extensao = getExtensao($imagem['name']);
				$img = $ultimo.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($imagem['tmp_name'],$path_temp.$img);

				$imgg = new canvas($path_temp.$img);
				$imgg->hexa('#fff');
				$imgg->redimensiona(180,100,'preenchimento');
				$imgg->grava($path.$img,100);

				atualizar(CLIENTES,"imagem = '".$img."'","idcliente = ".$ultimo);
				if(is_file($path_temp.$img)) unlink($path_temp.$img);
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'editar'){

		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-clientes.php');
			echo '</div>';
		} else {
			
			$titulo = seguranca($_POST['titulo']);
			$imagem = $_FILES['imagem'];
			$hidden = seguranca($_POST['hidden']);
			$url = seguranca($_POST['url']);
			$ativo = seguranca($_POST['ativo']);
			$posicao = seguranca($_POST['posicao']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';

			$dados = "titulo = '".$titulo."',url = '".$url."',ativo = '".$ativo."',posicao = '".$posicao."'";
			atualizar(CLIENTES,$dados,"idcliente = ".$id);
			
			if($imagem['name'] != ''){
				if(is_file($path_temp.$hidden)) unlink($path_temp.$hidden);
				if(is_file($path.$hidden)) unlink($path.$hidden);

				$extensao = getExtensao($imagem['name']);
				$img = $id.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($imagem['tmp_name'],$path_temp.$img);

				$imgg = new canvas($path_temp.$img);
				$imgg->hexa('#fff');
				$imgg->redimensiona(180,100,'preenchimento');
				$imgg->grava($path.$img,100);

				atualizar(CLIENTES,"imagem = '".$img."'","idcliente = ".$id);
				if(is_file($path_temp.$img)) unlink($path_temp.$img);
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'remover'){
		if(is_numeric($id)){
			$img = mysql_fetch_assoc(mysql_query("select * from ".CLIENTES." where idcliente = ".$id));

			if(is_file($path_temp.$img['imagem'])) unlink($path_temp.$img['imagem']);
			if(is_file($path.$img['imagem'])) unlink($path.$img['imagem']);

			deletar(CLIENTES,"where idcliente = ".$id);
		}
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
	}
	?>
</div>
<? include("include-rodape.php"); ?>