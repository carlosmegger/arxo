<?
@session_start();

if((!isset($_SESSION['usuario_admin'])) && (!isset($_SESSION['email_admin'])) && (!isset($_SESSION['acesso']))){
	echo '<script type="text/javascript">document.location.href="logout.php";</script>';
}
elseif((strtotime(date('Y-m-d H:i:s')) - strtotime($_SESSION['acesso'])) > 3600){
	go_url($sistema.'index.php?login=expirou');
} else {
	$_SESSION['acesso'] = date("Y-m-d H:i:s");
}
?>