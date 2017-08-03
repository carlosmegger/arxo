<? include('topo.php'); ?>
<div class="breadcrumb">
	<div class="central">
		<a href="./">HOME</a> &raquo; <a href="<?=$_links['contato']?>"><?=$_rotulos['contato']?></a>
	</div>
</div>
<section class="conteudo central">
	<h1><?=$_rotulos['contato']?></h1>

	<div class="telefones">
		<? if ($idioma == 'br'){?>
		<p>Matriz Arxo <span><?=$_rotulos['fone_matriz']?></span></p>
		<p>Filial Arxo <span><?=$_rotulos['fone_filial']?></span></p>
		<? } else { ?>
		<p><?=$_rotulos['telefone_arxo']?> <span><?=$_rotulos['fone_matriz']?></span></p>
		<? } ?>
	</div>

	<? if (!$_POST){ ?>
	<section>
		<p><?=$_textos['contato']?></p>
	</section>
	<form id="form-contato" class="contato" method="post" action="">
		<input type="hidden" name="subject" value="" autofill="off">
		<input type="hidden" name="captcha" id="captcha" value="<?=$_SESSION['captcha']?>">
		<input type="hidden" id="token_rdstation" name="token_rdstation" value="677820bd5f70a085a0b22a46ab6bb763">
		<input type="hidden" id="identificador" name="identificador" value="Comercial">
		<span class="uma-coluna">
			<span>
				<select name="area" id="area" placeholder="<?=$_label['area']?>" required>
					<option value="">Selecione uma área</option>
					<option value="Comercial">Comercial</option>
					<option value="Suprimentos">Suprimentos</option>
					<option value="Marketing">Marketing</option>
					<option value="Assistência Técnica">Assistência Técnica</option>
					<option value="Financeiro">Financeiro</option>
					<option value="Comunicação Visual e Lojas de Conveniência">Comunicação Visual e Lojas de Conveniência</option>
				</select>
			</span>
		</span>
		<span class="duas-colunas">
			<span>
				<input type="text" name="empresa" id="empresa" placeholder="<?=$_label['empresa']?>" required />
			</span>
			<span>
				<input type="text" name="nome" id="nome" placeholder="<?=$_label['nome']?>" required />
			</span>
		</span>
		<? if ($idioma == 'br'){?>
		<span class="uma-coluna">
			<span>
				<input type="text" name="cnpj" id="cnpj" placeholder="<?=$_label['cnpj']?>" />
			</span>
		</span>
		<? } ?>
		<span class="duas-colunas">
			<span>
				<input type="text" name="telefone" id="telefone" placeholder="<?=$_label['telefone']?>" required />
			</span>
			<span>
				<input type="email" name="email" id="email" placeholder="<?=$_label['email']?>" required />
			</span>
		</span>
		<span class="duas-colunas">
			<span>
				<input type="text" name="pais" id="pais" placeholder="<?=$_label['pais']?>" required />
			</span>
			<span>
				<input type="text" name="cidade_estado" id="cidade" placeholder="<?=$_label['cidade']?>" />
			</span>
		</span>
		<span class="uma-coluna">
			<span>
				<textarea name="mensagem" id="mensagem" rows="7" placeholder="<?=$_label['mensagem']?>" required></textarea>
			</span>
		</span>
		<div><small><?=$_textos['obrigatorios']?></small></div>
		<? /*<div class="g-recaptcha" data-sitekey="6LdzlgkTAAAAAHaoSDzOvemIm7gjVzaTUwAjihCw"></div>*/ ?>
		<span class="duas-colunas">
			<span class="retorno"></span>
			<input type="submit" id="enviar-contato" value="<?=$_label['submit']?>" />
		</span>
	</form>
	<?
	} else {
		$subject = $_POST['subject'];
		if (!$subject && !empty($_SESSION['captcha']) && $_SESSION['captcha'] == $_POST['captcha']){

			require_once('class/sendmail.php');
			require_once('class/contato.php');

			$empresa = $_POST['empresa'];
			$cnpj = isset($_POST['cnpj'])?$_POST['cnpj']:'';
			$nome = $_POST['nome'];
			$email = $_POST['email'];
			$telefone = $_POST['telefone'];
			$cidade = $_POST['cidade_estado'];
			$pais = $_POST['pais'];
			$area = $_POST['area'];
			$mensagem = $_POST['mensagem'];

			$contato = new Contato;
			$contato->post();
			$contato->assunto = $area;
			$contato->gravar();

			$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Formulário de Contato</title>
			</head>
			<body>
			<div style="font-size:14px; font-family:arial,verdana;">
				<div><strong>Empresa:</strong> '.$empresa.'</div>
				<div><strong>CNPJ:</strong> '.$cnpj.'</div>
				<div><strong>Nome:</strong> '.$nome.'</div>
				<div><strong>E-mail:</strong> '.$email.'</div>
				<div><strong>Área de Interesse:</strong> '.$area.'</div>';
			if (!!$telefone){
				$msg .= '<div><strong>Telefone:</strong> '.$telefone.'</div>';
			}
			if (!!$pais){
				$msg .= '<p><strong>País:</strong> '.$pais.'</p>';
			}
			if (!!$cidade){
				$msg .= '<p><strong>Cidade/Estado:</strong> '.$cidade.'</p>';
			}
			$msg .= '<p><strong>Mensagem:</strong> '.nl2br($mensagem).'</p>
			</div>
			</body>
			</html>';

			#enviando
			$mailer = new Sendmail;

			if ($area == 'Comercial'){
				$mailer->setTo('comunicacao@arxo.com');
				#$mailer->addCC('victor.compasso@arxo.com');
				$mailer->addCC('claudia.marques@arxo.com');
				$mailer->addCC('cidemar.zen@arxo.com');
			} elseif ($area == 'Suprimentos'){
				$mailer->setTo('michael.pereira@arxo.com');
			} elseif ($area == 'Marketing'){
				$mailer->setTo('comunicacao@arxo.com');
			} elseif ($area == 'Assistência Técnica'){
				$mailer->setTo('ata@arxo.com');
			} elseif ($area == 'Financeiro'){
				$mailer->setTo('financeiro@arxo.com');
			}
			#$mailer->setTo('alessandro@dataprisma.com.br');
			#$mailer->addBCC('massami@dataprisma.com.br');
			$mailer->returnPath($email);

			$mailer->setSubject('Contato pelo site: '.$area);
			$mailer->setContent($msg);

			echo '<p class="centraliza">';
			if($mailer->send()){
				echo str_replace('[nome]',$nome,$_textos['envio contato_sucesso']);
			} else {
				echo str_replace('[nome]',$nome,$_textos['envio erro']);
			}
			echo '</p>';
			unset($_SESSION['captcha']);
		}
	}
	?>
</section>
<script type="text/javascript" src="https://d335luupugsy2.cloudfront.net/js/integration/stable/rd-js-integration.min.js"></script>
<? include('rodape.php') ?>
