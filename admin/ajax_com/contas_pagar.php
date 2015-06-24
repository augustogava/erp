<?
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

if($_GET["acao"] == "listar"){
	$fluxo        = $Main->Fluxo->pegaContasPagarVencidas();
    $fluxoPagar   = $Main->Fluxo->pegaContasPagar();
	
?>
    <table width="100%" cellspacing="0" cellpadding="0" border="1" id="tabletest" class="table-erp">
	<tbody>
		<tr class="titulo">
			<td width="10%" colspan="7">Vencidas</td>
        </tr>
		<tr class="titulo">
			<td width="20%">Ocorrencia</td>
			<td width="20%">&nbsp;</td>
			<td width="14%" >Tipo</td>
			<td width="8%" >Valor</td>
			<td width="10%" >Status</td>
			<td width="10%" >Vencimento</td>
			<td width="18%"></td>
		</tr>
		<?
		$total = 0;
		if( count($fluxo) == 0 ){
		?>
			<tr class="linha">
				<td width="100%" align="center" colspan="7">Sem Registros</td>
			</tr>
		<?
		}else{
				for($j=0; $j<count($fluxo); $j++){
					$total += $Main->Formata->valor2banco($fluxo[$j]->getValor());
	            	$class = "linhaVermelho";
		?>
		<tr id="linhaDataGrid_<?=$j?>" class="linha <?=$class?>" width="60%">
			<td id="linhaDataGrid_<?=$j?>_0">
				<?=$fluxo[$j]->getOcorrencia()?>
			</td>
			<td  id="linhaDataGrid_<?=$j?>_0">
				<?=($fluxo[$j]->getClienteNome() != "") ? $fluxo[$j]->getClienteNome() : $fluxo[$j]->getFornecedorNome();?>
			</td>
			<td id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxo[$j]->getTipoFluxoNome()?>
			</td>
			<td  id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxo[$j]->getValor()?>
			</td>
			<td width="10%" id="linhaDataGrid_<?=$j?>_1"/>
				<?
	            if($fluxo[$j]->getStatus()==0){
					print "Aberto";
	            }else if($fluxo[$j]->getStatus()==1){
	            	print "Cancelada";
	            }else if($fluxo[$j]->getStatus()==3){
	            	print "Descontado";
	            }else{
	            	print "Pago";
	            }
	            ?>
			</td>
			<td id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxo[$j]->getData()?>
			</td>
			<td align="right"> 
				<a title="Pagar" href="javascript:doAjaxSemRetorno('ajax_com/contas_pagar.php?acao=pagar&id=<?=$fluxo[$j]->getId()?>',1,'addPop');addPop_open(550);">
					<span class="glyphicon fa fa-usd" aria-hidden="true"></span>
				</a>
				
				<a title="Descontar" href="javascript:doAjaxSemRetorno('ajax_com/contas_pagar.php?acao=descontar&id=<?=$fluxo[$j]->getId()?>',1,'addPop');addPop_open(550);">
					<span class="glyphicon fa fa-money" aria-hidden="true"></span>
				</a>

				<a title="Cancelar?" onclick="if(confirm('Deseja Cancelar?')){ cancelarContasReceber(<?=$fluxo[$j]->getId()?>);  }" href="#">
					<span class="glyphicon fa fa-close" aria-hidden="true"></span>
				</a>
				
				<a title="Editar" href="javascript:doAjaxSemRetorno('ajax_com/contas_pagar.php?acao=editar&id=<?=$fluxo[$j]->getId()?>',1,'addPop');addPop_open(550);">
					<span class="glyphicon fa fa-edit" aria-hidden="true"></span>
				</a>

				<a title="Excluir" onclick="if(confirm('Deseja Excluir?')){ excluirFluxo(<?=$fluxo[$j]->getId()?>);  }" href="#">
					<span class="glyphicon fa fa-trash" aria-hidden="true"></span>
				</a>
			</td>
		</tr>
		<?
			}
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

<br>

    <table width="100%" cellspacing="0" cellpadding="0" border="1" id="tabletest" class="table-erp">
	<tbody>
		<tr class="titulo">
			<td width="10%" colspan="7">Pagar</td>
        </tr>
		<tr class="titulo">
			<td width="20%">Ocorrencia</td>
			<td width="20%">&nbsp;</td>
			<td width="14%" >Tipo</td>
			<td width="8%" >Valor</td>
			<td width="10%" >Status</td>
			<td width="10%" >Vencimento</td>
			<td width="18%"></td>
		</tr>
		<?
			$total = 0;
			if( count($fluxoPagar) == 0 ){
			?>
			<tr class="linha">
				<td width="100%" align="center" colspan="7">Sem Registros</td>
	        </tr>
		<?
			}else{
				for($j=0; $j<count($fluxoPagar); $j++){
					if($fluxoPagar[$j]->getStatus() == 0)
	                	$total += $Main->Formata->valor2banco($fluxoPagar[$j]->getValor());
	
					if(($j%2) == 0){
						$class = "linha";
					}else{
						$class = "linhaMu";
					}
		?>
		<tr id="linhaDataGrid_<?=$j?>" class="<?=$class?>" width="60%">
			<td  id="linhaDataGrid_<?=$j?>_0">
				<?=$fluxoPagar[$j]->getOcorrencia()?>
			</td>
			<td  id="linhaDataGrid_<?=$j?>_0">
				<?=($fluxoPagar[$j]->getClienteNome() != "") ? $fluxoPagar[$j]->getClienteNome() : $fluxoPagar[$j]->getFornecedorNome();?>
			</td>
			<td  id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxoPagar[$j]->getTipoFluxoNome()?>
			</td>
			<td  id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxoPagar[$j]->getValor()?>
			</td>
			<td  id="linhaDataGrid_<?=$j?>_1"/>
            	<?
            	if($fluxoPagar[$j]->getStatus()==0){
                		print "Aberto";
				}else if($fluxoPagar[$j]->getStatus()==1){
                		print "Cancelada";
				}else if($fluxoPagar[$j]->getStatus()==3){
                		print "Descontado";
				}else{
                		print "Pago";
				}
                ?>
			</td>
			<td id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxoPagar[$j]->getData()?>
			</td>
			<td  align="right">
                <?
				if($fluxoPagar[$j]->getStatus()==0){
                ?>
				 <a title="Pagar" href="javascript:doAjaxSemRetorno('ajax_com/contas_pagar.php?acao=pagar&id=<?=$fluxoPagar[$j]->getId()?>',1,'addPop');addPop_open(550);">
					<span class="glyphicon fa fa-usd" aria-hidden="true"></span>
				</a>
				<?
                }
                ?>
                    
                <?
				if($fluxoPagar[$j]->getStatus()==0){
                ?>
				<a title="Descontar" href="javascript:doAjaxSemRetorno('ajax_com/contas_pagar.php?acao=descontar&id=<?=$fluxoPagar[$j]->getId()?>',1,'addPop');addPop_open(550);">
					<span class="glyphicon fa fa-money" aria-hidden="true"></span>
				</a>
				<?
                }
                ?>
                    
				<?
				if($fluxoPagar[$j]->getStatus()==0){
                ?>
				<a title="Cancelar" onclick="if(confirm('Deseja Cancelar?')){ cancelarContasReceber(<?=$fluxoPagar[$j]->getId()?>);  }" href="#">
					<span class="glyphicon fa fa-close" aria-hidden="true"></span>
				</a>
				<?
                }
                ?>
                
                <a title="Editar" href="javascript:doAjaxSemRetorno('ajax_com/contas_pagar.php?acao=editar&id=<?=$fluxoPagar[$j]->getId()?>',1,'addPop');addPop_open(550);">
					<span class="glyphicon fa fa-edit" aria-hidden="true"></span>
				</a>

				<a title="Excluir" onclick="if(confirm('Deseja Excluir?')){ excluirFluxo(<?=$fluxoPagar[$j]->getId()?>);  }" href="#">
					<span class="glyphicon fa fa-trash" aria-hidden="true"></span>
				</a>
			</td>
		</tr>
		<?
			}
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
	$bancos = $Main->FluxoBanco->pegaBancos();
	$fornecedores = $Main->Fluxo->pegaFornecedores();
	$tipoFluxo = $Main->Fluxo->pegaTipoFluxo(2);
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
					<td align="right"><b>Banco:</b></td>
					<td align="left" class="form-inline">
						<select id="banco" name="banco" title="banco" class="form-control input-xs" >
							<option value="">Selecione</option>
							<?
							for($j=0; $j<count($bancos); $j++){
								$selected = ($fluxo[0] && $fluxo[0]->getBancoId() == $bancos[$j]->getId()) ? "selected" : "";
							?>					
							<option value="<?=$bancos[$j]->getId()?>" <?=$selected?>><?=$bancos[$j]->getNome()?></option>
							<?
							}
							?>
						</select>
						
						<a onclick="javascript:window.open('buscapopup.php?campoatual=bancos&amp;tabela=bancos', 'Busca', 'height = 300, width = 250, location = no, toolbar = no, menubar=no')" href="#"><img border="0" src="layout/incones/find.png"/></a> 
						<a onclick="javascript:window.open('addpopup.php?campoatual=bancos&amp;tabela=bancos', 'Busca', 'height = 550, width = 550, location = no, toolbar = no, scrollbars = yes')" href="#"><img border="0" src="layout/incones/add16.png"/></a>
					</td>
				</tr>
				<tr>
					<td align="right"><b>Tipo Despesa:</b></td>
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
				<?php 
				if($fluxo[0] && $fluxo[0]->getStatus() >= 2){
				?>
				<tr>
					<td align="right"><b>Tipo Pagamento:</b></td>
					<td align="left" class="form-inline">&nbsp;
						<? print ($fluxo[0] && $fluxo[0]->getTipoPagamentoNome() ) ? $fluxo[0]->getTipoPagamentoNome() : "-"; ?>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td align="right"><b>Status:</b></td>
					<td align="left" class="form-inline">
						
						<select id="statusFluxo" name="statusFluxo"  title="statusFluxo" class="erroForm form-control input-xs">
							<option value="0" <?=($fluxo[0] && $fluxo[0]->getStatus() == 0) ? "selected" : "";?>>Aberta</option>
							<option value="2" <?=($fluxo[0] && $fluxo[0]->getStatus() == 2) ? "selected" : "";?>>Paga</option>
							<option value="3" <?=($fluxo[0] && $fluxo[0]->getStatus() == 3) ? "selected" : "";?>>Descontada</option>
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
							<input class="btn btn-success btn-sm " type="button" onclick="salvarContasPagar(<?=$_GET["id"]?>)" value="Salvar" /> 
							<input class="btn btn-danger btn-sm" type="button" onclick="addPop_close();" value="Cancelar"/>
						</div>
						<input type="hidden" name="id" id="id" value="<?=$_GET["id"]?>"/>
						<input type="hidden" name="tipo" id="tipo" value="2"/>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<?
}else if($_GET["acao"] == "pagar" || $_GET["acao"] == "descontar"){ 
	$fluxo = $Main->Fluxo->pegaFluxo("", "", "", "", "", $_GET["id"]);
	$tipoPagamento = $Main->Fluxo->pegaTipoPagamentos();
?>
<div style="border: 1px solid rgb(235, 240, 253);" id="SaidaPop">
	<form id="edit" name="edit" action="">
		<table cellspacing="5" cellpadding="0" border="1" align="left" width="100%">
			<tbody>
				<tr style="border-bottom: 1px solid #ddd; height: 30px;">
					<td align="left" width="30%"  style="padding-bottom: 5px;">
						<h2><?ucfirst($_GET["acao"]);?> Cadastro</h2>
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
					<td align="right"><b>Tipo Pagamento:</b></td>
					<td align="left" class="form-inline">
						
						<select id="tipoPagamento" name="tipoPagamento" title="tipoPagamento" class="erroForm form-control input-xs">
							<option value="">Selecione</option>
							<?
							for($j=0; $j<count($tipoPagamento); $j++){
							?>					
							<option value="<?=$tipoPagamento[$j]->getId()?>" <?=$selected?>><?=$tipoPagamento[$j]->getNome()?></option>
							<?
							}
							?>
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
					<td align="center" colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" colspan="3">
						<div class="btn-group" role="group" aria-label="...">
							<?php if( $_GET["acao"]  == "pagar"){?>
								<input class="btn btn-success btn-sm " type="button" onclick="pagarContasPagar(<?=$_GET["id"]?>)" value="Pagar" />
							<?php } ?>
							
							<?php if( $_GET["acao"]  == "descontar"){?>
								<input class="btn btn-success btn-sm " type="button" onclick="descontarContasPagar(<?=$_GET["id"]?>)" value="Descontar" />
							<?php } ?>
							 
							<input class="btn btn-danger btn-sm" type="button" onclick="addPop_close();" value="Cancelar"/>
						</div>
						<input type="hidden" name="id" id="id" value="<?=$_GET["id"]?>"/>
						<input type="hidden" name="tipo" id="tipo" value="1"/>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<? 
}
?>