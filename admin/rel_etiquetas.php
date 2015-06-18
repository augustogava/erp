<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
$Main->AdicionaPedidos();

$clientes = $Main->Pedidos->pegaClientes();
				
include($Main->Configuracoes->HEADER_NADMIN);  
?>
<div id="main-body">
	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Etiquetas</p>
			</div>
		</div>
	</div>
	<div id="content">
	
			<div class="linhaConfig" id="busca">  
				<form id="edit" name="edit" >	
					<input type="radio" name="filtro1" id="filtro1" value="1" checked> Gerar <br />
				</form>
			</div>
			<button type="button" onClick="abrirRelatorioEtiquetas();" class="btn btn-success" style="margin-top: 10px">Gerar Relatório</button>
				
				<script>
					document.onkeypress = function (evt){
						if(main.procuraTecla(evt,13)){
							if(confirm('Deseja gerar o relat�rio?')){ abrirRelatorioEtiquetas() }
						}
					}
					
				</script>
		
		
		<div id="SaidaMain">
	
		</div>

	</div> <!-- end #content -->
	
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->