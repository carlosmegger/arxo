var $estados = {
	AC:'Acre',
	AL:'Alagoas',
	AM:'Amazonas',
	AP:'Amapá',
	BA:'Bahia',
	CE:'Ceará',
	DF:'Distrito Federal',
	ES:'Espírito Santo',
	GO:'Goiás',
	MA:'Maranhão',
	MT:'Mato Grosso',
	MS:'Mato Grosso do Sul',
	MG:'Minas Gerais',
	PA:'Pará',
	PB:'Paraíba',
	PR:'Paraná',
	PE:'Pernambuco',
	PI:'Piauí',
	RJ:'Rio de Janeiro',
	RN:'Rio Grande do Norte',
	RS:'Rio Grande do Sul',
	RO:'Rondônia',
	RR:'Roraima',
	SC:'Santa Catarina',
	SP:'São Paulo',
	SE:'Sergipe',
	TO:'Tocantins'
}
$("#mapa_america")[0].onload = function(){
	$(this).css('visibility','visible');
}
window.onload = function(){
	$.getJSON('lista_representantes',function(json){
		window.$representantes = json;
	});

	var mapa_mobile = $('#mapa_america');
	var SVGDoc_mobile = mapa_mobile[0].contentDocument;
	var SVGRoot_mobile = SVGDoc_mobile.documentElement;
	window.$paisesMobile = $(SVGRoot_mobile).find('path');
	$paisesMobile.on('click',function(){
		if (typeof($representantes[this.id]) != 'undefined'){
			carregarJanela(this.id);
		}
	});
}
function carregarJanela(pais){
	var janela = $("#popup");

	if(janela.length == 0){
		janela = $("<div id='popup'/>");
		var fechar = $("<div id='fechar_popup'/>");
		var titulo = $("<div id='titulo_popup'/>");
		var conteudo = $("<div id='conteudo_popup'/>");
		janela.append(fechar,titulo,conteudo);
		$("#container_mapa").append(janela);
		janela.on('click','#fechar_popup',function(){
			$(this).parent().fadeOut(function(){
				$(this).remove();
			});
		});

		if (pais == 'BR'){
			var filtro = $("<div id='filtro_popup' />");
			var select = $("<select />");
			select.append('<option value="">Selecione um estado</option>');

			for (var uf in $estados){
				select.append('<option value="'+uf+'">'+$estados[uf]+'</option>');
			}
			select.change(function(){
				selecionarEstado(this.value);
			});
			filtro.append(select);
			var lista = $("<div id='lista_popup' />");
			var rep;

			janela.find('#titulo_popup').html('Selecione o estado desejado:');
			janela.find('#conteudo_popup').append(filtro,lista);
		} else {
			var content = '';
			var rep;

			for(var x in $representantes[pais]){
				rep = $representantes[pais][x];

				content += '<div class="item-rep">';
				content += '<strong>'+ rep.razao_social +'</strong><br>';
				for(var y in rep){
					if(!rep[y] || y == 'razao_social' || y == 'slug' || y == 'id') continue;
					content += rep[y] + '<br />';
				}
				content += '</div>';
			}

			janela.find('#titulo_popup').html($paisesMobile.filter('#'+pais).attr('title'));
			janela.find('#conteudo_popup').html(content);
		}
	}
}

function selecionarEstado(estado){
	var content = '';
	for(var x in $representantes.BR[estado]){
		rep = $representantes.BR[estado][x];

		content += '<div class="item-rep">';
		content += '<strong>Representação:</strong> '+ rep.razao_social +'<br />';
		if(rep.contato != null) content += '<strong>Contato: </strong> '+ rep.contato +'<br />';
		if(rep.area != null) content += '<strong>Área: </strong> '+ rep.area +'<br />';
		if(rep.telefone != null) content += '<strong>Telefone: </strong> '+ rep.telefone +'<br />';
		if(rep.celular != null) content += '<strong>Celular: </strong> '+ rep.celular +'<br />';
		if(rep.email != null) content += '<strong>E-mail: </strong> '+ rep.email +'<br />';

		content += '<a href="'+ http +'representantes/'+ rep.id +'/'+ rep.slug +'/" class="mais-infos">Mais Informações</a>';
		content += '</div>';
	}

	$('#lista_popup').html(content);
}
