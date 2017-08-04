<?
session_start();

unset($_SESSION['usuario_admin']);
unset($_SESSION['email_admin']);
#session_destroy();

header('Location: index.php');
exit;
?> 