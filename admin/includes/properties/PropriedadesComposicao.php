<?php
# - - - - - - - - - - - - - - - - ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/1/08
#  
#  Classe métodos
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Classe propriedades.
 *
 * @author Augusto Gava
 * @version 1.0
 */
class PropriedadesComposicao  {
	var $id;
	var $produtoId;
	var $produtoNome;
	var $qtd;
	var $descricao;
	
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
	
	public function getQtd(){
		return $this->qtd;
	}
	
	public function setQtd($qtd){
		$this->qtd = $qtd;
	}
	
	public function getDescricao(){
		return $this->descricao;
	}
	
	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}
	
}
?>