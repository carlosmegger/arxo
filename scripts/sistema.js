$(function(){

	/* --- editor */
	CKFinder.setupCKEditor(null,http + 'sistema/ckfinder/');
	
	/* --- mascara */
	$('#data').mask('99/99/9999',{ placeholder : ' ' });
	$('#cep').mask('99999-999',{ placeholder : ' ' });

	/* --- fancybox */
	$('.fancybox').fancybox();

	/* --- ajax */
	var carregando = $('#carregando');
	carregando.ajaxStart(function(){
		$(this).show();
	});
	carregando.ajaxStop(function(){
		$(this).delay(800).fadeOut();
	});

	/* --- atualizado com sucesso */
	if(atualizado == true) $('#atualizado').delay(1500).fadeOut();

	/* --- sortable */
	$('#sortable').sortable({
		beforeStop : function(event,ui){
			atualizaPosicao();
		},
		placeholder : 'ui-state-highlight',
		forcePlaceholderSize : true,
		cancel : '.principal'
	});
	function atualizaPosicao(){
		var posicoes = '',
			tabela = $('#tabela').val(),
			campo = $('#campo').val(),
			tipo = $('#tipo').val(),
			tipo = (tipo != undefined) ? tipo : '',
			idproduto = $('#idproduto').val(),
			idproduto = (idproduto != undefined) ? idproduto : '';

		$('div.posiciona').each(function(){
			posicoes += $(this).attr('data-id')+';';
		});

		var url = 'ajax.php?acao=posiciona&posicoes='+ posicoes +'&tabela='+ tabela +'&campo='+ campo +'&tipo='+ tipo +'&idproduto='+ idproduto;
		$.ajax({ url:url, type:'GET', async:false, cache:false });
	}

	/* --- ativo */
	$('img.ativo').click(function(){
		var tthis = $(this),
			src = tthis.attr('src').split('-').pop(),
			src = src.split('.').shift(),
			check = (src == 'on') ? 'N' : 'S',
			img = (src == 'on') ? 'off' : 'on',

			dados = tthis.attr('longdesc').split('-'),
			tabela = dados[0],
			id = dados[1],
			campo = dados[2];

		var url = "ajax.php?acao=ativo&check="+ check +"&id=" + id + "&tabela=" + tabela + "&campo=" + campo + "&page=" + page;
		$.ajax({ url:url, type: "GET", cache: false, success: function(response){
			if(response == 'ok'){
				tthis.attr('src','../img/sistema/ico-ativo-' + img + '.png');
			}
		}});
	});

	/* --- exibir */
	$('img.exibir').click(function(){
		var tthis = $(this),
			src = tthis.attr('src').split('-').pop(),
			src = src.split('.').shift(),
			check = (src == 'on') ? 'N' : 'S',
			img = (src == 'on') ? 'off' : 'on',

			dados = tthis.attr('longdesc').split('-'),
			tabela = dados[0],
			valor = dados[1],
			campo = dados[2];

		var url = "ajax.php?acao=exibir&check="+ check +"&valor=" + valor + "&tabela=" + tabela + "&campo=" + campo + "&page=" + page;
		//console.log(url);
		//return false;		

		$.ajax({ url:url, type:'GET', cache: false, success: function(response){
			if(response == 'ok'){
				tthis.attr('src','../img/sistema/ico-ativo-'+ img +'.png');
			}
		}});
	});

	/* --- destaque + destaque único */
	$('img.destaque').click(function(){
		var tthis = $(this),
			src = tthis.attr('src').split('-').pop(),
			src = src.split('.').shift(),
			check = (src == 'on') ? 'N' : 'S',
			img = (src == 'on') ? 'off' : 'on',

			dados = tthis.attr('longdesc').split('-'),
			tabela = dados[0],
			id = dados[1],
			campo = dados[2],
			secao = dados[3];

		// servicos
		if(img == 'on' && $(this).hasClass('icone-N')){
			alert('Para setar um serviço como destaque antes é necessário enviar um ícone (png transparente) de destaque!');
			return false;
		}

		var url = "ajax.php?acao=destaque&check="+ check +"&id="+ id +"&tabela="+ tabela +"&campo="+ campo;
		$.ajax({ url:url, type: "GET", cache: false, success: function(response){
			if(response == 'ok'){
				$('img.destaque.'+secao).attr('src','../img/sistema/ico-ativo-off.png');
				tthis.attr('src','../img/sistema/ico-ativo-' + img + '.png');
			}
		}});
	});
	$('img.destaque-unico').click(function(){
		var tthis = $(this),
			src = tthis.attr('src').split('-').pop(),
			src = src.split('.').shift(),
			check = (src == 'on') ? 'N' : 'S',
			img = (src == 'on') ? 'off' : 'on',

			dados = tthis.attr('longdesc').split('-'),
			tabela = dados[0],
			id = dados[1],
			campo = dados[2],
			idgaleria = dados[3],
			idgaleria = (idgaleria != undefined) ? idgaleria : '';

		if(img == 'on'){
			var url = "ajax.php?acao=destaque-unico&check="+ check +"&id="+ id +"&tabela="+ tabela +"&campo="+ campo +"&idgaleria="+ idgaleria;
			$.ajax({ url:url, type:'GET', cache:false, success:function(response){
				if(response == 'ok'){
					$('img.destaque-unico').attr('src','../img/sistema/ico-ativo-off.png');
					tthis.attr('src','../img/sistema/ico-ativo-' + img + '.png');
				}
			}});
		}
	});
	
	/* hexa */
	$('#hexadecimal,span.hexadecimal').colpick({
		layout : 'hex',
		submit : 0,
		onChange : function(hsb,hex,rgb,el,bySetColor){
			//$(el).css('border-color','#'+ hex);
			$('span.hexadecimal').css('background-color','#'+ hex);
			//if(!bySetColor) $(el).val(hex);
			if(!bySetColor) $('#hexadecimal').val('#'+hex);
		}
	}).keyup(function(){
		$(this).colpickSetColor(this.value);
	});

	/* fundos */
	$('input[name=copia_institucional]').change(function(){
		if($(this).is(':checked')){
			$('#form-fundos').find('.imagem').hide();
			$('#imagem').val('');
		} else {
			$('#form-fundos').find('.imagem').show();
			$('#imagem').val('');
		}
	});

	/* --- contatos - expande conteúdo */
	$('span.expande').click(function(){
		if(!$(this).parent().hasClass('abre')){
			$(this).parent().removeClass('fecha').addClass('abre').find('div.caixa-oculta').slideDown();
		} else {
			$(this).parent().removeClass('abre').addClass('fecha').find('div.caixa-oculta').slideUp();
		}
	});

	/* linha do tempo */
	if(page == 'linha-tempo'){
		var elem = $('span.quantidade');
		$('#texto').limiter(250,elem);	
	}
	
	/* simposio cadastro */
	$('a.simposio-status').click(function(evt){
		evt.preventDefault();
		var status = ($(this).data('status') == 'S') ? 'N' : 'S',
			url = 'ajax.php?acao=simposio-cadastro&status='+ status;

		$.ajax({ url:url, type:'GET', cache:false, success:function(response){
			window.location.href = page +'.php?atualizado=true';
		}});
	});
	
	/* produtos - remover imgs */
	$('a.remover-produto-tit').click(function(evt){
		evt.preventDefault();
		var _this = $(this), 
			idproduto = _this.data('idproduto'),
			img = _this.data('img'),
			url = 'ajax.php?acao=remover-produto-tit&idproduto='+idproduto+'&img='+img;

		$.ajax({ url:url, type:'GET', cache:false, success:function(response){
			if(response == 'ok') _this.parent().find('a').fadeOut();
		}});
	});

	$('a.remover-produto-banner').click(function(evt){
		evt.preventDefault();
		var _this = $(this), 
			idproduto = _this.data('idproduto'),
			img = _this.data('img'),
			url = 'ajax.php?acao=remover-produto-banner&idproduto='+idproduto+'&img='+img;

		$.ajax({ url:url, type:'GET', cache:false, success:function(response){
			if(response == 'ok') _this.parent().find('a').fadeOut();
		}});
	});

	/*
	if(page == 'produtos'){
		// --- produtos relacionados
		$('input[name=idioma]').click(function(evt){
			//evt.preventDefault();
			var _this = $(this),
				idioma = _this.val(),
				idproduto = $('.relacionados').data('idproduto'),
				selecionados = $('.relacionados').data('selecionados'),
				lista = $('.relacionados .lista');

			var url = 'ajax.php?acao=exibe-produtos-rel',
				data = { idioma : idioma, idproduto : idproduto, selecionados : selecionados };

			$.ajax({ url:url, type:'POST', data:data, async:false, cache:false, success:function(response){
				if(response != ''){
					lista.html(response);
				}
			}});
		});
	}
	*/

	/* --- filtrar produtos */
	$('#filtro-produtos').click(function(){
		filtroProdutos();
	});
	$('input[name=busca].produto').keydown(function(event){
		var code = event.which ? event.which : event.keyCode;
		if(code == 13) filtroProdutos();
	});

	function filtroProdutos(){
		var idioma = $('#idioma').val(),
			idcategoria = $('#idcategoria').val(),
			busca = $('#busca').val(),
			url = '';

		if(idioma != '') url += '&idioma='+idioma;
		if(idcategoria != 0) url += '&idcategoria='+idcategoria;
		if(busca != '') url += '&busca='+busca;
		window.location = page + '.php?filtro=true'+url;
	}

	/* --- filtrar contatos */
	$('#filtro-contatos,#filtro-curriculos').click(function(){
		filtroContatos();
	});
	$('input[name=busca].contato').keydown(function(event){
		var code = event.which ? event.which : event.keyCode;
		if(code == 13) filtroContatos();
	});
	
	function filtroContatos(){
		var idioma = $('#idioma').val(),
			busca = $('#busca').val(),
			url = '';

		if(idioma != '') url += '&idioma='+idioma;
		if(busca != '') url += '&busca='+busca;
		window.location = page + '.php?filtro=true'+url;
	}

	/* --- filtrar orcamentos */
	$('#filtro-orcamentos').click(function(){
		filtroOrcamentos();
	});
	$('input[name=busca].orcamento').keydown(function(event){
		var code = event.which ? event.which : event.keyCode;
		if(code == 13) filtroOrcamentos();
	});
	
	function filtroOrcamentos(){
		var idioma = $('#idioma').val(),
			idproduto = $('#idproduto').val(),
			busca = $('#busca').val(),
			url = '';

		if(idioma != 0) url += '&idioma='+idioma;
		if(idproduto != 0) url += '&idproduto='+idproduto;
		if(busca != '') url += '&busca='+busca;
		window.location = page + '.php?filtro=true'+url;
	}

	/* --- filtrar representantes */
	$('#filtro-representantes').click(function(){
		filtroRepresentantes();
	});
	$('input[name=busca].representantes').keydown(function(event){
		var code = event.which ? event.which : event.keyCode;
		if(code == 13) filtroRepresentantes();
	});

	function filtroRepresentantes(){
		var pais = $('#pais').val(),
			busca = $('#busca').val(),
			url = '';

		if(pais != 0) url += '&pais='+pais;
		if(busca != '') url += '&busca='+busca;
		window.location = page + '.php?filtro=true'+url;
	}
	
	/* seo */
	if($('#meta_titulo').size() > 0) $('#meta_titulo').limiter(100,$('.contador-tit span'),true);
	if($('#meta_descricao').size() > 0) $('#meta_descricao').limiter(160,$('.contador-desc span'),true);

	/* --- voltar ao topo */
	$('.voltar-topo').click(function(){
		$('html,body').animate({ scrollTop:0 },900);
	});

});

