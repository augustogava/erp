<?
header("Content-Type: text/html;  charset=ISO-8859-1",true);
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

if($_GET["acao"] == "listar"){
	$ordem = $Main->OrdemProducao->pegaOrdemProducao($_GET["produto"], $_GET["pedido"], $_GET["dataIni"], $_GET["dataFim"], "", $_GET["limite"]);
	//print_r($ordem);
	if(empty($_GET["limite"]) || $_GET["limite"] < 0)
		$limite = "0";
		
?>
<table width="100%" cellspacing="0" cellpadding="0" border="1" id="tabletest" class="table-erp">
	<tbody>
		<tr class="titulo">
			<td width="100%" class="ColunaInfo" colspan="10">Exibindo de <?=$limite?> a <?=($limite+15)?></td>
		</tr>
		<tr class="titulo">
			<td width="20%">Produto</td>
			<td width="10%">Estoque Atual</td>
			<td width="20%" >Qtd</td>
			<td width="10%">Pedido</td>
			<td width="10%" >Data Cadastro</td>
			<td width="10%" >Data Produzido</td>
			<td width="10%" >Status</td>
			<td width="4%" >&nbsp;</td>
			<td width="4%">
				<a href="javascript:doAjaxSemRetorno('ajax_com/ordem_producao.php?acao=listar&produto=<?=$_GET["produto"]?>&pedido=<?=$_GET["pedido"]?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&limite=<?=($limite-15)?>',1,'Saida');" href="#">
					<img border="0" alt="Próximo" src="layout/incones/bulletgreenleft.gif"/>
				</a>
			</td>
			<td width="4%">
				<a href="javascript:doAjaxSemRetorno('ajax_com/ordem_producao.php?acao=listar&produto=<?=$_GET["produto"]?>&pedido=<?=$_GET["pedido"]?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&limite=<?=($limite+15)?>',1,'Saida');" href="#">
					<img border="0" alt="Próximo" src="layout/incones/bulletgreen.gif"/>
				</a>
			</td>
		</tr>
		<?
			for($j=0; $j<count($ordem); $j++){
				$produto = $ordem[$j]->getProdutos();
				$pedido = $ordem[$j]->getPedidos();	
		?>
		<tr id="linhaDataGrid_<?=$j?>" class="linha" width="60%">
			<td  id="linhaDataGrid_<?=$j?>_0">
				<?=$produto[0]->codigo;?>
			</td>
			<td  id="linhaDataGrid_<?=$j?>_0">
				<?=$produto[0]->getEstoqueAtual();?>
			</td>
			<td  id="linhaDataGrid_<?=$j?>_1"/>
				<?=$ordem[$j]->getQtd()?>
			</td>
			<td  id="linhaDataGrid_<?=$j?>_0">
				<?=$pedido[0]->codigo;?>
			</td>
			<td  id="linhaDataGrid_<?=$j?>_1"/>
				<?=$ordem[$j]->getDataCad()?>
			</td>
			<td  id="linhaDataGrid_<?=$j?>_1"/>
				<?=($ordem[$j]->getDataStatus()=="00/00/0000"?"-":$ordem[$j]->getDataStatus())?>
			</td>
			<td  id="linhaDataGrid_<?=$j?>_1"/>
				<?=$ordem[$j]->getStatusNome()?>
			</td>
			<td align="center"> 
				<?php 
				if( $ordem[$j]->getStatusId() != 2 ){
				?>
				<a href="javascript:fecharOrdemProducao(<?=$ordem[$j]->getId()?>, <?=$ordem[$j]->getStatusId()?>)">
					<img border="0" src="layout/incones/fechar_22.png" alt="<?=($ordem[$j]->getStatusId()==1?"Produzir": ($ordem[$j]->getStatusId()==4?"Fechar":"") )?>" title="<?=($ordem[$j]->getStatusId()==1?"Produzir": ($ordem[$j]->getStatusId()==4?"Fechar":"") )?>"/>
				</a>
				<?php } ?>
			</td>
			<td  align="center"> 
				<a href="javascript:doAjaxSemRetorno('ajax_com/ordem_producao.php?acao=editar&id=<?=$ordem[$j]->getId()?>',1,'addPop');addPop_open(550);">
					<img border="0" src="layout/incones/edit.png"/>
				</a>
			</td>
			<td   align="center"> 
				<? if(!$ordem[$j] || ($ordem[$j] && $ordem[$j]->getStatusId() != 2)){ ?>
				<a onclick="if(confirm('Deseja Excluir?')){ excluirOrdemProducao(<?=$ordem[$j]->getId()?>, <?=$ordem[$j]->getStatusId()?>);  }" href="#">
					<img border="0" src="layout/incones/button_cancel.png"/>
				</a>
				<?php } ?>
			</td>
		</tr>
		<?
		}
		?>
		
	</tbody>
</table>
<? 
}else if($_GET["acao"] == "adicionar" || $_GET["acao"] == "editar"){ 
	if($_GET["acao"] == "editar"){
		$ordem = $Main->OrdemProducao->pegaOrdemProducao("", "", "","",$_GET["id"]);
		$produto = $ordem[0]->getProdutos();
		$pedido = $ordem[0]->getPedidos();	
	}
	
	$produtosLista = $Main->Pedidos->pegaProduto();
	$pedidosLista = $Main->Pedidos->pegaPedidos();
	$status = $Main->OrdemProducao->pegaStatusOrdem();
?>
<div style="border: 1px solid rgb(235, 240, 253);" id="SaidaPop">
	<form id="edit" name="edit" action="">
		<table cellspacing="5" cellpadding="0" border="1" align="left" width="100%">
			<tbody>
				<tr>
					<td align="left" width="40%">
						<h2>Adicionar Cadastro</h2>
					</td>
					<td align="right" width="60%">
						<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="addPop_close();">
						  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Fechar
						</button>
					</td>
				</tr>
				<tr>
					<td align="center" style="color: red;" id="erro" colspan="3"></td>
				</tr>
				<tr>
					<td align="right"><b>Produto:</b></td>
					<td align="left" class="form-inline">
						<select id="produto" name="produto" title="Produto" class="erroForm form-control input-sm">
							<option value="">Selecione</option>
							<?
							for($j=0; $j<count($produtosLista); $j++){
								$selected = ($ordem[0] && $produto[0]->id == $produtosLista[$j]->getId()) ? "selected" : "";
							?>					
							<option value="<?=$produtosLista[$j]->getId()?>" <?=$selected?>><?=$produtosLista[$j]->getCodigo()?> - <?=$produtosLista[$j]->getNome()?></option>
							<?
							}
							?>
						</select>
						
						<a onclick="javascript:window.open('buscapopup.php?campoatual=produto&amp;tabela=produtos', 'Busca', 'height = 300, width = 250, location = no, toolbar = no, menubar=no')" href="#"><img border="0" src="layout/incones/find.png"/></a> 
						<a onclick="javascript:window.open('addpopup.php?campoatual=produto&amp;tabela=produtos', 'Busca', 'height = 450, width = 550, location = no, toolbar = no')" href="#"><img border="0" src="layout/incones/add16.png"/></a>
					</td>
				</tr>
				
				<tr>
					<td align="right"><b>Pedido:</b></td>
					<td align="left" class="form-inline">
						<select id="pedido" name="pedido" title="Pedido" class="erroForm form-control input-sm">
							<option value="">Selecione</option>
							<?
							for($j=0; $j<count($pedidosLista); $j++){
								$selected = ($ordem[0] && $pedido[0]->id == $pedidosLista[$j]->getId()) ? "selected" : "";
							?>					
							<option value="<?=$pedidosLista[$j]->getId()?>" <?=$selected?>><?=$pedidosLista[$j]->getCodigo()?></option>
							<?
							}
							?>
						</select>
						
						<a onclick="javascript:window.open('buscapopup.php?campoatual=pedido&amp;tabela=pedidos', 'Busca', 'height = 300, width = 250, location = no, toolbar = no, menubar=no')" href="#"><img border="0" src="layout/incones/find.png"/></a> 
						<a onclick="javascript:window.open('addpopup.php?campoatual=pedido&amp;tabela=pedidos', 'Busca', 'height = 450, width = 550, location = no, toolbar = no')" href="#"><img border="0" src="layout/incones/add16.png"/></a>
					</td>
				</tr>
			
				
				<tr>
					<td align="right"><b>Quantidade:</b></td>
					<td align="left">
						<input type="text" class="form-control input-sm" name="qtd" id="qtd" size="5" onkeypress="mascaras.mascara(this,'soNumeros')" value="<? if($ordem[0]) print $ordem[0]->getQtd()?>" >
					</td>
				</tr>
			
				<tr>
					<td align="right"><b>Descrição:</b></td>
					<td align="left">
						<input type="text" class="form-control input-sm" name="descricao" id="descricao"  value="<? if($ordem[0]) print $ordem[0]->getDescricao()?>">
					</td>
				</tr>
				<tr>
					<td align="right"><b>Data:</b></td>
					<td align="left">
						<input type="text" class="form-control input-sm" name="data" id="data" size="11" onkeypress="mascaras.mascara(this,'data')"  value="<? if($ordem[0]) print $ordem[0]->getDataCad()?>">
					</td>
				</tr>
				
				<tr>
					<td align="center" colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" colspan="3">
						<div class="btn-group" role="group" aria-label="...">
							<? if(!$ordem[0] || ($ordem[0] && $ordem[0]->getStatusId() != 2)){ ?><input class="btn btn-success btn-sm " type="button" onclick="salvaOrdemProducao(<?=$_GET["id"]?>)" value="Salvar" /><? } ?> 
							<input class="btn btn-danger btn-sm" type="button" onclick="addPop_close();" value="Cancelar"/>
						</div>
						
						<input type="hidden" name="id" id="id" value="<?=$_GET["id"]?>"/>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
	<? if(!$ordem[0] || ($ordem[0] && $ordem[0]->getStatusId() != 2)){ ?>
	<script>
	document.onkeypress = function (evt){
		if(main.procuraTecla(evt,13)){
			if(confirm('Deseja salvar?')){ salvaOrdemProducao(<?=$_GET["id"]?>); } 
		}
	}
	</script>
	<? } ?>
</div>
<? 
}
?>