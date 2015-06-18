<?
include("../classes/conecta.php");
header("Content-Type: text/html;  charset=ISO-8859-1",true);
if($acao=="user"){
	$login=$_GET["login"];
	$senha=$_GET["senha"];
	$sq=mysql_query("SELECT * FROM login WHERE usuario='$login'");
	if(!mysql_num_rows($sq)){
		print "<font color=red>Usuário não cadastrado!</font>";
	}else{
		print "<script>document.getElementById('form1').logina.disabled=true;</script>";
	}
}
if($acao=="senha"){
	$login=$_GET["login"];
	$senha=$_GET["senha"];
	$sq=mysql_query("SELECT funcionario.nome,funcionario.id,funcionario.email,nivel.nome as nnome FROM login,funcionario,nivel WHERE login.usuario='$login' AND login.senha='$senha' AND funcionario.id=login.funcionario AND login.nivel=nivel.id");
	if(mysql_num_rows($sq)){
		
			$res=mysql_fetch_array($sq);
			$sq1=mysql_query("SELECT * FROM online WHERE user='$res[id]'");
			if(!mysql_num_rows($sq1)){
			//Sessoes
				$_SESSION["logado"]=true;
				$_SESSION["iduser"]=$res["id"];
				$_SESSION["nomeuser"]=$res["nome"];
				$_SESSION["emailuser"]=$res["email"];
				$_SESSION["niveluser"]=$res["nnome"];
			//
				print "1";
			}else{
				print "2";
			}
	}
}
mysql_close();
?>