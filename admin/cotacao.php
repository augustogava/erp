<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
$fornecedores = $Main->Compras->pegaFornecedores();
				
include($Main->Configuracoes->HEADER_NADMIN);  
?>
	<script>
		var mCal;
	window.onload = function() {
		mCal = new dhtmlxCalendarObject(['dataIni', 'dataFim']);
		mCal.setDateFormat("%d/%m/%Y");
	}
	
	</script>
<div id="main-body">
	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Cotação</p>
			</div>
		</div>
	</div>
	
	<div id="content">
	
			<div class="linhaConfig" id="busca">  
				<ul class="nav nav-tabs" role="tablist">
    				<li role="presentation" class=""><a href="#"  onclick="main.trocad('buscaDiv');" aria-controls="home" role="tab" data-toggle="tab"><span class="glyphicon fa fa-search" aria-hidden="true"></span> Consultar</a></li>
    				<li role="presentation" class=""><a href="#"  onclick="doAjaxSemRetorno('ajax_com/compras.php?acao=adicionar&local=cotacao',1,'addPop');addPop_open(630);" aria-controls="home" role="tab" data-toggle="tab"><span class="glyphicon fa fa-file" aria-hidden="true"></span> Cadastrar Novo</a></li>
    			</ul>
    			
				<div id="buscaDiv" style="display:none;">
					<div class="form-group form-inline">
						<label for="codigoBusca">Código</label>
						<input class="form-control input-xs"type="text" name="codigoBusca" id="codigoBusca" size="15">
						
						
						<label for="fornecedoresBusca">Fornecedores</label>
						<select  class="form-control input-xs normalsizeSelect" id="fornecedoresBusca" name="fornecedoresBusca">
							<option value="0">Selecione</option>
							<?
							for($j=0; $j<count($fornecedores); $j++){
							?>					
							<option value="<?=$fornecedores[$j]->getId()?>"><?=$fornecedores[$j]->getNome()?></option>
							<?
							}
							?>
						</select>
						
						<label for="dataIni">Data Inicial</label>
						<input class="form-control input-xs" type="text" name="dataIni" id="dataIni" size="11" onkeypress="mascaras.mascara(this,'data')" value="<?=date("d/m/Y", mktime(0,0,0,date("m"), 01, date("Y"))) ?>">
						<label for="dataFim">Data Final</label>
						<input class="form-control input-xs" type="text" name="dataFim" id="dataFim" size="11" onkeypress="mascaras.mascara(this,'data')" value="<?=date("d/m/Y", mktime(0,0,0, date("m"), 31, date("Y"))) ?>">
						
						<button type="button" class="btn btn-sm btn-default" onClick="doAjaxSemRetorno('ajax_com/compras.php?acao=listarCotacao&fornecedores=' + $('fornecedoresBusca').value  + '&dataIni=' + $('dataIni').value + '&dataFim=' + $('dataFim').value + '&codigo=' + $('codigoBusca').value, 1, 'SaidaMain');">Buscar</button>
					</div>
					<br/>
				</div>
					<script>
						document.onkeypress = function (evt){
							if(main.procuraTecla(evt,13)){
								if(confirm('Deseja efetuar a busca?')){  }
							}
						}
						
					</script>
			</div>
		
		<div style="border: 1px solid rgb(235, 240, 253);" id="SaidaMain">
	
		</div>

	</div> <!-- end #content -->
	
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->
<script>refreshCotacao();</script>