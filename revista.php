<?
include('topo.php');
$path = 'arquivos/revistas/';
?>

	<div class="breadcrumb">
		<div class="central">
			<a href="./">HOME</a> &raquo; <a href="<?=$_links['revista arxo']?>"><?=$_rotulos['revista arxo']?></a> 
			<? if($tag != ''){ ?>
				&raquo; <a href="<?=$_links['revista arxo'].$tag.'/'?>"><?=$revista->titulo?></a>
            <? } ?>
		</div>
	</div>

	<section class="conteudo">
		<div class="central">

			<? if($tag == ''){ ?>
                <h1>REVISTA ARXO</h1>

				<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.</p>
                
                <div class="revista-lista">
                    <?
                    foreach($revistas as $revista){
                        $href = $_links['revista arxo'].$revista->slug.'/';
                        $download = $path.$revista->arquivo;
    
                        echo '<div>';
                        echo '	<figure><a href="'.$href.'"><img src="img/revistas/p/'.$revista->imagem.'" alt="'.$revista->titulo.'" /></a></figure>';
                        echo '	<span class="titulo"><a href="'.$href.'">'.$revista->titulo.'</a></span>';
                        echo '	<span class="breve"><a href="'.$href.'">'.$revista->breve.'</a></span>';
                        echo '	<span class="links">';
                        echo '		<a href="'.$href.'">'.$_rotulos['visualizar'].'</a>';
                        if($revista->arquivo != ''){
                            echo '	<a href="'.$download.'">'.$_rotulos['fazer download'].'</a>';
                        }
                        echo '	</span>';
                        echo '</div>';
                    }
                    ?>
                </div>

			<?
			} else { ?>
				
				<h1><?=$revista->titulo?></h1>
                <p><?=$revista->breve?></p>

				<?
				/*
				foreach($imagens as $img){
					echo '<figure>';
					echo '<img src="img/revistas/galeria/'.$img->imagem.'" alt="'.$revista->titulo.'" />';
					echo '</figure>';
				}
				*/
				
				echo '<div class="t">';
				echo '	<div class="tc rel">';
				echo '		<div class="book" id="book">';

				foreach($imagens as $img){
					#echo '<div class="page" data-ampliacao="img/revistas/galeria/'.$img->imagem.'">';
					echo '<div class="page">';
					echo '<a href="img/revistas/galeria/'.$img->imagem.'" class="fancybox-revista" rel="galeria"><img src="img/revistas/galeria/m/'.$img->imagem.'" alt="" /></a>';
					#echo '<img src="img/revistas/galeria/m/'.$img->imagem.'" alt="" />';
					echo '</div>';
				}

				echo '		</div>';
				echo '	</div>';
				echo '</div>';
			
			}
			?>
		</div>
	</section>
    
    <script>
	/*
	$(function(){

		$('div.page').click(function(evt){
			evt.preventDefault();
			alert( $(this).data('ampliacao') );
		});

	});
	*/
	</script>
	<script src="scripts/revista.js"></script>

<? include('rodape.php') ?>