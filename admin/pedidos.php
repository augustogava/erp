<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
//session_unset($_SESSION["Ordena"]);

$clientes = $Main->Pedidos->pegaClientes();
$status = $Main->Pedidos->pegaListaStatus();
				
include($Main->Configuracoes->HEADER_NADMIN);  
?>
	<script>
		var mCal;
	window.onload = function() {
		mCal = new dhtmlxCalendarObject(['dataIni', 'dataFim', 'dataEnvioIni', 'dataEnvioFim']);
		mCal.setDateFormat("%d/%m/%Y");
	}
	
	</script>
<div id="main-body">
	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Pedidos</p>
			</div>
		</div>
	</div>
	<div id="content">
	
			<div class="linhaConfig" id="busca">  
				<ul class="nav nav-tabs" role="tablist">
    				<li role="presentation" class=""><a href="#"  onclick="main.trocad('buscaDiv');" aria-controls="home" role="tab" data-toggle="tab">Consultar</a></li>
    				<li role="presentation" class=""><a href="#"  onclick="doAjaxSemRetorno('ajax_com/pedidos.php?acao=adicionar',1,'addPop');addPop_open(630);" aria-controls="home" role="tab" data-toggle="tab">Cadastrar Novo</a></li>
    			</ul>
    			 
				<div id="buscaDiv" style="display:none;">
					<div class="form-group form-inline">
						<label for="clientesBusca">Clientes</label>
						<select class="form-control input-sm normalsizeSelect" id="clientesBusca" name="clientesBusca">
							<option value="0">Selecione</option>
							<?
							for($j=0; $j<count($clientes); $j++){
							?>					
							<option value="<?=$clientes[$j]->getId()?>"><?=$clientes[$j]->getNome()?></option>
							<?
							}
							?>
						</select>
						
						<label for="statusBusca">Status</label>
						<select class="form-control input-sm normalsizeSelect" id="statusBusca" name="statusBusca">
							<option value="0">Selecione</option>
							<?
							for($j=0; $j<count($status); $j++){
							?>					
							<option value="<?=$status[$j]->getId()?>"><?=$status[$j]->getNome()?></option>
							<?
							}
							?>
						</select>
					</div>
					<div class="form-group form-inline">
						<label for="codigoBusca">Código</label>
						<input class="form-control input-sm" type="text" name="codigoBusca" id="codigoBusca" size="15">
						<label for="dataIni">Data Inicial:</label>
						 <input class="form-control input-sm" type="text" name="dataIni" id="dataIni" size="11" onkeypress="mascaras.mascara(this,'data')" value="<?=date("d/m/Y", mktime(0,0,0,date("m"), 01, date("Y"))) ?>">
						<label for="dataFim">Data Final:</label>
						 <input class="form-control input-sm" type="text" name="dataFim" id="dataFim" size="11" onkeypress="mascaras.mascara(this,'data')" value="<?=date("d/m/Y", mktime(0,0,0, date("m"), 31, date("Y"))) ?>">
						
						<label for="dataEnvioIni">Data Envio Inicial:</label>
						<input class="form-control input-sm" type="text" name="dataEnvioIni" id="dataEnvioIni" size="11" onkeypress="mascaras.mascara(this,'data')" value="">
						<label for="dataEnvioFim">Data Final Final:</label>
						<input class="form-control input-sm" type="text" name="dataEnvioFim" id="dataEnvioFim" size="11" onkeypress="mascaras.mascara(this,'data')" value="">
						
						<button type="button" class="btn btn-sm btn-default" onClick="doAjaxSemRetorno('ajax_com/pedidos.php?acao=listar&clientes=' + $('clientesBusca').value + '&status=' + $('statusBusca').value + '&dataIni=' + $('dataIni').value + '&dataFim=' + $('dataFim').value + '&codigo=' + $('codigoBusca').value + '&dataEnvioIni=' + $('dataEnvioIni').value + '&dataEnvioFim=' + $('dataEnvioFim').value,1,'SaidaMain');">Buscar</button>
					</div>
				</div>
					<script>
						document.onkeypress = function (evt){
							if(main.procuraTecla(evt,13)){
								if(confirm('Deseja efetuar a busca?')){  }
							}
						}
						
					</script>
			</div>
		
		<div id="SaidaMain">
		</div>

	</div> <!-- end #content -->
	
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->
<script>refreshPedido();</script>