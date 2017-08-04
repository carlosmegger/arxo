<?
if($acao == 'editar'){
	if(is_numeric($id)){
		$sql = selecionar("",REVISTAS,"where idrevista = ".$id);
		$rs = mysql_fetch_assoc($sql);

		$idrevista = $rs['idrevista'];
		$idioma = $rs['idioma'];
		$titulo = $rs['titulo'];
		$slug = $rs['slug'];
		$breve = $rs['breve'];
		$imagem = $rs['imagem'];
		$arquivo = $rs['arquivo'];
		$ativo = $rs['ativo'];
		$posicao = $rs['posicao'];
	}

} else {
	$ativo = 'S';
	$posicao = proxPosicao(REVISTAS,'asc');
}
?>
<form name="form-revistas" id="form-revistas" method="post" enctype="multipart/form-data" action="">
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
    	<label for="breve">Breve:</label>
		<textarea name="breve" id="breve"><?=$breve?></textarea>
	</span>
	<span>
		<label for="imagem">Imagem:*</label>
		<input type="hidden" name="hidden" id="hidden" value="<?=$imagem?>" />
        <input type="file" name="imagem" id="imagem" size="40" />
		<? if($acao == 'editar' && $imagem != ''){ ?><a href="<?=$path.$imagem?>" class="fancybox"><img src="../img/sistema/ico-zoom.png" class="vimg" /> visualizar</a><? } ?>
		<!--div class="small">(Tamanho ideal: 600px de largura x 800px de altura)</div-->
		<div class="small">(Tamanho ideal: 1500px de largura x 2000px de altura)</div>
	</span>
    <span>
		<label for="arquivo">Arquivo - PDF para download:</label>
		<input type="hidden" name="hidden_arq" id="hidden_arq" value="<?=$arquivo?>" />
		<input type="file" name="arquivo" id="arquivo" size="40" />
		<? if($acao == 'editar' && $arquivo != ''){ ?><a href="<?=$path_arq.$arquivo?>" target="_blank"><img src="../img/sistema/ico-zoom.png" class="vimg" /> visualizar</a><? } ?>
	</span>

	<span><label for="ativo"><input type="checkbox" name="ativo" id="ativo" value="S" <? if($ativo == 'S') echo 'checked="checked"'; ?> />&nbsp;Ativo?</label></span>
	<br />

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
    <span class="retorno"></span>
</form>
