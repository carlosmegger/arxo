<? include("include-topo.php") ?>
<div id="conteudo">
	<div class="topo">
		<h1>Configurações</h1>
		<div><a href="javascript:history.back()" class="voltar">&laquo; voltar</a></div>
	</div>

	<?
	if(!$_POST){
		echo '<div class="formulario">';
		include('form/form-configs.php');
		echo '</div>';
	} else {

		$valor1 = seguranca($_POST['valor1']);
		atualizar(CONFIGS,"valor = '".$valor1."'","diretiva = 'url_loja'");

		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php?atualizado=true'>";

	}
	?>

</div>
<? include("include-rodape.php") ?>