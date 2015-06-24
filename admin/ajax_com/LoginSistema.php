<?
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();

if($_GET["acao"]=="user"){
	$login=$_GET["login"];
	$senha=$_GET["senha"];
    $sq = $Main->ConexaoSQL->RetornaQuantidadeQuery("SELECT * FROM usuarios WHERE login='".$login."' ");
	if($sq){
		print "<script>document.getElementById('form1').logina.disabled=true;</script>";
	}
}
if($_GET["acao"]=="senha"){
	$login=$_GET["login"];
	$senha=$_GET["senha"];
	$sq=mysql_query("SELECT * FROM usuarios WHERE login='".$login."' AND senha='".$senha."'");
	if(mysql_num_rows($sq)){
		$res = mysql_fetch_array($sq);

		$Main->ConexaoSQL->executaQuery("INSERT INTO auditoria (id_usuarios, acao, pagina, data, ip) VALUES('".$res["id"]."','login','login',NOW(),'".$_SERVER['REMOTE_ADDR']."') ");
				
        $_SESSION["logado"]=true;
        $_SESSION["iduser"]=$res["id"];
        $_SESSION["nomeuser"]=$res["nome"];
        $_SESSION["emailuser"]=$res["email"];
        $_SESSION["niveluser"]=$res["id_niveis"];

        print "1";
        
	}
}
mysql_close();
?>