<?php 

include "../includes/Main.class.php";

// chama a classe principal

$Main = new Main();

$Main->Seguranca->verificaLogado();

//session_unset($_SESSION["Ordena"]);



if($_REQUEST["acao"] == "deletar"){

	$Main->Pedidos->excluirPedido($_GET["id"]);

}else if($_REQUEST["acao"] == "deletarItemPedido"){

	$Main->Pedidos->excluirItemPedido($_GET["id"]);

}else if($_REQUEST["acao"] == "adicionarItem"){

	$Main->Pedidos->adicionaItemPedido($_GET["id"]);

}else if($_REQUEST["acao"] == "salvarPedido"){

	$Main->Pedidos->salvarPedido($_GET["clientes"], $_GET["representantes"], $_GET["idPedido"], $_GET["tipoComissao"], $_GET["valorComissao"], $_GET["formaPagamento"], $_GET["codigo"], $_GET["obs"], $_GET["tipo_entrega"], $_GET["imposto"], $_GET["valorEntrega"], $_GET["comissao"], $_GET["dataimposto"]);

}else if($_REQUEST["acao"] == "salvarItem"){

	$Main->Pedidos->salvarItem($_GET["campo"], $_GET["valor"], $_GET["idItem"], $_GET["indice"]);

}else if($_REQUEST["acao"] == "fecharPedido"){

	$Main->Pedidos->fecharPedido($_GET["id"]);

}else if($_REQUEST["acao"] == "enviarPedido"){

	$Main->Pedidos->enviarPedido($_GET["id"]);

}else if( $_REQUEST["acao"] == "pegarRepresentanteCliente"){

	$cliente = $Main->Pedidos->pegaClientes($_GET["cliente"]);

	print $cliente[0]->getIdRepresentante();

}else if( $_REQUEST["acao"] == "pegarDadosClientes"){

	$cliente = $Main->Pedidos->pegaClientes($_GET["cliente"]);

	print "</b>Razao:</b> ".$cliente[0]->getRazao()." <br />Estado: ".$cliente[0]->getEstado()."  <br />Cidade: ".$cliente[0]->getCidade();

}  

?>