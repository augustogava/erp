<?php
# - - - - - - - - - - - - - - - - ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2009
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 03/02/2009
#  
#  Classe m�todos Ordem Producao.
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Classe respons�vel pelos metodos Pedidos.
 *
 * @author Augusto Gava
 * @version 1.0
 */
 
include_once("properties/PropriedadesOrdemProducao.php");
include_once("properties/PropriedadesPadrao.php");

class OrdemProducao  {
	public $ConexaoSQL;
    public $Formata;
    public $Pedidos;
    public $Estoque;
	
    /**
	 * M�todo construtor.
	 *
	 * @param ConexaoSQL conex�o com o banco
	 * @param Formata 
	 */
    public function OrdemProducao($ConexaoSQL, $Formata, $Pedidos, $Estoque){
        $this->ConexaoSQL = $ConexaoSQL;
        $this->Formata = $Formata;
        $this->Pedidos = $Pedidos;
        $this->Estoque = $Estoque;
    }
    
    /**
	* retorna lista de ordens de producao.
	*@param clientes.
	*@param status.
	*@return array clientes.
	*/
	public function pegaOrdemProducao($produto = "", $pedido = "", $dataIni = "", $dataFim = "", $idOrdem = "", $limite = ""){
		$qtd = 15;
		if(!empty($produto))
			$busca = " AND ordem_producao.id_produtos = '".$produto."' ";
		
		if(!empty($pedido))
			$busca .= " AND ordem_producao.id_pedido = '".$pedido."' ";
			
		if(!empty($dataIni))
			$busca .= " AND ordem_producao.data_cad >= '".$this->Formata->date2banco($dataIni)."' ";
			
		if(!empty($dataFim))
			$busca .= " AND ordem_producao.data_cad <= '".$this->Formata->date2banco($dataFim)."' ";
		
		if(!empty($idOrdem))
			$busca .= " AND ordem_producao.id = '".$idOrdem."' ";
			
		if(empty($limite) || $limite < 0)
			$limite = "0";

		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT ordem_producao.*, status_ordem.nome as statusNome FROM ordem_producao LEFT JOIN status_ordem ON status_ordem.id = ordem_producao.id_status_ordem WHERE 1 ".$busca." ORDER By ordem_producao.id DESC Limit ".$limite.", ".$qtd." ");
    	
		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$Retorno[$j] = new PropriedadesOrdemProducao();
				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
				$Retorno[$j]->setProdutos($this->Pedidos->pegaProduto($RetornoConsultaRel[$j]["id_produtos"]));
				$Retorno[$j]->setPedidos($this->Pedidos->pegaPedidos("", "", $RetornoConsultaRel[$j]["id_pedido"]));
				$Retorno[$j]->setDescricao($RetornoConsultaRel[$j]["descricao"]);
				$Retorno[$j]->setQtd($RetornoConsultaRel[$j]["qtd"]);
				$Retorno[$j]->setStatusId($RetornoConsultaRel[$j]["id_status_ordem"]);
				$Retorno[$j]->setStatusNome($RetornoConsultaRel[$j]["statusNome"]);
				$Retorno[$j]->setDataCad($this->Formata->banco2date($RetornoConsultaRel[$j]["data_cad"]));
				$Retorno[$j]->setDataStatus($this->Formata->banco2date($RetornoConsultaRel[$j]["data_status"]));
				
				
			}
		}
		
		return $Retorno;
		
	}
	
	/**
	* Salvar ou Adicionar ordem producao.
	* @param $id
	*/
	public function salvarOrdemProducao($id = "", $produto = "", $pedido = "", $qtd = "", $descricao = "", $data = "", $status = ""){
		if(empty($id)){
			$this->ConexaoSQL->insertQuery("INSERT INTO ordem_producao (id_produtos, id_pedido, qtd, descricao, id_status_ordem, data_cad) VALUES('".$produto."', '".$pedido."','".$qtd."','".$descricao."', '1', '".$this->Formata->date2banco($data)."')");
		}else{
			$this->ConexaoSQL->updateQuery("UPDATE ordem_producao SET id_produtos = '".$produto."', descricao = '".$descricao."', id_pedido = '".$pedido."', qtd = '".$qtd."', id_status_ordem= '1', data_cad = '".$this->Formata->date2banco($data)."' WHERE id = '".$id."'");
		}
	}
	
	/**
	* Excluir ordem producao
	* @param $id
	*/
	public function excluir($id){
			$this->ConexaoSQL->deleteQuery("DELETE FROM ordem_producao WHERE id = '".$id."'");
	}
	
	/**
	 * produzir ordem producao
	 * @param $id
	 */
	public function produzirOrdem($id){
// 		$ordem = $this->pegaOrdemProducao("", "", "", "", $id);
// 		$produto = $ordem[0]->getProdutos();
// 		$pedido = $ordem[0]->getPedidos();
	
		$this->ConexaoSQL->updateQuery("UPDATE ordem_producao SET id_status_ordem = '4' WHERE id = '".$id."'");
	}
	
	/**
	* fechar ordem producao
	* @param $id
	*/
	public function fecharOrdem($id){
		$ordem = $this->pegaOrdemProducao("", "", "", "", $id);
		$produto = $ordem[0]->getProdutos();
		$pedido = $ordem[0]->getPedidos();
		
		$this->ConexaoSQL->updateQuery("UPDATE ordem_producao SET data_status = NOW(), id_status_ordem = '2' WHERE id = '".$id."'");
		$this->Estoque->adicionaEstoque( $produto[0]->id, $pedido[0]->id, "Ordem Produção: ".$ordem[0]->getId()." para o pedido: ".$pedido[0]->codigo , $ordem[0]->getQtd() );
	}
	
	/**
	* retorna lista com status ordens de producao.
	* @param id int
	*@return array status ordem.
	*/
	public function pegaStatusOrdem( $id = "" ){
		
		if(!empty($id))
			$busca = " AND id = '".$id."' ";
			
		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT * FROM status_ordem WHERE 1 ".$busca." ");
    	
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