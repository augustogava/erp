<?
$acao=$_REQUEST["acao"];
$id=$_REQUEST["acao"];
if(empty($acao)) $acao="entrar";
if($acao=="alt"){
	empty($_GET["id"]) ? $id=$_SESSION["iduser"] : $id=$_GET["id"];
	$res=mysql_fetch_array(mysql_query("SELECT * FROM funcionario WHERE id='$id'"));
}else if($acao=="alterar"){
	$id=$_POST["id"];
	$nascimento=data2banco($nascimento);
	$admissao=data2banco($admissao);
	$sql=mysql_query("UPDATE funcionario SET nome='$nome',nascimento='$nascimento',rg='$rg',carteira='$carteira',admissao='$admissao',cargo='$cargo',tel='$telefone',cel='$celular',email='$email',endereco='$endereco',bairro='$bairro',cep='$cep',cidade='$cidade',estado='$estado' WHERE id='$id'");
	print "<script>window.location='index.php?url=clientes.php'</script>";
}else if($acao=="incluir"){
	$nascimento=data2banco($nascimento);
	$admissao=data2banco($admissao);
	$sql=mysql_query("INSERT INTO funcionario (nome,nascimento,rg,carteira,admissao,cargo,tel,cel,email,endereco,bairro,cep,cidade,estado) VALUES('$nome','$nascimento','$rg','$carteira','$admissao','$cargo','$telefone','$celular','$email','$endereco','$bairro','$cep','$cidade','$estado')");
	print "<script>window.location='index.php?url=clientes.php'</script>";
	//exit;
}else if($acao=="log"){
	$id=$_GET["id"];
	$res=mysql_fetch_array(mysql_query("SELECT * FROM login WHERE funcionario='$id'"));
}else if($acao=="login"){
	$id=$_POST["id"];
	$sql=mysql_query("SELECT * FROM login WHERE funcionario='$id'");
	if(mysql_num_rows($sql)){
			mysql_query("UPDATE login SET senha='$senha',nivel='$nivel' WHERE funcionario='$id'");
			print "<script>window.location='index.php?url=clientes.php'</script>";
	}else{
		$sql2=mysql_query("SELECT * FROM login WHERE usuario='$usuario'");
		if(!mysql_num_rows($sql2)){
			mysql_query("INSERT INTO login (funcionario,usuario,senha,nivel) VALUES('$id','$usuario','$senha','$nivel')");
			print "<script>window.location='index.php?url=clientes.php'</script>";
		}else{
			print "<script>window.alert('Nome de usu�rio j� existente!');window.location='index.php?url=clientes.php&acao=log&id=$id'</script>";
		}
	}
}else if($acao=="exc"){
	$id=$_GET["id"];
	$sql=mysql_query("DELETE FROM funcionario WHERE id='$id'");
	print "<script>window.location='index.php?url=clientes.php'</script>";
	//exit;
}
?>
<? if($acao=="entrar"){ ?>
<h1>Funcion�rios</h1>
<div align="center">
  <table width="417" border="0" align="left" cellpadding="0" cellspacing="0">
    <tr>
      <th scope="col"><a href="index.php?url=clientes.php&acao=inc">Incluir Funcion&aacute;rio</a></th>
    </tr>
  </table>
  <br>
</div>
<div align="left"></div>
<table width="440" border="0" cellpadding="0" cellspacing="1" bgcolor="#6375D6">
<? 
$sql=mysql_query("SELECT * FROM funcionario ORDER By id ASC");
if(!mysql_num_rows($sql)){
?>
  <tr align="center" bgcolor="#FFFFFF">
    <th colspan="5" scope="col">NADA ENCONTRADO</th>
  </tr>
 <? }else{ ?>
  <tr bgcolor="#FFFFFF" class="tr">
    <td width="49">Id</td>
    <td width="334">Nome</td>
    <td width="17"></td>
    <td width="17"></td>
    <td width="17"></td>
  </tr>
  <? while($res=mysql_fetch_array($sql)){ ?>
  <tr bgcolor="#FFFFFF">
    <td><?= $res[id]; ?></td>
    <td><?= $res[nome]; ?></td>
    <td><a href="index.php?url=clientes.php&acao=alt&id=<?= $res["id"]; ?>"><img src="imagens/personaldatamanager.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
    <td><a href="index.php?url=clientes.php&acao=log&id=<?= $res["id"]; ?>"><img src="imagens/logout.gif" alt="Login" width="14" height="14" border="0"></a></td>
    <td><a href="#" onClick="if(confirm('Deseja mesmo excluir?')){ window.location='index.php?url=clientes.php&acao=exc&id=<?= $res["id"]; ?>'; }"><img src="imagens/lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
  </tr>
  <? } } ?>
</table>
<h1>
  <? }else if($acao=="alt" or $acao=="inc"){ ?>
</h1>
<h1><? if($acao=="alt"){ ?>Alterar<? }else{ ?>Incluir<? } ?> Cadastro</h1>
<form name="form1" method="post" action="">
  <table width="300" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td align="right">Nome: </td>
      <th width="207" align="left" scope="col"><? $vp->campo("text","nome",$res["nome"]); ?></th>
    </tr>
    <tr>
      <td align="right">Nascimento: </td>
      <td align="left"><? $vp->set_event("onkeypress"); $vp->set_event("onkeyup"); $vp->set_func("return validanum(this, event)"); $vp->set_func("mdata(this)"); $vp->campo("text","nascimento",banco2data($res["nascimento"]),"10"); ?></td>
    </tr>
    <tr>
      <td align="right">Rg : </td>
      <td align="left"><? $vp->campo("text","rg",$res["rg"],"15"); ?></td>
    </tr>
    <tr>
      <td align="right">Carteira :</td>
      <td align="left"><? $vp->campo("text","carteira",$res["carteira"],"15"); ?></td>
    </tr>
    <tr>
      <td align="right">Admiss&atilde;o : </td>
      <td align="left"><? $vp->set_event("onkeypress"); $vp->set_event("onkeyup"); $vp->set_func("return validanum(this, event)"); $vp->set_func("mdata(this)"); $vp->campo("text","admissao",banco2data($res["admissao"]),"10"); ?></td>
    </tr>
    <tr>
      <td align="right">Cargo : </td>
      <td align="left"><? $vp->campo("select","cargo",$res["cargo"],"20",0,"cargo","nome"); ?></td>
    </tr>
    <tr>
      <td align="right">Telefone : </td>
      <td align="left"><? $vp->campo("text","telefone",$res["tel"],"10"); ?></td>
    </tr>
    <tr>
      <td align="right">Celular : </td>
      <td align="left"><? $vp->campo("text","celular",$res["cel"],"10"); ?></td>
    </tr>
    <tr>
      <td align="right">Email : </td>
      <td align="left"><? $vp->campo("text","email",$res["email"],"20"); ?></td>
    </tr>
    <tr>
      <td align="right">Endere&ccedil;o : </td>
      <td align="left"><? $vp->campo("text","endereco",$res["endereco"],"40"); ?></td>
    </tr>
    <tr>
      <td align="right">Bairro : </td>
      <td align="left"><? $vp->campo("text","bairro",$res["bairro"],"30"); ?></td>
    </tr>
    <tr>
      <td align="right">CEP : </td>
      <td align="left"><? $vp->campo("text","cep",$res["cep"],"15"); ?></td>
    </tr>
    <tr>
      <td align="right">Cidade : </td>
      <td align="left"><?  $vp->campo("text","cidade",$res["cidade"],"20"); ?></td>
    </tr>
    <tr>
      <td align="right">Estado : </td>
      <td align="left"><? $vp->campo("select","estado",$res["estado"],"20",0,"estado","nome");  ?></td>
    </tr>
    <tr>
      <td colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><? if($acao=="alt"){ $acao="alterar"; }else{ $acao="incluir"; } $vp->campo("hidden","id",$id,"",0); $vp->campo("hidden","acao",$acao,"",0);  $vp->campo("submit","enviar","Enviar","",0);  ?></td>
    </tr>
  </table>
</form>
<? }else if($acao=="log"){ ?>
<h1>Login</h1>
<form name="form1" method="post" action="">
  <table width="300" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td align="right">Usu&aacute;rio: </td>
      <th align="left" scope="col"><? $vp->campo("text","usuario",$res["usuario"]); ?></th>
    </tr>
    <tr>
      <td align="right">Senha: </td>
      <th width="207" align="left" scope="col"><? $vp->campo("password","senha",$res["senha"]); ?></th>
    </tr>
    <tr>
      <td align="right">N&iacute;vel:</td>
      <td align="left"><? $vp->campo("select","nivel",$res["nivel"],0,0,"nivel","nome");  ?></td>
    </tr>
    <tr>
      <td colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><? $vp->campo("hidden","id",$id,"",0); $vp->campo("hidden","acao","login","",0);  $vp->campo("submit","enviar","Enviar","",0);  ?></td>
    </tr>
  </table>
</form>
<? } ?>