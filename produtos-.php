<? include('topo.php'); ?>
<div class="breadcrumb">
	<div class="central">
		<a href="./">HOME</a> &raquo; <a href="<?=$_links['produtos']?>"><?=$_rotulos['produtos']?></a>
		<?
		if(!empty($categoria)){
			if($categoria->titulo != '') echo ' &raquo; <a href="',($idioma!='br'?$idioma.'/':'').$categoria->slug,'/">',$categoria->titulo,'</a>';
		}
		if(!empty($produto) && $produto->id > 0){
			echo ' &raquo; <a href="',($idioma!='br'?$idioma.'/':'').$categoria->slug,'/',$produto->slug,'/">',$produto->titulo_completo,'</a>';
		}
		?>
	</div>
</div>

<? if ($categoria->idcategoria != 0){ ?>
	<? if ($produto->idproduto == 0){ ?>
		<div class="header-produtos fundo-cat-<?=$categoria->slug?>">
			<div class="central">
            	<h1><?=$categoria->titulo?></h1>
            </div>
        </div>
	<? } else { ?>
		<div class="header-produtos-detalhe fundo-cat-<?=$categoria->slug?><?=($produto->titulo == '' && $produto->subtitulo == '') ? ' reduzido' : '' ?>">
			<div class="sombra"></div>
			<div class="central">

				<? if ($produto->titulo != '' || $produto->subtitulo != ''){ ?>
                    <div class="titulo">
                        <h1><?=$produto->titulo?></h1>
                        <? if ($produto->subtitulo != ''){ ?>
                        	<h2><?=$produto->subtitulo?></h2>
						<? } ?>

					</div>
                <? } else { ?>
                    <div class="titulo">
                        <h2><?=$produto->titulo_completo?></h2>
                    </div>
                <? } ?>

				<? if ($produto->imagem_tit != ''){ ?>
                	<figure><img src="img/produtos/titulo/<?=$produto->imagem_tit?>" alt="" /></figure>
				<? } ?>

			</div>
        </div>
        <div class="clear"></div>
	<? } ?>
<? } ?>

