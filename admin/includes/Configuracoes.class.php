<?php
# - - - - - - - - - - - - - - - -  ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/01/08
#  
#  Classe configuracoes
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Configura��es do software
 * extende a configura��o padr�o.
 *
 * @author Augusto Gava
 * @version 1.0
 */
class Configuracoes {
    //Main
    var $INCLUDE_DIR = "includes/";
    var $HEADER_N = "header.php";
    var $FOOTER_N = "footer.php";
    
    var $HEADER_NADMIN = "header.php";
    var $MENU_NADMIN = "menu_admin.php";
    var $FOOTER_NADMIN = "footer.php";
    
    var $HEADER_POPBUSCA = "headerpopbusca.php";
    var $FOOTER_POPBUSCA = "footerpopbusca.php";
    var $Local = true;
    
    var $MySQLHostname = "";
    var $MySQLUsuario = "";
    var $MySQLSenha = "";
    var $BancodeDados = "";
    
    var $TemplateArquivoEmail = "padrao/emailPadrao.html";
    var $TemplateArquivoFluxo = "padrao/fluxo.html";
    var $TemplateArquivoPedido = "padrao/pedido.html";
    var $TemplateArquivoCompra = "padrao/compra.html";
	
    public function Configuracoes(){
        session_start();
        //Banco
	    if(!$this->Local){
 		    //$this->MySQLHostname = "mysql01.multpoint.ind.br";
 		    $this->MySQLUsuario = "multpoint1";
 		    $this->MySQLSenha = "2";
 		    $this->BancodeDados = "multpoint1";
	    }else{
		    $this->MySQLHostname = "db.cmjg5io1t8yh.sa-east-1.rds.amazonaws.com";
		    $this->MySQLUsuario = "erp";
		    $this->MySQLSenha = "-";
		    $this->BancodeDados = "erp";
	    }
    }
    
}
?>