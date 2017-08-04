<? include("include-topo.php") ?>
<div id="conteudo">
	<div class="topo">
		<h1>Simpósio Galerias</h1>
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

		$query = mysql_query("select * from ".SIMPOSIO_GALERIAS." order by posicao desc");

		if(mysql_num_rows($query) == 0){ ?>
			<p>N&atilde;o há itens cadastrados!</p>
		<? } else { ?>
        	<div class="listagem">
                <div class="cabecalho">
                    <span class="titulo">Título</span>
                    <span class="galeria">Galeria</span>
                    <span class="ativo">Ativo</span>
                    <span class="editar">Editar</span>
					<span class="remover">Remover</span>
                    <span class="posicao">Ordenar</span>
					<div class="clear"></div>
				</div>
                <div id="sortable">
                	<input type="hidden" name="tabela" id="tabela" value="<?=SIMPOSIO_GALERIAS?>" />
                    <input type="hidden" name="campo" id="campo" value="idgaleria" />
                    <?
                    while($rs = mysql_fetch_assoc($query)){
                        $ativo = ($rs['ativo'] == 'S') ? 'ico-ativo-on.png' : 'ico-ativo-off.png';
						$qtd_fotos = mysql_num_rows(mysql_query("select * from ".SIMPOSIO_IMGS." where idgaleria = '".$rs['idgaleria']."'"));
					?>
                    <div class="caixa-simp-galeria posiciona" data-id="<?=$rs['idgaleria']?>">
						<span class="titulo"><?=$rs['titulo']?></span>
						<span class="galeria"><a href="simposio-imgs.php?acao=listar&idgaleria=<?=$rs['idgaleria']?>"><img src="../img/sistema/ico-galeria.png" class="vimg" /> (<?=$qtd_fotos?>)</a></span>
                        <span class="ativo"><img src="../img/sistema/<?=$ativo?>" longdesc="<?=SIMPOSIO_GALERIAS?>-<?=$rs['idgaleria']?>-idgaleria" class="ativo cursor" /></span>
                        <span class="editar"><a href="?acao=editar&id=<?=$rs['idgaleria']?>"><img src="../img/sistema/ico-editar.png" alt="editar" border="0" /></a></span>
						<span class="remover"><a href="javascript:void(0)" onClick="remover(<?=$rs['idgaleria']?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" /></a></span>
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
			include('form/form-simposio-galerias.php');
			echo '</div>';
		} else {

			$titulo = seguranca($_POST['titulo']);
			$slug = montaTag($titulo);
			$ativo = seguranca($_POST['ativo']);
			$posicao = seguranca($_POST['posicao']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';

			$campos = "titulo,slug,ativo,posicao";
			$valores = "'".$titulo."','".$slug."','".$ativo."','".$posicao."'";
			inserir(SIMPOSIO_GALERIAS,$campos,$valores);

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'editar'){

		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-simposio-galerias.php');
			echo '</div>';
		} else {

			$titulo = seguranca($_POST['titulo']);
			$slug = montaTag($titulo);
			$ativo = seguranca($_POST['ativo']);
			$posicao = seguranca($_POST['posicao']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';

			$dados = "titulo = '".$titulo."',slug = '".$slug."',ativo = '".$ativo."',posicao = '".$posicao."'";
			atualizar(SIMPOSIO_GALERIAS,$dados,"idgaleria = ".$id);

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'remover'){
		if(is_numeric($id)) deletar(SIMPOSIO_GALERIAS,"where idgaleria = ".$id);
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
	}
	?>
</div>
<? include("include-rodape.php") ?>
