<? include('topo.php') ?>

	<div id="banner">
		<?php
		foreach ($slides as $slide){
			$slide->html();
		}
		?>
		<div id="banner-nav"></div>
	</div>

	<section id="chamadas" class="central">
		<?
		foreach ($chamadas as $chamada){
			echo '<a href="',$chamada->url,'" ',($chamada->blank=="S"?'target="_blank"':''),'>';
			echo '<figure><img src="img/chamadas/',$chamada->imagem,'" alt="" /></figure>';
			echo '<h2>',$chamada->titulo,'</h2>';
			echo '<p>',$chamada->breve,'</p>';
			echo '</a>';
		}?>
	</section>

	<section id="postagens">
		<div class="central">
			<h1>Blog Arxo</h1>

			<div class="lista">
				<p>Carregando...</p>
				<!--
				<div>
					<figure><a href="#" target="_blank"><img src="http://placekitten.com/272/180" alt="Lorem Ipsum" /></a></figure>
					<div>
						<h2><a href="#" target="_blank">Lorem Ipsum Dolor Sit Amet</a></h2>
						<p><a href="#" target="_blank">Natus cubilia ex, augue dolores risus incididunt faucibus donec eligendi, perferendis amet? Mi. Ut venenatis non adipisci conubia? Harum, enim erat tellus dicta saepe? Nibh nihil dis fugit tempor. Fuga cum recusandae egestas dolores nascetur et, autem aliquid ligula dapibus officiis dapibus sociosqu, excepteur. Fames! Magnis porttitor auctor doloribus nisi.</a></p>
						<a href="#" target="_blank" class="continue-lendo">Continue Lendo &rarr;</a>
					</div>
				</div>
				<div>
					<figure><a href="#" target="_blank"><img src="http://placekitten.com/272/180" alt="Lorem Ipsum" /></a></figure>
					<div>
						<h2><a href="#" target="_blank">Lorem Ipsum Dolor Sit Amet</a></h2>
						<p><a href="#" target="_blank">Natus cubilia ex, augue dolores risus incididunt faucibus donec eligendi, perferendis amet? Mi. Ut venenatis non adipisci conubia? Harum, enim erat tellus dicta saepe? Nibh nihil dis fugit tempor. Fuga cum recusandae egestas dolores nascetur et, autem aliquid ligula dapibus officiis dapibus sociosqu, excepteur. Fames! Magnis porttitor auctor doloribus nisi.</a></p>
						<a href="#" target="_blank" class="continue-lendo">Continue Lendo &rarr;</a>
					</div>
				</div>
				-->
			</div>

			<a href="<?=$http?>blog/" target="_blank" class="mais-novidades">&raquo; Mais novidades no blog. Acesse.</a>
		</div>
	</section>

	<section id="descricao-home">
		<div class="central">
			<strong><?=$_rotulos['home qualidade 1']?></strong>
			<span class="colunas">
				<span><?=$_textos['home qualidade 1']?></span>
				<!--span><?=$_textos['home qualidade 2']?></span-->
			</span>
			<strong><?=$_rotulos['home qualidade 2']?></strong>
			<p><?=$_textos['home qualidade 3']?></p>
		</div>
	</section>

	<section id="novidades-home" class="central">
		<!--h1>Parceiros</h1-->
        <table width="600" border="0" cellspacing="10" cellpadding="10" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img src="img/abieps.png" width="281" height="105"></td>
    <td><img src="img/pei-member.png" width="200" height="74"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
      </table>

	</section>

<? include('rodape.php'); ?>
