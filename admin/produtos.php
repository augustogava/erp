<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
$Main->DataGrid->setQuery("SELECT * from produtos ");
$Main->DataGrid->setTabela("produtos");
$Main->DataGrid->setColunas("produtos.codigo");
$Main->DataGrid->setColunas("produtos.nome.like");
$Main->DataGrid->setColunas("produtos.descricao.like");
$Main->DataGrid->setColunas("produtos.estoque_atual");

$Main->DataGrid->addCadastroExtra(array('list-ul', '../produtos_composicao.php'));

$Main->DataGrid->addCollumnsAlias( array("img"=>"Foto Produto") );
$Main->DataGrid->addCollumnsAlias( array("estoque_atual"=>"Estoque") );

$Main->DataGrid->setLimite(15);
$Main->DataGrid->setEditar("1");
$Main->DataGrid->setExcluir("1");
$Main->DataGrid->setNomeTable("tabletest");
$Main->DataGrid->setNomeDivPai("Saida");
$Main->DataGrid->setFlagRefresh(5);
$Main->DataGrid->addCamposIgnorados("estoque_atual");
$Main->DataGrid->addCollumnsCurrency("peso");

include($Main->Configuracoes->HEADER_NADMIN);  
?>
<div id="main-body">
	
	<div class="title">
		<div class="row">
	  		<div class="col-md-12">
	  			<p class="titlePage" id="recent">Produtos</p>
			</div>
		</div>
	</div>
	
	<div id="content">
	
		<?= $Main->DataGrid->montarBusca(); ?>
		
		<div id="Saida">
			<? $Main->DataGrid->montaDataGrid(); ?></div>
		</div>

	</div> <!-- end #content -->
	
	<? include($Main->Configuracoes->FOOTER_NADMIN); ?>
	
</div> <!-- end #main-body -->