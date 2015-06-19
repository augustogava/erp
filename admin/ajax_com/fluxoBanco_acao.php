<?php 
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

if($_REQUEST["acao"] == "deletar"){
	$Main->FluxoBanco->excluir($_GET["id"]);
}else if($_REQUEST["acao"] == "salvar"){
	$Main->FluxoBanco->salvarFluxo($_GET["id"], $_GET["idBanco"], $_GET["tipo"], $_GET["tipoFluxo"], $_GET["ocorrencia"], $_GET["valor"] , $_GET["data"], $_GET["numeroDoc"]);
}else if($_REQUEST["acao"] == "pagar"){
	$Main->FluxoBanco->pagarFluxo($_GET["id"], $_GET["info"]);
}
  
?>