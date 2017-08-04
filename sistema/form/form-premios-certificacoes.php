<?
if($acao == 'editar'){
	if(is_numeric($id)){
		$sql = selecionar("",PREMIOS_CERT,"where idcertificacao = ".$id);
		$rs = mysql_fetch_assoc($sql);

		$idcertificacao = $rs['idcertificacao'];
		$idioma = $rs['idioma'];
		$titulo = $rs['titulo'];
		$ativo = $rs['ativo'];
		$posicao = $rs['posicao'];
	}

} else {
	$ativo = 'S';
	$posicao = proxPosicao(PREMIOS_CERT,'asc');
}
?>
<form name="form-premios-certificacoes" id="form-premios-certificacoes" method="post" enctype="multipart/form-data" action="">
	<input type="hidden" name="posicao" value="<?=$posicao?>" />

	<span>
    	<label class="lado-lado"><input type="radio" name="idioma" value="br" <?=($idioma == 'br') ? 'checked="checked"' : '' ?> />Português</label>
		<label class="lado-lado"><input type="radio" name="idioma" value="en" <?=($idioma == 'en') ? 'checked="checked"' : '' ?> />Inglês</label>
		<label class="lado-lado"><input type="radio" name="idioma" value="es" <?=($idioma == 'es') ? 'checked="checked"' : '' ?> />Espanhol</label>
	</span>
	<span>
		<label for="titulo">Título:*</label>
		<input type="text" name="titulo" id="titulo" value="<?=$titulo?>" maxlenght="150" />
	</span>
	<span><label for="ativo"><input type="checkbox" name="ativo" id="ativo" value="S" <? if($ativo == 'S') echo 'checked="checked"'; ?> />&nbsp;Ativo?</label></span>
	<br />

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
    <span class="retorno"></span>
</form>
