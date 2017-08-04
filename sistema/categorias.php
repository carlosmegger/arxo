<?
include("include-topo.php");

$path_temp = '../img/categorias/destaque/temp/';
$path_p = '../img/categorias/destaque/p/';
$path = '../img/categorias/destaque/';

switch($tipo){
	case 'P': $tit = ' &raquo; Produtos e Serviços'; break;
	case 'N': $tit = ' &raquo; Notícias'; break;
}
?>
<div id="conteudo">
	<div class="topo">
		<h1>Categorias<?=$tit?></h1>
		<div>
        <? if($acao == 'listar'){ ?>
			<a href="?acao=adicionar&tipo=<?=$tipo?>" class="adicionar">adicionar</a>
		<? } else { ?>
        	<a href="javascript:history.back()" class="voltar">&laquo; voltar</a>
		<? } ?>
		</div>
	</div>

	<? if($acao == ''){ ?>
    	
        <div class="categorias">
            <p>Selecione para qual seção deseja administrar categorias:</p>

			<a href="?acao=listar&tipo=P">
            	<span>Produtos e Serviços</span>
			</a>
			<a href="?acao=listar&tipo=N">
            	<span>Notícias</span>
			</a>
		</div>

	<?	
	}
	elseif($acao == 'listar'){

		$query = mysql_query("select * from ".CATEGORIAS." where tipo = '".$tipo."' order by posicao desc");

		if(mysql_num_rows($query) == 0){ ?>
			<p>N&atilde;o há itens cadastrados!</p>
		<? } else { ?>
        	<div class="listagem">
                <div class="cabecalho-<?=$tipo?>">
                    <span class="idioma">Idioma</span>
					<? if($tipo == 'P'){ ?><span class="preview">Preview</span><? } ?>
                    <span class="titulo">Título</span>
					<? if($tipo == 'P'){ ?><span class="galeria">Galeria</span><? } ?>
                    <span class="ativo">Ativo</span>
                    <span class="editar">Editar</span>
					<span class="remover">Remover</span>
                    <span class="posicao">Ordenar</span>
					<div class="clear"></div>
				</div>
                <div id="sortable">
                	<input type="hidden" name="tabela" id="tabela" value="<?=CATEGORIAS?>" />
                    <input type="hidden" name="campo" id="campo" value="idcategoria" />
                    <input type="hidden" name="tipo" id="tipo" value="<?=$tipo?>" />
                    <?
                    while($rs = mysql_fetch_assoc($query)){
                        $ativo = ($rs['ativo'] == 'S') ? 'ico-ativo-on.png' : 'ico-ativo-off.png';
						
						/* produtos e serviços */
						if($tipo == 'P'){
							$qtd_fotos = mysql_num_rows(mysql_query("select * from ".CATEGORIAS_IMGS." where idcategoria = '".$rs['idcategoria']."'"));
						}
					?>
                    <div class="caixa-categoria-<?=$tipo?> posiciona" data-id="<?=$rs['idcategoria']?>">
                        <span class="idioma"><img src="../img/sistema/<?=$rs['idioma']?>.png" /></span>
                        <? if($tipo == 'P'){ ?><span class="preview"><a href="<?=$path.$rs['imagem']?>" class="fancybox"><img src="<?=$path_p.$rs['imagem']?>" /></a></span><? } ?>
                        <span class="titulo"><?=$rs['titulo']?></span>
                        <? if($tipo == 'P'){ ?><span class="galeria"><a href="categorias-imgs.php?acao=listar&idcategoria=<?=$rs['idcategoria']?>&tipo=<?=$tipo?>"><img src="../img/sistema/ico-galeria.png" class="vimg" /> (<?=$qtd_fotos?>)</a></span><? } ?>
                        <span class="ativo"><img src="../img/sistema/<?=$ativo?>" longdesc="<?=CATEGORIAS?>-<?=$rs['idcategoria']?>-idcategoria" class="ativo cursor" /></span>
                        <span class="editar"><a href="?acao=editar&tipo=<?=$tipo?>&id=<?=$rs['idcategoria']?>"><img src="../img/sistema/ico-editar.png" alt="editar" border="0" /></a></span>
						<span class="remover"><a href="javascript:void(0)" onClick="removerCAT(<?=$rs['idcategoria']?>,'<?=$tipo?>')"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" /></a></span>
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
			include('form/form-categorias.php');
			echo '</div>';
		} else {
			
			$idioma = seguranca($_POST['idioma']);
			$tipo = seguranca($_POST['tipo']);
			$titulo = seguranca($_POST['titulo']);
			$slug = montaTag($titulo);
			$descricao = seguranca($_POST['descricao']);
			$imagem = $_FILES['imagem'];
			$hexadecimal = seguranca($_POST['hexadecimal']);
			$ativo = seguranca($_POST['ativo']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';
			$posicao = seguranca($_POST['posicao']);

			$campos = "idioma,tipo,titulo,slug,descricao,hexadecimal,ativo,posicao";
			$valores = "'".$idioma."','".$tipo."','".$titulo."','".$slug."','".$descricao."','".$hexadecimal."','".$ativo."','".$posicao."'";
			inserir(CATEGORIAS,$campos,$valores);
			$ultimo = ultimoID();
			
			if($imagem['name'] != ''){

				$extensao = getExtensao($imagem['name']);
				$img = $ultimo.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($imagem['tmp_name'],$path_temp.$img);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(306,160);
				$imgg->grava($path.$img,100);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(150,'');
				$imgg->grava($path_p.$img,100);

				atualizar(CATEGORIAS,"imagem = '".$img."'","idcategoria = ".$ultimo);
				if(is_file($path_temp.$img)) unlink($path_temp.$img);
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php?acao=listar&tipo=$tipo'>";
		}
	}
	elseif($acao == 'editar'){

		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-categorias.php');
			echo '</div>';
		} else {

			$idioma = seguranca($_POST['idioma']);
			$tipo = seguranca($_POST['tipo']);
			$titulo = seguranca($_POST['titulo']);
			$slug = montaTag($titulo);
			$descricao = seguranca($_POST['descricao']);
			$imagem = $_FILES['imagem'];
			$hidden = seguranca($_POST['hidden']);
			$hexadecimal = seguranca($_POST['hexadecimal']);
			$ativo = seguranca($_POST['ativo']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';
			$posicao = seguranca($_POST['posicao']);

			$dados = "idioma = '".$idioma."',tipo = '".$tipo."',titulo = '".$titulo."',slug = '".$slug."',descricao = '".$descricao."',hexadecimal = '".$hexadecimal."',ativo = '".$ativo."',posicao = '".$posicao."'";
			atualizar(CATEGORIAS,$dados,"idcategoria = ".$id);

			if($imagem['name'] != ''){
				if(is_file($path_temp.$hidden)) unlink($path_temp.$hidden);
				if(is_file($path_p.$hidden)) unlink($path_p.$hidden);
				if(is_file($path.$hidden)) unlink($path.$hidden);

				$extensao = getExtensao($imagem['name']);
				$img = $id.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($imagem['tmp_name'],$path_temp.$img);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(306,160);
				$imgg->grava($path.$img,100);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(150,'');
				$imgg->grava($path_p.$img,100);

				atualizar(CATEGORIAS,"imagem = '".$img."'","idcategoria = ".$id);
				if(is_file($path_temp.$img)) unlink($path_temp.$img);
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php?acao=listar&tipo=$tipo'>";
		}
	}
	elseif($acao == 'remover'){
		if(is_numeric($id)){

			if($tipo == 'P'){
				$img = mysql_fetch_assoc(mysql_query("select * from ".CATEGORIAS." where idcategoria = ".$id));
				if(is_file($path_temp.$img['imagem'])) unlink($path_temp.$img['imagem']);
				if(is_file($path_p.$img['imagem'])) unlink($path_p.$img['imagem']);
				if(is_file($path.$img['imagem'])) unlink($path.$img['imagem']);
			}

			deletar(CATEGORIAS,"where idcategoria = ".$id);
		}

		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php?acao=listar&tipo=$tipo'>";
	}
	?>
</div>
<? include("include-rodape.php"); ?>