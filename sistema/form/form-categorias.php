<?
if($acao == 'editar'){
	if(is_numeric($id)){
		$sql = selecionar("",CATEGORIAS,"where idcategoria = ".$id);
		$rs = mysql_fetch_assoc($sql);

		$idcategoria = $rs['idcategoria'];
		$idioma = $rs['idioma'];
		$tipo = $rs['tipo'];
		$titulo = $rs['titulo'];
		$slug = $rs['slug'];
		$descricao = $rs['descricao'];
		$imagem = $rs['imagem'];
		$hexadecimal = $rs['hexadecimal'];
		$ativo = $rs['ativo'];
		$posicao = $rs['posicao'];
	}

} else {
	$ativo = 'S';
	$posicao = proxPosicao(CATEGORIAS,"asc","tipo = '".$tipo."'");
}
?>
<form name="form-categorias" id="form-categorias" method="post" enctype="multipart/form-data" action="">
	<input type="hidden" name="tipo" id="tipo" value="<?=$tipo?>" />
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
    
    <? if($tipo == 'P'){ ?>
    <span>
		<label for="descricao">Descrição:*</label>
        <textarea name="descricao" id="descricao" class="ckeditor"><?=$descricao?></textarea>
    </span>
	<span>
        <label for="imagem">Imagem:*</label>
        <input type="hidden" name="hidden" id="hidden" value="<?=$imagem?>" />
        <input type="file" name="imagem" id="imagem" size="40" />
		<? if($acao == 'editar' && $imagem != ''){ ?><a href="<?=$path.$imagem?>" class="fancybox"><img src="../img/sistema/ico-zoom.png" class="vimg" /> visualizar</a><? } ?>
		<div class="small">(Tamanho ideal: 960px de largura x 400px de altura)</div>
	</span>
	<span>
		<label for="hexadecimal">Hexadecimal:*</label>
		<input type="text" name="hexadecimal" id="hexadecimal" value="<?=$hexadecimal?>" maxlength="150" />
		<span class="hexadecimal" style="background:<?=$hexadecimal?>"></span>
	</span>
	<? } ?>

	<span><label for="ativo"><input type="checkbox" name="ativo" id="ativo" value="S" <? if($ativo == 'S') echo 'checked="checked"'; ?> />&nbsp;Ativo?</label></span>
	<br />

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
   	<span class="retorno"></span>
</form>
