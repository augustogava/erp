<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

$produtos = $Main->Pedidos->pegaProduto();
//SELECT  (SELECT sum(qtd) FROM estoque WHERE tipo = 1) - (SELECT sum(qtd) FROM estoque WHERE tipo = 2)  as total FROM estoque LIMIT 1
		
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
	  			<p class="titlePage" id="recent">Estoque</p>
			</div>
		</div>
	</div>
	
	<div id="content">
	
			<div class="linhaConfig" id="busca">  
				<a href="javascript:main.trocad('buscaDiv');" class="button"><span>Consultar</span></a> 
				
				<a href="javascript:doAjaxSemRetorno('ajax_com/estoque.php?acao=adicionar',1,'addPop');addPop_open(630);" class="button"><span>Incluir</span></a><br /><br /> 
				
				<div id="buscaDiv" style="display:none;">
					<div class="form-group form-inline">
						<label for="produtoBusca">Produtos</label>
						<select class="form-control input-sm normalsizeSelect" id="produtoBusca" name="produtoBusca">
							<option value="">Selecione</option>
							<?
							for($j=0; $j<count($produtos); $j++){
							?>					
							<option value="<?=$produtos[$j]->getId()?>"><?=$produtos[$j]->getCodigo()?> - <?=$produtos[$j]->getNome()?></option>
							<?
							}
							?>
						</select>
						
						<label for="tipoBusca">Tipo</label>
						<select class="form-control input-sm normalsizeSelect" id="tipoBusca" name="tipoBusca">
							<option value="">Selecione</option>
							<option value="1">Entrada</option>
							<option value="2">Sa�da</option>
						</select>
						
						<label for="dataIni">Data Inicial</label>
						<input class="form-control input-sm" type="text" name="dataIni" id="dataIni" size="11" onkeypress="mascaras.mascara(this,'data')">
						<label for="dataFim">Data Final</label>
						<input class="form-control input-sm" type="text" name="dataFim" id="dataFim" size="11" onkeypress="mascaras.mascara(this,'data')">
						
						<a href="javascript:doAjaxSemRetorno('ajax_com/estoque.php?acao=listar&produto=' + $('produtoBusca').value + '&tipo=' + $('tipoBusca').value + '&dataIni=' + $('dataIni').value + '&dataFim=' + $('dataFim').value ,1,'Saida');" href="#">
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

<script>refreshEstoque();</script>