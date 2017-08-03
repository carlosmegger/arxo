<? include('topo.php'); ?>
<div class="breadcrumb">
	<div class="central">
		<a href="./">HOME</a> &raquo; <a href="<?=$_links['representantes']?>"><?=$_rotulos['representantes']?></a>
	</div>
</div>
<section class="conteudo central">
	<h1><?=$_rotulos['representantes']?></h1>

	<? if ($slug == ''){ ?>
        <section>
            <p><?=$_textos['localizacao']?></p>
        </section>
        <div id="container_mapa">
            <object id="mapa_america" type="image/svg+xml" data="img/america_do_sul.svg" width="100%" height="300"></object>
        </div>
		<script src="scripts/representantes.js"></script>
	<?
	} else {
		echo '<div class="coluna-representante">';
		if($representante->razao_social) echo '<p><strong>Razão Social:</strong> '.$representante->razao_social.'</p>';
		if($representante->contato) echo '<p><strong>Contato:</strong> '.$representante->contato.'</p>';
		if($representante->email) echo '<p><strong>E-mail:</strong> <a href="mailto:'.$representante->email.'">'.$representante->email.'</a></p>';
		if($representante->telefone) echo '<p><strong>Telefone:</strong> '.$representante->telefone.'</p>';
		if($representante->celular) echo '<p><strong>Celular:</strong> '.$representante->celular.'</p>';
		if($representante->area) echo '<p><strong>Área:</strong> '.$representante->area.'</p>';
		if($representante->endereco) echo '<p><strong>Endereço:</strong> '.$representante->endereco.'</p>';
		if($representante->pais) echo '<p><strong>País:</strong> '.$representante->pais.'</p>';
		if($representante->cidade) echo '<p><strong>Cidade:</strong> '.$representante->cidade.'</p>';
		if($representante->estado) echo '<p><strong>Estado:</strong> '.$representante->estado.'</p>';
		if($representante->cep) echo '<p><strong>CEP:</strong> '.$representante->cep.'</p>';
		echo '</div>';
		echo '<div class="coluna-representante">';
		if($representante->breve) echo '<p>'.$representante->breve.'</p>';
		echo '</div>';
		echo '<div class="clear"></div>';
		echo '<a href="'.$_links['representantes'].'" class="voltar">&laquo; '.$_rotulos['voltar'].'</a>';

	}
	?>

</section>
<? include('rodape.php'); ?>