<div class="central">
	<div class="conteudo" id="produto">
		<?
		if ($categoria->idcategoria == 0){ #listagem categorias
			echo '<div id="lista-produtos">';

			if ($categoria->idcategoria == 0){
				echo '<h1>Produtos e Serviços</h1>';
			}

			echo '<div>';
			foreach ($categorias as $cat){
				$img = is_file('img/categorias/destaque/'.$cat->imagem)?'img/categorias/destaque/'.$cat->imagem:'img/placeholder.png';
				echo '<a href="',($idioma!='br'?$idioma.'/':'').$cat->slug,'/"><img src="'.$img.'" alt="'.$cat->titulo.'"></a>';
			}
			echo '</div>';
			echo '<div class="clear"></div>';
			echo '</div>';
		} elseif ($produto->idproduto == 0){ #detalhe categoria

			echo '<br>';
			echo $categoria->descricao;
			echo '<br>';

			if (count($produtos) > 0){ #possui produtos atrelados
				echo '<div id="lista-produtos">';
				echo '<div>';
				foreach ($produtos as $p){
					$img = is_file('img/produtos/'.$p->imagem) ? 'img/produtos/'.$p->imagem : 'img/placeholder.png';
					echo '<a href="',($idioma!='br'?$idioma.'/':'').$categoria->slug,'/',$p->slug,'/',$p->idproduto,'/">';
					echo '<figure><img src="',$img,'" alt="'.$p->titulo_completo.'"></figure>';
					echo '<div>'.$p->titulo_completo.'</div>';
					echo '</a>';
				}
				echo '</div>';
				echo '</div>';

			} else { #exibe imagens da galeria

				foreach($imagens as $img){
					$href = 'img/categorias/galeria/'.$img->imagem;

					echo '<figure>';
					echo '<a href="',$href,'" class="fancybox" title="',$img->legenda,'" rel="galeria"><img src="img/categorias/galeria/p/',$img->imagem,'" title="',$img->legenda,'" alt="',$categoria->titulo,'" /></a>';
					echo '</figure>';
				}
			}

		} else { #detalhe produto

			if ($produto->imagem_banner != ''){ #imagem banner
				echo '<figure class="banner-produto"><img src="img/produtos/banner/'.$produto->imagem_banner.'" alt="'.$produto->titulo_completo.'" /></figure>';
			}

			echo '<div class="botao-orcamento"><a href="#"><span class="um">Clique para fazer seu</span> <span class="dois">orçamento</span></a></div>';

			echo $produto->descricao;

			$imagens = $produto->imagens();
			if (count($imagens) > 0){
				echo '<h2>GALERIA DE FOTOS</h2>';
				echo '<div class="galeria">';
				echo '<div id="galeria">';
				echo '<div class="anterior"></div>';
				echo '<div class="proxima"></div>';
				echo '<div id="miniaturas">';
				foreach ($imagens as $img){
					echo '<a class="fancybox" rel="produtos" title="',$img->legenda,'" href="img/produtos/galeria/',$img->imagem,'"><img src="img/produtos/galeria/p/',$img->imagem,'" title="',$img->legenda,'" alt=""></a>';
				}
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}

			$arquivos = $produto->arquivos();
			if (count($arquivos) > 0){
				echo '<div class="downloads">';
				echo '<h2>DOWNLOADS</h2>';

				if(count($arquivos) == 0){
					echo '<p><strong>Este produto não possui arquivos para download.</strong></p>';
				} else {
					echo '<div id="lista-download">';
					foreach($arquivos as $arq){
						echo '<a class="item-download" href="arquivos/produtos/',$arq->arquivo,'" target="_blank">',$arq->titulo,'</a>';
					}
					echo '</div>';
				}
				echo '</div>';
			}
			?>

			<div class="orcamento">
				<h2><?=$_rotulos['orcamento']?></h2>
				<form method="post" id="form-orcamento">
					<input type="hidden" name="idioma" id="idioma" value="<?=$idioma?>">
					<input type="hidden" name="idproduto" id="id" value="<?=$produto->idproduto?>">
                    				<input type="hidden" name="tag" id="tag" value="<?=$produto->slug?>">
                    				<input type="hidden" name="nomeproduto" id="nomeproduto" value="<?=$produto->titulo_completo?>">
                    <span class="coluna">
	                    <span class="linha">
							<input type="text" name="empresa" id="empresa" class="input" required placeholder="EMPRESA*">
						</span>
	                    <span class="linha">
							<input type="text" name="nome" id="nome" class="input" required placeholder="NOME*">
							<input type="text" name="cnpj" id="cnpj" class="input" required placeholder="CNPJ*" maxlength="18">
						</span>
	                    <span class="linha">
							<input type="email" name="email" id="email" class="input" placeholder="E-MAIL*">
							<input type="text" name="telefone" id="telefone" class="input" placeholder="TELEFONE*">
						</span>
					</span>
					<span class="mensagem">
						<textarea name="mensagem" id="mensagem" class="textarea" required placeholder="MENSAGEM*" rows="5" cols="40"></textarea>
					</span>
					<span class="botao">
						<div class="g-recaptcha" data-sitekey="6LdzlgkTAAAAAHaoSDzOvemIm7gjVzaTUwAjihCw"></div>
						<input type="submit" value="ENVIAR">
					</span>

				</form>
				<span class="retorno"></span>
			</div>

			<div class="clear"></div>

			<script type="text/javascript">
				var google_tag_params = {
				dynx_itemid: 'REPLACE_WITH_VALUE',
				dynx_itemid2: 'REPLACE_WITH_VALUE',
				dynx_pagetype: 'REPLACE_WITH_VALUE',
				dynx_totalvalue: 'REPLACE_WITH_VALUE',
				};
			</script>
			<script type="text/javascript">
				/* <![CDATA[ */
				var google_conversion_id = 964853732;
				var google_custom_params = window.google_tag_params;
				var google_remarketing_only = true;
				/* ]]> */
			</script>
			<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
			</script>
			<noscript>
			<div style="display:inline;">
			<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/964853732/?value=0&amp;guid=ON&amp;script=0"/>
			</div>
			</noscript>
			<?
		}
		?>
	</div>
</div>
<? include('rodape.php'); ?>