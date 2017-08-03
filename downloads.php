<? include('topo.php') ?>

	<div class="breadcrumb">
		<div class="central">
			<a href="./">HOME</a> &raquo; <a href="<?=$_links['portal do cliente']?>"><?=$_rotulos['portal do cliente']?></a> &raquo; <?=$categoria->titulo?>
        </div>
	</div>

	<div class="central">
        <div class="conteudo">
            <h1><?=$categoria->titulo?></h1>
			<div class="portais-lista">
            	<?
				foreach($arquivos as $arquivo){
					echo '<a href="arquivos/portal/'.$arquivo->arquivo.'" class="link-download" target="_blank">'.$arquivo->titulo.'</a>';
				}
				?>
            </div>
        </div>
    </div>

<? include('rodape.php') ?>