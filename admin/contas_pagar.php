<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
$Main->AdicionaPedidos();
$Main->AdicionaFluxo();

$clientes = $Main->Pedidos->pegaClientes();
$tipoFluxo = $Main->Fluxo->pegaTipoFluxo();
		
include($Main->Configuracoes->HEADER_NADMIN);  
?>

<div id="main-body">
	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Contas a Pagar</p>
			</div>
		</div>
	</div>
	
	<div id="content">
	
		<div  id="Saida">
	
		</div>

	</div> <!-- end #content -->
	
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->
<script>refreshContasPagar();</script>