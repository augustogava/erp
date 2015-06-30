<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

$tipos = $Main->Padrao->pegaTiposProdutos();

include($Main->Configuracoes->HEADER_NADMIN);  
?>
<div id="main-body">
	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Relatório Estoque Atual</p>
			</div>
		</div>
	</div>
	<div id="content">
	
			<div class="linhaConfig" id="busca">  
			<form id="edit" name="edit" >	
				<div class="form-group form-inline">
						<label for="filtro1">Status Ordem Produção</label>
						<select id="filtro1" name="filtro1" class="form-control input-xs normalsizeSelect">
							<option value="0">Selecione</option>
							<?
							for($j=0; $j<count($tipos); $j++){
							?>					
							<option value="<?=$tipos[$j]->getId()?>"><?=$tipos[$j]->getNome()?></option>
							<?
							}
							?>
						</select>
					</div>
			</form>
			</div>
				<button type="button" onClick="abrirRelatorioEstoqueAtual();" class="btn btn-success" style="margin-top: 10px">Gerar Relatório</button>

		<div id="SaidaMain">
	
		</div>

	</div> <!-- end #content -->
	
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->