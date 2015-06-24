<?php
# - - - - - - - - - - - - - - - - ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/1/08
#  
#  Classe m?todos seguran?a
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Classe respons?vel pelos metodos Fluxo.
 *
 * @author Augusto Gava
 * @version 1.0
 */
 
include_once("properties/PropriedadesFluxoBanco.php");
include_once("properties/PropriedadesBanco.php");
include_once("properties/PropriedadesPadrao.php");

class FluxoBanco  {
	public $ConexaoSQL;
	
    /**
	 * M?todo construtor.
	 *
	 * @param ConexaoSQL conex?o com o banco
	 */
    public function FluxoBanco($ConexaoSQL){
        $this->ConexaoSQL = $ConexaoSQL;
    }
   
    /**
    * retorna lista de entrada e saida .
    *@param clientes.
    *@param status.
    *@return array clientes.
    */
    public function pegaBancos($id = ""){

        if(!empty($id))
            $busca .= " AND id = '".$id."' ";

        $query = "SELECT * FROM bancos WHERE 1 ".$busca." ORDER By nome ASC";

        //print $query;
        $RetornoConsultaRel = $this->ConexaoSQL->Select($query);

        if(count($RetornoConsultaRel) > 0){
                for($j=0; $j<count($RetornoConsultaRel); $j++){
                        $Retorno[$j] = new PropriedadesBanco();
                        $Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
                        $Retorno[$j]->setNome($RetornoConsultaRel[$j]["nome"]);
                        $Retorno[$j]->setAgencia($RetornoConsultaRel[$j]["agencia"]);
                        $Retorno[$j]->setConta($RetornoConsultaRel[$j]["conta"]);
                        $Retorno[$j]->setSaldo($RetornoConsultaRel[$j]["saldo_atual"]);
                }
        }

        return $Retorno;

    }

    /**
	* retorna lista de entrada e saida .
	*@param clientes.
	*@param status.
	*@return array clientes.
	*/
	public function pegaFluxoBanco($idBanco = "", $tipo = "", $tipoFluxo = "", $dataIni = "", $dataFim = "", $id = ""){
		$qtd = 15;
	
		if(!empty($idBanco))
			$busca = " AND fluxo_bancos.id_bancos = '".$idBanco."' ";
			
		if(!empty($tipo))
			$busca .= " AND fluxo_bancos.tipo = '".$tipo."' ";
		
		if(!empty($tipoFluxo))
			$busca .= " AND fluxo_bancos.id_tipo_fluxo = '".$tipoFluxo."' ";

		if(!empty($dataIni))
			$busca .= " AND fluxo_bancos.data >= '".Formata::date2banco($dataIni)."' ";
			
		if(!empty($dataFim))
			$busca .= " AND fluxo_bancos.data <= '".Formata::date2banco($dataFim)."' ";
			
		if(!empty($id))
			$busca .= " AND fluxo_bancos.id = '".$id."' ";

		$query = "SELECT fluxo_bancos.*, tipo_fluxo.nome as tipoFluxoNome FROM fluxo_bancos LEFT JOIN tipo_fluxo ON tipo_fluxo.id = fluxo_bancos.id_tipo_fluxo WHERE 1 ".$busca." ORDER By fluxo_bancos.data ASC ";
		
// 		print $query;
		$RetornoConsultaRel = $this->ConexaoSQL->Select($query);
    	
		if(count($RetornoConsultaRel) > 0){
                    for($j=0; $j<count($RetornoConsultaRel); $j++){
                        $Retorno[$j] = new PropriedadesFluxoBanco();
                        $Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
                        $Retorno[$j]->setBancoId($RetornoConsultaRel[$j]["id_bancos"]);
                        $Retorno[$j]->setTipoFluxoId($RetornoConsultaRel[$j]["id_tipo_fluxo"]);
                        $Retorno[$j]->setTipoFluxoNome($RetornoConsultaRel[$j]["tipoFluxoNome"]);
                        $Retorno[$j]->setTipo($RetornoConsultaRel[$j]["tipo"]);
                        $Retorno[$j]->setNumeroDoc($RetornoConsultaRel[$j]["numero_doc"]);
                        $Retorno[$j]->setOcorrencia($RetornoConsultaRel[$j]["ocorrencia"]);
                        $Retorno[$j]->setStatus($RetornoConsultaRel[$j]["status"]);
                        $Retorno[$j]->setValor(Formata::banco2valor($RetornoConsultaRel[$j]["valor"]));
                        $Retorno[$j]->setData(Formata::banco2date($RetornoConsultaRel[$j]["data"]));
                    }
		}
		
		return $Retorno;
		
	}
	
