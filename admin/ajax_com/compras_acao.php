<?php 

include "../includes/Main.class.php";

// chama a classe principal

$Main = new Main();

$Main->Seguranca->verificaLogado();

$Main->AdicionaCompras();

//session_unset($_SESSION["Ordena"]);



if($_REQUEST["acao"] == "deletar"){

	$Main->Compras->excluirCompra($_GET["id"]);

}else if($_REQUEST["acao"] == "deletarItemCompra"){

	$Main->Compras->excluirItemCompra($_GET["id"]);

}else if($_REQUEST["acao"] == "deletarFormaPgto"){

	$Main->Compras->excluirFormaPgtoCompra($_GET["id"]);

}else if($_REQUEST["acao"] == "adicionarItem"){

	$Main->Compras->adicionaItemCompra($_GET["id"]);

}else if($_REQUEST["acao"] == "adicionarFormaPgto"){

	$Main->Compras->adicionaFormaPgtoCompra($_GET["id"]);

}else if($_REQUEST["acao"] == "salvarCompra"){

	$Main->Compras->salvarCompra($_GET["idCompra"], $_GET["fornecedores"], $_GET["codigo"], $_GET["obs"], $_GET["imposto"], $_GET["desconto"], $_GET["tipoFluxo"]);

}else if($_REQUEST["acao"] == "salvarItem"){

	$Main->Compras->salvarItem($_GET["campo"], $_GET["valor"], $_GET["idItem"], $_GET["indice"]);

}else if($_REQUEST["acao"] == "salvarFormaPgto"){

	$Main->Compras->salvarFormaPgto($_GET["campo"], $_GET["valor"], $_GET["idItem"], $_GET["indice"]);

}else if($_REQUEST["acao"] == "virarCompra"){

	$Main->Compras->virarCompra($_GET["id"]);

}else if($_REQUEST["acao"] == "fecharCompra"){

	$Main->Compras->fecharCompra($_GET["id"], $_GET["fluxo"]);

} 

?>