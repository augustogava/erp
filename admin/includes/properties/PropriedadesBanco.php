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
class PropriedadesBanco{
    var $id;
    var $nome;
    var $agencia;
    var $conta;
    var $saldo;

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

    public function getAgencia(){
            return $this->agencia;
    }

    public function setAgencia($agencia){
            $this->agencia = $agencia;
    }

    public function getConta(){
            return $this->conta;
    }

    public function setConta($conta){
            $this->conta = $conta;
    }

    public function getSaldo(){
            return $this->saldo;
    }

    public function setSaldo($saldo){
            $this->saldo = $saldo;
    }
}
?>