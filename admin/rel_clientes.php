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
<div id="main-body">
	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Relatório Clientes</p>
			</div>
		</div>
	</div>
	<div id="content">
	
			<div class="linhaConfig" id="busca">  
				<form id="edit" name="edit" >	
					<div class="form-group form-inline">
						<input type="radio" name="filtro1" id="filtro1" value="1" checked> Clientes que nunca compraram <br />
						<input type="radio" name="filtro1" id="filtro1_1" value="2" > Clientes que n�o compram desde: <input name="filtro2" id="filtro2" type="text" onKeyPress="mascaras.mascara(this,'data')" size="10"> <br />
					</div>
					
					<div class="form-group form-inline">
						<label for="filtro3">Estado</label>
						<select id="filtro3" name="filtro3" onChange="dataGrid.pegarCidades(this.value);" class="form-control input-sm normalsizeSelect">
								<option value="0">Selecione</option>
								<?
								for($j=0; $j<count($estados); $j++){
								?>					
								<option value="<?=$estados[$j]->getId()?>"><?=$estados[$j]->getNome()?></option>
								<?
								}
								?>
							</select>
						<label for="edit_id_cidade">Cidade</label>
						<span id="td_id_cidade">
							<select id="edit_id_cidade" name="edit_id_cidade" class="form-control input-sm normalsizeSelect">
								<option value="0">Selecione</option>
							</select>
					</div>
				</form>
			</div>

			<button type="button" onClick="abrirRelatorioClientes();" class="btn btn-success" style="margin-top: 0px">Gerar Relatório</button>		
					<script>
						document.onkeypress = function (evt){
							if(main.procuraTecla(evt,13)){
								if(confirm('Deseja gerar o relat�rio?')){ abrirRelatorioClientes() }
							}
						}
						
					</script>
		
		<div id="SaidaMain">
	
	</div> <!-- end #content -->
	
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->