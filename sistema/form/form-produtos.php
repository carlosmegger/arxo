<?
if($acao == 'editar'){
	if(is_numeric($id)){
		$sql = selecionar("",PRODUTOS,"where idproduto = ".$id);
		$rs = mysql_fetch_assoc($sql);

		$idproduto = $rs['idproduto'];
		$idioma = $rs['idioma'];
		$idcategoria = $rs['idcategoria'];
		$titulo_completo = $rs['titulo_completo'];
		$slug = $rs['slug'];
		$titulo = $rs['titulo'];
		$subtitulo = $rs['subtitulo'];
		$descricao = $rs['descricao'];
		$imagem = $rs['imagem'];
		$imagem_tit = $rs['imagem_tit'];
		$imagem_banner = $rs['imagem_banner'];
		$ativo = $rs['ativo'];
		$posicao = $rs['posicao'];

		$meta_titulo = $rs['meta_titulo'];
		$meta_descricao = $rs['meta_descricao'];

		#relacionados
		$sql = mysql_query("select * from ".PRODUTOS_REL." where idproduto = '".$idproduto."'");
		while($rs = mysql_fetch_assoc($sql)){
			$selecionados .= $rs['idrelacionado'].',';
		}
		$selecionados = substr($selecionados,0,-1);

	}

} else {
	$url = 'http://';
	$ativo = 'S';
	$posicao = proxPosicao(PRODUTOS,'asc');
}
?>

