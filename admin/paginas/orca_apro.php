<?
$acao=$_REQUEST["acao"];
$id=$_REQUEST["acao"];
$hj=date("Y-m-d");
if(empty($acao)) $acao="entrar";
$usua=$_SESSION["iduser"];
if($acao=="alt"){
	$id=$_GET["id"];
	$res=mysql_fetch_array(mysql_query("SELECT * FROM cad_orca_apro WHERE id='$id'"));
}else if($acao=="alterar"){
	$id=$_POST["id"];
	$data_apro=data2banco($data_apro);
	$valor_apro=valor2banco($valor_apro);
	$valor_orca=valor2banco($valor_orca);
	$sql=mysql_query("UPDATE cad_orca_apro SET numero='$numero',nome='$nome',n_orc='$n_orc',desc1='$desc',contato='$contato',tel='$tel',valor_orca='$valor_orca',valor_apro='$valor_apro',data_apro='$data_apro' WHERE id='$id'");
	print "<script>window.location='index.php?url=orca_apro.php'</script>";
}else if($acao=="incluir"){
	$data_apro=data2banco($data_apro);
	$valor_apro=valor2banco($valor_apro);
	$valor_orca=valor2banco($valor_orca);
	$sql=mysql_query("INSERT INTO cad_orca_apro (numero,nome,n_orc,desc1,contato,tel,valor_orca,valor_apro,data_apro,data_cad,usuario) VALUES('$numero','$nome','$n_orc','$desc','$contato','$tel','$valor_orca','$valor_apro','$data_apro','$hj','$usua')") or die(mysql_error());
	print "<script>window.location='index.php?url=orca_apro.php'</script>";
	//exit;
}else if($acao=="exc"){
	$id=$_GET["id"];
	$sql=mysql_query("DELETE FROM cad_orca_apro WHERE id='$id'");
	print "<script>window.location='index.php?url=orca_apro.php'</script>";
	//exit;
}
?>
<? if($acao=="entrar"){ ?>



<h1>Previsão de Orçamentos</h1>
<div align="center">
  <table width="417" border="0" align="left" cellpadding="0" cellspacing="0">
    <tr>
      <th scope="col"><a href="index.php?url=orca_apro.php&acao=inc">Incluir Orçamento</a></th>
    </tr>
  </table>
  <br>
</div>
<div align="left"></div>
<?
$sql=mysql_query("SELECT * FROM cad_orca_apro WHERE usuario='$usua' ORDER By id DESC");
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
            &nbsp;&nbsp;&nbsp;<strong>Data Aprov:  </strong>
            <?= banco2data($res["data_apro"]); ?>
           </td>
        </tr>
        <tr>
          <td align="left"><strong>Telefone :</strong></td>
          <td align="left"><?= $res["tel"]; ?>
          &nbsp;&nbsp;&nbsp;<strong>Valor do Or&ccedil;.:</strong>          <?= banco2valor($res["valor_orca"]); ?>
          &nbsp;&nbsp;&nbsp;&nbsp;<strong>Valor Aprov.:</strong>
          <?= banco2valor($res["valor_apro"]); ?>
          </td>
        </tr>
        <tr>
          <td align="left"><strong>Descrição :</strong></td>
          <td align="left"><?= $res["desc1"]; ?></td>
        </tr>
        <tr align="center">
          <td colspan="2"><input type="button" name="Button" value="Alterar" onClick="window.location='index.php?url=orca_apro.php&acao=alt&id=<?= $res["id"]; ?>'">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="button" name="Button2" value="Excluir" onClick="if(confirm('Deseja mesmo excluir?')){ window.location='index.php?url=orca_apro.php&acao=exc&id=<?= $res["id"]; ?>'; }"></td>
        </tr>
    </table></th>
  </tr>
</table>
<br>
<? } ?>

  <? }else if($acao=="alt" or $acao=="inc"){ ?>

<h1><? if($acao=="alt"){ ?>Alterar<? }else{ ?>Incluir<? } ?> Orçamento</h1>
<form name="form1" method="post" action="">
  <table width="380" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="141" align="right">Nº Contrato : </td>
      <td width="209" align="left"><? $vp->campo("text","numero",$res["numero"],"10"); ?></td>
    </tr>
    <tr>
      <td align="right">Nome Edifício : </td>
      <td align="left"><? $vp->campo("text","nome",$res["nome"],"40"); ?></td>
    </tr>
    <tr>
      <td align="right">N.º do Orç. :</td>
      <td align="left"><? $vp->campo("text","n_orc",$res["n_orc"],"10"); ?></td>
    </tr>
	
	 <tr>
      <td align="right">Descrição :</td>
      <td align="left"><? $vp->campo("text","desc",$res["desc1"],"40"); ?></td>
    </tr>
	<tr>
      <td align="right">Contato :</td>
      <td align="left"><? $vp->campo("text","contato",$res["contato"],"30"); ?></td>
    </tr>
	<tr>
      <td align="right">Telefone :</td>
      <td align="left"><? $vp->campo("text","tel",$res["tel"],"30"); ?></td>
    </tr>
	<tr>
      <td align="right">Valor do Orç. :</td>
      <td align="left"><? $vp->set_event("onkeydown"); $vp->set_event("onkeyup"); $vp->set_func("formataMoeda(this,retornaKeyCode(event))"); $vp->set_func("formataMoeda(this,retornaKeyCode(event))"); $vp->campo("text","valor_orca",banco2valor($res["valor_orca"]),15); ?>      </td>
    </tr>
	<tr>
      <td align="right">Valor Aprov. :</td>
      <td align="left"><? $vp->set_event("onkeydown"); $vp->set_event("onkeyup"); $vp->set_func("formataMoeda(this,retornaKeyCode(event))"); $vp->set_func("formataMoeda(this,retornaKeyCode(event))"); $vp->campo("text","valor_apro",banco2valor($res["valor_apro"]),15); ?>      </td>
    </tr>
	 <tr>
      <td align="right">Data Aprov :</td>
      <td align="left"><? $vp->set_event("onkeypress"); $vp->set_event("onkeyup"); $vp->set_func("return validanum(this, event)"); $vp->set_func("mdata(this)"); $vp->campo("text","data_apro",banco2data($res["data_apro"]),"15"); ?></td>
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