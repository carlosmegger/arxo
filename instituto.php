<? include('topo.php'); ?>
<div class="breadcrumb">
	<div class="central">
		<a href="./">HOME</a> &raquo; COMUNICADO</a>
	</div>
</div>
<section class="conteudo">
	<div class="central">

		<h1><?=$instituto->titulo?></h1>
		<?=$instituto->descricao?>

	</div>

			<div class="instituto-galeria">
        	<?
            foreach($imagens as $img){
				#echo $img->imagem;
				
				echo '<figure>';
				echo '<a href="img/instituto/galeria/'.$img->imagem.'" class="fancybox" rel="galeria">';
				echo '<img src="img/instituto/galeria/p/'.$img->imagem.'" alt="Instituto Arxo" />';
				echo '</a>';
				echo '</figure>';
			}
			?>
		</div>
</section>
<? include('rodape.php'); ?>