<div class="navbar" role="navigation">
	<div class="container">
        <div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="http://grupoclint.com.br/links-patrocinados/"><img src="../../images/logo.png" class="navbar-brand" width="262" height="68"></a>
        </div>
        <div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li><a href="#" class="icone-ligamos text-uppercase" data-toggle="modal" data-target="#ligamos-para-voce">Ligamos para você</a></li>
				<li><a href="#" class="icone-atendimento text-uppercase">Atendimento online</a></li>
				<li><a href="#" class="icone-envie-email text-uppercase" data-toggle="modal" data-target="#envie-um-email">Envie um email</a></li>
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
		<div class="row text-center">
			<div class="title-wrap">
				<h2 class="text-uppercase"><span class="arvo text-<?php echo $cor; ?>">Obrigado!</span></h2>
			</div>
			<div class="col-md-8 col-md-offset-2 text-center">
				<p>Um dos nossos consultores de marketing digital entrará em contato para que possamos dar início imediato aos trabalhos para o seu negócio.</p>
			</div>
		</div>
	</div>
</div><!-- /.container -->

<!-- Google Code for LP AdWords Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 969838446;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "ypIZCPT57lYQ7p66zgM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/969838446/?label=ypIZCPT57lYQ7p66zgM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<?php include_once('../../inc/rodape.php'); ?>