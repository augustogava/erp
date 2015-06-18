<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

$produtos = $Main->Pedidos->pegaProduto();
//SELECT  (SELECT sum(qtd) FROM estoque WHERE tipo = 1) - (SELECT sum(qtd) FROM estoque WHERE tipo = 2)  as total FROM estoque LIMIT 1
		
include($Main->Configuracoes->HEADER_NADMIN);  
?>
<div id="main-body">
	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Estoque Entrada</p>
			</div>
		</div>
	</div>
	
	<div id="content">
			<div class="linhaConfig" id="busca">  
				Clientes
				<select id="clientesBusca" name="clientesBusca">
					<option value="0">Selecione</option>
					<?
					for($j=0; $j<count($clientes); $j++){
					?>					
					<option value="<?=$clientes[$j]->getId()?>"><?=$clientes[$j]->getNome()?></option>
					<?
					}
					?>
				</select>
				
				Status:
				<select id="statusBusca" name="statusBusca">
					<option value="0">Selecione</option>
					<?
					for($j=0; $j<count($status); $j++){
					?>					
					<option value="<?=$status[$j]->getId()?>"><?=$status[$j]->getNome()?></option>
					<?
					}
					?>
				</select>
				<a onclick="javascript:doAjaxSemRetorno('ajax_com/pedidos.php?acao=listar&clientes=' + $('clientesBusca').value + '&status=' + $('statusBusca').value,1,'Saida');" href="#">
					<img border="0" src="layout/incones/find.png"/>
				</a>
				
				<br/>
				
					<center>
						 <a href="javascript:doAjaxSemRetorno('ajax_com/pedidos.php?acao=adicionar',1,'addPop');addPop_open(630);">Adicionar</a>
					</center>
					
					<input type="hidden" id="urlHidden" name="urlHidden" value="ajax_com/montaDataGrid.php?ord"/>
					<input type="hidden" id="queryB" name="queryB" value=""/>
					
					<script>
						document.onkeypress = function (evt){
							if(main.procuraTecla(evt,13)){
								if(confirm('Deseja efetuar a busca?')){  }
							}
						}
						
					</script>
			</div>
		
		<div style="border: 1px solid rgb(235, 240, 253);" id="Saida">
	
		</div>

	</div> <!-- end #content -->
	
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->
<script>refreshPedido();</script>