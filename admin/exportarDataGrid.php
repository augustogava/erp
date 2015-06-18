<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

if($_GET["acao"] == "exportar"){
	//Chama DataGrid
	$Main->AdicionaDataGrid();
	
	$Main->DataGrid->setQuery($_GET["query"]);
	$Main->DataGrid->setId($_GET["edit_id"]);
	$Main->DataGrid->setTabela($_GET["tabelaBD"]);
	
	//Adiciona Colunas
	$Colunas = explode(",", $_GET["colunas"]);
	foreach($Colunas as $Valor){
		$Main->DataGrid->setColunas($Valor);
	}
	
	
	$Main->DataGrid->setOrder($_GET["ordena"]);
	
	//pagina��o
	$Main->DataGrid->setLimiteAtual($_GET["limiteatual"]);
	$Main->DataGrid->setBusca($_GET["busca"]);
	$Main->DataGrid->setEditar($_GET["editar"]);
	$Main->DataGrid->setExcluir($_GET["excluir"]);
	$Main->DataGrid->setNomeDivPai($_GET["nomedivpai"]);
	$Main->DataGrid->setBusca($_GET["buscaItens"]);
	$Main->DataGrid->setOrder($_GET["ordena"]);
	
	$Main->DataGrid->setNomeTable($_GET["tabela"]);
	$Main->DataGrid->exportar($_GET["campo"]);
	
	if($_GET["campo"] == "html")
		include($Main->Configuracoes->HEADER_POPBUSCA);  
	
	exit;
	
}else{
	include($Main->Configuracoes->HEADER_POPBUSCA);  
}



?>
<div id="main-body popup">
	<div class="title">
		<div class="row">
	  		<div class="col-md-12">
	  			<p class="titlePage" id="recent">Exportação</p>
			</div>
		</div>
	</div>
	<div id="contentPopUp">
	
		<div id="Saida">
			<select id="campo" name="campo" style="width: 100%">
				<option value="">Selecione</option>
				<option value="csv">CSV</option>
				<option value="pdf">PDF</option>
				<option value="html">HTML</option>
				<option value="excel">EXCEL</option>
			</select>
		</div>

	</div> <!-- end #content -->
	
</div> <!-- end #main-body -->

<script>
evento.adicionar($('campo'), 'change', function (evt) { 
	if($('campo').value == "html"){
		main.openWindow('exportarDataGrid.php?<?=$_SERVER["QUERY_STRING"]?>&acao=exportar&campo=' + $('campo').value, '600', '500');
	}else{
		window.location ='exportarDataGrid.php?<?=$_SERVER["QUERY_STRING"]?>&acao=exportar&campo=' + $('campo').value;
	}
}
														 );
</script>
