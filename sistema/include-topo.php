<?
ob_start();
require_once('../scripts/conexao.php');
require_once('../scripts/funcoes.php');
require_once('../scripts/mysql.php');
require_once('../scripts/img.canvas.php');
require_once('../scripts/paginacao.php');

$page = basename($_SERVER['PHP_SELF'],'.php');
if($page != 'index') require_once('verifica.php');
if($page == 'categorias-imgs') $page = 'categorias';
if($page == 'produtos-imgs') $page = 'produtos';
if($page == 'produtos-arqs') $page = 'produtos';
if($page == 'noticias-imgs') $page = 'noticias';
if($page == 'simposio-imgs') $page = 'simposio-galerias';
if($page == 'revistas-imgs') $page = 'revistas';
if($page == 'relatorios-imgs') $page = 'relatorio-sustentabilidade';

$id = intval($_GET['id']);
$secao = seguranca($_GET['secao']);
$acao = seguranca($_GET['acao']);
$tipo = seguranca($_GET['tipo']);
$ativo = seguranca($_GET['ativo']);
$categoria = seguranca($_GET['categoria']);
$idcategoria = seguranca($_GET['idcategoria']);
$idproduto = seguranca($_GET['idproduto']);
$idnoticia = seguranca($_GET['idnoticia']);
$idgaleria = seguranca($_GET['idgaleria']);
$idrevista = seguranca($_GET['idrevista']);
$idrelatorio = seguranca($_GET['idrelatorio']);
$idioma = seguranca($_GET['idioma']);
$pais = seguranca($_GET['pais']);

$pagina = intval($_GET['pagina']);
$filtro = seguranca($_GET['filtro']);
$atualizado = seguranca($_GET['atualizado']);
$login = seguranca($_GET['login']);
$busca = seguranca($_GET['busca']);

