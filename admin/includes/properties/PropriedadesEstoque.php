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
class PropriedadesEstoque  {
	var $id;
	var $produtoId;
	var $produtoNome;
	var $tipo;
	var $qtd;
	var $preco;
	var $descricao;
	var $data;
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getProdutoId(){
		return $this->produtoId;
	}
	
	public function setProdutoId($produtoId){
		$this->produtoId = $produtoId;
	}
	
	public function getProdutoNome(){
		return $this->produtoNome;
	}
	
	public function setProdutoNome($produtoNome){
		$this->produtoNome = $produtoNome;
	}
	
	public function getTipo(){
		return $this->tipo;
	}
	
	public function setTipo($tipo){
		$this->tipo = $tipo;
	}
	
	public function getQtd(){
		return $this->qtd;
	}
	
	public function setQtd($qtd){
		$this->qtd = $qtd;
	}
	
	public function getPreco(){
		return $this->preco;
	}
	
	public function setPreco($preco){
		$this->preco = $preco;
	}
	
	public function getDescricao(){
		return $this->descricao;
	}
	
	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}
	
	public function getData(){
		return $this->data;
	}
	
	public function setData($data){
		$this->data = $data;
	}
}
?>