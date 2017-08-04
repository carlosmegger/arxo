<?
include("include-topo.php");

$path_temp = '../img/noticias/temp/';
$path_p = '../img/noticias/p/';
$path = '../img/noticias/';
?>
<div id="conteudo">
	<div class="topo">
		<h1>Perguntas e Respostas</h1>
		<div>
		<? if ($acao == ''){ ?>
			<a href="?acao=adicionar" class="adicionar">adicionar</a>
		<? } else { ?>
			<a href="javascript:history.back()" class="voltar">&laquo; voltar</a>
		<? } ?>
		</div>
	</div>

	<?
	if($acao == ''){

		$query = selecionar('',FAQ,'order by ordem, id');

		if(mysql_num_rows($query) == 0){ ?>
			<p>N&atilde;o há itens cadastrados!</p>
		<? } else { ?>
			<div class="listagem">
				<div class="cabecalho">
					<span class="pergunta">Pergunta</span>
					<span class="editar">Editar</span>
					<span class="remover">Remover</span>
					<span class="posicao">Ordenar</span>
					<div class="clear"></div>
				</div>
				<? while ($rs = mysql_fetch_assoc($query)){ ?>
				<div class="caixa-faq posiciona" data-id="<?=$rs['id']?>">
					<span class="pergunta"><?=$rs['pergunta']?></span>
					<span class="editar"><a href="?acao=editar&id=<?=$rs['id']?>"><img src="../img/sistema/ico-editar.png" alt="editar" border="0" /></a></span>
					<span class="remover"><a href="javascript:void(0)" onClick="remover(<?=$rs['id']?>)"><img src="../img/sistema/ico-remover.gif" alt="remover" border="0" /></a></span>
					<span class="posicao"></span>
				</div>
				<? } ?>
			</div>
			<?
		}
	} elseif ($acao == 'adicionar'){

		if (!$_POST){
			echo '<div class="formulario">';
			include('form/form-faq.php');
			echo '</div>';
		} else {
			$pergunta = seguranca($_POST['pergunta']);
			$resposta = seguranca($_POST['resposta']);

			$campos = 'pergunta,resposta';
			$valores = "'".$pergunta."','".$resposta."'";
			inserir(FAQ,$campos,$valores);

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	} elseif ($acao == 'editar'){

		if (!$_POST){
			echo '<div class="formulario">';
			include('form/form-faq.php');
			echo '</div>';
		} else {
			$pergunta = seguranca($_POST['pergunta']);
			$resposta = seguranca($_POST['resposta']);

			$dados  =  "pergunta = '".$pergunta."',
						resposta = '".$resposta."'";

			atualizar(FAQ,$dados,"id = ".$id);

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
		}
	} elseif ($acao == 'remover'){
		if (is_numeric($id)){
			deletar(FAQ,"where id = ".$id);
		}
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=$page.php'>";
	}
	?>
</div>
<? include("include-rodape.php") ?>
