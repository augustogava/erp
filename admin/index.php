<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

include($Main->Configuracoes->HEADER_NADMIN);  
?>
<div id="main-body">
	<div class="title">
		<div class="row">
	  		<div class="col-md-10">
	  			<p class="titlePage" id="recent">Index</p>
			</div>
		</div>
	</div>
	<div id="content">
	
		<div id="Saida">
			
		</div>
	</div> <!-- end #content -->
</div> <!-- end #main-body -->

<? include($Main->Configuracoes->FOOTER_NADMIN); ?>