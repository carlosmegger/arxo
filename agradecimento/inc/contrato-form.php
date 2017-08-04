<form action="<?php echo $mailUrl; ?>" id="contrato-form" class="form-vertical" role="form" data-redirect="<?php echo $redirectUrl; ?>" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
	<div class="clearfix">
		<div class="form-group col-sm-4">
			<label for="nome" class="control-label" data-bv-notempty="true">Nome completo</label>
			<input type="text" class="form-control input-disabled" id="contrato-nome" name="nome" data-bv-notempty="true" data-bv-notempty-message="Por favor digite seu nome completo">
		</div>
		<div class="form-group col-sm-4">
			<label for="telefone" class="control-label">Telefone</label>
			<input type="text" class="form-control input-disabled" id="contrato-telefone" name="telefone" data-bv-notempty="true" data-bv-notempty-message="Por favor digite seu telefone" data-bv-phone="true" data-bv-phone-country="BR" data-bv-phone-message="Por favor digite um número de telefone válido">
		</div>
		<div class="form-group col-sm-4">
			<label for="email" class="control-label">E-mail</label>
			<input type="email" class="form-control input-disabled" id="contrato-email" name="email" data-bv-notempty="true" data-bv-notempty-message="Por favor digite seu e-mail">
		</div>
	</div>
	<div class="clearfix">
		<div class="form-group col-sm-4">
			<label for="empresa" class="control-label">Empresa</label>
			<input type="text" class="form-control input-md" id="contrato-empresa" name="empresa" data-bv-notempty="true" data-bv-notempty-message="Por favor digite o nome da sua empresa">
		</div>
		<div class="form-group col-sm-4">
			<label for="razao-social" class="control-label">Razão social</label>
			<input type="text" class="form-control input-md" id="contrato-razao-social" name="razao-social" data-bv-notempty="true" data-bv-notempty-message="Por favor digite a razão social da sua empresa">
		</div>
		<div class="form-group col-sm-4">
			<label for="cnpj" class="control-label">CNPJ</label>
			<input type="text" class="form-control input-md" id="contrato-cnpj" name="cnpj" data-bv-notempty="true" data-bv-notempty-message="Por favor digite o CNPJ da sua empresa">
		</div>
	</div>
	<div class="clearfix">
		<div class="form-group col-sm-6">
			<label for="endereco" class="control-label">Endereço</label>
			<input type="text" class="form-control input-md" id="contrato-endereco" name="endereco" data-bv-notempty="true" data-bv-notempty-message="Por favor digite o endereço da sua empresa">
		</div>
		<div class="form-group col-sm-6">
			<label for="complemento" class="control-label">Complemento</label>
			<input type="text" class="form-control input-md" id="contrato-complemento" name="complemento">
		</div>
	</div>
	<div class="clearfix">
		<div class="form-group col-sm-4">
			<label for="cidade" class="control-label">Cidade</label>
			<input type="text" class="form-control input-md" id="contrato-cidade" name="cidade" data-bv-notempty="true" data-bv-notempty-message="Por favor digite sua cidade">
		</div>
		<div class="form-group col-sm-4">
			<label for="estado" class="control-label">Estado</label>
			<select class="form-control input-md" id="contrato-estado" name="estado" data-bv-notempty="true" data-bv-notempty-message="Por favor selecione seu estado">
				<option value="">--</option>
				<option value="AC">AC</option>
				<option value="AL">AL</option>
				<option value="AP">AP</option>
				<option value="AM">AM</option>
				<option value="BA">BA</option>
				<option value="CE">CE</option>
				<option value="DF">DF</option>
				<option value="ES">ES</option>
				<option value="GO">GO</option>
				<option value="MA">MA</option>
				<option value="MT">MT</option>
				<option value="MS">MS</option>
				<option value="MG">MG</option>
				<option value="PA">PA</option>
				<option value="PB">PB</option>
				<option value="PR">PR</option>
				<option value="PE">PE</option>
				<option value="PI">PI</option>
				<option value="RJ">RJ</option>
				<option value="RN">RN</option>
				<option value="RS">RS</option>
				<option value="RO">RO</option>
				<option value="RR">RR</option>
				<option value="SC">SC</option>
				<option value="SP">SP</option>
				<option value="SE">SE</option>
				<option value="TO">TO</option>
			</select>
		</div>
		<div class="form-group col-sm-4">
			<label for="plano" class="control-label">Plano</label>
			<input type="text" class="form-control input-md" id="contrato-plano" name="plano" value="<?php echo $plano; ?>" disabled>
		</div>
	</div>
	<div class="form-group col-sm-4 no-label">
		<div class="checkbox">
			<label>
				<input type="checkbox" id="aceito-termos-do-contrato" name="termos-contrato"  data-bv-notempty="true" data-bv-notempty-message="Por favor leia e aceite os termos do contrato"> Li e aceito os <a href="#" data-toggle="modal" data-target="#contrato-dialog">termos do contrato</a>.
			</label>
		</div>
	</div>
	<div class="form-group col-sm-4 col-sm-offset-4">
		<input type="hidden" name="assunto" value="Google Adwords - Contrato <?php echo $plano; ?>">
		<button type="submit" class="btn btn-default text-uppercase pull-right extra-margin-top" data-loading-text="Enviando...">Contratar</button>
	</div>

	<div class="msg-erro alert alert-danger" role="alert">
			<strong>Erro ao tentar enviar seu contrato!</strong><br>Por favor tente novamente.
	</div>
</form>