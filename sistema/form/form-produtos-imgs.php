<?
if($acao == 'editar'){
	if(is_numeric($id)){
		$sql = selecionar("",PRODUTOS_IMGS,"where idimg = ".$id);
		$rs = mysql_fetch_assoc($sql);

		$idimg = $rs['idimg'];
		$idproduto = $rs['idproduto'];
		$imagem = $rs['imagem'];
		$legendaBR = $rs['legendaBR'];
		$legendaEN = $rs['legendaEN'];
		$legendaES = $rs['legendaES'];
		$crop = $rs['crop'];
		$ativo = $rs['ativo'];
		$posicao = $rs['posicao'];
	}
}
?>
<form name="form-produtos-imgs" id="form-produtos-imgs" class="<?=$acao?>" method="post" enctype="multipart/form-data" action="<?=($acao == 'adicionar') ? '?acao=adicionar' : '' ?>">
	<input type="hidden" name="acao" id="acao" value="<?=$acao?>" />

	<? if($acao == 'editar'){ ?>

		<input type="hidden" name="idimg" id="idimg" value="<?=$id?>" />
        <input type="hidden" name="idproduto" id="idproduto" value="<?=$idproduto?>" />

		<span>
            <label>Imagem:</label>
            <input type="file" name="imagem" id="imagem" size="40" />
            <input type="hidden" name="hidden" id="hidden" value="<?=$imagem?>" />
            <? if($acao == 'editar' && $imagem != ''){ ?><a href="<?=$path.$imagem?>" class="fancybox"><img src="../img/sistema/ico-zoom.png" class="vimg" /> visualizar</a><? } ?>
            <div class="small" style="margin:4px 0">(Tamanho ideal: 800px de largura x 600px de altura)</div>
		</span>
        
        <span>
			<label>Legenda - Português:</label>
            <input type="text" name="legendaBR" id="legendaBR" size="50" value="<?=$legendaBR?>" />
		</span>
        <span>
			<label>Legenda - Inglês:</label>
			<input type="text" name="legendaEN" id="legendaEN" size="50" value="<?=$legendaEN?>" />
		</span>
        <span>
			<label>Legenda - Espanhol:</label>
            <input type="text" name="legendaES" id="legendaES" size="50" value="<?=$legendaES?>" />
		</span>

	<? } ?>

	<span><input type="submit" value="Salvar" /></span>
	<span class="retorno"></span>
</form>
