<?php
# - - - - - - - - - - - - - - - - ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/01/08
#  
#  Classe m�todos seguran�a
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Classe respons�vel pelos recursos de seguran�a
 *
 * @author Augusto Gava
 * @version 1.0
 */
class Seguranca  {
	public $email;
	public $senha;
    public $ConexaoSQL;
	
    /**
	 * M�todo construtor.
	 *
	 * @param ConexaoSQL conex�o com o banco
	 */
    public function Seguranca($ConexaoSQL){
        $this->ConexaoSQL = $ConexaoSQL;
    }//end function
    
    /**
	 * Verifica se usu�rio final est� com acesso.
	 *
	 * @return true or false
	 */
	public function verificaLogado(){
		if(!$_SESSION["logado"]){
			header("Location:login.php");
			exit;
		} 
	}//end function
    
    /**
	 * M�todo Logoff.
	 *
	 */
	public function logoffsite(){
		unset($_SESSION["logado"],$_SESSION["iduser"],$_SESSION["nomeuser"],$_SESSION["emailuser"],$_SESSION["niveluser"]);
		header("Location: index.php");
		exit;
	}//end function
}
?>