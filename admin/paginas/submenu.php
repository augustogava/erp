<?
$acao=$_REQUEST["acao"];
$id=$_REQUEST["acao"];
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	empty($_GET["id"]) ? $id=$_SESSION["iduser"] : $id=$_GET["id"];
	$res=mysql_fetch_array(mysql_query("SELECT * FROM submenu WHERE id='$id'"));
}else if($acao=="alterar"){
	$id=$_POST["id"];
	$sql=mysql_query("UPDATE submenu SET nome='$nome',pai='$pai',url='$urla' WHERE id='$id'");
	print "<script>window.location='index.php?url=submenu.php'</script>";
}else if($acao=="incluir"){
	$res2=mysql_fetch_array(mysql_query("SELECT max(ordem) as ord FROM submenu WHERE pai='$pai'"));
	$ord=$res2["ord"]+1;
	$sql=mysql_query("INSERT INTO submenu (nome,pai,ordem,url) VALUES('$nome','$pai','$res2[ord]','$urla')");
	print "<script>window.location='index.php?url=submenu.php'</script>";
	//exit;
}else if($acao=="ordem"){
	$ordem=$_POST["ordem"];
	foreach($ordem as $key=>$valor){
		$sql=mysql_query("UPDATE submenu SET ordem='$valor' WHERE id='$key'");
	}
	print "<script>window.location='index.php?url=submenu.php'</script>";
	//exit;
}else if($acao=="exc"){
	$id=$_GET["id"];
	$sql=mysql_query("DELETE FROM submenu WHERE id='$id'");
	print "<script>window.location='index.php?url=submenu.php'</script>";
	//exit;
}
?>
<? if($acao=="entrar"){ ?>
<h1>Submenu</h1>
<div align="center">
  <table width="417" border="0" align="left" cellpadding="0" cellspacing="0">
    <tr>
      <th scope="col"><a href="index.php?url=submenu.php&acao=inc">Incluir Submenu</a></th>
    </tr>
  </table>
  <br>
</div>
<div align="left"></div>
<table width="496" border="0" cellpadding="0" cellspacing="1" bgcolor="#6375D6">
<? 
$sql=mysql_query("SELECT * FROM submenu ORDER By pai ASC,ordem ASC");
if(!mysql_num_rows($sql)){
?>
  <tr align="center" bgcolor="#FFFFFF">
    <th colspan="6" scope="col">NADA ENCONTRADO</th>
  </tr>
 <? }else{ ?>
  <tr bgcolor="#FFFFFF" class="tr">
    <td width="214">Nome</td>
    <td width="163" align="left">Pai</td>
    <td width="58" align="center">Ordem</td>
    <td width="16"></td>
    <td width="19"></td>
    <td width="19"></td>
  </tr>
  <? while($res=mysql_fetch_array($sql)){ $res2=mysql_fetch_array(mysql_query("SELECT nome FROM menu WHERE id='$res[pai]'")); ?>
  <tr bgcolor="#FFFFFF">
    <td><?= $res[nome]; ?></td>
    <td><?= $res2[nome]; ?></td>
    <td><?= $res[ordem]; ?></td>
    <td><a href="index.php?url=submenu.php&acao=alt&id=<?= $res["id"]; ?>"><img src="imagens/personaldatamanager.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
    <td><a href="index.php?url=submenu.php&acao=ord&id=<?= $res["id"]; ?>"><img src="imagens/visitortextmessages.gif" alt="Ordem" width="14" height="14" border="0"></a></td>
    <td><a href="#" onClick="if(confirm('Deseja mesmo excluir?')){ window.location='index.php?url=submenu.php&acao=exc&id=<?= $res["id"]; ?>'; }"><img src="imagens/lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
  </tr>
  <? } } ?>
</table>
  <? }else if($acao=="alt" or $acao=="inc"){ ?>
<h1><? if($acao=="alt"){ ?>Alterar<? }else{ ?>Incluir<? } ?> Submenu</h1>
<form name="form1" method="post" action="">
  <table width="300" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td align="right">Pai: </td>
      <th align="left" scope="col"><? $vp->campo("select","pai",$res["pai"],"20",0,"menu","nome");  ?></th>
    </tr>
    <tr>
      <td align="right">Nome: </td>
      <th align="left" scope="col"><? $vp->campo("text","nome",$res["nome"]); ?></th>
    </tr>
    <tr>
      <td align="right">URL: </td>
      <th width="207" align="left" scope="col"><? $vp->campo("text","urla",$res["url"]); ?></th>
    </tr>
    <tr>
      <td colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><? if($acao=="alt"){ $acao="alterar"; }else{ $acao="incluir"; } $vp->campo("hidden","id",$id,"",0); $vp->campo("hidden","acao",$acao,"",0);  $vp->campo("submit","enviar","Enviar","",0);  ?></td>
    </tr>
  </table>
</form>
<? }else if($acao=="ord"){ ?>
<h1>Ordem Submenu </h1>
<form name="form2" method="post" action="">
<? 
$sqla=mysql_query("SELECT * FROM menu ORDER By ordem ASC");
if(mysql_num_rows($sqla)){
	while($resa=mysql_fetch_array($sqla)){
?>
  <table width="437" border="0" cellpadding="0" cellspacing="1" bgcolor="#6375D6">
    <? 
	$sql=mysql_query("SELECT * FROM submenu WHERE pai='$resa[id]' ORDER by ordem ASC");
	if(!mysql_num_rows($sql)){
?>
    <tr align="center" bgcolor="#FFFFFF">
      <th colspan="2" scope="col">NADA ENCONTRADO</th>
    </tr>
    <? }else{ ?>
    <tr bgcolor="#FFFFFF" class="tr">
      <td width="391">Menu <?= $resa["nome"]; ?></td>
      <td width="43" align="center">Ordem</td>
    </tr>
    <? while($res=mysql_fetch_array($sql)){ ?>
    <tr bgcolor="#FFFFFF">
      <td><?= $res[nome]; ?></td>
      <td><? $id=$res["id"]; $vp->campo("text","ordem[$id]",$res["ordem"],"10"); ?></td>
    </tr>
    <? } } ?>
  </table>
  <br>
  <? } ?>
  <? $vp->campo("hidden","acao","ordem","",0);  $vp->campo("submit","enviar","Enviar","",0); ?>
  <? } ?>
</form>
<? } ?>
