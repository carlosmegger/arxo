<?
if($acao == 'editar'){
	if(is_numeric($id)){
		$sql = selecionar("",SIMPOSIO_GALERIAS,"where idgaleria = ".$id);
		$rs = mysql_fetch_assoc($sql);

		$idgaleria = $rs['idgaleria'];
		$titulo = $rs['titulo'];
		$slug = $rs['slug'];
		$ativo = $rs['ativo'];
		$posicao = $rs['posicao'];
	}

} else {
	$ativo = 'S';
	$posicao = proxPosicao(SIMPOSIO_GALERIAS,'asc');
}
?>
<form name="form-simposio-galerias" id="form-simposio-galerias" method="post" enctype="multipart/form-data" action="">
	<input type="hidden" name="posicao" value="<?=$posicao?>" />

	<span>
    	<label for="titulo">Título:*</label>
        <input type="text" name="titulo" id="titulo" value="<?=$titulo?>" maxlength="250" />
	</span>
	<span><label for="ativo"><input type="checkbox" name="ativo" id="ativo" value="S" <? if($ativo == 'S') echo 'checked="checked"'; ?> />&nbsp;Ativo?</label></span>
	<br />

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
    <span class="retorno"></span>
</form>