<script>
$(function(){

	$('input[name=idioma]').click(function(){
		categorias($(this).val(),'');
	});

	/* --- produtos relacionados */
	$('input[name=idioma]').click(function(){
		var _this = $(this),
			idioma = _this.val();

		relacionados(idioma);
	});

	<? if($acao == 'editar'){ ?>
	categorias('<?=$idioma?>','<?=$idcategoria?>');
	relacionados('<?=$idioma?>');
	<? } ?>

});
function categorias(idioma,selected){
	var seletor = $('#idcategoria'),
		url = 'ajax.php?acao=categorias&idioma='+ idioma +'&tipo=P&selected='+ selected;

	$.ajax({ url:url, type:'GET', cache:false, success:function(response){
		if(response != '') seletor.html(response);
	}});
}
function relacionados(idioma){
	var idproduto = $('.relacionados').data('idproduto'),
		selecionados = $('.relacionados').data('selecionados'),
		lista = $('.relacionados .lista');

	var url = 'ajax.php?acao=exibe-produtos-rel',
		data = { idioma : idioma, idproduto : idproduto, selecionados : selecionados };

	$.ajax({ url:url, type:'POST', data:data, async:false, cache:false, success:function(response){
		if(response != '') lista.html(response);
	}});
}
</script>
<form name="form-produtos" id="form-produtos" method="post" enctype="multipart/form-data" action="">
	<!--input type="hidden" name="posicao" value="<?=$posicao?>" /-->

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
    	<label for="titulo_completo">Título Completo:* <a href="../img/sistema/ajuda-tit-produtos.png" class="fancybox"><img src="../img/sistema/ico-ajuda.png" alt="Ajuda" class="vimg" /></a></label>
        <input type="text" name="titulo_completo" id="titulo_completo" value="<?=$titulo_completo?>" maxlength="150" />
	</span>
	<span>
    	<label for="titulo">Título (trecho em negrito):* <a href="../img/sistema/ajuda-tit-produtos.png" class="fancybox"><img src="../img/sistema/ico-ajuda.png" alt="Ajuda" class="vimg" /></a></label>
        <input type="text" name="titulo" id="titulo" value="<?=$titulo?>" maxlength="150" />
	</span>
	<span>
		<label for="subtitulo">Subtítulo (trecho regular): <a href="../img/sistema/ajuda-tit-produtos.png" class="fancybox"><img src="../img/sistema/ico-ajuda.png" alt="Ajuda" class="vimg" /></a></label>
		<input type="text" name="subtitulo" id="subtitulo" value="<?=$subtitulo?>" maxlength="150" />
	</span>
    
	<span>
    	<label for="meta_titulo">Título utilizado no Google <a href="../img/sistema/resultado-google.gif" class="fancybox"><img src="../img/sistema/ico-help.gif" class="vimg" alt="Google" /></a>:</label>
		<input type="text" name="meta_titulo" id="meta_titulo" value="<?=$meta_titulo?>" />
        <div class="contador-tit">Qtd. de caractere(s) disponível(is): <span></span></div>
    </span>

	<span>
		<label for="descricao">Descrição:*</label>
		<textarea name="descricao" id="descricao" class="ckeditor"><?=$descricao?></textarea>
	</span>
    
    <span>
        <label for="meta_descricao">Descrição que aparecerá no Google <a href="../img/sistema/resultado-google.gif" class="fancybox"><img src="../img/sistema/ico-help.gif" class="vimg" alt="Google" /></a>:</label>
        <textarea name="meta_descricao" id="meta_descricao"><?=$meta_descricao?></textarea>
        <div class="contador-desc">Qtd. de caractere(s) disponível(is): <span></span></div>
	</span>
    
	<span>
        <label for="imagem">Imagem miniatura - utilizada nas listagens:*</label>
        <input type="hidden" name="hidden" id="hidden" value="<?=$imagem?>" />
        <input type="file" name="imagem" id="imagem" size="40" />
		<? if($acao == 'editar' && $imagem != ''){ ?><a href="<?=$path.$imagem?>" class="fancybox"><img src="../img/sistema/ico-zoom.png" class="vimg" /> visualizar</a><? } ?>
		<div class="small">(Tamanho ideal: 294px de largura x 180px de altura)</div>
	</span>

	<span>
        <label for="imagem_tit">Imagem transparente - será exibida ao lado do título:</label>
        <input type="hidden" name="hidden_tit" id="hidden_tit" value="<?=$imagem_tit?>" />
        <input type="file" name="imagem_tit" id="imagem_tit" size="40" />
		<? if($acao == 'editar' && $imagem_tit != ''){ ?>
			<a href="<?=$path_tit.$imagem_tit?>" class="fancybox"><img src="../img/sistema/ico-zoom.png" class="vimg" /> visualizar</a>&nbsp;&nbsp;
            <a href="#" class="remover-produto-tit remover" data-img="<?=$imagem_tit?>" data-idproduto="<?=$idproduto?>"><img src="../img/sistema/ico-remover.gif" class="vimg" /> remover</a>
		<? } ?>
		<div class="small">(Tamanho ideal: 485px de largura x 277px de altura)</div>
	</span>
	<span>
		<label for="imagem_banner">Imagem banner - será exibida antes do conteúdo:</label>
        <input type="hidden" name="hidden_banner" id="hidden_banner" value="<?=$imagem_banner?>" />
		<input type="file" name="imagem_banner" id="imagem_banner" size="40" />
		<? if($acao == 'editar' && $imagem_banner != ''){ ?>
			<a href="<?=$path_banner.$imagem_banner?>" class="fancybox"><img src="../img/sistema/ico-zoom.png" class="vimg" /> visualizar</a>&nbsp;&nbsp;
			<a href="#" class="remover-produto-banner remover" data-img="<?=$imagem_banner?>" data-idproduto="<?=$idproduto?>"><img src="../img/sistema/ico-remover.gif" class="vimg" /> remover</a>
		<? } ?>
		<div class="small">(Tamanho ideal: 960px de largura x altura proporcional)</div>
	</span>

	<span>
    	<label for="posicao">Posição:*</label>
		<input type="text" name="posicao" id="posicao" value="<?=$posicao?>" />
		<div class="small">(Ordenamento descrescente - números maiores tem prevalência nas listagens)</div>
    </span>
	
	<span><label for="ativo"><input type="checkbox" name="ativo" id="ativo" value="S" <? if($ativo == 'S') echo 'checked="checked"'; ?> />&nbsp;Ativo?</label></span>
	<br />

	<div class="relacionados" data-idproduto="<?=$idproduto?>" data-selecionados="<?=$selecionados?>">
		<h2>Selecione o(s) produto(s) relacionado(s):</h2>
		<p>- Serão listados como produtos adicionais no orçamento.</p>
		<div class="lista">
			<p>Para relacionar produtos é necessário selecionar o idioma!</p>
			<?
			/*
			$sql = selecionar("",PRODUTOS,"where idproduto not in ('".$idproduto."') order by posicao desc");
			while($rs = mysql_fetch_assoc($sql)){
				echo '<label>';
				echo '	<input type="checkbox" name="produto_relacionado[]" value="'.$rs['idproduto'].'" />';
				echo '	<span class="img"><img src="../img/produtos/p/'.$rs['imagem'].'" alt="'.$rs['titulo'].'" /></span>';
				echo '	<span class="tit">'.$rs['titulo'].'</span>';
				echo '</label>';
			}
			*/
			?>
		</div>
	</div>
	<br />

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
    <span class="retorno"></span>
</form>
