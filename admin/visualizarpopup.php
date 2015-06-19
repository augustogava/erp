<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
$Main->DataGrid->setQuery("SELECT * FROM ".$_GET["tabela"]);
$Main->DataGrid->setTabela($_GET["tabela"]);


//paginacao
$Main->DataGrid->setId($_GET["id"]);
$Main->DataGrid->setEditar(1);
$Main->DataGrid->setExcluir(1);
$Main->DataGrid->setNomeTable("tabletest");
$Main->DataGrid->setNomeDivPai("Saida");

include($Main->Configuracoes->HEADER_POPBUSCA);  
?>
<div id="main-body">
	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Adicionar <?=ucfirst($_GET["tabela"])?></p>
			</div>
		</div>
	</div>
	<div id="contentPopUp">
	
		<div id="Saida">
			<div id="addPop" class="caixa" style="display:inline;margin-top:50px;margin-right:10px;height:83%; width:90%;"><? $Main->DataGrid->editaAddDataGrid("abrir"); ?></div>
		</div>

	</div> <!-- end #content -->
	
</div> <!-- end #main-body -->

<? include($Main->Configuracoes->FOOTER_POPBUSCA); ?>




