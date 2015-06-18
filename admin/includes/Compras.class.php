<?php

# - - - - - - - - - - - - - - - - ERP - - - - - - - - - - - - - - - - - -

# ERP

#

#  Copyright (c) 2008

#  Author: Augusto Gava (augusto_gava@msn.com)

#  Criado: 14/1/08

#  

#  Classe m�todos seguran�a

# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



/**

 * Classe respons�vel pelos metodos Pedidos.

 *

 * @author Augusto Gava

 * @version 1.0

 */

 

include_once("properties/PropriedadesItensPedidos.php");

include_once("properties/PropriedadesFornecedores.php");

include_once("properties/PropriedadesProdutos.php");

include_once("properties/PropriedadesFormaPagamento.php");

include_once("properties/PropriedadesCompras.php");

include_once("properties/PropriedadesPadrao.php");



class Compras  {

    public $ConexaoSQL;

    public $Formata;

    public $Configuracoes;

    private $Exportacao;

	

    /**

     * M�todo construtor.

     *

     * @param ConexaoSQL conex�o com o banco

     */

    public function Compras($ConexaoSQL, $Formata, $Configuracoes, $Exportacao){

        $this->ConexaoSQL = $ConexaoSQL;

        $this->Formata = $Formata;

        $this->Configuracoes = $Configuracoes;
		
	$this->Exportacao = $Exportacao;

    }//end function

	

	/**

	* retorna lista de fornecedores.

	*@return array clientes.

	*/

