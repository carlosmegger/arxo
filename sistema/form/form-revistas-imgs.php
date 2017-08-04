<?
if($acao == 'editar'){
	if(is_numeric($id)){
		$sql = selecionar("",REVISTAS_IMGS,"where idimg = ".$id);
		$rs = mysql_fetch_assoc($sql);

		$idimg = $rs['idimg'];
		$idrevista = $rs['idrevista'];
		$imagem = $rs['imagem'];
		$crop = $rs['crop'];
		$ativo = $rs['ativo'];
		$posicao = $rs['posicao'];
	}
}
?>
<form name="form-revistas-imgs" id="form-revistas-imgs" class="<?=$acao?>" method="post" enctype="multipart/form-data" action="<?=($acao == 'adicionar') ? '?acao=adicionar' : '' ?>">
	<input type="hidden" name="acao" id="acao" value="<?=$acao?>" />

	<? if($acao == 'editar'){ ?>
		<input type="hidden" name="idimg" id="idimg" value="<?=$id?>" />
		<input type="hidden" name="idrevista" id="idrevista" value="<?=$idrevista?>" />

		<span>
			<label>Imagem:</label>
			<input type="file" name="imagem" id="imagem" size="40" />
			<input type="hidden" name="hidden" id="hidden" value="<?=$imagem?>" />
			<? if($acao == 'editar' && $imagem != ''){ ?><a href="<?=$path.$imagem?>" class="fancybox"><img src="../img/sistema/ico-zoom.png" class="vimg" /> visualizar</a><? } ?>
			<!--div class="small">(Tamanho ideal: 600px de largura x 800px de altura)</div-->
            <div class="small">(Tamanho ideal: 1500px de largura x 2000px de altura)</div>
		</span>
	<? } ?>

	<span><input type="submit" value="Salvar" /></span>
	<span class="retorno"></span>
</form>
