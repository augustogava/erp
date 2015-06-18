<?
header("Content-Type: text/html;  charset=ISO-8859-1",true);
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();

if($_GET["acao"]=="pegaCidades"){
	
    $RetornoConsultaRel = $Main->ConexaoSQL->Select("SELECT * FROM cidade WHERE id_estado = '".$_GET["estado"]."' ");
   	
    $html = "<select name=\"edit_id_cidade\" id=\"edit_id_cidade\" title=\"Cidade\" class=\"efeitos\">";
    $html .= "<option value=\"\">Selecione</option>";
	for($j=0; $j<count($RetornoConsultaRel); $j++){
		$html .= "<option value=\"".$RetornoConsultaRel[$j]['id']."\">".$RetornoConsultaRel[$j][nome]."</option>";
	}
	if(count($RetornoConsultaRel) == 0)
		$html .= "<select value=\"\">Busca não resultou em nada.</select>";
	$html .= "</select>";
	
	print "<script>$('td_id_cidade').innerHTML = '".$html."'</script>";
	
}
mysql_close();
?>