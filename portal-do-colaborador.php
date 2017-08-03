<? include('topo.php') ?>

	<div class="breadcrumb">
        <div class="central">
            <a href="./">HOME</a> &raquo; <a href="<?=$_links['portal do colaborador']?>"><?=$_rotulos['portal do colaborador']?></a>
		</div>
	</div>

	<div class="central">
		<div class="conteudo">
        	<h1><?=$_rotulos['portal do colaborador']?></h1>
            <div class="portais-lista">
            	<?
				foreach($portais as $portal){
					echo '<a href="'.$portal->url.'" target="_blank">';
					echo '<figure><img src="img/portais/'.$portal->icone.'" alt="'.$portal->titulo.'" /></figure>';
					echo '<span>'.$portal->titulo.'</span>';
					echo '</a>';
				}
				?>
			</div>
		</div>
	</div>

<? include('rodape.php') ?>