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
 
include_once("properties/PropriedadesFluxo.php");
include_once("properties/PropriedadesFornecedores.php");
include_once("properties/PropriedadesPadrao.php");

class Fluxo  {
	public $ConexaoSQL;
    public $Formata;
	
    /**
	 * M?todo construtor.
	 *
	 * @param ConexaoSQL conex?o com o banco
	 */
    public function Fluxo($ConexaoSQL, $Formata){
        $this->ConexaoSQL = $ConexaoSQL;
        $this->Formata = $Formata;
    }
    
    /**
	* retorna lista de entrada e saida .
	*@param clientes.
	*@param status.
	*@return array clientes.
	*/
	public function pegaFluxo($cliente = "", $tipo = "", $tipoFluxo = "", $dataIni = "", $dataFim = "", $id = ""){
		$qtd = 15;
	
		if(!empty($cliente)){
			$busca = " AND fluxo.id_clientes = '".$cliente."' ";
			$buscaEspec = " AND fluxo.id_clientes = '".$cliente."' ";
		}
			
		if(!empty($tipo))
			$busca .= " AND fluxo.tipo = '".$tipo."' ";
			$buscaEspec .= " AND fluxo.tipo = '".$tipo."' ";
		
		if(!empty($tipoFluxo))
			$busca .= " AND fluxo.id_tipo_fluxo = '".$tipoFluxo."' ";
			$buscaEspec .= " AND fluxo.id_tipo_fluxo = '".$tipoFluxo."' ";

		if(!empty($dataIni))
			$busca .= " AND fluxo.data >= '".$this->Formata->date2banco($dataIni)."' ";
			
		if(!empty($dataFim))
			$busca .= " AND fluxo.data <= '".$this->Formata->date2banco($dataFim)."' ";
			
		if(!empty($id)){
            $busca .= " AND fluxo.id = '".$id."' ";
            $query = " SELECT fluxo.*, clientes.nome as clienteNome, fornecedores.nome as fornecedorNome,tipo_fluxo.nome as tipoFluxoNome FROM fluxo LEFT JOIN clientes ON clientes.id = fluxo.id_clientes LEFT JOIN fornecedores ON fornecedores.id = fluxo.id_fornecedores LEFT JOIN tipo_fluxo ON tipo_fluxo.id = fluxo.id_tipo_fluxo WHERE 1 ".$busca." ORDER By fluxo.data ASC ";
        }else{
            
            $query = " SELECT * FROM (SELECT fluxo.*, clientes.nome as clienteNome, fornecedores.nome as fornecedorNome,tipo_fluxo.nome as tipoFluxoNome FROM fluxo LEFT JOIN clientes ON clientes.id = fluxo.id_clientes LEFT JOIN fornecedores ON fornecedores.id = fluxo.id_fornecedores LEFT JOIN tipo_fluxo ON tipo_fluxo.id = fluxo.id_tipo_fluxo WHERE fluxo.data <= '".$this->Formata->date2banco($dataIni)."' AND fluxo.status = '0' ".$buscaEspec." UNION SELECT fluxo.*, clientes.nome as clienteNome, fornecedores.nome as fornecedorNome,tipo_fluxo.nome as tipoFluxoNome FROM fluxo LEFT JOIN clientes ON clientes.id = fluxo.id_clientes LEFT JOIN fornecedores ON fornecedores.id = fluxo.id_fornecedores LEFT JOIN tipo_fluxo ON tipo_fluxo.id = fluxo.id_tipo_fluxo WHERE 1 ".$busca."  ) as a ORDER BY a.data ASC";
        }

		//print $query;
		$RetornoConsultaRel = $this->ConexaoSQL->Select($query);
    	
		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$Retorno[$j] = new PropriedadesFluxo();
				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
				$Retorno[$j]->setClienteId($RetornoConsultaRel[$j]["id_clientes"]);
				$Retorno[$j]->setClienteNome($RetornoConsultaRel[$j]["clienteNome"]);
				$Retorno[$j]->setFornecedorId($RetornoConsultaRel[$j]["id_fornecedores"]);
				$Retorno[$j]->setFornecedorNome($RetornoConsultaRel[$j]["fornecedorNome"]);
				$Retorno[$j]->setTipoFluxoId($RetornoConsultaRel[$j]["id_tipo_fluxo"]);
				$Retorno[$j]->setTipoFluxoNome($RetornoConsultaRel[$j]["tipoFluxoNome"]);
				$Retorno[$j]->setTipo($RetornoConsultaRel[$j]["tipo"]);
				$Retorno[$j]->setOcorrencia($RetornoConsultaRel[$j]["ocorrencia"]);
				$Retorno[$j]->setValor($this->Formata->banco2valor($RetornoConsultaRel[$j]["valor"]));
                                $Retorno[$j]->setStatus($RetornoConsultaRel[$j]["status"]);
				$Retorno[$j]->setData($this->Formata->banco2date($RetornoConsultaRel[$j]["data"]));
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
	* retorna lista de fornecedores.
	*@return array fornecedores.
	*/
	public function pegaFornecedores( $id = "" ){
		
		if(!empty($id))
			$where = " AND id = '".$id."'";
			
		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT * FROM fornecedores WHERE id_status_geral = '1' ".$where." ORDER By nome ASC");
    	
		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$Retorno[$j] = new PropriedadesFornecedores();
				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
				$Retorno[$j]->setNome($RetornoConsultaRel[$j]["nome"]);
				$Retorno[$j]->setRazao($RetornoConsultaRel[$j]["razao"]);
			}
		}
		
