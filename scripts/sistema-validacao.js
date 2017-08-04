$(function(){
	var retorno = $('.retorno');
		
	/* --- login */
	$('#form-login').submit(function(){
		var login = $('#login'),
			senha = $('#senha');
		
		if(login.val() == ''){
			retorno.html('Preencha o login!');
			login.addClass('erro').focus();
			return false;
		} else {
			login.removeClass('erro');
		}
		if(senha.val() == ''){
			retorno.html('Preencha a senha!');
			senha.addClass('erro').focus();
			return false;
		} else {
			senha.removeClass('erro');
		}
	});
	
	/* confis */
	$('#form-configs').submit(function(){
		var valor1 = $('#valor1');

		if(valor1.val() == '' || valor1.val() == 'http://'){
			retorno.html('Preencha o endereço da loja virtual!');
			valor1.addClass('erro').focus();
			return false;
		} else {
			valor1.removeClass('erro');
		}
	});

	/* slides */
	$('#form-slides').submit(function(){
		var titulo = $('#titulo'),
			imagem = $('#imagem');

		if($('input[name=idioma]').is(':checked') == false){
			retorno.html('Selecione o idioma!');
			return false;
		}
		if(titulo.val() == ''){
			retorno.html('Preencha o título!');
			titulo.addClass('erro').focus();
			return false;
		} else {
			titulo.removeClass('erro');
		}

		if(acao == 'adicionar'){
			if(imagem.val() == ''){
				retorno.html('Selecione uma imagem!');
				imagem.addClass('erro').focus();
				return false;
			} else {
				imagem.removeClass('erro');
			}
		}
	});

	/* chamadas */
	$('#form-chamadas').submit(function(){
		var titulo = $('#titulo'),
			breve = $('#breve'),
			imagem = $('#imagem'),
			url = $('#url');
		
		if($('input[name=idioma]').is(':checked') == false){
			retorno.html('Selecione o idioma!');
			return false;
		}
		if(titulo.val() == ''){
			retorno.html('Preencha o título!');
			titulo.addClass('erro').focus();
			return false;
		} else {
			titulo.removeClass('erro');
		}
		if(breve.val() == ''){
			retorno.html('Preencha uma breve descrição!');
			breve.addClass('erro').focus();
			return false;
		} else {
			breve.removeClass('erro');
		}
		if(acao == 'adicionar'){
			if(imagem.val() == ''){
				retorno.html('Selecione a imagem!');
				imagem.addClass('erro').focus();
				return false;
			} else {
				imagem.removeClass('erro');
			}
		}
		if(url.val() == '' || url.val() == 'http://'){
			retorno.html('Preencha o link!');
			url.addClass('erro').focus();
			return false;
		} else {
			url.removeClass('erro');
		}
	});

	/* popup */
	$('#form-popup').submit(function(){
		var titulo = $('#titulo'),
			imagem = $('#imagem'),
			url = $('#url');
		
		if($('input[name=idioma]').is(':checked') == false){
			retorno.html('Selecione o idioma!');
			return false;
		}
		if(titulo.val() == ''){
			retorno.html('Preencha o título!');
			titulo.addClass('erro').focus();
			return false;
		} else {
			titulo.removeClass('erro');
		}
		if(acao == 'adicionar'){
			if(imagem.val() == ''){
				retorno.html('Selecione a imagem!');
				imagem.addClass('erro').focus();
				return false;
			} else {
				imagem.removeClass('erro');
			}
		}
		if(url.val() == '' || url.val() == 'http://'){
			retorno.html('Preencha o link!');
			url.addClass('erro').focus();
			return false;
		} else {
			url.removeClass('erro');
		}
	});
	
	/* usuarios */
	$('#form-usuarios').submit(function(){
		var idusuario = $('#idusuario'),
			nome = $('#nome'),
			email = $('#email'),
			senha = $('#senha');

		if(nome.val() == ''){
			retorno.html('Preencha o nome do usuário!');
			nome.addClass('erro').focus();
			return false;
		} else {
			nome.removeClass('erro');
		}
		if(validaMail(email.val()) == false){
			retorno.html('Preencha o e-mail corretamente!');
			email.addClass('erro').focus();
			return false;
		} else {
			email.removeClass('erro');
		}
		if(validaEmailUsuario(email.val(),idusuario.val()) == false){
			retorno.html('O e-mail informado já pertence a outro usuário!');
			email.addClass('erro').focus();
			return false;
		} else {
			email.removeClass('erro');
		}
		if(senha.val() == ''){
			retorno.html('Preencha a senha!');
			senha.addClass('erro').focus();
			return false;
		} else {
			senha.removeClass('erro');
		}
	});

	/* institucional, ideologia, veryx */
	$('#form-institucional,#form-ideologia,#form-veryx').submit(function(){
		var titulo = $('#titulo'),
			descricao = CKEDITOR.instances['descricao'].getData();

		if(titulo.val() == ''){
			retorno.html('Preencha o título!');
			titulo.addClass('erro').focus();
			return false;
		} else {
			titulo.removeClass('erro');
		}
		if(descricao == ''){
			retorno.html('Preencha a descrição!');
			return false;
		}
	});

	/* linha do tempo */
	$('#form-linha-tempo').submit(function(){
		var ano = $('#ano'),
			texto = $('#texto');
			//imagem = $('#imagem');

		if($('input[name=idioma]').is(':checked') == false){
			retorno.html('Selecione o idioma!');
			return false;
		}
		if(ano.val() == ''){
			retorno.html('Preencha o ano!');
			ano.addClass('erro').focus();
			return false;
		} else {
			ano.removeClass('erro');
		}
		if(texto.val() == ''){
			retorno.html('Preencha o texto!');
			texto.addClass('erro').focus();
			return false;
		} else {
			texto.removeClass('erro');
		}

		/*
		if(acao == 'adicionar'){
			if(imagem.val() == ''){
				retorno.html('Selecione uma imagem!');
				imagem.addClass('erro').focus();
				return false;
			} else {
				imagem.removeClass('erro');
			}
		}
		*/
	});
	
	/* certificacoes */
	$('#form-certificacoes').submit(function(){
		var descricaoBR = CKEDITOR.instances['descricaoBR'].getData(),
			descricaoEN = CKEDITOR.instances['descricaoEN'].getData(),
			descricaoES = CKEDITOR.instances['descricaoES'].getData();

		if(descricaoBR == ''){
			retorno.html('Preencha a descrição para o português!');
			return false;
		}
		if(descricaoEN == ''){
			retorno.html('Preencha a descrição para o inglês!');
			return false;
		}
		if(descricaoES == ''){
			retorno.html('Preencha a descrição para o espanhol!');
			return false;
		}

	});
	
	/* premios e certificacoes */
	$('#form-premios-certificacoes').submit(function(){
		var titulo = $('#titulo');
		
		if($('input[name=idioma]').is(':checked') == false){
			retorno.html('Selecione o idioma!');
			return false;
		}
		if(titulo.val() == ''){
			retorno.html('Preencha o título!');
			titulo.addClass('erro').focus();
			return false;
		} else {
			titulo.removeClass('erro');
		}
	});

	/* clientes */
	$('#form-clientes').submit(function(){
		var titulo = $('#titulo'),
			imagem = $('#imagem');

		if(titulo.val() == ''){
			retorno.html('Preencha o título/nome!');
			titulo.addClass('erro').focus();
			return false;
		} else {
			titulo.removeClass('erro');
		}
		if(acao == 'adicionar'){
			if(imagem.val() == ''){
				retorno.html('Selecione a imagem!');
				imagem.addClass('erro').focus();
				return false;
			} else {
				imagem.removeClass('erro');
			}
		}
	});
	
	/* categorias */
	$('#form-categorias').submit(function(){
		var tipo = $('#tipo'),
			titulo = $('#titulo'),
			imagem = $('#imagem'),
			hexadecimal = $('#hexadecimal');

		if($('input[name=idioma]').is(':checked') == false){
			retorno.html('Selecione o idioma!');
			return false;
		}
		if(titulo.val() == ''){
			retorno.html('Preencha o título!');
			titulo.addClass('erro').focus();
			return false;
		} else {
			titulo.removeClass('erro');
		}
		if(tipo.val() == 'P'){
			var descricao = CKEDITOR.instances['descricao'].getData();
			if(descricao == ''){
				retorno.html('Preencha a descrição!');
				return false;
			}

			if(acao == 'adicionar'){
				if(imagem.val() == ''){
					retorno.html('Selecione a imagem!');
					imagem.addClass('erro').focus();
					return false;
				} else {
					imagem.removeClass('erro');
				}
			}

			if(hexadecimal.val() == ''){
				retorno.html('Preencha o hexadecimal!');
				hexadecimal.addClass('erro').focus();
				return false;
			} else {
				hexadecimal.removeClass('erro');
			}
		}
	});
	
	/* produtos e serviços */
	$('#form-produtos').submit(function(){
		var idcategoria = $('#idcategoria'),
			titulo_completo = $('#titulo_completo'),
			titulo = $('#titulo'),
			subtitulo = $('#subtitulo'),
			descricao = CKEDITOR.instances['descricao'].getData(),
			imagem = $('#imagem'),
			posicao = $('#posicao');

		if($('input[name=idioma]').is(':checked') == false){
			retorno.html('Selecione o idioma!');
			return false;
		}
		if(idcategoria.val() == 0){
			retorno.html('Selecione a categoria!');
			idcategoria.addClass('erro').focus();
			return false;
		} else {
			idcategoria.removeClass('erro');
		}
		if(titulo_completo.val() == ''){
			retorno.html('Preencha o título completo!');
			titulo_completo.addClass('erro').focus();
			return false;
		} else {
			titulo_completo.removeClass('erro');
		}
		if(titulo.val() == ''){
			retorno.html('Preencha o título!');
			titulo.addClass('erro').focus();
			return false;
		} else {
			titulo.removeClass('erro');
		}
		/*
		if(subtitulo.val() == ''){
			retorno.html('Preencha o subtítulo!');
			subtitulo.addClass('erro').focus();
			return false;
		} else {
			subtitulo.removeClass('erro');
		}
		*/

		if(descricao == ''){
			retorno.html('Preencha a descrição!');
			return false;
		}
		if(acao == 'adicionar'){
			if(imagem.val() == ''){
				retorno.html('Selecione a imagem!');
				imagem.addClass('erro').focus();
				return false;
			} else {
				imagem.removeClass('erro');
			}
		}

		if(posicao.val() == ''){
			retorno.html('Preencha a ordem de exibição deste produto!');
			posicao.addClass('erro').focus();
			return false;
		} else {
			posicao.removeClass('erro');
		}

	});
	
	/* noticias */
	$('#form-noticias').submit(function(){
		var idcategoria = $('#idcategoria'),
			titulo = $('#titulo'),
			breve = $('#breve'),
			descricao = CKEDITOR.instances['descricao'].getData(),
			imagem = $('#imagem'),
			data = $('#data');

		if($('input[name=idioma]').is(':checked') == false){
			retorno.html('Selecione o idioma!');
			return false;
		}
		
		if(idcategoria.val() == 0){
			retorno.html('Selecione a categoria!');
			idcategoria.addClass('erro').focus();
			return false;
		} else {
			idcategoria.removeClass('erro');
		}
		if(titulo.val() == ''){
			retorno.html('Preencha o título!');
			titulo.addClass('erro').focus();
			return false;
		} else {
			titulo.removeClass('erro');
		}
		if(breve.val() == ''){
			retorno.html('Preencha uma breve descrição!');
			breve.addClass('erro').focus();
			return false;
		} else {
			breve.removeClass('erro');
		}
		if(descricao == ''){
			retorno.html('Preencha a descrição!');
			return false;
		}
		/*
		if(acao == 'adicionar'){
			if(imagem.val() == ''){
				retorno.html('Selecione a imagem!');
				imagem.addClass('erro').focus();
				return false;
			} else {
				imagem.removeClass('erro');
			}
		}
		*/
	});
	
	/* instituto */
	$('#form-instituto').submit(function(){
		var titulo = $('#titulo'),
			descricao = CKEDITOR.instances['descricao'].getData();

		if(titulo.val() == ''){
			retorno.html('Preencha o título!');
			titulo.addClass('erro').focus();
			return false;
		} else {
			titulo.removeClass('erro');
		}
		if(descricao == ''){
			retorno.html('Preencha a descrição!');
			return false;
		}
	});
	
	/* locais */
	$('#form-locais').submit(function(){
		var titulo = $('#titulo'),
			endereco = $('#endereco'),
			telefone = $('#telefone');
		
		if(titulo.val() == ''){
			retorno.html('Preencha o título!');
			titulo.addClass('erro').focus();
			return false;
		} else {
			titulo.removeClass('erro');
		}
		if(endereco.val() == ''){
			retorno.html('Preencha o endereço!');
			endereco.addClass('erro').focus();
			return false;
		} else {
			endereco.removeClass('erro');
		}
		if(telefone.val() == ''){
			retorno.html('Preencha o telefone!');
			telefone.addClass('erro').focus();
			return false;
		} else {
			telefone.removeClass('erro');
		}
	});
	
	/* representantes */
	$('#form-representantes').submit(function(){
		var razao_social = $('#razao_social'),
			contato = $('#contato'),
			email = $('#email'),
			telefone = $('#telefone'),
			celular = $('#celular'),
			area = $('#area'),
			endereco = $('#endereco'),
			pais = $('#pais'),
			cidade = $('#cidade'),
			estado = $('#estado'),
			cep = $('#cep');

		/*
		if(titulo.val() == ''){
			retorno.html('Preencha o título!');
			titulo.addClass('erro').focus();
			return false;
		} else {
			titulo.removeClass('erro');
		}
		if(email.val() == ''){
			retorno.html('Preencha o e-mail!');
			email.addClass('erro').focus();
			return false;
		} else {
			email.removeClass('erro');
		}
		if(telefone.val() == ''){
			retorno.html('Preencha o telefone!');
			telefone.addClass('erro').focus();
			return false;
		} else {
			telefone.removeClass('erro');
		}
		if(endereco.val() == ''){
			retorno.html('Preencha o endereço!');
			endereco.addClass('erro').focus();
			return false;
		} else {
			endereco.removeClass('erro');
		}
		if(pais.val() == 0){
			retorno.html('Selecione o país!');
			pais.addClass('erro').focus();
			return false;
		} else {
			pais.removeClass('erro');
		}
		*/
		
		if(razao_social.val() == ''){
			retorno.html('Preencha a razão social!');
			razao_social.addClass('erro').focus();
			return false;
		} else {
			razao_social.removeClass('erro');
		}
		if(contato.val() == ''){
			retorno.html('Preencha a pessoa de contato!');
			contato.addClass('erro').focus();
			return false;
		} else {
			contato.removeClass('erro');
		}
		if(email.val() == ''){
			retorno.html('Preencha o e-mail!');
			email.addClass('erro').focus();
			return false;
		} else {
			email.removeClass('erro');
		}
		if(telefone.val() == ''){
			retorno.html('Preencha o telefone!');
			telefone.addClass('erro').focus();
			return false;
		} else {
			telefone.removeClass('erro');
		}
		if(endereco.val() == ''){
			retorno.html('Preencha o endereço!');
			endereco.addClass('erro').focus();
			return false;
		} else {
			endereco.removeClass('erro');
		}
		if(pais.val() == 0){
			retorno.html('Selecione o país!');
			pais.addClass('erro').focus();
			return false;
		} else {
			pais.removeClass('erro');
		}
		if(cidade.val() == ''){
			retorno.html('Preencha a cidade!');
			cidade.addClass('erro').focus();
			return false;
		} else {
			cidade.removeClass('erro');
		}
		/*
		if(estado.val() == 0){
			retorno.html('Selecione o estado!');
			estado.addClass('erro').focus();
			return false;
		} else {
			estado.removeClass('erro');
		}
		*/
		if(cep.val() == ''){
			retorno.html('Preencha o cep!');
			cep.addClass('erro').focus();
			return false;
		} else {
			cep.removeClass('erro');
		}

	});

	/* portais */
	$('#form-portais').submit(function(){
		var titulo = $('#titulo'),
			icone = $('#icone'),
			url = $('#url'),
			arquivo = $('#arquivo'),
			antigo = $('#antigo'),
			tipoLink = $(this.tipoLink).filter(':checked');

		if($('input[name=idioma]').is(':checked') == false){
			retorno.html('Selecione o idioma!');
			return false;
		}

		if (titulo.val() == ''){
			retorno.html('Preencha o título!');
			titulo.addClass('erro').focus();
			return false;
		} else {
			titulo.removeClass('erro');
		}
		if (acao == 'adicionar'){
			if(icone.val() == ''){
				retorno.html('Selecione o ícone!');
				icone.addClass('erro').focus();
				return false;
			} else {
				icone.removeClass('erro');
			}
		}
		if (tipoLink.val() == 'link'){
			if (url.val() == '' || url.val() == 'http://'){
				retorno.html('Preencha a url!');
				url.addClass('erro').focus();
				return false;
			} else {
				url.removeClass('erro');
			}
		} else {
			if (arquivo.val() == '' && antigo.val() == ''){
				retorno.html('Selecione um arquivo!');
				arquivo.addClass('erro').focus();
				return false;
			} else {
				arquivo.removeClass('erro');
			}
		}
	});
	
	/* simposio */
	$('#form-simposio').submit(function(){
		var titulo = $('#titulo'),
			descricao = CKEDITOR.instances['descricao'].getData();

		if(titulo.val() == ''){
			retorno.html('Preencha o título!');
			titulo.addClass('erro').focus();
			return false;
		} else {
			titulo.removeClass('erro');
		}
		if(descricao == ''){
			retorno.html('Preencha a descrição!');
			return false;
		}
	});

	/* simposio galerias */
	$('#form-simposio-galerias').submit(function(){
		var titulo = $('#titulo');

		if(titulo.val() == ''){
			retorno.html('Preencha o título!');
			titulo.addClass('erro').focus();
			return false;
		} else {
			titulo.removeClass('erro');
		}
	});
	
	/* revistas */
	$('#form-revistas').submit(function(){
		var titulo = $('#titulo'),
			imagem = $('#imagem');

		if($('input[name=idioma]').is(':checked') == false){
			retorno.html('Selecione o idioma!');
			return false;
		}

		if(titulo.val() == ''){
			retorno.html('Preencha o título!');
			titulo.addClass('erro').focus();
			return false;
		} else {
			titulo.removeClass('erro');
		}
		if(acao == 'adicionar'){
			if(imagem.val() == ''){
				retorno.html('Selecione uma imagem!');
				imagem.addClass('erro').focus();
				return false;
			} else {
				imagem.removeClass('erro');
			}
		}
	});
	
	/* relatorio de sustentabilidade */
	$('#form-relatorios').submit(function(){
		var titulo = $('#titulo'),
			imagem = $('#imagem');

		if($('input[name=idioma]').is(':checked') == false){
			retorno.html('Selecione o idioma!');
			return false;
		}

		if(titulo.val() == ''){
			retorno.html('Preencha o título!');
			titulo.addClass('erro').focus();
			return false;
		} else {
			titulo.removeClass('erro');
		}
		if(acao == 'adicionar'){
			if(imagem.val() == ''){
				retorno.html('Selecione uma imagem!');
				imagem.addClass('erro').focus();
				return false;
			} else {
				imagem.removeClass('erro');
			}
		}
	});

	$('#form-faq').submit(function(){
		var pergunta = $('#pergunta'),
			resposta = CKEDITOR.instances['resposta'].getData();

		if (pergunta.val() == ''){
			retorno.html('Preencha a pergunta!');
			pergunta.addClass('erro').focus();
			return false;
		} else {
			pergunta.removeClass('erro');
		}
		if (resposta == ''){
			retorno.html('Preencha a resposta!');
			return false;
		}
	});
});

var retorno = '';
function validaEmailUsuario(email,idusuario){
	var data = { email : email, idusuario : idusuario };
	var url = http + 'sistema/ajax.php?acao=email-usuario';
	$.ajax({ url:url, type:'POST', data:data, cache:false, async:false, dataType:'script', success:function(response){
		retorno = response;
	}});

	return retorno;
}
