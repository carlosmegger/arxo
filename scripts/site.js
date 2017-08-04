$(function(){
	var $window = $(window);

	$('.responsivo').picture();

	/* --- navegacao */
	$('.menu').on('mouseenter mouseleave',function(e){
		if(e.type == 'mouseenter'){
			$(this).children('.submenu').stop().slideDown();
		} else {
			$(this).children('.submenu').stop().slideUp();
		}
	});
	$('.submenu').each(function(){
		var t = $(this);
		if (t.parent().hasClass('contato')) return;
		var width = t.outerWidth();
		var pWidth = t.parent().outerWidth();
		t.css('right',(pWidth-width)/2);
	});

	function redirectPage(){
		window.location = linkLocation;
	}

	/* --- */

	$("#lupa").click(function(){
		$("#form_busca").toggleClass('visible');
	});

	$('.fancybox').fancybox({
		helpers:{
			title:{
				type:'inside'
			}
		}
	});
	$('.fancybox-revista').fancybox({ minWidth : ($(window).width()-80), maxWidth:1500 });

	$('#idioma').change(function(){
		window.location = http + $(this).val() +'/';
	});

	if (page != 'index'){
		$('#menu-mobile').val(page+'/');
	}
	$('nav').find('.'+page).addClass('ativo');

	$('#menu-mobile').change(function(){
		var linkLocation = this.value;
		document.location.href = http+linkLocation;
	});
	if ($('#galeria').length > 0){
		initGaleria();
	}

	if(page == 'index'){

		/* banners */
		var settings = {
		    'fx' : 'fadeout',
		    'timeout' : 4000,
		    'speed' : 750,
		    'slides' : "> figure",
		    'pagerTemplate' : "<span></span>",
		    'pager' : "#banner-nav",
		    'autoHeight' : "2000:450",
		    'loader' : "wait",
		    'log' : false,
	    	'centerVert' : true,
		    'pauseOnHover' : true
		};
		$('#banner').cycle(settings);

		/* postagens */
		var url = 'http://www.arxo.com.br/blog/wp-json/wp/v2/posts?per_page=2';
		$.ajax({ url:url, type:'GET', cache:false, async:false, dataType:'json', success:function(response){

			var qtd_itens = countJson(response),
				lista = $('#postagens .lista'),
				html = '';

			if(qtd_itens > 0){

				for(var i = 0; i < qtd_itens; i++){
					var id = response[i].id,
						titulo = response[i].title.rendered,
						link = response[i].link,
						imagem = getIMGPost(id), //abaixo
						desc = response[i].excerpt.rendered,
						desc = strip_tags(desc,'<a>'),
						desc = $.trim(desc);

					html += '<div>';
					html += '	<figure><a href="'+ link +'" target="_blank"><img src="'+ imagem +'" alt="'+ titulo +'" /></a></figure>';
					html += '	<div>';
					html += '		<h2><a href="'+ link +'" target="_blank">'+ titulo +'</a></h2>';
					html += '		<p><a href="'+ link +'" target="_blank">'+ desc +'</a></p>';
					html += '	</div>';
					html += '</div>';
				}

				lista.html(html);

			} else {
				lista.html('<p>Nenhuma novidade para exibir!</p>');
			}
		}});

		function getIMGPost(id){
			var url = 'http://www.arxo.com/blog/wp-json/wp/v2/media?per_page=1&parent='+id,
				imagem = '';

			$.ajax({ url:url, type:'GET', cache:false, async:false, dataType:'json', success:function(response){
				var qtd_itens = countJson(response);
				if(qtd_itens > 0){
					for(var i = 0; i < qtd_itens; i++){
						imagem = response[i].media_details.sizes.medium.source_url;
					}
				}
			}});
			return imagem;
		}

		$('a.more-link').click(function(evt){
			evt.preventDefault();
			window.open($(this).attr('href'));
		});

	} else if (page == 'institucional'){

		/* linha tempo */
		$('#evento_linha').cycle({ log:false, paused:true, slides:'> div' });
		$('#linha-tempo').on('click','span',function(){
			$('#evento_linha').cycle('goto',$(this).index());
			$(this).addClass('ativo').siblings('.ativo').removeClass('ativo');
		}).children().first().addClass('ativo');
		$('#evento_linha').cycle({ slides:'> div' });

		/* clientes */
		$('#lista-clientes').cycle({ log:false, paused:true, slides:' > span.item', pager:'> .navegacao' });
		
		//video
		$('#empresa').fitVids();

	} else if (page == 'marcas'){

		$('a.video').click(function(evt){
			evt.preventDefault();

			$.fancybox({
				'padding' : 0,
				'autoScale' : false,
				'transitionIn' : 'none',
				'transitionOut' : 'none',
				'closeBtn' : false,
				'width' : 680,
				'height' : 495,
				'href' : this.href.replace(new RegExp("watch\\?v=","i"),'v/'),
				'type' : 'swf',
				'swf' : { 'allowfullscreen':'true' },

				'afterLoad' : function(){
					setTimeout(function(){
						$('.fancybox-inner').css({ 'padding-bottom':0 });
						$('.fancybox-inner embed').css({ 'border-radius':'4px' });
					},0);
				}
			});
			return false;
		});

	} else if (page == 'opcoes-financiamento'){
		$('#lista-faq').on('click','.pergunta',function(){
			$(this).parent().toggleClass('aberta');
			$(this).next().slideToggle();
		});
	} else if (page == 'trabalhe-conosco'){
		
		$(':file').change(function(e){
			if (window.File && window.FileReader){
				var files = e.target.files;
				$("#label-curriculo").html(files[0].name);
			} else {
				$("#label-curriculo").hide();
				$("#curriculo").css('opacity',1);
			}
		});

	}
	else if (page == 'fale-conosco'){
		
		$("#estado").change(function(){
			var idestado = $(this).find('option:selected').data('idestado');
			$.getJSON('ajax/ajax.php?acao=cidades',{id:idestado},function(cidades){
				$("#cidade").children(":not(:first)").remove();
				for (x in cidades){
					$("#cidade").append("<option value='"+cidades[x]+"'>"+cidades[x]+"</option>");
				}
			});
		});

	}
	else if (page == 'produtos'){
		
		if(categoria != ''){
			$('#menu-mobile').val(categoria+'/');
		}

		//botão orçamento - mobile
		$('#produto .botao-orcamento a').click(function(evt){
			evt.preventDefault();
			var topo = $('#produto').find('.orcamento').offset().top;			
			ancora(topo);
		});

		//botão orçamento - desktop
		$('.orcamento-suspenso a').click(function(evt){
			evt.preventDefault();
			var topo = $('#produto').find('.orcamento').offset().top;
			ancora(topo);
		});

		$(window).scroll(function(){
			if($(window).width() >= 1280 && idproduto != 0){

				var topo = $('#produto').find('.orcamento').position().top;
				if($(document).scrollTop() > (topo - 150)){
					$('.orcamento-suspenso').fadeOut();
				} else {
					$('.orcamento-suspenso').fadeIn();
				}
				
			} else {
				$('.orcamento-suspenso').hide();
			}
		});

	}
});

