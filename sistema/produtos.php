<?
include("include-topo.php");

$path_temp = '../img/produtos/temp/';
$path_p = '../img/produtos/p/';
$path = '../img/produtos/';

$path_tit = '../img/produtos/titulo/';
$path_banner = '../img/produtos/banner/';
?>
<div id="conteudo">
	<div class="topo">
		<h1>Produtos e Serviços</h1>
		<div>
        <? if($acao == ''){ ?>
			<a href="?acao=adicionar" class="adicionar">adicionar</a>
		<? } else { ?>
        	<a href="javascript:history.back()" class="voltar">&laquo; voltar</a>
		<? } ?>
		</div>
	</div>

	<? if($acao == ''){ ?>
		<div class="filtro">
        
        	<span>Idioma:</span>
            <span>
				<select name="idioma" id="idioma">
					<option value="0">Selecione</option>
					<option value="br"<?=($idioma == 'br') ? ' selected="selected"' : '' ?>>Português</option>
					<option value="en"<?=($idioma == 'en') ? ' selected="selected"' : '' ?>>Inglês</option>
					<option value="es"<?=($idioma == 'es') ? ' selected="selected"' : '' ?>>Espanhol</option>
                </select>
            </span>
        
        	<span>Categoria:</span>
            <span>
            	<select name="idcategoria" id="idcategoria">
                	<option value="0">Selecione</option>
                    <?
                    $sql = mysql_query("select * from ".CATEGORIAS." where tipo = 'P' order by titulo asc");
					while($rs = mysql_fetch_assoc($sql)){
						$sel = ($rs['idcategoria'] == $idcategoria) ? ' selected="selected"' : '';						
						echo '<option value="'.$rs['idcategoria'].'"'.$sel.'>'.$rs['titulo'].'</option>';
					}
					?>
                </select>
            </span>
        
			<span>Busca por texto:</span>
			<span>
            	<input type="text" name="busca" id="busca" class="produto" value="<?=$busca?>" />
			</span>
            <span>
                <input type="submit" name="filtro-produtos" id="filtro-produtos" value="OK" />
                <? if($filtro == true){ ?><a href="<?=$page?>.php"><img src="../img/sistema/ico-cancelar.png" alt="limpar filtro" class="vimg" /></a><? } ?>
			</span>
		</div>

    	<?
		if($filtro == true){
			$w = " where ";
			if($idioma != ''){
				$cond .= $w." idioma = '".$idioma."' ";
				$w = " and ";
			}
			if($idcategoria != ''){
				$cond .= $w." idcategoria = '".$idcategoria."' ";
				$w = " and ";
			}
			if($busca != ''){
				$cond .= $w." (titulo_completo like '%".$busca."%' or titulo like '%".$busca."%' or subtitulo like '%".$busca."%' or descricao like '%".$busca."%') ";
			}
		}

		#$query = mysql_query("select * from ".PRODUTOS." order by posicao desc");
		$paginacao = new Paginacao(PRODUTOS," ".$cond." order by posicao desc","",$pagina,100);
		$query = mysql_query("select * from ".PRODUTOS." ".$cond." order by posicao desc limit ".$paginacao->getInicio().",100");

		if(mysql_num_rows($query) == 0){ ?>
			<p>N&atilde;o há itens cadastrados!</p>
		<? } else { ?>
        	<div class="listagem">
                <div class="cabecalho">
                    <span class="idioma">Idioma</span>
                    <span class="preview">Preview</span>
                    <span class="titulo">Título</span>
					<span class="galeria">Galeria</span>
					<span class="downloads">Downloads</span>
                    <span class="ativo">Ativo</span>
                    <span class="editar">Editar</span>
					<span class="remover">Remover</span>
                    <span class="posicao">Ordenar</span>
					<div class="clear"></div>
				</div>
                <div id="sortable">
                	<input type="hidden" name="tabela" id="tabela" value="<?=PRODUTOS?>" />
                    <input type="hidden" name="campo" id="campo" value="idproduto" />
                    <?
                    while($rs = mysql_fetch_assoc($query)){
                        $ativo = ($rs['ativo'] == 'S') ? 'ico-ativo-on.png' : 'ico-ativo-off.png';
						$qtd_fotos = mysql_num_rows(mysql_query("select * from ".PRODUTOS_IMGS." where idproduto = '".$rs['idproduto']."'"));
						$qtd_arqs = mysql_num_rows(mysql_query("select * from ".PRODUTOS_ARQS." where idproduto = '".$rs['idproduto']."'"));
					?>
                    <div class="caixa-produto posiciona" data-id="<?=$rs['idproduto']?>">
                        <span class="idioma"><img src="../img/sistema/<?=$rs['idioma']?>.png" border="0" /></span>
                        <span class="preview"><a href="<?=$path.$rs['imagem']?>" class="fancybox"><img src="<?=$path_p.$rs['imagem']?>" title="<?=$rs['titulo_completo']?>" border="0" /></a></span>
                        <span class="titulo"><?=$rs['titulo_completo']?></span>
						<span class="galeria"><a href="produtos-imgs.php?acao=listar&idproduto=<?=$rs['idproduto']?>"><img src="../img/sistema/ico-galeria.png" class="vimg" /> (<?=$qtd_fotos?>)</a></span>
                        <span class="downloads"><a href="produtos-arqs.php?acao=listar&idproduto=<?=$rs['idproduto']?>"><img src="../img/sistema/ico-texto.png" class="vimg" /> (<?=$qtd_arqs?>)</a></span>
                        <span class="ativo"><img src="../img/sistema/<?=$ativo?>" longdesc="<?=PRODUTOS?>-<?=$rs['idproduto']?>-idproduto" class="ativo cursor" /></span>
                        <span class="editar"><a href="?acao=editar&id=<?=$rs['idproduto']?>"><img src="../img/sistema/ico-editar.png" alt="editar" border="0" /></a></span>
						<span class="remover"><a href="javascript:void(0)" onClick="remover(<?=$rs['idproduto']?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" /></a></span>
						<span class="posicao"></span>
					</div>
					<? } ?>
				</div>
			</div>
			<?
			if($paginacao->temPaginacao()){
				echo '<div class="paginacao">';
				echo $paginacao->getPaginacao($page.'.php');
				echo '</div>';
			}
		}
	}
	elseif($acao == 'adicionar'){
		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-produtos.php');
			echo '</div>';
		} else {

			$idioma = seguranca($_POST['idioma']);
			$idcategoria = seguranca($_POST['idcategoria']);
			$titulo_completo = seguranca($_POST['titulo_completo']);
			$slug = montaTag($titulo_completo);
			$titulo = seguranca($_POST['titulo']);
			$subtitulo = seguranca($_POST['subtitulo']);
			$descricao = seguranca($_POST['descricao']);
			$imagem = $_FILES['imagem'];
			$imagem_tit = $_FILES['imagem_tit'];
			$imagem_banner = $_FILES['imagem_banner'];
			$ativo = seguranca($_POST['ativo']);
			$posicao = seguranca($_POST['posicao']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';
			
			$meta_titulo = seguranca($_POST['meta_titulo']);
			$meta_descricao = seguranca($_POST['meta_descricao']);

			$campos = "idioma,idcategoria,titulo_completo,slug,titulo,subtitulo,descricao,ativo,posicao,meta_titulo,meta_descricao";
			$valores = "'".$idioma."','".$idcategoria."','".$titulo_completo."','".$slug."','".$titulo."','".$subtitulo."','".$descricao."','".$ativo."','".$posicao."','".$meta_titulo."','".$meta_descricao."'";
			inserir(PRODUTOS,$campos,$valores);
			$ultimo = ultimoID();

			if($imagem['name'] != ''){
				$extensao = getExtensao($imagem['name']);
				$img = $ultimo.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($imagem['tmp_name'],$path_temp.$img);

				$imgg = new canvas($path_temp.$img);
				$imgg->hexa('#fff');
				$imgg->redimensiona(294,180,'preenchimento');
				$imgg->grava($path.$img,100);

				$imgg = new canvas($path_temp.$img);
				$imgg->hexa('#fff');
				$imgg->redimensiona(150,'','preenchimento');
				$imgg->grava($path_p.$img,100);

				atualizar(PRODUTOS,"imagem = '".$img."'","idproduto = ".$ultimo);
				if(is_file($path_temp.$img)) unlink($path_temp.$img);
			}
			if($imagem_tit['name'] != ''){
				$extensao = getExtensao($imagem_tit['name']);
				$img = $ultimo.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($imagem_tit['tmp_name'],$path_tit.$img);

				$imgg = new canvas($path_tit.$img);
				$imgg->hexa('#fff');
				$imgg->redimensiona(485,277,'preenchimento');
				$imgg->grava($imagem_tit.$img,100);

				atualizar(PRODUTOS,"imagem_tit = '".$img."'","idproduto = ".$ultimo);
			}
			if($imagem_banner['name'] != ''){
				$extensao = getExtensao($imagem_banner['name']);
				$img = $ultimo.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($imagem_banner['tmp_name'],$path_banner.$img);

				$imgg = new canvas($path_banner.$img);
				$imgg->hexa('#fff');
				$imgg->redimensiona(960,'','preenchimento');
				$imgg->grava($path_banner.$img,100);

				atualizar(PRODUTOS,"imagem_banner = '".$img."'","idproduto = ".$ultimo);
			}

			#relacionados
			$produto_rel = $_POST['produto_rel'];
			if(count($produto_rel) > 0){
				foreach($produto_rel as $produto){
					$campos = "idproduto,idrelacionado";
					$valores = "'".$ultimo."','".$produto."'";
					inserir(PRODUTOS_REL,$campos,$valores);
				}
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'editar'){
		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-produtos.php');
			echo '</div>';
		} else {

			$idioma = seguranca($_POST['idioma']);
			$idcategoria = seguranca($_POST['idcategoria']);
			$titulo_completo = seguranca($_POST['titulo_completo']);
			$slug = montaTag($titulo_completo);
			$titulo = seguranca($_POST['titulo']);
			$subtitulo = seguranca($_POST['subtitulo']);			
			$descricao = seguranca($_POST['descricao']);
			$imagem = $_FILES['imagem'];
			$imagem_tit = $_FILES['imagem_tit'];
			$imagem_banner = $_FILES['imagem_banner'];
			$hidden = seguranca($_POST['hidden']);
			$hidden_tit = seguranca($_POST['hidden_tit']);
			$hidden_banner = seguranca($_POST['hidden_banner']);
			$ativo = seguranca($_POST['ativo']);
			$posicao = seguranca($_POST['posicao']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';
			
			$meta_titulo = seguranca($_POST['meta_titulo']);
			$meta_descricao = seguranca($_POST['meta_descricao']);

			$dados = "idioma = '".$idioma."',idcategoria = '".$idcategoria."',titulo_completo = '".$titulo_completo."',slug = '".$slug."',titulo = '".$titulo."',subtitulo = '".$subtitulo."',descricao = '".$descricao."',ativo = '".$ativo."',posicao = '".$posicao."',meta_titulo = '".$meta_titulo."',meta_descricao = '".$meta_descricao."'";
			atualizar(PRODUTOS,$dados,"idproduto = ".$id);
			
			if($imagem['name'] != ''){
				if(is_file($path_temp.$hidden)) unlink($path_temp.$hidden);
				if(is_file($path_p.$hidden)) unlink($path_p.$hidden);
				if(is_file($path.$hidden)) unlink($path.$hidden);

				$extensao = getExtensao($imagem['name']);
				$img = $id.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($imagem['tmp_name'],$path_temp.$img);

				$imgg = new canvas($path_temp.$img);
				$imgg->hexa('#fff');
				$imgg->redimensiona(294,180,'preenchimento');
				$imgg->grava($path.$img,100);

				$imgg = new canvas($path_temp.$img);
				$imgg->hexa('#fff');
				$imgg->redimensiona(150,'','preenchimento');
				$imgg->grava($path_p.$img,100);

				atualizar(PRODUTOS,"imagem = '".$img."'","idproduto = ".$id);
				if(is_file($path_temp.$img)) unlink($path_temp.$img);
			}
			if($imagem_tit['name'] != ''){
				if(is_file($path_tit.$hidden_tit)) unlink($path_tit.$hidden_tit);

				$extensao = getExtensao($imagem_tit['name']);
				$img = $id.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($imagem_tit['tmp_name'],$path_tit.$img);

				$imgg = new canvas($path_tit.$img);
				$imgg->hexa('#fff');
				$imgg->redimensiona(485,277,'preenchimento');
				$imgg->grava($path_tit.$img,100);

				atualizar(PRODUTOS,"imagem_tit = '".$img."'","idproduto = ".$id);
			}
			if($imagem_banner['name'] != ''){
				if(is_file($path_banner.$hidden_banner)) unlink($path_banner.$hidden_banner);

				$extensao = getExtensao($imagem_banner['name']);
				$img = $id.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($imagem_banner['tmp_name'],$path_banner.$img);

				$imgg = new canvas($path_banner.$img);
				$imgg->hexa('#fff');
				$imgg->redimensiona(960,'','preenchimento');
				$imgg->grava($path_banner.$img,100);

				atualizar(PRODUTOS,"imagem_banner = '".$img."'","idproduto = ".$id);
			}

			#relacionados
			deletar(PRODUTOS_REL,"where idproduto = '".$id."'"); //remove anteriores para re-inserir

			$produto_rel = $_POST['produto_rel'];
			if(count($produto_rel) > 0){
				foreach($produto_rel as $produto){
					$campos = "idproduto,idrelacionado";
					$valores = "'".$id."','".$produto."'";
					inserir(PRODUTOS_REL,$campos,$valores);
				}
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'remover'){
		if(is_numeric($id)){
			$img = mysql_fetch_assoc(mysql_query("select * from ".PRODUTOS." where idproduto = ".$id));

			if(is_file($path_temp.$img['imagem'])) unlink($path_temp.$img['imagem']);
			if(is_file($path_p.$img['imagem'])) unlink($path_p.$img['imagem']);
			if(is_file($path.$img['imagem'])) unlink($path.$img['imagem']);

			deletar(PRODUTOS,"where idproduto = ".$id);
		}
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
	}
	?>
</div>
<? include("include-rodape.php"); ?>