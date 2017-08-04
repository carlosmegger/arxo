<form action="<?php echo $mailUrl; ?>" id="envie-um-email-form" class="form-horizontal" role="form" data-redirect="http://grupoclint.com.br/links-patrocinados/obrigado" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
	<div class="form-group">
		<label for="nome" class="col-sm-4 control-label" data-bv-notempty="true">Nome completo</label>
		<div class="col-sm-8">
			<input type="text" class="form-control input-sm" id="envie-um-email-nome" name="nome" data-bv-notempty="true" data-bv-notempty-message="Por favor digite seu nome completo">
		</div>
	</div>
	<div class="form-group">
		<label for="telefone" class="col-sm-4 control-label">Telefone</label>
		<div class="col-sm-8">
			<input type="text" class="form-control input-sm" id="envie-um-email-telefone" name="telefone" data-bv-notempty="true" data-bv-notempty-message="Por favor digite seu telefone" data-bv-phone="true" data-bv-phone-country="BR" data-bv-phone-message="Por favor digite um número de telefone válido">
		</div>
	</div>
	<div class="form-group">
		<label for="email" class="col-sm-4 control-label">E-mail</label>
		<div class="col-sm-8">
			<input type="email" class="form-control input-sm" id="envie-um-email-email" name="email" data-bv-notempty="true" data-bv-notempty-message="Por favor digite seu e-mail">
		</div>
	</div>
	<div class="form-group">
		<label for="cidade" class="col-sm-4 control-label">Cidade</label>
		<div class="col-sm-8">
			<input type="text" class="form-control input-sm" id="envie-um-email-cidade" name="cidade" data-bv-notempty="true" data-bv-notempty-message="Por favor digite sua cidade">
		</div>
	</div>
	<div class="form-group">
		<label for="empresa" class="col-sm-4 control-label">Nome da empresa</label>
		<div class="col-sm-8">
			<input type="text" class="form-control input-sm" id="envie-um-email-empresa" name="empresa" data-bv-notempty="true" data-bv-notempty-message="Por favor digite o nome da sua empresa">
		</div>
	</div>
	<div class="form-group">
		<label for="empresa" class="col-sm-4 control-label">Funcionários</label>
		<div class="col-sm-8">
			<select class="form-control input-sm" id="envie-um-email-funcionarios" name="numero-de-funcionarios" data-bv-notempty="true" data-bv-notempty-message="Por favor selecione o número de funcionários">
				<option value="">Selecione uma opção...</option>
				<option value="1 - 10">1 - 10</option>
				<option value="11 - 20">11 - 20</option>
				<option value="21 - 50">21 - 50</option>
				<option value="51 - 100">51 - 100</option>
				<option value="100 +">100 +</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="mensagem" class="col-sm-4 control-label">Dúvida ou Sugestão</label>
		<div class="col-sm-8">
			<textarea class="form-control input-sm" id="envie-um-email-mensagem" name="mensagem" data-bv-notempty="true" data-bv-notempty-message="Por favor digite a sua mensagem"></textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<div class="checkbox">
				<label>
					<input type="checkbox" id="envie-um-email-receber-informacoes" name="receber-informacoes"> Quero receber informações sobre o Grupo Clint
				</label>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-12">
			<input type="hidden" name="assunto" value="Google Adwords - Contato">
			<button type="submit" class="btn btn-default text-uppercase pull-right" data-loading-text="Enviando...">Enviar</button>
		</div>
	</div>

	<div class="msg-sucesso alert alert-success" role="alert">
			<strong>Mensagem enviada com sucesso!</strong><br>Em breve entraremos em contato. Obrigado.
	</div>
	<div class="msg-erro alert alert-danger" role="alert">
			<strong>Erro ao tentar enviar sua mensagem!</strong><br>Por favor tente novamente.
	</div>
</form>