	public function pegaFornecedores( $id = "" ){

		

		if(!empty($id))

			$where = " AND fornecedores.id = '".$id."'";

			

		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT fornecedores.* FROM fornecedores WHERE id_status_geral = '1' ".$where." ORDER By fornecedores.nome ASC");

    	

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

	* retorna lista de tipos de fluxo.

	*@return array clientes.

	*/

	public function pegaTipoFluxo( $id = "" ){



		if(!empty($id))

			$where = " AND tipo_fluxo.id = '".$id."'";



		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT tipo_fluxo.* FROM tipo_fluxo WHERE 1 ".$where." ORDER By tipo_fluxo.nome ASC");



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

	* retorna lista de clientes.

	*@param clientes.

	*@param status.

	*@return array clientes.

	*/

	public function pegaCotacao($id = "", $forn = "", $limite = "", $dataIni = "", $dataFim = "" , $codigo = "", $ordem = "", $tipoOrdem = "", $limitar = true){

		$qtd = ($limitar) ? 30: 99999;
	
		if(!empty($forn))

			$busca = " AND compras.id_fornecedores = '".$forn."' ";

			

		if(!empty($codigo))

			$busca = " AND compras.codigo LIKE '%".$codigo."%' ";
		

		if(!empty($id))

			$busca .= " AND compras.id = '".$id."' ";
			

		if(!empty($dataIni))

			$busca .= " AND compras.data >= '".$this->Formata->date2banco($dataIni)."' ";

			

		if(!empty($dataFim))

			$busca .= " AND compras.data <= '".$this->Formata->date2banco($dataFim)."' ";


		if($_SESSION["niveluser"] != 1 && $_SESSION["niveluser"] != 2)

			$permissao = "INNER JOIN permissoes ON compras.id = permissoes.idtabela AND permissoes.id_usuarios = '".$_SESSION["iduser"]."' AND permissoes.tabela = 'compras'";

			

		if(empty($limite) || $limite < 0)

			$limite = "0";



		if(!empty($ordem)){

			$order = " ORDER By ".$ordem." ".$tipoOrdem." ";

		}else{

			$order = " ORDER By id DESC ";

		}		


		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT compras.*, fornecedores.id as idFornecedores, fornecedores.nome as nomeFornecedores, tipo_fluxo.id as idTipoFluxo, tipo_fluxo.nome as nomeTipoFluxo  FROM compras INNER JOIN fornecedores ON fornecedores.id = compras.id_fornecedores LEFT JOIN tipo_fluxo ON tipo_fluxo.id = compras.id_tipo_fluxo  ".$permissao." WHERE compras.cotacao = 's' ".$busca." ".$order." Limit ".$limite.", ".$qtd." ");
    	

		if(count($RetornoConsultaRel) > 0){

			for($j=0; $j<count($RetornoConsultaRel); $j++){

				$Retorno[$j] = new PropriedadesCompras();

				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);

				$Retorno[$j]->setCodigo($RetornoConsultaRel[$j]["codigo"]);

				$Retorno[$j]->setFornecedoresId($RetornoConsultaRel[$j]["idFornecedores"]);

				$Retorno[$j]->setFornecedoresNome($RetornoConsultaRel[$j]["nomeFornecedores"]);

				$Retorno[$j]->setValorTotal($RetornoConsultaRel[$j]["valor_total"]);

                                $Retorno[$j]->setTipoFluxoId($RetornoConsultaRel[$j]["idTipoFluxo"]);

				$Retorno[$j]->setTipoFluxoNome($RetornoConsultaRel[$j]["nomeTipoFluxo"]);

				$Retorno[$j]->setObs($RetornoConsultaRel[$j]["obs"]);

                                $Retorno[$j]->setStatus($RetornoConsultaRel[$j]["status"]);

				$Retorno[$j]->setImposto($this->Formata->banco2valor($RetornoConsultaRel[$j]["imposto"]));

                                $Retorno[$j]->setDesconto($this->Formata->banco2valor($RetornoConsultaRel[$j]["desconto"]));

				$Retorno[$j]->setDataAberta($this->Formata->banco2date($RetornoConsultaRel[$j]["data"]));

			}

		}

		

		return $Retorno;

		

	}

        /**

	* retorna lista.

	*@param clientes.

	*@param status.

	*@return array clientes.

	*/

	public function pegaCompra($id = "", $forn = "", $limite = "", $dataIni = "", $dataFim = "" , $codigo = "", $ordem = "", $tipoOrdem = "", $limitar = true){

		$qtd = ($limitar) ? 30: 99999;

		if(!empty($forn))

			$busca = " AND compras.id_fornecedores = '".$forn."' ";



		if(!empty($codigo))

			$busca = " AND compras.codigo LIKE '%".$codigo."%' ";


		if(!empty($id))

			$busca .= " AND compras.id = '".$id."' ";


		if(!empty($dataIni))

			$busca .= " AND compras.data >= '".$this->Formata->date2banco($dataIni)."' ";



		if(!empty($dataFim))

			$busca .= " AND compras.data <= '".$this->Formata->date2banco($dataFim)."' ";


		if($_SESSION["niveluser"] != 1 && $_SESSION["niveluser"] != 2)

			$permissao = "INNER JOIN permissoes ON compras.id = permissoes.idtabela AND permissoes.id_usuarios = '".$_SESSION["iduser"]."' AND permissoes.tabela = 'compras'";



		if(empty($limite) || $limite < 0)

			$limite = "0";



		if(!empty($ordem)){

			$order = " ORDER By ".$ordem." ".$tipoOrdem." ";

		}else{

			$order = " ORDER By id DESC ";

		}


                $RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT compras.*, fornecedores.id as idFornecedores, fornecedores.nome as nomeFornecedores, tipo_fluxo.id as idTipoFluxo, tipo_fluxo.nome as nomeTipoFluxo  FROM compras INNER JOIN fornecedores ON fornecedores.id = compras.id_fornecedores LEFT JOIN tipo_fluxo ON tipo_fluxo.id = compras.id_tipo_fluxo  ".$permissao." WHERE compras.cotacao = 'n' ".$busca." ".$order." Limit ".$limite.", ".$qtd." ");



		if(count($RetornoConsultaRel) > 0){

			for($j=0; $j<count($RetornoConsultaRel); $j++){

				$Retorno[$j] = new PropriedadesCompras();

				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);

				$Retorno[$j]->setCodigo($RetornoConsultaRel[$j]["codigo"]);

				$Retorno[$j]->setFornecedoresId($RetornoConsultaRel[$j]["idFornecedores"]);

				$Retorno[$j]->setFornecedoresNome($RetornoConsultaRel[$j]["nomeFornecedores"]);

				$Retorno[$j]->setValorTotal($RetornoConsultaRel[$j]["valor_total"]);

                                $Retorno[$j]->setTipoFluxoId($RetornoConsultaRel[$j]["idTipoFluxo"]);

				$Retorno[$j]->setTipoFluxoNome($RetornoConsultaRel[$j]["nomeTipoFluxo"]);

				$Retorno[$j]->setObs($RetornoConsultaRel[$j]["obs"]);

                                $Retorno[$j]->setStatus($RetornoConsultaRel[$j]["status"]);

				$Retorno[$j]->setImposto($this->Formata->banco2valor($RetornoConsultaRel[$j]["imposto"]));

                                $Retorno[$j]->setDesconto($this->Formata->banco2valor($RetornoConsultaRel[$j]["desconto"]));

				$Retorno[$j]->setDataAberta($this->Formata->banco2date($RetornoConsultaRel[$j]["data"]));

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

	public function pegaCompraEspecifico($id = ""){


		if(!empty($id))
			$busca .= " AND compras.id = '".$id."' ";

                $RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT compras.*, fornecedores.id as idFornecedores, fornecedores.nome as nomeFornecedores, tipo_fluxo.id as idTipoFluxo, tipo_fluxo.nome as nomeTipoFluxo  FROM compras LEFT JOIN fornecedores ON fornecedores.id = compras.id_fornecedores LEFT JOIN tipo_fluxo ON tipo_fluxo.id = compras.id_tipo_fluxo  ".$permissao." WHERE 1 ".$busca."  ");

		if(count($RetornoConsultaRel) > 0){

			for($j=0; $j<count($RetornoConsultaRel); $j++){

				$Retorno[$j] = new PropriedadesCompras();

				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);

				$Retorno[$j]->setCodigo($RetornoConsultaRel[$j]["codigo"]);

				$Retorno[$j]->setFornecedoresId($RetornoConsultaRel[$j]["idFornecedores"]);

				$Retorno[$j]->setFornecedoresNome($RetornoConsultaRel[$j]["nomeFornecedores"]);

                                $Retorno[$j]->setTipoFluxoId($RetornoConsultaRel[$j]["idTipoFluxo"]);

				$Retorno[$j]->setTipoFluxoNome($RetornoConsultaRel[$j]["nomeTipoFluxo"]);

				$Retorno[$j]->setValorTotal($RetornoConsultaRel[$j]["valor_total"]);

				$Retorno[$j]->setObs($RetornoConsultaRel[$j]["obs"]);

                                $Retorno[$j]->setStatus($RetornoConsultaRel[$j]["status"]);

				$Retorno[$j]->setImposto($this->Formata->banco2valor($RetornoConsultaRel[$j]["imposto"]));

                                $Retorno[$j]->setDesconto($this->Formata->banco2valor($RetornoConsultaRel[$j]["desconto"]));

				$Retorno[$j]->setDataAberta($this->Formata->banco2date($RetornoConsultaRel[$j]["data"]));

			}

		}



		return $Retorno;



	}

	

	/**

	* retorna lista de itens do compra.

	*@param clientes.

	*@param status.

	*@return array clientes.

	*/

	public function pegaItensCompra($compra){

		

		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT * FROM compras_itens WHERE id_compras = '".$compra."' ");

    	

		if(count($RetornoConsulta) > 0){

			for($j=0; $j<count($RetornoConsulta); $j++){

				$Retorno[$j] = new PropriedadesItensPedidos();

				$Retorno[$j]->setId($RetornoConsulta[$j]["id"]);

				$Retorno[$j]->setIdPedido($RetornoConsulta[$j]["id_compras"]);

				$Retorno[$j]->setIdProduto($RetornoConsulta[$j]["id_produtos"]);

				$Retorno[$j]->setQtd($RetornoConsulta[$j]["qtd"]);

				$Retorno[$j]->setPreco($RetornoConsulta[$j]["preco"]);

				$Retorno[$j]->setTipoComissao($RetornoConsulta[$j]["tipo_comissao"]);

				$Retorno[$j]->setValorComissao($this->Formata->banco2valor($RetornoConsulta[$j]["comissao_valor"]));

				$Retorno[$j]->setTotal($RetornoConsulta[$j]["total"]);

				$Retorno[$j]->setProdutos($this->pegaProduto($RetornoConsulta[$j]["id_produtos"]));

			}

		}

		

		return $Retorno;

		

	}

        /**

	* retorna lista de formas de pgto

	*@param clientes.

	*@param status.

	*@return array clientes.

	*/

	public function pegaCompraFormaPagamento($compra){



		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT * FROM compras_formaPagamento WHERE id_compras = '".$compra."' ORDER By data ASC ");



		if(count($RetornoConsulta) > 0){

			for($j=0; $j<count($RetornoConsulta); $j++){

				$Retorno[$j] = new PropriedadesFormaPagamento();

				$Retorno[$j]->setId($RetornoConsulta[$j]["id"]);

				$Retorno[$j]->setValor($RetornoConsulta[$j]["valor"]);

                                $Retorno[$j]->setData($RetornoConsulta[$j]["data"]);

			}

		}



		return $Retorno;



	}

	

	/**

	* Adicionar item pedido.

	*@param idPedido.

	*@return id PK.

	*/

	public function adicionaItemCompra($idCompra){

		$this->ConexaoSQL->insertQuery("INSERT INTO compras_itens (id_compras, data_cad) VALUES('".$idCompra."', NOW())");

		return $this->ConexaoSQL->pegaLastId();

	}

        /**

	* Adicionar item pedido.

	*@param idPedido.

	*@return id PK.

	*/

	public function adicionaFormaPgtoCompra($idCompra){

            $dadosCompra = $this->pegaCompraEspecifico($idCompra);

            $RetornoConsulta = $this->ConexaoSQL->Select("SELECT sum(total) as total FROM compras_itens WHERE compras_itens.id_compras = '".$idCompra."' ");

            $RetornoConsultaForma = $this->ConexaoSQL->Select("SELECT sum(valor) as total FROM compras_formaPagamento WHERE compras_formaPagamento.id_compras = '".$idCompra."' ");
            
            $this->ConexaoSQL->insertQuery("INSERT INTO compras_formaPagamento (id_compras, data, valor) VALUES('".$idCompra."', NOW(), '".(($RetornoConsulta[0]["total"]-$this->Formata->valor2banco($dadosCompra[0]->getDesconto())+$this->Formata->valor2banco($dadosCompra[0]->getImposto()) )-$RetornoConsultaForma[0]["total"])."') ");

            return $this->ConexaoSQL->pegaLastId();

	}

	

	/**

	* retorna qtd em estoque do produto.

	*@param produto.

	*@return qtd int.

	*/

	public function pegaEstoqueProduto($produto){

		

		$RetornoEntrada = $this->ConexaoSQL->Select("SELECT sum(qtd) as totalEntrada FROM estoque WHERE tipo = 1 AND id_produtos = '".$produto."' ");

		$RetornoSaida = $this->ConexaoSQL->Select("SELECT sum(qtd) as totalSaida FROM estoque WHERE tipo = 2 AND id_produtos = '".$produto."' ");

    	

                $qtd = $RetornoEntrada[0]["totalEntrada"] - $RetornoSaida[0]["totalSaida"];

		
		return $qtd;

		

	}

        /**

	* Virar Compra.

	*@param idPedido.

	*/

	public function virarCompra($idCompra){

		$this->ConexaoSQL->updateQuery("UPDATE compras SET cotacao = 'n', status = '0' WHERE id = '".$idCompra."'");

        }
	/**

	* Fechar Pedido.

	*@param idPedido.

	*/

	public function fecharCompra($idCompra, $fluxo = "s"){

		$dadosCompra = $this->pegaCompraEspecifico($idCompra);

		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT sum(total) as total FROM compras_itens WHERE compras_itens.id_compras = '".$idCompra."' ");

                $RetornoConsultaForma = $this->ConexaoSQL->Select("SELECT sum(valor) as total FROM compras_formaPagamento WHERE compras_formaPagamento.id_compras = '".$idCompra."' ");

                if( ( $RetornoConsulta[0]["total"]-$this->Formata->valor2banco($dadosCompra[0]->getDesconto())+$this->Formata->valor2banco($dadosCompra[0]->getImposto()) ) != $RetornoConsultaForma[0]["total"]){
                    $this->ConexaoSQL->updateQuery("UPDATE compras SET status = '0' WHERE id = '".$idCompra."'");
                    $this->ConexaoSQL->deleteQuery("DELETE FROM estoque WHERE id_compras = '".$idCompra."'");
                            $this->ConexaoSQL->deleteQuery("DELETE FROM fluxo WHERE id_compras = '".$idCompra."'");
                    print "<script>window.alert('Formas pagamentos errado, valor total deve ser igual total compra!')</script>";
                }else{

                    $precoTotal = $RetornoConsulta[0]["total"];



                    $this->ConexaoSQL->updateQuery("UPDATE compras SET status = '1' WHERE id = '".$idCompra."'");



                    $RetornoConsulta = $this->ConexaoSQL->Select("SELECT * FROM compras_itens WHERE id_compras = '".$idCompra."' ");

                    $RetornoFormasPgto = $this->ConexaoSQL->Select("SELECT * FROM compras_formaPagamento WHERE id_compras = '".$idCompra."' ");



                    if(count($RetornoConsulta) > 0){

                            //Deleta lixo

                            $this->ConexaoSQL->deleteQuery("DELETE FROM estoque WHERE id_compras = '".$idCompra."'");
                            $this->ConexaoSQL->deleteQuery("DELETE FROM fluxo WHERE id_compras = '".$idCompra."'");


                            //INSERE ESTOQUE

                            for($j=0; $j<count($RetornoConsulta); $j++){

                                    $this->ConexaoSQL->insertQuery("INSERT INTO estoque (id_produtos, id_compras, descricao, tipo, qtd, preco, data) VALUES('".$RetornoConsulta[$j]["id_produtos"]."', '".$idCompra."', 'Compra: ".$dadosCompra[0]->getCodigo()." ', '1','".$RetornoConsulta[$j]["qtd"]."','".$RetornoConsulta[$j]["preco"]."', NOW())");

                            }

                            //INSERE Fluxo
                            if($fluxo == "s"){
                                for($j=0; $j<count($RetornoFormasPgto); $j++){

                                        $this->ConexaoSQL->insertQuery("INSERT INTO fluxo (id_fornecedores, id_tipo_fluxo, id_compras, ocorrencia, data, tipo, valor) VALUES('".$dadosCompra[0]->getFornecedoresId()."', '".$dadosCompra[0]->getTipoFluxoId()."', '".$idCompra."', 'C�digo Compra: ".$dadosCompra[0]->getCodigo()."', '".$RetornoFormasPgto[$j]["data"]."', '2', '".$RetornoFormasPgto[$j]["valor"]."')");

                                }
                            }
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

		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT * FROM compras INNER JOIN compras_itens ON compras_itens.id_compras = compras.id WHERE compras_itens.id = '".$idItem."' ");

		if(count($RetornoConsulta) > 0){

			if($campo == "id_produtos"){

				$RetornoConsulta = $this->ConexaoSQL->Select("SELECT id_compras FROM compras_itens WHERE id = '".$idItem."'");

				if(count($RetornoConsulta) > 0){

					$RetornoConsultaVerifica = $this->ConexaoSQL->Select("SELECT id FROM compras_itens WHERE id_compras = '".$RetornoConsulta[0]["id_pedidos"]."' AND id_produtos = '".$valor."'");

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

				$valor = $this->Formata->valor2banco($valor);

			}



			$this->ConexaoSQL->updateQuery("UPDATE compras_itens SET ".$campo." = '".$valor."' WHERE id = '".$idItem."'");

			$this->ConexaoSQL->updateQuery("UPDATE compras_itens SET total = qtd * preco WHERE id = '".$idItem."'");

			

			$RetornoConsulta = $this->ConexaoSQL->Select("SELECT id_produtos, id_compras FROM compras_itens WHERE id = '".$idItem."'");

			

			$this->verficaFechado($RetornoConsulta[0]["id_compras"]);

			

			print "<script>selecionaProdutoItenCompra(".$RetornoConsulta[0]["id_produtos"].", ".$indice.", ".$idItem.");</script>";

		}else{

			print "<script>window.alert('Produto j� cadastrado')</script>";

		}

	}

        /**

	* salva Forma Pgto

	*@param cliente.

	*@param status.

	*@return id PK.

	*/

	public function salvarFormaPgto($campo, $valor, $idItem, $indice = ""){

		$salvar = false;

		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT * FROM compras INNER JOIN compras_itens ON compras_itens.id_compras = compras.id WHERE compras_itens.id = '".$idItem."' ");


                if($campo == "valor"){

                        $valor = $this->Formata->valor2banco($valor);

                }else  if($campo == "data"){

                    $valor = $this->Formata->date2banco($valor);

                }



                $this->ConexaoSQL->updateQuery("UPDATE compras_formaPagamento SET ".$campo." = '".$valor."' WHERE id = '".$idItem."'");

                $RetornoConsulta = $this->ConexaoSQL->Select("SELECT id_compras FROM compras_formaPagamento WHERE id = '".$idItem."'");



                $this->verficaFechado($RetornoConsulta[0]["id_compras"]);

	}


	

	/**

	* salva  compra.

	*@param cliente.

	*@param status.

	*@return id PK.

	*/

	public function salvarCompra($id, $fornecedores, $codigo, $obs, $imposto, $desconto, $tipoFluxo){

	

		$this->ConexaoSQL->updateQuery("UPDATE compras SET desconto = '".$this->Formata->valor2banco($desconto)."', imposto = '".$this->Formata->valor2banco($imposto)."', obs = '".$obs."', codigo = '".$codigo."', id_fornecedores = '".$fornecedores."', id_tipo_fluxo = '".$tipoFluxo."' WHERE id = '".$id."'");

		
		$this->verficaFechado($id);

	}

	

	/**

	 * Verifica se est� fechado.

	 * @param id

	 */

	public function verficaFechado( $id ){

		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT status, cotacao FROM compras WHERE id = '".$id."' AND status IN (1) ");

		if(count($RetornoConsulta) > 0){
                        print 1;
			if($RetornoConsulta[0]["status"] == 1 && $RetornoConsulta[0]["cotacao"] == "n" ){
print 2;
				$this->fecharCompra($id);

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

			}

		}

		

		return $Retorno;

		

	}

	

	/**

	* Deletar pedido.

	*@param id.

	*/

	public function excluirCompra($id){

		//Exclui lixo

		$this->ConexaoSQL->deleteQuery("DELETE FROM estoque WHERE id_compras = '".$id."'");

		$this->ConexaoSQL->deleteQuery("DELETE FROM fluxo WHERE id_compras = '".$id."'");

		$this->ConexaoSQL->deleteQuery("DELETE FROM compras WHERE id = '".$id."'");

                $this->ConexaoSQL->deleteQuery("DELETE FROM compras_itens WHERE id_compras = '".$id."'");

	}

	

	/**

	* Deletar item pedido.

	*@param id.

	*/

	public function excluirItemCompra($id){


            $RetornoConsulta = $this->ConexaoSQL->Select("SELECT id_compras FROM compras_itens WHERE id = '".$id."' ");

            $this->ConexaoSQL->updateQuery("UPDATE compras SET status = '0' WHERE id = '".$RetornoConsulta[0]["id_compras"]."'");
           
            $this->ConexaoSQL->deleteQuery("DELETE FROM estoque WHERE id_compras = '".$RetornoConsulta[0]["id_compras"]."'");

            $this->ConexaoSQL->deleteQuery("DELETE FROM fluxo WHERE id_compras = '".$RetornoConsulta[0]["id_compras"]."'");
            
            $this->ConexaoSQL->deleteQuery("DELETE FROM compras_itens WHERE id = '".$id."'");

	}

        /**

	* Deletar forma pgto.

	*@param id.

	*/

	public function excluirFormaPgtoCompra($id){

            $RetornoConsulta = $this->ConexaoSQL->Select("SELECT id_compras FROM compras_formaPagamento WHERE id = '".$id."' ");

            $this->ConexaoSQL->updateQuery("UPDATE compras SET status = '0' WHERE id = '".$RetornoConsulta[0]["id_compras"]."'");
            
            $this->ConexaoSQL->deleteQuery("DELETE FROM estoque WHERE id_compras = '".$RetornoConsulta[0]["id_compras"]."'");

            $this->ConexaoSQL->deleteQuery("DELETE FROM fluxo WHERE id_compras = '".$RetornoConsulta[0]["id_compras"]."'");
            
            $this->ConexaoSQL->deleteQuery("DELETE FROM compras_formaPagamento  WHERE id = '".$id."'");

	}

	

	/**

	* Adicionar Cotacao.

	*@param cliente.

	*@param status.

	*@return id PK.

	*/

	public function adicionarCotacao($fornecedores = "", $status = ""){

		$this->ConexaoSQL->deleteQuery("DELETE FROM compras WHERE id_fornecedores = '0' AND id_status_pedidos IN (0, 1) ");

		$this->ConexaoSQL->insertQuery("INSERT INTO compras (id_fornecedores, data, cotacao) VALUES('".$fornecedores."', NOW(), 's')");

		$this->ConexaoSQL->insertQuery("INSERT INTO compras_itens (id_compras) VALUES('".$this->pegaUltimoId()."') ");

                $this->ConexaoSQL->insertQuery("INSERT INTO compras_formaPagamento  (id_compras) VALUES('".$this->pegaUltimoId()."') ");

	
		return $this->pegaUltimoId();

	}

        /**

	* Adicionar Cotacao.

	*@param cliente.

	*@param status.

	*@return id PK.

	*/

	public function adicionarCompra($fornecedores = "", $status = ""){

		$this->ConexaoSQL->deleteQuery("DELETE FROM compras WHERE id_fornecedores = '0' AND id_status_pedidos IN (0, 1) ");

		$this->ConexaoSQL->insertQuery("INSERT INTO compras (id_fornecedores, data, cotacao) VALUES('".$fornecedores."', NOW(), 'n')");

		$this->ConexaoSQL->insertQuery("INSERT INTO compras_itens (id_compras) VALUES('".$this->pegaUltimoId()."') ");

                $this->ConexaoSQL->insertQuery("INSERT INTO compras_formaPagamento  (id_compras) VALUES('".$this->pegaUltimoId()."') ");


		return $this->pegaUltimoId();

	}

	

	/**

	* Adicionar pedido.

	*@return id PK.

	*/

	public function pegaUltimoId(){

	

		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT max(id) as id FROM compras ");

    	

		if(count($RetornoConsulta) > 0){

				return $RetornoConsulta[0]["id"];

		}

	}

	

	/**

	 * Monta html usado para abrir o relatorio ou email.

	 * @param $idPedido.

	 * @return html.

	 */

	function montaHTMLRelatorio($idCompra, $tipo = ""){

		$dadosCompra = $this->pegaCompraEspecifico( $idCompra);

/*		if($dadosPedido[0]->getTipoComissao() == 1){

			$tipo = "%";

		}else{

			$tipo = "Valor";

		}*/

		$itens = $this->pegaItensHTMLCompra($idCompra);

		

		$fluxoTemplate = file($this->Configuracoes->TemplateArquivoCompra);//chama o arquivo do p

		$fluxoTemplateSaida = "";

		

		foreach ($fluxoTemplate as $fluxoTemplateHTML) {

			$fluxoTemplateSaida.= $fluxoTemplateHTML;//imprime o retorno

		}

		

		$fornDados = $this->pegaFornecedores($dadosCompra[0]->getFornecedoresId());

		

		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT sum(total) as total FROM compras_itens WHERE compras_itens.id_compras = '".$idCompra."' ");

		

		$precoTotal = $RetornoConsulta[0]["total"];

		

		$pt = explode("/", $dadosCompra[0]->getCodigo());

		

		if(count($pt) > 1){

			$codigoNovo = $dadosCompra[0]->getCodigo();

		}else{

			$codigoNovo = $dadosCompra[0]->getCodigo()."/".date("y");

		}

		
                $fluxoTemplateSaida = ereg_replace("%TIPO%", $tipo, $fluxoTemplateSaida);

		$fluxoTemplateSaida = ereg_replace("%PEDIDO%", $codigoNovo, $fluxoTemplateSaida);

		$fluxoTemplateSaida = ereg_replace("%FORNECEDOR%",$dadosCompra[0]->getFornecedoresNome(), $fluxoTemplateSaida);


		$fluxoTemplateSaida = ereg_replace("%OBS%",$dadosCompra[0]->getObs(), $fluxoTemplateSaida);

                $fluxoTemplateSaida = ereg_replace("%TIPOFLUXO%",$dadosCompra[0]->getTipoFluxoNome(), $fluxoTemplateSaida);

		$fluxoTemplateSaida = ereg_replace("%DATA%", $this->Formata->banco2date($dadosCompra[0]->getDataAberta()), $fluxoTemplateSaida);

		$fluxoTemplateSaida = ereg_replace("%ITENS%",$itens, $fluxoTemplateSaida);


                $saidaParcelas .= "<tr style=\"background:#CFDEFF;color:#215DF6;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">

							<td width=\"20%\" class=\"ColunaInfo\" style=\"text-align:left;\"> Parcelamento</td>

							<td width=\"20%\" class=\"ColunaInfo\" style=\"text-align:left;\"></td>

							<td width=\"60%\" class=\"ColunaInfo\" style=\"text-align:left;\"></td>

						</tr>";
                $formasPagto = $this->pegaCompraFormaPagamento($idCompra);
                for($i=0; $i<count($formasPagto); $i++){

                    $precoTotal += $formasPagto[$i]->getValor();
                    $saidaParcelas .= "<tr style=\"background:#EBF0FD;color:#215DF6;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">

							<td width=\"20%\" class=\"ColunaInfo\" style=\"text-align:left;\"> Parcela: ".($i+1)." </td>

							<td width=\"20%\" class=\"ColunaInfo\" style=\"text-align:left;\">".$this->Formata->banco2date($formasPagto[$i]->getData())."</td>

							<td width=\"60%\" class=\"ColunaInfo\" style=\"text-align:left;\">".$this->Formata->banco2valor($formasPagto[$i]->getValor())."</td>

						</tr>";

                }
		$fluxoTemplateSaida = ereg_replace("%PARCELAS%", $saidaParcelas, $fluxoTemplateSaida);

		$padraoTemplate = file($this->Configuracoes->TemplateArquivoEmail);//chama o arquivo do p

		$padraoTemplateSaida = "";

		

		foreach ($padraoTemplate as $padraoTemplateHTML) {

			$padraoTemplateSaida.= $padraoTemplateHTML;//imprime o retorno

		}

		

		$padraoTemplateSaida = ereg_replace("%CONTEUDOEMAIL%",$fluxoTemplateSaida, $padraoTemplateSaida);


		

		return $padraoTemplateSaida;

		

	}

	

	function pegaItensHTMLCompra($idCompra){

		$dadosCompra = $this->pegaCompraEspecifico($idCompra);

		$itens = $this->pegaItensCompra($idCompra);

		

		$return = "<tr style=\"background:#CFDEFF;color:#215DF6;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">

						<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\">Cod</td>

						<td width=\"50%\" class=\"ColunaInfo\" style=\"text-align:left;\">Produto</td>

						<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\">Qtd</td>

						<td width=\"15%\" class=\"ColunaInfo\" style=\"text-align:left;\">Valor</td>

						<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\">Total</td>

					</tr>";

		for($i=0; $i<count($itens); $i++){

			$produtoItem = $itens[$i]->getProdutos();

			if($produtoItem[0]){

				$codigo = $produtoItem[0]->getCodigo();

				$qtdTotal += $itens[$i]->getQtd();

				$precoTotal += $itens[$i]->getTotal();

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

					".$this->Formata->banco2valor($itens[$i]->getPreco())."

				</td>

				<td width=\"10%\" style=\"text-align:left;\" id =\"campoTotal_<?=$i?>\">

					".$this->Formata->banco2valor($itens[$i]->getTotal())."

				</td>

			</tr>";

		}
			
	$return .= "<tr style=\"background: #EBF0FD;height:32px;\">

				<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\">&nbsp;<strong>Total</strong></td>

				<td width=\"50%\" class=\"ColunaInfo\" style=\"text-align:left;\">&nbsp;</td>

				<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\"><strong>".$qtdTotal."</strong></td>

				<td width=\"15%\" class=\"ColunaInfo\" style=\"text-align:left;\" >&nbsp;</td>

				<td width=\"10%\" class=\"ColunaInfo\" style=\"text-align:left;\"><strong>".$this->Formata->banco2valor( ($precoTotal))."</strong></td>

			</tr>";

			
			$return .= "<tr style=\"background: #EBF0FD;height:32px;\">

				<td colspan=\"5\" style=\"text-align:right;\">
					<table width=\"20%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"right\">
						<tr style=\"background:#CFDEFF;color:#215DF6;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
							<td width=\"100%\" class=\"ColunaInfo\" style=\"text-align:left;\">Imposto</td>
						</tr>
						<tr style=\"background:#EBF0FD;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
							<td width=\"100%\" class=\"ColunaInfo\" style=\"text-align:left;\">".$dadosCompra[0]->getImposto()."</td>
						</tr>
						<tr style=\"background:#CFDEFF;color:#215DF6;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
							<td width=\"100%\" class=\"ColunaInfo\" style=\"text-align:left;\">Desconto</td>
						</tr>
						<tr style=\"background:#EBF0FD;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
							<td width=\"100%\" class=\"ColunaInfo\" style=\"text-align:left;\">".$dadosCompra[0]->getDesconto()."</td>
						</tr>
						
						
						
						<tr style=\"background:#CFDEFF;color:#215DF6;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
							<td width=\"100%\" class=\"ColunaInfo\" style=\"text-align:left;\">Total Pedido</td>
						</tr>
						<tr style=\"background:#EBF0FD;border-bottom: 1px solid #000;font-weight: bold;height:26px;\">
							<td width=\"100%\" class=\"ColunaInfo\" style=\"text-align:left;\">".$this->Formata->banco2valor($this->Formata->valor2banco($dadosCompra[0]->getImposto())+$precoTotal-$this->Formata->valor2banco($dadosCompra[0]->getDesconto()))."</td>
						</tr>
						
					</table>

				</td>
				
			</tr>";

		return $return;

					

	}

	


	

	/**

	 * Gera c�digo para pedido, formato YYYY/000increment.

	 */

	function pegaCodigoNovo(){

		$RetornoConsulta = $this->ConexaoSQL->Select("SELECT codigo FROM compras WHERE codigo != '' ORDER By ID DESC Limit 1");

		if(count($RetornoConsulta) > 0){

			

			$pt = $RetornoConsulta[0]["codigo"];

			

			$codigo = $this->Formata->preencheZero(($pt+1), 4);

			

		}else{

			$codigo = "00001";

		}

		

		return $codigo;

	}
	
	/**
	* Exportacao tela.
	*/
	public function exportar($fornecedores = "", $dataIni = "", $dataFim = "" , $codigo = "", $ordem = "", $tipoOrdem = "", $tipo, $tipoR = ""){
		
            if($tipoR == "Compra" ){
                $compras = $this->pegaCompra("", $fornecedores, "", $dataIni, $dataFim , $codigo, $ordem, $tipoOrdem, false);
            }else{
                $compras = $this->pegaCotacao("", $fornecedores, "", $dataIni, $dataFim , $codigo, $ordem, $tipoOrdem, false);
            }

		
		if($tipo != "csv"){
			$html = "<table border=\"1\" width=\"100%\" height=\"100px\"  cellpadding=\"0\" cellspacing=\"5\" align=\"left\">";
			$html .= "<tr class=\"tituloRelatorio\">";
				
				if($tipo == "html"){
					$html .= "<td width='10%'>";
					$html .= "<img src=\"layout/incones/exportar.png\" width=\"30px\" border='1' alt=\"Imprimir\" onclick=\"main.imprimir();\"  /> ";
					$html .= "</td>";
				}

				$html .= "<td  width='90%' align='center'>";
					$html .= "Impress�o ".$tipoR;
				$html .= "</td>";
			$html .= "</tr>";
			$html .= "</table><br />";
			
			$html .= "<table width=\"99%\" cellspacing=\"0\" cellpadding=\"0\" border=\"1\" id=\"tabletest\">";
			
				$html .= "<tr id=\"linhaDataGrid_\" class=\"titulo\" width=\"100%\">
	
							<td width=\"10%\" class=\"ColunaInfo\">C�digo</td>
				
							<td width=\"35%\"  id=\"linhaDataGrid__0\">Fornecedor</td>
				
							<td width=\"30%\" id=\"linhaDataGrid__1\"/>Tipo Fluxo</td>
				
							<td width=\"15%\"  id=\"linhaDataGrid__0\">Data</td>
				
							<td width=\"10%\" id=\"linhaDataGrid_1\"/>Status</td>
						</tr>";
			
			for($j=0; $j<count($compras); $j++){
				if(($j%2) == 0){

					$linha = "linha";

				}else{

					$linha = "linhaMu";

				}

                                if($compras[$j]->getStatus()==0){
                                    $status = "Aberto";
                                }else{
                                    $status = "Fechado";
                                }
				
				$html .= "<tr id=\"linhaDataGrid_\" class=\"".$linha."\" width=\"100%\">

                        <td width=\"10%\" class=\"ColunaInfo\">
            
                            ".$compras[$j]->getCodigo()."
            
                        </td>
            
                        <td width=\"40%\" class=\"relatorio\"  id=\"linhaDataGrid__0\">
            
                            ".$compras[$j]->getFornecedoresNome()."
            
                        </td>
            
                        <td width=\"30%\" class=\"relatorio\" id=\"linhaDataGrid__1\"/>
            
                            ".$compras[$j]->getTipoFluxoNome()."
            
                        </td>
            
                        <td width=\"10%\" class=\"relatorio\"  id=\"linhaDataGrid__0\">
            
                            ".$compras[$j]->getDataAberta()."
            
                        </td>
            
                        <td width=\"10%\" class=\"relatorio\" id=\"linhaDataGrid__1\"/>
            
                            ".$status."
            
                        </td>
					</tr>";
					
			}
			
			$html .= "</table>";
			
			if($tipo == "excel"){
				$arquivo = $this->Exportacao->criaArquivo("/", $html);
				$this->Exportacao->gerarExceldeArquivoTemporario($arquivo, "exportacao");
			}else if($tipo == "html"){
				print $html;
			}
			
		}else{
			
			$html .= "\"C�digo\",\"Fornecedores\",\"Tipo Fluxo\",\"Data\",\"Status\";\n";
			
			for($j=0; $j<count($compras); $j++){
                            if($compras[$j]->getStatus()==0){
                                    $status = "Aberto";
                                }else{
                                    $status = "Fechado";
                                }
                            $html .= "\"".$compras[$j]->getCodigo()."\",\"".$compras[$j]->getFornecedoresNome()."\",\"".$compras[$j]->getTipoFluxoNome()."\",\"".$compras[$j]->getDataAberta()."\",\"".$status."\" ;\n";
			}
			
			$arquivo = $this->Exportacao->criaArquivo("/", $html);
			$this->Exportacao->gerarCsvdeArquivoTemporario($arquivo, "exportacao");
		}
		
	}
	
	public function pegaQtditensCotacao($fornecedores = "", $dataIni = "", $dataFim = "" , $codigo = "", $ordem = "", $tipoOrdem = ""){
		
		$compras = $this->pegaCotacao("", $fornecedores, "", $dataIni, $dataFim , $codigo, $ordem, $tipoOrdem, false);
		
		return count($compras);
		
	}

        public function pegaQtditensCompras($fornecedores = "", $dataIni = "", $dataFim = "" , $codigo = "", $ordem = "", $tipoOrdem = ""){

		$compras = $this->pegaCompra("", $fornecedores, "", $dataIni, $dataFim , $codigo, $ordem, $tipoOrdem, false);

		return count($compras);

	}
	
}

?>