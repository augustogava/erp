<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
$Main->AdicionaOrdemSeparacao();

$produtos = $Main->Pedidos->pegaProduto();
$pedidos = $Main->Pedidos->pegaPedidos();
		
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
	  			<p class="titlePage" id="recent">Ordem de Separação</p>
			</div>
		</div>
	</div>
	<div id="content">
	
			<div class="linhaConfig" id="busca">  
				<a href="javascript:main.trocad('buscaDiv');" class="button"><span>Consultar</span></a> 
				
				<a href="javascript:doAjaxSemRetorno('ajax_com/ordem_separacao.php?acao=adicionar',1,'addPop');addPop_open(630);" class="button"><span>Incluir</span></a><br /><br /> 
				
				<div id="buscaDiv" style="display:none;">
					<div class="form-group form-inline">
						<label for="produtoBusca">Produtos</label>
						<select id="produtoBusca"class="form-control input-sm normalsizeSelect" name="produtoBusca">
							<option value="">Selecione</option>
							<?
							for($j=0; $j<count($produtos); $j++){
							?>					
							<option value="<?=$produtos[$j]->getId()?>"><?=$produtos[$j]->getCodigo()?> - <?=$produtos[$j]->getNome()?></option>
							<?
							}
							?>
						</select>
						
						<label for="pedidoBusca">Pedido</label>
						<select id="pedidoBusca" class="form-control input-sm normalsizeSelect" name="pedidoBusca">
							<option value="">Selecione</option>
							<?
							for($j=0; $j<count($pedidos); $j++){
							?>					
							<option value="<?=$pedidos[$j]->getId()?>"><?=$pedidos[$j]->getCodigo()?></option>
							<?
							}
							?>
						</select>
						
						<label for="dataIni">Data Inicial</label>
						<input type="text" name="dataIni" class="form-control input-sm" id="dataIni" size="11" onkeypress="mascaras.mascara(this,'data')">
						
						<label for="dataFim">Data Final</label>
						<input type="text" name="dataFim" class="form-control input-sm" id="dataFim" size="11" onkeypress="mascaras.mascara(this,'data')">
						
						<a href="javascript:doAjaxSemRetorno('ajax_com/ordem_separacao.php?acao=listar&produto=' + $('produtoBusca').value + '&pedido=' + $('pedidoBusca').value + '&dataIni=' + $('dataIni').value + '&dataFim=' + $('dataFim').value ,1,'Saida');" href="#">
							<img border="0" src="layout/incones/find.png"/>
						</a>
					</div>
				</div>
			</div>
		<div id="Saida">
	
		</div>

	</div> <!-- end #content -->
	
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->
<script>refreshOrdemSeparacao();</script>