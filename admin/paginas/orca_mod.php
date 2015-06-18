<?
$acao=$_REQUEST["acao"];
$id=$_REQUEST["acao"];
$hj=date("Y-m-d");
if(empty($acao)) $acao="entrar";
$usua=$_SESSION["iduser"];
if($acao=="alt"){
	$id=$_GET["id"];
	$res=mysql_fetch_array(mysql_query("SELECT * FROM cad_orca_mod WHERE id='$id'"));
}else if($acao=="alterar"){
	$id=$_POST["id"];
	$valor=valor2banco($valor);
	$sql=mysql_query("UPDATE cad_orca_mod SET numero='$numero',nome='$nome',n_orc='$n_orc',descr='$desc',contato='$contato',tel='$tel',valor='$valor',obs='$obs',status='$status' WHERE id='$id'");
	print "<script>window.location='index.php?url=orca_mod.php'</script>";
}else if($acao=="incluir"){
	$valor=valor2banco($valor);
	$sql=mysql_query("INSERT INTO cad_orca_mod (numero,nome,n_orc,descr,contato,tel,valor,obs,status,data_cad,usuario) VALUES('$numero','$nome','$n_orc','$desc','$contato','$tel','$valor','$obs','$status','$hj','$usua')") or die(mysql_error());
	print "<script>window.location='index.php?url=orca_mod.php'</script>";
	//exit;
}else if($acao=="exc"){
	$id=$_GET["id"];
	$sql=mysql_query("DELETE FROM cad_orca_mod WHERE id='$id'");
	print "<script>window.location='index.php?url=orca_mod.php'</script>";
	//exit;
}
?>
<? if($acao=="entrar"){ ?>


<h1>Orçamentos de Modernização</h1>
<div align="center">
  <table width="417" border="0" align="left" cellpadding="0" cellspacing="0">
    <tr>
      <th scope="col"><a href="index.php?url=orca_mod.php&acao=inc">Incluir Orçamento</a></th>
    </tr>
  </table>
  <br>
</div>
<div align="left"></div>
<? 
$sql=mysql_query("SELECT * FROM cad_orca_mod WHERE usuario='$usua' ORDER By id DESC");
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
          <td width="90" align="left"><strong>Nº Contrato:</strong></td>
          <td width="327" align="left" scope="col"><?= $res["numero"]; ?>
&nbsp;&nbsp;&nbsp;<strong>Nome Edifício:</strong>
            <?= $res["nome"]; ?>
</td>
        </tr>
        <tr>
          <td align="left"><strong>N.º do Orç.: </strong></td>
          <td align="left"><?= $res["n_orc"]; ?>
&nbsp;&nbsp;&nbsp;<strong>Contato:</strong>&nbsp;
            <?= $res["contato"]; ?>
          &nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><strong>Telefone :</strong></td>
          <td align="left"><?= $res["tel"]; ?>
          &nbsp;&nbsp;&nbsp;<strong>Valor:</strong>          <?= banco2valor($res["valor"]); ?>
          &nbsp;&nbsp;<strong>Status:</strong>          <?= $st; ?></td>
        </tr>
        <tr>
          <td align="left"><strong>Descrição :</strong></td>
          <td align="left"><?= $res["descr"]; ?></td>
        </tr>
        <tr align="center">
          <td colspan="2"><input type="button" name="Button" value="Alterar" onClick="window.location='index.php?url=orca_mod.php&acao=alt&id=<?= $res["id"]; ?>'">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="button" name="Button2" value="Excluir" onClick="if(confirm('Deseja mesmo excluir?')){ window.location='index.php?url=orca_mod.php&acao=exc&id=<?= $res["id"]; ?>'; }"></td>
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
      <td width="101" align="right">N&ordm; Contrato:</td>
      <th width="199" align="left" scope="col"><? $vp->campo("text","numero",$res["numero"],"15"); ?></th>
    </tr>
    <tr>
      <td align="right">Nome Edif&iacute;cio : </td>
      <td align="left"><? $vp->campo("text","nome",$res["nome"],"50"); ?></td>
    </tr>
    <tr>
      <td align="right">Nº Orç. : </td>
      <td align="left"><? $vp->campo("text","n_orc",$res["n_orc"],"10"); ?></td>
    </tr>
    <tr>
      <td align="right">Descrição :</td>
      <td align="left"><? $vp->campo("text","desc",$res["descr"],"45"); ?></td>
    </tr>
	 <tr>
      <td align="right">Contato :</td>
      <td align="left"><? $vp->campo("text","contato",$res["contato"],"25"); ?></td>
    </tr>
	<tr>
      <td align="right">Tel :</td>
      <td align="left"><? $vp->campo("text","tel",$res["tel"],11); ?>      </td>
    </tr>
	<tr>
      <td align="right">Valor :</td>
      <td align="left"><? $vp->set_event("onkeydown"); $vp->set_event("onkeyup"); $vp->set_func("formataMoeda(this,retornaKeyCode(event))"); $vp->set_func("formataMoeda(this,retornaKeyCode(event))"); $vp->campo("text","valor",$res["valor"],10); ?>      </td>
    </tr>
	<tr>
      <td align="right">Obs :</td>
      <td align="left"><? $vp->campo("textarea","obs",$res["obs"],5); ?>      </td>
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