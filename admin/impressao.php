<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

if($_GET["cadastro"] == "pedido"){
	$Main->AdicionaPedidos();
	$html = $Main->Pedidos->montaHTMLRelatorio($_GET["id"]);

}else if($_GET["cadastro"] == "compra"){
	$Main->AdicionaCompras();
	$html = $Main->Compras->montaHTMLRelatorio($_GET["id"], $_GET["tipo"]);
}

print $html;

?>


