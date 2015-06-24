<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

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
	
		<div class="linhaConfig" id="busca">  
			<ul class="nav nav-tabs" role="tablist">
    			<li role="presentation" class=""><a href="#"  onclick="doAjaxSemRetorno('ajax_com/contas_pagar.php?acao=adicionar',1,'addPop');addPop_open(630);" aria-controls="home" role="tab" data-toggle="tab"><span class="glyphicon fa fa-file" aria-hidden="true"></span> Cadastrar Novo</a></li>
    		</ul>
		</div>
		
		<div  id="Saida">
	
		</div>

	</div> <!-- end #content -->
	
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->
<script>refreshContasPagar();</script>