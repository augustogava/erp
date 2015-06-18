<?
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
//Chama Cadastro
$Main->AdicionaCadastrousuario();

header("Content-Type: text/html;  charset=ISO-8859-1",true);

$cep = $_GET["cep"];
   
$resultado_busca = $Main->CadastroUsuario->BuscaCep($cep);  
if($resultado_busca[resultado])
	print "<script>
	$('endereco').value = '$resultado_busca[logradouro]';
	$('bairro').value = '$resultado_busca[bairro]';
	$('cidade').value = '$resultado_busca[cidade]';
	$('estado').value = '$resultado_busca[uf]';
	$('infoCEP').innerHTML = '';
	</script>";
else
	print "<script>$('infoCEP').innerHTML = 'CEP incorreto, tente novamente ou entre com os dados manualmente';</script>";
?>