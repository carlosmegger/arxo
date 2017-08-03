<? include('topo.php'); ?>
<div class="central">
	<div class="conteudo">
		<h1>CLIENTES</h1>
		<ul id="lista_clientes">
		<?
		foreach ($clientes as $cliente){
			echo '<figure>';
			if (!!$cliente->url){
				echo '<a href="'.$cliente->url.'" target="_blank">';
			}
			echo '<img src="img/clientes/'.$cliente->imagem.'" alt="'.$cliente->titulo.'">';
			if (!!$cliente->url){
				echo '</a>';
			}
			echo '</figure>';
		}
		?>
		</ul>
		</div>
	</div>
</div>
<? include('rodape.php'); ?>