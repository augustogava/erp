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
	
		<div class="title">
			<div class="row">
		  		<div class="col-md-10">
		  			<p class="titlePage" id="recent">Busca <?=ucfirst($_GET["tabela"])?></p>
				</div>
			</div>
		</div>
		
		<div id="Saida">
			<form id="frmBusca" name="frmBusca" action="">
				<div class="form-group form-inline">
				
					<label for="campo">Busca</label>
					<select id="campo" name="campo" class="form-control input-xs">
						<?
						for($i=0; $i<count($campos); $i++){
						?>
							<option value="<?=$campos[$i]?>"><?=ucfirst($campos[$i])?></option>
						<?
						}
						?>
					</select>
					<label for="valor">Valor</label>
					<input type="text" id="valor" name="valor"  class="form-control input-xs">
				</div>
				
				<div id="saidaBusca" class="autocomplete"> </div>
			</form>
		</div>

	</div> <!-- end #content -->
	
</div> <!-- end #main-body -->

<input type="hidden" id="popup" name="popup"  value="true">

<script>evento.adicionar($('valor'), 'keyup', function (evt) { ajaxEfeitos.gerarCombo('<?=$_GET["tabela"]?>', '<?=$_GET["campoatual"]?>'); });</script>
<? include($Main->Configuracoes->FOOTER_POPBUSCA); ?>




