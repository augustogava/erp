<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

$produtos = $Main->Pedidos->pegaProduto($_GET["id"]);

include($Main->Configuracoes->HEADER_NADMIN);  
?>
<div id="main-body">
	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Composição Produtos -  <?=$produtos[0]->getCodigo()." ".$produtos[0]->getNome()?></p>
			</div>
		</div>
	</div>
	
	<div id="content">
	
			<div class="linhaConfig" id="busca">  
				<ul class="nav nav-tabs" role="tablist">
    				<li role="presentation" class=""><a href="#"  onclick="main.trocad('buscaDiv');" aria-controls="home" role="tab" data-toggle="tab"><span class="glyphicon fa fa-search" aria-hidden="true"></span> Consultar</a></li>
    				<li role="presentation" class=""><a href="#"  onclick="javascript:doAjaxSemRetorno('ajax_com/composicao.php?acao=adicionar&id=<?=$_GET["id"]?>',1,'addPop');addPop_open(630);" aria-controls="home" role="tab" data-toggle="tab"><span class="glyphicon fa fa-file" aria-hidden="true"></span> Cadastrar Novo</a></li>
    			</ul>
    			
				<div id="buscaDiv" style="display:none;">
					<div class="form-group form-inline">
						<label for="itensBusca">Produtos</label>
						<select id="itensBusca" class="form-control input-xs normalsizeSelect" name="itensBusca">
							<option value="">Selecione</option>
							<?
							$produtos = $Main->Pedidos->pegaProduto();
							for($j=0; $j<count($produtos); $j++){
							?>					
							<option value="<?=$produtos[$j]->getId()?>"><?=$produtos[$j]->getCodigo()?> - <?=$produtos[$j]->getNome()?></option>
							<?
							}
							?>
						</select>
						
						<button type="button" class="btn btn-sm btn-default" onClick="doAjaxSemRetorno('ajax_com/composicao.php?acao=listar&id=<?=$_GET["id"]?>&itensBusca=' + $('itensBusca').value , 1, 'Saida');">Buscar</button>
						
					</div>
				</div>
			</div>
		
		<div id="Saida">
	
		</div>

	</div> <!-- end #content -->

	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->
<script>refreshComposicao(<?=$_GET["id"]?>);</script>