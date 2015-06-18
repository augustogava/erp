<?
header("Content-Type: text/html;  charset=ISO-8859-1",true);
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();

if($_GET["tipo"]=="autoComplete"){
	if(!empty($_GET["valor"]))
		$query = " AND ".$_GET["campo"]." LIKE '%".$_GET["valor"]."%'";
	
    $RetornoConsultaRel = $Main->ConexaoSQL->Select("SELECT * FROM ".$_GET["tabela"]." WHERE 1 ".$query." Limit 9 ");
    print "<ul>";
	for($j=0; $j<count($RetornoConsultaRel); $j++){
		print "<li onClick=\"ajaxEfeitos.enviaValor('".$_GET["campoatual"]."', ".$RetornoConsultaRel[$j]['id'].");\">".$RetornoConsultaRel[$j][$_GET["campo"]]."</li>";
	}
	if(count($RetornoConsultaRel) == 0)
		print "<li>Busca não resultou em nada.<li>";
	print "</ul>";
}
mysql_close();
?>