<?php

// - - - - - - - - - - - - - - - - ERP - - - - - - - - - - - - - - - - - -

// ERP

//

// Copyright (c) 2008

// Author: Augusto Gava (augusto_gava@msn.com)

// Criado: 14/1/08

//

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Classe propriedades.
 *
 * @author Augusto Gava
 * @version 1.0
 */
class PropriedadesPedidos {
	var $id;
	var $codigo;
	var $clienteId;
	var $clienteNome;
	var $valorTotal;
	var $valorTotalEspecial;
	var $statusNome;
	var $statusId;
	var $representantesId;
	var $representantesNome;
	var $formaPagamento;
	var $formaPagamentoNome;
	var $tipoEntregaId;
	var $tipoEntregaNome;
	var $obs;
	var $dataFechada;
	var $dataAberta;
	var $dataEnviada;
	var $dataImposto;
	var $imposto;
	var $valorEntrega;
	var $comissao;
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getCodigo() {
		return $this->codigo;
	}
	public function setCodigo($codigo) {
		$this->codigo = $codigo;
	}
	public function getClienteId() {
		return $this->clienteId;
	}
	public function setClienteId($clienteId) {
		$this->clienteId = $clienteId;
	}
	public function getClienteNome() {
		return $this->clienteNome;
	}
	public function setClienteNome($clienteNome) {
		$this->clienteNome = $clienteNome;
	}
	public function getValorTotal() {
		return $this->valorTotal;
	}
	public function setValorTotal($valorTotal) {
		$this->valorTotal = $valorTotal;
	}
	
	public function getValorTotalEspecial() {
		return $this->valorTotalEspecial;
	}
	public function setValorTotalEspecial($valorTotalEspecial) {
		$this->valorTotalEspecial = $valorTotalEspecial;
	}
	
	public function getStatusNome() {
		return $this->statusNome;
	}
	public function setStatusNome($statusNome) {
		$this->statusNome = $statusNome;
	}
	public function getStatusId() {
		return $this->statusId;
	}
	public function setStatusId($statusId) {
		$this->statusId = $statusId;
	}
	public function getRepresentantesId() {
		return $this->representantesId;
	}
	public function setRepresentantesId($representantesId) {
		$this->representantesId = $representantesId;
	}
	public function getRepresentantesNome() {
		return $this->representantesNome;
	}
	public function setRepresentantesNome($representantesNome) {
		$this->representantesNome = $representantesNome;
	}
	public function getFormaPagamento() {
		return $this->formaPagamento;
	}
	public function setFormaPagamento($formaPagamento) {
		$this->formaPagamento = $formaPagamento;
	}
	public function getFormaPagamentoNome() {
		return $this->formaPagamentoNome;
	}
	public function setFormaPagamentoNome($formaPagamentoNome) {
		$this->formaPagamentoNome = $formaPagamentoNome;
	}
	public function getObs() {
		return $this->obs;
	}
	public function setObs($obs) {
		$this->obs = $obs;
	}
	public function getTipoEntregaId() {
		return $this->tipoEntregaId;
	}
	public function setTipoEntregaId($tipoEntregaId) {
		$this->tipoEntregaId = $tipoEntregaId;
	}
	public function getTipoEntregaNome() {
		return $this->tipoEntregaNome;
	}
	public function setTipoEntregaNome($tipoEntregaNome) {
		$this->tipoEntregaNome = $tipoEntregaNome;
	}
	public function getDataFechada() {
		return $this->dataFechada;
	}
	public function setDataFechada($dataFechada) {
		$this->dataFechada = $dataFechada;
	}
	public function getDataAberta() {
		return $this->dataAberta;
	}
	public function setDataAberta($dataAberta) {
		$this->dataAberta = $dataAberta;
	}
	public function getDataEnviada() {
		return $this->dataEnviada;
	}
	public function setDataEnviada($dataEnviada) {
		$this->dataEnviada = $dataEnviada;
	}
	public function getImposto() {
		return $this->imposto;
	}
	public function setImposto($Imposto) {
		$this->imposto = $Imposto;
	}
	public function getValorEntrega() {
		return $this->valorEntrega;
	}
	public function setValorEntrega($ValorEntrega) {
		$this->valorEntrega = $ValorEntrega;
	}
	public function getComissao() {
		return $this->comissao;
	}
	public function setComissao($Comissao) {
		$this->comissao = $Comissao;
	}
	public function getDataImposto() {
		return $this->dataImposto;
	}
	public function setDataImposto($dataImposto) {
		$this->dataImposto = $dataImposto;
	}
}

?>