<? include('topo.php'); ?>
<div class="breadcrumb">
	<div class="central">
		<a href="./">HOME</a> &raquo; <a href="<?=$_links['orcamento']?>"><?=$_rotulos['orcamento']?></a>
	</div>
</div>

<div class="central">
	<div class="conteudo" id="orcamento">
		<?

		#agradecimento
		echo '<h2>'.$_textos['orcamento retorno tit'].'</h2>';
		echo '<p>'.$_textos['orcamento retorno txt'].'</p>';
		echo '<br />';

		#lista produtos
		$idproduto_rel = $_SESSION['idproduto_rel'];

		$sql = "select
					p.*,
					c.titulo as categoria,
					c.slug as categoria_slug
				from
					2015_produtos_rel pr
					left join 2015_produtos p on (pr.idrelacionado = p.idproduto)
					left join 2015_categorias c on (p.idcategoria = c.idcategoria)
				where
					pr.idproduto = '".$idproduto_rel."'
				order by p.titulo_completo asc";

		$DB = new DB();
		$relacionados = $DB->query($sql);
		$qtd_relacionados = count($relacionados);
		if($qtd_relacionados > 0){

			echo '<h2>'.$_textos['orcamento outros produtos'].':</h2>';
			echo '<br />';

			echo '<div id="lista-produtos">';
			echo '	<div>';

			foreach($relacionados as $rel){
				$img = is_file('img/produtos/'.$rel['imagem']) ? 'img/produtos/'.$rel['imagem'] : 'img/placeholder.png';

				echo '<a href="',($idioma != 'br' ? $idioma.'/' : '').$rel['categoria_slug'],'/',$rel['slug'],'/',$rel['idproduto'],'/">';
				echo '	<figure><img src="',$img,'" alt="'.$rel['titulo_completo'].'"></figure>';
				echo '	<div>'.$rel['titulo_completo'].'</div>';
				echo '</a>';
			}

			echo '	</div>';
			echo '</div>';
		}
		?>
	</div>
</div>

<script>
var TOKEN = '677820bd5f70a085a0b22a46ab6bb763';
</script>
<script type="text/javascript" src="https://d335luupugsy2.cloudfront.net/js/integration/stable/rd-js-integration.min.js"></script>
<? include('rodape.php') ?>