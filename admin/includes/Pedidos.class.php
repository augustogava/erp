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
 * Classe respons�vel pelos metodos Pedidos.
 *
 * @author Augusto Gava
 * @version 1.0
 */
 

include_once("properties/PropriedadesItensPedidos.php");
include_once("properties/PropriedadesProdutos.php");
include_once("properties/PropriedadesPedidos.php");
include_once("properties/PropriedadesClientes.php");
include_once("properties/PropriedadesRepresentantes.php");
include_once("properties/PropriedadesPadrao.php");
include_once("properties/PropriedadesFormaPagamento.php");

class Pedidos  {
	public $ConexaoSQL;
    public $Configuracoes;
    
    /**
	 * Método construtor.
	 *
	 * @param ConexaoSQL conexão com o banco
	 */

    public function Pedidos($ConexaoSQL, $Configuracoes){
        $this->ConexaoSQL = $ConexaoSQL;
        $this->Configuracoes = $Configuracoes;
    }

	/**
	* retorna lista de clientes.
	*@return array clientes.
	*/
	public function pegaClientes( $id = "" ){
		if(!empty($id))
			$where = " AND clientes.id = '".$id."'";

		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT clientes.*, estado.sigla as estadoNome, cidade.nome as cidadeNome FROM clientes LEFT JOIN estado ON estado.id = clientes.id_estado LEFT JOIN cidade ON cidade.id = clientes.id_cidade WHERE id_status_geral = '1' ".$where." ORDER By clientes.nome ASC");

		if(count($RetornoConsultaRel) > 0){

			for($j=0; $j<count($RetornoConsultaRel); $j++){

				$Retorno[$j] = new PropriedadesClientes();

				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);

				if(!empty($RetornoConsultaRel[$j]["id_transportadoras"]))

					$Retorno[$j]->setTransportadora($this->pegaTransportadora($RetornoConsultaRel[$j]["id_transportadoras"]));

					

				$Retorno[$j]->setNome($RetornoConsultaRel[$j]["nome"]);

				$Retorno[$j]->setRazao($RetornoConsultaRel[$j]["razao"]);

				$Retorno[$j]->setEmail($RetornoConsultaRel[$j]["email"]);

				$Retorno[$j]->setEndereco($RetornoConsultaRel[$j]["endereco"]);

				$Retorno[$j]->setCep($RetornoConsultaRel[$j]["cep"]);

				

				$Retorno[$j]->setBairro($RetornoConsultaRel[$j]["bairro"]);

				$Retorno[$j]->setEstado($RetornoConsultaRel[$j]["estadoNome"]);

				$Retorno[$j]->setCidade($RetornoConsultaRel[$j]["cidadeNome"]);

				

				$Retorno[$j]->setCnpj($RetornoConsultaRel[$j]["cnpj"]);

				$Retorno[$j]->setIe($RetornoConsultaRel[$j]["incricao_estadual"]);

				$Retorno[$j]->setContato($RetornoConsultaRel[$j]["contato"]);

				$Retorno[$j]->setTelefone($RetornoConsultaRel[$j]["telefone1"]);

				

				$Retorno[$j]->setiIdRepresentante($RetornoConsultaRel[$j]["id_representantes"]);

			}

		}

		

