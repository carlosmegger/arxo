</main>
<footer>
	<span id="rodape">
		<span class="central">
			<span class="coluna">
				<span class="titulo"><?=$_rotulos['quem somos']?></span>
				<a href="<?=$_links['institucional']?>"><?=$_rotulos['institucional']?></a>
				<a href="<?=$_links['ideologia']?>"><?=$_rotulos['ideologia']?></a>
				<? if ($veryx->exibir == 'S'){ ?>
				<a href="<?=$_links['veryx']?>"><?=$_rotulos['veryx']?></a>
				<? } ?>
				<a href="<?=$_links['premios e certificacoes']?>"><?=$_rotulos['premios e certificacoes']?></a>
				<a href="<?=$_links['clientes']?>"><?=$_rotulos['clientes']?></a>
			</span>
			<span class="coluna">
				<span class="titulo"><?=$_rotulos['produtos']?></span>
				<?php foreach($categorias as $cat){ ?>
                <a href="<?=($idioma!='br'?$idioma.'/':'').$cat->slug?>/"><?=$cat->titulo?></a>
                <?php } ?>
			</span>
			<span class="coluna">
				<span class="titulo"><?=$_rotulos['novidades']?></span>
				<? if ($idioma == 'br'){?>
				<a href="<?=$_links['novidades']?>"><?=$_rotulos['noticias']?></a>
				<? } ?>
				<a href="<?=$_links['blog']?>" target="_blank"><?=$_rotulos['blog']?></a>
			</span>
			<span class="coluna">
				<span class="titulo"><?=$_rotulos['contato']?></span>
				<a href="<?=$_links['fale conosco']?>"><?=$_rotulos['fale conosco']?></a>
				<? if ($idioma == 'br'){?>
				<a href="<?=$_links['trabalhe conosco']?>"><?=$_rotulos['trabalhe conosco']?></a>
				<? } ?>
				<a href="<?=$_links['representantes']?>"><?=$_rotulos['representantes']?></a>
				<a href="<?=$_links['localizacao']?>"><?=$_rotulos['localizacao']?></a>
			</span>
			<a id="rodape-logo" href="./"><img src="img/<?=$idioma?>-logo-rodape.png" alt="ARXO"></a>
		</span>
	</span>
	<span id="copyright">
		<span class="central">
			<span>&copy; <?=date('Y')?> - ARXO | <?=$_textos['copyright']?>.</span>
			<span class="espacamento"></span>
			<span class="midias">
				<a href="https://www.facebook.com/arxo.brasil" target="_blank" class="facebook"></a>
				<a href="https://br.linkedin.com/company/arxo-sidera-o" target="_blank" class="linkedin"></a>
				<a href="https://www.youtube.com/user/arxodobrasil" target="_blank" class="youtube"></a>
			</span>
		</span>
	</span>
</footer>
<script type="text/javascript" async src="https://d335luupugsy2.cloudfront.net/js/loader-scripts/af1e66bb-e4c5-4251-94eb-06cce2fb76f3-loader.js" ></script>
</body>
</html>