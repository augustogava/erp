<?php
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main ();
$Main->Seguranca->verificaLogado ();

// session_unset($_SESSION["Ordena"]);

// Chama DataGrid
$Main->AdicionaDataGrid ();

$Main->DataGrid->setQuery ( "SELECT * from familia " );
$Main->DataGrid->setTabela ( "familia" );
$Main->DataGrid->setColunas ( "familia.id" );
$Main->DataGrid->setColunas ( "familia.nome.like" );
$Main->DataGrid->setLimite ( 15 );
$Main->DataGrid->setEditar ( "1" );
$Main->DataGrid->setExcluir ( "1" );
$Main->DataGrid->setNomeTable ( "tabletest" );
$Main->DataGrid->setNomeDivPai ( "Saida" );
$Main->DataGrid->setExportar ( "1" );
$Main->DataGrid->setFlagRefresh ( 5 );

include ($Main->Configuracoes->HEADER_NADMIN);
?>
<div id="main-body">

	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Família</p>
			</div>
		</div>
	</div>
	
	<div id="content">
		
		<?= $Main->DataGrid->montarBusca(); ?>
		
		<div id="Saida" style="border: 1px solid #EBF0FD;">
			<? $Main->DataGrid->montaDataGrid(); ?>
		</div>

	</div>
	<!-- end #content -->
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div>
<!-- end #main-body -->


