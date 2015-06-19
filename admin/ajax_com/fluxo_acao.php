<?php 
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

if($_REQUEST["acao"] == "deletar"){
	$Main->Fluxo->excluir($_GET["id"]);
}else if($_REQUEST["acao"] == "salvar"){
	$Main->Fluxo->salvarFluxo($_GET["id"], $_GET["cliente"], $_GET["fornecedor"], $_GET["tipo"], $_GET["tipoFluxo"], $_GET["ocorrencia"], $_GET["valor"] , $_GET["data"], $_GET["statusFluxo"]);
}
  
?>