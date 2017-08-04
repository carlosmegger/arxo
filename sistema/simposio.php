<?
include("include-topo.php");

$path_temp = '../img/simposio/temp/';
$path_p = '../img/simposio/p/';
$path = '../img/simposio/';
$path_edital = '../arquivos/simposio/edital/';

switch($idioma){
	case 'br' : $tit = ' &raquo; Português'; break;
	case 'en' : $tit = ' &raquo; Inglês'; break;
	case 'es' : $tit = ' &raquo; Espanhol'; break;
}
?>
<div id="conteudo">
	<div class="topo">
		<h1>Simpósio de Esculturas<?=$tit?></h1>
        <div><a href="javascript:history.back()" class="voltar">&laquo; voltar</a></div>
	</div>

	<? if($acao == ''){ ?>

		<div class="simposio-cadastro">
        	<?
			$status = mysql_fetch_assoc(mysql_query("select * from ".CONFIGS." where diretiva = 'cadastro_simposio'"));
			switch($status['valor']){
				case 'S':
					$m1 = 'ativo';
					$m2 = 'inativar';
					$_class = 'ativo';
				break;
				case 'N':
					$m1 = 'inativo';
					$m2 = 'ativar';
					$_class = 'inativo';
				break;
			}
			?>
        	<p>O formulário de cadastro para o simpósio está <span class="<?=$_class?>"><?=$m1?></span> no momento!</p>
            <a href="#" data-status="<?=$status['valor']?>" class="simposio-status <?=$_class?>">clique aqui para <?=$m2?></a>
		</div>

		<?
		$query = mysql_query("select * from ".SIMPOSIO." order by idioma asc");

		if(mysql_num_rows($query) == 0){ ?>
        	<p>N&atilde;o há itens cadastrados!</p>
		<? } else { ?>
			<div class="listagem">
            	<div class="cabecalho">
                	<span class="idioma">Idioma</span>
                    <span class="preview">Preview</span>
                    <span class="titulo">Título</span>
                    <span class="editar">Editar</span>
					<div class="clear"></div>
				</div>
				<? while($rs = mysql_fetch_assoc($query)){ ?>
                <div class="caixa-simposio">
                	<span class="idioma"><img src="../img/sistema/<?=$rs['idioma']?>.png" alt="<?=$rs['idioma']?>" /></span>
                    <span class="preview">
                    	<? if($rs['imagem'] != ''){ ?>
                            <a href="<?=$path.$rs['imagem']?>" class="fancybox"><img src="<?=$path_p.$rs['imagem']?>" alt="<?=$rs['titulo']?>" /></a>
						<?
                        } else {
							echo '-';
						}
						?>
                    </span>
					<span class="titulo"><?=$rs['titulo']?></span>
                    <span class="editar"><a href="?acao=editar&idioma=<?=$rs['idioma']?>"><img src="../img/sistema/ico-editar.png" alt="editar" border="0" /></a></span>
                </div>
				<? } ?>
			</div>
			<?
		}
	}
	elseif($acao == 'editar'){
		
		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-simposio.php');
			echo '</div>';
		} else {

			$idioma = seguranca($_POST['idioma']);
			$titulo = seguranca($_POST['titulo']);
			$descricao = seguranca($_POST['descricao']);
			$imagem = $_FILES['imagem'];
			$hidden = seguranca($_POST['hidden']);
			$edital = $_FILES['edital'];
			$hidden_edital = seguranca($_POST['hidden_edital']);
			$termos_compromisso = seguranca($_POST['termos_compromisso']);

			$dados = "titulo = '".$titulo."',descricao = '".$descricao."',termos_compromisso = '".$termos_compromisso."'";
			atualizar(SIMPOSIO,$dados,"idioma = '".$idioma."'");
			
			if($imagem['name'] != ''){
				
				if(is_file($path_temp.$hidden)) unlink($path_temp.$hidden);
				if(is_file($path_p.$hidden)) unlink($path_p.$hidden);
				if(is_file($path.$hidden)) unlink($path.$hidden);

				$extensao = getExtensao($imagem['name']);
				$img = $idioma.'-'.corrigeNome($titulo).'.'.$extensao;
				move_uploaded_file($imagem['tmp_name'],$path_temp.$img);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(320,240);
				$imgg->grava($path.$img,100);

				$imgg = new canvas($path_temp.$img);
				$imgg->redimensiona(150,'');
				$imgg->grava($path_p.$img,100);

				atualizar(SIMPOSIO,"imagem = '".$img."'","idioma = '".$idioma."'");
				if(is_file($path_temp.$img)) unlink($path_temp.$img);
			}

			if($edital['name'] != ''){
				if(is_file($path_edital.$hidden_edital)) unlink($path_edital.$hidden_edital);

				$arq = $idioma.'-'.corrigeNome($edital['name']);
				move_uploaded_file($edital['tmp_name'],$path_edital.$arq);

				atualizar(SIMPOSIO,"edital = '".$arq."'","idioma = '".$idioma."'");
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php?atualizado=true'>";
		}
	}
	elseif($acao == 'remover-img'){
		if($idioma != ''){

			$img = mysql_fetch_assoc(mysql_query("select * from ".SIMPOSIO." where idioma = '".$idioma."'"));
			if(is_file($path_temp.$img['imagem'])) unlink($path_temp.$img['imagem']);
			if(is_file($path_p.$img['imagem'])) unlink($path_p.$img['imagem']);
			if(is_file($path.$img['imagem'])) unlink($path.$img['imagem']);

			atualizar(SIMPOSIO,"imagem = null","idioma = '".$idioma."'");
		}
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php?acao=editar&idioma=$idioma&atualizado=true'>";
	}
	elseif($acao == 'remover-edital'){
		if($idioma != ''){

			$arq = mysql_fetch_assoc(mysql_query("select * from ".SIMPOSIO." where idioma = '".$idioma."'"));
			if(is_file($path_edital.$arq['edital'])) unlink($path_edital.$arq['edital']);

			atualizar(SIMPOSIO,"edital = null","idioma = '".$idioma."'");
		}
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php?acao=editar&idioma=$idioma&atualizado=true'>";
	}
	?>
</div>
<? include("include-rodape.php"); ?>