(function($){
	$.fn.extend({
		limiter : function(limit,elem){
            $(this).on('keyup focus',function(){
                setCount(this,elem);
            });
			function setCount(src,elem){
				var chars = src.value.length;
                if(chars > limit){
                    src.value = src.value.substr(0, limit);
                    chars = limit;
                }
                elem.html(limit - chars);
            }
            setCount($(this)[0],elem);
        }
    });
})(jQuery);

$(window).load(function(){

	/* seo */
	if(acao == 'adicionar' || acao == 'editar'){
		if(page == 'produtos'){
			var titulo_completo = $('#titulo_completo'),
				meta_titulo = $('#meta_titulo');
	
			if(meta_titulo.val() == ''){
				titulo_completo.blur(function(){
					meta_titulo.val(titulo_completo.val());
					meta_titulo.limiter(100,$('.contador-tit span'),false);
				});
			}
	
			var editor = CKEDITOR.instances.descricao,
				meta_descricao = $('#meta_descricao');
	
			if(meta_descricao.val() == ''){
				editor.on('blur',function(evt){
					var data = strip_tags(editor.getData()),
						data = data.replace(/\s+/g,' ').trim();
		
					meta_descricao.val(data);
					meta_descricao.limiter(160,$('.contador-desc span'),false);
				});
			}
		}
		else if(page == 'noticias'){
			var titulo = $('#titulo'),
				meta_titulo = $('#meta_titulo');
	
			if(meta_titulo.val() == ''){
				titulo.blur(function(){
					meta_titulo.val(titulo.val());
					meta_titulo.limiter(100,$('.contador-tit span'),false);
				});
			}
	
			var breve = $('#breve'),
				meta_descricao = $('#meta_descricao');
	
			if(meta_descricao.val() == ''){
				breve.blur(function(){
					var data = strip_tags(breve.val()),
						data = data.replace(/\s+/g,' ').trim();
		
					meta_descricao.val(data);
					meta_descricao.limiter(160,$('.contador-desc span'),false);
				});
			}
		}
	}

});

