<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
if($_GET["acao"] == "exportar"){

	$Main->Compras->exportar($_GET["fornecedores"], $_GET["dataIni"], $_GET["dataFim"], $_GET["codigo"], $_GET["ordem"], $_GET["tipoOrdem"], $_GET["campo"], $_GET["tipoR"]);
	
	if($_GET["campo"] == "html")
		include($Main->Configuracoes->HEADER_POPBUSCA);  
	
	exit;
	
}else{
	include($Main->Configuracoes->HEADER_POPBUSCA);  
}


?>
<div id="main-body">

	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Exportação</p>
			</div>
		</div>
	</div>
		
	<div id="contentPopUp">
	
		<div id="Saida">
			<select id="campo" name="campo" style="width: 100%">
				<option value="">Selecione</option>
				<option value="csv">CSV</option>
				<option value="pdf">PDF</option>
				<option value="html">HTML</option>
				<option value="excel">EXCEL</option>
			</select>
		</div>

	</div> <!-- end #content -->
	
</div> <!-- end #main-body -->

<script>
evento.adicionar($('campo'), 'change', function (evt) { 
	if($('campo').value == "html"){
		main.openWindow('exportarCompras.php?<?=$_SERVER["argv"][0]?>&acao=exportar&campo=' + $('campo').value, '600', '500');
	}else{
window.location ='exportarCompras.php?<?=$_SERVER["argv"][0]?>&acao=exportar&campo=' + $('campo').value;
	}
}
														 );
</script>
