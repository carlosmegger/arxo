<?
include("include-topo.php");
require_once("../class/portal.php");
$pathImg = '../img/portais/';
$pathDL = '../arquivos/portal/';
?>
<div id="conteudo">
	<div class="topo">
		<h1>Portal do Cliente - Arquivos para Download</h1>
		<div>
		<? if (!$acao){
			echo '<a href="?acao=adicionar" class="adicionar">adicionar</a>';
		} else {
			echo '<a href="javascript:history.back()" class="voltar">&laquo; voltar</a>';
		} ?>
		</div>
	</div>
	<?
	if (!$acao){
		$categorias = Portais::categorias();

		if (empty($categorias)){
			echo '<p class="vazio">Não há itens cadastrados!</p>';
		} else {
			foreach ($categorias as $categoria){
				$arquivos = $categoria->arquivos();
				echo '<h2>',$categoria->titulo,'</h2>';
				if (empty($arquivos)){
					echo '<p class="vazio">Não há arquivos nesta categoria!</p>';
				} else {?>
					<div class="listagem">
						<div class="cabecalho">
							<span class="titulo">Título</span>
							<span class="ativo">Ativo</span>
							<span class="editar">Editar</span>
							<span class="remover">Remover</span>
							<span class="posicao">Ordenar</span>
							<div class="clear"></div>
						</div>
						<div id="sortable">
							<input type="hidden" name="tabela" id="tabela" value="<?=DOWNLOADS?>" />
							<input type="hidden" name="campo" id="campo" value="id" />

							<?
							foreach ($arquivos as $arq){
								$id = $arq->id;
								$ativo = ($arq->ativo == 'S') ? 'ico-ativo-on.png' : 'ico-ativo-off.png';
								?>
								<div class="caixa-portal posiciona" data-id="<?=$id?>">
									<span class="titulo"><?=$arq->titulo?></span>
									<span class="ativo"><img src="../img/sistema/<?=$ativo?>" longdesc="<?=DOWNLOADS?>-<?=$id?>-id" class="ativo cursor" /></span>
									<span class="editar"><a href="?acao=editar&amp;id=<?=$id?>"><img src="../img/sistema/ico-editar.png" alt="editar" border="0" /></a></span>
									<span class="remover"><a href="javascript:void(0)" onClick="remover(<?=$id?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" /></a></span>
									<span class="posicao"></span>
								</div>
							<? } ?>
						</div>
					</div>
					<?
				}
			}
		}
	} elseif ($acao == 'adicionar'){

		if (!$_POST){
			echo '<div class="formulario">';
			include('form/form-portal-download.php');
			echo '</div>';
		} else {
			$idCat = seguranca($_POST['idCat']);
			$titulo = seguranca($_POST['titulo']);
			$arquivo = $_FILES['arquivo'];
			$ativo = seguranca($_POST['ativo']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';
			$posicao = seguranca($_POST['posicao']);

			$campos = "idCat,titulo,ativo,posicao";
			$valores = "'".$idCat."','".$titulo."','".$ativo."','".$posicao."'";
			inserir(DOWNLOADS,$campos,$valores);
			$ultimo = ultimoID();

			if ($arquivo['name'] != ''){
				$file = $ultimo.'-'.corrigeNome($arquivo['name']);
				move_uploaded_file($arquivo['tmp_name'],$pathDL.$file);

				atualizar(DOWNLOADS,"arquivo = '".$file."'","id = ".$ultimo);
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	} elseif ($acao == 'editar'){

		if (!$_POST){
			echo '<div class="formulario">';
			include('form/form-portal-download.php');
			echo '</div>';
		} else {
			$idCat = seguranca($_POST['idCat']);
			$titulo = seguranca($_POST['titulo']);
			$arquivo = $_FILES['arquivo'];
			$ativo = seguranca($_POST['ativo']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';
			$posicao = seguranca($_POST['posicao']);

			$antigo = $_FILES['antigo'];
			$hidden = seguranca($_POST['hidden']);

			$dados = "idCat = '".$idCat."'titulo = '".$titulo."',url = '".$url."',ativo = '".$ativo."',posicao = '".$posicao."'";
			atualizar(DOWNLOADS,$dados,"id = ".$id);

			if ($arquivo['name'] != ''){
				if (is_file($pathDL.$antigo)) unlink($pathDL.$antigo);
				$file = $id.'-'.corrigeNome($arquivo['name']);
				move_uploaded_file($arquivo['tmp_name'],$pathDL.$file);

				atualizar(DOWNLOADS,"arquivo = '".$file."'","id = ".$id);
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	} elseif ($acao == 'remover'){
		if (is_numeric($id)){
			$img = mysql_fetch_assoc(mysql_query("select * from ".DOWNLOADS." where id = ".$id));
			if (is_file($pathDL.$img['arquivo'])) unlink($pathDL.$img['arquivo']);

			deletar(DOWNLOADS,"where id = ".$id);
		}

		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
	}
	?>
</div>
<? include("include-rodape.php"); ?>