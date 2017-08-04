<?
include("include-topo.php");
$path = '../img/portais/';
?>
<div id="conteudo">
	<div class="topo">
		<h1>Portal do Colaborador</h1>
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

		$query = mysql_query("select * from ".PORTAIS." where tipo = 'CO' order by posicao desc");

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
                	<input type="hidden" name="tabela" id="tabela" value="<?=PORTAIS?>" />
                    <input type="hidden" name="campo" id="campo" value="idportal" />
                    <input type="hidden" name="tipo" id="tipo" value="CO" />

                    <?
                    while($rs = mysql_fetch_assoc($query)){
                        $ativo = ($rs['ativo'] == 'S') ? 'ico-ativo-on.png' : 'ico-ativo-off.png';
					?>
                    <div class="caixa-portal posiciona" data-id="<?=$rs['idportal']?>">
                        <span class="preview"><img src="<?=$path.$rs['icone']?>" alt="<?=$rs['titulo']?>" /></span>
                        <span class="titulo"><?=$rs['titulo']?></span>
                        <span class="ativo"><img src="../img/sistema/<?=$ativo?>" longdesc="<?=PORTAIS?>-<?=$rs['idportal']?>-idportal" class="ativo cursor" /></span>
                        <span class="editar"><a href="?acao=editar&id=<?=$rs['idportal']?>"><img src="../img/sistema/ico-editar.png" alt="editar" border="0" /></a></span>
						<span class="remover"><a href="javascript:void(0)" onClick="remover(<?=$rs['idportal']?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" /></a></span>
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
			include('form/form-portal-colaborador.php');
			echo '</div>';
		} else {

			$idioma = seguranca($_POST['idioma']);
			$tipo = seguranca($_POST['tipo']);
			$titulo = seguranca($_POST['titulo']);
			$icone = $_FILES['icone'];
			$url = seguranca($_POST['url']);
			$ativo = seguranca($_POST['ativo']);
			$posicao = seguranca($_POST['posicao']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';

			$campos = "idioma,tipo,titulo,url,ativo,posicao";
			$valores = "'".$idioma."','".$tipo."','".$titulo."','".$url."','".$ativo."','".$posicao."'";
			inserir(PORTAIS,$campos,$valores);
			$ultimo = ultimoID();
			
			if($icone['name'] != ''){
				$img = $ultimo.'-'.corrigeNome($icone['name']);
				move_uploaded_file($icone['tmp_name'],$path.$img);

				$imgg = new canvas($path.$img);
				$imgg->hexa('#fff');
				$imgg->redimensiona(180,180,'preenchimento');
				$imgg->grava($path.$img,100);

				atualizar(PORTAIS,"icone = '".$img."'","idportal = ".$ultimo);
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'editar'){

		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-portal-colaborador.php');
			echo '</div>';
		} else {
			
			$idioma = seguranca($_POST['idioma']);
			$tipo = seguranca($_POST['tipo']);
			$titulo = seguranca($_POST['titulo']);
			$icone = $_FILES['icone'];
			$hidden = seguranca($_POST['hidden']);
			$url = seguranca($_POST['url']);
			$ativo = seguranca($_POST['ativo']);
			$posicao = seguranca($_POST['posicao']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';

			$dados = "idioma = '".$idioma."',tipo = '".$tipo."',titulo = '".$titulo."',url = '".$url."',ativo = '".$ativo."',posicao = '".$posicao."'";
			atualizar(PORTAIS,$dados,"idportal = ".$id);
			
			if($icone['name'] != ''){
				if(is_file($path.$hidden)) unlink($path.$hidden);

				$img = $id.'-'.corrigeNome($icone['name']);
				move_uploaded_file($icone['tmp_name'],$path.$img);

				$imgg = new canvas($path.$img);
				$imgg->hexa('#fff');
				$imgg->redimensiona(180,180,'preenchimento');
				$imgg->grava($path.$img,100);

				atualizar(PORTAIS,"icone = '".$img."'","idportal = ".$id);
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'remover'){
		if(is_numeric($id)){
			$img = mysql_fetch_assoc(mysql_query("select * from ".PORTAIS." where idportal = ".$id));
			if(is_file($path.$img['icone'])) unlink($path.$img['icone']);

			deletar(PORTAIS,"where idportal = ".$id);
		}

		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
	}
	?>
</div>
<? include("include-rodape.php"); ?>