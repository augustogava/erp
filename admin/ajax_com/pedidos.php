<?
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

if($_GET["acao"] == "listar"){

	$pedidos = $Main->Pedidos->pegaPedidos($_GET["clientes"], $_GET["status"], "", $_GET["limite"], $_GET["dataIni"], $_GET["dataFim"], $_GET["codigo"], $_GET["ordem"], $_GET["tipoOrdem"], $_GET["dataEnvioIni"], $_GET["dataEnvioFim"]);

	if(empty($_GET["limite"]) || $_GET["limite"] < 0){
		$limite = "0";
	}else{
		$limite = $_GET["limite"]	;
	}

		

	if(!empty($_GET["tipoOrdem"]) && $_GET["tipoOrdem"] == "asc")

		$tipoOrdem = "desc";

	else

		$tipoOrdem = "asc";

?>

<table width="100%" cellspacing="0" cellpadding="0" border="1" id="tabletest" class="table-erp">

	<tbody>

		<tr class="titulo">

			<td width="96%" class="ColunaInfo" colspan="5">Exibindo de <?=$limite?> a <?=($limite+30)?></td>
			<td width="4%" align="right">
				<a href="#" onClick="main.openWindow('exportarPedidos.php?clientes=<?=$_GET["clientes"]?>&status=<?=$_GET["status"]?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&dataEnvioIni=<?=$_GET["dataEnvioIni"]?>&dataEnvioFim=<?=$_GET["dataEnvioFim"]?>&ordem=<?=$_GET["ordem"]?>&tipoOrdem=<?=$tipoOrdem?>', '300', '150')">
					<span class="glyphicon fa fa-print" style="font-size: 30px !important;" aria-hidden="true"></span>
				</a>
			</td>
		</tr>

		<tr class="titulo">

			<td width="7%" onclick="doAjaxSemRetorno('ajax_com/pedidos.php?acao=listar&clientes=<?=$_GET["clientes"]?>&status=<?=$_GET["status"]?>&limite=<?=($limite)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&dataEnvioIni=<?=$_GET["dataEnvioIni"]?>&dataEnvioFim=<?=$_GET["dataEnvioFim"]?>&ordem=pedidos.codigo&tipoOrdem=<?=$tipoOrdem?>',1,'SaidaMain');"><a href="#">Código</a></td>

			<td width="25%" onclick="doAjaxSemRetorno('ajax_com/pedidos.php?acao=listar&clientes=<?=$_GET["clientes"]?>&status=<?=$_GET["status"]?>&limite=<?=($limite)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&dataEnvioIni=<?=$_GET["dataEnvioIni"]?>&dataEnvioFim=<?=$_GET["dataEnvioFim"]?>&ordem=clientes.nome&tipoOrdem=<?=$tipoOrdem?>',1,'SaidaMain');"><a href="#">Cliente</a></td>

			<td width="25%" onclick="doAjaxSemRetorno('ajax_com/pedidos.php?acao=listar&clientes=<?=$_GET["clientes"]?>&status=<?=$_GET["status"]?>&limite=<?=($limite)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&dataEnvioIni=<?=$_GET["dataEnvioIni"]?>&dataEnvioFim=<?=$_GET["dataEnvioFim"]?>&ordem=representantes.nome&tipoOrdem=<?=$tipoOrdem?>',1,'SaidaMain');"><a href="#">Representante</a></td>

			<td width="10%" onclick="doAjaxSemRetorno('ajax_com/pedidos.php?acao=listar&clientes=<?=$_GET["clientes"]?>&status=<?=$_GET["status"]?>&limite=<?=($limite)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&dataEnvioIni=<?=$_GET["dataEnvioIni"]?>&dataEnvioFim=<?=$_GET["dataEnvioFim"]?>&ordem=pedidos.data_cad&tipoOrdem=<?=$tipoOrdem?>',1,'SaidaMain');"><a href="#">Data</a></td>

			<td width="10%" onclick="doAjaxSemRetorno('ajax_com/pedidos.php?acao=listar&clientes=<?=$_GET["clientes"]?>&status=<?=$_GET["status"]?>&limite=<?=($limite)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&dataEnvioIni=<?=$_GET["dataEnvioIni"]?>&dataEnvioFim=<?=$_GET["dataEnvioFim"]?>&ordem=status_pedidos.nome&tipoOrdem=<?=$tipoOrdem?>',1,'SaidaMain');" ><a href="#">Status</a></td>

			<td width="15%" align="right">

				 <a title="Anterior" href="javascript:doAjaxSemRetorno('ajax_com/pedidos.php?acao=listar&clientes=<?=$_GET["clientes"]?>&status=<?=$_GET["status"]?>&limite=<?=($limite-30)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&dataEnvioIni=<?=$_GET["dataEnvioIni"]?>&dataEnvioFim=<?=$_GET["dataEnvioFim"]?>&ordem=<?=$_GET["ordem"]?>&tipoOrdem=<?=$_GET["tipoOrdem"]?>',1,'SaidaMain');">
					<span class="glyphicon fa fa-arrow-circle-left" aria-hidden="true"></span>
				</a>

				<?
				if($Main->Pedidos->pegaQtditens($_GET["clientes"], $_GET["status"], $_GET["dataIni"], $_GET["dataFim"], $_GET["codigo"], $_GET["ordem"], $_GET["tipoOrdem"], $_GET["dataEnvioIni"], $_GET["dataEnvioFim"]) > ($limite+30) ){
				?>
                    <a title="Próximo" href="javascript:doAjaxSemRetorno('ajax_com/pedidos.php?acao=listar&clientes=<?=$_GET["clientes"]?>&status=<?=$_GET["status"]?>&limite=<?=($limite+30)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&dataEnvioIni=<?=$_GET["dataEnvioIni"]?>&dataEnvioFim=<?=$_GET["dataEnvioFim"]?>&ordem=<?=$_GET["ordem"]?>&tipoOrdem=<?=$_GET["tipoOrdem"]?>',1,'SaidaMain');">
						<span class="glyphicon fa fa-arrow-circle-right" aria-hidden="true"></span>
					</a>
                <? }else{ ?>
					 <span class="glyphicon fa fa-arrow-circle-right" aria-hidden="true"></span>
				 <? } ?>

			</td>

		</tr>

		<?

			for($j=0; $j<count($pedidos); $j++){

				if(($j%2) == 0){
					$linha = "linha";
				}else{
					$linha = "linhaMu";
				}

		?>

		<tr id="linhaDataGrid_<?=$j?>" class="<?=$linha?>" width="60%">

			<td  class="ColunaInfo">

				<?=$pedidos[$j]->getCodigo()?>

			</td>

			<td   id="linhaDataGrid_<?=$j?>_0">

				<?=$pedidos[$j]->getClienteNome()?>

			</td>

			<td id="linhaDataGrid_<?=$j?>_1"/>

				<?=($pedidos[$j]->getRepresentantesNome()) ? ($pedidos[$j]->getRepresentantesNome()) : "Sem Representante";?>

			</td>

			<td   id="linhaDataGrid_<?=$j?>_0">

				<?=$pedidos[$j]->getDataAberta()?>

			</td>

			<td  id="linhaDataGrid_<?=$j?>_1"/>

				<?=$pedidos[$j]->getStatusNome()?>

			</td>

			<td align="right"> 
				
				<?php 
				if( $pedidos[$j]->getStatusId() == 1 ){
				?>
				<a title="Fechar Pedido" href="javascript:verifyPnotifyConfirm( 'Deseja realmente enviar para separação?\nOperação não pode ser cancelada posteriormente!', 'fecharPedido(<?=$pedidos[$j]->getId()?>, <?=$pedidos[$j]->getStatusID()?>)' );">
					<span class="glyphicon fa fa-check-circle" aria-hidden="true"></span>
				</a>
				<?php } ?>

				<?php 
				if( $pedidos[$j]->getStatusId() == 6 ){
				?>
				<a title="Enviar Pedido" href="javascript:verifyPnotifyConfirm( 'Deseja realmente mudar status do pedido para enviado?\nOperação não pode ser cancelada posteriormente!', 'enviarPedido(<?=$pedidos[$j]->getId()?>, <?=$pedidos[$j]->getStatusID()?>)' );">
					<span class="glyphicon fa fa-truck" aria-hidden="true"></span>
				</a>
				<?php } ?>
				
				<a title="Imprimir" href="javascript:impressaoPedido(<?=$pedidos[$j]->getId()?>)">
					<span class="glyphicon fa fa-print" aria-hidden="true"></span>
				</a>

				<a title="Enviar E-mail" href="javascript:enviarEmailPedido(<?=$pedidos[$j]->getId()?>, <?=$pedidos[$j]->getClienteId()?>)">
					<span class="glyphicon fa fa-send" aria-hidden="true"></span>
				</a>

				<a title="Editar" href="javascript:doAjaxSemRetorno('ajax_com/pedidos.php?acao=editar&idPedido=<?=$pedidos[$j]->getId()?>',1,'addPop');addPop_open(630);">
					<span class="glyphicon fa fa-edit" aria-hidden="true"></span>
				</a>

				<a title="Excluir" onclick="verifyPnotifyConfirm( 'Deseja Excluir ?', 'excluirPedido(<?=$pedidos[$j]->getId()?>)' );" href="#">
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

	//Adiciona na tabela produtos para ter chave primãria para poder adicionar os itens

	if($_GET["acao"] == "adicionar"){

		$idPedido = $Main->Pedidos->adicionarPedido();

	}else if($_GET["acao"] == "editar"){

		$pedidos = $Main->Pedidos->pegaPedidos("", "", $_GET["idPedido"]);
		$idPedido = $_GET["idPedido"];
	}

	$clientes = $Main->Pedidos->pegaClientes();
	$status = $Main->Pedidos->pegaListaStatus();
	$formaPagamento = $Main->Pedidos->pegaFormaPagamento();
	$tipoentrega = $Main->Pedidos->pegaTipoEntrega();
	$representantes = $Main->Pedidos->pegaRepresentantes();

?>

<div style="border: 1px solid rgb(235, 240, 253);" id="Saida">

	<form id="edit" name="edit" action="">
		<table cellspacing="5" cellpadding="0" border="1" align="left" width="100%">
			<tbody>
				<tr style="border-bottom: 1px solid #ddd; height: 30px;">
					<td align="left" width="30%">
						<h2>Adicionar Cadastro</h2>
					</td>
					<td align="right" width="70%">
						<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="addPop_close();">
						  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Fechar
						</button>
					</td>
				</tr>
				<tr>
					<td align="center" style="color: red;" id="erro" colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td align="right"><b>Código:</b></td>
					<td align="left" id="td_id_menus" >
						<input class="form-control input-xs" onkeypress="return false;" type="text" name="codigo" id="codigo"  value="<?if($pedidos[0] && $pedidos[0]->getCodigo() ) print $pedidos[0]->getCodigo(); else print $Main->Pedidos->pegaCodigoNovo(); ?>"  />
					</td>
				</tr>
				<tr>
					<td align="right"><b>Cliente:</b></td>
					<td align="left" id="td_id_menus" class="form-inline">
						<select id="clientes" name="clientes" title="Clientes" class="erroForm form-control input-xs" onChange="pegaRepresentantePedido(this.value); pegaDadosClientePedido(this.value)">

							<option value="">Selecione</option>

							<?

							for($j=0; $j<count($clientes); $j++){

								$selected = ($pedidos[0] && $pedidos[0]->getClienteId() == $clientes[$j]->getId()) ? "selected" : "";

							?>					

							<option value="<?=$clientes[$j]->getId()?>" <?=$selected?>><?=$clientes[$j]->getNome()?></option>

							<?

							}

							?>

						</select> 

						

						<a onclick="javascript:abrirPopVisu('clientes', 'clientes')" href="#"><img border="0" src="layout/incones/visualizar.png"/></a>

						<a onclick="javascript:window.open('buscapopup.php?campoatual=clientes&amp;tabela=clientes', 'Busca', 'height = 300, width = 250, location = no, toolbar = no, menubar=no')" href="#"><img border="0" src="layout/incones/find.png"/></a> 

						<a onclick="javascript:window.open('addpopup.php?campoatual=clientes&amp;tabela=clientes', 'Busca', 'height = 400, width = 550, location = no, toolbar = no')" href="#"><img border="0" src="layout/incones/add16.png"/></a>
					</td>
				</tr>
				<tr>
					<td align="center" id="dadosClientes" colspan="2"></td>
				</tr>
				<tr>
					<td align="right"><b>Representante:</b></td>
					<td align="left" id="td_id_menus" class="form-inline">
						<select id="representantes" name="representantes" title="Representantes" class="form-control input-xs">
							<option value="">Selecione</option>

							<?

							for($j=0; $j<count($representantes); $j++){

								$selected = ($pedidos[0] && $pedidos[0]->getRepresentantesId() == $representantes[$j]->getId()) ? "selected" : "";

							?>					

							<option value="<?=$representantes[$j]->getId()?>" <?=$selected?>><?=$representantes[$j]->getNome()?></option>

							<?

							}

							?>

						</select> 
						<a onclick="javascript:abrirPopVisu('representantes', 'representantes')" href="#"><img border="0" src="layout/incones/visualizar.png"/></a>
						<a onclick="javascript:window.open('buscapopup.php?campoatual=representantes&amp;tabela=representantes', 'Busca', 'height = 300, width = 250, location = no, toolbar = no, menubar=no')" href="#"><img border="0" src="layout/incones/find.png"/></a> 
						<a onclick="javascript:window.open('addpopup.php?campoatual=representantes&amp;tabela=representantes', 'Busca', 'height = 400, width = 550, location = no, toolbar = no')" href="#"><img border="0" src="layout/incones/add16.png"/></a>
					</td>
				</tr>
				<tr>
					<td align="right" style="font-family: Lucida Grande,Verdana,sans-serif; font-size: 11px; color: rgb(56, 61, 68);">
						<b>Forma Pagamento:</b>
					</td>

					<td align="left" class="form-inline">

						<select id="formapagamento" name="formapagamento" title="formapagamento" class="erroForm form-control input-xs">

							<option value="">Selecione</option>

							<?

							for($j=0; $j<count($formaPagamento); $j++){

								$selected = ($pedidos[0] && $pedidos[0]->getFormaPagamento() == $formaPagamento[$j]->getId()) ? "selected" : "";

							?>					

							<option value="<?=$formaPagamento[$j]->getId()?>" <?=$selected?>><?=$formaPagamento[$j]->getNome()?></option>

							<?

							}

							?>

						</select>

					</td>
				</tr>
				<tr>
					<td align="right" style="font-family: Lucida Grande,Verdana,sans-serif; font-size: 11px; color: rgb(56, 61, 68);">
						<b>Obs:</b>
					</td>
					<td align="left">
						<input class="form-control input-xs" type="text" name="obs" id="obs"  value="<?if($pedidos[0] && $pedidos[0]->getObs() ) print $pedidos[0]->getObs(); ?>"  />
					</td>
				</tr>
				<tr>
					<td align="right" style="font-family: Lucida Grande,Verdana,sans-serif; font-size: 11px; color: rgb(56, 61, 68);">
						<b>Tipo Entrega:</b>
					</td>
					<td align="left" class="form-inline">
						<select id="tipoentrega" name="tipoentrega" title="tipoentrega" class="form-control input-xs">

							<option value="">Selecione</option>

							<?

							for($j=0; $j<count($tipoentrega); $j++){

								$selected = ($pedidos[0] && $pedidos[0]->getTipoEntregaId() == $tipoentrega[$j]->getId()) ? "selected" : "";

							?>					

							<option value="<?=$tipoentrega[$j]->getId()?>" <?=$selected?>><?=$tipoentrega[$j]->getNome()?></option>

							<?

							}

							?>

						</select>

					</td>

				</tr>
                
                <tr>

					<td align="right" style="font-family: Lucida Grande,Verdana,sans-serif; font-size: 11px; color: rgb(56, 61, 68);">

						<b>Valor Entrega:</b>

					</td>

					<td align="left">

						<input class="form-control input-xs" type="text" name="valorEntrega" id="valorEntrega" onkeypress="mascaras.Formata(this,20,event,2);"  value="<?if($pedidos[0] && $pedidos[0]->getValorEntrega() ) print $pedidos[0]->getValorEntrega(); ?>"  />

					</td>

				</tr>

				<tr>

					<td align="right" style="font-family: Lucida Grande,Verdana,sans-serif; font-size: 11px; color: rgb(56, 61, 68);">

						<b>Imposto:</b>

					</td>

					<td align="left">

						<input class="form-control input-xs" type="text" name="imposto" id="imposto" onkeypress="mascaras.Formata(this,20,event,2);"  value="<?if($pedidos[0] && $pedidos[0]->getImposto() ) print $pedidos[0]->getImposto(); ?>"  />

					</td>

				</tr>
				<tr>

					<td align="right" style="font-family: Lucida Grande,Verdana,sans-serif; font-size: 11px; color: rgb(56, 61, 68);">

						<b>Data Imposto:</b>

					</td>

					<td align="left">

						<input class="form-control input-xs" type="text" name="dataimposto" id="dataimposto" size="11" onkeypress="mascaras.mascara(this,'data')"  value="<?if($pedidos[0] && $pedidos[0]->getDataImposto() ) print $pedidos[0]->getDataImposto(); ?>"  />

					</td>

				</tr>

                                <tr>

					<td align="right" style="font-family: Lucida Grande,Verdana,sans-serif; font-size: 11px; color: rgb(56, 61, 68);">

						<b>Comissão:</b>

					</td>

					<td align="left" class="form-inline">

						<input class="form-control input-xs fourdigits" type="text" name="comissao" id="comissao" onkeypress="mascaras.Formata(this,20,event,2);"  value="<?if($pedidos[0] && $pedidos[0]->getComissao() ) print $pedidos[0]->getComissao(); ?>"  /> %

					</td>

				</tr>

				<tr>

					<td align="right" style="font-family: Lucida Grande,Verdana,sans-serif; font-size: 11px; color: rgb(56, 61, 68);">

						<b>Status:</b>

					</td>

					<td align="left">

						<select id="status" name="status" title="Status" class="form-control input-xs" >

							<option value="">Selecione</option>

							<?

							for($j=0; $j<count($status); $j++){



								$selected = (($pedidos[0] && $pedidos[0]->getStatusId() == $status[$j]->getId()) || (!$pedidos[0] && $status[$j]->getId() == 1)) ? "selected" : "";

							?>					

							<option value="<?=$status[$j]->getId()?>" <?=$selected?>><?=$status[$j]->getNome()?></option>

							<?

							}

							?>

						</select>

					</td>

				</tr>

				<tr>

					<td align="left" style="font-family: Lucida Grande,Verdana,sans-serif; font-size: 11px; color: rgb(56, 61, 68);" colspan="2">

						<table width="100%" cellspacing="0" cellpadding="0" border="1" id="bodyID" class="table-erp">

						</table>

					</td>

				</tr>

				<tr>

					<td align="center" colspan="3">&nbsp;</td>

				</tr>

				<tr>

					<td align="center" colspan="3">

						<div class="btn-group" role="group" aria-label="...">
							<button class="btn btn-success btn-sm " type="button" onclick="verifyPnotifyConfirm( 'Deseja Salvar ?', 'salvaPedido(<?=$idPedido?>, <?= ($pedidos[0] && $pedidos[0]->getStatusId()) ? $pedidos[0]->getStatusId() : 0 ?>)' );" >
								<span class="glyphicon fa fa-save" aria-hidden="true"></span> Salvar
							</button> 
							
							<input class="btn btn-danger btn-sm" type="button" onclick="addPop_close();" value="Cancelar"/>
						</div>

					</td>

				</tr>

			</tbody>

		</table>

	</form>

	<script>

	doAjaxSemRetorno('ajax_com/pedidos.php?acao=listarItens&idPedido=<?=$idPedido?>',1,'bodyID');
	setTimeout(function(){
						var campos = new Array('dataimposto');
						mCal = new dhtmlxCalendarObject(campos);
						mCal.setDateFormat("%d/%m/%Y");
					}, 1000);
	
	document.onkeypress = function (evt){

		if(main.procuraTecla(evt,13)){
			verifyPnotifyConfirm( 'Deseja Salvar ?', 'salvaPedido(<?=$idPedido?>, <?= ($pedidos[0] && $pedidos[0]->getStatusId()) ? $pedidos[0]->getStatusId() : 0 ?>)' );
		}

	}

	</script>
</div>
<? 
}else if($_GET["acao"] == "listarItens"){
	$dadosPedido = $Main->Pedidos->pegaPedidos("", "", $_GET["idPedido"]);
	$itens = $Main->Pedidos->pegaItensPedido($_GET["idPedido"]);

	$produtos = $Main->Pedidos->pegaProduto();
	$idPedido = $_GET["idPedido"];
?>
	<? if($pedidos[0] && $pedidos[0]->getClienteId()){ ?>
		pegaDadosClientePedido(<?=$pedidos[0]->getClienteId()?>);
	<? } ?>
	<tr class="titulo">

		<td width="10%"  style="text-align:left;">Qtd</td>

		<td width="70"  style="text-align:left;">Produto</td>

		<td width="10%"  style="text-align:left;">Valor</td>
		<td width="10%"  style="text-align:left;">Valor Especial</td>

		<td width="2%"  style="text-align:left;">Total</td>

		<td width="2%"  style="text-align:left;">&nbsp;</td>

		<td width="2%"  style="text-align:left;">&nbsp;</td>	

	</tr>
	<?
	for($i=0; $i<count($itens); $i++){
		$produtoItem = $itens[$i]->getProdutos();

		$qtdTotal += $itens[$i]->getQtd();
		$precoTotal += $itens[$i]->getTotal() + $itens[$i]->getTotalEspecial();
		if(($i%2) == 0){
			$linha = "linha";
		}else{
			$linha = "linhaMu";
		}
	?>
	<tr class="<?=$linha?>">
		<td  style="text-align:left;">
			<input class="form-control input-xs twodigits" type="text" size="2" id="qtd<?=$i?>" name="qtd[<?=$itens[$i]->getId()?>]" value="<?=$itens[$i]->getQtd()?>" title="qtd" onChange="salvaCampo(this.title, this.value, <?=$itens[$i]->getId()?>, <?=$i?>);calculaPrecoPedido();">
		</td>

		<td   style="text-align:left;">
			<select class="form-control input-xs fullsize" id="produto<?=$i?>" name="produto[<?=$itens[$i]->getId()?>]" title="id_produtos" onChange="salvaCampo(this.title, this.value, <?=$itens[$i]->getId()?>, <?=$i?>);">
				<option value="0" selected>Selecione</option>
				<?
				for($j=0; $j<count($produtos); $j++){
					$select = (($produtoItem[0] && $produtoItem[0]->getId()) && ($produtoItem[0]->getId()  == $produtos[$j]->getId()) ) ? "selected" : "";
				?>					
				<option value="<?=$produtos[$j]->getId()?>" <?=$select?> ><?=$produtos[$j]->getCodigo()?> - <?=$produtos[$j]->getNome()?></option>
				<?
				}
				?>
			</select>
		</td>

		<td  style="text-align:left;" id="precosProduto_<?=$i?>">
			<input class="form-control input-xs fourdigits money" type="text" size="6" id="preco<?=$i?>" name="preco[<?=$itens[$i]->getId()?>]" value="<?=$Main->Formata->banco2valor($itens[$i]->getPreco())?>" title="preco" onChange="salvaCampo(this.title, this.value, <?=$itens[$i]->getId()?>, <?=$i?>);calculaPrecoPedido();">
		</td>
		
		<td  style="text-align:left;" id="precosProduto_<?=$i?>">
			<input class="form-control input-xs fourdigits money" type="text" size="6" id="precoEspecial<?=$i?>" name="precoEspecial[<?=$itens[$i]->getId()?>]" value="<?=$Main->Formata->banco2valor($itens[$i]->getPrecoEspecial())?>" title="preco_especial" onChange="salvaCampo(this.title, this.value, <?=$itens[$i]->getId()?>, <?=$i?>);calculaPrecoPedido();">
		</td>

		<td   style="text-align:left;" id ="campoTotal_<?=$i?>">
			<?=$itens[$i]->getTotal()+$itens[$i]->getTotalEspecial();?>
		</td>

		<td >
			<? if($i == count($itens)-1){ ?>
			<a title="Excluir" onclick="adicionarItemPedido(<?=$idPedido?>, <?=$i-1?>)" href="#">
				<span class="glyphicon fa fa-plus" aria-hidden="true"></span>
			</a>
			<? } ?>
		</td>

		<td  >
			<a title="Excluir" onclick="verifyPnotifyConfirm( 'Deseja deletar item do pedido?', 'excluirItemPedido(<?=$itens[$i]->getId()?>, <?=$_GET["idPedido"]?>)' );" href="#">
				<span class="glyphicon fa fa-trash" aria-hidden="true"></span>
			</a>
		</td>
	</tr>
<?
	}
?>

	<tr class="titulo">
		<td  style="text-align:left;" id = "qtdTotalItens">
			<?=$qtdTotal?>
		</td>

		<td  style="text-align:left;">&nbsp;
			<input type="hidden" name="totalItens" id="totalItens" value="<?=count($itens)?>">
		</td>

		<td   style="text-align:left;" >&nbsp;
		</td>
<td   style="text-align:left;" >&nbsp;
		</td>
		<td  style="text-align:left;" id = "precoTotalItens">
			<?=$precoTotal?>
		</td>

		<td >&nbsp;
		</td>

		<td  >&nbsp;
		</td>
	</tr>
	
	<script>jQuery('.money').mask('000.000.000.000.000,00', {reverse: true}); /*$('.money2').mask("#.##0,00", {reverse: true});*/ </script>
<?

}else if($_GET["acao"] == "selecionaProduto"){

	$produtos = $Main->Pedidos->pegaProduto($_GET["idProduto"]);

	print_r($produtos);

	if($produtos){

		$codigo = $produtos[0]->getCodigo();

		$precos = "<select id=\"preco".$indice."\" name=\"preco[".$_GET["idItem"]."]\" title=\"preco\" onChange=\"salvaCampo(this.title, this.value, ".$_GET["idItem"].");calculaPrecoPedido(".$indice.")\">";
		$precos .= "<option value=\"0\" selected>Selecione</option> ";
		$precos .= "<option value=\"".$produtos[0]->getPreco1()."\">".$produtos[0]->getPreco1()."</option>";
		$precos .= "<option value=\"".$produtos[0]->getPreco2()."\">".$produtos[0]->getPreco2()."</option>";
		$precos .= "<option value=\"".$produtos[0]->getPreco3()."\">".$produtos[0]->getPreco3()."</option>";
		$precos .= "<option value=\"".$produtos[0]->getPreco4()."\">".$produtos[0]->getPreco4()."</option>";
		$precos .= "</select>";

?>
		<script>
			//$('precosProduto_<?=$_GET["indice"]?>').innerHTML = '<?=$precos?>';
		</script>
<? 

	}else{
		$precos = "<select id=\"preco".$indice."\" name=\"preco[".$_GET["idItem"]."]\" onChange=\"calculaPrecoPedido(".$indice.")\">";
		$precos .= "<option value=\"0\" selected>Selecione</option> ";
		$precos .= "</select>";
?>
		<script>
			//$('precosProduto_<?=$_GET["indice"]?>').innerHTML = '<?=$precos?>';
		</script>
<?
	}
} 
?>