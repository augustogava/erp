<?
$acao=$_REQUEST["acao"];
$id=$_REQUEST["acao"];
$hj=date("Y-m-d");
if(empty($acao)) $acao="entrar";
$usua=$_SESSION["iduser"];
if($acao=="alt"){
	$id=$_GET["id"];
	$res=mysql_fetch_array(mysql_query("SELECT * FROM cad_pres WHERE id='$id'"));
}else if($acao=="alterar"){
	$id=$_POST["id"];
	$data=data2banco($data);
	$valor=valor2banco($valor);
	$sql=mysql_query("UPDATE cad_pres SET numero='$numero',qtd='$qtd',nome='$nome',endereco='$endereco',data='$data',atual='$atual',valor='$valor',tipo='$tipo',obs='$obs' WHERE id='$id'");
	print "<script>window.location='index.php?url=orca_prev.php'</script>";
}else if($acao=="incluir"){
	$valor=valor2banco($valor);
	$data=data2banco($data);
	$sql=mysql_query("INSERT INTO cad_pres (numero,qtd,nome,endereco,data,atual,valor,tipo,obs,data_cad,usuario) VALUES('$numero','$qtd','$nome','$endereco','$data','$atual','$valor','$tipo','$obs','$hj','$usua')") or die(mysql_error());
	print "<script>window.location='index.php?url=orca_prev.php'</script>";
	//exit;
}else if($acao=="exc"){
	$id=$_GET["id"];
	$sql=mysql_query("DELETE FROM cad_pres WHERE id='$id'");
	print "<script>window.location='index.php?url=orca_prev.php'</script>";
	//exit;
}
?>
<? if($acao=="entrar"){ ?>

<h1>Previsão de Resgates</h1>
<div align="center">
  <table width="417" border="0" align="left" cellpadding="0" cellspacing="0">
    <tr>
      <th scope="col"><a href="index.php?url=orca_prev.php&acao=inc">Incluir Orçamento</a></th>
    </tr>
  </table>
  <br>
</div>
<div align="left"></div>
<? 
$sql=mysql_query("SELECT * FROM cad_pres WHERE usuario='$usua' ORDER By id DESC");
while($res=mysql_fetch_array($sql)){
  $st=""; 
  switch($res["status"]){
  	case "1";
		$st="Em Negocia&ccedil;&atilde;o";
		break;
	case "2";
		$st="Aprovado";
		break;
	case "3";
		$st="Cancelado";
		break;
  }
?>
<table width="417" border="1" cellpadding="0" cellspacing="0" bordercolor="#B5CAFF">
  <tr>
    <th scope="col"><table width="417" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="115" align="left"><strong>Nº Contrato:</strong></td>
          <td width="302" align="left" scope="col"><?= $res["numero"]; ?>
&nbsp;&nbsp;&nbsp;<strong>Nome Edifício:</strong>
            <?= $res["nome"]; ?>
</td>
        </tr>
        <tr>
          <td align="left"><strong>Qtd. Elv.: </strong></td>
          <td align="left"><?= $res["qtd"]; ?>
&nbsp;&nbsp;&nbsp;<strong>Contato:</strong>&nbsp;
            <?= $res["contato"]; ?>
            &nbsp;&nbsp;&nbsp;<strong>Data :  </strong>
            <?= banco2data($res["data"]); ?>
          </td>
        </tr>
        <tr>
          <td align="left"><strong>Atual Conserv. :</strong></td>
          <td align="left"><?= $res["atual"]; ?>
          &nbsp;&nbsp;&nbsp;<strong>Valor do Contrato:</strong>          <?= banco2valor($res["valor"]); ?>
          
          </td>
        </tr>
        <tr>
          <td align="left"><strong>Tipo Contr. :</strong></td>
          <td align="left"><?= $res["tipo"]; ?></td>
        </tr>
        <tr>
          <td align="left"><strong>Endere&ccedil;o :</strong></td>
          <td align="left"><?= $res["endereco"]; ?></td>
        </tr>
        <tr>
          <td align="left"><strong>Obs :</strong></td>
          <td align="left"><?= $res["obs"]; ?></td>
        </tr>
        <tr align="center">
          <td colspan="2"><input type="button" name="Button" value="Alterar" onClick="window.location='index.php?url=orca_prev.php&acao=alt&id=<?= $res["id"]; ?>'">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="button" name="Button2" value="Excluir" onClick="if(confirm('Deseja mesmo excluir?')){ window.location='index.php?url=orca_prev.php&acao=exc&id=<?= $res["id"]; ?>'; }"></td>
        </tr>
    </table></th>
  </tr>
</table>
<br>
<? } ?>
<h1>
  <? }else if($acao=="alt" or $acao=="inc"){ ?>
</h1>
<h1><? if($acao=="alt"){ ?>Alterar<? }else{ ?>Incluir<? } ?> Orçamento</h1>
<form name="form1" method="post" action="">
  <table width="350" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="141" align="right">Nº Contrato : </td>
      <td width="209" align="left"><? $vp->campo("text","numero",$res["numero"],"10"); ?></td>
    </tr>
	  <tr>
      <td align="right">Qtd. Elv. : </td>
      <td align="left"><? $vp->campo("text","qtd",$res["qtd"],"10"); ?></td>
    </tr>
    <tr>
      <td align="right">Nome Edifício : </td>
      <td align="left"><? $vp->campo("text","nome",$res["nome"],"40"); ?></td>
    </tr>
    <tr>
      <td align="right">Endereço :</td>
      <td align="left"><? $vp->campo("text","endereco",$res["endereco"],"40"); ?></td>
    </tr>
	 <tr>
      <td align="right">Data :</td>
      <td align="left"><? $vp->set_event("onkeypress"); $vp->set_event("onkeyup"); $vp->set_func("return validanum(this, event)"); $vp->set_func("mdata(this)"); $vp->campo("text","data",banco2data($res["data"]),"15"); ?></td>
    </tr>
	 <tr>
      <td align="right">Atual Conserv. :</td>
      <td align="left"><? $vp->campo("text","atual",$res["atual"],"20"); ?></td>
    </tr>
	<tr>
      <td align="right">Valor do Contrato :</td>
      <td align="left"><? $vp->set_event("onkeydown"); $vp->set_event("onkeyup"); $vp->set_func("formataMoeda(this,retornaKeyCode(event))"); $vp->set_func("formataMoeda(this,retornaKeyCode(event))"); $vp->campo("text","valor",banco2valor($res["valor"]),15); ?>      </td>
    </tr>
	<tr>
      <td align="right">Tipo de Contrato :</td>
      <td align="left"><? $vp->campo("text","tipo",$res["tipo"],20); ?>      </td>
    </tr>
	<tr>
      <td align="right">Obs :</td>
      <td align="left"><? $vp->campo("textarea","obs",$res["obs"],"5"); ?>      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><? if($acao=="alt"){ $acao="alterar"; }else{ $acao="incluir"; } $vp->campo("hidden","id",$id,"",0); $vp->campo("hidden","acao",$acao,"",0);  $vp->campo("submit","enviar","Enviar","",0);  ?></td>
    </tr>
  </table>
</form>
<? } ?>