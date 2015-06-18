<?
$acao=$_REQUEST["acao"];
$id=$_REQUEST["acao"];
$hj=date("Y-m-d");
if(empty($acao)) $acao="entrar";
$usua=$_SESSION["iduser"];
if($acao=="alt"){
	$id=$_GET["id"];
	$res=mysql_fetch_array(mysql_query("SELECT * FROM cad_cont_op WHERE id='$id'"));
}else if($acao=="alterar"){
	$id=$_POST["id"];
	$data=data2banco($data);
	$valor=valor2banco($valor);
	$sql=mysql_query("UPDATE cad_cont_op SET ctr_r='$ctr',edificio='$edificio',qtd='$qtd',data='$data',valor='$valor',tipo='$tipo',status='$status' WHERE id='$id'");
	print "<script>window.location='index.php?url=orca_op.php'</script>";
}else if($acao=="incluir"){
	$valor=valor2banco($valor);
	$data=data2banco($data);
	$sql=mysql_query("INSERT INTO cad_cont_op (ctr_r,edificio,qtd,data,valor,tipo,status,data_cad,usuario) VALUES('$ctr','$edificio','$qtd','$data','$valor','$tipo','$status','$hj','$usua')") or die(mysql_error());
	print "<script>window.location='index.php?url=orca_op.php'</script>";
	//exit;
}else if($acao=="exc"){
	$id=$_GET["id"];
	$sql=mysql_query("DELETE FROM cad_cont_op WHERE id='$id'");
	print "<script>window.location='index.php?url=orca_op.php'</script>";
	//exit;
}
?>
<? if($acao=="entrar"){ ?>

<h1>Órgão Publico</h1>
<div align="center">
  <table width="417" border="0" align="left" cellpadding="0" cellspacing="0">
    <tr>
      <th scope="col"><a href="index.php?url=orca_op.php&acao=inc">Incluir Orçamento</a></th>
    </tr>
  </table>
  <br>
</div>
<div align="left"></div>
<? 
$sql=mysql_query("SELECT * FROM cad_cont_op WHERE usuario='$usua' ORDER By id DESC");
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
          <td width="90" align="left"><strong>Ctr:</strong></td>
          <td width="327" align="left" scope="col"><?= $res["ctr_r"]; ?>
&nbsp;&nbsp;&nbsp;<strong>Cliente Edifício:</strong>
            <?= $res["edificio"]; ?>
</td>
        </tr>
        <tr>
          <td align="left"><strong>Qtd.: </strong></td>
          <td align="left"><?= $res["qtd"]; ?>
&nbsp;&nbsp;&nbsp;<strong>Data Vigênc:</strong>&nbsp;
            <?= banco2data($res["data"]); ?>
            &nbsp;&nbsp;&nbsp;<strong>Valor Mensal:  </strong>
            <?= banco2valor($res["valor"]); ?>
          </td>
        </tr>
        <tr>
          <td align="left"><strong>Tp.Contr. :</strong></td>
          <td align="left"><?= $res["tipo"]; ?>
          &nbsp;&nbsp;&nbsp;<strong>Status.:</strong>          <?= $st; ?></td>
        </tr>
        <tr align="center">
          <td colspan="2"><input type="button" name="Button" value="Alterar" onClick="window.location='index.php?url=orca_op.php&acao=alt&id=<?= $res["id"]; ?>'">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="button" name="Button2" value="Excluir" onClick="if(confirm('Deseja mesmo excluir?')){ window.location='index.php?url=orca_op.php&acao=exc&id=<?= $res["id"]; ?>'; }"></td>
        </tr>
    </table></th>
  </tr>
</table>
<br>
<? } ?>

  <? }else if($acao=="alt" or $acao=="inc"){ ?>

<h1><? if($acao=="alt"){ ?>Alterar<? }else{ ?>Incluir<? } ?> Orçamento</h1>
<form name="form1" method="post" action="">
  <table width="350" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="101" align="right">Ctr : </td>
      <td width="199" align="left"><? $vp->campo("text","ctr",$res["ctr_r"],"50"); ?></td>
    </tr>
    <tr>
      <td align="right">Cliente Edifício : </td>
      <td align="left"><? $vp->campo("text","edificio",$res["edificio"],"40"); ?></td>
    </tr>
    <tr>
      <td align="right">Qtd :</td>
      <td align="left"><? $vp->campo("text","qtd",$res["qtd"],"15"); ?></td>
    </tr>
	 <tr>
      <td align="right">Data Vigênc :</td>
      <td align="left"><? $vp->set_event("onkeypress"); $vp->set_event("onkeyup"); $vp->set_func("return validanum(this, event)"); $vp->set_func("mdata(this)"); $vp->campo("text","data",banco2data($res["data"]),"15"); ?></td>
    </tr>
	<tr>
      <td align="right">Valor Mensal :</td>
      <td align="left"><? $vp->set_event("onkeydown"); $vp->set_event("onkeyup"); $vp->set_func("formataMoeda(this,retornaKeyCode(event))"); $vp->set_func("formataMoeda(this,retornaKeyCode(event))"); $vp->campo("text","valor",$res["valor"],15); ?>      </td>
    </tr>
	<tr>
      <td align="right">Tp.Contr. :</td>
      <td align="left"><? $vp->campo("text","tipo",$res["tipo"],20); ?>      </td>
    </tr>
	<tr>
      <td align="right">Status :</td>
      <td align="left"><select name="status" id="status">
        <option>Selecione</option>
        <option value="1" <? if($res["status"]==1) print "selected"; ?>>Em Negocia&ccedil;&atilde;o</option>
        <option value="2" <? if($res["status"]==2) print "selected"; ?>>Aprovado</option>
        <option value="3" <? if($res["status"]==3) print "selected"; ?>>Cancelado</option>
      </select></td>
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