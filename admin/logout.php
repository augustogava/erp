<?
header("Content-Type: text/html;  charset=ISO-8859-1",true);
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();

$Main->Seguranca->logoffsite();
?>