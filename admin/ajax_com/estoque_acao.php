<?php 
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
//session_unset($_SESSION["Ordena"]);

if($_REQUEST["acao"] == "deletar"){
	$Main->Estoque->excluir($_GET["id"]);
}else if($_REQUEST["acao"] == "salvar"){
	$Main->Estoque->salvarEstoque($_GET["id"], $_GET["produto"], $_GET["tipo"], $_GET["qtd"], $_GET["preco"] , $_GET["data"], $_GET["descricao"]);
}
  
?>