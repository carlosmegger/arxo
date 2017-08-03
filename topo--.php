<? require_once('includes/topo.php')?>
<!DOCTYPE html>
<html lang="<?=$lang?>">
<head>
<base href="<?=$http?>">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<? include('includes/meta-tags.php') ?>
<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />

<link rel="stylesheet" href="css/estilo.css" />
<link rel="stylesheet" href="css/media-queries.css" />
<link rel="stylesheet" href="css/categorias.php" />
<link rel="stylesheet" href="css/jquery.fancybox.css" />

<link rel="stylesheet" type="text/css" href="css/revista.css" />

<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,700' rel='stylesheet'>
<script>
var http = '<?=$http?>',
    page = '<?=$page?>',
    hash = '<?=$ancora?>',
	popup = <?=$popup?>;
<? if($page == 'produtos'){ ?>
	var categoria = '<?=$categoria->slug?>',
		idproduto = <?=$produto->idproduto?>;
<? } ?>
</script>
<script src="scripts/jquery-2.1.4.min.js"></script>
<script src="scripts/modernizr.custom.78617.js"></script>
<script src="scripts/jquery.maskedinput.min.js"></script>
<script src="scripts/jquery.fancybox.js"></script>
<script src="scripts/jquery.form.min.js"></script>
<script src="scripts/jquery.cycle2.min.js"></script>
<script src="scripts/jquery-picture-min.js"></script>
<script src="scripts/turn.min.js"></script>
<script src="scripts/jquery.fitvids.js"></script>
<script src="scripts/funcoes.js"></script>
<script src="scripts/site.js?r=<?=rand()?>"></script>
<script src="https://d335luupugsy2.cloudfront.net/js/integration/stable/rd-js-integration.min.js" type='text/javascript' ></script>
<script src="scripts/validacao.php"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript" async="true" src="https://d335luupugsy2.cloudfront.net/js/loader-scripts/af1e66bb-e4c5-4251-94eb-06cce2fb76f3-loader.js" ></script>
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount','UA-43940246-1']);
_gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
<script type="text/javascript">
//<![CDATA[
  (function() {
    var shr = document.createElement('script');
    shr.setAttribute('data-cfasync', 'false');
    shr.src = '//dsms0mj1bbhn4.cloudfront.net/assets/pub/shareaholic.js';
    shr.type = 'text/javascript'; shr.async = 'true';
    shr.onload = shr.onreadystatechange = function() {
      var rs = this.readyState;
      if (rs && rs != 'complete' && rs != 'loaded') return;
      var site_id = '5ae8cb1d2e7d182cd9933dc18d8dff74';
      try { Shareaholic.init(site_id); } catch (e) {}
    };
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(shr, s);
  })();
