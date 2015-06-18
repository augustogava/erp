<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

$campos = $Main->ConexaoSQL->pegaCamposTabela($_GET["tabela"]);

include($Main->Configuracoes->HEADER_POPBUSCA);  
?>
<div id="main-body">
	<div id="contentPopUp">
	
		<h3 id="recent">Busca <?=ucfirst($_GET["tabela"])?></h3>
		
		<div id="Saida">
			<form id="frmBusca" name="frmBusca" action="">
				Busca: <br />
				<select id="campo" name="campo">
					<?
					for($i=0; $i<count($campos); $i++){
					?>
						<option value="<?=$campos[$i]?>"><?=ucfirst($campos[$i])?></option>
					<?
					}
					?>
				</select>
				<input type="text" id="valor" name="valor" style="width:98%; border: 1px solid #CFDEFF;">
				<div id="saidaBusca"> </div>
			</form>
		</div>

	</div> <!-- end #content -->
	
</div> <!-- end #main-body -->

<script>evento.adicionar($('valor'), 'keyup', function (evt) { ajaxEfeitos.gerarCombo('<?=$_GET["tabela"]?>', '<?=$_GET["campoatual"]?>'); });</script>
<? include($Main->Configuracoes->FOOTER_POPBUSCA); ?>




