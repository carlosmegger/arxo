<? include("include-topo.php") ?>
<div id="conteudo">
	<div class="topo">
		<h1>Certificações</h1>
        <div><a href="javascript:history.back()" class="voltar">&laquo; voltar</a></div>
	</div>

	<?
	if(!$_POST){
		echo '<div class="formulario">';
		include('form/form-certificacoes.php');
		echo '</div>';
	} else {

		$descricaoBR = seguranca($_POST['descricaoBR']);
		$descricaoEN = seguranca($_POST['descricaoEN']);
		$descricaoES = seguranca($_POST['descricaoES']);

		$dados = "descricaoBR = '".$descricaoBR."',descricaoEN = '".$descricaoEN."',descricaoES = '".$descricaoES."'";
		atualizar(CERTIFICACOES,$dados,"1 = 1");

		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php?atualizado=true'>";

	}
	?>
</div>
<? include("include-rodape.php"); ?>