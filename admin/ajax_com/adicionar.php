<?
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();

$RetornoConsultaRel = $Main->ConexaoSQL->Select("SELECT nome, id FROM ".$_GET["tabela"]." ORDER By id DESC LIMIT 1 ");
print "<script>selectInput.adicionarCampoSelect('".$_GET["campo"]."', ".$RetornoConsultaRel[0]['id'].", '".$RetornoConsultaRel[0]['nome']."');</script>";

mysql_close();
?>