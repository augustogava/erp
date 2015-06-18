<?php
# - - - - - - - - - - - - - - - - ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2009
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 03/2/09
#  
#  Classe métodos ordem producao.
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Classe propriedades.
 *
 * @author Augusto Gava
 * @version 1.0
 */
class PropriedadesOrdemProducao  {
	var $id;
	var $produtos;
	var $pedidos;
	var $descricao;
	var $qtd;
	var $statusId;
	var $statusNome;
	var $data_cad;
	var $data_status;
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getProdutos(){
		return $this->produtos;
	}
	
	public function setProdutos($produtos){
		$this->produtos = $produtos;
	}
	
	public function getPedidos(){
		return $this->pedidos;
	}
	
	public function setPedidos($pedidos){
		$this->pedidos = $pedidos;
	}
	
	public function getDescricao(){
		return $this->descricao;
	}
	
	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}
	
	public function getQtd(){
		return $this->qtd;
	}
	
	public function setQtd($qtd){
		$this->qtd = $qtd;
	}
	
	public function getStatusId(){
		return $this->statusId;
	}
	
	public function setStatusId($statusId){
		$this->statusId = $statusId;
	}
	
	public function getStatusNome(){
		return $this->statusNome;
	}
	
	public function setStatusNome($statusNome){
		$this->statusNome = $statusNome;
	}
	
	public function getDataCad(){
		return $this->data_cad;
	}
	
	public function setDataCad($data_cad){
		$this->data_cad = $data_cad;
	}
	
	public function getDataStatus(){
		return $this->data_status;
	}
	
	public function setDataStatus($data_status){
		$this->data_status = $data_status;
	}

}
?>