$(window).load(function(){
	var $window = $(window),
		$document = $(document);

	if (!!hash){
		$('html,body').animate({scrollTop:$("#"+hash).offset().top},500);
	}

	if(page == 'index'){

		/* popup */
		//setItem
		/*
		if(popup !== null && sessionStorage.popup !== 'true'){
			$.fancybox({
				'type' : 'image',
				'href' : popup.imagem,
				'beforeShow' : function(){
					var blank = (popup.blank == 'S') ? ' target="_blank"' : '';
					$('.fancybox-image').wrap('<a href="'+ popup.url +'"'+ blank +' />');
				}
			});
			sessionStorage.popup = 'true';
		}
		*/

		if(popup !== null){
			$.fancybox({
				'type' : 'image',
				'href' : popup.imagem,
				'beforeShow' : function(){
					var blank = (popup.blank == 'S') ? ' target="_blank"' : '';
					$('.fancybox-image').wrap('<a href="'+ popup.url +'"'+ blank +' />');
				}
			});
		}
	}

	if(page == 'marcas'){

		function setasMarcas(){
			var windowsize = $window.width();

			if(windowsize >= 800){

				var detalheW = $('#marcas .marca .detalhe').outerWidth(),
					detalheH = $('#marcas .marca .detalhe').outerHeight(),
					calculo = (($window.width()-detalheW)/2);

				//altura
				$('#marcas .marca a.seta').height(detalheH);

				//posicionamento
				$('#marcas .marca a.anterior').css({ 'left':(calculo-120) });
				$('#marcas .marca a.proxima').css({ 'right':(calculo-120) });

			} else {
				$('#marcas .marca a.seta').removeAttr('style');
			}
		}

		setasMarcas();
		$(window).resize(setasMarcas);
	}

});

$.fn.preload = function(){
	this.each(function(){
		$('<img />')[0].src = this;
	});
}

function carregaMapa(latitude,longitude,local){
	var myLatlng = new google.maps.LatLng(latitude,longitude);
	var myOptions = {
		zoom : 16,
		center : myLatlng,
		mapTypeId : google.maps.MapTypeId.ROADMAP,
		scrollwheel: false,
  		disableDoubleClickZoom: true
	}
	map = new google.maps.Map(local,myOptions);

	marker = new google.maps.Marker({
		position : myLatlng,
		map : map,
		clickable : true
	});

	google.maps.event.addDomListener(window,'resize',function(){
		map.setCenter(myLatlng);
	});

	marker.setMap(map);
	google.maps.event.trigger(marker,'click');
}

function ancora(valor){
	$('html,body').animate({ scrollTop:valor },1000);
}

function initGaleria(){
	window.$galeria = {
		self:$('#galeria'),
		index:0,
		thumbs: $("#miniaturas"),
		prev: $('.anterior'),
		next: $('.proxima')
	}
	$galeria.imgs = $galeria.thumbs.children();
	$galeria.total = $galeria.imgs.length;
	$galeria.prev.click(function(){
		if ($galeria.index <= 0) return;
		//var left = $galeria.imgs.eq($galeria.index-1).width();
		var left = -293 * ($galeria.index-1);
		//$galeria.thumbs.css('left','+='+left+'px');
		$galeria.thumbs.css('left',left);
		$galeria.next.show();
		if ($galeria.index <= 1){
			$galeria.prev.hide();
		}
		$galeria.index--;
	}).hide();
	$galeria.next.click(function(){
		if ($galeria.index >= $galeria.total-1) return;
		//var left = $galeria.imgs.eq($galeria.index).width();
		var left = -293 * ($galeria.index+1);
		//$galeria.thumbs.css('left','-='+left+'px');
		$galeria.thumbs.css('left',left);
		if ($galeria.total-1 <= $galeria.index+1){
			$galeria.next.hide();
		}
		$galeria.prev.show();
		$galeria.index++;
	}).hide();
	$(window).resize(function(){
		var width = $galeria.self.innerWidth();
		if ($galeria.thumbs.width() <= width){
			$galeria.prev.hide();
			$galeria.next.hide();
		} else {
			if ($galeria.index > 0){
				$galeria.prev.show();
			}
			if ($galeria.total-1 > $galeria.index){
				$galeria.next.show();
			}
		}
	}).resize();
}