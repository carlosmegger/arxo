<?
if($acao == 'editar'){
	if(is_numeric($id)){
		$sql = selecionar("",USUARIOS,"where idusuario = ".$id);
		$rs = mysql_fetch_assoc($sql);

		$idusuario = $rs['idusuario'];
		$nome = $rs['nome'];
		$email = $rs['email'];
		$senha = $rs['senha'];
		$permissao = $rs['permissao'];
		$ativo = $rs['ativo'];
		$data_cadastro = $rs['data_cadastro'];
		$data_edicao = $rs['data_edicao'];

		#permissoes
		$_permissoes = explode(',',$permissao);
	}

} else {

	$ativo = 'S';

	#permissoes
	$_permissoes = array();
}
?>
<form name="form-usuarios" id="form-usuarios" method="post" enctype="multipart/form-data" action="">
	<input type="hidden" name="idusuario" id="idusuario" value="<?=$idusuario?>" />
	
	<span>
    	<label for="nome">Nome:*</label>
        <input type="text" name="nome" id="nome" value="<?=$nome?>" maxlength="150" />
	</span>
	<span>
    	<label for="email">E-mail:*</label>
        <input type="text" name="email" id="email" value="<?=$email?>" maxlength="150" />
	</span>
	<span>
    	<label for="senha">Senha:*</label>
        <input type="text" name="senha" id="senha" value="<?=$senha?>" maxlength="150" />
	</span>
	<span><label for="ativo"><input type="checkbox" name="ativo" id="ativo" value="S" <?=($ativo == 'S') ? 'checked="checked"' : '' ?> />&nbsp;Ativo? (Usuários inativos não acessam o sistema).</label></span>
	<br />

    <h2>Permissões:</h2>
	<p style="color:#d00">- As permissões surtirão efeito após novo login.</p>
	<div class="permissoes">
		<div>
			<p>Gerais:</p>
            <label><input type="checkbox" name="permissao[]" value="configs" <?=(in_array('configs',$_permissoes)) ? 'checked="checked"' : '' ?> /> Configurações</label>
            <label><input type="checkbox" name="permissao[]" value="slides" <?=(in_array('slides',$_permissoes)) ? 'checked="checked"' : '' ?> /> Slides</label>
            <label><input type="checkbox" name="permissao[]" value="chamadas" <?=(in_array('chamadas',$_permissoes)) ? 'checked="checked"' : '' ?> /> Chamadas</label>
			<label><input type="checkbox" name="permissao[]" value="popup" <?=(in_array('popup',$_permissoes)) ? 'checked="checked"' : '' ?> /> Pop-up</label>
			<label><input type="checkbox" name="permissao[]" value="usuarios" <?=(in_array('usuarios',$_permissoes)) ? 'checked="checked"' : '' ?> /> Usuários</label>
		</div>
        
        <div>
			<p>Quem somos:</p>
            <label><input type="checkbox" name="permissao[]" value="institucional" <?=(in_array('institucional',$_permissoes)) ? 'checked="checked"' : '' ?> /> A Arxo</label>
			<label><input type="checkbox" name="permissao[]" value="linha-tempo" <?=(in_array('linha-tempo',$_permissoes)) ? 'checked="checked"' : '' ?> /> Linha do Tempo</label>
            <label><input type="checkbox" name="permissao[]" value="ideologia" <?=(in_array('ideologia',$_permissoes)) ? 'checked="checked"' : '' ?> /> Ideologia</label>
            <label><input type="checkbox" name="permissao[]" value="veryx" <?=(in_array('veryx',$_permissoes)) ? 'checked="checked"' : '' ?> /> Veryx</label>
            <label><input type="checkbox" name="permissao[]" value="certificacoes" <?=(in_array('certificacoes',$_permissoes)) ? 'checked="checked"' : '' ?> /> Certificações</label>
            <label><input type="checkbox" name="permissao[]" value="premios-certificacoes" <?=(in_array('premios-certificacoes',$_permissoes)) ? 'checked="checked"' : '' ?> /> Prêmios e Certificações</label>
            <label><input type="checkbox" name="permissao[]" value="clientes" <?=(in_array('clientes',$_permissoes)) ? 'checked="checked"' : '' ?> /> Clientes</label>
		</div>

		<div>
			<p>Produtos e Serviços:</p>
			<label><input type="checkbox" name="permissao[]" value="categorias-p" <?=(in_array('categorias-p',$_permissoes)) ? 'checked="checked"' : '' ?> /> Categorias</label>
			<label><input type="checkbox" name="permissao[]" value="produtos" <?=(in_array('produtos',$_permissoes)) ? 'checked="checked"' : '' ?> /> Produtos</label>
        </div>

        <div>
			<p>Notícias:</p>
            <label><input type="checkbox" name="permissao[]" value="categorias-n" <?=(in_array('categorias-n',$_permissoes)) ? 'checked="checked"' : '' ?> /> Categorias</label>
			<label><input type="checkbox" name="permissao[]" value="noticias" <?=(in_array('noticias',$_permissoes)) ? 'checked="checked"' : '' ?> /> Notícias</label>
		</div>

		<div>
        	<p>Comunicado:</p>
			<label><input type="checkbox" name="permissao[]" value="instituto" <?=(in_array('instituto',$_permissoes)) ? 'checked="checked"' : '' ?> /> Comunicado</label>
			<label><input type="checkbox" name="permissao[]" value="instituto-galeria" <?=(in_array('instituto-galeria',$_permissoes)) ? 'checked="checked"' : '' ?> /> Comunicado Galeria</label>
		</div>

		<div>
        	<p>Comunicação Visual:</p>
			<label><input type="checkbox" name="permissao[]" value="comunicacao" <?=(in_array('comunicacao',$_permissoes)) ? 'checked="checked"' : '' ?> /> Comunicação Visual</label>
			<label><input type="checkbox" name="permissao[]" value="comunicacao-galeria" <?=(in_array('comunicacao-galeria',$_permissoes)) ? 'checked="checked"' : '' ?> /> Comunicação Visual Galeria</label>
		</div>
        
        <div>
			<p>Localização:</p>
			<label><input type="checkbox" name="permissao[]" value="locais" <?=(in_array('locais',$_permissoes)) ? 'checked="checked"' : '' ?> /> Locais</label>
		</div>

		<div>
        	<p>Opções de Financiamento:</p>
			<label><input type="checkbox" name="permissao[]" value="financiamento" <?=(in_array('financiamento',$_permissoes)) ? 'checked="checked"' : '' ?> /> Opções de Financiamento</label>
		</div>
        
        <div>
			<p>Contatos:</p>
            <label><input type="checkbox" name="permissao[]" value="contatos" <?=(in_array('contatos',$_permissoes)) ? 'checked="checked"' : '' ?> /> Contatos</label>
            <label><input type="checkbox" name="permissao[]" value="curriculos" <?=(in_array('curriculos',$_permissoes)) ? 'checked="checked"' : '' ?> /> Currículos</label>
			<label><input type="checkbox" name="permissao[]" value="representantes" <?=(in_array('representantes',$_permissoes)) ? 'checked="checked"' : '' ?> /> Representantes</label>
			<label><input type="checkbox" name="permissao[]" value="orcamentos" <?=(in_array('orcamentos',$_permissoes)) ? 'checked="checked"' : '' ?> /> Solicitações de Orçamento</label>
		</div>

        <div>
        	<p>Portais:</p>
			<label><input type="checkbox" name="permissao[]" value="portal-cliente" <?=(in_array('portal-cliente',$_permissoes)) ? 'checked="checked"' : '' ?> /> Portal do Cliente</label>
			<label><input type="checkbox" name="permissao[]" value="portal-downloads" <?=(in_array('portal-downloads',$_permissoes)) ? 'checked="checked"' : '' ?> /> Download para Clientes</label>
			<label><input type="checkbox" name="permissao[]" value="portal-colaborador" <?=(in_array('portal-colaborador',$_permissoes)) ? 'checked="checked"' : '' ?> /> Portal do Colaborador</label>
		</div>

		<div>
            <p>Simpósio de Esculturas:</p>
            <label><input type="checkbox" name="permissao[]" value="simposio" <?=(in_array('simposio',$_permissoes)) ? 'checked="checked"' : '' ?> /> Simpósio de Esculturas</label>
            <label><input type="checkbox" name="permissao[]" value="simposio-galerias" <?=(in_array('simposio-galerias',$_permissoes)) ? 'checked="checked"' : '' ?> /> Galerias</label>
            <label><input type="checkbox" name="permissao[]" value="simposio-inscricoes" <?=(in_array('simposio-inscricoes',$_permissoes)) ? 'checked="checked"' : '' ?> /> Inscrições</label>
        </div>

		<div>
            <p>Revista Arxo:</p>
            <label><input type="checkbox" name="permissao[]" value="revistas" <?=(in_array('revistas',$_permissoes)) ? 'checked="checked"' : '' ?> /> Revistas</label>
		</div>

        <div>
        	<p>Relatório de Sustentabilidade:</p>
			<label><input type="checkbox" name="permissao[]" value="relatorio-sustentabilidade" <?=(in_array('relatorio-sustentabilidade',$_permissoes)) ? 'checked="checked"' : '' ?> /> Relatório de Sustentabilidade</label>
		</div>

	</div>
	<div class="clear"></div>
	<br />

	<span class="small">*Campos obrigatórios.</span>
	<span><input type="submit" value="Salvar" /></span>
    <span class="retorno"></span>
</form>
