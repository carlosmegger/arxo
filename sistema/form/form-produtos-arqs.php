<form name="form-produtos-arqs" id="form-produtos-arqs" method="post" enctype="multipart/form-data" action="">
	<input type="hidden" name="idproduto" value="<?=$idproduto?>" />

	<p>- Só serão gravados registros com título e seleção de arquivo.</p>
	<br />

	<div class="arquivos">
		<div class="cab">
            <span class="titulo">Título*</span>
            <span class="arquivo">Arquivo*</span>
            <span class="ativo">Ativo</span>
		</div>
        
		<? for($i = 1; $i <= 5; $i++){
			$fundo = ($i % 2) ? 'fundo-1' : 'fundo-2';
			?>
			<div class="<?=$fundo?>">
                <span class="titulo"><input type="text" name="titulo_<?=$i?>" maxlength="150" /></span>
                <span class="arquivo"><input type="file" name="arquivo_<?=$i?>" size="40" /></span>
                <span class="ativo"><input type="checkbox" name="ativo_<?=$i?>" value="S" checked /></span>
			</div>
		<? } ?>
	</div>

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
	<span class="retorno"></span>
</form>
<br />

<?
$query = mysql_query("select * from ".PRODUTOS_ARQS." where idproduto = '".$idproduto."' order by posicao desc");
if(mysql_num_rows($query) > 0){ ?>
	
	<h2 style="margin-bottom:5px">Arquivos cadastrados:</h2>
    <div class="listagem">
        <div class="cabecalho-arqs">
            <span class="titulo">Título</span>
            <span class="visualizar">Visualizar</span>
            <span class="ativo">Ativo</span>
            <span class="remover">Remover</span>
            <span class="posicao">Ordenar</span>
            <div class="clear"></div>
        </div>
        <div id="sortable">
            <input type="hidden" name="tabela" id="tabela" value="<?=PRODUTOS_ARQS?>" />
            <input type="hidden" name="campo" id="campo" value="idarq" />
            <input type="hidden" name="idproduto" id="idproduto" value="<?=$idproduto?>" />
            <?
            while($rs = mysql_fetch_assoc($query)){
				$ativo = ($rs['ativo'] == 'S') ? 'ico-ativo-on.png' : 'ico-ativo-off.png';
            ?>
            <div class="caixa-produto-arq posiciona" data-id="<?=$rs['idarq']?>">
				<span class="titulo"><a href="<?=$path.$rs['arquivo']?>" target="_blank"><?=$rs['titulo']?></a></span>
                <span class="visualizar"><a href="<?=$path.$rs['arquivo']?>" target="_blank"><img src="../img/sistema/ico-lupa.png" class="vimg" /></a></span>
                <span class="ativo"><img src="../img/sistema/<?=$ativo?>" longdesc="<?=PRODUTOS_ARQS?>-<?=$rs['idarq']?>-idarq" class="ativo cursor" /></span>
                <span class="remover"><a href="javascript:void(0)" onClick="removerArq(<?=$rs['idarq']?>,<?=$idproduto?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" /></a></span>
                <span class="posicao"></span>
			</div>
            <? } ?>
        </div>
	</div>
<? } ?>