<? include('topo.php'); ?>
<div class="breadcrumb">
	<div class="central">
		<a href="./">HOME</a> &raquo; <a href="<?=$_links['institucional']?>"><?=$_rotulos['quem somos']?></a>
	</div>
</div>
<section id="empresa" class="conteudo">
	<div class="central">
		<h1><?=$institucional->titulo?></h1>
		<?=$institucional->descricao?>
	</div>
</section>
<section id="ideologia" class="conteudo">
	<div class="central">
		<? if ($ideologia->imagem){ ?>
		<figure class="right"><img src="img/ideologia/<?=$ideologia->imagem?>" alt="<?$ideologia->titulo?>"></figure>
		<? } ?>
		<h1><?=$ideologia->titulo?></h1>
		<?=$ideologia->descricao?>
	</div>
</section>
<section id="tempo" class="conteudo">
	<div class="central">
		<h1><?=$_rotulos['historiaarxo']?></h1>
		<div>
			<span id="linha-tempo"><?
			foreach ($eventos as $evento){
				echo '<span>'.$evento->ano.'</span>';
			}
			?></span>
			<div id="evento_linha">
				<?
                foreach($eventos as $evento){
					echo '<div id="i'.$evento->ano.'">';
					if($evento->imagem) echo '<figure><img src="img/linha-tempo/'.$evento->imagem.'" alt="Arxo '.$evento->ano.'" /></figure>';
					echo nl2br($evento->texto);
					echo '</div>';
                }
                ?>
			</div>
		</div>
	</div>
</section>

<? if($veryx->exibir == 'S'){ ?>
<section id="veryx" class="conteudo">
	<div class="central">
		<figure class="right"><img src="img/veryx/<?=$veryx->imagem?>" alt="<?$veryx->titulo?>"></figure>
		<h1><?=$veryx->titulo?></h1>
		<?=$veryx->descricao?>
	</div>
</section>
<? } ?>


<section id="certificacoes" class="conteudo">
	<div class="central">
		<h1><?=$_rotulos['premios e certificacoes']?></h1>		
		
		<?
		require_once('class/certificacao.php');
		$certificacao = new Certificacao;
		echo $certificacao->descricao;

		echo '<ul id="lista-certificacoes">';
		foreach($premios as $premio){
			echo '<li>'.$premio->titulo.'</li>';
		}
		echo '</ul>';
		?>
	</div>
</section>
<section id="clientes" class="conteudo">
	<div class="central">
		<h1>CLIENTES</h1>
		<div id="lista-clientes">
			<?
            $i = 0;
            foreach($clientes as $cliente){
                if($i % 4 == 0){
                    if($i > 0){
                        echo '</span>';
                    }
                    echo '<span class="item">';
                }
                echo '<span>';
                $a1 = $a2 = '';
                if(!!$cliente->url && !preg_match('#^https?:\/\/$#',$cliente->url)){
                    $a1 = '<a href="'.$cliente->url.'" target="_blank">';
                    $a2 = '</a>';
                }
                echo $a1,'<img src="img/clientes/'.$cliente->imagem.'" alt="'.$cliente->titulo.'">',$a2;
                
                echo '</span>';
                $i++;
            }
			if($i > 0){
                echo '</span>';
            }
            ?>

			<div class="navegacao"></div>
		</div>
	</div>
</section>
<? include('rodape.php'); ?>