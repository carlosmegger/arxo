<?
$sql = selecionar("",CERTIFICACOES,"where 1 = 1");
$rs = mysql_fetch_assoc($sql);

$descricaoBR = $rs['descricaoBR'];
$descricaoEN = $rs['descricaoEN'];
$descricaoES = $rs['descricaoES'];
?>

<form name="form-certificacoes" id="form-certificacoes" method="post" enctype="multipart/form-data" action="">
	<input type="hidden" name="idioma" id="idioma" value="<?=$idioma?>" />

	<h2>Português</h2>
	<span><textarea name="descricaoBR" id="descricaoBR" class="ckeditor"><?=$descricaoBR?></textarea></span>
	<br />

    <h2>Inglês</h2>
    <span><textarea name="descricaoEN" id="descricaoEN" class="ckeditor"><?=$descricaoEN?></textarea></span>
    <br />

	<h2>Espanhol</h2>
	<span><textarea name="descricaoES" id="descricaoES" class="ckeditor"><?=$descricaoES?></textarea></span>
	<br />

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
	<span class="retorno"></span>
</form>
