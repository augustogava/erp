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
	  			<p class="titlePage" id="recent">Relatório Vendas</p>
			</div>
		</div>
	</div>
	<div id="content">
			<div class="linhaConfig" id="busca">  
				<form id="edit" name="edit" >	
					<div class="form-group form-inline">
						<label for="filtro2">Data Início</label>
						<input name="filtro2" id="filtro2" class="form-control input-xs" type="text" onKeyPress="mascaras.mascara(this,'data')" size="10"  value="<?=date("d/m/Y", mktime(0,0,0,date("m"), 01, date("Y"))) ?>">
						 
						<label for="filtro3">Data Fim</label>
						<input name="filtro3" id="filtro3" class="form-control input-xs" type="text" onKeyPress="mascaras.mascara(this,'data')" size="10" value="<?=date("d/m/Y", mktime(0,0,0, date("m"), 30, date("Y"))) ?>"> <br />
						
						<label id="label4" for="filtro4" style="display: none;">Clientes</label>
						<select id="filtro4" name="filtro4" title="Clientes" style="display: none;" class="form-control input-xs normalsizeSelect">
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
						Listar Por: <br /> <input type="radio" name="filtro1" id="filtro1" value="1" checked onclick="$('filtro4').style.display='none'; $('label4').style.display='none';"> Produtos 
						<input type="radio" name="filtro1" id="filtro1_1" value="2" onclick="$('filtro4').style.display='none'; $('label4').style.display='none';"> Representantes 
						<input type="radio" name="filtro1" id="filtro1_1" value="3" onclick="$('filtro4').style.display='none'; $('label4').style.display='none';"> Clientes
						<input type="radio" name="filtro1" id="filtro1_1" value="4" onclick="$('filtro4').style.display=''; $('label4').style.display='';"> Detalhado
						<input type="radio" name="filtro1" id="filtro1_1" value="5" onclick="$('filtro4').style.display='none'; $('label4').style.display='none';"> Mensal  <br /> 
					</div>
				</form>
			
				<button type="button" onClick="abrirRelatorioVendas();" class="btn btn-success" style="margin-top: 0px">Gerar Relatório</button>
				
				<br/>
				
					<script>
						document.onkeypress = function (evt){
							if(main.procuraTecla(evt,13)){
								if(confirm('Deseja gerar o relatório?')){ abrirRelatorioVendas() }
							}
						}
						
					</script>
			</div>
		
		<div id="SaidaMain">
	
		</div>

	</div> <!-- end #content -->
	
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->