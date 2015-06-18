<?
$acao=$_REQUEST["acao"];
$id=$_REQUEST["acao"];
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	empty($_GET["id"]) ? $id=$_SESSION["iduser"] : $id=$_GET["id"];
	$res=mysql_fetch_array(mysql_query("SELECT * FROM nivel WHERE id='$id'"));
}else if($acao=="alterar"){
	$id=$_POST["id"];
	$menus=implode(",",$menu);
	$submenus=implode(",",$submenu);
	$sql=mysql_query("UPDATE nivel SET nome='$nome',menu='$menus',submenu='$submenus' WHERE id='$id'");
	print "<script>window.location='index.php?url=nivel.php'</script>";
}else if($acao=="incluir"){
	$menus=implode(",",$menu);
	$submenus=implode(",",$submenu);
	$sql=mysql_query("INSERT INTO nivel (nome,menu,submenu) VALUES('$nome','$menus','$submenus')");
	print "<script>window.location='index.php?url=nivel.php'</script>";
	//exit;
}else if($acao=="exc"){
	$id=$_GET["id"];
	$sql=mysql_query("DELETE FROM nivel WHERE id='$id'");
	print "<script>window.location='index.php?url=nivel.php'</script>";
	//exit;
}
?>
<? if($acao=="entrar"){ ?>
<h1>Nível</h1>
<div align="center">
  <table width="400" border="0" align="left" cellpadding="0" cellspacing="0">
    <tr>
      <th scope="col"><a href="index.php?url=nivel.php&acao=inc">Incluir Submenu</a></th>
    </tr>
  </table>
  <br>
</div>
<div align="left"></div>
<table width="400" border="0" cellpadding="0" cellspacing="1" bgcolor="#6375D6">
<? 
$sql=mysql_query("SELECT * FROM nivel ORDER By nome");
if(!mysql_num_rows($sql)){
?>
  <tr align="center" bgcolor="#FFFFFF">
    <th colspan="6" scope="col">NADA ENCONTRADO</th>
  </tr>
 <? }else{ ?>
  <tr bgcolor="#FFFFFF" class="tr">
    <td width="368">Nome</td>
    <td width="14"></td>
    <td width="14"></td>
  </tr>
  <? while($res=mysql_fetch_array($sql)){  ?>
  <tr bgcolor="#FFFFFF">
    <td><?= $res[nome]; ?></td>
    <td><a href="index.php?url=nivel.php&acao=alt&id=<?= $res["id"]; ?>"><img src="imagens/personaldatamanager.gif" alt="Alterar" width="14" height="14" border="0"></a></td>

    <td><a href="#" onClick="if(confirm('Deseja mesmo excluir?')){ window.location='index.php?url=nivel.php&acao=exc&id=<?= $res["id"]; ?>'; }"><img src="imagens/lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
  </tr>
  <? } } ?>
</table>
  <? }else if($acao=="alt" or $acao=="inc"){ ?>
<h1><? if($acao=="alt"){ ?>Alterar<? }else{ ?>Incluir<? } ?> Nível</h1>
<form name="form1" method="post" action="">
  <table width="300" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td align="right">Nome: </td>
      <th align="left" scope="col"><? $vp->campo("text","nome",$res["nome"]); ?></th>
    </tr>
    <tr>
      <td align="right" valign="top">Menus: </td>
      <th align="left" scope="col"><select name="menu[]" size="6" multiple>
	 	 <?
		 	$mn=explode(",",$res["menu"]);
	  		$q=mysql_query("SELECT * FROM menu ORDER By nome");
			while($r=mysql_fetch_array($q)){
		?>
		<option value="<?= $r["id"] ?>" <? if(in_array($r["id"],$mn)) print "selected"; ?>><?= $r["nome"] ?></option>";
		<? } ?>
      </select></th>
    </tr>
    <tr>
      <td align="right" valign="top">Submenus: </td>
      <th width="207" align="left" scope="col"><select name="submenu[]" size="6" multiple>
	   <?
		 	$mn=explode(",",$res["submenu"]);
	  		$q=mysql_query("SELECT * FROM submenu ORDER By nome");
			while($r=mysql_fetch_array($q)){
				$res2=mysql_fetch_array(mysql_query("SELECT nome FROM menu WHERE id='$r[pai]'"));
		?>
		<option value="<?= $r["id"]; ?>" <? if(in_array($r["id"],$mn)) print "selected"; ?>><?= $res2["nome"]." - ".$r["nome"]; ?></option>";
		<? } ?>
      </select></th>
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
