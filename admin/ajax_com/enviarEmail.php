<?
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();

if($_GET["tipo"] == "fluxo"){
	$Main->Pedidos->enviaEmailFluxo($_GET["id"], $_GET["email"]);
}
mysql_close();
?>