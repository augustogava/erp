<?php
# - - - - - - - - - - - - - - - - ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2009
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 03/02/2009
#  
#  Classe m�todos Ordem Separacao.
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Classe respons�vel pela ordem sepracao..
 *
 * @author Augusto Gava
 * @version 1.0
 */
 
include_once("properties/PropriedadesOrdemSeparacao.php");
include_once("properties/PropriedadesPadrao.php");

class OrdemSeparacao  {
	public $ConexaoSQL;
	public $Padrao;
	
    /**
	 * M�todo construtor.
	 *
	 * @param ConexaoSQL conex�o com o banco
	 * @param Formata 
	 */
    public function OrdemSeparacao($ConexaoSQL, $Padrao){
        $this->ConexaoSQL = $ConexaoSQL;
        $this->Padrao = $Padrao;
    }
    
    /**
	* retorna lista de ordens de separacao.
	*@param clientes.
	*@param status.
	*@return array clientes.
	*/
	public function pegaOrdemSeparacao($produto = "", $pedido = "", $dataIni = "", $dataFim = "", $idOrdem = "", $limite = "", $status = ""){
		
		$qtd = 15;
		if(!empty($produto))
			$busca = " AND ordem_separacao.id_produtos = '".$produto."' ";
		
		if(!empty($pedido))
			$busca .= " AND ordem_separacao.id_pedido = '".$pedido."' ";
			
		if(!empty($dataIni))
			$busca .= " AND ordem_separacao.data_cad >= '".Formata::date2banco($dataIni)."' ";
			
		if(!empty($dataFim))
			$busca .= " AND ordem_separacao.data_cad <= '".Formata::date2banco($dataFim)."' ";
		
		if(!empty($status))
			$busca .= " AND ordem_separacao.id_status_separacao = '".$status."' ";
		
		if(!empty($idOrdem))
			$busca .= " AND ordem_separacao.id = '".$idOrdem."' ";
			
		if(empty($limite) || $limite < 0)
			$limite = "0";

// 		print "SELECT ordem_separacao.*, status_separacao.nome as statusNome FROM ordem_separacao LEFT JOIN status_separacao ON status_separacao.id = ordem_separacao.id_status_separacao WHERE 1 ".$busca." ORDER By ordem_separacao.id DESC Limit ".$limite.", ".$qtd." ";
		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT ordem_separacao.*, status_separacao.nome as statusNome FROM ordem_separacao LEFT JOIN status_separacao ON status_separacao.id = ordem_separacao.id_status_separacao WHERE 1 ".$busca." ORDER By ordem_separacao.id DESC Limit ".$limite.", ".$qtd." ");
    	
		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$Retorno[$j] = new PropriedadesOrdemSeparacao();
				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
				$Retorno[$j]->setProdutos(Pedidos::pegaProduto($RetornoConsultaRel[$j]["id_produtos"]));
				$Retorno[$j]->setPedidos(Pedidos::pegaPedidos("", "", $RetornoConsultaRel[$j]["id_pedido"]));
				
				$Retorno[$j]->setDescricao($RetornoConsultaRel[$j]["descricao"]);
				$Retorno[$j]->setQtd($RetornoConsultaRel[$j]["qtd"]);
				$Retorno[$j]->setStatusId($RetornoConsultaRel[$j]["id_status_separacao"]);
				$Retorno[$j]->setStatusNome($RetornoConsultaRel[$j]["statusNome"]);
				
				$Retorno[$j]->setDataCad(Formata::banco2date($RetornoConsultaRel[$j]["data_cad"]));
				$Retorno[$j]->setDataStatus(Formata::banco2date($RetornoConsultaRel[$j]["data_status"]));
				
				
			}
		}
		
		return $Retorno;
		
	}
	
	/**
	* Salvar ou Adicionar ordem Separacao.
	* @param $id
	*/
	public function salvarOrdemSeparacao($id = "", $produto = "", $pedido = "", $qtd = "", $descricao = "", $data = "", $status = ""){
		if(empty($id)){
			$this->ConexaoSQL->insertQuery("INSERT INTO ordem_separacao (id_produtos, id_pedido, qtd, descricao, id_status_separacao, data_cad) VALUES('".$produto."', '".$pedido."','".$qtd."','".$descricao."', '1', '".Formata::date2banco($data)."')");
		}else{
			$this->ConexaoSQL->updateQuery("UPDATE ordem_separacao SET id_produtos = '".$produto."', descricao = '".$descricao."', id_pedido = '".$pedido."', qtd = '".$qtd."', id_status_separacao= '1', data_cad = '".Formata::date2banco($data)."' WHERE id = '".$id."'");
		}
	}
	
	/**
	* Excluir ordem separacao
	* @param $id
	*/
	public function excluir($id){
		$this->ConexaoSQL->deleteQuery("DELETE FROM ordem_separacao WHERE id = '".$id."'");
	}
	
	/**
	 * Excluir ordem separacao
	 * @param $id
	 */
	public function cancelarOrdem($id){
		$ordem = $this->pegaOrdemSeparacao("", "", "", "", $id);
		if( $ordem[0]->getStatusId() == 2 ){
			$produto 	= $ordem[0]->getProdutos();
			$pedido 	= $ordem[0]->getPedidos();
			
			Pedidos::alteraStatusPedidoSeparado( $pedido[0]->id, 4 );

			if( $this->Padrao->ParametrosVAR["estoque_automatico"] === "true" )
				$this->ConexaoSQL->updateQuery("UPDATE produtos SET estoque_atual = estoque_atual + '". $ordem[0]->getQtd()."' WHERE id = '". $produto[0]->getId(). "'");
			
			$this->ConexaoSQL->updateQuery("UPDATE ordem_separacao SET data_status = NOW(), id_status_separacao = '1' WHERE id = '".$id."'");
		}
	}
	
	/**
	* fechar ordem separacao
	* @param $id
	*/
	public function fecharOrdem($id){
		$ordem = $this->pegaOrdemSeparacao("", "", "", "", $id);
		$pedido = $ordem[0]->getPedidos();
				
		if( $this->Padrao->ParametrosVAR["estoque_automatico"] === "true" ){
			$produto = $ordem[0]->getProdutos();
			if( $produto[0]->getEstoqueAtual() >= $ordem[0]->getQtd()  ){
				Estoque::removeEstoque( $produto[0]->id, $pedido[0]->id, "Ordem Separação: ".$ordem[0]->getId()." para o pedido: ".$pedido[0]->codigo , $ordem[0]->getQtd() );
			}else{
				print "<script>window.alert('Não existe estoque suficiente para este produto Estoque atual: ".$produto[0]->getEstoqueAtual()." ');</script>";
				return ;
			}
		}

		$this->ConexaoSQL->updateQuery("UPDATE ordem_separacao SET data_status = NOW(), id_status_separacao = '2' WHERE id = '".$id."'");
		$lstOrdens = $this->pegaOrdemSeparacao("", $pedido[0]->id, "","","","", 1);// pega todas ordens pra esse pedido que esteja aberta
		if( count($lstOrdens) == 0){//não exste nenhuma aberta, altera status pedido
			Pedidos::alteraStatusPedidoSeparado( $pedido[0]->id, 6 );
		}
	}
	
	/**
	* retorna lista com status ordens de separacao.
	* @param id int
	*@return array status ordem.
	*/
	public function pegaStatusSeparacao( $id = "" ){
		
		if(!empty($id))
			$busca = " AND id = '".$id."' ";
			
		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT * FROM status_separacao WHERE 1 ".$busca." ");
    	
		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$Retorno[$j] = new PropriedadesPadrao();
				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
				$Retorno[$j]->setNome($RetornoConsultaRel[$j]["nome"]);
			}
		}
		
		return $Retorno;
		
	}	
	
}
?>