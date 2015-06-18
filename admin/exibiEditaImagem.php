<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
$Main->AdicionaImagem();


include($Main->Configuracoes->HEADER_POPBUSCA);  

if($_POST){
	$Main->Imagem->redimensionarImagem($_FILES["arquivo"]["tmp_name"], "../img_prod/prod_".$_FILES["arquivo"]["name"], "400", "400");
	$Main->Imagem->salvaImg($_POST["campo"], $_POST["tabela"], $_POST["id"], "prod_".$_FILES["arquivo"]["name"]);
	print "<script>ajaxEfeitos.enviaValorImg('editimg_".$_POST["campo"]."', '../img_prod/prod_".$_FILES["arquivo"]["name"]."');</script>";
}
?>
<div id="main-body">
	<div id="contentPopUp">
	
		<h3 id="recent">Upload Imagem <?=ucfirst($_GET["tabela"])?></h3>
		
		<div id="Saida">
			<form id="frmBusca" name="frmBusca" action="" enctype="multipart/form-data" method="post">
				Imagem: <br />
				
				<input type="hidden" name="campo" id="campo" value="<?=$_GET["campoatual"]?>">
				<input type="hidden" name="tabela" id="tabela" value="<?=$_GET["tabela"]?>">
				<input type="hidden" name="id" id="id" value="<?=$_GET["id"]?>">
				<input type="file" name="arquivo" id="arquivo">
				<input type="submit" name="Submit" value="Enviar">
				<div id="saidaBusca"> </div>
			</form>
		</div>

	</div> <!-- end #content -->
	
</div> <!-- end #main-body -->

<? include($Main->Configuracoes->FOOTER_POPBUSCA); ?>




