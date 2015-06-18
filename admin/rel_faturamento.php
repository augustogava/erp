<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

$estados = $Main->Padrao->pegaEstados();
//$cidades = $Main->Padrao->pegaCidades();

$clientes = $Main->Pedidos->pegaClientes();
				
include($Main->Configuracoes->HEADER_NADMIN);  
?>
<script>
		var mCal;
	window.onload = function() {
		mCal = new dhtmlxCalendarObject(['filtro2', 'filtro3']);
		mCal.setDateFormat("%d/%m/%Y");
	}
	
</script>
<div id="main-body">
	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Relatório Faturamento</p>
			</div>
		</div>
	</div>
	
	<div id="content">
	
			<div class="linhaConfig" id="busca">  
				<form id="edit" name="edit" >	
					<div class="form-group form-inline">
						<label for="filtro2">Data Início</label>
						<input name="filtro2" class="form-control input-sm" id="filtro2" type="text" onKeyPress="mascaras.mascara(this,'data')" size="10"  value="<?=date("d/m/Y", mktime(0,0,0,date("m"), 01, date("Y"))) ?>"> 

						<label for="filtro3">Data Fim</label>
						<input name="filtro3"  class="form-control input-sm" id="filtro3" type="text" onKeyPress="mascaras.mascara(this,'data')" size="10" value="<?=date("d/m/Y", mktime(0,0,0, date("m"), 30, date("Y"))) ?>"> <br />
					</div>
					<div class="form-group form-inline">
						Listar Por: <input type="radio" name="filtro1" id="filtro1" value="1" checked> Pedido 
						<input type="radio" name="filtro1" id="filtro1_1" value="2" >  Representantes
	                    <input type="radio" name="filtro1" id="filtro1_1" value="3" >  Clientes <br /> 
					</div>
				</form>
			</div>
			
			<button type="button" onClick="abrirRelatorioFaturamento();" class="btn btn-success" style="margin-top: 0px">Gerar Relatório</button>
				
					<script>
						document.onkeypress = function (evt){
							if(main.procuraTecla(evt,13)){
								if(confirm('Deseja gerar o relat�rio?')){ abrirRelatorioFaturamento() }
							}
						}
						
					</script>
		
		<div id="SaidaMain">
	
		</div>

	</div> <!-- end #content -->
	
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->