	 /**
	* retorna lista de TipoFluxo.
	*@return array tipofluxo.
	*/
	public function pegaTipoFluxo(){

		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT * FROM tipo_fluxo ");
    	
		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$Retorno[$j] = new PropriedadesPadrao();
				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
				$Retorno[$j]->setNome($RetornoConsultaRel[$j]["nome"]);
			}
		}
		
		return $Retorno;
		
	}
	
	/**
	* Salvar ou Adicionar Fluxo.
	* @param $id
	*/
	public function salvarFluxo($id = "", $idBanco = "", $tipo = "", $tipoFluxo = "", $ocorrencia = "", $valor = "", $data = "", $numeroDoc = ""){

            if(empty($id)){
                    $this->ConexaoSQL->insertQuery("INSERT INTO fluxo_bancos (id_bancos, tipo, id_tipo_fluxo, ocorrencia, valor, numero_doc, data) VALUES('".$idBanco."', '".$tipo."', '".$tipoFluxo."', '".$ocorrencia."','".Formata::valor2banco($valor)."', '".$numeroDoc."', '".Formata::date2banco($data)."')");
            }else{
            	$valorantigo = $this->pegaFluxoBanco("", "", "", "", "", $id);
                $valorNovo = Formata::valor2banco($valor) - Formata::valor2banco($valorantigo[0]->getValor());
                
            	$this->ConexaoSQL->updateQuery("UPDATE fluxo_bancos SET id_bancos = '".$idBanco."', tipo = '".$tipo."', id_tipo_fluxo = '".$tipoFluxo."', ocorrencia = '".$ocorrencia."', valor = '".Formata::valor2banco($valor)."', numero_doc = '".$numeroDoc."', data = '".Formata::date2banco($data)."' WHERE id = '".$id."'");
            }
                
	}

        /**
	* pagar.
	* @param $id
	*/
	public function pagarFluxo($id = "", $info = ""){

            $fluxo = $this->pegaFluxoBanco("", "", "", "", "", $id);

            $valor = Formata::valor2banco($fluxo[0]->getValor());

            if($fluxo[0]->getTipo() == 1){
                $this->ConexaoSQL->updateQuery("UPDATE bancos SET saldo_atual = ( saldo_atual + '".$valor."') WHERE id = '".$fluxo[0]->getBancoId()."'");
            }else{
                $this->ConexaoSQL->updateQuery("UPDATE bancos SET saldo_atual = ( saldo_atual - '".$valor."') WHERE id = '".$fluxo[0]->getBancoId()."'");
            }

            $this->ConexaoSQL->updateQuery("UPDATE fluxo_bancos SET status = '1', ocorrencia = '".$fluxo[0]->getOcorrencia()."\n".$info."' WHERE id = '".$id."'");
		

	}
	
	/**
	* Excluir fluxo
	* @param $id
	*/
	public function excluir($id){
            $valorantigo = $this->pegaFluxoBanco("", "", "", "", "", $id);

            $valorNovo = Formata::valor2banco($valorantigo[0]->getValor());

            if($valorantigo[0]->getTipo() == 1){
                $this->ConexaoSQL->updateQuery("UPDATE bancos SET saldo_atual = ( saldo_atual - '".$valorNovo."') WHERE id = '".$valorantigo[0]->getBancoId()."'");
            }else{
                $this->ConexaoSQL->updateQuery("UPDATE bancos SET saldo_atual = ( saldo_atual + '".$valorNovo."') WHERE id = '".$valorantigo[0]->getBancoId()."'");
            }

            $this->ConexaoSQL->deleteQuery("DELETE FROM fluxo_bancos WHERE id = '".$id."'");
	}

       	
}
?>