<?
include("include-topo.php");

$path_temp = '../img/certificacoes/temp/';
$path = '../img/certificacoes/';
?>
<div id="conteudo">
	<div class="topo">
		<h1>Prêmios e Certificações</h1>
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

		$query = mysql_query("select * from ".PREMIOS_CERT." order by posicao desc");

		if(mysql_num_rows($query) == 0){ ?>
			<p>N&atilde;o há itens cadastrados!</p>
		<? } else { ?>
        	<div class="listagem">
                <div class="cabecalho">
					<span class="idioma">Idioma</span>
                    <span class="titulo">Título</span>
                    <span class="ativo">Ativo</span>
                    <span class="editar">Editar</span>
					<span class="remover">Remover</span>
                    <span class="posicao">Ordenar</span>
					<div class="clear"></div>
				</div>
                <div id="sortable">
                	<input type="hidden" name="tabela" id="tabela" value="<?=PREMIOS_CERT?>" />
                    <input type="hidden" name="campo" id="campo" value="idcertificacao" />
                    <?
                    while($rs = mysql_fetch_assoc($query)){
                        $ativo = ($rs['ativo'] == 'S') ? 'ico-ativo-on.png' : 'ico-ativo-off.png';
					?>
                    <div class="caixa-premios-certificado posiciona" data-id="<?=$rs['idcertificacao']?>">
						<span class="idioma"><img src="../img/sistema/<?=$rs['idioma']?>.png" /></span>
                        <span class="titulo"><?=$rs['titulo']?></span>
                        <span class="ativo"><img src="../img/sistema/<?=$ativo?>" longdesc="<?=PREMIOS_CERT?>-<?=$rs['idcertificacao']?>-idcertificacao" class="ativo cursor" /></span>
                        <span class="editar"><a href="?acao=editar&id=<?=$rs['idcertificacao']?>"><img src="../img/sistema/ico-editar.png" alt="editar" border="0" /></a></span>
						<span class="remover"><a href="javascript:void(0)" onClick="remover(<?=$rs['idcertificacao']?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" /></a></span>
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
			include('form/form-premios-certificacoes.php');
			echo '</div>';
		} else {
			
			$idioma = seguranca($_POST['idioma']);
			$titulo = seguranca($_POST['titulo']);
			$ativo = seguranca($_POST['ativo']);
			$posicao = seguranca($_POST['posicao']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';

			$campos = "idioma,titulo,ativo,posicao";
			$valores = "'".$idioma."','".$titulo."','".$ativo."','".$posicao."'";
			inserir(PREMIOS_CERT,$campos,$valores);

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'editar'){

		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-premios-certificacoes.php');
			echo '</div>';
		} else {
			
			$idioma = seguranca($_POST['idioma']);
			$titulo = seguranca($_POST['titulo']);
			$ativo = seguranca($_POST['ativo']);
			$posicao = seguranca($_POST['posicao']);
			$ativo = ($ativo == 'S') ? 'S' : 'N';

			$dados = "idioma = '".$idioma."',titulo = '".$titulo."',ativo = '".$ativo."',posicao = '".$posicao."'";
			atualizar(PREMIOS_CERT,$dados,"idcertificacao = ".$id);
			
			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'remover'){
		if(is_numeric($id)) deletar(PREMIOS_CERT,"where idcertificacao = ".$id);
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
	}
	?>
</div>
<? include("include-rodape.php"); ?>