<?
ini_set('default_charset','UTF-8');
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

if($_GET["acao"] == "listar"){
	$fluxo = $Main->Fluxo->pegaFluxo($_GET["cliente"], $_GET["tipo"], $_GET["tipoFluxo"], $_GET["dataIni"], $_GET["dataFim"], "");

	
	
?>
<table width="100%" cellspacing="0" cellpadding="0" border="1" id="tabletest" class="table-erp">
	<tbody>
		<tr class="titulo">
			<td width="20%">Ocorrencia</td>
			<td width="20%">&nbsp;</td>
			<td width="10%" >Tipo</td>
			<td width="10%" >Valor</td>
			<td width="10%" >&nbsp;</td>
                        <td width="10%" >Status</td>
			<td width="10%" >Data</td>
			<td width="10%" align="right">
				<a title="Anterior" href="javascript:doAjaxSemRetorno('ajax_com/fluxo.php?acao=listar&cliente=<?=$_GET["cliente"]?>&tipo=<?=$_GET["tipo"]?>&tipoFluxo=<?=$_GET["tipoFluxo"]?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&limite=<?=($limite-15)?>',1,'Saida');">
					<span class="glyphicon fa fa-arrow-circle-left" aria-hidden="true"></span>
				</a>

				<a title="Próximo" href="javascript:doAjaxSemRetorno('ajax_com/fluxo.php?acao=listar&cliente=<?=$_GET["cliente"]?>&tipo=<?=$_GET["tipo"]?>&tipoFluxo=<?=$_GET["tipoFluxo"]?>&dataIni=<?=$_GET["dataIni"]?>&dataFim=<?=$_GET["dataFim"]?>&limite=<?=($limite-15)?>',1,'Saida');">
					<span class="glyphicon fa fa-arrow-circle-right" aria-hidden="true"></span>
				</a>
			</td>
		</tr>
		<?
			$total = 0;
			for($j=0; $j<count($fluxo); $j++){
				if($fluxo[$j]->getTipo() == 2){
					
                                        if($fluxo[$j]->getStatus()==0){
                                            $total -= $Main->Formata->valor2banco($fluxo[$j]->getValor());
                                        }
				}else{
					
                                        if($fluxo[$j]->getStatus()==0){
                                            $total += $Main->Formata->valor2banco($fluxo[$j]->getValor());
                                        }
				}

				
				
                                if($fluxo[$j]->getStatus() == 0){
                                    $class = "linha linhaVermelho";
                                }else{
                               		if(($j%2) == 0){
										$class = "linha";
									}else{
										$class = "linhaMu";
									}
                                }
		?>
		<tr id="linhaDataGrid_<?=$j?>" class="<?=$class?>" width="60%">
			<td id="linhaDataGrid_<?=$j?>_0">
				<?=$fluxo[$j]->getOcorrencia()?>
			</td>
			<td id="linhaDataGrid_<?=$j?>_0">
				<?=($fluxo[$j]->getClienteNome() != "") ? $fluxo[$j]->getClienteNome() : $fluxo[$j]->getFornecedorNome();?>
			</td>
			<td id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxo[$j]->getTipoFluxoNome()?>
			</td>
			<td id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxo[$j]->getValor()?>
			</td>
			<td id="linhaDataGrid_<?=$j?>_1"/>
				<?=($fluxo[$j]->getTipo()==1)?"Receita":"Despesa";?>
			</td>
			<td id="linhaDataGrid_<?=$j?>_1"/>

                         <?
                         if($fluxo[$j]->getStatus()==0){
                            print "Aberto";
                         }else if($fluxo[$j]->getStatus()==1){
                            print "Cancelada";
                         }else if($fluxo[$j]->getStatus()==3){
                            print "Descontado";
                         }else{
                            print "Paga";
                         }
                         ?>

			</td>
			<td id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxo[$j]->getData()?>
			</td>
			<td align="right"> 
				<a title="Editar" href="javascript:doAjaxSemRetorno('ajax_com/fluxo.php?acao=editar&id=<?=$fluxo[$j]->getId()?>',1,'addPop');addPop_open(550);">
					<span class="glyphicon fa fa-edit" aria-hidden="true"></span>
				</a>

				<a title="Excluir" onclick="verifyPnotifyConfirm( 'Deseja Excluir ?', 'excluirFluxo(<?=$fluxo[$j]->getId()?>)' );" href="#">
					<span class="glyphicon fa fa-trash" aria-hidden="true"></span>
				</a>
			</td>
		</tr>
		<?
		}
		
		if($total < 0){
			$fonte = "color:red;";
		}else{
			$fonte = "";
		}
		?>
		<tr class="titulo">
			<td width="100%" class="ColunaInfo" colspan="2" style="text-align:left;">Total</td>
			<td width="100%" class="ColunaInfo" colspan="6" style="text-align:left;<?=$fonte?>" ><?=$Main->Formata->banco2valor($total)?></td>
		</tr>
	</tbody>
</table>
<? 
}else if($_GET["acao"] == "adicionar" || $_GET["acao"] == "editar"){ 
	if($_GET["acao"] == "editar"){
		$fluxo = $Main->Fluxo->pegaFluxo("", "", "", "", "", $_GET["id"]);
	}
	$clientes = $Main->Pedidos->pegaClientes();
	$fornecedores = $Main->Fluxo->pegaFornecedores();
	$tipoFluxo = $Main->Fluxo->pegaTipoFluxo();
?>
<div style="border: 1px solid rgb(235, 240, 253);" id="SaidaPop">
	<form id="edit" name="edit" action="">
		<table cellspacing="5" cellpadding="0" border="1" align="left" width="100%">
			<tbody>
				<tr style="border-bottom: 1px solid #ddd; height: 30px;">
					<td align="left" width="30%"  style="padding-bottom: 5px;">
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
					<td align="right"><b>Clientes:</b></td>
					<td align="left" class="form-inline">
						<select id="clientes" name="clientes" title="clientes" class="form-control input-xs" >
							<option value="">Selecione</option>
							<?
							for($j=0; $j<count($clientes); $j++){
								$selected = ($fluxo[0] && $fluxo[0]->getClienteId() == $clientes[$j]->getId()) ? "selected" : "";
							?>					
							<option value="<?=$clientes[$j]->getId()?>" <?=$selected?>><?=$clientes[$j]->getNome()?></option>
							<?
							}
							?>
						</select>
						
						<a onclick="javascript:window.open('buscapopup.php?campoatual=clientes&amp;tabela=clientes', 'Busca', 'height = 300, width = 250, location = no, toolbar = no, menubar=no')" href="#"><img border="0" src="layout/incones/find.png"/></a> 
						<a onclick="javascript:window.open('addpopup.php?campoatual=clientes&amp;tabela=clientes', 'Busca', 'height = 550, width = 550, location = no, toolbar = no, scrollbars = yes')" href="#"><img border="0" src="layout/incones/add16.png"/></a>
					</td>
				</tr>
				<tr>
					<td align="right"><b>Fornecedores:</b></td>
					<td align="left" class="form-inline">
						<select id="fornecedor" name="fornecedor" title="fornecedor" class="form-control input-xs" >
							<option value="">Selecione</option>
							<?
							for($j=0; $j<count($fornecedores); $j++){
								$selected = ($fluxo[0] && $fluxo[0]->getFornecedorId() == $fornecedores[$j]->getId()) ? "selected" : "";
							?>					
							<option value="<?=$fornecedores[$j]->getId()?>" <?=$selected?>><?=$fornecedores[$j]->getNome()?></option>
							<?
							}
							?>
						</select>
						
						<a onclick="javascript:window.open('buscapopup.php?campoatual=fornecedor&amp;tabela=fornecedores', 'Busca', 'height = 300, width = 250, location = no, toolbar = no, menubar=no')" href="#"><img border="0" src="layout/incones/find.png"/></a> 
						<a onclick="javascript:window.open('addpopup.php?campoatual=fornecedor&amp;tabela=fornecedores', 'Busca', 'height = 550, width = 550, location = no, toolbar = no, scrollbars = yes')" href="#"><img border="0" src="layout/incones/add16.png"/></a>
					</td>
				</tr>
				<tr>
					<td align="right"><b>Tipo Fluxo:</b></td>
					<td align="left" class="form-inline">
						
						<select id="tipoFluxo" name="tipoFluxo"  title="tipoFluxo" class="erroForm form-control input-xs">
							<option value="">Selecione</option>
							<?
							for($j=0; $j<count($tipoFluxo); $j++){
								$selected = ($fluxo[0] && $fluxo[0]->getTipoFluxoId() == $tipoFluxo[$j]->getId()) ? "selected" : "";
							?>					
							<option value="<?=$tipoFluxo[$j]->getId()?>" <?=$selected?>><?=$tipoFluxo[$j]->getNome()?></option>
							<?
							}
							?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td align="right"><b>Status:</b></td>
					<td align="left" class="form-inline">
						
						<select id="statusFluxo" name="statusFluxo"  title="statusFluxo" class="erroForm form-control input-xs">
							<option value="0" <?=($fluxo[0] && $fluxo[0]->getStatus() == 0) ? "selected" : "";?>>Não Pago</option>
							<option value="1" <?=($fluxo[0] && $fluxo[0]->getStatus() == 1) ? "selected" : "";?>>Cancelada</option>
							<option value="2" <?=($fluxo[0] && $fluxo[0]->getStatus() == 2) ? "selected" : "";?>>Paga</option>
							<option value="3" <?=($fluxo[0] && $fluxo[0]->getStatus() == 3) ? "selected" : "";?>>Descontado</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td align="right"><b>Tipo:</b></td>
					<td align="left"class="form-inline" >
						<select id="tipo" name="tipo"  title="Tipo" class="erroForm form-control input-xs">
							<option value="">Selecione</option>
							<option value="1" <? if($fluxo[0] && $fluxo[0]->getTipo() == 1) print "selected"; ?>>Entrada</option>
							<option value="2" <? if($fluxo[0] && $fluxo[0]->getTipo() == 2) print "selected"; ?>>Saída</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td align="right"><b>Ocorrencia:</b></td>
					<td align="left">
					  <textarea name="ocorrencia" class="form-control" id="ocorrencia" rows="5" cols="50" wrap="off"><? if($fluxo[0]) print $fluxo[0]->getOcorrencia()?></textarea>
					</td>
				</tr>
				<tr>
					<td align="right"><b>Valor:</b></td>
					<td align="left">
						<input type="text" class="form-control input-xs" name="valor" id="valor" size="10" onkeypress="mascaras.Formata(this,20,event,2)"  value="<? if($fluxo[0]) print $fluxo[0]->getValor()?>">
					</td>
				</tr>
				<tr>
					<td align="right"><b>Data:</b></td>
					<td align="left">
						<input type="text" class="form-control input-xs" name="data" id="data" size="11" onkeypress="mascaras.mascara(this,'data')"  value="<? if($fluxo[0]) print $fluxo[0]->getData()?>">
					</td>
				</tr>
				
				<tr>
					<td align="center" colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" colspan="3">
						<div class="btn-group" role="group" aria-label="...">
							<input class="btn btn-success btn-sm " type="button" onclick="verifyPnotifyConfirm( 'Deseja pagar?', 'salvarFluxo(<?=$_GET["id"]?>)' );" value="Salvar" /> 
							<input class="btn btn-danger btn-sm" type="button" onclick="addPop_close();" value="Cancelar"/>
						</div>
						<input type="hidden" name="id" id="id" value="<?=$_GET["id"]?>"/>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
<? 
}
?>