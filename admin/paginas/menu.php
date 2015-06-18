<?
$acao=$_REQUEST["acao"];
$id=$_REQUEST["acao"];
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	empty($_GET["id"]) ? $id=$_SESSION["iduser"] : $id=$_GET["id"];
	$res=mysql_fetch_array(mysql_query("SELECT * FROM menu WHERE id='$id'"));
}else if($acao=="alterar"){
	$id=$_POST["id"];
	$sql=mysql_query("UPDATE menu SET nome='$nome' WHERE id='$id'");
	print "<script>window.location='index.php?url=menu.php'</script>";
}else if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO menu (nome) VALUES('$nome')");
	print "<script>window.location='index.php?url=menu.php'</script>";
	//exit;
}else if($acao=="ordem"){
	$ordem=$_POST["ordem"];
	foreach($ordem as $key=>$valor){
		$sql=mysql_query("UPDATE menu SET ordem='$valor' WHERE id='$key'");
	}
	print "<script>window.location='index.php?url=menu.php'</script>";
	//exit;
}else if($acao=="exc"){
	$id=$_GET["id"];
	$sql=mysql_query("DELETE FROM menu WHERE id='$id'");
	print "<script>window.location='index.php?url=menu.php'</script>";
	//exit;
}
?>
<? if($acao=="entrar"){ ?>
<h1>Menu</h1>
<div align="center">
  <table width="417" border="0" align="left" cellpadding="0" cellspacing="0">
    <tr>
      <th scope="col"><a href="index.php?url=menu.php&acao=inc">Incluir Menu</a></th>
    </tr>
  </table>
  <br>
</div>
<div align="left"></div>
<table width="437" border="0" cellpadding="0" cellspacing="1" bgcolor="#6375D6">
<? 
$sql=mysql_query("SELECT * FROM menu ORDER By Ordem ASC");
if(!mysql_num_rows($sql)){
?>
  <tr align="center" bgcolor="#FFFFFF">
    <th colspan="5" scope="col">NADA ENCONTRADO</th>
  </tr>
 <? }else{ ?>
  <tr bgcolor="#FFFFFF" class="tr">
    <td width="319">Nome</td>
    <td width="58" align="center">Ordem</td>
    <td width="16"></td>
    <td width="19"></td>
    <td width="19"></td>
  </tr>
  <? while($res=mysql_fetch_array($sql)){ ?>
  <tr bgcolor="#FFFFFF">
    <td><?= $res[nome]; ?></td>
    <td><?= $res[ordem]; ?></td>
    <td><a href="index.php?url=menu.php&acao=alt&id=<?= $res["id"]; ?>"><img src="imagens/personaldatamanager.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
    <td><a href="index.php?url=menu.php&acao=ord&id=<?= $res["id"]; ?>"><img src="imagens/visitortextmessages.gif" alt="Ordem" width="14" height="14" border="0"></a></td>
    <td><a href="#" onClick="if(confirm('Deseja mesmo excluir?')){ window.location='index.php?url=menu.php&acao=exc&id=<?= $res["id"]; ?>'; }"><img src="imagens/lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
  </tr>
  <? } } ?>
</table>
  <? }else if($acao=="alt" or $acao=="inc"){ ?>
<h1><? if($acao=="alt"){ ?>Alterar<? }else{ ?>Incluir<? } ?> Menu</h1>
<form name="form1" method="post" action="">
  <table width="300" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td align="right">Nome: </td>
      <th width="207" align="left" scope="col"><? $vp->campo("text","nome",$res["nome"]); ?></th>
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
<h1>Ordem Menu </h1>
<form name="form2" method="post" action="">
  <table width="437" border="0" cellpadding="0" cellspacing="1" bgcolor="#6375D6">
    <? 
$sql=mysql_query("SELECT * FROM menu ORDER By Ordem ASC");
if(!mysql_num_rows($sql)){
?>
    <tr align="center" bgcolor="#FFFFFF">
      <th colspan="2" scope="col">NADA ENCONTRADO</th>
    </tr>
    <? }else{ ?>
    <tr bgcolor="#FFFFFF" class="tr">
      <td width="391">Nome</td>
      <td width="43" align="center">Ordem</td>
    </tr>
    <? while($res=mysql_fetch_array($sql)){ ?>
    <tr bgcolor="#FFFFFF">
      <td><?= $res[nome]; ?></td>
      <td><? $id=$res["id"]; $vp->campo("text","ordem[$id]",$res["ordem"],"10"); ?></td>
    </tr>
    <? } } ?>
    <tr align="center" bgcolor="#FFFFFF">
      <th colspan="2" scope="col"><? $vp->campo("hidden","acao","ordem","",0);  $vp->campo("submit","enviar","Enviar","",0); ?></th>
    </tr>
  </table>
</form>
<? } ?>
