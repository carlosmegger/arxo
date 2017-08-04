<?
include("include-topo.php");

switch($idioma){
	case 'br': $tit = ' &raquo; Português'; break;
	case 'en': $tit = ' &raquo; Inglês'; break;
	case 'es': $tit = ' &raquo; Espanhol'; break;
}
?>
<div id="conteudo">
	<div class="topo">
		<h1>COMUNICADO<?=$tit?></h1>
		<div><a href="javascript:history.back()" class="voltar">&laquo; voltar</a></div>
	</div>

	<?
	if($acao == ''){

		$query = mysql_query("select * from ".INSTITUTO." order by idioma asc");

		if(mysql_num_rows($query) == 0){ ?>
        	<p>N&atilde;o há itens cadastrados!</p>
		<? } else { ?>
			<div class="listagem">
            	<div class="cabecalho">
                	<span class="idioma">Idioma</span>
                    <span class="titulo">Título</span>
                    <span class="editar">Editar</span>
					<div class="clear"></div>
				</div>
				<? while($rs = mysql_fetch_assoc($query)){ ?>
                <div class="caixa-instituto">
					<span class="idioma"><img src="../img/sistema/<?=$rs['idioma']?>.png" alt="<?=$rs['idioma']?>" /></span>
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
			include('form/form-instituto.php');
			echo '</div>';
		} else {

			$idioma = seguranca($_POST['idioma']);
			$titulo = seguranca($_POST['titulo']);
			$descricao = seguranca($_POST['descricao']);
			$hidden = seguranca($_POST['hidden']);

			$dados = "titulo = '".$titulo."',descricao = '".$descricao."'";
			atualizar(INSTITUTO,$dados,"idioma = '".$idioma."'");
			
			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php?atualizado=true'>";
		}
	}
	?>
</div>
<? include("include-rodape.php"); ?>