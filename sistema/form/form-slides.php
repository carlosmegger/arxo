<?
if($acao == 'editar'){
	if(is_numeric($id)){
		$sql = selecionar("",SLIDES,"where idslide = ".$id);
		$rs = mysql_fetch_assoc($sql);

		$idslide = $rs['idslide'];
		$idioma = $rs['idioma'];
		$titulo = $rs['titulo'];
		$imagem = $rs['imagem'];
		$url = $rs['url'];
		$blank = $rs['blank'];
		$ativo = $rs['ativo'];
		$posicao = $rs['posicao'];
	}

} else {
	$url = 'http://';
	$ativo = 'S';
	$posicao = proxPosicao(SLIDES,'asc');
}
?>
<form name="form-slides" id="form-slides" method="post" enctype="multipart/form-data" action="">
	<input type="hidden" name="posicao" value="<?=$posicao?>" />

	<span>
		<label class="lado-lado"><input type="radio" name="idioma" value="br" <?=($idioma == 'br') ? 'checked="checked"' : '' ?> />Português</label>
		<label class="lado-lado"><input type="radio" name="idioma" value="en" <?=($idioma == 'en') ? 'checked="checked"' : '' ?> />Inglês</label>
		<label class="lado-lado"><input type="radio" name="idioma" value="es" <?=($idioma == 'es') ? 'checked="checked"' : '' ?> />Espanhol</label>
    </span>
	<span>
    	<label for="titulo">Título:*</label>
        <input type="text" name="titulo" id="titulo" value="<?=$titulo?>" maxlength="150" />
	</span>
	<span>
        <label for="imagem">Imagem:*</label>
        <input type="hidden" name="hidden" id="hidden" value="<?=$imagem?>" />
        <input type="file" name="imagem" id="imagem" size="40" />
		<? if($acao == 'editar' && $imagem != ''){ ?><a href="<?=$path.$imagem?>" class="fancybox"><img src="../img/sistema/ico-zoom.png" class="vimg" /> visualizar</a><? } ?>
		<div class="small">(Tamanho ideal: 2000px de largura x 450px de altura)</div>
	</span>
	<span>
    	<label for="url">Link:</label>
        <input type="text" name="url" id="url" value="<?=$url?>" maxlength="150" />
	</span>
	<span><label for="blank"><input type="checkbox" name="blank" id="blank" value="S" <? if($blank == 'S') echo 'checked="checked"'; ?> />&nbsp;Link abre em nova janela?</label></span>
	<span><label for="ativo"><input type="checkbox" name="ativo" id="ativo" value="S" <? if($ativo == 'S') echo 'checked="checked"'; ?> />&nbsp;Ativo?</label></span>
	<br />

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
    <span class="retorno"></span>
</form>
