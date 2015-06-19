<?
header("Content-Type: text/html;  charset=ISO-8859-1",true);
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
            <tr class="tituloSemLinha">
		<td width="10%" colspan="7">Vencidas</td>
            </tr>
		<tr class="tituloRed">
			<td width="20%">Ocorrencia</td>
			<td width="20%">&nbsp;</td>
			<td width="10%" >Tipo</td>
			<td width="10%" >Valor</td>
			<td width="10%" >&nbsp;</td>
                        <td width="10%" >Status</td>
			<td width="10%" >Data</td>
			<td width="4%">
				
			</td>
                        <td width="4%">

			</td>
			<td width="4%">
				
			</td>
		</tr>
		<?
			$total = 0;
			for($j=0; $j<count($fluxo); $j++){
				/*if($fluxo[$j]->getTipo() == 2){
					$class = "linhaVermelha";
					$total -= $Main->Formata->valor2banco($fluxo[$j]->getValor());
				}else{
					$class = "linha";
					$total += $Main->Formata->valor2banco($fluxo[$j]->getValor());
				}*/
                            $total += $Main->Formata->valor2banco($fluxo[$j]->getValor());
                            $class = "linhaVermelha";
		?>
		<tr id="linhaDataGrid_<?=$j?>" class="<?=$class?>" width="60%">
			<td width="20%"  id="linhaDataGrid_<?=$j?>_0">
				<?=$fluxo[$j]->getOcorrencia()?>
			</td>
			<td width="20%"  id="linhaDataGrid_<?=$j?>_0">
				<?=($fluxo[$j]->getClienteNome() != "") ? $fluxo[$j]->getClienteNome() : $fluxo[$j]->getFornecedorNome();?>
			</td>
			<td width="10%" id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxo[$j]->getTipoFluxoNome()?>
			</td>
			<td width="10%" id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxo[$j]->getValor()?>
			</td>
			<td width="10%" id="linhaDataGrid_<?=$j?>_1"/>
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
			<td width="10%" id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxo[$j]->getData()?>
			</td>
			<td width="4%" align="center"> 
				<a href ="#" onclick="pagarContasPagar(<?=$fluxo[$j]->getId()?>)">
					<img border="0" src="layout/incones/pagar.png" alt="Pagar"/>
				</a>
			</td>
                        <td width="4%" align="center">
				<a href ="#" onclick="descontarContasPagar(<?=$fluxo[$j]->getId()?>)">
					<img border="0" src="layout/incones/desconto.png" alt="Descontar" width="32px"/>
				</a>
			</td>
			<td  width="4%" align="center"> 
				<a onclick="if(confirm('Deseja Cancelar?')){ excluirContasReceber(<?=$fluxo[$j]->getId()?>);  }" href="#">
					<img border="0" src="layout/incones/button_cancel.png" alt="Cancelar"/>
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
			<td width="100%" class="ColunaInfo" colspan="8" style="text-align:left;<?=$fonte?>" ><?=$Main->Formata->banco2valor($total)?></td>
		</tr>
	</tbody>
    </table>

<br>

    <table width="100%" cellspacing="0" cellpadding="0" border="1" id="tabletest" class="table-erp">
	<tbody>
            <tr class="tituloSemLinha">
		<td width="10%" colspan="7">Pagar</td>
            </tr>
		<tr class="tituloRed">
			<td width="20%">Ocorrencia</td>
			<td width="20%">&nbsp;</td>
			<td width="10%" >Tipo</td>
			<td width="10%" >Valor</td>
			<td width="10%" >&nbsp;</td>
                        <td width="10%" >Status</td>
			<td width="10%" >Data</td>
			<td width="4%">
				
			</td>
                        <td width="4%">

			</td>
			<td width="4%">
				
			</td>
		</tr>
		<?
			$total = 0;
			for($j=0; $j<count($fluxoPagar); $j++){
				/*if($fluxo[$j]->getTipo() == 2){
					$class = "linhaVermelha";
					$total -= $Main->Formata->valor2banco($fluxo[$j]->getValor());
				}else{
					$class = "linha";
					$total += $Main->Formata->valor2banco($fluxo[$j]->getValor());
				}*/
                            if($fluxoPagar[$j]->getStatus() == 0)
                                $total += $Main->Formata->valor2banco($fluxoPagar[$j]->getValor());

				if(($j%2) == 0){
					$class = "linha";
				}else{
					$class = "linhaMu";
				}
		?>
		<tr id="linhaDataGrid_<?=$j?>" class="<?=$class?>" width="60%">
			<td width="20%"  id="linhaDataGrid_<?=$j?>_0">
				<?=$fluxoPagar[$j]->getOcorrencia()?>
			</td>
			<td width="20%"  id="linhaDataGrid_<?=$j?>_0">
				<?=($fluxoPagar[$j]->getClienteNome() != "") ? $fluxoPagar[$j]->getClienteNome() : $fluxoPagar[$j]->getFornecedorNome();?>
			</td>
			<td width="10%" id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxoPagar[$j]->getTipoFluxoNome()?>
			</td>
			<td width="10%" id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxoPagar[$j]->getValor()?>
			</td>
			<td width="10%" id="linhaDataGrid_<?=$j?>_1"/>
				<?=($fluxoPagar[$j]->getTipo()==1)?"Entrada":"Saida";?>
			</td>
                        <td width="10%" id="linhaDataGrid_<?=$j?>_1"/>
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
			<td width="10%" id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxoPagar[$j]->getData()?>
			</td>
			<td width="4%" align="center">
			<?
                        if($fluxoPagar[$j]->getStatus()==0){
                        ?>
                            <a href ="#"onclick="if(confirm('Deseja Pagar?')){doAjaxSemRetorno('ajax_com/contas_receber_acao.php?acao=pagar&id=<?=$fluxoPagar[$j]->getId()?>', 1, '');refreshContasPagar();}">
					<img border="0" src="layout/incones/pagar.png" alt="Pagar"/>
				</a>
                           <?
                        }
                        ?>
			</td>
                        <td width="4%" align="center">
                        <?
                            if($fluxoPagar[$j]->getStatus()==0){
                        ?>
                                <a href ="#" onclick="if(confirm('Deseja Descontar?')){doAjaxSemRetorno('ajax_com/contas_receber_acao.php?acao=descontar&id=<?=$fluxoPagar[$j]->getId()?>', 1, '');refreshContasPagar();}">
					<img border="0" src="layout/incones/desconto.png" alt="Descontar" width="32px"/>
				</a>
                        <?
                            }
                        ?>
			</td>
			<td  width="4%" align="center">
			<?
                        if($fluxoPagar[$j]->getStatus()==0){
                        ?>
                            <a onclick="if(confirm('Deseja Cancelar?')){ excluirContasReceber(<?=$fluxoPagar[$j]->getId()?>);  }" href="#">
					<img border="0" src="layout/incones/button_cancel.png" alt="Cancelar"/>
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
			<td width="100%" class="ColunaInfo" colspan="8" style="text-align:left;<?=$fonte?>" ><?=$Main->Formata->banco2valor($total)?></td>
		</tr>
	</tbody>
    </table>

<? 
}
?>