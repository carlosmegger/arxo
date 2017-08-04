<?
include('../scripts/conexao.php');
include('../scripts/funcoes.php');
include('../scripts/mysql.php');

$email = seguranca($_POST['email']);
$senha = seguranca($_POST['senha']);

$sql = selecionar("",USUARIOS,"where (email = '".$email."' and senha = '".$senha."') and ativo = 'S'");
$row = mysql_num_rows($sql);

if($row == 0){
	go_url($sistema.'index.php?login=erro');
} else {

	$idusuario = mysql_result($sql,0,'idusuario');
	$email = mysql_result($sql,0,'email');
	$permissao = mysql_result($sql,0,'permissao');

	session_start();
	$_SESSION['usuario_admin'] = $idusuario;
	$_SESSION['email_admin'] = $email;
	$_SESSION['permissoes'] = $permissao;
	$_SESSION['acesso'] = date('Y-m-d H:i:s');
	$_SESSION['IsAuthorized'] = true;

	go_url($sistema.'home.php');
}
?>