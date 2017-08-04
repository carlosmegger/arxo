<?
if ($acao == 'editar'){
	if (is_numeric($id)){
		$sql = selecionar("",DOWNLOADS,'where id = '.$id);
		$rs = mysql_fetch_assoc($sql);

		$id = $rs['id'];
		$idCat = $rs['idCat'];
		$titulo = $rs['titulo'];
		$arquivo = $rs['arquivo'];
		$ativo = $rs['ativo'];
		$posicao = $rs['posicao'];
	}

} else {
	$ativo = 'S';
	$posicao = proxPosicao(DOWNLOADS,'asc');
	$arquivo = '';
}
?>
<form id="form-download" method="post" enctype="multipart/form-data" action="">
	<input type="hidden" name="posicao" value="<?=$posicao?>" />
	<span>
		<label for="idCat">Categoria:*</label>
		<select name="idCat" id="idCat" required>
			<option value="">Selecionar</option>
			<?
			$categorias = Portais::categorias();
			foreach ($categorias as $c){
				echo '<option value="'.$c->idportal.'" '.($c->idportal == $idCat?'selected':'').'>'.$c->titulo.'</option>';
			}
			?>
		</select>
	</span>
	<span>
		<label for="titulo">Título:*</label>
		<input type="text" name="titulo" id="titulo" value="<?=$titulo?>" maxlength="150" size="50" required />
	</span>
	<span>
		<label for="arquivo">Arquivo:*</label>
		<input type="file" name="arquivo" id="arquivo" value="" />
		<input type="hidden" name="antigo" id="antigo" value="<?=$arquivo?>" />
	</span>
	<span><label for="ativo"><input type="checkbox" name="ativo" id="ativo" value="S" <?=($ativo == 'S')?'checked':''?> /> Ativo?</label></span>
	<br />

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
	<span class="retorno"></span>
</form>
<script>
$('#form-download').on('submit',function(){

	var valor1 = $('#arquivo');
	var valor2 = $('#antigo');

	if (!valor1.val() && !valor2.val()){
		retorno.html('Selecione um arquivo!');
		valor1.addClass('erro').focus();
		return false;
	} else {
		valor1.removeClass('erro');
	}

	return true;
});
</script>
