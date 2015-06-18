<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
$Main->AdicionaCompras();
//session_unset($_SESSION["Ordena"]);

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
	  			<p class="titlePage" id="recent">Compras</p>
			</div>
		</div>
	</div>
	
	<div id="content">
			
			<div class="linhaConfig" id="busca">  
				<a href="javascript:main.trocad('buscaDiv');" class="button"><span>Consultar</span></a> 
				
				<a href="javascript:doAjaxSemRetorno('ajax_com/compras.php?acao=adicionar&local=compras',1,'addPop');addPop_open(630);" class="button"><span>Incluir</span></a><br /><br />
				
				<div id="buscaDiv" style="display:none;">
					<div class="form-group form-inline">
						<label for="codigoBusca">Código</label>
						<input class="form-control input-sm"type="text" name="codigoBusca" id="codigoBusca" size="15">
						
						
						<label for="fornecedoresBusca">Fornecedores</label>
						<select  class="form-control input-sm normalsizeSelect" id="fornecedoresBusca" name="fornecedoresBusca">
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
						<input class="form-control input-sm" type="text" name="dataIni" id="dataIni" size="11" onkeypress="mascaras.mascara(this,'data')" value="<?=date("d/m/Y", mktime(0,0,0,date("m"), 01, date("Y"))) ?>">
						<label for="dataFim">Data Final</label>
						<input class="form-control input-sm" type="text" name="dataFim" id="dataFim" size="11" onkeypress="mascaras.mascara(this,'data')" value="<?=date("d/m/Y", mktime(0,0,0, date("m"), 31, date("Y"))) ?>">
						
						<a href="javascript:doAjaxSemRetorno('ajax_com/compras.php?acao=listarCompras&fornecedores=' + $('fornecedoresBusca').value  + '&dataIni=' + $('dataIni').value + '&dataFim=' + $('dataFim').value + '&codigo=' + $('codigoBusca').value, 1, 'SaidaMain');" href="#">
							<img border="0" src="layout/incones/find.png"/>
						</a>
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
		
		<div id="SaidaMain">
	
		</div>

	</div> <!-- end #content -->
	
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->
<script>refreshCompras();</script>