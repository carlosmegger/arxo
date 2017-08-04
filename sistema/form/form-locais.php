<?
if($acao == 'editar'){
	if(is_numeric($id)){
		$sql = selecionar("",LOCAIS,"where idlocal = ".$id);
		$rs = mysql_fetch_assoc($sql);

		$idlocal = $rs['idlocal'];
		$titulo = $rs['titulo'];
		$endereco = $rs['endereco'];
		$telefone = $rs['telefone'];
		$ativo = $rs['ativo'];
		$posicao = $rs['posicao'];
	}

} else {
	$ativo = 'S';
	$posicao = proxPosicao(LOCAIS,'asc');
}
?>
<form name="form-locais" id="form-locais" method="post" enctype="multipart/form-data" action="">
	<input type="hidden" name="posicao" value="<?=$posicao?>" />

	<span>
    	<label for="titulo">Título:*</label>
        <input type="text" name="titulo" id="titulo" value="<?=$titulo?>" maxlength="250" />
	</span>
	<span>
    	<label for="endereco">Endereço:*</label>
        <textarea name="endereco" id="endereco"><?=$endereco?></textarea>
	</span>
	<span>
    	<label for="telefone">Telefone:*</label>
        <input type="text" name="telefone" id="telefone" value="<?=$telefone?>" maxlenght="50" />
	</span>
	<span><label for="ativo"><input type="checkbox" name="ativo" id="ativo" value="S" <? if($ativo == 'S') echo 'checked="checked"'; ?> />&nbsp;Ativo?</label></span>
	<br />

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
    <span class="retorno"></span>
</form>
