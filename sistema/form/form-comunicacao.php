<?
if($acao == 'editar'){
	if(is_numeric($id)){

		$sql = selecionar("",COMUNICACAO,"where idioma = '".$idioma."'");
		$rs = mysql_fetch_assoc($sql);

		$idioma = $rs['idioma'];
		$titulo = $rs['titulo'];
		$descricao = $rs['descricao'];
		$imagem = $rs['imagem'];
	}

} else {
	$ativo = 'S';
}
?>
<form name="form-comunicacao" id="form-comunicacao" method="post" enctype="multipart/form-data" action="">
	<input type="hidden" name="idioma" id="idioma" value="<?=$idioma?>" />
	
    <span>
    	<label for="titulo">Título:*</label>
		<input type="text" name="titulo" id="titulo" value="<?=$titulo?>" maxlength="250" />
	</span>
	<span>
		<label for="descricao">Descrição:*</label>
        <textarea name="descricao" id="descricao" class="ckeditor"><?=$descricao?></textarea>
	</span>
	<br />

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
	<span class="retorno"></span>
</form>
