<?php
# - - - - - - - - - - - - - - - - ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/1/08
#  
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Classe propriedades.
 *
 * @author Augusto Gava
 * @version 1.0
 */
class PropriedadesFluxoBanco{
	var $id;
	var $bancoId;
	var $tipoFluxoId;
	var $tipoFluxoNome;
	var $tipo;
        var $status;
	var $ocorrencia;
        var $numeroDoc;
	var $valor;
	var $data;
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}

        public function getBancoId(){
		return $this->bancoId;
	}

	public function setBancoId($bancoId){
		$this->bancoId = $bancoId;
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

        public function getNumeroDoc(){
		return $this->numeroDoc;
	}

	public function setNumeroDoc($numeroDoc){
		$this->numeroDoc = $numeroDoc;
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