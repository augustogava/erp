<?
header("Content-Type: text/html;  charset=ISO-8859-1",true);
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

if($_GET["acao"] == "listar"){
	$estoque = $Main->Estoque->pegaEstoque($_GET["produto"], $_GET["tipo"], $_GET["dataIni"], $_GET["dataFim"], "", $_GET["limite"]);
	if(empty($_GET["limite"]) || $_GET["limite"] < 0)
		$limite = "0";
	
	
?>
<table width="100%" cellspacing="0" cellpadding="0" border="1" id="tabletest" class="table-erp">
	<tbody>
		<tr class="titulo">
			<td width="100%" class="ColunaInfo" colspan="5">Exibindo de <?=$limite?> a <?=($limite+15)?></td>
		</tr>
		<tr class="titulo">
			<td width="40%">Produto</td>
			<td width="5%" >Qtd</td>
			<td width="5%" >Tipo</td>
			<td width="5%" >Data</td>
			<td width="30%" align="right">
				<a title="Anterior" href="javascript:doAjaxSemRetorno('ajax_com/estoque.php?acao=listar&produto=<?=$_GET["produto"]?>&tipo=<?=$_GET["tipo"]?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&limite=<?=($limite-15)?>',1,'Saida');">
					<span class="glyphicon fa fa-arrow-circle-left" aria-hidden="true"></span>
				</a>
				
				<a title="Próximo" href="javascript:doAjaxSemRetorno('ajax_com/estoque.php?acao=listar&produto=<?=$_GET["produto"]?>&tipo=<?=$_GET["tipo"]?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&limite=<?=($limite+15)?>',1,'Saida');">
					<span class="glyphicon fa fa-arrow-circle-right" aria-hidden="true"></span>
				</a>
					
			</td>
		</tr>
		<?
			for($j=0; $j<count($estoque); $j++){
				if(($j%2) == 0){
					$linha = "linha";
				}else{
					$linha = "linhaMu";
				}
		?>
		<tr id="linhaDataGrid_<?=$j?>" class="<?=$linha?>" width="60%">
			<td id="linhaDataGrid_<?=$j?>_0">
				<?=$estoque[$j]->getProdutoNome()?>
			</td>
			<td id="linhaDataGrid_<?=$j?>_1"/>
				<?=$estoque[$j]->getQtd()?>
			</td>
			<td id="linhaDataGrid_<?=$j?>_1"/>
				<?=($estoque[$j]->getTipo()==1)?"Entrada":"Saí=ida";?>
			</td>
			<td  id="linhaDataGrid_<?=$j?>_1"/>
				<?=$estoque[$j]->getData()?>
			</td>
			<td  align="right"> 
				<a title="Editar" href="javascript:doAjaxSemRetorno('ajax_com/estoque.php?acao=editar&id=<?=$estoque[$j]->getId()?>',1,'addPop');addPop_open(550);">
					<span class="glyphicon fa fa-edit" aria-hidden="true"></span>
				</a>

				<a title="Excluir" onclick="if(confirm('Deseja Excluir?')){ excluirEstoque(<?=$estoque[$j]->getId()?>);  }" href="#">
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
		$estoque = $Main->Estoque->pegaEstoque("", "", "","",$_GET["id"]);
	}
	$produtos = $Main->Pedidos->pegaProduto();
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
							for($j=0; $j<count($produtos); $j++){
								$selected = ($estoque[0] && $estoque[0]->getProdutoId() == $produtos[$j]->getId()) ? "selected" : "";
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
					<td align="right"><b>Tipo:</b></td>
					<td align="left" class="form-inline">
						<select id="tipo" name="tipo"  title="Tipo" class="erroForm form-control input-sm">
							<option value="">Selecione</option>
							<option value="1" <? if($estoque[0] && $estoque[0]->getTipo() == 1) print "selected"; ?>>Entrada</option>
							<option value="2" <? if($estoque[0] && $estoque[0]->getTipo() == 2) print "selected"; ?>>Saída</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td align="right"><b>Quantidade:</b></td>
					<td align="left">
						<input type="text" class="form-control input-sm" name="qtd" id="qtd" size="5" onkeypress="mascaras.mascara(this,'soNumeros')" value="<? if($estoque[0]) print $estoque[0]->getQtd()?>" >
					</td>
				</tr>
				<tr>
					<td align="right"><b>Valor:</b></td>
					<td align="left">
						<input type="text" class="form-control input-sm" name="preco" id="preco" size="10" onkeypress="mascaras.Formata(this,20,event,2)"  value="<? if($estoque[0]) print $estoque[0]->getPreco()?>">
					</td>
				</tr>
				<tr>
					<td align="right"><b>Descrição:</b></td>
					<td align="left">
						<input type="text" class="form-control input-sm" name="descricao" id="descricao"  value="<? if($estoque[0]) print $estoque[0]->getDescricao()?>">
					</td>
				</tr>
				<tr>
					<td align="right"><b>Data:</b></td>
					<td align="left">
						<input type="text" class="form-control input-sm" name="data" id="data" size="11" onkeypress="mascaras.mascara(this,'data')"  value="<? if($estoque[0]) print $estoque[0]->getData()?>">
					</td>
				</tr>
				
				<tr>
					<td align="center" colspan="3"></td>
				</tr>
				<tr>
					<td align="center" colspan="3">
						<div class="btn-group" role="group" aria-label="...">
							<input class="btn btn-success btn-sm " type="button" onclick="salvaEstoque(<?=$_GET["id"]?>)" value="Salvar" /> 
							<input class="btn btn-danger btn-sm" type="button" onclick="addPop_close();" value="Cancelar"/>
						</div>
						
						<input type="hidden" name="id" id="id" value="<?=$_GET["id"]?>"/>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
	<script>
	document.onkeypress = function (evt){
		if(main.procuraTecla(evt,13)){
			if(confirm('Deseja salvar?')){ salvaEstoque(<?=$_GET["id"]?>); } 
		}
	}
	</script>
</div>
<? 
}
?>