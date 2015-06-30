<?
include "../includes/Main.class.php";

// chama a classe principal

$Main = new Main();

$Main->Seguranca->verificaLogado();

if($_GET["acao"] == "listarCotacao"){

	$compras = $Main->Compras->pegaCotacao("", $_GET["fornecedores"], $_GET["limite"], $_GET["dataIni"], $_GET["dataFim"], $_GET["codigo"], $_GET["ordem"], $_GET["tipoOrdem"]);
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
			<td width="96%" class="ColunaInfo" colspan="4">Exibindo de <?=$limite?> a <?=($limite+30)?></td>
			<td width="4%" align="right">
				<a href="#" onClick="main.openWindow('exportarCompras.php?fornecedores=<?=$_GET["fornecedores"]?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&tipoR=Cotaçãoo&ordem=<?=$_GET["ordem"]?>&tipoOrdem=<?=$tipoOrdem?>', '300', '150')">
					<span class="glyphicon fa fa-print" style="font-size: 30px !important;" aria-hidden="true"></span>
				</a>
		</tr>

		<tr class="titulo">

			<td width="10%" onclick="doAjaxSemRetorno('ajax_com/compras.php?acao=listarCotacao&fornecedores=<?=$_GET["fornecedores"]?>&limite=<?=($limite)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&ordem=compras.codigo&tipoOrdem=<?=$tipoOrdem?>',1,'SaidaMain');"><a href="#">Código</a></td>

			<td width="25%" onclick="doAjaxSemRetorno('ajax_com/compras.php?acao=listarCotacao&fornecedores=<?=$_GET["fornecedores"]?>&limite=<?=($limite)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&ordem=fornecedores.nome&tipoOrdem=<?=$tipoOrdem?>',1,'SaidaMain');"><a href="#">Fornecedores</a></td>

			<td width="20%" onclick="doAjaxSemRetorno('ajax_com/compras.php?acao=listarCotacao&fornecedores=<?=$_GET["fornecedores"]?>&limite=<?=($limite)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&ordem=compras.data&tipoOrdem=<?=$tipoOrdem?>',1,'SaidaMain');"><a href="#">Data</a></td>

			<td width="20%" onclick="doAjaxSemRetorno('ajax_com/compras.php?acao=listarCotacao&fornecedores=<?=$_GET["fornecedores"]?>&limite=<?=($limite)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&ordem=compras.status&tipoOrdem=<?=$tipoOrdem?>',1,'SaidaMain');" ><a href="#">Status</a></td>

			<td width="30%" align="right">

				<a href="javascript:doAjaxSemRetorno('ajax_com/compras.php?acao=listarCotacao&fornecedores=<?=$_GET["fornecedores"]?>&limite=<?=($limite)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&ordem=<?=$_GET["ordem"]?>&tipoOrdem=<?=$_GET["tipoOrdem"]?>&limite=<?=($limite-30)?>',1,'SaidaMain');" href="#">
					<span class="glyphicon fa fa-arrow-circle-left" aria-hidden="true"></span>
				</a>

                            <?


                            if($Main->Compras->pegaQtditensCotacao($_GET["fornecedores"], $_GET["dataIni"], $_GET["dataFim"], $_GET["codigo"], $_GET["ordem"], $_GET["tipoOrdem"]) > ($limite+30) ){
                            ?>
                                    <a href="javascript:doAjaxSemRetorno('ajax_com/compras.php?acao=listarCotacao&fornecedores=<?=$_GET["fornecedores"]?>&limite=<?=($limite)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&ordem=<?=$_GET["ordem"]?>&tipoOrdem=<?=$_GET["tipoOrdem"]?>&limite=<?=($limite+30)?>',1,'SaidaMain');" href="#">
										<span class="glyphicon fa fa-arrow-circle-right" aria-hidden="true"></span>
									</a>
                             <? }else{ ?>
                                     <span class="glyphicon fa fa-arrow-circle-right" aria-hidden="true"></span>
                             <? } ?>

			</td>

		</tr>

		<?

			for($j=0; $j<count($compras); $j++){
				if(($j%2) == 0){
					$linha = "linha";
				}else{
					$linha = "linhaMu";
				}
		?>

		<tr id="linhaDataGrid_<?=$j?>" class="<?=$linha?>" width="60%">

			<td class="ColunaInfo">

				<?=$compras[$j]->getCodigo()?>

			</td>

			<td id="linhaDataGrid_<?=$j?>_0">

				<?=$compras[$j]->getFornecedoresNome()?>

			</td>


			<td   id="linhaDataGrid_<?=$j?>_0">

				<?=$compras[$j]->getDataAberta()?>

			</td>

			<td id="linhaDataGrid_<?=$j?>_1"/>

				<?
                                if($compras[$j]->getStatus()==0){
                                    print "Aberto";
                                }else{
                                    print "Fechado";
                                }
                                ?>

			</td>

			<td  align="right"> 

				<?php 
				if( $compras[$j]->getStatus() == 0 ){
				?>
				<a title="Fechar" href="javascript:verifyPnotifyConfirm( 'Deseja realmente fechar cotacao e virar Compra? Operação não pode ser cancelada posteriormente!', 'virarCompra(<?=$compras[$j]->getId()?>)' );">
					<span class="glyphicon fa fa-check-circle" aria-hidden="true"></span>
				</a>
				<?php } ?>
				<a title="Imprimir" href="javascript:impressaoCompra(<?=$compras[$j]->getId()?>, 'Cotação')">
					<span class="glyphicon fa fa-print" aria-hidden="true"></span>
				</a>

				<a title="Editar" href="javascript:doAjaxSemRetorno('ajax_com/compras.php?acao=editar&idCompra=<?=$compras[$j]->getId()?>&local=cotacao',1,'addPop');addPop_open(630);">
					<span class="glyphicon fa fa-edit" aria-hidden="true"></span>
				</a>

				<a title="Excluir" onclick="verifyPnotifyConfirm( 'Deseja Excluir ?', 'excluirCompraCotacao(<?=$compras[$j]->getId()?>)' );" href="#">
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


}else if($_GET["acao"] == "listarCompras"){

	$compras = $Main->Compras->pegaCompra("", $_GET["fornecedores"], $_GET["limite"], $_GET["dataIni"], $_GET["dataFim"], $_GET["codigo"], $_GET["ordem"], $_GET["tipoOrdem"]);

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

			<td width="96%" class="ColunaInfo" colspan="4">Exibindo de <?=$limite?> a <?=($limite+30)?></td>
			<td width="4%" align="right">
				<a href="#" onClick="main.openWindow('exportarCompras.php?fornecedores=<?=$_GET["fornecedores"]?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&tipoR=Compra&ordem=<?=$_GET["ordem"]?>&tipoOrdem=<?=$tipoOrdem?>', '300', '150')">
					<span class="glyphicon fa fa-print" style="font-size: 30px !important;" aria-hidden="true"></span>
				</a>
		</tr>

		<tr class="titulo">

			<td width="10%" onclick="doAjaxSemRetorno('ajax_com/compras.php?acao=listarCompras&fornecedores=<?=$_GET["fornecedores"]?>&limite=<?=($limite)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&ordem=compras.codigo&tipoOrdem=<?=$tipoOrdem?>',1,'SaidaMain');"><a href="#">Código</a></td>

			<td width="25%" onclick="doAjaxSemRetorno('ajax_com/compras.php?acao=listarCompras&fornecedores=<?=$_GET["fornecedores"]?>&limite=<?=($limite)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&ordem=fornecedores.nome&tipoOrdem=<?=$tipoOrdem?>',1,'SaidaMain');"><a href="#">Fornecedores</a></td>

			<td width="25%" onclick="doAjaxSemRetorno('ajax_com/compras.php?acao=listarCompras&fornecedores=<?=$_GET["fornecedores"]?>&limite=<?=($limite)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&ordem=compras.data&tipoOrdem=<?=$tipoOrdem?>',1,'SaidaMain');"><a href="#">Data</a></td>

			<td width="25%" onclick="doAjaxSemRetorno('ajax_com/compras.php?acao=listarCompras&fornecedores=<?=$_GET["fornecedores"]?>&limite=<?=($limite)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&ordem=compras.status&tipoOrdem=<?=$tipoOrdem?>',1,'SaidaMain');" ><a href="#">Status</a></td>

			<td width="15%" align="right">
				
				<a title="Anterior" href="javascript:doAjaxSemRetorno('ajax_com/compras.php?acao=listarCompras&fornecedores=<?=$_GET["fornecedores"]?>&limite=<?=($limite)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&ordem=<?=$_GET["ordem"]?>&tipoOrdem=<?=$_GET["tipoOrdem"]?>&limite=<?=($limite-30)?>',1,'SaidaMain');" href="#">
					<span class="glyphicon fa fa-arrow-circle-left" aria-hidden="true"></span>
				</a>
				
                            <?
                            if($Main->Compras->pegaQtditensCompras($_GET["fornecedores"], $_GET["dataIni"], $_GET["dataFim"], $_GET["codigo"], $_GET["ordem"], $_GET["tipoOrdem"]) > ($limite+30) ){
                            ?>

								<a title="Próximo" href="javascript:doAjaxSemRetorno('ajax_com/compras.php?acao=listarCompras&fornecedores=<?=$_GET["fornecedores"]?>&limite=<?=($limite)?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&codigo=<?=$_GET["codigo"]?>&ordem=<?=$_GET["ordem"]?>&tipoOrdem=<?=$_GET["tipoOrdem"]?>&limite=<?=($limite+30)?>',1,'SaidaMain');">
									<span class="glyphicon fa fa-arrow-circle-right" aria-hidden="true"></span>
								</a>
                             <? }else{ ?>
                                     <span class="glyphicon fa fa-arrow-circle-right" aria-hidden="true"></span>
                             <? } ?>

			</td>

		</tr>

		<?

			for($j=0; $j<count($compras); $j++){
				if(($j%2) == 0){
					$linha = "linha";
				}else{
					$linha = "linhaMu";
				}
		?>
		<tr id="linhaDataGrid_<?=$j?>" class="<?=$linha?>" width="60%">
			<td class="ColunaInfo">
				<?=$compras[$j]->getCodigo()?>
			</td>
			<td id="linhaDataGrid_<?=$j?>_0">
				<?=$compras[$j]->getFornecedoresNome()?>
			</td>
			<td  id="linhaDataGrid_<?=$j?>_0">
				<?=$compras[$j]->getDataAberta()?>
			</td>
			<td id="linhaDataGrid_<?=$j?>_1"/>
				<?
                                if($compras[$j]->getStatus()==0){
                                    print "Aberto";
                                }else{
                                    print "Fechado";
                                }
                                ?>

			</td>

			<td  align="right"> 

				<?php 
				if( $compras[$j]->getStatus() == 0 ){
				?>
				<a title="Fechar" href="javascript:verifyPnotifyConfirm( 'Deseja realmente fechar compra? Operação não pode ser cancelada posteriormente!', 'fecharCompra(<?=$compras[$j]->getId()?>, <?=$compras[$j]->getStatus()?>)' );">
					<span class="glyphicon fa fa-check-circle" aria-hidden="true"></span>
				</a>
				<?php 
				} 
				?>
				<a title="Imprimir" href="javascript:impressaoCompra(<?=$compras[$j]->getId()?>, 'Compra')">
					<span class="glyphicon fa fa-print" aria-hidden="true"></span>
				</a>

				<a title="Editar" href="javascript:doAjaxSemRetorno('ajax_com/compras.php?acao=editar&idCompra=<?=$compras[$j]->getId()?>&local=compras',1,'addPop');addPop_open(630);">
					<span class="glyphicon fa fa-edit" aria-hidden="true"></span>
				</a>

				<a title="Excluir" onclick="verifyPnotifyConfirm( 'Deseja Excluir ?', 'excluirCompraCompra(<?=$compras[$j]->getId()?>)');" href="#">
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

	//Adiciona na tabela produtos para ter chave prim�ria para poder adicionar os itens

	if($_GET["acao"] == "adicionar"){
		if($_GET["local"] == "cotacao"){
			$idCompra = $Main->Compras->adicionarCotacao();
        }else{
              $idCompra = $Main->Compras->adicionarCompra();
        }
	}else if($_GET["acao"] == "editar"){
		$compra = $Main->Compras->pegaCompraEspecifico($_GET["idCompra"]);
		$idCompra = $_GET["idCompra"];
	}

	$fornecedores = $Main->Compras->pegaFornecedores();
	$tipoFluxo = $Main->Compras->pegaTipoFluxo();
?>
<div style="border: 1px solid rgb(235, 240, 253);" id="Saida">

	<form id="edit" name="edit" action="">

		<table cellspacing="5" cellpadding="0" border="1" align="left" width="100%">

			<tbody>

				<tr style="border-bottom: 1px solid #ddd; height: 30px;">

					<td align="left" width="30%" style="padding-bottom: 5px;">
						<h2>Adicionar Cadastro</h2>
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

					<td align="right"><b>Código:</b></td>

					<td align="left" id="td_id_menus">

						<input onkeypress="return false;" type="text" name="codigo" id="codigo"  value="<?if($compra[0] && $compra[0]->getCodigo() ) print $compra[0]->getCodigo(); else print $Main->Compras->pegaCodigoNovo(); ?>"  />

					</td>

				</tr>

				<tr>

					<td align="right"><b>Fornecedores:</b></td>

					<td align="left" id="td_id_menus" class="form-inline">
						<select id="fornecedores" name="fornecedores" title="fornecedores" class="erroForm form-control input-xs" >

							<option value="">Selecione</option>

							<?

							for($j=0; $j<count($fornecedores); $j++){

								$selected = ($compra[0] && $compra[0]->getFornecedoresId() == $fornecedores[$j]->getId()) ? "selected" : "";

							?>					

							<option value="<?=$fornecedores[$j]->getId()?>" <?=$selected?>><?=$fornecedores[$j]->getNome()?></option>

							<?

							}

							?>

						</select> 

						

						<a onclick="javascript:abrirPopVisu('fornecedores', 'fornecedores')" href="#"><img border="0" src="layout/incones/visualizar.png"/></a>

						<a onclick="javascript:window.open('buscapopup.php?campoatual=fornecedores&amp;tabela=fornecedores', 'Busca', 'height = 300, width = 250, location = no, toolbar = no, menubar=no')" href="#"><img border="0" src="layout/incones/find.png"/></a>

						<a onclick="javascript:window.open('addpopup.php?campoatual=fornecedores&amp;tabela=fornecedores', 'Busca', 'height = 400, width = 550, location = no, toolbar = no')" href="#"><img border="0" src="layout/incones/add16.png"/></a>

					</td>

				</tr>

                                <tr>

					<td align="right"><b>Tipo:</b></td>

					<td align="left" id="td_id_menus" class="form-inline">



						<select id="tipoFluxo" name="tipoFluxo" title="tipoFluxo" class="erroForm form-control input-xs" >

							<option value="">Selecione</option>

							<?

							for($j=0; $j<count($tipoFluxo); $j++){

								$selected = ($compra[0] && $compra[0]->getTipoFluxoId() == $tipoFluxo[$j]->getId()) ? "selected" : "";

							?>

							<option value="<?=$tipoFluxo[$j]->getId()?>" <?=$selected?>><?=$tipoFluxo[$j]->getNome()?></option>

							<?

							}

							?>

						</select>



						<a onclick="javascript:abrirPopVisu('tipoFluxo', 'tipoFluxo')" href="#"><img border="0" src="layout/incones/visualizar.png"/></a>

						<a onclick="javascript:window.open('buscapopup.php?campoatual=tipoFluxo&amp;tabela=tipo_fluxo', 'Busca', 'height = 300, width = 250, location = no, toolbar = no, menubar=no')" href="#"><img border="0" src="layout/incones/find.png"/></a>

						<a onclick="javascript:window.open('addpopup.php?campoatual=tipoFluxo&amp;tabela=tipo_fluxo', 'Busca', 'height = 400, width = 550, location = no, toolbar = no')" href="#"><img border="0" src="layout/incones/add16.png"/></a>

					</td>

				</tr>

				<tr>

					<td align="right" style="font-family: Lucida Grande,Verdana,sans-serif; font-size: 11px; color: rgb(56, 61, 68);">

						<b>Obs:</b>

					</td>

					<td align="left">
						<input type="text" name="obs" id="obs" class="form-control input-xs" value="<?if($compra[0] && $compra[0]->getObs() ) print $compra[0]->getObs(); ?>"  />
					</td>
				</tr>
				<tr>
					<td align="right" style="font-family: Lucida Grande,Verdana,sans-serif; font-size: 11px; color: rgb(56, 61, 68);">
						<b>Imposto:</b>
					</td>
					<td align="left">
						<input type="text" name="imposto" id="imposto" class="form-control input-xs" onkeypress="mascaras.Formata(this,20,event,2);"  value="<?if($compra[0] && $compra[0]->getImposto() ) print $compra[0]->getImposto(); ?>"  />
					</td>
				</tr>
                <tr>
					<td align="right" style="font-family: Lucida Grande,Verdana,sans-serif; font-size: 11px; color: rgb(56, 61, 68);">
						<b>Desconto:</b>
					</td>

					<td align="left">
                    	<input type="text" name="desconto" id="desconto" class="form-control input-xs" onkeypress="mascaras.Formata(this,20,event,2);"  value="<?if($compra[0] && $compra[0]->getDesconto() ) print $compra[0]->getDesconto(); ?>"  />
					</td>
				</tr>
				<tr>
					<td align="left" style="font-family: Lucida Grande,Verdana,sans-serif; font-size: 11px; color: rgb(56, 61, 68);" colspan="2">

						<table width="100%" cellspacing="0" cellpadding="0" border="1" id="bodyID">

						</table>
					</td>
				</tr>

				<tr>
					<td align="center" colspan="3"></td>
				</tr>
                <tr>

					<td align="left" style="font-family: Lucida Grande,Verdana,sans-serif; font-size: 11px; color: rgb(56, 61, 68);" colspan="2">

						<table width="100%" cellspacing="0" cellpadding="0" border="1" id="bodyForma">

						</table>

					</td>

				</tr>

				<tr>

					<td align="center" colspan="3">
						<div class="btn-group" role="group" aria-label="...">
							<?php 
							if( $compra[0] == null ||  $compra[0]->getStatus() == 0 ){
							?>
							<button class="btn btn-success btn-sm " type="button" onclick="salvaCompra(<?=$idCompra?>, <?= ($compra[0] && $compra[0]->getStatus()) ? $compra[0]->getStatus() : 0 ?>, '<?=$_GET["local"]?>')" value="Salvar">
								<span class="glyphicon fa fa-save" aria-hidden="true"></span> Salvar
							</button>
							<?php } ?>
							<input class="btn btn-danger btn-sm" type="button" onclick="addPop_close();" value="Cancelar"/>
						</div>
					</td>

				</tr>

			</tbody>

		</table>

	</form>

	<script>

	doAjaxSemRetorno('ajax_com/compras.php?acao=listarItens&idCompra=<?=$idCompra?>',1,'bodyID');


	<?php 
	if( $compra[0] == null ||  $compra[0]->getStatus() == 0 ){
	?>
	document.onkeypress = function (evt){

		if(main.procuraTecla(evt,13)){


		}

	}
	<?php } ?>

	</script>
 </div>

<? 

}else if($_GET["acao"] == "listarItens"){

	$dadosCompra = $Main->Compras->pegaCompraEspecifico($_GET["idCompra"]);

	$itens = $Main->Compras->pegaItensCompra($_GET["idCompra"]);

	//print_r($itens);

	$produtos = $Main->Compras->pegaProduto();

?>

	<tr class="titulo">

		<td width="7%" class="ColunaInfo" style="text-align:left;">Qtd</td>

		<td width="65%" class="ColunaInfo" style="text-align:left;">Produto</td>

		<td width="10%" class="ColunaInfo" style="text-align:left;">Valor</td>

		<td width="10%" class="ColunaInfo" style="text-align:left;">Total</td>

		<td width="5%" class="ColunaInfo" style="text-align:left;">&nbsp;</td>

		<td width="5%" class="ColunaInfo" style="text-align:left;">&nbsp;</td>	

	</tr>

	<?

	for($i=0; $i<count($itens); $i++){

		$produtoItem = $itens[$i]->getProdutos();

		if($produtoItem[0]){

			

			$codigo = $produtoItem[0]->getCodigo();

			

			$precos = "<select id=\"preco".$i."\" name=\"preco[".$itens[$i]->getId()."]\" title=\"preco\" onChange=\"salvaCampoCompra(this.title, this.value, ".$itens[$i]->getId().");calculaPrecoCompra(".$i.")\">";

			$precos .= "<option value=\"0\" selected>Selecione</option> ";

			

			$sel = "";

			if($produtoItem[0]->getPreco1() == $itens[$i]->getPreco())

				$sel = "selected";

				

			$precos .= "<option value=\"".$produtoItem[0]->getPreco1()."\" ".$sel.">".$produtoItem[0]->getPreco1()."</option>";

			

			$sel = "";

			if($produtoItem[0]->getPreco2() == $itens[$i]->getPreco())

				$sel = "selected";

				

			$precos .= "<option value=\"".$produtoItem[0]->getPreco2()."\" ".$sel.">".$produtoItem[0]->getPreco2()."</option>";

			

			$sel = "";

			if($produtoItem[0]->getPreco3() == $itens[$i]->getPreco())

				$sel = "selected";

				

			$precos .= "<option value=\"".$produtoItem[0]->getPreco3()."\" ".$sel.">".$produtoItem[0]->getPreco3()."</option>";

		

			$sel = "";

			if($produtoItem[0]->getPreco4() == $itens[$i]->getPreco())

				$sel = "selected";

				

			$precos .= "<option value=\"".$produtoItem[0]->getPreco4()."\" ".$sel.">".$produtoItem[0]->getPreco4()."</option>";

			$precos .= "</select>";

		}else{

			$codigo = "";

			$precos = "<select id=\"preco".$i."\" name=\"preco[".$itens[$i]->getId()."]\" title=\"preco\" onChange=\"salvaCampoCompra(this.title, this.value, ".$itens[$i]->getId().");calculaPrecoCompra(".$i.")\">";

			$precos .= "<option value=\"0\" selected>Selecione</option> ";

			$precos .= "</select>";

		}

		

		$qtdTotal += $itens[$i]->getQtd();

		$precoTotal += $itens[$i]->getTotal();

		if(($i%2) == 0){
			$linha = "linha";
		}else{
			$linha = "linhaMu";
		}

	?>

	<tr class="<?=$linha?>">

		<td class="ColunaInfo" style="text-align:left;">

			<input type="text" class="form-control input-xs twodigits" size="2" id="qtd<?=$i?>" name="qtd[<?=$itens[$i]->getId()?>]" value="<?=$itens[$i]->getQtd()?>" title="qtd" onChange="salvaCampoCompra(this.title, this.value, <?=$itens[$i]->getId()?>, <?=$i?>);calculaPrecoCompra();">

		</td>

		<td  class="ColunaInfo" style="text-align:left;">

			<select class="form-control input-xs fullsize" id="produto<?=$i?>" name="produto[<?=$itens[$i]->getId()?>]" title="id_produtos" onChange="salvaCampoCompra(this.title, this.value, <?=$itens[$i]->getId()?>, <?=$i?>);">
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


		<td class="ColunaInfo" style="text-align:left;" id="precosProduto_<?=$i?>">

			<input type="text" class="form-control input-xs fourdigits" size="6" id="preco<?=$i?>" name="preco[<?=$itens[$i]->getId()?>]" value="<?=$Main->Formata->banco2valor($itens[$i]->getPreco())?>" title="preco" onkeypress="mascaras.Formata(this,20,event,2);" onChange="salvaCampoCompra(this.title, this.value, <?=$itens[$i]->getId()?>, <?=$i?>);calculaPrecoCompra();">

		</td>

		<td class="ColunaInfo" style="text-align:left;" id ="campoTotal_<?=$i?>">

			<?=$itens[$i]->getTotal();?>

		</td>

		<td class="ColunaInfo">

			&nbsp;<? if($i == count($itens)-1){ ?><a onclick="javascript:adicionarItemCompra(<?=$_GET["idCompra"]?>, <?=$i-1?>)" href="#"><img src="layout/incones/add16.png" border="0" alt="Adicioar Item" title="Adicionar Item"></a><? } ?>

		</td>

		<td class="ColunaInfo">

			<a href="javascript:verifyPnotifyConfirm( 'Deseja Excluir ?', 'excluirItemCompra(<?=$itens[$i]->getId()?>, <?=$_GET["idCompra"]?>)');"><img src="layout/incones/button_cancel.png" border="0" style="width: 14px;"></a>

		</td>

	</tr>

<?

	}

?>

	<tr class="linha">

		<td  class="ColunaInfo" style="text-align:left;" id = "qtdTotalItens">
			<?=$qtdTotal?>

		</td>
		<td class="ColunaInfo" style="text-align:left;">&nbsp;
			<input type="hidden" name="totalItens" id="totalItens" value="<?=count($itens)?>">
		</td>
		<td class="ColunaInfo" style="text-align:left;">&nbsp;

		</td>
		<td  class="ColunaInfo" style="text-align:left;" >&nbsp;
		</td>
		<td  class="ColunaInfo" style="text-align:left;" id = "precoTotalItens">
			<?=$precoTotal-$Main->Formata->valor2banco($dadosCompra[0]->getDesconto())+$Main->Formata->valor2banco($dadosCompra[0]->getImposto())?>
		</td>
		<td  class="ColunaInfo">&nbsp;
		</td>
		<td  class="ColunaInfo">&nbsp;
		</td>
	</tr>

        <script>
            doAjaxSemRetorno('ajax_com/compras.php?acao=listarForma&idCompra=<?=$_GET["idCompra"]?>',1,'bodyForma');
        </script>

<?
}else if($_GET["acao"] == "listarForma"){

	$dadosCompra = $Main->Compras->pegaCompraEspecifico($_GET["idCompra"]);
        $formasPagto = $Main->Compras->pegaCompraFormaPagamento($_GET["idCompra"]);

?>
    <tr class="linha">

		<td width="7%" class="ColunaInfo" style="text-align:left;" colspan="4">Forma Pagamento</td>


	</tr>
    <tr class="titulo">

		<td width="7%" class="ColunaInfo" style="text-align:left;">Valor</td>

		<td width="87%" class="ColunaInfo" style="text-align:left;">Data</td>

		<td width="5%" class="ColunaInfo" style="text-align:left;">&nbsp;</td>

		<td width="5%" class="ColunaInfo" style="text-align:left;">&nbsp;</td>

	</tr>

	<?

	for($i=0; $i<count($formasPagto); $i++){

            $precoTotal += $formasPagto[$i]->getValor();
            if(($i%2) == 0){
            	$linha = "linha";
            }else{
            	$linha = "linhaMu";
            }
        ?>
     	<tr class="<?=$linha?>">

	         <td class="ColunaInfo" style="text-align:left;" id="precosProduto_<?=$i?>">
				<input type="text"  class="form-control input-xs twodigits" size="6" id="valor<?=$i?>" name="valor[<?=$formasPagto[$i]->getId()?>]" value="<?=$Main->Formata->banco2valor($formasPagto[$i]->getValor())?>" title="valor" onkeypress="mascaras.Formata(this,20,event,2);" onChange="salvaCampoCompraFormaPgto(this.title, this.value, <?=$formasPagto[$i]->getId()?>, <?=$i?>);calculaPrecoCompraFormaPgto();">
			</td>
	       	<td  class="ColunaInfo" style="text-align:left;">
				<input type="text"  class="form-control input-xs" size="12" id="data<?=$i?>" name="data[<?=$formasPagto[$i]->getId()?>]" value="<?=$Main->Formata->banco2date($formasPagto[$i]->getData())?>"  title="data" onkeypress="mascaras.mascara(this,'data')" onChange="salvaCampoCompraFormaPgto(this.title, this.value, <?=$formasPagto[$i]->getId()?>, <?=$i?>);">
	
			</td>
	
	        <td  class="ColunaInfo">
				&nbsp;<? if($i == count($formasPagto)-1){ ?><a onclick="javascript:adicionarFormaPgtoCompra(<?=$_GET["idCompra"]?>, <?=$i-1?>)" href="#"><img src="layout/incones/add16.png" border="0" alt="Adicioar Item" title="Adicionar Item"></a><? } ?>
			</td>
			<td class="ColunaInfo">
				<a href="javascript:verifyPnotifyConfirm( 'Deseja Excluir ?', 'excluirFormaPgtoCompra(<?=$formasPagto[$i]->getId()?>, <?=$_GET["idCompra"]?>);' );"><img src="layout/incones/button_cancel.png" border="0" style="width: 14px;"></a>
			</td>
        </tr>
        <? } ?>

		<tr class="linha">
			<td width="7%" class="ColunaInfo" style="text-align:left;" id = "precoTotalForma">
				<?=$precoTotal?>
			</td>
			<td width="40%" class="ColunaInfo" style="text-align:left;">&nbsp;
				<input type="hidden" name="totalFormaPgto" id="totalFormaPgto" value="<?=count($formasPagto)?>">
			</td>
			<td width="25%" class="ColunaInfo" style="text-align:left;">&nbsp;
	
			</td>
			<td width="10%" class="ColunaInfo" style="text-align:left;" >&nbsp;
	
			</td>
		</tr>
        
<?

}else if($_GET["acao"] == "selecionaProduto"){

	$produtos = $Main->Compras->pegaProduto($_GET["idProduto"]);

	if($produtos){

		$codigo = $produtos[0]->getCodigo();

		

		$precos = "<select id=\"preco".$indice."\" name=\"preco[".$_GET["idItem"]."]\" title=\"preco\" onChange=\"salvaCampoCompra(this.title, this.value, ".$_GET["idItem"].");calculaPrecoCompra(".$indice.")\">";

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

		$precos = "<select id=\"preco".$indice."\" name=\"preco[".$_GET["idItem"]."]\" onChange=\"calculaPrecoCompra(".$indice.")\">";

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