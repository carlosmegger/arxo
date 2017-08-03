<? include('topo.php'); ?>
<div class="breadcrumb">
	<div class="central">
		<a href="./">HOME</a> &raquo; <a href="<?=$_links['simposio']?>"><?=$_rotulos['simposio']?></a>
	</div>
</div>
<section class="conteudo">
	<div class="central">
		<!--h1>SIMPÓSIO</h1>
		<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.</p-->

		<h1><?=$simposio->titulo?></h1>
		<p><?=$simposio->descricao?></p>

		<h2>GALERIA DE FOTOS</h2>
		<div class="galeria">
			<div id="galeria">
				<div class="anterior"></div>
				<div class="proxima"></div>
				<div id="miniaturas">
				<?
				$galerias = SimposioGaleria::listar();
				$imagens = $galerias[0]->imagens();
				foreach ($imagens as $img){
					echo '<a class="fancybox" rel="galeria" title="',$img->legenda,'" href="img/simposio/galeria/',$img->imagem,'"><img src="img/simposio/galeria/p/',$img->imagem,'" alt="" title="',$img->legenda,'"></a>';
				}
				?>
				</div>
			</div>
		</div>
	</div>
</section>
<? include('rodape.php'); ?>