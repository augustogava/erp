<?php 
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

if($_REQUEST["acao"] == "deletar"){
	$Main->OrdemSeparacao->excluir($_GET["id"]);
}else if($_REQUEST["acao"] == "salvar"){
	$Main->OrdemSeparacao->salvarOrdemSeparacao($_GET["id"], $_GET["produto"], $_GET["pedido"], $_GET["qtd"], $_GET["descricao"] , $_GET["data"], $_GET["status"]);
}else if($_REQUEST["acao"] == "fecharOrdem"){
	$Main->OrdemSeparacao->fecharOrdem( $_GET["id"] );
}
  
?>