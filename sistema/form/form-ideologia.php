<?
if($acao == 'editar'){
	if(is_numeric($id)){
		$sql = selecionar("",IDEOLOGIA,"where idioma = '".$idioma."'");
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
<form name="form-ideologia" id="form-ideologia" method="post" enctype="multipart/form-data" action="">
	<input type="hidden" name="idioma" id="idioma" value="<?=$idioma?>" />
	
    <span>
    	<label for="titulo">Título:*</label>
		<input type="text" name="titulo" id="titulo" value="<?=$titulo?>" maxlength="250" />
	</span>
	<span>
		<label for="descricao">Descrição:*</label>
        <textarea name="descricao" id="descricao" class="ckeditor"><?=$descricao?></textarea>
	</span>
    
    <!--
	<span>
        <label for="imagem">Imagem:</label>
        <input type="hidden" name="hidden" id="hidden" value="<?=$imagem?>" />
        <input type="file" name="imagem" id="imagem" size="40" />
		<? if($acao == 'editar' && $imagem != ''){ ?>
        	<a href="<?=$path.$imagem?>" class="fancybox"><img src="../img/sistema/ico-zoom.png" class="vimg" /> visualizar</a>&nbsp;&nbsp;
        	<a href="?acao=remover-img&idioma=<?=$idioma?>" class="remover"><img src="../img/sistema/ico-remover.gif" class="vimg" /> remover</a>
		<? } ?>
		<div class="small">(Tamanho ideal: 320px de largura x 240px de altura)</div>
	</span>
	-->
	<br />

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
	<span class="retorno"></span>
</form>
