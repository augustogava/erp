<?
header("Content-Type: text/html;  charset=ISO-8859-1",true);
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();

$Main->DataGrid->setQuery($_GET["query"]);
$Main->DataGrid->setId($_GET["id"]);
$Main->DataGrid->setTabela($_GET["tabelaBD"]);

//Adiciona Colunas
$Colunas = explode(",", $_GET["colunas"]);
foreach($Colunas as $Valor){
	$Main->DataGrid->setColunas($Valor);
}

$collumnsCurrency = explode(",", $_GET["collumnsCurrency"]);
foreach($collumnsCurrency as $Valor){
	$Main->DataGrid->addCollumnsCurrency($Valor);
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

$Main->DataGrid->setOrder($_GET["ordena"]);

//paginação
$Main->DataGrid->setLimiteAtual($_GET["limiteatual"]);
$Main->DataGrid->setLimite($_GET["limite"]);
$Main->DataGrid->setBusca($_GET["busca"]);
$Main->DataGrid->setEditar($_GET["editar"]);
$Main->DataGrid->setExcluir($_GET["excluir"]);
$Main->DataGrid->setNomeDivPai($_GET["nomedivpai"]);


$Main->DataGrid->setNomeTable($_GET["tabela"]);
?>
<div id="Saida">
<? $Main->DataGrid->editaAddDataGrid($_GET["acao"]); ?>
</div>