<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
$Main->AdicionaPedidos();
$Main->AdicionaFluxoBanco();

$clientes = $Main->Pedidos->pegaClientes();
$tipoFluxo = $Main->FluxoBanco->pegaTipoFluxo();
		
include($Main->Configuracoes->HEADER_NADMIN);  
?>
<script>
    var mCal;
    window.onload = function() {
            mCal = new dhtmlxCalendarObject(['dataIni']);
            mCal.setDateFormat("%d/%m/%Y");
    }
</script>
<div id="main-body">
	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Fluxo Banco</p>
			</div>
		</div>
	</div>
	
	<div id="content">
			<div class="linhaConfig" id="busca">  
			<?
                                    if($_GET["idBanco"] > 0){
                                ?>
                                <a href="javascript:main.trocad('buscaDiv');" class="button"><span>Consultar</span></a>
				
				<a href="javascript:doAjaxSemRetorno('ajax_com/fluxoBanco.php?acao=adicionar&idBanco=<?=$_GET["idBanco"]?>',1,'addPop');addPop_open(630);" class="button"><span>Incluir</span></a><br /><br />
			<?
                                    }
                                ?>
			<div id="buscaDiv" style="display:none;">
				<div class="form-group form-inline">
					<label for="tipoFluxoBusca">Tipo Fluxo</label>
					<select id="tipoFluxoBusca" class="form-control input-sm normalsizeSelect" name="tipoFluxoBusca">
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
					<select id="tipoBusca" class="form-control input-sm normalsizeSelect" name="tipoBusca">
						<option value="">Selecione</option>
						<option value="1">Entrada</option>
						<option value="2">Sa�da</option>
					</select>
					
					
					<label for="dataIni">Data Inicial</label>
					<input type="text" class="form-control input-sm" name="dataIni" id="dataIni" size="11" onkeypress="mascaras.mascara(this,'data')" value="<?=date("d/m/Y", mktime(0,0,0,date("m"), 01, date("Y"))) ?>">
					
					<a href="javascript:doAjaxSemRetorno('ajax_com/fluxoBanco.php?acao=listar&idBanco=<?=$_GET["idBanco"]?>&tipo=' + $('tipoBusca').value + '&tipoFluxo=' + $('tipoFluxoBusca').value + '&dataIni=' + $('dataIni').value  ,1,'Saida');" href="#">
						<img border="0" src="layout/incones/find.png"/>
					</a>
				
				</div>
			</div>
		</div>
			
		<div id="Saida"></div>

	</div> <!-- end #content -->
	
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->
<script>
    dragA.criar_dragEl('drag1',0);
    <?
        if($_GET["idBanco"] > 0){
    ?>
            refreshFluxoBancoFluxo(<?=$_GET["idBanco"]?>);
    <?
        }else{
    ?>
            refreshFluxoBanco();
    <?
         }
    ?>
</script>