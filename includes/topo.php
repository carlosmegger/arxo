<?php
session_start();
if (!ob_start('ob_gzhandler')) ob_start();
require_once('class/model.php');
require_once('class/paginacao.php');
require_once('class/sendmail.php');
require_once('class/config.php');

require_once('scripts/funcoes.php');

if($_SERVER['HTTPS'] == 'on'){
	$http = 'https://'.$_SERVER['HTTP_HOST'].'/';
} else {
	$http = 'http://'.$_SERVER['HTTP_HOST'].'/';
}

if($_SERVER['HTTP_HOST'] == 'clientes.dataprisma'){
	$http .= 'arxo/';
}

# idioma
$idiomas = array('br','en','es');
$idioma = isset($_SESSION['idioma']) ? strtolower($_SESSION['idioma']) : 'br';
$idioma = isset($_GET['idioma']) ? strtolower($_GET['idioma']) : $idioma;
$idioma = in_array($idioma,$idiomas) ? $idioma : 'br';
$_SESSION['idioma'] = $idioma;
require_once('idioma/'.$idioma.'.php');

switch($idioma){
	case 'en': $lang = 'en'; break;
	case 'es': $lang = 'es'; break;
	default: $lang = 'pt-br';
}

# loja virtual
$loja_virtual = Config::get('url_loja');

# gerais
$page = basename($_SERVER['SCRIPT_FILENAME'],'.php');
$campo = strtoupper($idioma);

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$tag = isset($_GET['tag']) ? $_GET['tag'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$idproduto = isset($_GET['idproduto']) ? intval($_GET['idproduto']) : 0;
$busca = strip_tags($_GET['busca']);

require_once('class/veryx.php');
$veryx = Veryx::init();

require_once('class/produto.php');
$categorias = Produto::categorias();

if ($page == 'index'){

	require_once('class/slide.php');
	require_once('class/chamada.php');
	require_once('class/noticia.php');

	$slides = Slide::listar(array('idioma' => $idioma));
	$noticias = Noticia::listar(array('idioma' => $idioma),null,0,2);
	$chamadas = Chamada::listar(array('idioma' => $idioma),null,0,4);

} elseif ($page == 'institucional'){

	$ancora = isset($_GET['ancora']) ? $_GET['ancora'] : '';

	require_once('class/institucional.php');
	require_once('class/ideologia.php');
	require_once('class/linhaTempo.php');
	require_once('class/premio.php');
	require_once('class/cliente.php');
	#require_once('class/certificacao.php');

	$institucional = Institucional::init();
	$eventos = LinhaTempo::listar(array('idioma' => $idioma));
	$ideologia = Ideologia::init();
	$premios = Premio::listar(array('idioma' => $idioma));
	$clientes = Cliente::listar();

	#$certificacao = new Certificacao();

	require_once('scripts/conexao.php');

} elseif ($page == 'produtos'){

	$categoria = new Categoria($slug);
	$produtos = $categoria->produtos();
	$imagens = $categoria->imagens();

	#$produto = new Produto($tag);
	$produto = new Produto($idproduto);
	$_SESSION['captcha'] = crypt(microtime(),'arxoCaptcha');

} elseif ($page == 'novidades'){

	require_once('class/noticia.php');
	require_once('class/paginacao.php');

	$ano = isset($_GET['ano'])?intval($_GET['ano']):0;
	$data = isset($_GET['data'])?$_GET['data']:'';
	$categorias = Noticia::categorias();
	$anos = Noticia::anos();
	$qtd = 10;

	$pag = new Paginacao($qtd);

	if ($ano != 0){
		$inicio = $pag->getInicio();
		$noticias = Noticia::arquivos($ano,$inicio,$qtd);
		$total = Noticia::totalArquivos($ano);
		$pag->setTotal($total);
		$titulo = $_rotulos['novidades'].' &raquo; '.$ano;
	} elseif ($slug != ''){
		$categoria = new Categoria($slug);
		$noticias = $categoria->noticias();
		$total = $categoria->totalNoticias();
		$pag->setTotal($total);
		$titulo = $_rotulos['novidades'].' &raquo; '.$categoria->titulo;
	} elseif ($tag != '' && $data != ''){
		$noticia = new Noticia($tag,$data);
		$categoria = $noticia->categoria();
		$titulo = $noticia->titulo;
		$galeria = $noticia->fotos();
	} else {
		$inicio = $pag->getInicio();
		$noticias = Noticia::listar($inicio,$qtd);
		$total = Noticia::total();
		$pag->setTotal($total);
		$titulo = $_rotulos['novidades'];
	}
} elseif ($page == 'fale-conosco'){
	require_once('class/estado.php');
	$estados = Estado::listar();
	if (empty($_SESSION['captcha']) && !$_POST){
		$_SESSION['captcha'] = crypt(microtime(),'arxoCaptcha');
	}
} elseif ($page == 'portal-do-cliente' || $page == 'portal-do-colaborador'){
	require_once('class/portal.php');
	$tipo = ($page == 'portal-do-cliente') ? 'CL' : 'CO';
	$portais = Portais::listar(array('idioma' => $idioma,'tipo' => $tipo));
} elseif ($page == 'revista'){
	require_once('class/revista.php');

	if ($tag == ''){
		$revistas = Revista::listar(array('idioma' => $idioma));
	} else {
		$revista = new Revista($tag);
		$imagens = Revista::imagens($revista->idrevista);
	}
} elseif ($page == 'instituto'){
	require_once('class/instituto.php');
	$instituto = Instituto::init();
	$imagens = InstFoto::listar();
} elseif ($page == 'comunicacao-visual'){
	require_once('class/comunicacao.php');
	$comunicacao = Comunicacao::init();
	$imagens = ComunicacaoFoto::listar();
} elseif ($page == 'opcoes-financiamento'){
	require_once('class/financiamento.php');
	require_once('class/faq.php');
	$financiamento = Financiamento::init();
	$perguntas = Faq::listar();
} elseif ($page == 'simposio'){
	require_once('class/simposio.php');
	$simposio = Simposio::init();
} elseif ($page == 'representantes'){
	if ($id != ''){
		require_once('class/representante.php');
		$representante = new Representante($id);
	}
} elseif ($page == 'downloads'){
	require_once('class/portal.php');
	$cat = isset($_GET['categoria']) ? $_GET['categoria'] : '';
	$categoria = new Portais($cat);
	$arquivos = $categoria->arquivos();
}

#popup
require_once('class/popup.php');
$popup = Popup::listar(array('idioma' => $idioma),null,0,1);

if(count($popup) > 0){

	if(!isset($_SESSION['popup'][$idioma])){
		$popup = array('titulo' => $popup[0]->titulo,
					   'imagem' => 'img/popup/'.$popup[0]->imagem,
					   'url' => $popup[0]->url,
					   'blank' => $popup[0]->blank);

		$popup = json_encode($popup);
		$_SESSION['popup'][$idioma] = true;

	} else {
		$popup = 'null';
	}

} else {
	$popup = 'null';
}
