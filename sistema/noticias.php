<?
include("include-topo.php");

$path_temp = '../img/noticias/temp/';
$path_p = '../img/noticias/p/';
$path = '../img/noticias/';
?>
<div id="conteudo">
	<div class="topo">
		<h1>Notícias</h1>
		<div>
        <? if($acao == ''){ ?>
			<a href="?acao=adicionar" class="adicionar">adicionar</a>
		<? } else { ?>
        	<a href="javascript:history.back()" class="voltar">&laquo; voltar</a>
		<? } ?>
		</div>
	</div>

	<?
    if($acao == ''){

		$query = mysql_query("select * from ".NOTICIAS." order by data desc, idnoticia desc");

		if(mysql_num_rows($query) == 0){ ?>
			<p>N&atilde;o há itens cadastrados!</p>
		<? } else { ?>
        	<div class="listagem">
                <div class="cabecalho">
                    <span class="idioma">Idioma</span>
                    <span class="preview">Preview</span>
                    <span class="titulo">Título</span>
					<span class="galeria">Galeria</span>
                    <span class="ativo">Ativo</span>
                    <span class="editar">Editar</span>
					<span class="remover">Remover</span>
					<div class="clear"></div>
				</div>
				<?
                while($rs = mysql_fetch_assoc($query)){
                    $ativo = ($rs['ativo'] == 'S') ? 'ico-ativo-on.png' : 'ico-ativo-off.png';
                    $qtd_fotos = mysql_num_rows(mysql_query("select * from ".NOTICIAS_IMGS." where idnoticia = '".$rs['idnoticia']."'"));
                ?>
                <div class="caixa-noticia posiciona" data-id="<?=$rs['idnoticia']?>">
                    <span class="idioma"><img src="../img/sistema/<?=$rs['idioma']?>.png" border="0" /></span>
                    <span class="preview">
                    	<? if($rs['imagem'] != ''){ ?>
                            <a href="<?=$path.$rs['imagem']?>" class="fancybox"><img src="<?=$path_p.$rs['imagem']?>" border="0" /></a>
						<?
                        } else {
                        	echo '-';
                        }
						?>
					</span>
                    <span class="titulo"><?=$rs['titulo']?></span>
                    <span class="galeria"><a href="noticias-imgs.php?acao=listar&idnoticia=<?=$rs['idnoticia']?>"><img src="../img/sistema/ico-galeria.png" class="vimg" /> (<?=$qtd_fotos?>)</a></span>
                    <span class="ativo"><img src="../img/sistema/<?=$ativo?>" longdesc="<?=NOTICIAS?>-<?=$rs['idnoticia']?>-idnoticia" class="ativo cursor" /></span>
                    <span class="editar"><a href="?acao=editar&id=<?=$rs['idnoticia']?>"><img src="../img/sistema/ico-editar.png" alt="editar" border="0" /></a></span>
                    <span class="remover"><a href="javascript:void(0)" onClick="remover(<?=$rs['idnoticia']?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" /></a></span>
                </div>
				<? } ?>
			</div>
			<?
		}
	}
	elseif($acao == 'adicionar'){

		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-noticias.php');
			echo '</div>';
		} else {
			
			$idioma = seguranca($_POST['idioma']);
			$idcategoria = seguranca($_POST['idcategoria']);
			$titulo = seguranca($_POST['titulo']);
			$slug = montaTag($titulo);
			$breve = seguranca($_POST['breve']);
			$descricao = seguranca($_POST['descricao']);
			$imagem = $_FILES['imagem'];
			$ativo = seguranca($_POST['ativo']);
			$data = converteData($_POST['data'],'Y-m-d');
			$ativo = ($ativo == 'S') ? 'S' : 'N';
			
			$meta_titulo = seguranca($_POST['meta_titulo']);
			$meta_descricao = seguranca($_POST['meta_descricao']);

			$campos = "idioma,idcategoria,titulo,slug,breve,descricao,ativo,data,meta_titulo,meta_descricao";
			$valores = "'".$idioma."','".$idcategoria."','".$titulo."','".$slug."','".$breve."','".$descricao."','".$ativo."','".$data."','".$meta_titulo."','".$meta_descricao."'";
			inserir(NOTICIAS,$campos,$valores);
			$ultimo = ultimoID();
			
			if($imagem['name'] != ''){
				
				$extensao = getExtensao($imagem['name']);
				$img = $ultimo.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($imagem['tmp_name'],$path_temp.$img);
				
				$tamanho = getimagesize($path_temp.$img);
				if($tamanho[0] > 800){
					$imgg = new canvas($path_temp.$img);
					$imgg->redimensiona(800,'');
					$imgg->grava($path_temp.$img,100);
				}

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(320,240);
				$imgg->grava($path.$img,100);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(150,'');
				$imgg->grava($path_p.$img,100);

				atualizar(NOTICIAS,"imagem = '".$img."'","idnoticia = ".$ultimo);
				#if(is_file($path_temp.$img)) unlink($path_temp.$img);
				$crop = true;
			}

			if($crop){
				echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php?acao=crop&id=$ultimo'>";
			} else {
				echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
			}
		}
	}
	elseif($acao == 'editar'){

		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-noticias.php');
			echo '</div>';
		} else {

			$idioma = seguranca($_POST['idioma']);
			$idcategoria = seguranca($_POST['idcategoria']);
			$titulo = seguranca($_POST['titulo']);
			$slug = montaTag($titulo);
			$breve = seguranca($_POST['breve']);
			$descricao = seguranca($_POST['descricao']);
			$imagem = $_FILES['imagem'];
			$hidden = seguranca($_POST['hidden']);
			$ativo = seguranca($_POST['ativo']);
			$data = converteData($_POST['data'],'Y-m-d');
			$ativo = ($ativo == 'S') ? 'S' : 'N';

			$meta_titulo = seguranca($_POST['meta_titulo']);
			$meta_descricao = seguranca($_POST['meta_descricao']);

			$dados  =  "idioma = '".$idioma."',
						idcategoria = '".$idcategoria."',
						titulo = '".$titulo."',
						slug = '".$slug."',
						breve = '".$breve."',
						descricao = '".$descricao."',
						ativo = '".$ativo."',
						data = '".$data."',
						meta_titulo = '".$meta_titulo."',
						meta_descricao = '".$meta_descricao."'";

			atualizar(NOTICIAS,$dados,"idnoticia = ".$id);
			
			if($imagem['name'] != ''){
				if(is_file($path_temp.$hidden)) unlink($path_temp.$hidden);
				if(is_file($path_p.$hidden)) unlink($path_p.$hidden);
				if(is_file($path.$hidden)) unlink($path.$hidden);

				$extensao = getExtensao($imagem['name']);
				$img = $id.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($imagem['tmp_name'],$path_temp.$img);

				$tamanho = getimagesize($path_temp.$img);
				if($tamanho[0] > 800){
					$imgg = new canvas($path_temp.$img);
					$imgg->redimensiona(800,'');
					$imgg->grava($path_temp.$img,100);
				}

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(320,240);
				$imgg->grava($path.$img,100);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(150,'');
				$imgg->grava($path_p.$img,100);

				atualizar(NOTICIAS,"imagem = '".$img."'","idnoticia = ".$id);
				#if(is_file($path_temp.$img)) unlink($path_temp.$img);
				$crop = true;
			}

			if($crop){
				echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php?acao=crop&id=$id'>";
			} else {
				echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
			}
		}
	}
	elseif($acao == 'crop'){
		if(!$_POST){
			$sql = mysql_query("select * from ".NOTICIAS." where idnoticia = '".$id."'");
			?>
            <div class="conteudo">
				<form name="" id="" action="?acao=crop" method="post" enctype="multipart/form-data">
                    <p>Dicas de utilização:</p>
                    <p>1) Arraste o pontilhado até a área que você deseja na imagem (a imagem será recortada nesse ponto, sendo exibida no site);</p>
                    <p>2) Clique no botão 'Salvar' abaixo da imagem.</p>
                    <?
                    $contador = 0;
                    while($rs = mysql_fetch_assoc($sql)){

                        #eu sei que fazer assim fica uma droga, mas não tinha opções, eu juro - maicon
                        $hidden .= '
                        <input type="hidden" name="imagem-'.$contador.'" id="imagem-'.$contador.'" value="'.$rs['imagem'].'" />
    
                        <input type="hidden" name="x-'.$contador.'" id="x-'.$contador.'" value="0" />
                        <input type="hidden" name="y-'.$contador.'" id="y-'.$contador.'" value="0" />
                        <input type="hidden" name="x2-'.$contador.'" id="x2-'.$contador.'" value="0" />
                        <input type="hidden" name="y2-'.$contador.'" id="y2-'.$contador.'" value="0" />
                        <input type="hidden" name="w-'.$contador.'" id="w-'.$contador.'" value="0" />
                        <input type="hidden" name="h-'.$contador.'" id="h-'.$contador.'" value="0" />';
    
                        $jq .= "
                        $('#img-".$contador."').Jcrop({
                            onChange : preview".$contador.",
                            onSelect : preview".$contador.",
                            minSize : [150,113],
							setSelect : [0,0,150,113],
                            aspectRatio : 150/113
                        });";
    
                        $js .= "
                        function preview".$contador."(p){
                            $('#x-".$contador."').val(p.x);
                            $('#y-".$contador."').val(p.y);
                            $('#x2-".$contador."').val(p.x2);
                            $('#y2-".$contador."').val(p.y2);
                            $('#w-".$contador."').val(p.w);
                            $('#h-".$contador."').val(p.h);
						}";
					?>
                    <div class="crop"><img src="<?=$path_temp.$rs['imagem']?>" id="img-<?=$contador?>" /></div>
                    <?
                    $contador++;
                    }
                    ?>
                    <input type="hidden" name="total" id="total" value="<?=$contador?>" />
					<?=$hidden?>
					<script type="text/javascript">
                        $(window).load(function(){ <?=$jq?> });
                        <?=$js?>
                    </script>
                    <div><input type="submit" name="btn-crop" id="btn-crop" value="Salvar" /></div>
                </form>
            </div>
		<?
		} else {

			$total = seguranca($_POST['total']);
			for($i = 0; $i <= $total; $i++){

				$img = seguranca($_POST['imagem-'.$i]);
				
				$x = intval($_POST['x-'.$i]);
				$y = intval($_POST['y-'.$i]);
				$w = intval($_POST['w-'.$i]);
				$h = intval($_POST['h-'.$i]);

				if($img != ''){
					$imgg = new canvas($path_temp.$img);
					$imgg->posicaoCrop($x,$y);
					$imgg->redimensiona($w,$h,'crop');
					$imgg->grava($path_temp.$img,100);

					$imgg = new canvas($path_temp.$img);
					$imgg->redimensiona(320,240);
					$imgg->grava($path.$img,100);

					$imgg = new canvas($path_temp.$img);
					$imgg->redimensiona(150,113);
					$imgg->grava($path_p.$img,100);

					if(is_file($path_temp.$img)) unlink($path_temp.$img);
				}
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	}
	elseif($acao == 'remover-img'){
		if($id != ''){

			$img = mysql_fetch_assoc(mysql_query("select * from ".NOTICIAS." where idnoticia = '".$id."'"));
			if(is_file($path_temp.$img['imagem'])) unlink($path_temp.$img['imagem']);
			if(is_file($path_p.$img['imagem'])) unlink($path_p.$img['imagem']);
			if(is_file($path.$img['imagem'])) unlink($path.$img['imagem']);

			atualizar(NOTICIAS,"imagem = null","idnoticia = '".$id."'");
		}
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php?acao=editar&id=$id'>";
	}
	elseif($acao == 'remover'){
		if(is_numeric($id)){
			
			#imagem
			$img = mysql_fetch_assoc(mysql_query("select * from ".NOTICIAS." where idnoticia = ".$id));
			if(is_file($path_temp.$img['imagem'])) unlink($path_temp.$img['imagem']);
			if(is_file($path_p.$img['imagem'])) unlink($path_p.$img['imagem']);
			if(is_file($path.$img['imagem'])) unlink($path.$img['imagem']);

			deletar(NOTICIAS,"where idnoticia = ".$id);

			#galeria
			$path = '../img/noticias/galeria/';
			$path_p = '../img/noticias/galeria/p/';
			$path_temp = '../img/noticias/galeria/temp/';

			$sql = mysql_query("select * from ".NOTICIAS_IMGS." where idnoticia = ".$id);
			while($rs = mysql_fetch_assoc($sql)){
				if(is_file($path_temp.$rs['imagem'])) unlink($path_temp.$rs['imagem']);
				if(is_file($path_p.$rs['imagem'])) unlink($path_p.$rs['imagem']);
				if(is_file($path.$rs['imagem'])) unlink($path.$rs['imagem']);
			}
			deletar(NOTICIAS_IMGS,"where idnoticia = ".$id);

		}

		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
	}
	?>
</div>
<? include("include-rodape.php") ?>
