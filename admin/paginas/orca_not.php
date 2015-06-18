<?
$acao=$_REQUEST["acao"];
$id=$_REQUEST["acao"];
if(empty($acao)) $acao="entrar";
$usua=$_SESSION["iduser"];
if($acao=="alt"){
	$id=$_GET["id"];
	$res=mysql_fetch_array(mysql_query("SELECT * FROM cad_cont WHERE id='$id'"));
}else if($acao=="alterar"){
	$id=$_POST["id"];
	$data=data2banco($data);
	$sql=mysql_query("UPDATE cad_cont SET contrato='$contrato',cliente='$cliente',data='$data',zona='$zona',elev='$elev',obs='$obs' WHERE id='$id'");
	print "<script>window.location='index.php?url=orca_not.php'</script>";
}else if($acao=="incluir"){
	$data=data2banco($data);
	$sql=mysql_query("INSERT INTO cad_cont (contrato,cliente,data,zona,elev,obs,usuario) VALUES('$contrato','$cliente','$data','$zona','$elev','$obs','$usua')");
	print "<script>window.location='index.php?url=orca_not.php'</script>";
	//exit;
}else if($acao=="exc"){
	$id=$_GET["id"];
	$sql=mysql_query("DELETE FROM cad_cont WHERE id='$id'");
	print "<script>window.location='index.php?url=orca_not.php'</script>";
	//exit;
}
?>
<? if($acao=="entrar"){ ?>

<h1>1º Contratação</h1>
<div align="center">
  <table width="417" border="0" align="left" cellpadding="0" cellspacing="0">
    <tr>
      <th scope="col"><a href="index.php?url=orca_not.php&acao=inc">Incluir Notícias</a></th>
    </tr>
  </table>
  <br>
</div>
<div align="left"></div>
<table width="440" border="0" cellpadding="0" cellspacing="1" bgcolor="#6375D6">
<? 
$sql=mysql_query("SELECT * FROM cad_cont ORDER By data DESC");
if(!mysql_num_rows($sql)){
?>
  <tr align="center" bgcolor="#FFFFFF">
    <th colspan="4" scope="col">NADA ENCONTRADO</th>
  </tr>
 <? }else{ ?>
  <tr bgcolor="#FFFFFF" class="tr">
    <td width="108">Data</td>
    <td width="296">Contrato</td>
    <td width="17"></td>
    <td width="14"></td>
  </tr>
  <? while($res=mysql_fetch_array($sql)){ ?>
  <tr bgcolor="#FFFFFF">
    <td><?= banco2data($res[data]); ?></td>
    <td><?= $res[contrato]; ?></td>
    <td><a href="index.php?url=orca_not.php&acao=alt&id=<?= $res["id"]; ?>"><img src="imagens/personaldatamanager.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
    <td><a href="#" onClick="if(confirm('Deseja mesmo excluir?')){ window.location='index.php?url=orca_not.php&acao=exc&id=<?= $res["id"]; ?>'; }"><img src="imagens/lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
  </tr>
  <? } } ?>
</table>
<h1>
  <? }else if($acao=="alt" or $acao=="inc"){ ?>
</h1>
<h1><? if($acao=="alt"){ ?>Alterar<? }else{ ?>Incluir<? } ?> Contratação</h1>
<form name="form1" method="post" action="">
  <table width="300" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td align="right">Contrato: </td>
      <th width="207" align="left" scope="col"><? $vp->campo("text","contrato",$res["contrato"]); ?></th>
    </tr>
    <tr>
      <td align="right">Cliente: </td>
      <td align="left"><? $vp->campo("text","cliente",$res["cliente"],"50"); ?></td>
    </tr>
    <tr>
      <td align="right">Data : </td>
      <td align="left"><? $vp->set_event("onkeypress"); $vp->set_event("onkeyup"); $vp->set_func("return validanum(this, event)"); $vp->set_func("mdata(this)"); $vp->campo("text","data",banco2data($res["data"]),"10"); ?></td>
    </tr>
    <tr>
      <td align="right">Zona :</td>
      <td align="left"><? $vp->campo("text","zona",$res["zona"],"15"); ?></td>
    </tr>
	 <tr>
      <td align="right">Elev :</td>
      <td align="left"><? $vp->campo("text","elev",$res["elev"],"15"); ?></td>
    </tr>
	<tr>
      <td align="right">Obs :</td>
      <td align="left"><? $vp->campo("textarea","obs",$res["obs"],5); ?>      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><? if($acao=="alt"){ $acao="alterar"; }else{ $acao="incluir"; } $vp->campo("hidden","id",$id,"",0); $vp->campo("hidden","acao",$acao,"",0);  $vp->campo("submit","enviar","Enviar","",0);  ?></td>
    </tr>
  </table>
</form>
<? }else if($acao=="vis"){ ?>
<h1>Visualizar</h1>
<? $sql=mysql_query("SELECT * FROM cad_cont ORder By id DESC limit 0,10"); while($res=mysql_fetch_array($sql)){ ?>
  <table width="330" border="1" cellpadding="0" cellspacing="0" bordercolor="#B5CAFF">
    <tr>
      <th scope="col"><table width="330" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="68" align="left"><strong>Contrato: </strong></td>
          <td width="332" align="left" scope="col"><?= $res["contrato"]; ?>
&nbsp;&nbsp;&nbsp;<strong>Data:</strong>
      <?= banco2data($res["data"]); ?>
&nbsp;&nbsp;&nbsp;<strong>Elev:</strong>
      <?= $res["elev"]; ?></td>
        </tr>
        <tr>
          <td align="left"><strong>Cliente: </strong></td>
          <td align="left"><?= $res["cliente"]; ?>
&nbsp;&nbsp;&nbsp;<strong>Zona:</strong>&nbsp;
      <?= $res["zona"]; ?></td>
        </tr>
        <tr>
          <td align="left"><strong>Obs :</strong></td>
          <td align="left"><?= $res["obs"]; ?></td>
        </tr>

      </table></th>
    </tr>
</table>
<br>
<? }  } ?>