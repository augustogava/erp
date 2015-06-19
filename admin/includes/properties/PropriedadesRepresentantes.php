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
class PropriedadesRepresentantes  {
	var $id;
	var $nome;
	var $razao;
	var $endereco;
	var $telefone;
	var $cidadeId;
	var $estadoId;
	var $cidadeNome;
	var $estadoNome;
	var $cep;
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getEndereco(){
		return $this->endereco;
	}
	
	public function setEndereco($endereco){
		$this->endereco = $endereco;
	}
	
	public function getCep(){
		return $this->cep;
	}
	
	public function setCep($cep){
		$this->cep = $cep;
	}
	
	public function getTelefone(){
		return $this->telefone;
	}
	
	public function setTelefone($telefone){
		$this->telefone = $telefone;
	}
	
	public function getCidadeId(){
		return $this->cidadeId;
	}
	
	public function setCidadeId($cidadeId){
		$this->cidadeId = $cidadeId;
	}
	
	public function getEstadoId(){
		return $this->estadoId;
	}
	
	public function setEstadoId($estadoId){
		$this->estadoId = $estadoId;
	}	
	
	public function getCidadeNome(){
		return $this->cidadeNome;
	}
	
	public function setCidadeNome($cidadeNome){
		$this->cidadeNome = $cidadeNome;
	}
	
	public function getEstadoNome(){
		return $this->estadoNome;
	}
	
	public function setEstadoNome($estadoNome){
		$this->estadoNome = $estadoNome;
	}

	public function getNome(){
		return $this->nome;
	}
	
	public function setNome($nome){
		$this->nome = $nome;
	}
	
	public function getRazao(){
		return $this->razao;
	}
	
	public function setRazao($razao){
		$this->razao = $razao;
	}
	
}
?>