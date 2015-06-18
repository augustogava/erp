<?
header("Content-Type: text/html;  charset=ISO-8859-1",true);
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
$Main->AdicionaFluxoBanco();


if($_GET["acao"] == "listarBancos"){
    $bancos = $Main->FluxoBanco->pegaBancos();
?>
<table width="100%" cellspacing="0" cellpadding="0" border="1" id="tabletest">
	<tbody>
		<tr class="titulo">
			<td width="40%">Nome</td>
			<td width="25%" >Agencia</td>
			<td width="25%" >Conta</td>
			<td width="10%" >Saldo</td>
		</tr>
		<?
                    for($j=0; $j<count($bancos); $j++){
		?>
		<tr id="" class="linha" width="60%" onclick="window.location = 'fluxo_banco.php?idBanco=<?=$bancos[$j]->getId()?>'">
			<td width="40%"  id="linhaDataGrid_<?=$j?>_0">
				<?=$bancos[$j]->getNome()?>
			</td>
			<td width="25%" id="linhaDataGrid_<?=$j?>_1"/>
				<?=$bancos[$j]->getAgencia()?>
			</td>
			<td width="25%" id="linhaDataGrid_<?=$j?>_1"/>
				<?=$bancos[$j]->getConta()?>
			</td>
			<td width="10%" id="linhaDataGrid_<?=$j?>_1"/>
				<?=$Main->Formata->banco2valor($bancos[$j]->getSaldo());?>
			</td>
		</tr>
                <?
                    }
		?>
	</tbody>
</table>
<?
}else if($_GET["acao"] == "listar"){
	$fluxo = $Main->FluxoBanco->pegaFluxoBanco($_GET["idBanco"], $_GET["tipo"], $_GET["tipoFluxo"], $_GET["dataIni"], $_GET["dataFim"], "");
	print_r($fluxo);
        $bancos = $Main->FluxoBanco->pegaBancos($_GET["idBanco"]);
	
?>
<table width="100%" cellspacing="0" cellpadding="0" border="1" id="tabletest">
	<tbody>
		<tr class="titulo">
			<td width="40%">Ocorrencia</td>
			<td width="10%" >Tipo</td>
			<td width="10%" >Valor</td>
			<td width="10%" >&nbsp;</td>
                        <td width="10%" >&nbsp;</td>
			<td width="10%" >Data</td>
                        <td width="4%">
                            &nbsp;
			</td>
			<td width="4%">
                            &nbsp;
			</td>
			<td width="4%">
                            &nbsp;
			</td>
		</tr>
		<?
			$total = 0;
			for($j=0; $j<count($fluxo); $j++){
                            if($fluxo[$j]->getStatus() == 0){
                                $class = "linhaVermelha";
                                if($fluxo[$j]->getTipo() == 1){
                                    $soma += $Main->Formata->valor2banco( $fluxo[$j]->getValor() );
                                }else{
                                     $soma -= $Main->Formata->valor2banco( $fluxo[$j]->getValor() );
                                }
                            }else{
                                $class = "linha";
                            }


		?>
		<tr id="linhaDataGrid_<?=$j?>" class="<?=$class?>" width="60%">
			<td width="40%"  id="linhaDataGrid_<?=$j?>_0">
				<?=$fluxo[$j]->getOcorrencia()?>
			</td>
			<td width="10%" id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxo[$j]->getTipoFluxoNome()?>
			</td>
			<td width="10%" id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxo[$j]->getValor()?>
			</td>
			<td width="10%" id="linhaDataGrid_<?=$j?>_1"/>
				<?=($fluxo[$j]->getTipo()==1)?"Entrada":"Saída";?>
			</td>
                        <td width="10%" id="linhaDataGrid_<?=$j?>_1"/>
				<?=($fluxo[$j]->getStatus()==0)?"Não Pago":"Pago";?>
			</td>
			<td width="10%" id="linhaDataGrid_<?=$j?>_1"/>
				<?=$fluxo[$j]->getData()?>
			</td>
                        <td width="4%" align="center">
                            <? if($fluxo[$j]->getStatus() == 0){ ?>
                                <a href ="#" onclick="pagarBanco(<?=$fluxo[$j]->getId()?>, <?=$_GET["idBanco"]?>)">
					<img border="0" src="layout/incones/pagar.png" alt="Pagar"/>
				</a>
                            <? } ?>
			</td>
			<td width="4%" align="center"> 
				<a href="javascript:doAjaxSemRetorno('ajax_com/fluxoBanco.php?acao=editar&id=<?=$fluxo[$j]->getId()?>&idBanco=<?=$_GET["idBanco"]?>',1,'addPop');addPop_open(550);">
					<img border="0" src="layout/incones/edit.png"/>
				</a>
			</td>
			<td  width="4%" align="center"> 
				<a onclick="if(confirm('Deseja Excluir?')){ excluirFluxoBanco(<?=$fluxo[$j]->getId()?>, <?=$_GET["idBanco"]?>);  }" href="#">
					<img border="0" src="layout/incones/button_cancel.png"/>
				</a>
			</td>
		</tr>
		<?
		}
		?>
		<tr class="titulo">
                    <td width="100%" class="ColunaInfo" colspan="9" style="text-align:left;">
                        <table width="100%" cellspacing="0" cellpadding="0" border="1" id="tabletest">
                            <tr class="titulo">
                                <td width="20%" class="ColunaInfo" style="text-align:left;">Saldo Previsto: <?=$Main->Formata->banco2valor($bancos[0]->getSaldo()+$soma)?></td>
                                <td width="80%" class="ColunaInfo"  style="text-align:left;">Saldo Atual: <?=$Main->Formata->banco2valor($bancos[0]->getSaldo())?></td>
                            </tr>
                        </table>
                    </td>
		</tr>
	</tbody>
</table>
<? 
}else if($_GET["acao"] == "adicionar" || $_GET["acao"] == "editar"){ 
	if($_GET["acao"] == "editar"){
		$fluxo = $Main->FluxoBanco->pegaFluxoBanco("", "", "", "", "", $_GET["id"]);
	}

	$tipoFluxo = $Main->FluxoBanco->pegaTipoFluxo();
        $bancos    = $Main->FluxoBanco->pegaBancos($_GET["idBanco"]);
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
                                    <td align="right"><b>Banco:</b></td>
                                    <td align="left" class="form-inline">
                                        <select id="banco" name="banco"  title="banco" class="erroForm form-control input-sm">
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
                                    </td>
				</tr>
				<tr>
                                    <td align="right"><b>Tipo Fluxo:</b></td>
                                    <td align="left" class="form-inline">
                                        <select id="tipoFluxo" name="tipoFluxo"  title="tipoFluxo" class="erroForm form-control input-sm">
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
                                    <td align="right"><b>Tipo:</b></td>
                                    <td align="left" class="form-inline">
                                        <select id="tipo" name="tipo"  title="Tipo" class="erroForm form-control input-sm">
                                                <option value="">Selecione</option>
                                                <option value="1" <? if($fluxo[0] && $fluxo[0]->getTipo() == 1) print "selected"; ?>>Entrada</option>
                                                <option value="2" <? if($fluxo[0] && $fluxo[0]->getTipo() == 2) print "selected"; ?>>Saída</option>
                                        </select>
                                    </td>
				</tr>
				
				<tr>
					<td align="right"><b>Ocorrencia:</b></td>
					<td align="left">
					  <textarea name="ocorrencia" id="ocorrencia" class="form-control input-sm" rows="6" cols="50" wrap="off"><? if($fluxo[0]) print $fluxo[0]->getOcorrencia()?></textarea>
					</td>
				</tr>
                                <tr>
					<td align="right"><b>Numero Doc.:</b></td>
					<td align="left">
					  <textarea name="numero_doc" id="numero_doc" class="form-control input-sm" rows="1" cols="50" wrap="off"><? if($fluxo[0]) print $fluxo[0]->getNumeroDoc()?></textarea>
					</td>
				</tr>
				<tr>
					<td align="right"><b>Valor:</b></td>
					<td align="left">
						<input type="text" name="valor" id="valor" class="form-control input-sm" size="10" onkeypress="mascaras.Formata(this,20,event,2)"  value="<? if($fluxo[0]) print $fluxo[0]->getValor()?>">
					</td>
				</tr>
				<tr>
					<td align="right"><b>Data:</b></td>
					<td align="left">
						<input type="text" name="data" id="data" class="form-control input-sm" size="11" onkeypress="mascaras.mascara(this,'data')"  value="<? if($fluxo[0]) print $fluxo[0]->getData()?>">
					</td>
				</tr>
				
				<tr>
					<td align="center" colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" colspan="3">
						<div class="btn-group" role="group" aria-label="...">
							<input class="btn btn-success btn-sm " type="button" onclick="salvarFluxoBanco(<?=$_GET["id"]?>)" value="Salvar" />
							<input class="btn btn-danger btn-sm" type="button" onclick="addPop_close();" value="Cancelar"/>
						</div>
						
						<input type="hidden" name="id" id="id" value="<?=$_GET["id"]?>"/>
						<input type="hidden" name="idBanco" id="idBanco" value="<?=$_GET["idBanco"]?>"/>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
	<script>
	document.onkeypress = function (evt){
		if(main.procuraTecla(evt,13)){
			if(confirm('Deseja salvar?')){ salvafluxoBanco(<?=$_GET["id"]?>); }
		}
	}
	</script>
</div>
<? 
}
?>