<?
require_once('../scripts/conexao.php');
require_once('../scripts/funcoes.php');
require_once('../scripts/mysql.php');
require_once('../phpmailer/class.phpmailer.php');

$acao = !empty($_GET['acao'])?$_GET['acao']:'';
if($acao == 'orcamento'){

	header('Content-Type: application/json; charset=utf8');
	$json = array();

	/*
	require_once('../class/orcamento.php');
	
	try {
		$orcamento = new Orcamento();
		$orcamento->post();
		$orcamento->gravar();
		$json['status'] = true;
	} catch (Exception $e){
		$json['status'] = false;
		$json['msg'] = $e->getMessage();
	}
	echo json_encode($json);
	*/

	$idioma = seguranca($_POST['idioma']);
	$idproduto = seguranca($_POST['idproduto']);
	$tag = seguranca($_POST['tag']);
	$empresa = seguranca($_POST['empresa']);
	$nome = seguranca($_POST['nome']);
	$cnpj_cpf = seguranca($_POST['cnpj']);
	$email = seguranca($_POST['email']);
	$telefone = seguranca($_POST['telefone']);
	$mensagem = seguranca($_POST['mensagem']);
	$data = date('Y-m-d H:i:s');

	# insere
	$campos = "idioma,idproduto,empresa,nome,cnpj_cpf,email,telefone,mensagem,data";
	$valores = "'".$idioma."','".$idproduto."','".$empresa."','".$nome."','".$cnpj_cpf."','".$email."','".$telefone."','".$mensagem."','".$data."'";
	inserir(ORCAMENTOS,$campos,$valores);
	
	#produto
	require_once('../class/produto.php');
	$produto = new Produto($tag);
	
	#envia
	$corpo .= '<html><head><title>Arxo</title></head><body>';
	$corpo .= 'Orçamento através do site:<br />';
	$corpo .= '----------------------------------------------------<br />';
	$corpo .= '<strong>Produto:</strong> '.$produto->titulo_completo.'<br />';
	$corpo .= '----------------------------------------------------<br />';
	$corpo .= '<strong>Mensagem:</strong> '.$mensagem.'<br />';
	$corpo .= '----------------------------------------------------<br />';
	$corpo .= '<strong>Idioma:</strong> '.$idioma.'<br />';
	$corpo .= '<strong>Empresa:</strong> '.$empresa.'<br />';
	$corpo .= '<strong>Nome:</strong> '.$nome.'<br />';
	$corpo .= '<strong>CPF/CNPJ:</strong> '.$cnpj_cpf.'<br />';
	$corpo .= '<strong>E-mail:</strong> '.$email.'<br />';
	$corpo .= '<strong>Telefone:</strong> '.$telefone.'<br />';
	$corpo .= '<strong>Data de envio:</strong> '.converteData($data,'d/m/Y H:i:s').'<br />';
	$corpo .= '</body></html>';

	$mail = new PHPMailer();

	if($autenticado == true){
		$mail->IsSMTP();
		#$mail->SMTPDebug = 2;

		$mail->SMTPAuth = true;
		$mail->Host = $_host;
		$mail->Username = $_usuario;
		$mail->Password = $_senha;

		$mail->From = $_usuario;
	}

	$mail->FromName = $nome;
	#$mail->AddAddress('fabio.mallon@arxo.com');
	$mail->AddAddress('comunicacao@arxo.com');
	$mail->AddAddress('cidemar.zen@arxo.com');
	#mail->AddAddress('victor.compasso@arxo.com');
	$mail->AddAddress('claudia.marques@arxo.com');
	$mail->AddReplyTo($email,$nome);

	$mail->WordWrap = 50;
	$mail->IsHTML(true);
	$mail->Subject = utf8_decode('Arxo - Orçamento: '.$nome.'!');
	$mail->Body = utf8_decode($corpo);

	#$retorno = ($mail->Send()) ? 'ok' : 'erro';
	#echo $retorno;
	try {
		$mail->Send();
		$json['status'] = true;
	} catch (Exception $e){
		$json['status'] = false;
		$json['msg'] = 'Ocorreu um erro ao enviar sua mensagem!';
	}
	echo json_encode($json);

} elseif($acao == 'contato'){

	if($_POST){

		$idioma = seguranca($_POST['idioma']);
		$nome = seguranca($_POST['nome']);
		$email = seguranca($_POST['email']);
		$cidade_estado = seguranca($_POST['cidade_estado']);
		$telefone = seguranca($_POST['telefone']);
		$assunto = seguranca($_POST['assunto']);
		$mensagem = seguranca($_POST['mensagem']);
		$mensagem = nl2br2($mensagem);
		$data = date('Y-m-d H:i:s');

		# insere
		$campos = "idioma,nome,email,cidade_estado,telefone,assunto,mensagem,data";
		$valores = "'".$idioma."','".$nome."','".$email."','".$cidade_estado."','".$telefone."','".$assunto."','".$mensagem."','".$data."'";
		inserir(CONTATOS,$campos,$valores);

		# envia
		$corpo .= '<html><head><title>Arxo</title></head><body>';
		$corpo .= 'Contato através do site:<br />';
		$corpo .= '----------------------------------------------------<br />';
		$corpo .= '<strong>Assunto:</strong> '.$assunto.'<br />';
		$corpo .= '<strong>Mensagem:</strong> '.$mensagem.'<br />';
		$corpo .= '----------------------------------------------------<br />';
		$corpo .= '<strong>Nome:</strong> '.$nome.'<br />';
		$corpo .= '<strong>E-mail:</strong> '.$email.'<br />';
		$corpo .= '<strong>Cidade/Estado:</strong> '.$cidade_estado.'<br />';
		$corpo .= '<strong>Telefone:</strong> '.$telefone.'<br />';
		$corpo .= '<strong>Data de envio:</strong> '.converteData($data,'d/m/Y H:i:s').'<br />';
		$corpo .= '</body></html>';

		$mail = new PHPMailer();

		if($autenticado == true){
			$mail->IsSMTP();
			#$mail->SMTPDebug = 2;

			$mail->SMTPAuth = true;
			$mail->Host = $_host;
			$mail->Username = $_usuario;
			$mail->Password = $_senha;

			$mail->From = $_usuario;
		}

		$mail->FromName = $nome;
		$mail->AddAddress($destino);
		$mail->AddReplyTo($email,$nome);

		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		$mail->Subject = utf8_decode('Arxo - Contato: '.$nome.'!');
		$mail->Body = utf8_decode($corpo);

		$retorno = ($mail->Send()) ? 'ok' : 'erro';
		echo $retorno;

	}

}
elseif($acao == 'curriculo'){

	if($_POST){

		$path = '../arquivo/curriculos/';

		$idioma = seguranca($_POST['idioma']);
		$nome = seguranca($_POST['nome']);
		$telefone = seguranca($_POST['telefone']);
		$cidade_estado = seguranca($_POST['cidade_estado']);
		$email = seguranca($_POST['email']);
		$funcao_pretendida = seguranca($_POST['funcao_pretendida']);
		$arquivo = $_FILES['arquivo'];
		$data = date('Y-m-d H:i:s');
		$erro = false;
		$retorno = array();
		
		if($arquivo['name'] != '' && $arquivo['error'] == 0){
			$extensao = explode('.',$arquivo['name']);
			$extensao = end($extensao);

			$permitidas = array('pdf','doc','docx','txt');
			$tamanho = round($arquivo['size']/1024);
			
			if(in_array($extensao,$permitidas) && $tamanho <= 2000){
				$arq = corrigeNome($data).'-'.corrigeNome($arquivo['name']);
				move_uploaded_file($arquivo['tmp_name'],$path.$arq);
				
				$mime_type = mimetype($path.$arq);
				if($mime_type == 'plain' || $mime_type == 'pdf' || $mime_type == 'msword' || $mime_type == 'docx'){
					$erro = false;
				} else {
					$erro = true;
					@unlink($path.$arq);
				}

			} else {
				$erro = true;
			}
		}
		if($arquivo['error'] == 1){
			$erro = true;
		}

		if($erro == false){

			# banco de dados
			$campos .= "idioma,nome,telefone,cidade_estado,email,funcao_pretendida,arquivo,data";
			$valores .= "'".$idioma."','".$nome."','".$telefone."','".$cidade_estado."','".$email."','".$funcao_pretendida."','".$arq."','".$data."'";
			inserir(CURRICULOS,$campos,$valores);

			# envia
			$corpo .= '<html><head><title>Arxo</title></head><body>';
			$corpo .= 'Currículo através do site:<br />';
			$corpo .= '----------------------------------------------------<br />';
			$corpo .= '<strong>Função Pretendida:</strong> '.$arq.'<br />';
			$corpo .= '<strong>Anexo:</strong> '.$arq.'<br />';
			$corpo .= '----------------------------------------------------<br />';
			$corpo .= '<strong>Nome:</strong> '.$nome.'<br />';
			$corpo .= '<strong>Telefone:</strong> '.$telefone.'<br />';
			$corpo .= '<strong>Cidade/Estado:</strong> '.$cidade_estado.'<br />';
			$corpo .= '<strong>E-mail:</strong> '.$email.'<br />';
			$corpo .= '<strong>Data de envio:</strong> '.converteData($data,'d/m/Y H:i:s').'<br />';
			$corpo .= '</body></html>';
		
			$mail = new PHPMailer();
			$mail->IsSMTP();
	
			if($autenticado == true){
				$mail->SMTPAuth = true;
				$mail->Host = $_host;
				$mail->Username = $_usuario;
				$mail->Password = $_senha;
				$mail->From = $_usuario;
			}

			$mail->FromName = utf8_decode($nome);
			$mail->AddAddress($destino_rh);
			$mail->AddReplyTo($email,$nome);
			$mail->AddAttachment($path.$arq);
	
			$mail->WordWrap = 50;
			$mail->IsHTML(true);
			$mail->Subject = utf8_decode('Arxo - Currículo através do site: '.$nome.'!');
			$mail->Body = utf8_decode($corpo);
	
			if($mail->Send()){
				$retorno['msg'] = 'Seu currículo foi enviado com sucesso!';
				$retorno['erro'] = false;
			} else {
				$retorno['msg'] = 'Ocorreu um erro no envio dos seus dados. Por favor entre em contato conosco através do e-mail '.$destino.' e comunique-nos, para que possamos solucionar o problema. Obrigado!';
				$retorno['erro'] = 'envio';
			}

		} else {
			$retorno['msg'] = 'Extensão não permitida ou o arquivo ultrapassa os 2 Megas permitidos!';
			$retorno['erro'] = 'extensao';
		}

		echo json_encode($retorno);

	}

}
elseif($acao == 'representantes'){

	if($_POST){

		$path = '../arquivo/representantes/';
		
		$idioma = seguranca($_POST['idioma']);
		$nome = seguranca($_POST['nome']);
		$email = seguranca($_POST['email']);
		$telefone = seguranca($_POST['telefone']);
		$arquivo = $_FILES['arquivo'];
		$data = date('Y-m-d H:i:s');
		$erro = false;
		$retorno = array();
		
		if($arquivo['name'] != '' && $arquivo['error'] == 0){
			$extensao = explode('.',$arquivo['name']);
			$extensao = end($extensao);

			$permitidas = array('pdf','doc','docx','txt');
			$tamanho = round($arquivo['size']/1024);
			
			if(in_array($extensao,$permitidas) && $tamanho <= 2000){
				$arq = corrigeNome($data).'-'.corrigeNome($arquivo['name']);
				move_uploaded_file($arquivo['tmp_name'],$path.$arq);
				
				$mime_type = mimetype($path.$arq);
				if($mime_type == 'plain' || $mime_type == 'pdf' || $mime_type == 'msword' || $mime_type == 'docx'){
					$erro = false;
				} else {
					$erro = true;
					@unlink($path.$arq);
				}

			} else {
				$erro = true;
			}
		}
		if($arquivo['error'] == 1){
			$erro = true;
		}

		if($erro == false){

			# banco de dados
			$campos .= "idioma,nome,email,telefone,arquivo,data";
			$valores .= "'".$idioma."','".$nome."','".$email."','".$telefone."','".$arq."','".$data."'";
			inserir(REPRESENTANTES,$campos,$valores);

			# envia
			$corpo .= '<html><head><title>Arxo</title></head><body>';
			$corpo .= 'Contato representante através do site:<br />';
			$corpo .= '----------------------------------------------------<br />';
			$corpo .= '<strong>Anexo:</strong> '.$arq.'<br />';
			$corpo .= '----------------------------------------------------<br />';
			$corpo .= '<strong>Nome:</strong> '.$nome.'<br />';
			$corpo .= '<strong>E-mail:</strong> '.$email.'<br />';
			$corpo .= '<strong>Telefone:</strong> '.$telefone.'<br />';
			$corpo .= '<strong>Data de envio:</strong> '.converteData($data,'d/m/Y H:i:s').'<br />';
			$corpo .= '</body></html>';
		
			$mail = new PHPMailer();
			$mail->IsSMTP();
	
			if($autenticado == true){
				$mail->SMTPAuth = true;
				$mail->Host = $_host;
				$mail->Username = $_usuario;
				$mail->Password = $_senha;
				$mail->From = $_usuario;
			}

			$mail->FromName = utf8_decode($nome);
			$mail->AddAddress($destino_rh);
			$mail->AddReplyTo($email,$nome);
			$mail->AddAttachment($path.$arq);

			$mail->WordWrap = 50;
			$mail->IsHTML(true);
			$mail->Subject = utf8_decode('Arxo - Contato representante através do site: '.$nome.'!');
			$mail->Body = utf8_decode($corpo);

			if($mail->Send()){
				$retorno['msg'] = 'Seu currículo foi enviado com sucesso!';
				$retorno['erro'] = false;
			} else {
				$retorno['msg'] = 'Ocorreu um erro no envio dos seus dados. Por favor entre em contato conosco através do e-mail '.$destino.' e comunique-nos, para que possamos solucionar o problema. Obrigado!';
				$retorno['erro'] = 'envio';
			}

		} else {
			$retorno['msg'] = 'Extensão não permitida ou o arquivo ultrapassa os 2 Megas permitidos!';
			$retorno['erro'] = 'extensao';
		}

		echo json_encode($retorno);

	}

}
elseif($acao == 'listaRepresentantes'){

	header('Content-Type: application/json; charset=utf8');
	require_once('../class/representante.php');
	$representantes = Representante::listar();
	$json = array();

	foreach($representantes as $rep){
		if(empty($json[$rep->pais])){
			$json[$rep->pais] = array();
		}
		if($rep->pais == 'BR'){
			if(empty($json[$rep->pais][$rep->estado])){
				$json[$rep->pais][$rep->estado] = array();
			}
			$json[$rep->pais][$rep->estado][] = $rep->toArray();
		} else {
			$json[$rep->pais][] = $rep->toArray();
		}
	}

	echo json_encode($json);

}
elseif($acao == 'idioma'){
	session_start();
	header('Content-Type: application/json; charset=utf8');
	
	#idioma
	$idiomas = array('br','en','es');
	$idioma = isset($_GET['idioma'])?strtolower($_GET['idioma']):'br';
	$idioma = in_array($idioma,$idiomas)?$idioma:'br';
	$_SESSION['idioma'] = $idioma;
	echo json_encode(array('status' => true));

}
elseif($acao == 'cidades'){

	require_once('../class/estado.php');
	$estado = !empty($_GET['id']) ? intval($_GET['id']) : 0;
	header('Content-Type: application/json; charset=utf8');

	$estado = new Estado($estado);
	$cidades = $estado->cidades();
	echo json_encode($cidades);

}
?>