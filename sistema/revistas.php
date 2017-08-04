<?
include("include-topo.php");

$path_arq = '../arquivos/revistas/';

$path_temp = '../img/revistas/temp/';
$path_p = '../img/revistas/p/';
$path = '../img/revistas/';
?>
<div id="conteudo">
	<div class="topo">
		<h1>Revistas</h1>
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

		$query = mysql_query("select * from ".REVISTAS." order by posicao desc");

		if(mysql_num_rows($query) == 0){ ?>
			<p>N&atilde;o há itens cadastrados!</p>
		<? } else { ?>
        	<div class="listagem">
                <div class="cabecalho">
                	<span class="idioma">Idioma</span>
                    <span class="preview">Preview</span>
                    <span class="titulo">Título</span>
                    <span class="arquivo">Arquivo</span>
                    <span class="galeria">Galeria</span>
                    <span class="ativo">Ativo</span>
                    <span class="editar">Editar</span>
                    <span class="remover">Remover</span>
                    <span class="posicao">Ordenar</span>
                    <div class="clear"></div>
				</div>
                <div id="sortable">
					<input type="hidden" name="tabela" id="tabela" value="<?=REVISTAS?>" />
                    <input type="hidden" name="campo" id="campo" value="idrevista" />
                    <?
                    while($rs = mysql_fetch_assoc($query)){
						$ativo = ($rs['ativo'] == 'S') ? 'ico-ativo-on.png' : 'ico-ativo-off.png';
						$qtd_fotos = mysql_num_rows(mysql_query("select * from ".REVISTAS_IMGS." where idrevista = '".$rs['idrevista']."'"));
					?>
                    <div class="caixa-revista posiciona" data-id="<?=$rs['idrevista']?>">
                        <span class="idioma"><img src="../img/sistema/<?=$rs['idioma']?>.png" border="0" /></span>
                        <span class="preview"><a href="<?=$path.$rs['imagem']?>" class="fancybox"><img src="<?=$path_p.$rs['imagem']?>" title="<?=$rs['titulo']?>" border="0" /></a></span>
                        <span class="titulo"><?=$rs['titulo']?></span>
						<span class="arquivo">
							<? if($rs['arquivo'] != ''){ ?>
								<a href="<?=$path_arq.$rs['arquivo']?>" target="_blank"><img src="../img/sistema/ico-lupa.png" alt="Visualizar" /></a>
							<?
                            } else {
                            	echo '-';
                            }
                            ?>
                        </span>
                        <span class="galeria"><a href="revistas-imgs.php?acao=listar&idrevista=<?=$rs['idrevista']?>"><img src="../img/sistema/ico-galeria.png" class="vimg" /> (<?=$qtd_fotos?>)</a></span>
                        <span class="ativo"><img src="../img/sistema/<?=$ativo?>" longdesc="<?=REVISTAS?>-<?=$rs['idrevista']?>-idrevista" class="ativo cursor" /></span>
                        <span class="editar"><a href="?acao=editar&id=<?=$rs['idrevista']?>"><img src="../img/sistema/ico-editar.png" alt="editar" border="0" /></a></span>
						<span class="remover"><a href="javascript:void(0)" onClick="remover(<?=$rs['idrevista']?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" /></a></span>
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
			include('form/form-revistas.php');
			echo '</div>';
		} else {
			
			$idioma = seguranca($_POST['idioma']);
			$titulo = seguranca($_POST['titulo']);
			$slug = montaTag($titulo);
			$breve = seguranca($_POST['breve']);
			$imagem = $_FILES['imagem'];
			$arquivo = $_FILES['arquivo'];
			$ativo = seguranca($_POST['ativo']);
			$posicao = seguranca($_POST['posicao']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';
			
			$campos = "idioma,titulo,slug,breve,ativo,posicao";
			$valores = "'".$idioma."','".$titulo."','".$slug."','".$breve."','".$ativo."','".$posicao."'";
			inserir(REVISTAS,$campos,$valores);
			$ultimo = ultimoID();
			
			if($imagem['name'] != ''){

				$extensao = getExtensao($imagem['name']);
				$img = $ultimo.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($imagem['tmp_name'],$path_temp.$img);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(600,800);
				$imgg->grava($path.$img,100);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(100,133);
				$imgg->grava($path_p.$img,100);

				atualizar(REVISTAS,"imagem = '".$img."'","idrevista = ".$ultimo);
				if(is_file($path_temp.$img)) unlink($path_temp.$img);
			}

			if($arquivo['name'] != ''){
				$extensao = getExtensao($arquivo['name']);
				$arq = $ultimo.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($arquivo['tmp_name'],$path_arq.$arq);

				atualizar(REVISTAS,"arquivo = '".$arq."'","idrevista = ".$ultimo);
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'editar'){

		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-revistas.php');
			echo '</div>';
		} else {
			
			$idioma = seguranca($_POST['idioma']);
			$titulo = seguranca($_POST['titulo']);
			$slug = montaTag($titulo);
			$breve = seguranca($_POST['breve']);
			$imagem = $_FILES['imagem'];
			$hidden = seguranca($_POST['hidden']);
			$arquivo = $_FILES['arquivo'];
			$hidden_arq = seguranca($_POST['hidden_arq']);
			$ativo = seguranca($_POST['ativo']);
			$posicao = seguranca($_POST['posicao']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';

			$dados = "idioma = '".$idioma."',titulo = '".$titulo."',url = '".$url."',blank = '".$blank."',ativo = '".$ativo."',posicao = '".$posicao."'";
			atualizar(REVISTAS,$dados,"idrevista = ".$id);

			if($imagem['name'] != ''){
				if(is_file($path_temp.$hidden)) unlink($path_temp.$hidden);
				if(is_file($path_p.$hidden)) unlink($path_p.$hidden);
				if(is_file($path.$hidden)) unlink($path.$hidden);

				$extensao = getExtensao($imagem['name']);
				$img = $id.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($imagem['tmp_name'],$path_temp.$img);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(600,800);
				$imgg->grava($path.$img,100);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(100,133);
				$imgg->grava($path_p.$img,100);

				atualizar(REVISTAS,"imagem = '".$img."'","idrevista = ".$id);
				if(is_file($path_temp.$img)) unlink($path_temp.$img);
			}

			if($arquivo['name'] != ''){
				if(is_file($path_arq.$hidden_arq)) unlink($path_arq.$hidden_arq);

				$extensao = getExtensao($arquivo['name']);
				$arq = $id.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($arquivo['tmp_name'],$path_arq.$arq);

				atualizar(REVISTAS,"arquivo = '".$arq."'","idrevista = ".$id);
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'remover'){
		if(is_numeric($id)){
			$img = mysql_fetch_assoc(mysql_query("select * from ".REVISTAS." where idrevista = ".$id));

			if(is_file($path_arq.$img['arquivo'])) unlink($path_arq.$img['arquivo']);

			if(is_file($path_temp.$img['imagem'])) unlink($path_temp.$img['imagem']);
			if(is_file($path_p.$img['imagem'])) unlink($path_p.$img['imagem']);
			if(is_file($path.$img['imagem'])) unlink($path.$img['imagem']);

			deletar(REVISTAS,"where idrevista = ".$id);
		}
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
	}
	?>
</div>
<? include("include-rodape.php"); ?>