<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

$clientes = $Main->Pedidos->pegaClientes();
$tipoFluxo = $Main->Fluxo->pegaTipoFluxo();
		
include($Main->Configuracoes->HEADER_NADMIN);  
?>
<script>
		var mCal, mCal2;
	window.onload = function() {
		mCal = new dhtmlxCalendarObject(['dataIni']);
		mCal.setDateFormat("%d/%m/%Y");

		mCal = new dhtmlxCalendarObject(['dataFim']);
		mCal.setDateFormat("%d/%m/%Y");
	}
	
</script>
<div id="main-body">
	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Fluxo</p>
			</div>
		</div>
	</div>
	
	<div id="content">
	
			<div class="linhaConfig" id="busca">  
				<ul class="nav nav-tabs" role="tablist">
    				<li role="presentation" class=""><a href="#"  onclick="main.trocad('buscaDiv');" aria-controls="home" role="tab" data-toggle="tab"><span class="glyphicon fa fa-search" aria-hidden="true"></span> Consultar</a></li>
    			</ul>
    			
				<div id="buscaDiv" style="display:none;">
					<div class="form-group form-inline">
						<label for="clienteBusca">Cliente</label>
						<select id="clienteBusca" class="form-control input-xs normalsizeSelect" name="clienteBusca">
							<option value="">Selecione</option>
							<?
							for($j=0; $j<count($clientes); $j++){
							?>					
							<option value="<?=$clientes[$j]->getId()?>"><?=$clientes[$j]->getNome()?></option>
							<?
							}
							?>
						</select>
						
						<label for="tipoFluxoBusca">Tipo Fluxo</label>
						<select id="tipoFluxoBusca" class="form-control input-xs normalsizeSelect" name="tipoFluxoBusca">
							<option value="">Selecione</option>
							<?
							for($j=0; $j<count($tipoFluxo); $j++){
							?>					
							<option value="<?=$tipoFluxo[$j]->getId()?>"><?=$tipoFluxo[$j]->getNome()?></option>
							<?
							}
							?>
						</select>
						
						<label for="tipoBusca">Tipo</label>
						<select id="tipoBusca" class="form-control input-xs normalsizeSelect" name="tipoBusca">
							<option value="">Selecione</option>
							<option value="1">Entrada</option>
							<option value="2">Saída</option>
						</select>
						<br>
						<label for="dataIni">Data Inicial</label>
						<input type="text" class="form-control input-xs" name="dataIni" id="dataIni" size="11" onkeypress="mascaras.mascara(this,'data')" value="<?=date("d/m/Y", mktime(0,0,0,date("m"), 01, date("Y"))) ?>">
						
						<label for="dataFim">Data Final</label>
						<input type="text" class="form-control input-xs" name="dataFim" id="dataFim" size="11" onkeypress="mascaras.mascara(this,'data')">
						
						
						<button type="button" class="btn btn-sm btn-default" onClick="doAjaxSemRetorno('ajax_com/fluxo.php?acao=listar&cliente=' + $('clienteBusca').value + '&tipo=' + $('tipoBusca').value + '&tipoFluxo=' + $('tipoFluxoBusca').value + '&dataIni=' + $('dataIni').value + '&dataFim=' + $('dataFim').value ,1,'Saida');">Buscar</button>
					</div>
				</div>
			</div>
		
		<div id="Saida">
	
		</div>

	</div> <!-- end #content -->

	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->
<script>refreshFluxo();</script>