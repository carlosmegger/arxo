<?
include("include-topo.php");

$path_temp = '../img/slides/temp/';
$path_p = '../img/slides/p/';
$path_m = '../img/slides/m/';
$path = '../img/slides/';
?>
<div id="conteudo">
	<div class="topo">
		<h1>Slides</h1>
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

		$query = mysql_query("select * from ".SLIDES." order by posicao desc");

		if(mysql_num_rows($query) == 0){ ?>
			<p>N&atilde;o há itens cadastrados!</p>
		<? } else { ?>
        	<div class="listagem">
                <div class="cabecalho">
					<span class="idioma">Idioma</span>
                    <span class="preview">Preview</span>
                    <span class="titulo">Título</span>
                    <span class="ativo">Ativo</span>
                    <span class="editar">Editar</span>
					<span class="remover">Remover</span>
                    <span class="posicao">Ordenar</span>
					<div class="clear"></div>
				</div>
                <div id="sortable">
                	<input type="hidden" name="tabela" id="tabela" value="<?=SLIDES?>" />
                    <input type="hidden" name="campo" id="campo" value="idslide" />
                    <?
                    while($rs = mysql_fetch_assoc($query)){
                        $ativo = ($rs['ativo'] == 'S') ? 'ico-ativo-on.png' : 'ico-ativo-off.png';
					?>
                    <div class="caixa-slide posiciona" data-id="<?=$rs['idslide']?>">
                    	<span class="idioma"><img src="../img/sistema/<?=$rs['idioma']?>.png" border="0" /></span>
                        <span class="preview"><a href="<?=$path.$rs['imagem']?>" class="fancybox"><img src="<?=$path_p.$rs['imagem']?>" title="<?=$rs['titulo']?>" border="0" /></a></span>
                        <span class="titulo"><?=$rs['titulo']?></span>
                        <span class="ativo"><img src="../img/sistema/<?=$ativo?>" longdesc="<?=SLIDES?>-<?=$rs['idslide']?>-idslide" class="ativo cursor" /></span>
                        <span class="editar"><a href="?acao=editar&id=<?=$rs['idslide']?>"><img src="../img/sistema/ico-editar.png" alt="editar" border="0" /></a></span>
						<span class="remover"><a href="javascript:void(0)" onClick="remover(<?=$rs['idslide']?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" /></a></span>
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
			include('form/form-slides.php');
			echo '</div>';
		} else {

			$idioma = seguranca($_POST['idioma']);
			$titulo = seguranca($_POST['titulo']);
			$imagem = $_FILES['imagem'];
			$url = seguranca($_POST['url']);
			$blank = seguranca($_POST['blank']);
			$ativo = seguranca($_POST['ativo']);
			$posicao = seguranca($_POST['posicao']);
			$blank = ($blank == 'S') ? 'S' : 'N';
			$ativo = ($ativo == 'S') ? 'S' : 'N';
			
			$campos = "idioma,titulo,url,blank,ativo,posicao";
			$valores = "'".$idioma."','".$titulo."','".$url."','".$blank."','".$ativo."','".$posicao."'";
			inserir(SLIDES,$campos,$valores);
			$ultimo = ultimoID();
			
			if($imagem['name'] != ''){

				$extensao = getExtensao($imagem['name']);
				$img = $ultimo.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($imagem['tmp_name'],$path_temp.$img);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(2000,450);
				$imgg->grava($path.$img,100);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(960,'');
				$imgg->grava($path_m.$img,100);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(150,'');
				$imgg->grava($path_p.$img,100);

				atualizar(SLIDES,"imagem = '".$img."'","idslide = ".$ultimo);
				if(is_file($path_temp.$img)) unlink($path_temp.$img);
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'editar'){

		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-slides.php');
			echo '</div>';
		} else {
			
			$idioma = seguranca($_POST['idioma']);
			$titulo = seguranca($_POST['titulo']);
			$imagem = $_FILES['imagem'];
			$hidden = seguranca($_POST['hidden']);
			$url = seguranca($_POST['url']);
			$blank = seguranca($_POST['blank']);
			$ativo = seguranca($_POST['ativo']);
			$posicao = seguranca($_POST['posicao']);
			$blank = ($blank == 'S') ? 'S' : 'N';
			$ativo = ($ativo == 'S') ? 'S' : 'N';

			$dados = "idioma = '".$idioma."',titulo = '".$titulo."',url = '".$url."',blank = '".$blank."',ativo = '".$ativo."',posicao = '".$posicao."'";
			atualizar(SLIDES,$dados,"idslide = ".$id);

			if($imagem['name'] != ''){
				if(is_file($path_temp.$hidden)) unlink($path_temp.$hidden);
				if(is_file($path_m.$hidden)) unlink($path_m.$hidden);
				if(is_file($path_p.$hidden)) unlink($path_p.$hidden);
				if(is_file($path.$hidden)) unlink($path.$hidden);

				$extensao = getExtensao($imagem['name']);
				$img = $id.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($imagem['tmp_name'],$path_temp.$img);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(2000,450);
				$imgg->grava($path.$img,100);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(960,'');
				$imgg->grava($path_m.$img,100);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(150,'');
				$imgg->grava($path_p.$img,100);

				atualizar(SLIDES,"imagem = '".$img."'","idslide = ".$id);
				if(is_file($path_temp.$img)) unlink($path_temp.$img);
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'remover'){
		if(is_numeric($id)){
			$img = mysql_fetch_assoc(mysql_query("select * from ".SLIDES." where idslide = ".$id));

			if(is_file($path_temp.$img['imagem'])) unlink($path_temp.$img['imagem']);
			if(is_file($path_m.$img['imagem'])) unlink($path_m.$img['imagem']);
			if(is_file($path_p.$img['imagem'])) unlink($path_p.$img['imagem']);
			if(is_file($path.$img['imagem'])) unlink($path.$img['imagem']);

			deletar(SLIDES,"where idslide = ".$id);
		}
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
	}
	?>
</div>
<? include("include-rodape.php"); ?>