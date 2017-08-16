<?
header("Content-type: text/css",true);
@session_start();
require_once('../class/produto.php');

$categorias = Produto::categorias();

echo '/* categorias */'.PHP_EOL;
foreach($categorias as $cat){
	echo '.fundo-cat-'.$cat->slug.' { background:'.$cat->hexadecimal.' }'.PHP_EOL;
}
?>