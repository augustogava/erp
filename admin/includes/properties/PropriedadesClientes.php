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
class PropriedadesClientes  {
	var $id;
	var $nome;
	var $razao;
	var $idRepresentante;
	var $email;
	var $endereco;
	var $cep;
	var $bairro;
	var $cidade;
	var $estado;
	var $cnpj;
	var $ie;
	var $contato;
	var $telefone;
	var $transportadora;
	
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
	
	public function getRazao(){
		return $this->razao;
	}
	
	public function setRazao($razao){
		$this->razao = $razao;
	}
	
	public function getIdRepresentante(){
		return $this->idRepresentante;
	}
	
	public function setiIdRepresentante($idRepresentante){
		$this->idRepresentante = $idRepresentante;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	public function setEmail($email){
		$this->email = $email;
	}
	
	
	
	public function getEndereco(){
		return $this->endereco;
	}
	
	public function setEndereco($endereco){
		$this->endereco = $endereco;
	}
	
	public function getBairro(){
		return $this->bairro;
	}
	
	public function setBairro($bairro){
		$this->bairro = $bairro;
	}
	
	
	public function getCidade(){
		return $this->cidade;
	}
	
	public function setCidade($cidade){
		$this->cidade = $cidade;
	}
	
	public function getEstado(){
		return $this->estado;
	}
	
	public function setEstado($estado){
		$this->estado = $estado;
	}
	
	
	public function getCnpj(){
		return $this->cnpj;
	}
	
	public function setCnpj($cnpj){
		$this->cnpj = $cnpj;
	}
	
	
	
	public function getIe(){
		return $this->ie;
	}
	
	public function setIe($ie){
		$this->ie = $ie;
	}
	
	
	public function getContato(){
		return $this->contato;
	}
	
	public function setContato($contato){
		$this->contato = $contato;
	}
	
	
	public function getTelefone(){
		return $this->telefone;
	}
	
	public function setTelefone($telefone){
		$this->telefone = $telefone;
	}
	
	public function getcep(){
		return $this->cep;
	}
	
	public function setCep($cep){
		$this->cep = $cep;
	}	
	
	public function getTransportadora(){
		return $this->transportadora;
	}
	
	public function setTransportadora($transportadora){
		$this->transportadora = $transportadora;
	}	
	
}
?>