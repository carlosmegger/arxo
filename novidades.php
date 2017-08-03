<? include('topo.php'); ?>
<div class="breadcrumb">
	<div class="central">
		<a href="./">HOME</a> &raquo; <a href="<?=$_links['novidades']?>"><?=$_rotulos['novidades']?></a>
		<?
		if(!empty($categoria)){
			echo ' &raquo; <a href="',$_links['novidades'],$categoria->slug,'/">',$categoria->titulo,'</a>';
		}
		if(!empty($noticia)){
			echo ' &raquo; <a href="',$_links['novidades'],$noticia->url,'">',$noticia->titulo,'</a>';
		}
		?>
	</div>
</div>
<section class="conteudo central">
	<h1><?=$titulo?></h1>
	<aside>
		<nav id="lista_categorias">
			<h2><?=$_rotulos['categorias']?></h2>
			<?php
			foreach($categorias as $c){
				echo '<a href="'.$_links['novidades'].$c->slug.'/">'.$c->titulo.'</a>';
			}
			?>
		</nav>
		<nav id="lista_arquivos">
			<h2><?=$_rotulos['arquivos']?></h2>
			<?php
			foreach($anos as $ano){
				echo '<a href="'.$_links['novidades'].$ano['ano'].'/">'.$ano['ano'].'</a>';
			}
			?>
		</nav>
	</aside>
    
	<? if(!empty($noticia) && $noticia->idnoticia > 0){ ?>
		<section id="detalhe-noticia">
        
        	<time><?=$noticia->data?></time>
        
            <figure><img src="img/noticias/<?=$noticia->imagem?>" alt=""></figure>
            <div>
				<?=$noticia->descricao?>
                
                <div class="compartilhamento">
                    <div class='shareaholic-canvas' data-app='share_buttons' data-app-id='18447201'></div>
				</div>
            </div>
            <div class="clear"></div>
            <div id="galeria">
                <div class="anterior"></div>
                <div id="miniaturas">
                <?
                foreach ($galeria as $foto){
                    echo '<a href="img/noticias/galeria/'.$foto->imagem.'" title="',$img->legenda,'" class="fancybox" rel="fotos"><img src="img/noticias/galeria/p/'.$foto->imagem.'" title="',$img->legenda,'" alt=""></a>';
                }
                ?>
                </div>
                <div class="proxima"></div>
            </div>
        </section>
	<?
	}
	elseif(!empty($noticias)){
		echo '<section>';
		foreach($noticias as $not){

			$href = $_links['noticia'].$not->url;
			
			echo '<article class="item-noticia">';
			if($not->imagem){
				echo '<figure><a href="'.$href.'"><img src="img/noticias/',$not->imagem,'" alt="" /></a></figure>';
			}
			echo '	<h2><a href="'.$href.'">',$not->titulo,'</a></h2>';
			echo '	<time>',$not->data,'</time>';
			echo '	<p><a href="'.$href.'">',nl2br($not->breve),'</a></p>';
			echo '	<a href="'.$href.'" class="leia-mais">',$_rotulos['ler mais'],'</a>';
			echo '</article>';
		}
		echo $pag->getPaginacao();
		echo '</section>';
	} else {
		echo '<section>';
		echo '<p>',$_textos['noticia vazia'],'</p>';
		echo '</section>';
	}
	?>
	<div class="clear"></div>
</section>
<? include('rodape.php'); ?>