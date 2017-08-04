<?
if($acao == 'editar'){
	if(is_numeric($id)){
		$sql = selecionar("",LINHA_TEMPO,"where idlinhatempo = ".$id);
		$rs = mysql_fetch_assoc($sql);

		$idlinhatempo = $rs['idlinhatempo'];
		$idioma = $rs['idioma'];
		$ano = $rs['ano'];
		$imagem = $rs['imagem'];
		$texto = $rs['texto'];
		$ativo = $rs['ativo'];
	}

} else {
	$ativo = 'S';
}
?>
<form name="form-linha-tempo" id="form-linha-tempo" method="post" enctype="multipart/form-data" action="">
	<span>
		<label class="lado-lado"><input type="radio" name="idioma" value="br" <?=($idioma == 'br') ? 'checked="checked"' : '' ?> />&nbsp;Português</label>
		<label class="lado-lado"><input type="radio" name="idioma" value="en" <?=($idioma == 'en') ? 'checked="checked"' : '' ?> />&nbsp;Inglês</label>
		<label class="lado-lado"><input type="radio" name="idioma" value="es" <?=($idioma == 'es') ? 'checked="checked"' : '' ?> />&nbsp;Espanhol</label>
	</span>
	<span>
    	<label for="ano">Ano:*</label>
        <input type="text" name="ano" id="ano" value="<?=$ano?>" maxlength="4" />
	</span>
    <span>
		<label for="texto">Texto:*</label>
		<textarea name="texto" id="texto"><?=$texto?></textarea>
		<span class="quantidade"></span>
	</span>
    <span>
		<label for="imagem">Imagem:</label>
		<input type="hidden" name="hidden" id="hidden" value="<?=$imagem?>" />
		<input type="file" name="imagem" id="imagem" size="40" />
		<? if($acao == 'editar' && $imagem != ''){ ?>
        	<a href="<?=$path.$imagem?>" class="fancybox"><img src="../img/sistema/ico-zoom.png" class="vimg" /> visualizar</a>&nbsp;&nbsp;
			<a href="?acao=remover-img&id=<?=$id?>" class="remover"><img src="../img/sistema/ico-remover.gif" class="vimg" /> remover</a>
		<? } ?>
		<!--div class="small">(Tamanho ideal: 800px de largura x 600px de altura)</div-->
		<div class="small">(Tamanho ideal: 960px de largura máxima x 250px de altura)</div>
	</span>
	<span><label for="ativo"><input type="checkbox" name="ativo" id="ativo" value="S" <? if($ativo == 'S') echo 'checked="checked"'; ?> />&nbsp;Ativo?</label></span>

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
	<span class="retorno"></span>
</form>
