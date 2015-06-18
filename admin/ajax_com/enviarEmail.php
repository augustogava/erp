<?
header("Content-Type: text/html;  charset=ISO-8859-1",true);
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();

if($_GET["tipo"] == "fluxo"){
	$Main->AdicionaPedidos();
	$Main->Pedidos->enviaEmailFluxo($_GET["id"], $_GET["email"]);
}
mysql_close();
?>