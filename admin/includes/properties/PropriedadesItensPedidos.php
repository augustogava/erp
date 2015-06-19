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
class PropriedadesItensPedidos  {
	var $id;
	var $idPedido;
	var $idProduto;
	var $produtos;
	var $qtd;
	var $preco;
	var $total;
	var $tipoComissao;
	var $valorComissao;
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getTipoComissao(){
		return $this->tipoComissao;
	}
	
	public function setTipoComissao($tipoComissao){
		$this->tipoComissao = $tipoComissao;
	}
	
	public function getValorComissao(){
		return $this->valorComissao;
	}
	
	public function setValorComissao($valorComissao){
		$this->valorComissao = $valorComissao;
	}
	
	public function getIdPedido(){
		return $this->IdPedido;
	}
	
	public function setIdPedido($IdPedido){
		$this->IdPedido = $IdPedido;
	}
	
	public function getIdProduto(){
		return $this->idProduto;
	}
	
	public function setIdProduto($idProduto){
		$this->idProduto = $idProduto;
	}
	
	public function getProdutos(){
		return $this->produtos;
	}
	
	public function setProdutos($produtos){
		$this->produtos = $produtos;
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
	
	public function getTotal(){
		return $this->total;
	}
	
	public function setTotal($total){
		$this->total = $total;
	}
}
?>