function isPosicao(posicao,anterior,id,campo,tabela){
	if(posicao != anterior){
		url = 'ajax.php?acao=posicao&posicao='+ posicao +'&id='+ id +'&campo='+ campo +'&tabela='+ tabela;
		$.ajax({ url:url, type:"GET", cache:false, success:function(response){
			if(response == "ok") window.location.reload();
		}});
	}
}
function validaMail(email) {
	var exclude=/[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
	var check=/@[\w\-]+\./;
	var checkend=/\.[a-zA-Z]{2,3}$/;
	if(((email.search(exclude) != -1)||(email.search(check)) == -1)||(email.search(checkend) == -1)){
		return false;
	} else {
		return true;
	}
}
function remover(id){
	if(confirm('Deseja realmente excluir este registro?')){
		window.location = page +'.php?acao=remover&id='+id;
	}
}
function removerCAT(id,tipo){
	if(confirm('Deseja realmente excluir esta categoria?')){
		window.location = page +'.php?acao=remover&id='+id+'&tipo='+tipo;
	}
}

function removerIMGC(id,idcategoria,tipo){
	if(confirm('Deseja realmente excluir esta categoria?')){
		window.location = 'categorias-imgs.php?acao=remover&id='+id+'&idcategoria='+idcategoria+'&tipo='+tipo;
	}
}
function removerIMGP(id,idproduto){
	if(confirm('Deseja realmente excluir esta categoria?')){
		window.location = 'produtos-imgs.php?acao=remover&id='+id+'&idproduto='+idproduto;
	}
}
function removerIMGR(id,idrevista){
	if(confirm('Deseja realmente excluir esta imagem?')){
		window.location = 'revistas-imgs.php?acao=remover&id='+id+'&idrevista='+idrevista;
	}
}

function removerIMGI(id){
	if(confirm('Deseja realmente excluir esta imagem?')){
		window.location = 'instituto-galeria.php?acao=remover&id='+id;
	}
}

function removerIMGCom(id){
	if(confirm('Deseja realmente excluir esta imagem?')){
		window.location = 'comunicacao-galeria.php?acao=remover&id='+id;
	}
}

function removerArq(id,idproduto){
	if(confirm('Deseja realmente excluir este arquivo?')){
		window.location = 'produtos-arqs.php?acao=remover&id='+id+'&idproduto='+idproduto;
	}
}


