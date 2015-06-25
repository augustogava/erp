<?php 
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
//session_unset($_SESSION["Ordena"]);

if($_REQUEST["acao"] == "salvar"){
	$Main->User->salvar($_GET["id"], $_GET["nome"], $_GET["email"], $_GET["login"]);
}else if($_REQUEST["acao"] == "salvarSenha"){
	$Main->User->salvarSenha($_GET["id"], $_GET["senhaAntiga"], $_GET["senhaNova"]);
}
  
?>