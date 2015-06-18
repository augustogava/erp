<?
header("Content-Type: text/html;  charset=ISO-8859-1",true);
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
$Main->AdicionaComposicao();

if($_GET["acao"] == "listar"){
	$composicao = $Main->Composicao->pegaComposicao($_GET["id"], $_GET["itensBusca"], "", $_GET["limite"]);
	if(empty($_GET["limite"]) || $_GET["limite"] < 0)
		$limite = "0";
	
	
?>
<table width="100%" cellspacing="0" cellpadding="0" border="1" id="tabletest">
	<tbody>
		<tr class="titulo">
			<td width="100%" class="ColunaInfo" colspan="4">Exibindo de <?=$limite?> a <?=($limite+15)?></td>
		</tr>
		<tr class="titulo">
			<td width="60%">Produto</td>
			<td width="30%" >Qtd</td>
			<td width="4%">
				<a href="javascript:doAjaxSemRetorno('ajax_com/composicao.php?acao=listar&id=<?=$_GET["id"]?>itensBusca=<?=$_GET["itensBusca"]?>&limite=<?=($limite-15)?>',1,'Saida');" href="#">
					<img border="0" alt="Próximo" src="layout/incones/bulletgreenleft.gif"/>
				</a>
			</td>
			<td width="4%">
				<a href="javascript:doAjaxSemRetorno('ajax_com/composicao.php?acao=listar&id=<?=$_GET["id"]?>itensBusca=<?=$_GET["itensBusca"]?>&limite=<?=($limite+15)?>',1,'Saida');" href="#">
					<img border="0" alt="Próximo" src="layout/incones/bulletgreen.gif"/>
				</a>
			</td>
		</tr>
		<?
			for($j=0; $j<count($composicao); $j++){
		?>
		<tr id="linhaDataGrid_<?=$j?>" class="linha" width="60%">
			<td width="60%"  id="linhaDataGrid_<?=$j?>_0">
				<?=$composicao[$j]->getProdutoNome()?>
			</td>
			<td width="30%" id="linhaDataGrid_<?=$j?>_1"/>
				<?=$composicao[$j]->getQtd()?>
			</td>
			<td width="4%" align="center"> 
				<a href="javascript:doAjaxSemRetorno('ajax_com/composicao.php?acao=editar&id=<?=$_GET["id"]?>&idComposicao=<?=$composicao[$j]->getId()?>',1,'addPop');addPop_open(630);">
					<img border="0" src="layout/incones/edit.png"/>
				</a>
			</td>
			<td  width="4%" align="center"> 
				<a onclick="if(confirm('Deseja Excluir?')){ excluirComposicao(<?=$composicao[$j]->getId()?>, <?=$_GET["id"]?>);  }" href="#">
					<img border="0" src="layout/incones/button_cancel.png"/>
				</a>
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
		$composicao = $Main->Composicao->pegaComposicao($_GET["id"], "", $_GET["idComposicao"]);
	}
	$produtos = $Main->Pedidos->pegaProduto();
?>
<div style="border: 1px solid rgb(235, 240, 253);" id="SaidaPop">
	<form id="edit" name="edit" action="">
		<table cellspacing="5" cellpadding="0" border="1" align="left" width="100%">
			<tbody>
				<tr>
					<td align="left" width="40%">
						<h2>Adicionar</h2>
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
							for($j=0; $j<count($produtos); $j++){
								$selected = ($composicao[0] && $composicao[0]->getProdutoId() == $produtos[$j]->getId()) ? "selected" : "";
							?>					
							<option value="<?=$produtos[$j]->getId()?>" <?=$selected?>><?=$produtos[$j]->getCodigo()?> - <?=$produtos[$j]->getNome()?></option>
							<?
							}
							?>
						</select>
						
						<a onclick="javascript:window.open('buscapopup.php?campoatual=produto&amp;tabela=produtos', 'Busca', 'height = 300, width = 250, location = no, toolbar = no, menubar=no')" href="#"><img border="0" src="layout/incones/find.png"/></a> 
						<a onclick="javascript:window.open('addpopup.php?campoatual=produto&amp;tabela=produtos', 'Busca', 'height = 450, width = 550, location = no, toolbar = no')" href="#"><img border="0" src="layout/incones/add16.png"/></a>
					</td>
				</tr>
				<tr>
					<td align="right"><b>Quantidade:</b></td>
					<td align="left">
						<input type="text" name="qtd" id="qtd" class="form-control input-sm" size="5" onkeypress="mascaras.mascara(this,'soNumeros')" value="<? if($composicao[0]) print $composicao[0]->getQtd()?>" >
					</td>
				</tr>
				<tr>
					<td align="right"><b>Descrição:</b></td>
					<td align="left">
						<input type="text" name="descricao" class="form-control input-sm" id="descricao"  value="<? if($composicao[0]) print $composicao[0]->getDescricao()?>">
					</td>
				</tr>
				
				<tr>
					<td align="center" colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" colspan="3">
						<div class="btn-group" role="group" aria-label="...">
							<input class="btn btn-success btn-sm"  type="button" onclick="salvaComposicao()" value="Salvar" /> 
							<input class="btn btn-danger btn-sm" type="button" onclick="addPop_close();" value="Cancelar"/>
						</div>
						
						<input type="hidden" name="id" id="id" value="<?=$_GET["id"]?>"/>
                        <input type="hidden" name="idComposicao" id="idComposicao" value="<?=$_GET["idComposicao"]?>"/>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
	<script>
	document.onkeypress = function (evt){
		if(main.procuraTecla(evt,13)){
			if(confirm('Deseja salvar?')){ salvaComposicao(); } 
		}
	}
	</script>
</div>
<? 
}
?>