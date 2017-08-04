<?
if($acao == 'editar'){
	if(is_numeric($id)){

		$sql = selecionar("",FAQ,"where id = '".$id."'");
		$rs = mysql_fetch_assoc($sql);

		$id = $rs['id'];
		$pergunta = $rs['pergunta'];
		$resposta = $rs['resposta'];
		$ordem = $rs['ordem'];
	}
}
?>
<form id="form-faq" method="post" action="">
	<input type="hidden" name="ordem" id="ordem" value="<?=$ordem?>" />
    <span>
    	<label for="pergunta">Pergunta:*</label>
		<input type="text" name="pergunta" id="pergunta" value="<?=$pergunta?>" maxlength="250" required />
	</span>
	<span>
		<label for="resposta">Resposta:*</label>
        <textarea name="resposta" id="resposta" class="ckeditor"><?=$resposta?></textarea>
	</span>
	<br />

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
	<span class="retorno"></span>
</form>