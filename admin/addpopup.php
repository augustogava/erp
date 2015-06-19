<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
$Main->DataGrid->setQuery("SELECT * FROM ".$_GET["tabela"]." Order By id ASC ");
$Main->DataGrid->setTabela($_GET["tabela"]);


//pagina��o
$Main->DataGrid->setEditar(1);
$Main->DataGrid->setExcluir(1);
$Main->DataGrid->setNomeTable("tabletest");
$Main->DataGrid->setNomeDivPai("Saida");

include($Main->Configuracoes->HEADER_POPBUSCA);  
?>
<div id="main-body">
	<div id="contentPopUp">
	
		<h3 id="recent">Adicionar <?=ucfirst($_GET["tabela"])?></h3>
		
		
		<div id="Saida">
			<div id="addPop" class="caixa" style="display:inline;margin-top:50px;margin-right:10px;height:83%; width:90%;"><? $Main->DataGrid->editaAddDataGrid("adicionarPopUp", $_GET["campoatual"]); ?></div>
		</div>

	</div> <!-- end #content -->
	
</div> <!-- end #main-body -->

<? include($Main->Configuracoes->FOOTER_POPBUSCA); ?>




