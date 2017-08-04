<? include("include-topo.php") ?>
<div id="conteudo">
	<div class="topo">
		<h1>Locais</h1>
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

		$query = mysql_query("select * from ".LOCAIS." order by posicao desc");

		if(mysql_num_rows($query) == 0){ ?>
			<p>N&atilde;o há itens cadastrados!</p>
		<? } else { ?>
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
                	<input type="hidden" name="tabela" id="tabela" value="<?=LOCAIS?>" />
                    <input type="hidden" name="campo" id="campo" value="idlocal" />
                    <?
                    while($rs = mysql_fetch_assoc($query)){
                        $ativo = ($rs['ativo'] == 'S') ? 'ico-ativo-on.png' : 'ico-ativo-off.png';
					?>
                    <div class="caixa-local posiciona" data-id="<?=$rs['idlocal']?>">
                        <span class="titulo"><?=$rs['titulo']?></span>
                        <span class="ativo"><img src="../img/sistema/<?=$ativo?>" longdesc="<?=LOCAIS?>-<?=$rs['idlocal']?>-idlocal" class="ativo cursor" /></span>
                        <span class="editar"><a href="?acao=editar&id=<?=$rs['idlocal']?>"><img src="../img/sistema/ico-editar.png" alt="editar" border="0" /></a></span>
						<span class="remover"><a href="javascript:void(0)" onClick="remover(<?=$rs['idlocal']?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" /></a></span>
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
			include('form/form-locais.php');
			echo '</div>';
		} else {
			
			$titulo = seguranca($_POST['titulo']);
			$endereco = seguranca($_POST['endereco']);
			$telefone = seguranca($_POST['telefone']);
			$ativo = seguranca($_POST['ativo']);
			$posicao = seguranca($_POST['posicao']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';

			$campos = "titulo,endereco,telefone,ativo,posicao";
			$valores = "'".$titulo."','".$endereco."','".$telefone."','".$ativo."','".$posicao."'";
			inserir(LOCAIS,$campos,$valores);

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'editar'){

		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-locais.php');
			echo '</div>';
		} else {
			
			$titulo = seguranca($_POST['titulo']);
			$endereco = seguranca($_POST['endereco']);
			$telefone = seguranca($_POST['telefone']);
			$ativo = seguranca($_POST['ativo']);
			$posicao = seguranca($_POST['posicao']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';

			$dados = "titulo = '".$titulo."',endereco = '".$endereco."',telefone = '".$telefone."',ativo = '".$ativo."',posicao = '".$posicao."'";
			atualizar(LOCAIS,$dados,"idlocal = ".$id);

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'remover'){
		if(is_numeric($id)) deletar(LOCAIS,"where idlocal = ".$id);
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
	}
	?>
</div>
<? include("include-rodape.php"); ?>