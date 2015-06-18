<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
$Main->AdicionaComposicao();

$produtos = $Main->Pedidos->pegaProduto($_GET["id"]);

include($Main->Configuracoes->HEADER_NADMIN);  
?>
<div id="main-body">
	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Composi��o Produtos -  <?=$produtos[0]->getCodigo()." ".$produtos[0]->getNome()?></p>
			</div>
		</div>
	</div>
	
	<div id="content">
	
			<div class="linhaConfig" id="busca">  
				<a href="javascript:main.trocad('buscaDiv');" class="button"><span>Consultar</span></a> 
				
				<a href="javascript:doAjaxSemRetorno('ajax_com/composicao.php?acao=adicionar&id=<?=$_GET["id"]?>',1,'addPop');addPop_open(630);" class="button"><span>Incluir</span></a><br /><br /> 
				
				<div id="buscaDiv" style="display:none;">
					<div class="form-group form-inline">
						<label for="itensBusca">Produtos</label>
						<select id="itensBusca" class="form-control input-sm normalsizeSelect" name="itensBusca">
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
						
						<a href="javascript:doAjaxSemRetorno('ajax_com/composicao.php?acao=listar&id=<?=$_GET["id"]?>&itensBusca=' + $('itensBusca').value , 1, 'Saida');" href="#">
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
<script>refreshComposicao(<?=$_GET["id"]?>);</script>