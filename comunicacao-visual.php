<? include('topo.php'); ?>
<div class="breadcrumb">
	<div class="central">
		<a href="./">HOME</a> &raquo; COMUNICAÇÃO VISUAL</a>
	</div>
</div>
<section class="conteudo">
	<div class="central">

		<!--h1><?=$comunicacao->titulo?></h1-->
		<?=$comunicacao->descricao?>

	</div>


<div class="instituto-galeria">
        	<?
            foreach($imagens as $img){
				#echo $img->imagem;
				
				echo '<figure>';
				echo '<a href="img/comunicacao/galeria/'.$img->imagem.'" class="fancybox" rel="galeria">';
				echo '<img src="img/comunicacao/galeria/p/'.$img->imagem.'" alt="Comunicação Visual Arxo" />';
				echo '</a>';
				echo '</figure>';
			}
			?>
		</div>

</section>
<? include('rodape.php'); ?>