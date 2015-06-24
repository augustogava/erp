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
			<td width="10%" colspan="8">Vencidas</td>
        </tr>
		<tr class="titulo">
			<td width="20%">Ocorrencia</td>
			<td width="20%">&nbsp;</td>
			<td width="10%" >Tipo</td>
			<td width="10%" >Valor</td>
			<td width="10%" >&nbsp;</td>
			<td width="10%" >Status</td>
			<td width="10%" >Data</td>
			<td width="10%"></td>
		</tr>
		<?
			$total = 0;
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
			<td  id="linhaDataGrid_<?=$j?>_1"/>
				<?=($fluxo[$j]->getTipo()==1)?"Entrada":"Saida";?>
			</td>
			<td width="10%" id="linhaDataGrid_<?=$j?>_1"/>
				<?
	            if($fluxo[$j]->getStatus()==0){
					print "Não Paga";
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
				<a title="Pagar"  onclick="pagarContasPagar(<?=$fluxo[$j]->getId()?>)" href="#">
					<span class="glyphicon fa fa-usd" aria-hidden="true"></span>
				</a>
				
				<a title="Descontar" onclick="descontarContasPagar(<?=$fluxo[$j]->getId()?>)" href="#" >
					<span class="glyphicon fa fa-money" aria-hidden="true"></span>
				</a>

				<a title="Excluir" onclick="if(confirm('Deseja Cancelar?')){ excluirContasReceber(<?=$fluxo[$j]->getId()?>);  }" href="#">
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

<br>

    <table width="100%" cellspacing="0" cellpadding="0" border="1" id="tabletest" class="table-erp">
	<tbody>
		<tr class="titulo">
			<td width="10%" colspan="8">Pagar</td>
        </tr>
		<tr class="titulo">
			<td width="20%">Ocorrencia</td>
			<td width="20%">&nbsp;</td>
			<td width="10%" >Tipo</td>
			<td width="10%" >Valor</td>
			<td width="10%" >&nbsp;</td>
			<td width="10%" >Status</td>
			<td width="10%" >Data</td>
			<td width="10%"></td>
		</tr>
		<?
			$total = 0;
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
				<?=($fluxoPagar[$j]->getTipo()==1)?"Entrada":"Saida";?>
			</td>
			<td  id="linhaDataGrid_<?=$j?>_1"/>
            	<?
            	if($fluxoPagar[$j]->getStatus()==0){
                		print "Não Paga";
				}else if($fluxoPagar[$j]->getStatus()==1){
                		print "Cancelada";
				}else if($fluxoPagar[$j]->getStatus()==3){
                		print "Descontado";
				}else{
                		print "Paga";
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
					<a title="Pagar" onclick="if(confirm('Deseja Pagar?')){doAjaxSemRetorno('ajax_com/contas_receber_acao.php?acao=pagar&id=<?=$fluxoPagar[$j]->getId()?>', 1, '');refreshContasPagar();}" href="#">
						<span class="glyphicon fa fa-usd" aria-hidden="true"></span>
					</a>
					<?
                    }
                    ?>
                    
                    <?
					if($fluxoPagar[$j]->getStatus()==0){
                    ?>
					<a title="Descontar" onclick="if(confirm('Deseja Descontar?')){doAjaxSemRetorno('ajax_com/contas_receber_acao.php?acao=descontar&id=<?=$fluxoPagar[$j]->getId()?>', 1, '');refreshContasPagar();}" href="#" >
						<span class="glyphicon fa fa-money" aria-hidden="true"></span>
					</a>
					
					<?
                    }
                    ?>
                    
					<?
					if($fluxoPagar[$j]->getStatus()==0){
                    ?>
					<a title="Excluir" onclick="if(confirm('Deseja Cancelar?')){ excluirContasReceber(<?=$fluxoPagar[$j]->getId()?>);  }" href="#">
						<span class="glyphicon fa fa-trash" aria-hidden="true"></span>
					</a>
					<?
                    }
                    ?>
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
}
?>