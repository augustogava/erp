<?
header("Content-Type: text/html;  charset=ISO-8859-1",true);
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();


$Main->DataGrid->setQuery($_GET["query"]);

//Adiciona Colunas
$Colunas = explode(",", $_GET["colunas"]);
foreach($Colunas as $Valor){
	$Main->DataGrid->setColunas($Valor);
}


$Main->DataGrid->setOrder($_GET["ordena"]);

//paginação
$Main->DataGrid->setLimiteAtual($_GET["limiteatual"]);
if($_GET["flag"] == "proximo"){
	$Main->DataGrid->setLimiteAtual(($Main->DataGrid->getLimiteAtual() + $_GET["limite"] ));
	$Main->DataGrid->setFlagRefresh($_GET["FlagRefresh"]);
	print $_GET["FlagRefresh"];
}else if ($_GET["flag"] == "anterior"){
	if(($Main->DataGrid->getLimiteAtual() - $_GET["limite"] ) >= 0){
		$Main->DataGrid->setLimiteAtual(($Main->DataGrid->getLimiteAtual() - $_GET["limite"] ));
		$Main->DataGrid->setFlagRefresh($_GET["FlagRefresh"]);
	}
}

if(!empty($_GET["cadastroExtras"])){
	$cadastroExtra = explode("|", $_GET["cadastroExtras"]);
	if(is_array($cadastroExtra)){
		foreach($cadastroExtra as $res){
			$pt = explode(",", $res);
			$Main->DataGrid->addCadastroExtra(array($pt[0], $pt[1]));
		}
	}else{
		$pt = explode(",", $cadastroExtra);
		$Main->DataGrid->addCadastroExtra(array($pt[0], $pt[1]));
	}
}


$Main->DataGrid->setLimite($_GET["limite"]);
$Main->DataGrid->setBusca($_GET["busca"]);
$Main->DataGrid->setEditar($_GET["editar"]);
$Main->DataGrid->setExcluir($_GET["excluir"]);
$Main->DataGrid->setNomeDivPai($_GET["nomedivpai"]);

$Main->DataGrid->setTabela($_GET["tabelaBD"]);

$Main->DataGrid->setNomeTable($_GET["tabela"]);

//Acao Deletar
if($_GET["acao"]=="Deletar"){
	$Main->DataGrid->deletaDataGrid($_GET["idData"]);
}
sleep(1);
//Adiciona na sessão pra verificar
$_SESSION["flag"] = $_GET["flagOrdena"];

$Main->DataGrid->montaDataGrid();
?>
