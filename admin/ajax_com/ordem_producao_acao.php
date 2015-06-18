<?php 
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
$Main->AdicionaOrdemProducao();
//session_unset($_SESSION["Ordena"]);

if($_REQUEST["acao"] == "deletar"){
	$Main->OrdemProducao->excluir($_GET["id"]);
}else if($_REQUEST["acao"] == "salvar"){
	$Main->OrdemProducao->salvarOrdemProducao($_GET["id"], $_GET["produto"], $_GET["pedido"], $_GET["qtd"], $_GET["descricao"] , $_GET["data"], $_GET["status"]);
}else if($_REQUEST["acao"] == "produzirOrdem"){
	$Main->OrdemProducao->produzirOrdem( $_GET["id"] );
}else if($_REQUEST["acao"] == "fecharOrdem"){
	$Main->OrdemProducao->fecharOrdem( $_GET["id"] );
}
  
?>