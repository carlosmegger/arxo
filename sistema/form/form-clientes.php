<?
if($acao == 'editar'){
	if(is_numeric($id)){
		$sql = selecionar("",CLIENTES,"where idcliente = ".$id);
		$rs = mysql_fetch_assoc($sql);

		$idcliente = $rs['idcliente'];
		$titulo = $rs['titulo'];
		$imagem = $rs['imagem'];
		$url = $rs['url'];
		$ativo = $rs['ativo'];
		$posicao = $rs['posicao'];
	}

} else {
	$url = 'http://';
	$ativo = 'S';
	$posicao = proxPosicao(CLIENTES,'asc');
}
?>
<form name="form-clientes" id="form-clientes" method="post" enctype="multipart/form-data" action="">
	<input type="hidden" name="posicao" value="<?=$posicao?>" />

	<span>
    	<label for="titulo">Título:*</label>
        <input type="text" name="titulo" id="titulo" value="<?=$titulo?>" maxlength="150" />
	</span>
	<span>
        <label for="imagem">Imagem:*</label>
        <input type="hidden" name="hidden" id="hidden" value="<?=$imagem?>" />
        <input type="file" name="imagem" id="imagem" size="40" />
		<? if($acao == 'editar' && $imagem != ''){ ?><a href="<?=$path.$imagem?>" class="fancybox"><img src="../img/sistema/ico-zoom.png" class="vimg" /> visualizar</a><? } ?>
		<div class="small">(Tamanho ideal: 320px de largura x 240px de altura)</div>
	</span>
	<span>
    	<label for="url">Link:</label>
        <input type="text" name="url" id="url" value="<?=$url?>" maxlength="150" />
	</span>
	<span><label for="ativo"><input type="checkbox" name="ativo" id="ativo" value="S" <? if($ativo == 'S') echo 'checked="checked"'; ?> />&nbsp;Ativo?</label></span>
	<br />

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
    <span class="retorno"></span>
</form>
