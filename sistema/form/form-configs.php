<?
#url loja
$sql1 = mysql_query("select * from ".CONFIGS." where diretiva = 'url_loja'");
$rs1 = mysql_fetch_assoc($sql1);

$diretiva1 = $rs1['diretiva'];
$valor1 = $rs1['valor'];
?>
<form name="form-configs" id="form-configs" method="post" enctype="multipart/form-data" action="">
	<span>
		<label for="valor1">Link da Loja virtual - <em>E-commerce</em>:*</label>
        <input type="text" name="valor1" id="valor1" value="<?=$valor1?>" maxlenght="250" />
	</span>
	<br />

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
	<span class="retorno"></span>
</form>
