var filiais = [
	{
		lat:-26.775904,
		lng:-48.685688,
		cidade: 'Balneário Piçarras',
		estado: 'Santa Catarina, Brasil',
		titulo: 'Matriz',
		telefone: '+55 47 2104.6700',
		fax: '+55 47 2104.6717',
		endereco: 'Rod. BR 101 | Km 100,4',
		bairro: 'Nossa Senhora Conceição',
		cep: 'CEP: 88380-000'
	},
	{
		lat:-8.114640,
		lng:-35.248523,
	    cidade: 'Vitória de Santo Antão',
	    estado: 'Pernambuco | Brasil',
	    titulo: 'Filial Industrial',
	    telefone: '+55 81 3145.9300',
	    fax: '',
	    endereco: 'Rod. Luiz Gonzaga, S/N, BR 232',
	    bairro: 'Distrito Ind. José Augusto Ferrer',
	    cep: 'CEP: 55613-010'
	},
	{
		lat:-23.4191675,
		lng:-46.8242699,
	    cidade: 'Cajamar',
	    estado: 'São Paulo | Brasil',
	    titulo: 'Filial Comercial',
	    telefone: '+55 11 5508.6525',
	    fax: '',
	    endereco: 'Rua Cordeirópolis, 37',
	    bairro: 'Jardim Paraiso',
	    cep: 'CEP: 07794-100'
	},
	{
		lat:-25.3174755,
		lng:-54.6913351,
	    cidade: 'Alto Paraná',
	    estado: 'Paraguai',
	    titulo: 'Filial Industrial',
	    telefone: '595 21 620.7836',
	    fax: '',
	    endereco: 'Super Carretera, KM 5,5 - Hernandarias'
	}
];
function initMap(){
	var geocoder = new google.maps.Geocoder();
	var latlng = new google.maps.LatLng(-16.262343, -60.166433);

	var opcoes = {
		zoom: 4,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
    }

	var map = new google.maps.Map($("#mapa")[0],opcoes);

	var filial,
		markers = [],
		marker = null;
	window.$openedWindow = null;
	for (var index in filiais){
		filial = filiais[index];

		marker = new google.maps.Marker({
			map: map,
			position: new google.maps.LatLng(filial.lat,filial.lng),
			title: filial.titulo,
			index: index
		});
		markers.push(marker);
	}
	$(markers).each(function(){
		google.maps.event.addListener(this, 'click', function() {
			if ($openedWindow != null) {
				$openedWindow.close();
				$openedWindow = null;
			}
			var info = new google.maps.InfoWindow();
			var data = filiais[this.index];
			var html = ['<strong>'+data.titulo+'</strong>'];
			if (!!data.endereco){
				html.push(data.endereco);
			}
			if (!!data.bairro && !!data.cidade){
				html.push(data.bairro+', '+data.cidade);
			} else if (!!data.bairro){
				html.push(data.bairro);
			} else if (!!data.cidade){
				html.push(data.cidade);
			}
			if (!!data.estado){
				html.push(data.estado);
			}
			if (!!data.cep){
				html.push('CEP: '+data.cep);
			}
			if (!!data.telefone){
				html.push(data.telefone);
			}
			if (!!data.fax){
				html.push('Fax: '+data.fax);
			}
			html = html.join('<br>');

			info.setContent(html);
			info.open(map, this);
			map.setCenter(this.position);
			map.setZoom(16);
			google.maps.event.trigger(map, 'resize');
			$openedWindow = info;
			google.maps.event.addListener(info,'closeclick',function(){
				$openedWindow = null;
				map.setZoom(4);
			});
		});
	});
}
$(function(){
	$.getScript('http://maps.google.com/maps/api/js?sensor=false&region=BR&language=pt-BR&callback=initMap');
});