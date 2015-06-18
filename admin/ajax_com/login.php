<?
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();

$email = $_GET["email"];
if($Main->ConexaoSQL->RetornaQuantidadeQuery("SELECT * FROM cliente WHERE email = '".$email."'"))
	print 1;
	
print 123;
?>