#permissoes
$_permissoes = explode(',',$_SESSION['permissoes']);
if(($page != 'home' && $page != 'index') && (!in_array($page,$_permissoes)) && (!in_array($page.'-'.strtolower($tipo),$_permissoes))){ #não tem permissão
	header('Location: home.php');
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-Strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Arxo - Administração</title>
<meta name="Author" content="www.dataprisma.com.br" />
<meta name="robots" content="all" />
<meta name="robots" content="noindex,nofollow" />
<link rel="shortcut icon" type="image/x-icon" href="<?=$img?>favicon.ico?<?=rand()?>" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700' rel='stylesheet' type='text/css' />

<link rel="stylesheet" type="text/css" href="../css/sistema.css?<?=rand()?>" />
<link rel="stylesheet" type="text/css" href="../css/jquery.fancybox.css" />
<link rel="stylesheet" type="text/css" href="../css/jcrop.css" />
<link rel="stylesheet" type="text/css" href="../css/colpick.css" />
<link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.10.2.custom.min.css" />

<link rel="stylesheet" type="text/css" href="../css/jquery.fileupload.css" />
<link rel="stylesheet" type="text/css" href="../css/jquery.fileupload-ui.css" />
<noscript><link rel="stylesheet" href="../css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="../css/jquery.fileupload-ui-noscript.css"></noscript>

<script type="text/javascript">
var http = '<?=$http?>',
	page = '<?=$page?>',
	acao = '<?=$acao?>',
	atualizado = '<?=($atualizado == true) ? true : false ?>';
</script>

<? if($page == 'lojas'){ ?><script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false"></script><? } ?>
<script type="text/javascript" src="../scripts/jquery.js"></script>
<script type="text/javascript" src="../scripts/jquery.maskedinput.min.js"></script>
<!--script type="text/javascript" src="../scripts/jquery.price_format.2.0.min.js"></script-->
<script type="text/javascript" src="../scripts/funcoes.js"></script>
<script type="text/javascript" src="../scripts/jquery.fancybox.js"></script>
<script type="text/javascript" src="../scripts/jcrop.min.js"></script>
<script type="text/javascript" src="../scripts/colpick.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="../scripts/sistema.js?<?=rand()?>"></script>
<script type="text/javascript" src="../scripts/sistema-validacao.js?<?=rand()?>"></script>
<script type="text/javascript" src="../scripts/jquery-ui-1.10.2.custom.min.js"></script>
</head>
<body id="<?=$page?>">
<div id="carregando">Processando...</div>
<? if($atualizado){ ?><div id="atualizado">Atualizado com sucesso!</div><? } ?>

<div id="principal">
	<div id="topo">
		<span><img src="../img/sistema/logo.png" />Arxo</span>
		<? if($page != 'index'){ ?><span class="logout"><a href="logout.php">Logout<img src="../img/sistema/logout.png" /></a></span><? } ?>
	</div>
	
	<? if($page != 'index'){ ?>
	<div id="menu">
		<div class="links">
			<div>
            	<span class="home"><a href="home.php" <?=($page == 'home') ? 'class="ativo"' : '' ?>>Home</a></span>
			</div>

			<? if(in_array('configs',$_permissoes) || in_array('slides',$_permissoes) || in_array('chamadas',$_permissoes) || in_array('popup',$_permissoes) || in_array('usuarios',$_permissoes)){ ?>
                <div>
                    <p>Gerais:</p>
                    <? if(in_array('configs',$_permissoes)){ ?><span class="configs"><a href="configs.php" <?=($page == 'configs') ? 'class="ativo"' : '' ?>>Configurações</a></span><? } ?>
                    <? if(in_array('slides',$_permissoes)){ ?><span class="slides"><a href="slides.php" <?=($page == 'slides') ? 'class="ativo"' : '' ?>>Slides</a></span><? } ?>
                    <? if(in_array('chamadas',$_permissoes)){ ?><span class="chamadas"><a href="chamadas.php" <?=($page == 'chamadas') ? 'class="ativo"' : '' ?>>Chamadas</a></span><? } ?>
                    <? if(in_array('popup',$_permissoes)){ ?><span class="popup"><a href="popup.php" <?=($page == 'popup') ? 'class="ativo"' : '' ?>>Pop-up</a></span><? } ?>
                    <? if(in_array('usuarios',$_permissoes)){ ?><span class="usuarios"><a href="usuarios.php" <?=($page == 'usuarios') ? 'class="ativo"' : '' ?>>Usuários</a></span><? } ?>
                </div>
			<? } ?>

			<? if(in_array('institucional',$_permissoes) || in_array('linha-tempo',$_permissoes) || in_array('ideologia',$_permissoes) || in_array('veryx',$_permissoes) || in_array('certificacoes',$_permissoes) || in_array('clientes',$_permissoes)){ ?>
                <div>
                    <p>Quem somos:</p>
                    <? if(in_array('institucional',$_permissoes)){ ?><span class="institucional"><a href="institucional.php" <?=($page == 'institucional') ? 'class="ativo"' : '' ?>>A Arxo</a></span><? } ?>
                    <? if(in_array('linha-tempo',$_permissoes)){ ?><span class="linha-tempo"><a href="linha-tempo.php" <?=($page == 'linha-tempo') ? 'class="ativo"' : '' ?>>Linha do Tempo</a></span><? } ?>
                    <? if(in_array('ideologia',$_permissoes)){ ?><span class="ideologia"><a href="ideologia.php" <?=($page == 'ideologia') ? 'class="ativo"' : '' ?>>Ideologia</a></span><? } ?>
                    <? if(in_array('veryx',$_permissoes)){ ?><span class="veryx"><a href="veryx.php" <?=($page == 'veryx') ? 'class="ativo"' : '' ?>>Veryx</a></span><? } ?>
                    <? if(in_array('certificacoes',$_permissoes)){ ?><span class="certificacoes"><a href="certificacoes.php" <?=($page == 'certificacoes') ? 'class="ativo"' : '' ?>>Certificações</a></span><? } ?>
                    <? if(in_array('premios-certificacoes',$_permissoes)){ ?><span class="certificacoes"><a href="premios-certificacoes.php" <?=($page == 'premios-certificacoes') ? 'class="ativo"' : '' ?>>Prêmios e Certificações</a></span><? } ?>
                    <? if(in_array('clientes',$_permissoes)){ ?><span class="clientes"><a href="clientes.php" <?=($page == 'clientes') ? 'class="ativo"' : '' ?>>Clientes</a></span><? } ?>
                </div>
			<? } ?>
            
            <? if(in_array('categorias-p',$_permissoes) || in_array('produtos',$_permissoes)){ ?>
                <div>
                    <p>Produtos e Serviços:</p>
                    <? if(in_array('categorias-p',$_permissoes)){ ?><span class="categorias"><a href="categorias.php?acao=listar&tipo=P" <?=($page == 'categorias' && $tipo == 'P') ? 'class="ativo"' : '' ?>>Categorias</a></span><? } ?>
                    <? if(in_array('produtos',$_permissoes)){ ?><span class="produtos"><a href="produtos.php" <?=($page == 'produtos') ? 'class="ativo"' : '' ?>>Produtos e Serviços</a></span><? } ?>
                </div>
			<? } ?>

            <? if(in_array('categorias-n',$_permissoes) || in_array('noticias',$_permissoes)){ ?>
                <div>
                    <p>Notícias:</p>
                    <? if(in_array('categorias-n',$_permissoes)){ ?><span class="categorias"><a href="categorias.php?acao=listar&tipo=N" <?=($page == 'categorias' && $tipo == 'N') ? 'class="ativo"' : '' ?>>Categorias</a></span><? } ?>
                    <? if(in_array('noticias',$_permissoes)){ ?><span class="noticias"><a href="noticias.php" <?=($page == 'noticias') ? 'class="ativo"' : '' ?>>Notícias</a></span><? } ?>
                </div>
			<? } ?>

            <? if(in_array('instituto',$_permissoes) || in_array('instituto-galeria',$_permissoes)){ ?>
                <div>
                    <p>Comunicado:</p>
                    <? if(in_array('instituto',$_permissoes)){ ?><span class="instituto"><a href="instituto.php" <?=($page == 'instituto') ? 'class="ativo"' : '' ?>>COMUNICADO</a></span><? } ?>
                    <? if(in_array('instituto-galeria',$_permissoes)){ ?><span class="instituto-galeria"><a href="instituto-galeria.php" <?=($page == 'instituto-galeria') ? 'class="ativo"' : '' ?>>GALERIA</a></span><? } ?>
                </div>
            <? } ?>

            <? if(in_array('comunicacao',$_permissoes) || in_array('comunicacao-galeria',$_permissoes)){ ?>
                <div>
                    <p>Comunicação Visual:</p>
                    <? if(in_array('comunicacao',$_permissoes)){ ?><span class="comunicacao"><a href="comunicacao.php" <?=($page == 'comunicacao') ? 'class="ativo"' : '' ?>>COMUNICAÇÃO VISUAL</a></span><? } ?>
                    <? if(in_array('comunicacao-galeria',$_permissoes)){ ?><span class="comunicacao-galeria"><a href="comunicacao-galeria.php" <?=($page == 'comunicacao-galeria') ? 'class="ativo"' : '' ?>>GALERIA</a></span><? } ?>
                </div>
            <? } ?>

			<? if(in_array('financiamento',$_permissoes)){ ?>
                <div>
                    <p>Opções de Financiamento:</p>
                    <? if(in_array('financiamento',$_permissoes)){ ?>
                    <span class="financiamento"><a href="financiamento.php" <?=($page == 'financiamento') ? 'class="ativo"' : '' ?>>OPÇÕES DE FINANCIAMENTO</a></span>
                    <span class="faq"><a href="faq.php" <?=($page == 'faq') ? 'class="ativo"' : '' ?>>PERGUNTAS E RESPOSTAS</a></span>
                    <? } ?>
                </div>
			<? } ?>

			<? if(in_array('locais',$_permissoes)){ ?>
                <div>
                    <p>Localização:</p>
                    <? if(in_array('locais',$_permissoes)){ ?><span class="locais"><a href="locais.php" <?=($page == 'locais') ? 'class="ativo"' : '' ?>>Locais</a></span><? } ?>
                </div>
			<? } ?>
            
			<? if(in_array('contatos',$_permissoes) || in_array('curriculos',$_permissoes) || in_array('representantes',$_permissoes) || in_array('orcamentos',$_permissoes)){ ?>
				<div>
					<p>Contatos:</p>
                    <? if(in_array('contatos',$_permissoes)){ ?><span class="contatos"><a href="contatos.php" <?=($page == 'contatos') ? 'class="ativo"' : '' ?>>Contatos</a></span><? } ?>
					<? if(in_array('curriculos',$_permissoes)){ ?><span class="curriculos"><a href="curriculos.php" <?=($page == 'curriculos') ? 'class="ativo"' : '' ?>>Currículos</a></span><? } ?>
					<? if(in_array('representantes',$_permissoes)){ ?><span class="representantes"><a href="representantes.php" <?=($page == 'representantes') ? 'class="ativo"' : '' ?>>Representantes</a></span><? } ?>
					<? if(in_array('orcamentos',$_permissoes)){ ?><span class="orcamentos"><a href="orcamentos.php" <?=($page == 'orcamentos') ? 'class="ativo"' : '' ?>>Solicitações de Orçamento</a></span><? } ?>
                </div>
            <? } ?>

			<? if(in_array('portal-cliente',$_permissoes) || in_array('portal-colaborador',$_permissoes)){ ?>
                <div>
                    <p>Portais:</p>
                    <? if(in_array('portal-cliente',$_permissoes)){ ?><span class="portal-cliente"><a href="portal-cliente.php" <?=($page == 'portal-cliente') ? 'class="ativo"' : '' ?>>Portal do Cliente</a></span><? } ?>
                    <? if(in_array('portal-downloads',$_permissoes)){ ?><span class="portal-downloads"><a href="portal-downloads.php" <?=($page == 'portal-downloads') ? 'class="ativo"' : '' ?>>Arquivos para Download</a></span><? } ?>
                    <? if(in_array('portal-colaborador',$_permissoes)){ ?><span class="portal-colaborador"><a href="portal-colaborador.php" <?=($page == 'portal-colaborador') ? 'class="ativo"' : '' ?>>Portal do Colaborador</a></span><? } ?>
                </div>
			<? } ?>
            
			<? if(in_array('simposio',$_permissoes) || in_array('simposio-galerias',$_permissoes) || in_array('simposio-inscricoes',$_permissoes)){ ?>
                <div>
					<p>Simpósio de Esculturas:</p>
					<? if(in_array('simposio',$_permissoes)){ ?><span class="simposio"><a href="simposio.php" <?=($page == 'simposio') ? 'class="ativo"' : '' ?>>Simpósio de Esculturas</a></span><? } ?>
                    <? if(in_array('simposio-galerias',$_permissoes)){ ?><span class="simposio-galerias"><a href="simposio-galerias.php" <?=($page == 'simposio-galerias') ? 'class="ativo"' : '' ?>>Galerias</a></span><? } ?>
					<? if(in_array('simposio-inscricoes',$_permissoes)){ ?><span class="simposio-inscricoes"><a href="simposio-inscricoes.php" <?=($page == 'simposio-inscricoes') ? 'class="ativo"' : '' ?>>Inscrições</a></span><? } ?>
                </div>
			<? } ?>

			<? if(in_array('revistas',$_permissoes)){ ?>
                <div>
                    <p>Revista Arxo:</p>
                    <? if(in_array('revistas',$_permissoes)){ ?><span class="revistas"><a href="revistas.php" <?=($page == 'revistas') ? 'class="ativo"' : '' ?>>Revistas</a></span><? } ?>
                </div>
			<? } ?>

			<? if(in_array('relatorio-sustentabilidade',$_permissoes)){ ?>
                <div>
                    <p>Relatório de Sustentabilidade:</p>
                    <? if(in_array('relatorio-sustentabilidade',$_permissoes)){ ?><span class="relatorio-sustentabilidade"><a href="relatorio-sustentabilidade.php" <?=($page == 'relatorio-sustentabilidade') ? 'class="ativo"' : '' ?>>Relatório de Sustentabilidade</a></span><? } ?>
                </div>
			<? } ?>
            
		</div>
        <div class="legendas">
        	<h1>Legendas</h1>
			<span><img src="../img/sistema/ico-adicionar.png" class="vimg" /> Adicionar conteúdo</span>
			<span><img src="../img/sistema/ico-editar.png" class="vimg" /> Editar conteúdo</span>
			<span><img src="../img/sistema/ico-remover.gif" class="vimg" /> Remover item</span>
			<span><img src="../img/sistema/ico-ordenar.png" class="vimg" /> Ordenar</span>
			<span><img src="../img/sistema/ico-zoom.png" class="vimg" /> Visualiza imagem</span>
			<span><img src="../img/sistema/ico-left.png" class="vimg" /> Expande conteúdo</span>
		</div>
	</div>
	<? } else { ?>
	<div class="login">
    	<h2>Para acessar a administração, preencha seu login e senha:</h2>
	</div>
	<? } ?>
	