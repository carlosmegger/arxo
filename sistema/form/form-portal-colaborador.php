<?
if($acao == 'editar'){
	if(is_numeric($id)){
		$sql = selecionar("",PORTAIS,"where idportal = ".$id);
		$rs = mysql_fetch_assoc($sql);

		$idportal = $rs['idportal'];
		$idioma = $rs['idioma'];
		$tipo = $rs['tipo'];
		$titulo = $rs['titulo'];
		$icone = $rs['icone'];
		$url = $rs['url'];
		$ativo = $rs['ativo'];
		$posicao = $rs['posicao'];
	}

} else {
	$url = 'http://';
	$ativo = 'S';
	$posicao = proxPosicao(PORTAIS,'asc');
}
?>
<form name="form-portais" id="form-portais" method="post" enctype="multipart/form-data" action="">
	<input type="hidden" name="posicao" value="<?=$posicao?>" />
	<input type="hidden" name="tipo" value="CO" />

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
        <label for="icone">Ícone:*</label>
        <input type="hidden" name="hidden" id="hidden" value="<?=$icone?>" />
        <input type="file" name="icone" id="icone" size="40" />
		<? if($acao == 'editar' && $imagem != ''){ ?><a href="<?=$path.$icone?>" class="fancybox"><img src="../img/sistema/ico-zoom.png" class="vimg" /> visualizar</a><? } ?>
		<div class="small">(Tamanho ideal: 180px de largura x 180px de altura)</div>
	</span>
	<span>
		<label for="url">Link:*</label>
		<input type="text" name="url" id="url" value="<?=$url?>" maxlength="150" />
	</span>
	<span><label for="ativo"><input type="checkbox" name="ativo" id="ativo" value="S" <? if($ativo == 'S') echo 'checked="checked"'; ?> />&nbsp;Ativo?</label></span>
	<br />

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
    <span class="retorno"></span>
</form>
