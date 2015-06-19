<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

$clientes = $Main->Pedidos->pegaClientes();
				
include($Main->Configuracoes->HEADER_NADMIN);  
?>

<div id="main-body">
	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Relatório Fluxo</p>
			</div>
		</div>
	</div>
	<div id="content">
	
			<div class="linhaConfig" id="busca">  
				<form id="edit" name="edit" >	
					
 
				</form>
			</div>
			
			<button type="button" onClick="abrirRelatorioFluxo();" class="btn btn-success" style="margin-top: 0px">Gerar Relatório</button>
					<script>
						document.onkeypress = function (evt){
							if(main.procuraTecla(evt,13)){
								if(confirm('Deseja gerar o relatório?')){ abrirRelatorioFluxo() }
							}
						}
						
					</script>
			
		
		<div id="SaidaMain">
	
		</div>

	</div> <!-- end #content -->
	
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->