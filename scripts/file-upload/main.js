$(function(){
    'use strict';

	//categorias
	$('#fileupload-categorias').fileupload({
		url : http + 'sistema/ajax.php?acao=categorias-imgs',
		sequentialUploads : true,
		stop : function(e,data){
			var idcategoria = $('#idcategoria').val(),
				tipo = $('#tipo').val();

			if(confirm('Deseja recortar as imagens recém enviadas?')){
				window.location = 'categorias-imgs.php?acao=crop&idcategoria='+idcategoria+'&tipo='+tipo;
			}
		}
	});

	//produtos
	$('#fileupload-produtos').fileupload({
		url : http + 'sistema/ajax.php?acao=produtos-imgs',
		sequentialUploads : true,
		stop : function(e,data){
			var idproduto = $('#idproduto').val();
			if(confirm('Deseja recortar as imagens recém enviadas?')){
				window.location = 'produtos-imgs.php?acao=crop&idproduto='+idproduto;
			}
		}
	});

	//noticias
	$('#fileupload-noticias').fileupload({
		url : http + 'sistema/ajax.php?acao=noticias-imgs',
		sequentialUploads : true,
		stop : function(e,data){
			var idnoticia = $('#idnoticia').val();
			if(confirm('Deseja recortar as imagens recém enviadas?')){
				window.location = 'noticias-imgs.php?acao=crop&idnoticia='+idnoticia;
			}
		}
	});

	//instituto
	$('#fileupload-instituto').fileupload({
		url : http + 'sistema/ajax.php?acao=instituto-galeria',
		sequentialUploads : true,
		stop : function(e,data){
			if(confirm('Deseja recortar as imagens recém enviadas?')){
				window.location = 'instituto-galeria.php?acao=crop';
			}
		}
	});

	//instituto
	$('#fileupload-comunicacao').fileupload({
		url : http + 'sistema/ajax.php?acao=comunicacao-galeria',
		sequentialUploads : true,
		stop : function(e,data){
			if(confirm('Deseja recortar as imagens recém enviadas?')){
				window.location = 'comunicacao-galeria.php?acao=crop';
			}
		}
	});

	//simpósio galerias
	$('#fileupload-simposio').fileupload({
		url : http + 'sistema/ajax.php?acao=simposio-imgs',
		sequentialUploads : true,
		stop : function(e,data){
			var idgaleria = $('#idgaleria').val();
			if(confirm('Deseja recortar as imagens recém enviadas?')){
				window.location = 'simposio-imgs.php?acao=crop&idgaleria='+idgaleria;
			}
		}
	});

	//revistas
	$('#fileupload-revistas').fileupload({
		url : http + 'sistema/ajax.php?acao=revistas-imgs',
		sequentialUploads : true,
		stop : function(e,data){
			var idrevista = $('#idrevista').val();
			if(confirm('Deseja listar as imagens recém enviadas?')){
				//window.location = 'revistas-imgs.php?acao=crop&idrevista='+idrevista;
				window.location = 'revistas-imgs.php?acao=listar&idrevista='+idrevista;
			}
		}
	});
	
	//relatorio sustentabilidade
	$('#fileupload-relatorios').fileupload({
		url : http + 'sistema/ajax.php?acao=relatorios-imgs',
		sequentialUploads : true,
		stop : function(e,data){
			var idrelatorio = $('#idrelatorio').val();
			if(confirm('Deseja recortar as imagens recém enviadas?')){
				window.location = 'relatorios-imgs.php?acao=crop&idrelatorio='+idrelatorio;
			}
		}
	});

});
