<? include('topo.php'); ?>
<div class="central">
	<div class="conteudo">
		<h1><?=$_rotulos['localizacao']?></h1>
        
        <div class="telefones">
		<? if ($idioma == 'br'){?>
		<p>Matriz Arxo <span><?=$_rotulos['fone_matriz']?></span></p>
        <p>Filial Arxo <span><?=$_rotulos['fone_filial']?></span></p>
        <? } else { ?>
		<p><?=$_rotulos['telefone_arxo']?> <span><?=$_rotulos['fone_matriz']?></span></p>
        <? } ?>
        </div>
        
		<div id="mapa"></div>
	</div>
</div>
<script src="scripts/mapa.js"></script>
<? include('rodape.php'); ?>