<?
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

				<a title="Excluir" onclick="if(confirm('Deseja Excluir?')){ excluirFluxo(<?=$fluxo[$j]->getId()?>);  }" href="#">
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
}
?>