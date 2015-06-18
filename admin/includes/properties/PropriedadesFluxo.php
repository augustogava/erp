<?php
# - - - - - - - - - - - - - - - - ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/1/08
#  
#  Classe métodos segurança
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Classe propriedades.
 *
 * @author Augusto Gava
 * @version 1.0
 */
class PropriedadesFluxo{
	var $id;
	var $clienteId;
	var $clienteNome;
	var $fornecedorId;
	var $fornecedorNome;
	var $tipoFluxoId;
	var $tipoFluxoNome;
	var $tipo;
	var $ocorrencia;
	var $valor;
	var $data;
        var $status;
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getClienteId(){
		return $this->clienteId;
	}
	
	public function setClienteId($clienteId){
		$this->clienteId = $clienteId;
	}
	
	public function getClienteNome(){
		return $this->clienteNome;
	}
	
	public function setClienteNome($clienteNome){
		$this->clienteNome = $clienteNome;
	}
	
	public function getFornecedorId(){
		return $this->fornecedorId;
	}
	
	public function setFornecedorId($fornecedorId){
		$this->fornecedorId = $fornecedorId;
	}
	
	public function getFornecedorNome(){
		return $this->fornecedorNome;
	}
	
	public function setFornecedorNome($fornecedorNome){
		$this->fornecedorNome = $fornecedorNome;
	}

	public function getTipoFluxoId(){
		return $this->tipoFluxoId;
	}
	
	public function setTipoFluxoId($tipoFluxoId){
		$this->tipoFluxoId = $tipoFluxoId;
	}
	
	public function getTipoFluxoNome(){
		return $this->tipoFluxoNome;
	}
	
	public function setTipoFluxoNome($tipoFluxoNome){
		$this->tipoFluxoNome = $tipoFluxoNome;
	}
	
	public function getTipo(){
		return $this->tipo;
	}
	
	public function setTipo($tipo){
		$this->tipo = $tipo;
	}
	
	public function getOcorrencia(){
		return $this->ocorrencia;
	}
	
	public function setOcorrencia($ocorrencia){
		$this->ocorrencia = $ocorrencia;
	}
	
	public function getValor(){
		return $this->valor;
	}
	
	public function setValor($valor){
		$this->valor = $valor;
	}
	
	public function getData(){
		return $this->data;
	}
	
	public function setData($data){
		$this->data = $data;
	}

        public function getStatus(){
		return $this->status;
	}
	
	public function setStatus($status){
		$this->status = $status;
	}
}
?>