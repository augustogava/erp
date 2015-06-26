<?
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

if($_GET["acao"] == "listar"){
	$composicao = $Main->Composicao->pegaComposicao($_GET["id"], $_GET["itensBusca"], "", $_GET["limite"]);
	if(empty($_GET["limite"]) || $_GET["limite"] < 0)
		$limite = "0";
	
	
?>
<table width="100%" cellspacing="0" cellpadding="0" border="1" id="tabletest" class="table-erp">
	<tbody>
		<tr class="titulo">
			<td width="100%" class="ColunaInfo" colspan="4">Exibindo de <?=$limite?> a <?=($limite+15)?></td>
		</tr>
		<tr class="titulo">
			<td width="60%">Produto</td>
			<td width="30%" >Qtd</td>
			<td width="10%" align="right">
				<a title="Anterior" href="javascript:doAjaxSemRetorno('ajax_com/composicao.php?acao=listar&id=<?=$_GET["id"]?>itensBusca=<?=$_GET["itensBusca"]?>&limite=<?=($limite-15)?>',1,'Saida');">
					<span class="glyphicon fa fa-arrow-circle-left" aria-hidden="true"></span>
				</a>
				
				<a title="Próximo" href="javascript:doAjaxSemRetorno('ajax_com/composicao.php?acao=listar&id=<?=$_GET["id"]?>itensBusca=<?=$_GET["itensBusca"]?>&limite=<?=($limite+15)?>',1,'Saida');">
					<span class="glyphicon fa fa-arrow-circle-right" aria-hidden="true"></span>
				</a>
			</td>
		</tr>
		<?
			for($j=0; $j<count($composicao); $j++){
				if(($j%2) == 0){
					$linha = "linha";
				}else{
					$linha = "linhaMu";
				}
		?>
		<tr id="linhaDataGrid_<?=$j?>" class="<?=$linha?>" width="60%">
			<td  id="linhaDataGrid_<?=$j?>_0">
				<?=$composicao[$j]->getProdutoNome()?>
			</td>
			<td id="linhaDataGrid_<?=$j?>_1"/>
				<?=$composicao[$j]->getQtd()?>
			</td>
			<td align="right"> 
				<a title="Editar" href="javascript:doAjaxSemRetorno('ajax_com/composicao.php?acao=editar&id=<?=$_GET["id"]?>&idComposicao=<?=$composicao[$j]->getId()?>',1,'addPop');addPop_open(630);">
					<span class="glyphicon fa fa-edit" aria-hidden="true"></span>
				</a>

				<a title="Excluir" onclick="verifyPnotifyConfirm( 'Deseja excluir?', 'excluirComposicao(<?=$composicao[$j]->getId()?>, <?=$_GET["id"]?>)' );" href="#">
					<span class="glyphicon fa fa-trash" aria-hidden="true"></span>
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
				<tr style="border-bottom: 1px solid #ddd; height: 30px;">
					<td align="left" width="30%" style="padding-bottom: 5px;">
						<h2>Adicionar</h2>
					</td>
					<td align="right" width="70%" style="padding-bottom: 5px;">
						<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="addPop_close();">
						  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Fechar
						</button>
					</td>
				</tr>
				<tr>
					<td align="center" style="color: red;" id="erro" colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td align="right"><b>Produto:</b></td>
					<td align="left" class="form-inline">
						<select id="produto" name="produto" title="Produto" class="erroForm form-control input-xs">
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
						<input type="text" name="qtd" id="qtd" class="form-control input-xs" size="5" onkeypress="mascaras.mascara(this,'soNumeros')" value="<? if($composicao[0]) print $composicao[0]->getQtd()?>" >
					</td>
				</tr>
				<tr>
					<td align="right"><b>Descrição:</b></td>
					<td align="left">
						<input type="text" name="descricao" class="form-control input-xs" id="descricao"  value="<? if($composicao[0]) print $composicao[0]->getDescricao()?>">
					</td>
				</tr>
				
				<tr>
					<td align="center" colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" colspan="3">
						<div class="btn-group" role="group" aria-label="...">
							<input class="btn btn-success btn-sm"  type="button" onclick="verifyPnotifyConfirm( 'Deseja salvar?', 'salvaComposicao()' );" value="Salvar" /> 
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
		}
	}
	</script>
</div>
<? 
}
?>