		return $Retorno;
		
	}
	
	/**
	* Salvar ou Adicionar Fluxo.
	* @param $id
	*/
	public function salvarFluxo($id = "", $cliente = "", $fornecedor = "", $tipo = "", $tipoFluxo = "", $ocorrencia = "", $valor = "", $data = "", $status = ""){
		if(empty($id)){
			$this->ConexaoSQL->insertQuery("INSERT INTO fluxo (id_clientes, id_fornecedores, tipo, id_tipo_fluxo, ocorrencia, valor, data) VALUES('".$cliente."', '".$fornecedor."', '".$tipo."', '".$tipoFluxo."', '".$ocorrencia."','".$this->Formata->valor2banco($valor)."', '".$this->Formata->date2banco($data)."')");
		}else{
			if( $status != ""){
				$queryStatus = ", status = '".$status."' ";
			}
			$this->ConexaoSQL->updateQuery("UPDATE fluxo SET id_clientes = '".$cliente."', id_fornecedores = '".$fornecedor."', tipo = '".$tipo."', id_tipo_fluxo = '".$tipoFluxo."', ocorrencia = '".$ocorrencia."', valor = '".$this->Formata->valor2banco($valor)."', data = '".$this->Formata->date2banco($data)."' ".$queryStatus." WHERE id = '".$id."'");
		}
	}
	
	/**
	* Excluir fluxo
	* @param $id
	*/
	public function excluir($id){
			$this->ConexaoSQL->deleteQuery("DELETE FROM fluxo WHERE id = '".$id."'");
	}

        /**
	* retorna lista contas receber vencidas.
	*
	*@return array clientes.
	*/
	public function pegaContasReceberVencidas(){

		$query = "SELECT fluxo.*, clientes.nome as clienteNome, fornecedores.nome as fornecedorNome,tipo_fluxo.nome as tipoFluxoNome FROM fluxo LEFT JOIN clientes ON clientes.id = fluxo.id_clientes LEFT JOIN fornecedores ON fornecedores.id = fluxo.id_fornecedores LEFT JOIN tipo_fluxo ON tipo_fluxo.id = fluxo.id_tipo_fluxo WHERE status = '0' AND data < NOW() AND tipo = '1' ORDER By fluxo.data ASC ";

		//print $query;
		$RetornoConsultaRel = $this->ConexaoSQL->Select($query);

		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$Retorno[$j] = new PropriedadesFluxo();
				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
				$Retorno[$j]->setClienteId($RetornoConsultaRel[$j]["id_clientes"]);
				$Retorno[$j]->setClienteNome($RetornoConsultaRel[$j]["clienteNome"]);
				$Retorno[$j]->setFornecedorId($RetornoConsultaRel[$j]["id_fornecedores"]);
				$Retorno[$j]->setFornecedorNome($RetornoConsultaRel[$j]["fornecedorNome"]);
				$Retorno[$j]->setTipoFluxoId($RetornoConsultaRel[$j]["id_tipo_fluxo"]);
				$Retorno[$j]->setTipoFluxoNome($RetornoConsultaRel[$j]["tipoFluxoNome"]);
				$Retorno[$j]->setTipo($RetornoConsultaRel[$j]["tipo"]);
				$Retorno[$j]->setOcorrencia($RetornoConsultaRel[$j]["ocorrencia"]);
				$Retorno[$j]->setValor($this->Formata->banco2valor($RetornoConsultaRel[$j]["valor"]));
				$Retorno[$j]->setData($this->Formata->banco2date($RetornoConsultaRel[$j]["data"]));
                                $Retorno[$j]->setStatus($RetornoConsultaRel[$j]["status"]);
			}
		}

		return $Retorno;

	}

        /**
	* retorna lista contas receber.
	*
	*@return array clientes.
	*/
	public function pegaContasReceber(){

		$query = "SELECT fluxo.*, clientes.nome as clienteNome, fornecedores.nome as fornecedorNome,tipo_fluxo.nome as tipoFluxoNome FROM fluxo LEFT JOIN clientes ON clientes.id = fluxo.id_clientes LEFT JOIN fornecedores ON fornecedores.id = fluxo.id_fornecedores LEFT JOIN tipo_fluxo ON tipo_fluxo.id = fluxo.id_tipo_fluxo WHERE data > NOW() AND tipo = '1' AND status = '0' ORDER By fluxo.data ASC ";

		//print $query;
		$RetornoConsultaRel = $this->ConexaoSQL->Select($query);

		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$Retorno[$j] = new PropriedadesFluxo();
				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
				$Retorno[$j]->setClienteId($RetornoConsultaRel[$j]["id_clientes"]);
				$Retorno[$j]->setClienteNome($RetornoConsultaRel[$j]["clienteNome"]);
				$Retorno[$j]->setFornecedorId($RetornoConsultaRel[$j]["id_fornecedores"]);
				$Retorno[$j]->setFornecedorNome($RetornoConsultaRel[$j]["fornecedorNome"]);
				$Retorno[$j]->setTipoFluxoId($RetornoConsultaRel[$j]["id_tipo_fluxo"]);
				$Retorno[$j]->setTipoFluxoNome($RetornoConsultaRel[$j]["tipoFluxoNome"]);
				$Retorno[$j]->setTipo($RetornoConsultaRel[$j]["tipo"]);
				$Retorno[$j]->setOcorrencia($RetornoConsultaRel[$j]["ocorrencia"]);
				$Retorno[$j]->setValor($this->Formata->banco2valor($RetornoConsultaRel[$j]["valor"]));
				$Retorno[$j]->setData($this->Formata->banco2date($RetornoConsultaRel[$j]["data"]));
                                $Retorno[$j]->setStatus($RetornoConsultaRel[$j]["status"]);
			}
		}

		return $Retorno;

	}

        /**
	* Pagar Fluxo
	* @param $id
	*/
	public function pagarFluxo($id = "", $info = ""){

            $fluxo = $this->pegaFluxo("", "", "", "", "", $id);

            $this->ConexaoSQL->updateQuery("UPDATE fluxo SET status = '2', ocorrencia = '".$fluxo[0]->getOcorrencia()."\n".$info."', data_pgto = NOW() WHERE id = '".$id."'");

	}

        /**
	* descontar Fluxo
	* @param $id
	*/
	public function descontarFluxo($id = "", $info = ""){

            $fluxo = $this->pegaFluxo("", "", "", "", "", $id);

            $this->ConexaoSQL->updateQuery("UPDATE fluxo SET status = '3', ocorrencia = '".$fluxo[0]->getOcorrencia()."\n".$info."', data_pgto = NOW() WHERE id = '".$id."'");

	}

        /**
	* Cancelar Fluxo
	* @param $id
	*/
	public function cancelarFluxo($id = ""){

            $this->ConexaoSQL->updateQuery("UPDATE fluxo SET status = '1' WHERE id = '".$id."'");

	}

        /**
	* retorna lista contas receber vencidas.
	*
	*@return array clientes.
	*/
	public function pegaContasPagarVencidas(){

		$query = "SELECT fluxo.*, clientes.nome as clienteNome, fornecedores.nome as fornecedorNome,tipo_fluxo.nome as tipoFluxoNome FROM fluxo LEFT JOIN clientes ON clientes.id = fluxo.id_clientes LEFT JOIN fornecedores ON fornecedores.id = fluxo.id_fornecedores LEFT JOIN tipo_fluxo ON tipo_fluxo.id = fluxo.id_tipo_fluxo WHERE status = '0' AND data < NOW() AND tipo = '2' ORDER By fluxo.data ASC ";

		//print $query;
		$RetornoConsultaRel = $this->ConexaoSQL->Select($query);

		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$Retorno[$j] = new PropriedadesFluxo();
				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
				$Retorno[$j]->setClienteId($RetornoConsultaRel[$j]["id_clientes"]);
				$Retorno[$j]->setClienteNome($RetornoConsultaRel[$j]["clienteNome"]);
				$Retorno[$j]->setFornecedorId($RetornoConsultaRel[$j]["id_fornecedores"]);
				$Retorno[$j]->setFornecedorNome($RetornoConsultaRel[$j]["fornecedorNome"]);
				$Retorno[$j]->setTipoFluxoId($RetornoConsultaRel[$j]["id_tipo_fluxo"]);
				$Retorno[$j]->setTipoFluxoNome($RetornoConsultaRel[$j]["tipoFluxoNome"]);
				$Retorno[$j]->setTipo($RetornoConsultaRel[$j]["tipo"]);
				$Retorno[$j]->setOcorrencia($RetornoConsultaRel[$j]["ocorrencia"]);
				$Retorno[$j]->setValor($this->Formata->banco2valor($RetornoConsultaRel[$j]["valor"]));
				$Retorno[$j]->setData($this->Formata->banco2date($RetornoConsultaRel[$j]["data"]));
                                $Retorno[$j]->setStatus($RetornoConsultaRel[$j]["status"]);
			}
		}

		return $Retorno;

	}

        /**
	* retorna lista contas receber.
	*
	*@return array clientes.
	*/
	public function pegaContasPagar(){

		$query = "SELECT fluxo.*, clientes.nome as clienteNome, fornecedores.nome as fornecedorNome,tipo_fluxo.nome as tipoFluxoNome FROM fluxo LEFT JOIN clientes ON clientes.id = fluxo.id_clientes LEFT JOIN fornecedores ON fornecedores.id = fluxo.id_fornecedores LEFT JOIN tipo_fluxo ON tipo_fluxo.id = fluxo.id_tipo_fluxo WHERE data > NOW() AND tipo = '2' AND status = 0 ORDER By fluxo.data ASC ";

		//print $query;
		$RetornoConsultaRel = $this->ConexaoSQL->Select($query);

		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$Retorno[$j] = new PropriedadesFluxo();
				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
				$Retorno[$j]->setClienteId($RetornoConsultaRel[$j]["id_clientes"]);
				$Retorno[$j]->setClienteNome($RetornoConsultaRel[$j]["clienteNome"]);
				$Retorno[$j]->setFornecedorId($RetornoConsultaRel[$j]["id_fornecedores"]);
				$Retorno[$j]->setFornecedorNome($RetornoConsultaRel[$j]["fornecedorNome"]);
				$Retorno[$j]->setTipoFluxoId($RetornoConsultaRel[$j]["id_tipo_fluxo"]);
				$Retorno[$j]->setTipoFluxoNome($RetornoConsultaRel[$j]["tipoFluxoNome"]);
				$Retorno[$j]->setTipo($RetornoConsultaRel[$j]["tipo"]);
				$Retorno[$j]->setOcorrencia($RetornoConsultaRel[$j]["ocorrencia"]);
				$Retorno[$j]->setValor($this->Formata->banco2valor($RetornoConsultaRel[$j]["valor"]));
				$Retorno[$j]->setData($this->Formata->banco2date($RetornoConsultaRel[$j]["data"]));
                                $Retorno[$j]->setStatus($RetornoConsultaRel[$j]["status"]);
			}
		}

		return $Retorno;

	}

        public function pegaTiposDespesas($dataIni, $dataFim){
            $query = "SELECT tipo_fluxo.id, tipo_fluxo.nome as tipoFluxoNome FROM fluxo LEFT JOIN tipo_fluxo ON tipo_fluxo.id = fluxo.id_tipo_fluxo WHERE fluxo.data >= '".$this->Formata->date2banco($dataIni)."' AND fluxo.data <= '".$this->Formata->date2banco($dataFim)."' AND fluxo.tipo = '2' AND fluxo.status = '2' GROUP By fluxo.id_tipo_fluxo ";

            //print $query;
            $RetornoConsultaRel = $this->ConexaoSQL->Select($query);

            if(count($RetornoConsultaRel) > 0){
                    for($j=0; $j<count($RetornoConsultaRel); $j++){
                            
                            $Retorno[$RetornoConsultaRel[$j]["id"]] = $RetornoConsultaRel[$j]["tipoFluxoNome"];

                    }
            }

            return $Retorno;
        }

        public function pegaDespesas($dataIni, $dataFim, $tipo){
            $query = "SELECT fluxo.* FROM fluxo LEFT JOIN tipo_fluxo ON tipo_fluxo.id = fluxo.id_tipo_fluxo WHERE fluxo.id_tipo_fluxo = '".$tipo."' AND fluxo.data >= '".$this->Formata->date2banco($dataIni)."' AND fluxo.data <= '".$this->Formata->date2banco($dataFim)."' AND fluxo.tipo = '2' AND fluxo.status = '2' Order By fluxo.data ";

            //print $query."<br>";
            $RetornoConsultaRel = $this->ConexaoSQL->Select($query);

            if(count($RetornoConsultaRel) > 0){
                for($j=0; $j<count($RetornoConsultaRel); $j++){
                    $Retorno[$j] = new PropriedadesFluxo();
                    $Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
                    $Retorno[$j]->setTipo($RetornoConsultaRel[$j]["tipo"]);
                    $Retorno[$j]->setOcorrencia($RetornoConsultaRel[$j]["ocorrencia"]);
                    $Retorno[$j]->setValor($RetornoConsultaRel[$j]["valor"]);
                    $Retorno[$j]->setData($RetornoConsultaRel[$j]["data"]);
                    $Retorno[$j]->setStatus($RetornoConsultaRel[$j]["status"]);
                }
            }

            return $Retorno;
        }
	
}
?>