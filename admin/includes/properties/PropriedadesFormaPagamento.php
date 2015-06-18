<?php
# - - - - - - - - - - - - - - - - ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 24/11/08
#  
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Classe propriedades.
 *
 * @author Augusto Gava
 * @version 1.0
 */
class PropriedadesFormaPagamento  {
	var $id;
	var $nome;
	var $qtd;
	var $parcelas;
        var $data;
        var $valor;
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getNome(){
		return $this->nome;
	}
	
	public function setNome($nome){
		$this->nome = $nome;
	}
	
	public function getQtd(){
		return $this->qtd;
	}
	
	public function setQtd($qtd){
		$this->qtd = $qtd;
	}
	
	public function getParcelas(){
		return $this->parcelas;
	}
	
	public function setParcelas($parcelas){
		$this->parcelas = $parcelas;
	}

        public function getData(){
		return $this->data;
	}

	public function setData($data){
		$this->data = $data;
	}

        public function getValor(){
		return $this->valor;
	}

	public function setValor($valor){
		$this->valor = $valor;
	}
	
}
?>