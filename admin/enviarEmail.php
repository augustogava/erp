<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

if(!empty($_GET["idCliente"])){
	$cliente = $Main->Pedidos->pegaClientes($_GET["idCliente"]);
}else{
	$cliente = "";
}

include($Main->Configuracoes->HEADER_POPBUSCA);  
?>
<div id="main-body">

	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Enviar Email</p>
			</div>
		</div>
	</div>
	<div id="contentPopUp">
	
		<div id="Saida">
			<form id="frmBusca" name="frmBusca" action="">
				Email: <br />
				<input type="text" id="email" name="email" value="<? if($cliente){ print $cliente[0]->getEmail(); }?>" style="width:98%; border: 1px solid #CFDEFF;">
				<a href="javascript:enviarEmail(<?=$_GET["id"]?>, '<?=$_GET["tipo"]?>', $('email').value)">
					<center><img src="layout/incones/enviar.png" border="0" alt="Enviar"></center>
				</a>
				<div id="saidaBusca"> </div>
			</form>
		</div>

	</div> <!-- end #content -->
	
</div> <!-- end #main-body -->

<? include($Main->Configuracoes->FOOTER_POPBUSCA); ?>




