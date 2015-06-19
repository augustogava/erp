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
		mCal = new dhtmlxCalendarObject(['filtro1', 'filtro2']);
		mCal.setDateFormat("%d/%m/%Y");
	}
	
</script>
<div id="main-body">
	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Curva ABC</p>
			</div>
		</div>
	</div>
	<div id="content">
	
			<div class="linhaConfig" id="busca">  
				<form id="edit" name="edit" >	
					<div class="form-group form-inline">
						<label for="filtro3">Clientes</label>
						<select id="filtro3" name="filtro3" title="Clientes" class="form-control input-sm normalsizeSelect">
                                            <option value="">Todos</option>
                                            <?
                                            for($j=0; $j<count($clientes); $j++){
                                            ?>
                                            <option value="<?=$clientes[$j]->getId()?>" ><?=$clientes[$j]->getNome()?></option>
                                            <?
                                            }
                                            ?>
                                        </select>
					</div>
					<div class="form-group form-inline">
						<label for="filtro1">Data Inicial</label>
						<input type="text" class="form-control input-sm" name="filtro1" id="filtro1" size="11" onkeypress="mascaras.mascara(this,'data')" value="<?=date("d/m/Y", mktime(0,0,0,date("m"), 01, date("Y"))) ?>">
		
						<label for="filtro2">Data Final</label>
						<input type="text" class="form-control input-sm" name="filtro2" id="filtro2" size="11" onkeypress="mascaras.mascara(this,'data')" value="<?=date("d/m/Y", mktime(0,0,0, date("m"), 31, date("Y"))) ?>">
					</div>
				</form>
			</div>
			
			<button type="button" onClick="abrirRelatorioCurvaABC();" class="btn btn-success" style="margin-top: 0px">Gerar Relatório</button>
				
					<script>
						document.onkeypress = function (evt){
							if(main.procuraTecla(evt,13)){
								if(confirm('Deseja gerar o relatório?')){ abrirRelatorioCurvaABC() }
							}
						}
						
					</script>
		<div id="SaidaMain">
	
		</div>

	</div> <!-- end #content -->
	
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->