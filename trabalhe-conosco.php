<? include('topo.php'); ?>
<div class="breadcrumb">
	<div class="central">
		<a href="./">HOME</a> &raquo; <a href="<?=$_links['trabalhe conosco']?>"><?=$_rotulos['trabalhe conosco']?></a>
	</div>
</div>
<section class="conteudo central">
	<h1><?=$_rotulos['trabalhe conosco']?></h1>
	<? if (!$_POST){ ?>
    <section>
        <p><?=$_textos['trabalhe conosco']?></p>
    </section>
    <form id="form-trabalhe" class="contato" method="post" action="" enctype="multipart/form-data">
    	<span class="duas-colunas">
            <span>
                <input type="text" name="nome" id="nome" placeholder="<?=$_label['nome']?>" required />
            </span>
            <span>
                <input type="email" name="email" id="email" placeholder="<?=$_label['email']?>" required />
            </span>
        </span>
    	<span class="duas-colunas">
            <span>
                <input type="text" name="telefone" id="telefone" placeholder="<?=$_label['telefone']?>" required />
            </span>
            <span>
                <input type="text" name="celular" id="celular" placeholder="<?=$_label['celular']?>" required />
            </span>
        </span>
    	<span class="duas-colunas">
            <span>
                <input type="text" name="estado" id="estado" placeholder="<?=$_label['estado']?>" required />
            </span>
            <span>
                <input type="text" name="cidade" id="cidade" placeholder="<?=$_label['cidade']?>" required />
            </span>
        </span>
    	<span class="uma-coluna">
            <span class="curriculo">
            	<span id="label-curriculo"><?=$_label['curriculo']?> (Max.: <?=ini_get('upload_max_filesize')?>b)</span>
                <input type="file" name="curriculo" id="curriculo" required accept=".pdf,.ppt,.pptx,.doc,.docx" />
            </span>
        </span>
        <div><small><?=$_textos['obrigatorios']?></small></div>
    	<span class="duas-colunas">
            <span class="retorno"></span>
            <input type="submit" name="enviar-contato" id="enviar-contato" value="<?=$_label['submit']?>" />
        </span>
	</form>
    <?
	} else {
		if (!is_uploaded_file($_FILES['curriculo']['tmp_name'])){
			echo '<p class="centraliza">Ocorreu um erro ao enviar seu currículo, por favor tente novamente.</p>';
		} else {
			
			require_once('scripts/conexao.php');
			require_once('scripts/mysql.php');
			require_once('scripts/funcoes.php');
			#require_once('phpmailer/class.phpmailer.php');

			require_once('class/sendmail.php');

			$nome = seguranca($_POST['nome']);
			$email = seguranca($_POST['email']);
			$telefone = seguranca($_POST['telefone']);
			$celular = seguranca($_POST['celular']);
			$cidade = seguranca($_POST['cidade']);
			$estado = seguranca($_POST['estado']);
			#$curriculo = $_FILES['curriculo']['name'];
			$curriculo = $_FILES['curriculo'];

			$msg = "
			<font style='font-size:14px; font-family:arial,verdana;'>
				<b>Nome:</b> ".$nome."<br>
				<b>E-mail:</b> ".$email."<br>";
			if ($telefone != ''){
				$msg .= "<b>Telefone:</b> ".$telefone."<br>";
			}
			if ($celular != ''){
				$msg .= "<b>Celular:</b> ".$celular."<br>";
			}
			if ($cidade != '' && $estado != ''){
				$msg .= "<b>Cidade/Estado:</b> ".$cidade."/".$estado."<br>";
			}
			#$msg .= "<b>Mensagem:</b> ".nl2br($mensagem).";
			$msg .= "</font>";
			
			#arquivo
			$path = 'arquivos/curriculos/';
			
			if($curriculo['name'] != '' && $curriculo['error'] == 0){
				$extensao = explode('.',$curriculo['name']);
				$extensao = end($extensao);

				$permitidas = array('pdf','doc','docx','txt');
				$tamanho = round($curriculo['size']/1024);
				
				if(in_array($extensao,$permitidas) && $tamanho <= 2000){
					$arq = date('Ymdhis').'-'.corrigeNome($curriculo['name']);
					move_uploaded_file($curriculo['tmp_name'],$path.$arq);
					$erro = false;
				} else {
					$erro = true;
				}
			}
			if($curriculo['error'] == 1){
				$erro = true;
			}

			#enviando
			/*
			$mailer = new Sendmail();

			#$mailer->setTo('site@dominio.com.br');
			#$mailer->setTo('massami@dataprisma.com.br');
			$mailer->setTo('maicon@dataprisma.com.br');
			$mailer->returnPath($email);

			$mailer->setSubject('Cadastro de currículo via site Arxo');
			$mailer->addAttachment($_FILES['curriculo']['tmp_name'],$curriculo);
			$mailer->setContent($msg);

			echo '<p class="centraliza">';
			if($mailer->send()){
				echo str_replace('[nome]',$nome,$_textos['envio curriculo_sucesso']);
			} else {
				echo str_replace('[nome]',$nome,$_textos['envio erro']);
			}
			echo '</p>';
			*/

			if($erro == false){
				
				#banco de dados
				$campos .= "idioma,nome,telefone,email,arquivo,data";
				$valores .= "'".$idioma."','".$nome."','".$telefone."','".$email."','".$arq."',now()";
				inserir(CURRICULOS,$campos,$valores);

				#envia
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
				#$mail->AddAddress('maicon@dataprisma.com.br');
				$mail->AddAddress('curriculo@arxo.com');
				$mail->AddReplyTo($email,$nome);
			
				$mail->WordWrap = 50;
				$mail->IsHTML(true);
				$mail->Subject = utf8_decode('Cadastro de currículo via site Arxo');
				$mail->AddAttachment($path.$arq,$arq);
				$mail->Body = utf8_decode($msg);
	
				echo '<p class="centraliza">';
				if($mail->send()){
					echo str_replace('[nome]',$nome,$_textos['envio curriculo_sucesso']);
				} else {
					echo str_replace('[nome]',$nome,$_textos['envio erro']);
				}
				echo '</p>';

			} else {

				echo '<p class="centraliza">';
				echo str_replace('[nome]',$nome,$_textos['envio erro']);
				echo '</p>';

			}
		}
	}
	?>
</section>
<? include('rodape.php'); ?>