		return $Retorno;

		

	}

	

	/**

	* retorna lista de transportadoras.

	*@return array transportadora.

	*/

	public function pegaTransportadora( $id = "" ){

		

		if(!empty($id))

			$where = " AND transportadoras.id = '".$id."'";

				

		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT transportadoras.*, estado.nome as estadoNome, cidade.nome as cidadeNome FROM transportadoras LEFT JOIN estado ON estado.id = transportadoras.id_estado LEFT JOIN cidade ON cidade.id = transportadoras.id_cidade WHERE transportadoras.id_status_geral = '1' ".$where." ORDER By transportadoras.nome ASC");

    	

		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$Retorno[$j] = new PropriedadesRepresentantes();
				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
				$Retorno[$j]->setNome($RetornoConsultaRel[$j]["nome"]);
				$Retorno[$j]->setRazao($RetornoConsultaRel[$j]["razao"]);
				$Retorno[$j]->setTelefone($RetornoConsultaRel[$j]["telefone1"]);
				$Retorno[$j]->setEndereco($RetornoConsultaRel[$j]["endereco"]);
				$Retorno[$j]->setCep($RetornoConsultaRel[$j]["cep"]);
				$Retorno[$j]->setCidadeId($RetornoConsultaRel[$j]["id_cidade"]);
				$Retorno[$j]->setEstadoId($RetornoConsultaRel[$j]["id_estado"]);
				$Retorno[$j]->setCidadeNome($RetornoConsultaRel[$j]["cidadeNome"]);
				$Retorno[$j]->setEstadoNome($RetornoConsultaRel[$j]["estadoNome"]);
			}
		}

		return $Retorno;

	}

	/**
	* retorna lista de representantes.
	*@return array clientes.
	*/
	public function pegaRepresentantes( $id = "" ){

		if(!empty($id))
			$where = " AND representantes.id = '".$id."'";

		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT representantes.*, estado.nome as estadoNome, cidade.nome as cidadeNome FROM representantes LEFT JOIN estado ON estado.id = representantes.id_estado LEFT JOIN cidade ON cidade.id = representantes.id_cidade WHERE representantes.id_status_geral = '1' ".$where." ORDER By representantes.nome ASC");

		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$Retorno[$j] = new PropriedadesRepresentantes();
				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
				$Retorno[$j]->setNome($RetornoConsultaRel[$j]["nome"]);
				$Retorno[$j]->setRazao($RetornoConsultaRel[$j]["razao"]);
				$Retorno[$j]->setEndereco($RetornoConsultaRel[$j]["endereco"]);
				$Retorno[$j]->setCep($RetornoConsultaRel[$j]["cep"]);
				$Retorno[$j]->setCidadeId($RetornoConsultaRel[$j]["id_cidade"]);
				$Retorno[$j]->setEstadoId($RetornoConsultaRel[$j]["id_estado"]);
				$Retorno[$j]->setCidadeNome($RetornoConsultaRel[$j]["cidadeNome"]);
				$Retorno[$j]->setEstadoNome($RetornoConsultaRel[$j]["estadoNome"]);
			}
		}

		return $Retorno;

	}

	/**
	* retorna lista de clientes.
	*@return array clientes.
	*/
	public function pegaListaStatus(){
		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT * FROM status_pedidos ");

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
	* retorna lista de formas de pagamento.
	* @param id int
	*@return array formapagamento.
	*/
	public function pegaFormaPagamento( $id = "" ){
		if(!empty($id))
			$busca = " AND id = '".$id."' ";

		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT * FROM formas_pagamento WHERE 1 ".$busca." ");

		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$Retorno[$j] = new PropriedadesFormaPagamento();
				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
				$Retorno[$j]->setNome($RetornoConsultaRel[$j]["nome"]);
				$Retorno[$j]->setQtd($RetornoConsultaRel[$j]["qtd"]);
				$Retorno[$j]->setParcelas($RetornoConsultaRel[$j]["parcelas"]);
			}
		}

		return $Retorno;
	}

	/**
	* retorna lista com tipo entrega.
	* @param id int
	*@return array tipoEntrega.
	*/
	public function pegaTipoEntrega( $id = "" ){
		if(!empty($id))
			$busca = " AND id = '".$id."' ";

		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT * FROM tipo_entrega WHERE 1 ".$busca." ");
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
	* retorna lista de clientes.
	*@param clientes.
	*@param status.
	*@return array clientes.
	*/
	public function pegaPedidos($cliente = "", $status = "", $idPedido = "", $limite = "", $dataIni = "", $dataFim = "" , $codigo = "", $ordem = "", $tipoOrdem = "", $dataEnvioIni = "", $dataEnvioFim = "", $limitar = true){
		$qtd = ($limitar) ? 30: 99999;

		if(!empty($cliente))
			$busca = " AND pedidos.id_clientes = '".$cliente."' ";

		if(!empty($codigo))
			$busca = " AND pedidos.codigo LIKE '%".$codigo."%' ";

		if(!empty($status))
			$busca .= " AND pedidos.id_status_pedidos = '".$status."' ";

		if(!empty($idPedido))
			$busca .= " AND pedidos.id = '".$idPedido."' ";

		if(!empty($dataIni))
			$busca .= " AND pedidos.data_cad >= '".Formata::date2banco($dataIni)."' ";

		if(!empty($dataFim))
			$busca .= " AND pedidos.data_cad <= '".Formata::date2banco($dataFim)."' ";

		if(!empty($dataEnvioIni))
			$busca .= " AND pedidos.data_enviado >= '".Formata::date2banco($dataEnvioIni)."' ";

		if(!empty($dataEnvioFim))
			$busca .= " AND pedidos.data_enviado <= '".Formata::date2banco($dataEnvioFim)."' ";

		if(empty($limite) || $limite < 0)
			$limite = "0";

		if(!empty($ordem)){
			$order = " ORDER By ".$ordem." ".$tipoOrdem." ";
		}else{
			$order = " ORDER By id DESC ";
		}		
		//print "SELECT pedidos.*,tipo_entrega.nome as tipoEntregaNome, formas_pagamento.nome as nomeForma, clientes.nome as nomeCliente, status_pedidos.nome as nomeStatus, representantes.nome as nomeRepresentante, representantes.id as idRepresentante FROM pedidos LEFT JOIN representantes ON representantes.id = pedidos.id_representantes  LEFT JOIN tipo_entrega ON tipo_entrega.id = pedidos.id_tipo_entrega INNER JOIN clientes on clientes.id = pedidos.id_clientes INNER JOIN status_pedidos on status_pedidos.id = pedidos.id_status_pedidos INNER JOIN formas_pagamento on formas_pagamento.id = pedidos.id_formas_pagamento  ".$permissao." WHERE 1 ".$busca." ".$order." Limit ".$limite.", ".$qtd." ";
		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT pedidos.*,tipo_entrega.nome as tipoEntregaNome, formas_pagamento.nome as nomeForma, clientes.nome as nomeCliente, status_pedidos.nome as nomeStatus, representantes.nome as nomeRepresentante, representantes.id as idRepresentante FROM pedidos LEFT JOIN representantes ON representantes.id = pedidos.id_representantes  LEFT JOIN tipo_entrega ON tipo_entrega.id = pedidos.id_tipo_entrega INNER JOIN clientes on clientes.id = pedidos.id_clientes INNER JOIN status_pedidos on status_pedidos.id = pedidos.id_status_pedidos INNER JOIN formas_pagamento on formas_pagamento.id = pedidos.id_formas_pagamento  ".$permissao." WHERE 1 ".$busca." ".$order." Limit ".$limite.", ".$qtd." ");
		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$Retorno[$j] = new PropriedadesPedidos();
				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
				$Retorno[$j]->setCodigo($RetornoConsultaRel[$j]["codigo"]);
				$Retorno[$j]->setClienteId($RetornoConsultaRel[$j]["id_clientes"]);
				$Retorno[$j]->setClienteNome($RetornoConsultaRel[$j]["nomeCliente"]);
				$Retorno[$j]->setStatusId($RetornoConsultaRel[$j]["id_status_pedidos"]);
				$Retorno[$j]->setStatusNome($RetornoConsultaRel[$j]["nomeStatus"]);
				$Retorno[$j]->setRepresentantesId($RetornoConsultaRel[$j]["idRepresentante"]);
				$Retorno[$j]->setRepresentantesNome($RetornoConsultaRel[$j]["nomeRepresentante"]);
				$Retorno[$j]->setValorTotal($RetornoConsultaRel[$j]["valor_total"]);
				$Retorno[$j]->setValorTotalEspecial($RetornoConsultaRel[$j]["valor_total_especial"]);
				$Retorno[$j]->setFormaPagamento($RetornoConsultaRel[$j]["id_formas_pagamento"]);
				$Retorno[$j]->setFormaPagamentoNome($RetornoConsultaRel[$j]["nomeForma"]);
				$Retorno[$j]->setTipoEntregaId($RetornoConsultaRel[$j]["id_tipo_entrega"]);
				$Retorno[$j]->setTipoEntregaNome($RetornoConsultaRel[$j]["tipoEntregaNome"]);
				$Retorno[$j]->setObs($RetornoConsultaRel[$j]["obs"]);
				$Retorno[$j]->setImposto(Formata::banco2valor($RetornoConsultaRel[$j]["imposto"]));
                $Retorno[$j]->setComissao(Formata::banco2valor($RetornoConsultaRel[$j]["comissao"]));
				$Retorno[$j]->setValorEntrega(Formata::banco2valor($RetornoConsultaRel[$j]["valor_entrega"]));
				$Retorno[$j]->setDataFechada($RetornoConsultaRel[$j]["data_fechada"]);
				$Retorno[$j]->setDataEnviada($RetornoConsultaRel[$j]["data_enviado"]);
				$Retorno[$j]->setDataAberta(Formata::banco2date($RetornoConsultaRel[$j]["data_cad"]));
				$Retorno[$j]->setDataImposto(Formata::banco2date($RetornoConsultaRel[$j]["data_imposto"]));
			}
		}
		return $Retorno;
	}

	
	/**
	* retorna lista de itens do pedido.
	*@param clientes.
	*@param status.
	*@return array clientes.
	*/
	public function pegaItensPedido($pedido){
		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT * FROM pedidos_itens WHERE id_pedidos = '".$pedido."' ");

		if(count($RetornoConsulta) > 0){
			for($j=0; $j<count($RetornoConsulta); $j++){
				$Retorno[$j] = new PropriedadesItensPedidos();
				$Retorno[$j]->setId($RetornoConsulta[$j]["id"]);
				$Retorno[$j]->setIdPedido($RetornoConsulta[$j]["id_pedidos"]);
				$Retorno[$j]->setIdProduto($RetornoConsulta[$j]["id_produtos"]);
				$Retorno[$j]->setQtd($RetornoConsulta[$j]["qtd"]);
				$Retorno[$j]->setPreco($RetornoConsulta[$j]["preco"]);
				$Retorno[$j]->setPrecoEspecial($RetornoConsulta[$j]["preco_especial"]);
				$Retorno[$j]->setTotal($RetornoConsulta[$j]["total"]);
				$Retorno[$j]->setTotalEspecial($RetornoConsulta[$j]["total_especial"]);
				$Retorno[$j]->setProdutos($this->pegaProduto($RetornoConsulta[$j]["id_produtos"]));
			}
		}

		return $Retorno;

	}

	/**
	* Adicionar item pedido.
	*@param idPedido.
	*@return id PK.
	*/
	public function adicionaItemPedido($idPedido){
		$this->ConexaoSQL->insertQuery("INSERT INTO pedidos_itens (id_pedidos, data_cad) VALUES('".$idPedido."', NOW())");
		return $this->ConexaoSQL->pegaLastId();
	}


	/**
	* retorna qtd em estoque do produto.
	*@param produto.
	*@return qtd int.
	*/
	public function pegaEstoqueProduto($produto){

// 		$RetornoEntrada = $this->ConexaoSQL->Select("SELECT sum(qtd) as totalEntrada FROM estoque WHERE tipo = 1 AND id_produtos = '".$produto."' ");
// 		$RetornoSaida = $this->ConexaoSQL->Select("SELECT sum(qtd) as totalSaida FROM estoque WHERE tipo = 2 AND id_produtos = '".$produto."' ");

		$RetornoSaida = $this->ConexaoSQL->Select("SELECT estoque_atual as estoque_atual FROM produtos WHERE id = '".$produto."' ");

    	$qtd = $RetornoEntrada[0]["estoque_atual"]; // - $RetornoSaida[0]["totalSaida"]; 

		return $qtd;

	}

	/**
	 * Mudar status para enviado.
	 * @param idPedido.
	 */
	public function enviarPedido($idPedido){

		$dadosPedido = $this->pegaPedidos("", "", $idPedido);

		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT sum(total) as total,  sum(total_especial) as totalEspecial FROM pedidos_itens WHERE pedidos_itens.id_pedidos = '".$idPedido."' ");

		$precoTotal = $RetornoConsulta[0]["total"];
		$precoTotalEspecial = $RetornoConsulta[0]["totalEspecial"];
		
		$this->ConexaoSQL->updateQuery("UPDATE pedidos SET id_status_pedidos = '5', data_enviado = NOW()  WHERE id = '".$idPedido."'");
		$this->ConexaoSQL->deleteQuery("DELETE FROM fluxo WHERE id_pedidos = '".$idPedido."'");

        //Cadastra saida da comissao do representante
        $comissao = ($dadosPedido[0]->getComissao() > 0) ? $dadosPedido[0]->getComissao() : 7;
        $valorRepresentante = (($precoTotal+$precoTotalEspecial) * Formata::valor2banco( $comissao )) / 100;
        $ultimoDiaDomes = date("Y-m-d", strtotime(date("Y/m/d", mktime(0, 0, 0, date("m")+1, 1, date("Y"))) . " -1 day"));

        $representante = $this->ConexaoSQL->Select("SELECT * FROM fluxo WHERE ocorrencia LIKE '%".$dadosPedido[0]->getRepresentantesNome()."%' AND data = '".$ultimoDiaDomes."' AND tipo = '2'");
        if( count($representante) > 0 ){
        	$this->ConexaoSQL->updateQuery("UPDATE fluxo SET valor = valor + '".$valorRepresentante."'  WHERE id = '".$representante[0]["id"]."'");
        }else{
        	$this->ConexaoSQL->insertQuery("INSERT INTO fluxo (id_clientes, id_tipo_fluxo, id_pedidos, ocorrencia, data, tipo, valor) VALUES('".$dadosPedido[0]->getClienteId()."', '7', '".$idPedido."', 'Comissão Representante: ".$dadosPedido[0]->getRepresentantesNome()."', '".$ultimoDiaDomes."', '2', '".$valorRepresentante."')");
        }
        
		//GERA PARCELAS PARA FORMA PAGAMENTO
		$formaPagamento = $this->pegaFormaPagamento($dadosPedido[0]->getFormaPagamento());

		$parcela = $formaPagamento[0]->getParcelas();
		if(empty($parcela)){
			$adicional = 0;

			$adicional = Formata::valor2banco( $dadosPedido[0]->getValorEntrega() ); 
			if( $dadosPedido[0]->getDataImposto() == "00-00-0000" ||  $dadosPedido[0]->getDataImposto() == "00/00/0000" ){
				if( $precoTotalEspecial <= 0 )
					$adicional += Formata::valor2banco( $dadosPedido[0]->getImposto() );
				
				$this->ConexaoSQL->insertQuery("INSERT INTO fluxo (id_clientes, id_tipo_fluxo, id_pedidos, ocorrencia, data, tipo, valor) VALUES('".$dadosPedido[0]->getClienteId()."', '11', '".$idPedido." ', 'Imposto Código Pedido: ".$dadosPedido[0]->getCodigo()."', NOW(), '2', '".( $dadosPedido[0]->getImposto() )."')");
			}else{
				//Adiciona conta receber na data desejada, pois mayra recebe esse dinheiro do imposto do cliente tb.				
				$this->ConexaoSQL->insertQuery("INSERT INTO fluxo (id_clientes, id_tipo_fluxo, id_pedidos, ocorrencia, data, tipo, valor) VALUES('".$dadosPedido[0]->getClienteId()."', '11', '".$idPedido." ', 'Imposto Código Pedido: ".$dadosPedido[0]->getCodigo()."', '". Formata::date2banco( $dadosPedido[0]->getDataImposto() )."', '1', '".( $dadosPedido[0]->getImposto() )."')");
				$this->ConexaoSQL->insertQuery("INSERT INTO fluxo (id_clientes, id_tipo_fluxo, id_pedidos, ocorrencia, data, tipo, valor) VALUES('".$dadosPedido[0]->getClienteId()."', '11', '".$idPedido." ', 'Imposto Código Pedido: ".$dadosPedido[0]->getCodigo()."', NOW(), '2', '".( $dadosPedido[0]->getImposto() )."')");
			}

			$this->ConexaoSQL->insertQuery("INSERT INTO fluxo (id_clientes, id_tipo_fluxo, id_pedidos, ocorrencia, data, tipo, valor) VALUES('".$dadosPedido[0]->getClienteId()."', '1', '".$idPedido."', 'Código Pedido: ".$dadosPedido[0]->getCodigo()."', NOW(), '1', '".( $precoTotal+$adicional )."')");
			
			if( $precoTotalEspecial > 0 )
				$this->ConexaoSQL->insertQuery("INSERT INTO fluxo (id_clientes, id_tipo_fluxo, id_pedidos, ocorrencia, data, tipo, valor) VALUES('".$dadosPedido[0]->getClienteId()."', '1', '".$idPedido."', 'Código Pedido Especial: ".$dadosPedido[0]->getCodigo()."', NOW(), '1', '".( $precoTotal )."')");

		}else{
			$quantidadeParcelas = $formaPagamento[0]->getQtd(); 
			$dias = explode("/", $parcela ) ;

			if(isset($dias)){
				$valorParcela = $precoTotal / count($dias);
				$valorParcelaEspecial = $precoTotalEspecial / count($dias);
				foreach($dias as $k=>$datas){
					$adicional = 0;
					if($k == 0){
						if( $precoTotalEspecial <= 0 ) //Só adiciona frete no especial, caso existe especial
							$adicional = Formata::valor2banco( $dadosPedido[0]->getValorEntrega() ); 
						
						if( $dadosPedido[0]->getDataImposto() == "00-00-0000" || $dadosPedido[0]->getDataImposto() == "00/00/0000" ){
							$adicional += Formata::valor2banco( $dadosPedido[0]->getImposto() );
							$this->ConexaoSQL->insertQuery("INSERT INTO fluxo (id_clientes, id_tipo_fluxo, id_pedidos, ocorrencia, data, tipo, valor) VALUES('".$dadosPedido[0]->getClienteId()."', '11', '".$idPedido."', 'Imposto Código Pedido: ".$dadosPedido[0]->getCodigo()."', NOW(), '2', '".( $dadosPedido[0]->getImposto() )."')");
						}else{
							//Adiciona conta receber na data desejada, pois mayra recebe esse dinheiro do imposto do cliente tb.
							$this->ConexaoSQL->insertQuery("INSERT INTO fluxo (id_clientes, id_tipo_fluxo, id_pedidos, ocorrencia, data, tipo, valor) VALUES('".$dadosPedido[0]->getClienteId()."', '11', '".$idPedido."', 'Imposto Código Pedido: ".$dadosPedido[0]->getCodigo()."', '". Formata::date2banco( $dadosPedido[0]->getDataImposto() )."', '1', '".( $dadosPedido[0]->getImposto() )."')");
							$this->ConexaoSQL->insertQuery("INSERT INTO fluxo (id_clientes, id_tipo_fluxo, id_pedidos, ocorrencia, data, tipo, valor) VALUES('".$dadosPedido[0]->getClienteId()."', '11', '".$idPedido."', 'Imposto Código Pedido: ".$dadosPedido[0]->getCodigo()."', NOW(), '2', '".( $dadosPedido[0]->getImposto() )."')");
						}
					}
					
					$data = date("Y-m-d", mktime(0,0,0, date("m"), date("d") + $datas, date("Y")));
					
					$this->ConexaoSQL->insertQuery("INSERT INTO fluxo (id_clientes, id_tipo_fluxo, id_pedidos, ocorrencia, data, tipo, valor) VALUES('".$dadosPedido[0]->getClienteId()."', '1', '".$idPedido."', 'Código Pedido: ".$dadosPedido[0]->getCodigo()." <br> parcela ".($k+1)." de ".count($dias)."', '".$data."', '1', '".($valorParcela + $adicional)."')");
					
					//Só adiciona frete no especial
					$adicional = 0;
					if( $valorParcelaEspecial > 0 ){
						if($k == 0){
							$adicional = Formata::valor2banco( $dadosPedido[0]->getValorEntrega() );
						}
						$this->ConexaoSQL->insertQuery("INSERT INTO fluxo (id_clientes, id_tipo_fluxo, id_pedidos, ocorrencia, data, tipo, valor) VALUES('".$dadosPedido[0]->getClienteId()."', '1', '".$idPedido."', 'Código Pedido: ".$dadosPedido[0]->getCodigo()." Especial <br> Parcela ".($k+1)." de ".count($dias)."', '".$data."', '1', '".($valorParcelaEspecial+$adicional)."')");
					}
				}
			}
		}
	}

	public function voltaEstoqueAntigo($idPedido){
		
		//Só apaga ordens de produções abertas, as fechadas já foram feitas e estão no estoque já
		$this->ConexaoSQL->deleteQuery("DELETE FROM ordem_producao WHERE id_pedido = '".$idPedido."' AND id_status_ordem = '1' ");
		
		//Só pode remover do historio do estoque, as saidas (separacoes)
		$this->ConexaoSQL->deleteQuery("DELETE FROM estoque WHERE id_pedidos = '".$idPedido."' AND tipo = '2'");
		$ordens = OrdemSeparacao::pegaOrdemSeparacao("", $idPedido, null, null, null, null, 2 );
		for($j=0; $j<count($ordens); $j++){
			$produto = $ordens[0]->getProdutos();
			$this->ConexaoSQL->updateQuery("UPDATE produtos SET estoque_atual = estoque_atual + '". $ordens[0]->getQtd()."' WHERE id = '". $produto[0]->getId(). "'");
		}
		$this->ConexaoSQL->deleteQuery("DELETE FROM ordem_separacao WHERE id_pedido = '".$idPedido."'");
	}

	/**
	* Fechar Pedido para separar
	*@param idPedido.
	*/
	public function fecharPedido($idPedido){

		$dadosPedido = $this->pegaPedidos("", "", $idPedido);

		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT sum(total) as total, sum(total_especial) as totalEspecial FROM pedidos_itens WHERE pedidos_itens.id_pedidos = '".$idPedido."' ");
		$precoTotal = $RetornoConsulta[0]["total"];
		$precoTotalEspecial = $RetornoConsulta[0]["totalEspecial"];

		$this->ConexaoSQL->updateQuery("UPDATE pedidos SET id_status_pedidos = '4', data_fechada = NOW(), valor_total = '".$precoTotal."', valor_total_especial = '".$precoTotalEspecial."'  WHERE id = '".$idPedido."'");

		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT * FROM pedidos_itens WHERE id_pedidos = '".$idPedido."' ");
		if(count($RetornoConsulta) > 0){

			//Deleta lixo
			//normaliza estoque
			$this->voltaEstoqueAntigo($idPedido);

			//INSERE ESTOQUE
			for($j=0; $j<count($RetornoConsulta); $j++){

				$idOrdemProducao = null; 
				$qtdEstoque = $this->pegaEstoqueProduto($RetornoConsulta[$j]["id_produtos"]);
				if( $qtdEstoque > 0 && $qtdEstoque <= $RetornoConsulta[$j]["qtd"]){ // Estoque está acima de 0
					$qtdEstoque = $RetornoConsulta[$j]["qtd"] - $qtdEstoque;
					$this->ConexaoSQL->insertQuery("INSERT INTO ordem_producao (id_produtos, id_pedido, descricao, qtd, data_cad, id_status_ordem) VALUES('".$RetornoConsulta[$j]["id_produtos"]."', '".$idPedido."', 'Pedido: ".$dadosPedido[0]->getCodigo()." ','".$qtdEstoque."', NOW(), '1')");
					$idOrdemProducao = $this->ConexaoSQL->pegaLastId();
				}else if( $qtdEstoque <= 0 ) {	//Nao tem nada estoque, faz tudo
					$qtdEstoque = $RetornoConsulta[$j]["qtd"];
					$this->ConexaoSQL->insertQuery("INSERT INTO ordem_producao (id_produtos, id_pedido, descricao, qtd, data_cad, id_status_ordem) VALUES('".$RetornoConsulta[$j]["id_produtos"]."', '".$idPedido."', 'Pedido: ".$dadosPedido[0]->getCodigo()." ','".$qtdEstoque."', NOW(), '1')");
					$idOrdemProducao = $this->ConexaoSQL->pegaLastId();
				}
				
				$this->ConexaoSQL->insertQuery("INSERT INTO ordem_separacao (id_produtos, id_pedido, id_ordem_producao, descricao, qtd, data_cad, id_status_separacao) VALUES('".$RetornoConsulta[$j]["id_produtos"]."', '".$idPedido."', '".$idOrdemProducao."', 'Pedido: ".$dadosPedido[0]->getCodigo()." ','".$RetornoConsulta[$j]["qtd"]."', NOW(), '1')");
				
			}
		}
	}
	

	/**
	* salva Item pedido.

	*@param cliente.

	*@param status.

	*@return id PK.

	*/

	public function salvarItem($campo, $valor, $idItem, $indice = ""){

		$salvar = false;
		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT * FROM pedidos INNER JOIN pedidos_itens ON pedidos_itens.id_pedidos = pedidos.id WHERE pedidos_itens.id = '".$idItem."' ");
		if(count($RetornoConsulta) > 0){
			if($campo == "id_produtos"){
				$RetornoConsulta = $this->ConexaoSQL->Select("SELECT id_pedidos FROM pedidos_itens WHERE id = '".$idItem."'");
				if(count($RetornoConsulta) > 0){
					$RetornoConsultaVerifica = $this->ConexaoSQL->Select("SELECT id FROM pedidos_itens WHERE id_pedidos = '".$RetornoConsulta[0]["id_pedidos"]."' AND id_produtos = '".$valor."'");
					if(count($RetornoConsultaVerifica) == 0){
						$salvar = true;
					}
				}else{
					$salvar = true;
				}
			}else{
				$salvar = true;
			}
		}

		if($salvar){
			if($campo == "preco" || $campo == "comissao_valor"){
				$valor = Formata::valor2banco($valor);
			}

			$this->ConexaoSQL->updateQuery("UPDATE pedidos_itens SET ".$campo." = '".$valor."' WHERE id = '".$idItem."'");
			$this->ConexaoSQL->updateQuery("UPDATE pedidos_itens SET total = ( qtd * preco )  WHERE id = '".$idItem."'");
			$this->ConexaoSQL->updateQuery("UPDATE pedidos_itens SET total_especial = ( qtd * preco_especial )  WHERE id = '".$idItem."'");

			$RetornoConsulta = $this->ConexaoSQL->Select("SELECT id_produtos, id_pedidos FROM pedidos_itens WHERE id = '".$idItem."'");
			$this->verficaFechado($RetornoConsulta[0]["id_pedidos"]);
			print "<script>selecionaProdutoItenPedido(".$RetornoConsulta[0]["id_produtos"].", ".$indice.", ".$idItem.");</script>";
		}else{
			print "<script>window.alert('Produto já� cadastrado')</script>";
		}
	}

	/**
	* salva Item pedido.
	*@param cliente.
	*@param status.
	*@return id PK.
	*/
	public function salvarPedido($clientes, $representantes, $id, $tipoComissao, $valorComissao, $formaPagamento, $codigo, $obs, $tipo_entrega, $imposto, $valorEntrega, $comissao, $dataimposto=""){
		//Deleta lixo
		$this->ConexaoSQL->deleteQuery("DELETE FROM fluxo WHERE id_pedidos = '".$id."'");
		//print "UPDATE pedidos SET id_tipo_entrega = '".$tipo_entrega."', imposto = '".Formata::valor2banco($imposto)."', obs = '".$obs."', codigo = '".$codigo."', id_clientes = '".$clientes."', id_representantes = '".$representantes."', tipo_comissao = '".$tipoComissao."', comissao_valor = '".Formata::valor2banco($valorComissao)."', valor_entrega = '".Formata::valor2banco($valorEntrega)."', id_formas_pagamento = '".$formaPagamento."', data_fechada = '', comissao = '".Formata::valor2banco($comissao)."', data_imposto = '".Formata::date2banco($dataimposto)."' WHERE id = '".$id."'";
		$this->ConexaoSQL->updateQuery("UPDATE pedidos SET id_tipo_entrega = '".$tipo_entrega."', imposto = '".Formata::valor2banco($imposto)."', obs = '".$obs."', codigo = '".$codigo."', id_clientes = '".$clientes."', id_representantes = '".$representantes."', tipo_comissao = '".$tipoComissao."', comissao_valor = '".Formata::valor2banco($valorComissao)."', valor_entrega = '".Formata::valor2banco($valorEntrega)."', id_formas_pagamento = '".$formaPagamento."', data_fechada = '', comissao = '".Formata::valor2banco($comissao)."', data_imposto = '".Formata::date2banco($dataimposto)."' WHERE id = '".$id."'");
		$this->verficaFechado($id);
	}
	
	
	public function alteraStatusPedidoSeparado( $id, $status ){
		$this->ConexaoSQL->updateQuery("UPDATE pedidos SET id_status_pedidos = '".$status."' WHERE id = '".$id."'");
	}

	/**
	 * Verifica se est� fechado, se estiver, fecha o pedido.
	 * @param id
	 */
	public function verficaFechado( $id ){

		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT id_status_pedidos as status FROM pedidos WHERE id = '".$id."' AND id_status_pedidos IN (4, 5) ");
		if(count($RetornoConsulta) > 0){

			if($RetornoConsulta[0]["status"] == 4 ){
				$this->fecharPedido($id);
			}else if($RetornoConsulta[0]["status"] == 5){
				$this->fecharPedido($id);
				$this->enviarPedido($id);
			}
		}
	}

	/**
	* retorna lista de produtos.
	*@param clientes.
	*@param status.
	*@return array clientes.
	*/
	public function pegaProduto($produto = ""){
		if($produto != '')
			$busca = " AND id = '".$produto."' ";

		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT * FROM produtos WHERE 1 ".$busca." Order By codigo ASC ");
		if(count($RetornoConsulta) > 0){
			for($j=0; $j<count($RetornoConsulta); $j++){
				$Retorno[$j] = new PropriedadesProdutos();
				$Retorno[$j]->setId($RetornoConsulta[$j]["id"]);
				$Retorno[$j]->setIdUsuarios($RetornoConsulta[$j]["id_usuarios"]);
				$Retorno[$j]->setIdCategorias($RetornoConsulta[$j]["id_categorias"]);
				$Retorno[$j]->setCodigo($RetornoConsulta[$j]["codigo"]);
				$Retorno[$j]->setNome($RetornoConsulta[$j]["nome"]);
				$Retorno[$j]->setDescricao($RetornoConsulta[$j]["descricao"]);
				$Retorno[$j]->setPreco1($RetornoConsulta[$j]["preco_1"]);
				$Retorno[$j]->setPreco2($RetornoConsulta[$j]["preco_2"]);
				$Retorno[$j]->setPreco3($RetornoConsulta[$j]["preco_3"]);
				$Retorno[$j]->setPreco4($RetornoConsulta[$j]["preco_4"]);
				$Retorno[$j]->setPreco4($RetornoConsulta[$j]["preco_4"]);
				$Retorno[$j]->setEstoqueAtual($RetornoConsulta[$j]["estoque_atual"]);
			}
		}

		return $Retorno;

		

	}

	
	/**
	* Deletar pedido.
	*@param id.
	*/
	public function excluirPedido($id){
		//Exclui lixo
		$this->voltaEstoqueAntigo($id);
		$this->ConexaoSQL->deleteQuery("DELETE FROM fluxo WHERE id_pedidos = '".$id."'");
		$this->ConexaoSQL->deleteQuery("DELETE FROM pedidos WHERE id = '".$id."'");

	}

	/**
	* Deletar item pedido.
	*@param id.
	*/
	public function excluirItemPedido($id){
		$this->ConexaoSQL->deleteQuery("DELETE FROM pedidos_itens WHERE id = '".$id."'");
	}
	

	/**
	* Adicionar pedido.
	*@param cliente.
	*@param status.
	*@return id PK.
	*/
	public function adicionarPedido($cliente = "", $status = ""){
		$this->ConexaoSQL->deleteQuery("DELETE FROM pedidos WHERE id_clientes = '0' AND id_status_pedidos IN (0, 1) ");
		$this->ConexaoSQL->insertQuery("INSERT INTO pedidos (id_clientes, id_status_pedidos, data_cad) VALUES('".$cliente."', '1', NOW())");
		$this->ConexaoSQL->insertQuery("INSERT INTO pedidos_itens (id_pedidos) VALUES('".$this->pegaUltimoId()."') ");

		return $this->pegaUltimoId();
	}

	/**
	* Adicionar pedido.
	*@return id PK.
	*/
	public function pegaUltimoId(){
		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT max(id) as id FROM pedidos ");
		if(count($RetornoConsulta) > 0){
				return $RetornoConsulta[0]["id"];
		}
	}

	/**
	 * Monta html usado para abrir o relatorio ou email.
	 * @param $idPedido.
	 * @return html.
	 */
	function montaHTMLRelatorio($idPedido){
		$dadosPedido = $this->pegaPedidos("", "", $idPedido);

		$itens = $this->pegaItensHTMLPedido($idPedido);

		$fluxoTemplate = file($this->Configuracoes->TemplateArquivoPedido);//chama o arquivo do p
		$fluxoTemplateSaida = "";

		foreach ($fluxoTemplate as $fluxoTemplateHTML) {
			$fluxoTemplateSaida.= $fluxoTemplateHTML;//imprime o retorno
		}

		$clienteDados = $this->pegaClientes($dadosPedido[0]->getClienteId());
		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT sum(total) as total, sum(total_especial) as totalEspecial FROM pedidos_itens WHERE pedidos_itens.id_pedidos = '".$idPedido."' ");

		$precoTotal = $RetornoConsulta[0]["total"];
		$precoTotalEspecial = $RetornoConsulta[0]["totalEspecial"];

		if($dadosPedido[0]->getDataEnviada() != '0000-00-00 00:00:00'){
			//GERA PARCELAS PARA FORMA PAGAMENTO
			$saidaParcelas .= "<tr style=\"background:#1E96CD;color:white;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
							<td width=\"60%\" class=\"ColunaInfo\" style=\"text-align:left;\"><b>Parcelamento</b></td>
							<td width=\"20%\" class=\"ColunaInfo\" style=\"text-align:left;\"></td>
							<td width=\"30%\" class=\"ColunaInfo\" style=\"text-align:left;\"></td>
						</tr>";
			
			if( $dadosPedido[0]->getValorTotalEspecial() > 0 )
				$saidaParcelasEspecial .= "<tr style=\"background:#1E96CD;color:white;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
							<td width=\"60%\" class=\"ColunaInfo\" style=\"text-align:left;\"><b>Parcelamento Especial</b></td>
							<td width=\"20%\" class=\"ColunaInfo\" style=\"text-align:left;\"></td>
							<td width=\"30%\" class=\"ColunaInfo\" style=\"text-align:left;\"></td>
						</tr>";
			
			$formaPagamento = $this->pegaFormaPagamento($dadosPedido[0]->getFormaPagamento());
			$parcela = $formaPagamento[0]->getParcelas();

			$quantidadeParcelas = $formaPagamento[0]->getQtd(); 
			$dias = explode("/", $parcela ) ;
			$dataFechada = explode("-", $dadosPedido[0]->getDataEnviada());

			if(isset($dias)){
				$valorParcela = $precoTotal / count($dias);
				$valorParcelaEspecial = $precoTotalEspecial / count($dias);
				if( ( $dadosPedido[0]->getDataImposto() != "00-00-0000" && $dadosPedido[0]->getDataImposto() != "00/00/0000" ) && Formata::valor2banco( $dadosPedido[0]->getImposto() ) > 0  ){
					$saidaParcelas .= "<tr style=\"background:#EBF0FD;color:#215DF6;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
											<td  class=\"ColunaInfo\" style=\"text-align:left;\"> Imposto </td>
											<td class=\"ColunaInfo\" style=\"text-align:left;\">".$dadosPedido[0]->getDataImposto()."</td>
											<td  class=\"ColunaInfo\" style=\"text-align:right;\">".$dadosPedido[0]->getImposto()."</td>
										</tr>";
				}

				foreach($dias as $k=>$datas){

					$data = Formata::banco2date(date("Y-m-d", mktime(0,0,0, $dataFechada[1], substr($dataFechada[2], 0, 2) + $datas, $dataFechada[0])));

					$valPar = ($k==0) ? $valorParcela+Formata::valor2banco($dadosPedido[0]->getImposto())+Formata::valor2banco($dadosPedido[0]->getValorEntrega()) : $valorParcela;
					if( $k==0 ){
						
						if( $precoTotalEspecial <= 0 )
							$valPar = $valorParcela + Formata::valor2banco( $dadosPedido[0]->getValorEntrega() ); 
						else
							$valPar = $valorParcela ;//+ Formata::valor2banco($dadosPedido[0]->getImposto());
						
						if( $dadosPedido[0]->getDataImposto() == "00-00-0000" || $dadosPedido[0]->getDataImposto() == "00/00/0000" ){
							$valPar += Formata::valor2banco( $dadosPedido[0]->getImposto() );
						}
					}else{
						$valPar = $valorParcela;
					}

					$saidaParcelas .= "<tr style=\"background:#EBF0FD;color:#215DF6;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
											<td  class=\"ColunaInfo\" style=\"text-align:left;\"> Parcela: ".($k+1)." de ".count($dias)."</td>
											<td  class=\"ColunaInfo\" style=\"text-align:left;\">".$data."</td>
											<td  class=\"ColunaInfo\" style=\"text-align:right;\">".Formata::banco2valor($valPar)."</td>
										</tr>";
					
					if( $valorParcelaEspecial > 0 ){
						$addFrete = 0;
						if( $k==0 ){
							$addFrete =Formata::valor2banco( $dadosPedido[0]->getValorEntrega() );
						}
						$saidaParcelasEspecial .= "<tr style=\"background:#EBF0FD;color:#215DF6;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
												<td  class=\"ColunaInfo\" style=\"text-align:left;\"> Parcela Especial: ".($k+1)." de ".count($dias)."</td>
												<td  class=\"ColunaInfo\" style=\"text-align:left;\">".$data."</td>
												<td  class=\"ColunaInfo\" style=\"text-align:right;\">".Formata::banco2valor($valorParcelaEspecial+$addFrete)."</td>
											</tr>";
					}

				}
			}
			
		}

		$pt = explode("/", $dadosPedido[0]->getCodigo());
		if(count($pt) > 1){
			$codigoNovo = $dadosPedido[0]->getCodigo();
		}else{
			$codigoNovo = $dadosPedido[0]->getCodigo()."/".date("y");
		}

		if($dadosPedido[0]->getTipoEntregaId() == 2){
			$clientesDados = $this->pegaClientes($dadosPedido[0]->getClienteId());
			$trans = $clientesDados[0]->getTransportadora();
			$tipoEntrega = $dadosPedido[0]->getTipoEntregaNome();
			if(count($trans) > 0)
				$tipoEntrega .= " <b>Nome: </b> ".$trans[0]->getNome()." <b>Endereco: </b> ".$trans[0]->getEndereco()."<b>Cidade: </b> ".$trans[0]->getCidadeNome()." <b>Tel.: </b> ".$trans[0]->getTelefone();

		}else{
			$tipoEntrega = $dadosPedido[0]->getTipoEntregaNome();
		}

		$fluxoTemplateSaida = ereg_replace("%PEDIDO%", $codigoNovo, $fluxoTemplateSaida);
		$fluxoTemplateSaida = ereg_replace("%CLIENTE%",$dadosPedido[0]->getClienteNome(), $fluxoTemplateSaida);

		$fluxoTemplateSaida = ereg_replace("%ENDERECO%",$clienteDados[0]->getEndereco()." <b>CEP:</b> ".$clienteDados[0]->getCep(), $fluxoTemplateSaida);
		$fluxoTemplateSaida = ereg_replace("%BAIRRO%",$clienteDados[0]->getBairro(), $fluxoTemplateSaida);
		$fluxoTemplateSaida = ereg_replace("%CIDADE%",$clienteDados[0]->getCidade()." / ".$clienteDados[0]->getEstado(), $fluxoTemplateSaida);
		$fluxoTemplateSaida = ereg_replace("%CNPJ%",$clienteDados[0]->getCnpj(), $fluxoTemplateSaida);
		$fluxoTemplateSaida = ereg_replace("%IE%",$clienteDados[0]->getIe(), $fluxoTemplateSaida);
		$fluxoTemplateSaida = ereg_replace("%CONTATO%",$clienteDados[0]->getContato(), $fluxoTemplateSaida);
		$fluxoTemplateSaida = ereg_replace("%TELEFONE%",$clienteDados[0]->getTelefone(), $fluxoTemplateSaida);

		$fluxoTemplateSaida = ereg_replace("%REPRESENTANTE%",$dadosPedido[0]->getRepresentantesNome(), $fluxoTemplateSaida);
		$fluxoTemplateSaida = ereg_replace("%FORMAPAGAMENTO%",$dadosPedido[0]->getFormaPagamentoNome(), $fluxoTemplateSaida);
		$fluxoTemplateSaida = ereg_replace("%OBS%",$dadosPedido[0]->getObs(), $fluxoTemplateSaida);
		$fluxoTemplateSaida = ereg_replace("%TIPOENTREGA%", $tipoEntrega, $fluxoTemplateSaida);
		$fluxoTemplateSaida = ereg_replace("%DATA%", Formata::banco2date($dadosPedido[0]->getDataEnviada()), $fluxoTemplateSaida); 
		$fluxoTemplateSaida = ereg_replace("%ITENS%",$itens, $fluxoTemplateSaida);
		$fluxoTemplateSaida = ereg_replace("%PARCELAS%",$saidaParcelas, $fluxoTemplateSaida);
		$fluxoTemplateSaida = ereg_replace("%PARCELASESPECIAL%",$saidaParcelasEspecial, $fluxoTemplateSaida);
		

		
		$padraoTemplate = file($this->Configuracoes->TemplateArquivoEmail);//chama o arquivo do p
		$padraoTemplateSaida = "";

		foreach ($padraoTemplate as $padraoTemplateHTML) {
			$padraoTemplateSaida.= $padraoTemplateHTML;//imprime o retorno
		}

		$padraoTemplateSaida = ereg_replace("%CONTEUDOEMAIL%",$fluxoTemplateSaida, $padraoTemplateSaida);

		return $padraoTemplateSaida;

	}

	function pegaItensHTMLPedido($idPedido){

		$dadosPedido =$this->pegaPedidos("", "", $idPedido);
		$itens = $this->pegaItensPedido($idPedido);

		$return = "<tr style=\"background:#1E96CD;color:white;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
						<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\">Cod</td>
						<td width=\"50%\" class=\"ColunaInfo\" style=\"text-align:left;\">Produto</td>
						<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\">Qtd</td>
						<td width=\"15%\" class=\"ColunaInfo\" style=\"text-align:left;\">Valor</td>
						<td width=\"15%\" class=\"ColunaInfo\" style=\"text-align:left;\">Valor Espe.</td>
						<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\">Total</td>
					</tr>";

		for($i=0; $i<count($itens); $i++){
			$produtoItem = $itens[$i]->getProdutos();
			if($produtoItem[0]){
				$codigo = $produtoItem[0]->getCodigo();
				$qtdTotal += $itens[$i]->getQtd();
				$precoTotal += $itens[$i]->getTotal() + $itens[$i]->getTotalEspecial();
				$nomeItem = $produtoItem[0]->getNome();
			}

			$return .= "<tr style=\"background: #EBF0FD;height:32px;\">
				<td width=\"10%\" style=\"text-align:left;\" id=\"codigoProduto_<?=$i?>\">&nbsp;".$codigo."</td>
				<td width=\"50%\" style=\"text-align:left;\">
					".$nomeItem."
				</td>
				<td width=\"10%\" style=\"text-align:left;\">
					".$itens[$i]->getQtd()."
				</td>
				<td width=\"15%\" style=\"text-align:left;\" id=\"precosProduto_<?=$i?>\">
					".Formata::banco2valor($itens[$i]->getPreco())."
				</td>
				<td width=\"15%\" style=\"text-align:left;\" id=\"precosProduto_<?=$i?>\">
					".Formata::banco2valor($itens[$i]->getPrecoEspecial())."
				</td>
				<td width=\"10%\" style=\"text-align:left;\" id =\"campoTotal_<?=$i?>\">
					".Formata::banco2valor($itens[$i]->getTotal() + $itens[$i]->getTotalEspecial())."
				</td>
			</tr>";
		}
			
		$return .= "<tr style=\"background: #EBF0FD;height:32px;\">
				<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\">&nbsp;<strong>Total</strong></td>
				<td width=\"50%\" class=\"ColunaInfo\" style=\"text-align:left;\">&nbsp;</td>
				<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\"><strong>".$qtdTotal."</strong></td>
				<td width=\"15%\" class=\"ColunaInfo\" style=\"text-align:left;\" >&nbsp;</td>
				<td width=\"15%\" class=\"ColunaInfo\" style=\"text-align:left;\" >&nbsp;</td>
				<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\"><strong>".Formata::banco2valor( ($precoTotal))."</strong></td>
			</tr>";
		
		$return .= "<tr >
				<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\">&nbsp;<strong></strong></td>
				<td width=\"50%\" class=\"ColunaInfo\" style=\"text-align:left;\">&nbsp;</td>
				<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\"></td>
				<td width=\"15%\" class=\"ColunaInfo\" style=\"background:#1E96CD;color:white;height:26px;font-weight: bold;\" >IMPOSTO</td>
				<td width=\"15%\" class=\"ColunaInfo\" style=\"background:#1E96CD;color:white;height:26px;font-weight: bold;\" >FRETE</td>
				<td width=\"10%\" class=\"ColunaInfo\" style=\"background:#1E96CD;color:white;height:26px;font-weight: bold;\"></td>
			</tr>";
		
		$return .= "<tr style=\"background: #EBF0FD;height:32px;\">
				<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\">&nbsp;<strong></strong></td>
				<td width=\"50%\" class=\"ColunaInfo\" style=\"text-align:left;\">&nbsp;</td>
				<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\"></td>
				<td width=\"15%\" class=\"ColunaInfo\" style=\"text-align:left;\" ><b>".$dadosPedido[0]->getImposto()."</b></td>
				<td width=\"15%\" class=\"ColunaInfo\" style=\"text-align:left;\" ><b>".$dadosPedido[0]->getValorEntrega()."</b></td>
				<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\"></td>
			</tr>";
		
		$return .= "<tr >
				<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\">&nbsp;<strong></strong></td>
				<td width=\"50%\" class=\"ColunaInfo\" style=\"text-align:left;\">&nbsp;</td>
				<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\"></td>
				<td width=\"15%\" class=\"ColunaInfo\" style=\"background:#1E96CD;color:white;height:26px;font-weight: bold;\" >Total</td>
				<td width=\"15%\" class=\"ColunaInfo\" style=\"background:#1E96CD;color:white;height:26px;font-weight: bold;\" ></td>
				<td width=\"10%\" class=\"ColunaInfo\" style=\"background:#1E96CD;color:white;height:26px;font-weight: bold;\"></td>
			</tr>";
		
		$return .= "<tr style=\"background: #EBF0FD;height:32px;\">
				<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\">&nbsp;<strong></strong></td>
				<td width=\"50%\" class=\"ColunaInfo\" style=\"text-align:left;\">&nbsp;</td>
				<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\"></td>
				<td width=\"15%\" class=\"ColunaInfo\" style=\"text-align:left;\" ></td>
				<td width=\"15%\" class=\"ColunaInfo\" style=\"text-align:left;\" ></td>
				<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\"> <b>".Formata::banco2valor(Formata::valor2banco($dadosPedido[0]->getImposto())+$precoTotal+Formata::valor2banco($dadosPedido[0]->getValorEntrega()))."</b></td>
			</tr>";
		
// 			$return .= "<tr style=\"background: #EBF0FD;height:32px;\">
// 				<td colspan=\"5\" style=\"text-align:right;\">
// 					<table width=\"20%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"right\">
// 						<tr style=\"background:#1E96CD;color:white;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
// 							<td width=\"100%\" class=\"ColunaInfo\" style=\"text-align:left;\">Imposto</td>
// 						</tr>
// 						<tr style=\"background:#EBF0FD;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
// 							<td width=\"100%\" class=\"ColunaInfo\" style=\"text-align:left;\"></td>
// 						</tr>
						 
// 						<tr style=\"background:#1E96CD;color:white;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
// 							<td width=\"100%\" class=\"ColunaInfo\" style=\"text-align:left;\">Frete</td>
// 						</tr>
// 						<tr style=\"background:#EBF0FD;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
// 							<td width=\"100%\" class=\"ColunaInfo\" style=\"text-align:left;\"></td>
// 						</tr>
						
// 						<tr style=\"background:#1E96CD;color:white;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
// 							<td width=\"100%\" class=\"ColunaInfo\" style=\"text-align:left;\">Total Pedido</td>
// 						</tr>
// 						<tr style=\"background:#EBF0FD;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
// 							<td width=\"100%\" class=\"ColunaInfo\" style=\"text-align:left;\">".Formata::banco2valor(Formata::valor2banco($dadosPedido[0]->getImposto())+$precoTotal+Formata::valor2banco($dadosPedido[0]->getValorEntrega()))."</td>
// 						</tr>
// 					</table>
// 				</td>
// 			</tr>";
		return $return;

	}

	/**
	*
	*
	*/
	function enviaEmailFluxo($idPedido, $emailDest){
		$html = $this->montaHTMLRelatorio($idPedido);
		$dadosPedido = $this->pegaPedidos("", "", $idPedido);

		$email = new Email($this->ConexaoSQL, $this->Formata);
		$email->setAssunto("Pedido N ".$dadosPedido[0]->getCodigo());
		$email->setConteudo($html);
		$email->setDestinatario($emailDest);
		$email->setRemetente("stoikvendas@gmail.com");
		$email->enviarEmail();
	}

	/**
	 * Gera código para pedido, formato YYYY/000increment.
	 */
	function pegaCodigoNovo(){

		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT codigo FROM pedidos WHERE codigo != '' ORDER By ID DESC Limit 1");
		if(count($RetornoConsulta) > 0){

			$pt = $RetornoConsulta[0]["codigo"];
			$codigo = Formata::preencheZero(($pt+1), 4);
		}else{
			$codigo = "00001";
		}

		return $codigo;

	}
	
	/**
	* Exportacao tela.
	*/
	public function exportar($cliente = "", $status = "", $dataIni = "", $dataFim = "" , $codigo = "", $ordem = "", $tipoOrdem = "", $dataEnvioIni = "", $dataEnvioFim = "", $tipo){
		
		$pedidos = $this->pegaPedidos($cliente, $status, "", "", $dataIni, $dataFim, $codigo, $ordem, $tipoOrdem, $dataEnvioIni, $dataEnvioFim);
		
		if($tipo != "csv"){
			$html = "<table border=\"1\" width=\"100%\" height=\"100px\"  cellpadding=\"0\" cellspacing=\"0\" align=\"left\">";
			$html .= "<tr class=\"tituloRelatorio\">";
				
				if($tipo == "html"){
					$html .= "<td width='10%'>";
					$html .= "<div class=\"logo\"></div>";
					$html .= "</td>";
				}

				$html .= "<td  width='90%' align='center'>";
				$html .= "Impressão Pedido";
				$html .= "</td>";
			$html .= "</tr>";
			$html .= "</table><br />";
			
			$html .= "<table width=\"99%\" cellspacing=\"0\" cellpadding=\"0\" border=\"1\" id=\"tabletest\" class=\"table-relatorio\">";
				$html .= "<tr id=\"linhaDataGrid_\" class=\"titulo\" width=\"100%\">
							<td width=\"10%\" class=\"ColunaInfo\">Código</td>
							<td width=\"35%\"  id=\"linhaDataGrid__0\">Cliente</td>
							<td width=\"30%\" id=\"linhaDataGrid__1\"/>Representante</td>
							<td width=\"15%\"  id=\"linhaDataGrid__0\">Data</td>
							<td width=\"10%\" id=\"linhaDataGrid_1\"/>Status</td>
						</tr>";
			
			for($j=0; $j<count($pedidos); $j++){
				if(($j%2) == 0){
					$linha = "linha";
				}else{
					$linha = "linhaMu";
				}
				$html .= "<tr id=\"linhaDataGrid_\" class=\"".$linha."\" width=\"100%\">
                        <td width=\"10%\" class=\"ColunaInfo\">
                            ".$pedidos[$j]->getCodigo()."
                        </td>
                        <td width=\"40%\" class=\"relatorio\"  id=\"linhaDataGrid__0\">
                            ".$pedidos[$j]->getClienteNome()."
                        </td>
                        <td width=\"30%\" class=\"relatorio\" id=\"linhaDataGrid__1\"/>
                            ".(($pedidos[$j]->getRepresentantesNome()) ? ($pedidos[$j]->getRepresentantesNome()) : "Sem Representante")."
                        </td>
                        <td width=\"10%\" class=\"relatorio\"  id=\"linhaDataGrid__0\">
                            ".$pedidos[$j]->getDataAberta()."
                        </td>
                        <td width=\"10%\" class=\"relatorio\" id=\"linhaDataGrid__1\"/>
                            ".$pedidos[$j]->getStatusNome()."
                        </td>
					</tr>";
					
			}
			
			$html .= "</table>";
			
			if($tipo == "excel"){
				$arquivo = Exportacao::criaArquivo("/", $html);
				Exportacao::gerarExceldeArquivoTemporario($arquivo, "exportacao");
			}else if($tipo == "html"){
				print $html;
			}
			
		}else{
			
			$html .= "\"Código\",\"Cliente\",\"Representante\",\"Data\",\"Status\";\n";
			
			for($j=0; $j<count($pedidos); $j++){
				$html .= "\"".$pedidos[$j]->getCodigo()."\",\"".$pedidos[$j]->getClienteNome()."\",\"".(($pedidos[$j]->getRepresentantesNome()) ? ($pedidos[$j]->getRepresentantesNome()) : "Sem Representante")."\",\"".$pedidos[$j]->getDataAberta()."\",\"".$pedidos[$j]->getStatusNome()."\" ;\n";
			}
			
			$arquivo = Exportacao::criaArquivo("/", $html);
			Exportacao::gerarCsvdeArquivoTemporario($arquivo, "exportacao");
		}
		
	}
	
	public function pegaQtditens($cliente = "", $status = "", $dataIni = "", $dataFim = "" , $codigo = "", $ordem = "", $tipoOrdem = "", $dataEnvioIni = "", $dataEnvioFim = ""){
		$pedidos = $this->pegaPedidos($cliente, $status, "", "", $dataIni, $dataFim, $codigo, $ordem, $tipoOrdem, $dataEnvioIni, $dataEnvioFim, false);
		
		return count($pedidos);
	}

     /**
     *
     * pega pedidos para relatorio fechamento.
     *
     *@param dataIni
     *@param dataFim
     *@return query
     */
    public function pegaPedidosRelatorioFechamento($dataIni, $dataFim){

        $query = "SELECT SUM(pedidos_itens.qtd) as qtd, pedidos.codigo, pedidos.valor_total, pedidos.valor_total_especial, clientes.nome as nome  FROM pedidos
            INNER JOIN pedidos_itens ON pedidos_itens.id_pedidos = pedidos.id
            INNER JOIN clientes ON clientes.id = pedidos.id_clientes
            WHERE pedidos.data_fechada >= '".Formata::date2banco($dataIni)."'
            AND pedidos.data_fechada <= '".Formata::date2banco($dataFim)."'
            AND id_status_pedidos IN ('4', '5') GROUP By pedidos.id
            ";

        //print $query;
        $RetornoConsultaRel = $this->ConexaoSQL->Select($query);

        if(count($RetornoConsultaRel) > 0){
            for($j=0; $j<count($RetornoConsultaRel); $j++){
               $Retorno[$j]["codigo"]=$RetornoConsultaRel[$j]["codigo"];
               $Retorno[$j]["nome"]=$RetornoConsultaRel[$j]["nome"];
               $Retorno[$j]["valor"]=$RetornoConsultaRel[$j]["valor_total"]+$RetornoConsultaRel[$j]["valor_total_especial"];
               $Retorno[$j]["qtd"]=$RetornoConsultaRel[$j]["qtd"];
            }
        }

        return $Retorno;

    }//end function
}
?>