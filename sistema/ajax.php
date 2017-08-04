<?
require_once("../scripts/conexao.php");
require_once("../scripts/funcoes.php");
require_once("../scripts/mysql.php");
require_once("../scripts/img.canvas.php");
require_once("../phpmailer/class.phpmailer.php");

$acao = $_GET['acao'];
$busca = seguranca($_GET['busca']);
$tipo = seguranca($_GET['tipo']);
$setor = seguranca($_GET['setor']);

if(isset($acao) && $acao == 'posicao'){
	$posicao = intval($_GET['posicao']);
	$id = intval($_GET['id']);
	$campo = seguranca($_GET['campo']);
	$tabela = seguranca($_GET['tabela']);

	setPosicao($posicao,$id,$campo,$tabela);
	echo 'ok';
}
elseif(isset($acao) && $acao == 'posiciona'){
	$posicoes = seguranca($_GET['posicoes']);
	$tabela = seguranca($_GET['tabela']);
	$campo = seguranca($_GET['campo']);
	$tipo = seguranca($_GET['tipo']);
	$idproduto = seguranca($_GET['idproduto']);

	$posicoes = explode(';',$posicoes);

	$w = " where ";
	if($tipo != ''){
		$cond .= $w." tipo = '".$tipo."'";
		$w = " and ";
	}
	if($idproduto != ''){
		$cond .= $w." idproduto = '".$idproduto."'";
		$w = " and ";
	}

	$posicao = mysql_fetch_assoc(mysql_query("select count(*) as total from ".$tabela." ".$cond));
	$posicao = $posicao['total'];

	unset($cond);
	foreach($posicoes as $chave => $valor){
		if($valor != '' && $valor != 'undefined'){
			$cond = $campo.' = '.$valor;
			if($tipo != ''){
				$w = " and ";
				$cond .= $w." tipo = '".$tipo."' ";
			}
			if($idproduto != ''){
				$w = " and ";
				$cond .= $w." idproduto = '".$idproduto."' ";
			}

			atualizar($tabela,"posicao = ".$posicao,$cond);
			$posicao--;
		}
	}
}
elseif(isset($acao) && $acao == 'ativo'){
	$check = seguranca($_GET['check']);
	$id = intval($_GET['id']);
	$tabela = seguranca($_GET['tabela']);
	$campo = seguranca($_GET['campo']);
	$dados = "ativo = '$check'";

	atualizar($tabela,$dados,$campo." = ".$id);
	echo 'ok';
}
elseif(isset($acao) && $acao == 'exibir'){
	$check = seguranca($_GET['check']);
	$valor = seguranca($_GET['valor']);
	$tabela = seguranca($_GET['tabela']);
	$campo = seguranca($_GET['campo']);
	$dados = "exibir = '$check'";

	atualizar($tabela,$dados,$campo." = '".$valor."'");
	echo 'ok';
}
elseif(isset($acao) && $acao == 'ok'){
	$check = seguranca($_GET['check']);
	$id = intval($_GET['id']);
	$tabela = seguranca($_GET['tabela']);
	$campo = seguranca($_GET['campo']);
	$dados = "ok = '$check'";

	atualizar($tabela,$dados,$campo." = ".$id);
	echo 'ok';
}
elseif(isset($acao) && $acao == 'destaque'){
	$check = seguranca($_GET['check']);
	$id = intval($_GET['id']);
	$tabela = seguranca($_GET['tabela']);
	$campo = seguranca($_GET['campo']);
	$dados = "destaque = '".$check."'";

	atualizar($tabela,$dados,$campo." = ".$id);
	echo 'ok';
}
elseif(isset($acao) && $acao == 'destaque-unico'){
	$check = seguranca($_GET['check']);
	$id = intval($_GET['id']);
	$tabela = seguranca($_GET['tabela']);
	$campo = seguranca($_GET['campo']);
	$idgaleria = seguranca($_GET['idgaleria']);
	$dados = "destaque = '".$check."'";

	if($idgaleria == ''){
		atualizar($tabela,"destaque = 'N'","1 = 1");
	} else {
		atualizar($tabela,"destaque = 'N'","idcolecao = '".$idgaleria."'");
	}
	atualizar($tabela,$dados,$campo." = ".$id);
	echo 'ok';
}
elseif(isset($acao) && $acao == 'categorias'){

	$idioma = seguranca($_GET['idioma']);
	$tipo = seguranca($_GET['tipo']);
	$selected = intval($_GET['selected']);
	
	$retorno .= '<option value="0">Selecione</option>';
	$sql = mysql_query("select * from ".CATEGORIAS." where tipo = '".$tipo."' and idioma = '".$idioma."' order by titulo asc");
	while($rs = mysql_fetch_assoc($sql)){
		$sel = ($rs['idcategoria'] == $selected) ? ' selected="selected"' : '';
		$retorno .= '<option value="'.$rs['idcategoria'].'"'.$sel.'>'.$rs['titulo'].'</option>';
	}
	echo $retorno;

}
elseif(isset($acao) && $acao == 'categorias-imgs'){

	$path = '../img/categorias/galeria/';
	$path_p = '../img/categorias/galeria/p/';
	$path_temp = '../img/categorias/galeria/temp/';

	$idcategoria = $_POST['idcategoria'];
	$imagem = $_FILES['files'];
	$posicao = proxPosicao(CATEGORIAS_IMGS,'asc',"idcategoria = '".$idcategoria."'");

	if($imagem['name'][0] != ''){
		
		inserir(CATEGORIAS_IMGS,"idcategoria,ativo,posicao","'".$idcategoria."','S','".$posicao."'");
		$ultimo = ultimoID();

		$img = $ultimo.'-'.corrigeNome($imagem['name'][0]);
		move_uploaded_file($imagem['tmp_name'][0],$path_temp.$img);
		
		$tamanho = getimagesize($path_temp.$img);
		if($tamanho[0] > 800){
			$imgg = new canvas($path_temp.$img);
			$imgg->redimensiona(800,'');
			$imgg->grava($path_temp.$img,90);
		}

		$imgg = new canvas($path_temp.$img);
		$imgg->hexa('#fff');
		$imgg->redimensiona(800,600,'preenchimento');
		$imgg->grava($path.$img,90);

		$imgg = new canvas($path_temp.$img);
		$imgg->hexa('#fff');
		$imgg->redimensiona(150,113,'preenchimento');
		$imgg->grava($path_p.$img,90);

		atualizar(CATEGORIAS_IMGS,"imagem = '".$img."'","idimg = ".$ultimo);

		$adicionados['files'][] = array('name' => utf8_encode($img),
										'size' => $imagem['size'][0],
										'url' => utf8_encode($http.'img/categorias/galeria/'.$img),
										'thumbnailUrl' => utf8_encode($http.'img/categorias/galeria/p/'.$img),
										'type' => utf8_encode($imagem['type'][0]),
										'deleteUrl' => utf8_encode($sistema.'ajax.php?acao=categorias-imgs-deletar&img='.$img.'&idimg='.$ultimo),
										'deleteType' => 'DELETE');
	}

	echo json_encode($adicionados);

}
elseif(isset($acao) && $acao == 'categorias-imgs-deletar'){

	$path = '../img/categorias/galeria/';
	$path_p = '../img/categorias/galeria/p/';
	$path_temp = '../img/categorias/galeria/temp/';

	$img = seguranca($_GET['img']);
	$idimg = seguranca($_GET['idimg']);

	if(is_file($path.$img)) unlink($path.$img);
	if(is_file($path_p.$img)) unlink($path_p.$img);
	if(is_file($path_temp.$img)) unlink($path_temp.$img);

	deletar(CATEGORIAS_IMGS,"where idimg = ".$idimg);
	
}
elseif(isset($acao) && $acao == 'produtos-imgs'){

	$path = '../img/produtos/galeria/';
	$path_p = '../img/produtos/galeria/p/';
	$path_temp = '../img/produtos/galeria/temp/';

	$idproduto = $_POST['idproduto'];
	$imagem = $_FILES['files'];
	$posicao = proxPosicao(PRODUTOS_IMGS,'asc',"idproduto = '".$idproduto."'");

	if($imagem['name'][0] != ''){
		
		inserir(PRODUTOS_IMGS,"idproduto,ativo,posicao","'".$idproduto."','S','".$posicao."'");
		$ultimo = ultimoID();

		$img = $ultimo.'-'.corrigeNome($imagem['name'][0]);
		move_uploaded_file($imagem['tmp_name'][0],$path_temp.$img);
		
		$tamanho = getimagesize($path_temp.$img);
		if($tamanho[0] > 800){
			$imgg = new canvas($path_temp.$img);
			$imgg->redimensiona(800,'');
			$imgg->grava($path_temp.$img,90);
		}

		$imgg = new canvas($path_temp.$img);
		$imgg->hexa('#fff');
		$imgg->redimensiona(800,600,'preenchimento');
		$imgg->grava($path.$img,90);

		$imgg = new canvas($path_temp.$img);
		$imgg->hexa('#fff');
		$imgg->redimensiona(150,113,'preenchimento');
		$imgg->grava($path_p.$img,90);

		atualizar(PRODUTOS_IMGS,"imagem = '".$img."'","idimg = ".$ultimo);

		$adicionados['files'][] = array('name' => utf8_encode($img),
										'size' => $imagem['size'][0],
										'url' => utf8_encode($http.'img/produtos/galeria/'.$img),
										'thumbnailUrl' => utf8_encode($http.'img/produtos/galeria/p/'.$img),
										'type' => utf8_encode($imagem['type'][0]),
										'deleteUrl' => utf8_encode($sistema.'ajax.php?acao=produtos-imgs-deletar&img='.$img.'&idimg='.$ultimo),
										'deleteType' => 'DELETE');
	}

	echo json_encode($adicionados);

}
elseif(isset($acao) && $acao == 'produtos-imgs-deletar'){

	$path = '../img/produtos/galeria/';
	$path_p = '../img/produtos/galeria/p/';
	$path_temp = '../img/produtos/galeria/temp/';

	$img = seguranca($_GET['img']);
	$idimg = seguranca($_GET['idimg']);

	if(is_file($path.$img)) unlink($path.$img);
	if(is_file($path_p.$img)) unlink($path_p.$img);
	if(is_file($path_temp.$img)) unlink($path_temp.$img);

	deletar(PRODUTOS_IMGS,"where idimg = ".$idimg);
	
}
elseif(isset($acao) && $acao == 'remover-produto-tit'){
	$path_tit = '../img/produtos/titulo/';

	$idproduto = intval($_GET['idproduto']);
	$img = seguranca($_GET['img']);
	if(is_file($path_tit.$img)) unlink($path_tit.$img);

	atualizar(PRODUTOS,"imagem_tit = null","idproduto = ".$idproduto);
	echo 'ok';
}
elseif(isset($acao) && $acao == 'remover-produto-banner'){
	$path_banner = '../img/produtos/banner/';

	$idproduto = intval($_GET['idproduto']);
	$img = seguranca($_GET['img']);
	if(is_file($path_banner.$img)) unlink($path_banner.$img);

	atualizar(PRODUTOS,"imagem_banner = null","idproduto = ".$idproduto);
	echo 'ok';
}
elseif(isset($acao) && $acao == 'noticias-imgs'){

	$path = '../img/noticias/galeria/';
	$path_p = '../img/noticias/galeria/p/';
	$path_temp = '../img/noticias/galeria/temp/';

	$idnoticia = $_POST['idnoticia'];
	$imagem = $_FILES['files'];
	$posicao = proxPosicao(NOTICIAS_IMGS,'asc',"idnoticia = '".$idnoticia."'");

	if($imagem['name'][0] != ''){
		
		inserir(NOTICIAS_IMGS,"idnoticia,ativo,posicao","'".$idnoticia."','S','".$posicao."'");
		$ultimo = ultimoID();

		$img = $ultimo.'-'.corrigeNome($imagem['name'][0]);
		move_uploaded_file($imagem['tmp_name'][0],$path_temp.$img);
		
		$tamanho = getimagesize($path_temp.$img);
		if($tamanho[0] > 800){
			$imgg = new canvas($path_temp.$img);
			$imgg->redimensiona(800,'');
			$imgg->grava($path_temp.$img,90);
		}

		$imgg = new canvas($path_temp.$img);
		$imgg->hexa('#fff');
		$imgg->redimensiona(800,600,'preenchimento');
		$imgg->grava($path.$img,90);

		$imgg = new canvas($path_temp.$img);
		$imgg->hexa('#fff');
		$imgg->redimensiona(150,113,'preenchimento');
		$imgg->grava($path_p.$img,90);

		atualizar(NOTICIAS_IMGS,"imagem = '".$img."'","idimg = ".$ultimo);

		$adicionados['files'][] = array('name' => utf8_encode($img),
										'size' => $imagem['size'][0],
										'url' => utf8_encode($http.'img/noticias/galeria/'.$img),
										'thumbnailUrl' => utf8_encode($http.'img/noticias/galeria/p/'.$img),
										'type' => utf8_encode($imagem['type'][0]),
										'deleteUrl' => utf8_encode($sistema.'ajax.php?acao=noticias-imgs-deletar&img='.$img.'&idimg='.$ultimo),
										'deleteType' => 'DELETE');
	}

	echo json_encode($adicionados);

}
elseif(isset($acao) && $acao == 'noticias-imgs-deletar'){

	$path = '../img/noticias/galeria/';
	$path_p = '../img/noticias/galeria/p/';
	$path_temp = '../img/noticias/galeria/temp/';

	$img = seguranca($_GET['img']);
	$idimg = seguranca($_GET['idimg']);

	if(is_file($path.$img)) unlink($path.$img);
	if(is_file($path_p.$img)) unlink($path_p.$img);
	if(is_file($path_temp.$img)) unlink($path_temp.$img);

	deletar(NOTICIAS_IMGS,"where idimg = ".$idimg);

}
elseif(isset($acao) && $acao == 'instituto-galeria'){

	$path = '../img/instituto/galeria/';
	$path_p = '../img/instituto/galeria/p/';
	$path_temp = '../img/instituto/galeria/temp/';

	$imagem = $_FILES['files'];
	$posicao = proxPosicao(INSTITUTO_GAL,'asc');

	if($imagem['name'][0] != ''){
		
		inserir(INSTITUTO_GAL,"ativo,posicao","'S','".$posicao."'");
		$ultimo = ultimoID();

		$img = $ultimo.'-'.corrigeNome($imagem['name'][0]);
		move_uploaded_file($imagem['tmp_name'][0],$path_temp.$img);
		
		$tamanho = getimagesize($path_temp.$img);
		if($tamanho[0] > 800){
			$imgg = new canvas($path_temp.$img);
			$imgg->redimensiona(800,'');
			$imgg->grava($path_temp.$img,90);
		}

		$imgg = new canvas($path_temp.$img);
		$imgg->hexa('#fff');
		$imgg->redimensiona(800,600,'preenchimento');
		$imgg->grava($path.$img,90);

		$imgg = new canvas($path_temp.$img);
		$imgg->hexa('#fff');
		$imgg->redimensiona(150,113,'preenchimento');
		$imgg->grava($path_p.$img,90);

		atualizar(INSTITUTO_GAL,"imagem = '".$img."'","idimg = ".$ultimo);

		$adicionados['files'][] = array('name' => utf8_encode($img),
										'size' => $imagem['size'][0],
										'url' => utf8_encode($http.'img/instituto/galeria/'.$img),
										'thumbnailUrl' => utf8_encode($http.'img/instituto/galeria/p/'.$img),
										'type' => utf8_encode($imagem['type'][0]),
										'deleteUrl' => utf8_encode($sistema.'ajax.php?acao=instituto-gal-deletar&img='.$img.'&idimg='.$ultimo),
										'deleteType' => 'DELETE');
	}

	echo json_encode($adicionados);

}
elseif(isset($acao) && $acao == 'instituto-gal-deletar'){

	$path = '../img/instituto/galeria/';
	$path_p = '../img/instituto/galeria/p/';
	$path_temp = '../img/instituto/galeria/temp/';

	$img = seguranca($_GET['img']);
	$idimg = seguranca($_GET['idimg']);

	if(is_file($path.$img)) unlink($path.$img);
	if(is_file($path_p.$img)) unlink($path_p.$img);
	if(is_file($path_temp.$img)) unlink($path_temp.$img);

	deletar(INSTITUTO_GAL,"where idimg = ".$idimg);

}
elseif(isset($acao) && $acao == 'comunicacao-galeria'){

	$path = '../img/comunicacao/galeria/';
	$path_p = '../img/comunicacao/galeria/p/';
	$path_temp = '../img/comunicacao/galeria/temp/';

	$imagem = $_FILES['files'];
	$posicao = proxPosicao(COMUNICACAO_GAL,'asc');

	if($imagem['name'][0] != ''){
		
		inserir(COMUNICACAO_GAL,"ativo,posicao","'S','".$posicao."'");
		$ultimo = ultimoID();

		$img = $ultimo.'-'.corrigeNome($imagem['name'][0]);
		move_uploaded_file($imagem['tmp_name'][0],$path_temp.$img);
		
		$tamanho = getimagesize($path_temp.$img);
		if($tamanho[0] > 800){
			$imgg = new canvas($path_temp.$img);
			$imgg->redimensiona(800,'');
			$imgg->grava($path_temp.$img,90);
		}

		$imgg = new canvas($path_temp.$img);
		$imgg->hexa('#fff');
		$imgg->redimensiona(800,600,'preenchimento');
		$imgg->grava($path.$img,90);

		$imgg = new canvas($path_temp.$img);
		$imgg->hexa('#fff');
		$imgg->redimensiona(150,113,'preenchimento');
		$imgg->grava($path_p.$img,90);

		atualizar(COMUNICACAO_GAL,"imagem = '".$img."'","idimg = ".$ultimo);

		$adicionados['files'][] = array('name' => utf8_encode($img),
										'size' => $imagem['size'][0],
										'url' => utf8_encode($http.'img/comunicacao/galeria/'.$img),
										'thumbnailUrl' => utf8_encode($http.'img/comunicacao/galeria/p/'.$img),
										'type' => utf8_encode($imagem['type'][0]),
										'deleteUrl' => utf8_encode($sistema.'ajax.php?acao=comunicacao-gal-deletar&img='.$img.'&idimg='.$ultimo),
										'deleteType' => 'DELETE');
	}

	echo json_encode($adicionados);

}
elseif(isset($acao) && $acao == 'comunicacao-gal-deletar'){

	$path = '../img/comunicacao/galeria/';
	$path_p = '../img/comunicacao/galeria/p/';
	$path_temp = '../img/comunicacao/galeria/temp/';

	$img = seguranca($_GET['img']);
	$idimg = seguranca($_GET['idimg']);

	if(is_file($path.$img)) unlink($path.$img);
	if(is_file($path_p.$img)) unlink($path_p.$img);
	if(is_file($path_temp.$img)) unlink($path_temp.$img);

	deletar(COMUNICACAO_GAL,"where idimg = ".$idimg);

}
elseif(isset($acao) && $acao == 'simposio-imgs'){

	$path = '../img/simposio/galeria/';
	$path_p = '../img/simposio/galeria/p/';
	$path_temp = '../img/simposio/galeria/temp/';

	$idgaleria = $_POST['idgaleria'];
	$imagem = $_FILES['files'];
	$posicao = proxPosicao(SIMPOSIO_IMGS,'asc',"idgaleria = '".$idgaleria."'");

	if($imagem['name'][0] != ''){
		
		inserir(SIMPOSIO_IMGS,"idgaleria,ativo,posicao","'".$idgaleria."','S','".$posicao."'");
		$ultimo = ultimoID();

		$img = $ultimo.'-'.corrigeNome($imagem['name'][0]);
		move_uploaded_file($imagem['tmp_name'][0],$path_temp.$img);
		
		$tamanho = getimagesize($path_temp.$img);
		if($tamanho[0] > 800){
			$imgg = new canvas($path_temp.$img);
			$imgg->redimensiona(800,'');
			$imgg->grava($path_temp.$img,90);
		}

		$imgg = new canvas($path_temp.$img);
		$imgg->hexa('#fff');
		$imgg->redimensiona(800,600,'preenchimento');
		$imgg->grava($path.$img,90);

		$imgg = new canvas($path_temp.$img);
		$imgg->hexa('#fff');
		$imgg->redimensiona(150,113,'preenchimento');
		$imgg->grava($path_p.$img,90);

		atualizar(SIMPOSIO_IMGS,"imagem = '".$img."'","idimg = ".$ultimo);

		$adicionados['files'][] = array('name' => utf8_encode($img),
										'size' => $imagem['size'][0],
										'url' => utf8_encode($http.'img/simposio/galeria/'.$img),
										'thumbnailUrl' => utf8_encode($http.'img/simposio/galeria/p/'.$img),
										'type' => utf8_encode($imagem['type'][0]),
										'deleteUrl' => utf8_encode($sistema.'ajax.php?acao=simposio-imgs-deletar&img='.$img.'&idimg='.$ultimo),
										'deleteType' => 'DELETE');
	}

	echo json_encode($adicionados);

}
elseif(isset($acao) && $acao == 'simposio-imgs-deletar'){

	$path = '../img/simposio/galeria/';
	$path_p = '../img/simposio/galeria/p/';
	$path_temp = '../img/simposio/galeria/temp/';

	$img = seguranca($_GET['img']);
	$idimg = seguranca($_GET['idimg']);

	if(is_file($path.$img)) unlink($path.$img);
	if(is_file($path_p.$img)) unlink($path_p.$img);
	if(is_file($path_temp.$img)) unlink($path_temp.$img);

	deletar(SIMPOSIO_IMGS,"where idimg = ".$idimg);

}
elseif(isset($acao) && $acao == 'revistas-imgs'){

	$path = '../img/revistas/galeria/';
	$path_p = '../img/revistas/galeria/p/';
	$path_m = '../img/revistas/galeria/m/';
	$path_temp = '../img/revistas/galeria/temp/';

	$idrevista = $_POST['idrevista'];
	$imagem = $_FILES['files'];
	$posicao = proxPosicao(REVISTAS_IMGS,'asc',"idrevista = '".$idrevista."'");

	if($imagem['name'][0] != ''){
		
		inserir(REVISTAS_IMGS,"idrevista,ativo,posicao","'".$idrevista."','S','".$posicao."'");
		$ultimo = ultimoID();

		$img = $ultimo.'-'.corrigeNome($imagem['name'][0]);
		move_uploaded_file($imagem['tmp_name'][0],$path_temp.$img);
		
		/*
		$tamanho = getimagesize($path_temp.$img);
		if($tamanho[0] > 800){
			$imgg = new canvas($path_temp.$img);
			$imgg->redimensiona(800,'');
			$imgg->grava($path_temp.$img,90);
		}
		*/

		$imgg = new canvas($path_temp.$img);
		$imgg->redimensiona(1500,2000);
		$imgg->grava($path.$img,90);

		$imgg = new canvas($path_temp.$img);
		$imgg->redimensiona(600,800);
		$imgg->grava($path_m.$img,90);

		$imgg = new canvas($path_temp.$img);
		$imgg->redimensiona(100,133);
		$imgg->grava($path_p.$img,90);

		atualizar(REVISTAS_IMGS,"imagem = '".$img."'","idimg = ".$ultimo);

		$adicionados['files'][] = array('name' => utf8_encode($img),
										'size' => $imagem['size'][0],
										'url' => utf8_encode($http.'img/revistas/galeria/'.$img),
										'thumbnailUrl' => utf8_encode($http.'img/revistas/galeria/p/'.$img),
										'type' => utf8_encode($imagem['type'][0]),
										'deleteUrl' => utf8_encode($sistema.'ajax.php?acao=revistas-imgs-deletar&img='.$img.'&idimg='.$ultimo),
										'deleteType' => 'DELETE');
	}

	echo json_encode($adicionados);

}
elseif(isset($acao) && $acao == 'revistas-imgs-deletar'){

	$path = '../img/revistas/galeria/';
	$path_p = '../img/revistas/galeria/p/';
	$path_m = '../img/revistas/galeria/m/';
	$path_temp = '../img/revistas/galeria/temp/';

	$img = seguranca($_GET['img']);
	$idimg = seguranca($_GET['idimg']);

	if(is_file($path.$img)) unlink($path.$img);
	if(is_file($path_p.$img)) unlink($path_p.$img);
	if(is_file($path_m.$img)) unlink($path_m.$img);
	if(is_file($path_temp.$img)) unlink($path_temp.$img);

	deletar(REVISTAS_IMGS,"where idimg = ".$idimg);

}
elseif(isset($acao) && $acao == 'relatorios-imgs'){

	$path = '../img/relatorios/galeria/';
	$path_p = '../img/relatorios/galeria/p/';
	$path_temp = '../img/relatorios/galeria/temp/';

	$idrelatorio = $_POST['idrelatorio'];
	$imagem = $_FILES['files'];
	$posicao = proxPosicao(RELATORIOS_IMGS,'asc',"idrelatorio = '".$idrelatorio."'");

	if($imagem['name'][0] != ''){
		
		inserir(RELATORIOS_IMGS,"idrelatorio,ativo,posicao","'".$idrelatorio."','S','".$posicao."'");
		$ultimo = ultimoID();

		$img = $ultimo.'-'.corrigeNome($imagem['name'][0]);
		move_uploaded_file($imagem['tmp_name'][0],$path_temp.$img);
		
		$tamanho = getimagesize($path_temp.$img);
		if($tamanho[0] > 800){
			$imgg = new canvas($path_temp.$img);
			$imgg->redimensiona(800,'');
			$imgg->grava($path_temp.$img,90);
		}

		$imgg = new canvas($path_temp.$img);
		$imgg->hexa('#fff');
		$imgg->redimensiona(600,800,'preenchimento');
		$imgg->grava($path.$img,90);

		$imgg = new canvas($path_temp.$img);
		$imgg->hexa('#fff');
		$imgg->redimensiona(100,133,'preenchimento');
		$imgg->grava($path_p.$img,90);

		atualizar(RELATORIOS_IMGS,"imagem = '".$img."'","idimg = ".$ultimo);

		$adicionados['files'][] = array('name' => utf8_encode($img),
										'size' => $imagem['size'][0],
										'url' => utf8_encode($http.'img/relatorios/galeria/'.$img),
										'thumbnailUrl' => utf8_encode($http.'img/relatorios/galeria/p/'.$img),
										'type' => utf8_encode($imagem['type'][0]),
										'deleteUrl' => utf8_encode($sistema.'ajax.php?acao=relatorios-imgs-deletar&img='.$img.'&idimg='.$ultimo),
										'deleteType' => 'DELETE');
	}

	echo json_encode($adicionados);

}
elseif(isset($acao) && $acao == 'relatorios-imgs-deletar'){

	$path = '../img/relatorios/galeria/';
	$path_p = '../img/relatorios/galeria/p/';
	$path_temp = '../img/relatorios/galeria/temp/';

	$img = seguranca($_GET['img']);
	$idimg = seguranca($_GET['idimg']);

	if(is_file($path.$img)) unlink($path.$img);
	if(is_file($path_p.$img)) unlink($path_p.$img);
	if(is_file($path_temp.$img)) unlink($path_temp.$img);

	deletar(RELATORIOS_IMGS,"where idimg = ".$idimg);

}
elseif($acao == 'simposio-cadastro'){
	$status = seguranca($_GET['status']);
	atualizar(CONFIGS,"valor = '".$status."'","diretiva = 'cadastro_simposio'");
}
elseif($acao == 'email-usuario'){
	if($_POST){

		$email = seguranca($_POST['email']);
		$idusuario = seguranca($_POST['idusuario']);

		$cond = ($idusuario != '') ? " and idusuario != '".$idusuario."'" : "";
		$sql  = mysql_query("select * from ".USUARIOS." where email = '".$email."' ".$cond);
		$rows = mysql_num_rows($sql);

		echo ($rows == 0) ? true : false;
	}
}
elseif($acao == 'exibe-produtos-rel'){
	if($_POST){

		$idioma = strip_tags($_POST['idioma']);
		$idproduto = strip_tags($_POST['idproduto']);
		$selecionados = strip_tags($_POST['selecionados']);

		#$query = "select * from ".PRODUTOS." where idproduto not in ('".$idproduto."') and idioma = '".$idioma."' order by posicao desc";
		$query  =  "select distinct
						p.*,
						(select count(*) from ".PRODUTOS_REL." pr where pr.idproduto = '".$idproduto."' and p.idproduto = pr.idrelacionado) as checked
					from
						".PRODUTOS." p
					where
						p.idproduto not in ('".$idproduto."')
					and p.idioma = '".$idioma."'
					order by p.titulo_completo asc";

		$sql = mysql_query($query);
		if(mysql_num_rows($sql) > 0){
			while($rs = mysql_fetch_assoc($sql)){
				$checked = ($rs['checked'] == 1) ? ' checked="checked"' : '';

				$retorno .= '<label>';
				$retorno .= '	<input type="checkbox" name="produto_rel[]" value="'.$rs['idproduto'].'" '.$checked.' />';
				$retorno .= '	<span class="img"><img src="../img/produtos/p/'.$rs['imagem'].'" alt="'.$rs['titulo_completo'].'" /></span>';
				$retorno .= '	<span class="tit">'.$rs['titulo_completo'].'</span>';
				$retorno .= '</label>';
			}
		} else {
			$retorno = '<p>Nenhum produto no idioma selecionado para relacionar!</p>';
		}
		echo $retorno;
	}
}
?>