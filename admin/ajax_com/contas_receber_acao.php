<?php 
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

if($_REQUEST["acao"] == "pagar"){
	$Main->Fluxo->pagarFluxo($_GET["id"], $_GET["info"]);
}else if($_REQUEST["acao"] == "descontar"){
	$Main->Fluxo->descontarFluxo($_GET["id"], $_GET["info"]);
}else if($_REQUEST["acao"] == "cancelar"){
	$Main->Fluxo->cancelarFluxo($_GET["id"]);
}
  
?>