<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

//session_unset($_SESSION["Ordena"]);

//Chama DataGrid
$Main->AdicionaDataGrid();

$Main->DataGrid->setQuery("SELECT * from permissoes_niveis ");
$Main->DataGrid->setTabela("permissoes_niveis");
$Main->DataGrid->setColunas("permissoes_niveis.id");
$Main->DataGrid->setColunas("permissoes_niveis.id_niveis");
$Main->DataGrid->setColunas("permissoes_niveis.id_menus");
$Main->DataGrid->setLimite(15);
$Main->DataGrid->setEditar("1");
$Main->DataGrid->setExcluir("1");
$Main->DataGrid->setNomeTable("tabletest");
$Main->DataGrid->setNomeDivPai("Saida");
$Main->DataGrid->setFlagRefresh(5);

include($Main->Configuracoes->HEADER_NADMIN);  
?>
<div id="main-body">
	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Permissões</p>
			</div>
		</div>
	</div>
	<div id="content">
	
		<?= $Main->DataGrid->montarBusca(); ?>
		
		<div id="Saida">
			<? $Main->DataGrid->montaDataGrid(); ?>
		</div>

	</div> <!-- end #content -->
	
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->