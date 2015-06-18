<?php
# - - - - - - - - - - - - - - - - ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 16/12/08
#  
#  Classe métodos email
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Classe responsável pelos metodos Email.
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
	 * Método construtor.
	 *
	 * @param ConexaoSQL conexão com o banco
	 */
    public function Email($ConexaoSQL, $Formata){
        $this->ConexaoSQL = $ConexaoSQL;
        $this->Formata = $Formata;
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