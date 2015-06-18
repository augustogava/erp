<?php 
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
$Main->AdicionaComposicao();
//session_unset($_SESSION["Ordena"]);

if($_REQUEST["acao"] == "deletar"){
	$Main->Composicao->excluir($_GET["id"]);
}else if($_REQUEST["acao"] == "salvar"){
	$Main->Composicao->salvarComposicao($_GET["id"], $_GET["idComposicao"], $_GET["produto"], $_GET["qtd"], $_GET["descricao"]);
}
  
?>