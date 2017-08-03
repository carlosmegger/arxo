<?
include('scripts/conexao.php');
include('scripts/funcoes.php');
include('scripts/mysql.php');

$path_cv = 'arquivos/simposio/inscricoes/curriculos/';
$path_obras = 'arquivos/simposio/inscricoes/obras/';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Simpósio Inscrições</title>

<style>
* { margin:0; padding:0 }
body { margin:20px 0 }

form { width:600px; height:auto; margin:0 auto }
form div { width:auto; height:auto; margin-bottom:5px; overflow:hidden }
form div label { display:block; width:auto; height:auto }
form div label.lado-lado { width:auto; margin-right:15px; float:left }
form div input[type=text],
form div textarea { width:90%; padding:5px; border:#ccc 1px solid }

h2 { font-size:17px; text-transform:uppercase; margin:15px 0 5px 0 }
h3 { font-size:15px; text-transform:uppercase; margin:5px 0 }
</style>

<script src="scripts/jquery.js"></script>
<script src="scripts/jquery.maskedinput.min.js"></script>
<script>
$(function(){
	$('#data_nascimento').mask('99/99/9999');
	$('#telefone,#celular').focusout(function(){
        var phone,element;
			element = $(this);
			element.unmask();
			phone = element.val().replace(/\D/g,'');

        if(phone.length > 10){
            element.mask('(99) 99999-999?9');
        } else {
            element.mask('(99) 9999-9999?9');
        }
	}).trigger('focusout');
});
</script>
</head>

<body>

	<? if(!$_POST){ ?>
    <form name="simposio-inscricao" id="simposio-inscricao" action="" method="post" enctype="multipart/form-data">
		<h2>Informações Pessoais</h2>
        <div>
        	<label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" />
		</div>
		<div>
        	<label for="sobrenome">Sobrenome:</label>
            <input type="text" name="sobrenome" id="sobrenome" />
		</div>
		<div>
        	<label for="data_nascimento">Data de Nascimento:</label>
            <input type="text" name="data_nascimento" id="data_nascimento" />
		</div>
		<div>
        	<label for="titulos">Títulos:</label>
            <label class="lado-lado"><input type="checkbox" name="titulos[]" value="mr" /> MR</label>
            <label class="lado-lado"><input type="checkbox" name="titulos[]" value="mrs" /> MRS</label>
            <label class="lado-lado"><input type="checkbox" name="titulos[]" value="prof" /> PROF</label>
            <label class="lado-lado"><input type="checkbox" name="titulos[]" value="dr" /> DR</label>
		</div>
		<div>
        	<label>Sexo:</label>
            <label  class="lado-lado"><input type="radio" name="sexo" value="F" /> Fem</label>
            <label  class="lado-lado"><input type="radio" name="sexo" value="M" /> Masc</label>
		</div>
		<div>
        	<label for="nacionalidade">Nacionalidade:</label>
            <input type="text" name="nacionalidade" id="nacionalidade" />
		</div>
		<div>
        	<label for="documento">Passaporte ou CPF Nº:</label>
            <input type="text" name="documento" id="documento" />
		</div>
		<div>
        	<label for="validade">Validade:</label>
            <input type="text" name="validade" id="validade" />
		</div>
		<div>
        	<label for="endereco">Endereço:</label>
            <input type="text" name="endereco" id="endereco" />
		</div>
		<div>
        	<label for="telefone">Telefone:</label>
            <input type="text" name="telefone" id="telefone" />
		</div>
		<div>
        	<label for="celular">Celular:</label>
            <input type="text" name="celular" id="celular" />
		</div>
		<div>
        	<label for="pais">País:</label>
            <input type="text" name="pais" id="pais" />
		</div>
		<div>
        	<label for="cod_postal">Cod. Postal:</label>
            <input type="text" name="cod_postal" id="cod_postal" />
		</div>
		<div>
        	<label for="email">E-mail:</label>
            <input type="text" name="email" id="email" />
		</div>
		<div>
        	<label for="website">Website:</label>
			<input type="text" name="website" id="website" value="http://" />
		</div>

		<h2>Informação Biográfica</h2>
		<div>
        	<label for="cidade_pais">Cidade/Pais:</label>
            <input type="text" name="cidade_pais" id="cidade_pais" />
		</div>
		<div>
        	<label for="ocupacao">Ocupação:</label>
            <input type="text" name="ocupacao" id="ocupacao" />
		</div>
		<div>
        	<label for="curriculo">Currículo:</label>
            <input type="file" name="curriculo" id="curriculo" />
		</div>

		<h2>Recentes Trabalhos</h2>
        <h3>1) Trabalho</h3>
		<div>
        	<label for="trabalho1">Nome da ilustração:</label>
            <input type="text" name="trabalho1" id="trabalho1" />
		</div>
		<div>
        	<label for="mais1">Mais infos. sobre a arte:</label>
			<textarea name="mais1" id="mais1"></textarea>
		</div>
		<div>
			<label for="arquivo1">Imagem da obra de arte:</label>
            <input type="file" name="arquivo1" id="arquivo1" />
		</div>

        <h3>2) Trabalho</h3>
		<div>
        	<label for="trabalho2">Nome da ilustração:</label>
            <input type="text" name="trabalho2" id="trabalho2" />
		</div>
		<div>
        	<label for="mais2">Mais infos. sobre a arte:</label>
            <textarea name="mais2" id="mais2"></textarea>
		</div>
		<div>
			<label for="arquivo2">Imagem da obra de arte:</label>
            <input type="file" name="arquivo2" id="arquivo2" />
		</div>

        <h3>3) Trabalho</h3>
		<div>
        	<label for="trabalho3">Nome da ilustração:</label>
            <input type="text" name="trabalho3" id="trabalho3" />
		</div>
		<div>
        	<label for="mais3">Mais infos. sobre a arte:</label>
            <textarea name="mais3" id="mais3"></textarea>
		</div>
		<div>
			<label for="arquivo3">Imagem da obra de arte:</label>
            <input type="file" name="arquivo3" id="arquivo3" />
		</div>
       
		<h2>Participantes Informações de Obras de Arte</h2>
		<div>
        	<label for="titulo_obra">Título da Obra:</label>
            <input type="text" name="titulo_obra" id="titulo_obra" />
		</div>
		<div>
        	<label for="tamanho_obra">Tamanho (em metro) - Mínimo 2,0m / Máximo 2,5m:</label>
            <input type="text" name="tamanho_obra" id="tamanho_obra" />
		</div>
		<div>
			<label for="metal_obra">Tipo de metal:</label>
            <input type="text" name="metal_obra" id="metal_obra" />
		</div>
        <div>
        	<label for="descricao_obra">Clarificação da ideia (por favor esclarecer a sua ideia de trabalho em menos de 100 palavras):</label>
			<textarea name="descricao_obra" id="descricao_obra"></textarea>
        </div>
		<div>
			<label for="arquivo_obra">Projeto de design (tamanho máximo do arquivo 5MB):</label>
            <input type="file" name="arquivo_obra" id="arquivo_obra" />
		</div>

		<input type="submit" name="enviar-inscricao" id="enviar-inscricao" value="Enviar" />
	</form>
    <?
	} else {
		
		$nome = seguranca($_POST['nome']);
		$sobrenome = seguranca($_POST['sobrenome']);
		$data_nascimento = converteData($_POST['data_nascimento'],'Y-m-d');
		$titulos = json_encode($_POST['titulos']);
		$sexo = seguranca($_POST['sexo']);
		$nacionalidade = seguranca($_POST['nacionalidade']);
		$documento = seguranca($_POST['documento']);
		$validade = seguranca($_POST['validade']);
		$endereco = seguranca($_POST['endereco']);
		$telefone = seguranca($_POST['telefone']);
		$celular = seguranca($_POST['celular']);
		$pais = seguranca($_POST['pais']);
		$cod_postal = seguranca($_POST['cod_postal']);
		$email = seguranca($_POST['email']);
		$website = seguranca($_POST['website']);
		$cidade_pais = seguranca($_POST['cidade_pais']);
		$ocupacao = seguranca($_POST['ocupacao']);
		$curriculo = $_FILES['curriculo'];
		
		$trabalho1 = seguranca($_POST['trabalho1']);
		$mais1 = seguranca($_POST['mais1']);
		$arquivo1 = $_FILES['arquivo1'];
		
		$trabalho2 = seguranca($_POST['trabalho2']);
		$mais2 = seguranca($_POST['mais2']);
		$arquivo2 = $_FILES['arquivo2'];

		$trabalho3 = seguranca($_POST['trabalho3']);
		$mais3 = seguranca($_POST['mais3']);
		$arquivo3 = $_FILES['arquivo3'];
		
		$titulo_obra = seguranca($_POST['titulo_obra']);
		$tamanho_obra = seguranca($_POST['tamanho_obra']);
		$metal_obra = seguranca($_POST['metal_obra']);
		$descricao_obra = seguranca($_POST['descricao_obra']);
		$arquivo_obra = $_FILES['arquivo_obra'];

		$data = date('YmdHis');

		if($curriculo['name'] != ''){
			$arq = $data.'-'.corrigeNome($curriculo['name']);
			move_uploaded_file($curriculo['tmp_name'],$path_cv.$arq);

			$campos .= "curriculo,";
			$valores .= "'".$arq."',";
		}
		if($arquivo1['name'] != ''){
			$arq = $data.'-1-'.corrigeNome($arquivo1['name']);
			move_uploaded_file($arquivo1['tmp_name'],$path_obras.$arq);

			$campos .= "arquivo1,";
			$valores .= "'".$arq."',";
		}
		if($arquivo2['name'] != ''){
			$arq = $data.'-2-'.corrigeNome($arquivo2['name']);
			move_uploaded_file($arquivo2['tmp_name'],$path_obras.$arq);

			$campos .= "arquivo2,";
			$valores .= "'".$arq."',";
		}
		if($arquivo3['name'] != ''){
			$arq = $data.'-3-'.corrigeNome($arquivo3['name']);
			move_uploaded_file($arquivo3['tmp_name'],$path_obras.$arq);

			$campos .= "arquivo3,";
			$valores .= "'".$arq."',";
		}
		if($arquivo_obra['name'] != ''){
			$arq = $data.'-obra-'.corrigeNome($arquivo_obra['name']);
			move_uploaded_file($arquivo_obra['tmp_name'],$path_obras.$arq);

			$campos .= "arquivo_obra,";
			$valores .= "'".$arq."',";
		}

		$campos .= "nome,sobrenome,data_nascimento,titulos,sexo,nacionalidade,documento,validade,endereco,telefone,celular,pais,cod_postal,email,website,cidade_pais,ocupacao,trabalho1,mais1,trabalho2,mais2,trabalho3,mais3,titulo_obra,tamanho_obra,metal_obra,descricao_obra,data_cadastro";
		$valores .= "'".$nome."','".$sobrenome."','".$data_nascimento."','".$titulos."','".$sexo."','".$nacionalidade."','".$documento."','".$validade."','".$endereco."','".$telefone."','".$celular."','".$pais."','".$cod_postal."','".$email."','".$website."','".$cidade_pais."','".$ocupacao."','".$trabalho1."','".$mais1."','".$trabalho2."','".$mais2."','".$trabalho3."','".$mais3."','".$titulo_obra."','".$tamanho_obra."','".$metal_obra."','".$descricao_obra."','".$data."'";
		inserir(SIMPOSIO_INSCRICOES,$campos,$valores,true);
		$ultimo = ultimoID();

	}
	?>
</body>
</html>
