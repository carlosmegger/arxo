<? include('topo.php'); ?>
<div class="breadcrumb">
	<div class="central">
		<a href="./">HOME</a> &raquo; OPÇÕES DE FINANCIAMENTO</a>
	</div>
</div>
<section class="conteudo">
	<div class="central">
	<h1>OPÇÕES DE FINANCIAMENTO</h1>
	<?=$financiamento->descricao?></div>
	<br>
	<div class="central">
		<h2>Perguntas Frequentes</h2>
		<div id="lista-faq">
			<? foreach ($perguntas as $p){
				echo '<div class="questao">';
				echo '	<div class="pergunta">',$p->pergunta,'</div>';
				echo '	<div class="resposta">',$p->resposta,'</div>';
				echo '</div>';
			} ?>
		</div>
	</div>
</section>
<? include('rodape.php'); ?>