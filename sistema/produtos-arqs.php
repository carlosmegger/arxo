<?
include("include-topo.php");

$path = '../arquivos/produtos/';

if($idproduto != ''){
	$tit = mysql_fetch_assoc(mysql_query("select * from ".PRODUTOS." where idproduto = '".$idproduto."'"));
}
?>
<div id="conteudo">
	<div class="topo">
		<h1>Arquivos &raquo; <?=$tit['titulo']?></h1>
		<div><a href="javascript:history.back()" class="voltar">&laquo; voltar</a></div>
	</div>

	<?
	if($acao == 'listar'){

		if(!$_POST){
			echo '<div class="formulario">';
			include('form/form-produtos-arqs.php');
			echo '</div>';
		} else {

			$idproduto = seguranca($_POST['idproduto']);

			for($i = 1; $i <= 5; $i++){

				$titulo = seguranca($_POST['titulo_'.$i]);
				$arquivo = $_FILES['arquivo_'.$i];
				$ativo = seguranca($_POST['ativo_'.$i]);
				$ativo = ($ativo == 'S') ? 'S' : 'N';
				$posicao = proxPosicao(PRODUTOS_ARQS,"asc","idproduto = '".$idproduto."'");

				if($titulo != '' && $arquivo['name'] != ''){

					$campos = "idproduto,titulo,ativo,posicao";
					$valores = "'".$idproduto."','".$titulo."','".$ativo."','".$posicao."'";
					inserir(PRODUTOS_ARQS,$campos,$valores);
					$ultimo = ultimoID();

					$arq = $ultimo.'-'.corrigeNome($arquivo['name']);
					move_uploaded_file($arquivo['tmp_name'],$path.$arq);

					atualizar(PRODUTOS_ARQS,"arquivo = '".$arq."'","idarq = ".$ultimo);
				}
			}

			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=produtos-arqs.php?acao=listar&idproduto=$idproduto&atualizado=true'>";
		}
	}
	elseif($acao == 'remover'){
		if(is_numeric($id)){
			$arq = mysql_fetch_assoc(mysql_query("select * from ".PRODUTOS_ARQS." where idarq = ".$id));
			if(is_file($path.$arq['arquivo'])) unlink($path.$arq['arquivo']);

			deletar(PRODUTOS_ARQS,"where idarq = ".$id);
		}

		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=produtos-arqs.php?acao=listar&idproduto=$idproduto'>";
	}
	?>
</div>
<? include("include-rodape.php"); ?>