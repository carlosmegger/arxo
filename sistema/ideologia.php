<?
include("include-topo.php");

$path_temp = '../img/ideologia/temp/';
$path_p = '../img/ideologia/p/';
$path = '../img/ideologia/';

switch($idioma){
	case 'br': $tit = ' &raquo; Português'; break;
	case 'en': $tit = ' &raquo; Inglês'; break;
	case 'es': $tit = ' &raquo; Espanhol'; break;
}
?>
<div id="conteudo">
	<div class="topo">
		<h1>Ideologia<?=$tit?></h1>
        <div><a href="javascript:history.back()" class="voltar">&laquo; voltar</a></div>
	</div>

	<?
	if($acao == ''){

		$query = mysql_query("select * from ".IDEOLOGIA." order by idioma asc");

		if(mysql_num_rows($query) == 0){ ?>
        	<p>N&atilde;o há itens cadastrados!</p>
		<? } else { ?>
			<div class="listagem">
            	<div class="cabecalho">
                	<span class="idioma">Idioma</span>
                    <!--span class="preview">Preview</span-->
                    <span class="titulo">Título</span>
                    <span class="editar">Editar</span>
					<div class="clear"></div>
				</div>
				<? while($rs = mysql_fetch_assoc($query)){ ?>
                <div class="caixa-ideologia">
                	<span class="idioma"><img src="../img/sistema/<?=$rs['idioma']?>.png" alt="<?=$rs['idioma']?>" /></span>
                    <!--
                    <span class="preview">
                    	<? if($rs['imagem'] != ''){ ?>
                            <a href="<?=$path.$rs['imagem']?>" class="fancybox"><img src="<?=$path_p.$rs['imagem']?>" alt="<?=$rs['titulo']?>" /></a>
						<?
                        } else {
							echo '-';
						}
						?>
                    </span>
                    -->
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
			include('form/form-ideologia.php');
			echo '</div>';
		} else {

			$idioma = seguranca($_POST['idioma']);
			$titulo = seguranca($_POST['titulo']);
			$descricao = seguranca($_POST['descricao']);
			$imagem = $_FILES['imagem'];
			$hidden = seguranca($_POST['hidden']);

			$dados = "titulo = '".$titulo."',descricao = '".$descricao."'";
			atualizar(IDEOLOGIA,$dados,"idioma = '".$idioma."'");
			
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

				atualizar(IDEOLOGIA,"imagem = '".$img."'","idioma = '".$idioma."'");
				if(is_file($path_temp.$img)) unlink($path_temp.$img);
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php?atualizado=true'>";
		}
	}
	elseif($acao == 'remover-img'){
		if($idioma != ''){

			$img = mysql_fetch_assoc(mysql_query("select * from ".IDEOLOGIA." where idioma = '".$idioma."'"));
			if(is_file($path_temp.$img['imagem'])) unlink($path_temp.$img['imagem']);
			if(is_file($path_p.$img['imagem'])) unlink($path_p.$img['imagem']);
			if(is_file($path.$img['imagem'])) unlink($path.$img['imagem']);

			atualizar(IDEOLOGIA,"imagem = null","idioma = '".$idioma."'");
		}
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php?acao=editar&idioma=$idioma&atualizado=true'>";
	}
	?>
</div>
<? include("include-rodape.php"); ?>