//]]>
</script>
</head>
<body>

	<? if($page == 'produtos' && $idproduto != ''){ ?>
        <div class="orcamento-suspenso">
        	<a href="#"><img src="img/orcamento-flutuante.png" alt="Clique aqui para fazer um orçamento" /></a>
        </div>
	<? } ?>

	<header>
        <div id="topo">
            <div class="central">
                <span><?=$_textos['lema']?></span>
                <span>
                    <a href="<?=$_links['portal do cliente']?>"><?=$_rotulos['portal do cliente']?></a> |
                    <a href="<?=$_links['portal do colaborador']?>"><?=$_rotulos['portal do colaborador']?></a> |
                    <a href="<?=$loja_virtual?>" target="_blank">ArxoStore</a>
                </span>
                <span class="midias">
                    <!-- a href="https://www.facebook.com/arxo.brasil" target="_blank" class="facebook"></a -->
                    <!-- a href="#" target="_blank" class="twitter"></a -->
                    <a href="https://br.linkedin.com/company/arxo-sidera-o" target="_blank" class="linkedin"></a>
                    <a href="https://www.youtube.com/user/arxodobrasil" target="_blank" class="youtube"></a>
                    <!-- a href="#" target="_blank" class="gplus"></a -->
                </span>
            </div>
        </div>
        <div class="central">
            <figure id="logo"><a href="./"><img src="img/logo.png" alt="Arxo" /></a></figure>
            <div id="bandeiras">
                <!--a href="en/" id="en"></a-->
                <a href="br/" id="br"></a>
                <!--a href="es/" id="es"></a-->
            </div>
            <nav>
                <div class="mobile">
                    <select name="menu-mobile" id="menu-mobile">
                        <option value="./">HOME</option>
                        <optgroup label='<?=$_rotulos['quem somos']?>'>
                            <option value="<?=$_links['institucional']?>"><?=$_rotulos['institucional']?></option>
                            <option value="<?=$_links['ideologia']?>"><?=$_rotulos['ideologia']?></option>
                            <? if ($veryx->exibir == 'S'){ ?>
                            <option value="<?=$_links['veryx']?>"><?=$_rotulos['veryx']?></option>
                            <? } ?>
                            <option value="<?=$_links['premios e certificacoes']?>"><?=$_rotulos['premios e certificacoes']?></option>
                            <option value="<?=$_links['clientes']?>"><?=$_rotulos['clientes']?></option>
                        </optgroup>
                        <optgroup label='<?=$_rotulos['produtos']?>'>
                            <?php foreach($categorias as $cat){ ?>
                            <option value="<?=$cat->slug?>/"><?=$cat->titulo?></option>
                            <?php } ?>
                        </optgroup>
                        <optgroup label="<?=$_rotulos['novidades']?>">
                            <option value="<?=$_links['novidades']?>"><?=$_rotulos['noticias']?></option>
                            <option value="<?=$_links['simposio']?>"><?=$_rotulos['simposio']?></option>
                        </optgroup>
                        <optgroup label="<?=$_rotulos['contato']?>">
                            <option value="<?=$_links['fale conosco']?>"><?=$_rotulos['fale conosco']?></option>
                            <option value="<?=$_links['trabalhe conosco']?>"><?=$_rotulos['trabalhe conosco']?></option>
                            <option value="<?=$_links['representantes']?>"><?=$_rotulos['representantes']?></option>
                            <option value="<?=$_links['localizacao']?>"><?=$_rotulos['localizacao']?></option>
                        </optgroup>
                        <option value="<?=$_links['portal do cliente']?>"><?=strtoupper($_rotulos['portal do cliente'])?></option>
                        <option value="<?=$_links['portal do colaborador']?>"><?=strtoupper($_rotulos['portal do colaborador'])?></option>
                    </select>
                </div>
                <div class="desktop">
                    <? if ($page != 'index'){?><a href="./" class="index">HOME</a><? } ?>
                    <span class="menu quem-somos"><a href="<?=$_links['institucional']?>"><?=$_rotulos['quem somos']?></a>
                        <span class="submenu">
                            <a href="<?=$_links['institucional']?>"><?=$_rotulos['institucional']?></a>
                            <a href="<?=$_links['ideologia']?>"><?=$_rotulos['ideologia']?></a>
                            <? if ($veryx->exibir == 'S'){ ?>
                            <a href="<?=$_links['veryx']?>"><?=$_rotulos['veryx']?></a>
                            <? } ?>
                            <a href="<?=$_links['premios e certificacoes']?>"><?=$_rotulos['premios e certificacoes']?></a>
                            <a href="<?=$_links['clientes']?>"><?=$_rotulos['clientes']?></a>
                        </span>
                    </span>
                    <span class="menu produtos"><a href="<?=$_links['produtos']?>"><?=$_rotulos['produtos']?></a>
                        <span class="submenu">
                            <?php foreach($categorias as $cat){ ?>
                            <a href="<?=$cat->slug?>/"><?=$cat->titulo?></a>
                            <?php } ?>
                        </span>
                    </span>
                    <span class="menu novidades"><a href="<?=$_links['novidades']?>"><?=$_rotulos['novidades']?></a>
                        <span class="submenu">
                            <a href="<?=$_links['novidades']?>"><?=$_rotulos['noticias']?></a>
                            <a href="<?=$_links['simposio']?>"><?=$_rotulos['simposio']?></a>
                            <!--a href="<?=$_links['revista arxo']?>"><?=$_rotulos['revista arxo']?></a-->
                        </span>
                    </span>
                    <span class="menu contato"><a href="<?=$_links['fale conosco']?>"><?=$_rotulos['contato']?></a>
                        <span class="submenu">
                            <a href="<?=$_links['fale conosco']?>"><?=$_rotulos['fale conosco']?></a>
                            <a href="<?=$_links['trabalhe conosco']?>"><?=$_rotulos['trabalhe conosco']?></a>
                            <a href="<?=$_links['representantes']?>"><?=$_rotulos['representantes']?></a>
                            <a href="<?=$_links['localizacao']?>"><?=$_rotulos['localizacao']?></a>
                        </span>
                    </span>
                    <span id="lupa"><img src="img/lupa.png" alt="" height="20" width="20"></span>
                    <form id="form_busca" action="<?=$_links['busca']?>">
                        <input type="text" name="busca" required />
                        <input type="submit" value="OK" />
                    </form>
                </div>
            </nav>
            <div class="clear"></div>
        </div>
	</header>
    <main>


