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
class PropriedadesProdutos  {
	var $id;
	var $idUsuarios;
	var $idCategorias;
	var $codigo;
	var $nome;
	var $descricao;
	var $preco1;
	var $preco2;
	var $preco3;
	var $preco4;
	var $estoqueAtual;
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getIdUsuarios(){
		return $this->idUsuarios;
	}
	
	public function setIdUsuarios($idUsuarios){
		$this->idUsuarios = $idUsuarios;
	}
	
	public function getIdCategorias(){
		return $this->idCategorias;
	}
	
	public function setIdCategorias($idCategorias){
		$this->idCategorias = $idCategorias;
	}
	
	public function getCodigo(){
		return $this->codigo;
	}
	
	public function setCodigo($codigo){
		$this->codigo = $codigo;
	}
	
	public function getNome(){
		return $this->nome;
	}
	
	public function setNome($nome){
		$this->nome = $nome;
	}
	
	public function getDescricao(){
		return $this->descricao;
	}
	
	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}
	
	public function getPreco1(){
		return $this->preco1;
	}
	
	public function setPreco1($preco1){
		$this->preco1 = $preco1;
	}
	
	public function getPreco2(){
		return $this->preco2;
	}
	
	public function setPreco2($preco2){
		$this->preco2 = $preco2;
	}
	
	public function getPreco3(){
		return $this->preco3;
	}
	
	public function setPreco3($preco3){
		$this->preco3 = $preco3;
	}
	
	public function getPreco4(){
		return $this->preco4;
	}
	
	public function setPreco4($preco4){
		$this->preco4 = $preco4;
	}
	
	public function getEstoqueAtual(){
		return $this->estoqueAtual;
	}
	
	public function setEstoqueAtual($estoqueAtual){
		$this->estoqueAtual = $estoqueAtual;
	}
	
}
?>