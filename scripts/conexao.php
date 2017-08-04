<?
#caminhos
if($_SERVER['HTTPS'] == 'on'){
	$http = 'https://'.$_SERVER['HTTP_HOST'].'/';
} else {
	$http = 'http://'.$_SERVER['HTTP_HOST'].'/';
}

if($_SERVER['HTTP_HOST'] == 'clientes.dataprisma'){

	mysql_connect('localhost','dataprisma','prisma') or die ('Erro de conexao com o banco de dados: '.mysql_error());
	mysql_select_db('arxo_2015');
	mysql_query('SET CHARACTER SET utf8');

	$http .= 'arxo/';
	$prefixo = '2015_';

} else {

	mysql_connect('186.202.152.83','arxo10','o2x3r4ajxT1') or die ('Erro de conexao com o banco de dados: '.mysql_error());
	mysql_select_db('arxo10');
	mysql_query('SET CHARACTER SET utf8');

	#$http .= '2015/';
	$prefixo = '2015_';
}

define(CATEGORIAS,$prefixo.'categorias');
define(CATEGORIAS_IMGS,$prefixo.'categorias_imgs');
define(CERTIFICACOES,$prefixo.'certificacoes');
define(CHAMADAS,$prefixo.'chamadas');
define(CLIENTES,$prefixo.'clientes');
define(CONFIGS,$prefixo.'configs');
define(CONTATOS,$prefixo.'contatos');
define(CURRICULOS,$prefixo.'curriculos');
define(IDEOLOGIA,$prefixo.'ideologia');
define(INSTITUCIONAL,$prefixo.'institucional');
define(INSTITUTO,$prefixo.'instituto');
define(INSTITUTO_GAL,$prefixo.'instituto_galeria');
define(COMUNICACAO,$prefixo.'comunicacao');
define(COMUNICACAO_GAL,$prefixo.'comunicacao_galeria');
define(FINANCIAMENTO,$prefixo.'financiamento');
define(FAQ,$prefixo.'faq');
define(LINHA_TEMPO,$prefixo.'linha_tempo');
define(LOCAIS,$prefixo.'locais');
define(MARCAS,$prefixo.'marcas');
define(NOTICIAS,$prefixo.'noticias');
define(NOTICIAS_IMGS,$prefixo.'noticias_imgs');
define(ORCAMENTOS,$prefixo.'orcamentos');
define(ORCAMENTOS_PRODUTOS,$prefixo.'orcamentos_produtos');
define(PREMIOS_CERT,$prefixo.'premios_certificacoes');
define(POPUP,$prefixo.'popup');
define(PORTAIS,$prefixo.'portais');
define(PRODUTOS,$prefixo.'produtos');
define(PRODUTOS_IMGS,$prefixo.'produtos_imgs');
define(PRODUTOS_ARQS,$prefixo.'produtos_arqs');
define(PRODUTOS_REL,$prefixo.'produtos_rel');
define(REPRESENTANTES,$prefixo.'representantes');
define(RELATORIOS,$prefixo.'relatorios');
define(RELATORIOS_IMGS,$prefixo.'relatorios_imgs');
define(REVISTAS,$prefixo.'revistas');
define(REVISTAS_IMGS,$prefixo.'revistas_imgs');
define(SIMPOSIO,$prefixo.'simposio');
define(SIMPOSIO_GALERIAS,$prefixo.'simposio_galerias');
define(SIMPOSIO_IMGS,$prefixo.'simposio_imgs');
define(SIMPOSIO_INSCRICOES,$prefixo.'simposio_inscricoes');
define(SLIDES,$prefixo.'slides');
define(USUARIOS,$prefixo.'usuarios');
define(VERYX,$prefixo.'veryx');
define(DOWNLOADS,$prefixo.'downloads');

$scripts = $http.'scripts/';
$css = $http.'css/';
$img = $http.'img/';
$sistema = $http.'sistema/';

$destino = 'maicon@dataprisma.com.br';

#conta autenticadora
$autenticado = true;
$_host = 'ssl://smtp.gmail.com:465';
$_usuario = 'arxo.web@gmail.com';
$_senha = 'googlemarketing';
?>