<?php
# - - - - - - - - - - - - - - - - ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 16/12/08
#  
#  Classe m�todos email
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Classe respons�vel pelos metodos Email.
 *
 * @author Augusto Gava
 * @version 1.0
 */
 

class Email  {
	private $assunto;
    private $conteudo;
    private $destinatario;
    private $remetente;
	
    /**
	 * M�todo construtor.
	 *
	 * @param ConexaoSQL conex�o com o banco
	 */
    public function Email($ConexaoSQL){
        $this->ConexaoSQL = $ConexaoSQL;
    }
    
	/**
	* Excluir estoque
	* @param $id
	*/
	public function enviarEmail(){
        mail($this->destinatario,$this->assunto,$this->conteudo,"From: ".$this->remetente."\nContent-type: text/html");
	}
	
	
	public function setAssunto($assunto){
		$this->assunto = $assunto;
	}
	
	public function setConteudo($conteudo){
		$this->conteudo = $conteudo;
	}
	
	public function setDestinatario($destinatario){
		$this->destinatario = $destinatario;
	}
	
	public function setRemetente($remetente){
		$this->remetente = $remetente;
	}
	
	
}
?>