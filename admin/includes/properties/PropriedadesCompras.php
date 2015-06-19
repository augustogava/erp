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

class PropriedadesCompras  {

	var $id;

        var $fornecedoresNome;

        var $fornecedoresId;

	var $codigo;

        var $tipoFluxoId;

        var $tipoFluxoNome;

	var $obs;

	var $imposto;

        var $desconto;
        
        var $dataAberta;

        var $valorTotal;

        var $status;


	public function getId(){

		return $this->id;

	}
	

	public function setId($id){

		$this->id = $id;

	}

        public function getFornecedoresNome(){

		return $this->fornecedoresNome;

	}



	public function setFornecedoresNome($fornecedoresNome){

		$this->fornecedoresNome = $fornecedoresNome;

	}

        public function getFornecedoresId(){

		return $this->fornecedoresId;

	}



	public function setFornecedoresId($fornecedoresId){

		$this->fornecedoresId = $fornecedoresId;

	}

	

	public function getCodigo(){

		return $this->codigo;

	}

	

	public function setCodigo($codigo){

		$this->codigo = $codigo;

	}

        public function getTipoFluxoId(){

		return $this->tipoFluxoId;

	}


	public function setTipoFluxoId($tipoFluxo){

		$this->tipoFluxoId = $tipoFluxo;

	}

        public function getTipoFluxoNome(){

		return $this->tipoFluxoNome;

	}


	public function setTipoFluxoNome($tipoFluxo){

		$this->tipoFluxoNome = $tipoFluxo;

	}


	public function getValorTotal(){

		return $this->valorTotal;

	}


	public function setValorTotal($valorTotal){

		$this->valorTotal = $valorTotal;

	}


	public function getObs(){

		return $this->obs;

	}

	public function setObs($obs){

		$this->obs = $obs;

	}
	

	public function getDataAberta(){

		return $this->dataAberta;

	}

	

	public function setDataAberta($dataAberta){

		$this->dataAberta = $dataAberta;

	}


	public function getImposto(){

		return $this->imposto;

	}

	

	public function setImposto($Imposto){

		$this->imposto = $Imposto;

	}

        public function getDesconto(){

		return $this->desconto;

	}



	public function setDesconto($desconto){

		$this->desconto = $desconto;

	}

        public function getStatus(){

		return $this->status;

	}


	public function setStatus($status){

		$this->status = $status;

	}

}

?>