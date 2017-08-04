<?
if($acao == 'editar'){
	if(is_numeric($id)){
		$sql = selecionar("",NOTICIAS,"where idnoticia = ".$id);
		$rs = mysql_fetch_assoc($sql);

		$idnoticia = $rs['idnoticia'];
		$idioma = $rs['idioma'];
		$idcategoria = $rs['idcategoria'];
		$titulo = $rs['titulo'];
		$slug = $rs['slug'];
		$breve = $rs['breve'];
		$descricao = $rs['descricao'];
		$imagem = $rs['imagem'];
		$ativo = $rs['ativo'];
		$data = converteData($rs['data'],'d/m/Y');
		
		$meta_titulo = $rs['meta_titulo'];
		$meta_descricao = $rs['meta_descricao'];
	}

} else {
	$ativo = 'S';
	$data = date('d/m/Y');
	$posicao = proxPosicao(PRODUTOS,'asc');
}
?>
<script>
$(function(){

	$('input[name=idioma]').click(function(){
		categorias($(this).val(),'');
	});

	<? if($acao == 'editar'){ ?>
	categorias('<?=$idioma?>','<?=$idcategoria?>');
	<? } ?>

});
function categorias(idioma,selected){
	var seletor = $('#idcategoria'),
		url = 'ajax.php?acao=categorias&idioma='+ idioma +'&tipo=N&selected='+ selected;

	$.ajax({ url:url, type:'GET', cache:false, success:function(response){
		if(response != '') seletor.html(response);
	}});
}
</script>
<form name="form-noticias" id="form-noticias" method="post" enctype="multipart/form-data" action="">
	<input type="hidden" name="posicao" value="<?=$posicao?>" />

	<span>
        <label class="lado-lado"><input type="radio" name="idioma" value="br" <?=($idioma == 'br') ? 'checked="checked"' : '' ?> />Português</label>
        <label class="lado-lado"><input type="radio" name="idioma" value="en" <?=($idioma == 'en') ? 'checked="checked"' : '' ?> />Inglês</label>
        <label class="lado-lado"><input type="radio" name="idioma" value="es" <?=($idioma == 'es') ? 'checked="checked"' : '' ?> />Espanhol</label>
    </span>
    <span>
		<label for="idcategoria">Categoria:*</label>
		<select name="idcategoria" id="idcategoria">
        	<option value="0">Selecione</option>
		</select>
    </span>
	<span>
    	<label for="titulo">Título:*</label>
        <input type="text" name="titulo" id="titulo" value="<?=$titulo?>" maxlength="150" />
	</span>
    
	<span>
    	<label for="meta_titulo">Título utilizado no Google <a href="../img/sistema/resultado-google.gif" class="fancybox"><img src="../img/sistema/ico-help.gif" class="vimg" alt="Google" /></a>:</label>
		<input type="text" name="meta_titulo" id="meta_titulo" value="<?=$meta_titulo?>" />
        <div class="contador-tit">Qtd. de caractere(s) disponível(is): <span></span></div>
    </span>
    
	<span>
		<label for="breve">Breve:*</label>
        <textarea name="breve" id="breve"><?=$breve?></textarea>
	</span>

    <span>
        <label for="meta_descricao">Descrição que aparecerá no Google <a href="../img/sistema/resultado-google.gif" class="fancybox"><img src="../img/sistema/ico-help.gif" class="vimg" alt="Google" /></a>:</label>
        <textarea name="meta_descricao" id="meta_descricao"><?=$meta_descricao?></textarea>
        <div clas="contador-desc">Qtd. de caractere(s) disponível(is): <span></span></div>
	</span>

	<span>
		<label for="descricao">Descrição:*</label>
		<textarea name="descricao" id="descricao" class="ckeditor"><?=$descricao?></textarea>
	</span>
    
	<span>
        <label for="imagem">Imagem:</label>
        <input type="hidden" name="hidden" id="hidden" value="<?=$imagem?>" />
        <input type="file" name="imagem" id="imagem" size="40" />
		<? if($acao == 'editar' && $imagem != ''){ ?>
			<a href="<?=$path.$imagem?>" class="fancybox"><img src="../img/sistema/ico-zoom.png" class="vimg" /> visualizar</a>&nbsp;&nbsp;
			<a href="?acao=remover-img&id=<?=$id?>" class="remover"><img src="../img/sistema/ico-remover.gif" class="vimg" /> remover</a>
		<? } ?>
		<div class="small">(Tamanho ideal: 320px de largura x 240px de altura)</div>
	</span>
	<span>
    	<label for="data">Data:*</label>
		<input type="text" name="data" id="data" value="<?=$data?>" maxlength="150" />
	</span>
	<span><label for="ativo"><input type="checkbox" name="ativo" id="ativo" value="S" <? if($ativo == 'S') echo 'checked="checked"'; ?> />&nbsp;Ativo?</label></span>
	<br />

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
    <span class="retorno"></span>
</form>
