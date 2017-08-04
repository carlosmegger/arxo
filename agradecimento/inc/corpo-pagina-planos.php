<div class="navbar" role="navigation">
	<div class="container">
        <div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="http://grupoclint.com.br/links-patrocinados/"><img src="../images/logo.png" class="navbar-brand" width="262" height="68"></a>
        </div>
        <div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li><a href="#" class="icone-ligamos text-uppercase" data-toggle="modal" data-target="#ligamos-para-voce">Ligamos para você</a></li>
				<li><a href="#" class="icone-atendimento text-uppercase">Atendimento online</a></li>
				<li><a href="#" class="icone-envie-email text-uppercase" data-toggle="modal" data-target="#envie-um-email">Envie um email</a></li>
				<li class="has-btn"><span><button class="btn btn-default text-uppercase btn-lg scroll-to-planos" role="button">+ Planos</button></span></li>
			</ul>
        </div><!--/.nav-collapse -->
	</div>
</div>

<div id="ligamos-para-voce" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ligamosParaVoceModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="ligamosParaVoceModalLabel">Ligamos para você</h4>
			</div>
			<div class="modal-body">
				<?php include_once('ligamos-para-voce-form.php'); ?>
			</div>
		</div>
	</div>
</div>
<div id="envie-um-email" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="envieUmEmailModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="envieUmEmailModalLabel">Envie um email</h4>
			</div>
			<div class="modal-body">
				<?php include_once('envie-um-email-form.php'); ?>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div id="contrato">
		<div class="row">
			<?php include_once('../inc/titulo-descricao-plano.php'); ?>

			<?php include_once('../inc/contrato-form.php'); ?>

			<div id="contrato-dialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="envieUmEmailModal" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="contratoModalLabel">Contrato</h4>
						</div>
						<div class="modal-body text-justify">
							<?php include_once('../inc/contrato.php'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="nossos-planos">
		<div class="row">
			<div class="title-wrap text-center">
				<h2 class="text-uppercase"><span class="arvo">Nossos</span> planos</h2>
			</div>
			<?php include_once('../inc/tabela-de-planos.php'); ?>
		</div>
	</div>
</div><!-- /.container -->

<?php include_once('../inc/rodape.php'); ?>