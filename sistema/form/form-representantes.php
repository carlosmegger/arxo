<?
if($acao == 'editar'){
	if(is_numeric($id)){
		$sql = selecionar("",REPRESENTANTES,"where idrepresentante = ".$id);
		$rs = mysql_fetch_assoc($sql);

		$idrepresentante = $rs['idrepresentante'];
		$razao_social = $rs['razao_social'];
		$slug = $rs['slug'];
		$contato = $rs['contato'];
		$email = $rs['email'];
		$telefone = $rs['telefone'];
		$celular = $rs['celular'];
		$area = $rs['area'];
		$endereco = $rs['endereco'];
		$pais = $rs['pais'];
		$cidade = $rs['cidade'];
		$estado = $rs['estado'];
		$cep = $rs['cep'];
		$breve = $rs['breve'];
	}
}
?>
<form name="form-representantes" id="form-representantes" method="post" enctype="multipart/form-data" action="">
	<input type="hidden" name="posicao" value="<?=$posicao?>" />

	<span>
		<label for="razao_social">Razão Social/Título:*</label>
		<input type="text" name="razao_social" id="razao_social" value="<?=$razao_social?>" maxlength="150" />
	</span>
	<span>
    	<label for="contato">Contato(s):*</label>
        <input type="text" name="contato" id="contato" value="<?=$contato?>" maxlength="150" />
	</span>
    <span>
		<label for="email">E-mail:*</label>
        <input type="text" name="email" id="email" value="<?=$email?>" maxlength="150" />
	</span>
	<span>
    	<label for="telefone">Telefone:*</label>
        <input type="text" name="telefone" id="telefone" value="<?=$telefone?>" maxlength="150" />
	</span>
	<span>
    	<label for="celular">Celular:</label>
        <input type="text" name="celular" id="celular" value="<?=$celular?>" maxlength="150" />
	</span>
	<span>
    	<label for="area">Área:</label>
        <input type="text" name="area" id="area" value="<?=$area?>" maxlength="150" />
	</span>
	<span>
    	<label for="endereco">Endereço:*</label>
        <textarea name="endereco" id="endereco"><?=$endereco?></textarea>
	</span>
	<span>
		<label for="pais">País:*</label>
		<?=paises($pais)?>
	</span>
	<span>
    	<label for="cidade">Cidade:*</label>
        <input type="text" name="cidade" id="cidade" value="<?=$cidade?>" />
	</span>
	<span>
    	<label for="estado">Estado:*</label>
        <select name="estado" id="estado">
			<option value="">-- Selecione --</option>
			<option value="AC">Acre</option>
			<option value="AP">Amapá</option>
			<option value="AL">Alagoas</option>
			<option value="AM">Amazonas</option>
			<option value="BA">Bahia</option>
			<option value="CE">Ceará</option>
			<option value="DF">Distrito Federal</option>
			<option value="ES">Espirito Santo</option>
			<option value="GO">Goiás</option>
			<option value="MA">Maranhão</option>
			<option value="MT">Mato Grosso</option>
			<option value="MS">Mato Grosso do Sul</option>
			<option value="MG">Minas Gerais</option>
			<option value="PA">Pará</option>
			<option value="PR">Paraná</option>
			<option value="PB">Paraíba</option>
		    <option value="PE">Pernambuco</option>
		    <option value="PI">Piauí</option>
		    <option value="RJ">Rio de Janeiro</option>
		    <option value="RN">Rio Grande do Norte</option>
		    <option value="RS">Rio Grande do Sul</option>
		    <option value="RO">Rondônia</option>
		    <option value="RR">Roraima</option>
		    <option value="SP">São Paulo</option>
		    <option value="SC">Santa Catarina</option>
		    <option value="SE">Sergipe</option>
		    <option value="TO">Tocantins</option>
		</select>
	</span>
    <span>
    	<label for="cep">CEP:*</label>
        <input type="text" name="cep" id="cep" value="<?=$cep?>" />
    </span>
    <span>
    	<label for="breve">Breve:</label>
        <textarea name="breve" id="breve"><?=$breve?></textarea>
    </span>
	<br />


	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
    <span class="retorno"></span>
</form>
<script>
$("#estado").val('<?=$estado?>');
</script>
