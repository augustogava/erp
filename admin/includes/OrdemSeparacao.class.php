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
    public $Formata;
    public $Pedidos;
    public $Estoque;
	
    /**
	 * M�todo construtor.
	 *
	 * @param ConexaoSQL conex�o com o banco
	 * @param Formata 
	 */
    public function OrdemSeparacao($ConexaoSQL, $Formata, $Estoque){
        $this->ConexaoSQL = $ConexaoSQL;
        $this->Formata = $Formata;
        $this->Estoque = $Estoque;
    }
    
    public function setPedidos($Pedidos){
    	$this->Pedidos = $Pedidos;    	
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
			$busca .= " AND ordem_separacao.data_cad >= '".$this->Formata->date2banco($dataIni)."' ";
			
		if(!empty($dataFim))
			$busca .= " AND ordem_separacao.data_cad <= '".$this->Formata->date2banco($dataFim)."' ";
		
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
				$Retorno[$j]->setProdutos($this->Pedidos->pegaProduto($RetornoConsultaRel[$j]["id_produtos"]));
				$Retorno[$j]->setPedidos($this->Pedidos->pegaPedidos("", "", $RetornoConsultaRel[$j]["id_pedido"]));
				$Retorno[$j]->setDescricao($RetornoConsultaRel[$j]["descricao"]);
				$Retorno[$j]->setQtd($RetornoConsultaRel[$j]["qtd"]);
				$Retorno[$j]->setStatusId($RetornoConsultaRel[$j]["id_status_separacao"]);
				$Retorno[$j]->setStatusNome($RetornoConsultaRel[$j]["statusNome"]);
				$Retorno[$j]->setDataCad($this->Formata->banco2date($RetornoConsultaRel[$j]["data_cad"]));
				$Retorno[$j]->setDataStatus($this->Formata->banco2date($RetornoConsultaRel[$j]["data_status"]));
				
				
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
			$this->ConexaoSQL->insertQuery("INSERT INTO ordem_separacao (id_produtos, id_pedido, qtd, descricao, id_status_separacao, data_cad) VALUES('".$produto."', '".$pedido."','".$qtd."','".$descricao."', '1', '".$this->Formata->date2banco($data)."')");
		}else{
			$this->ConexaoSQL->updateQuery("UPDATE ordem_separacao SET id_produtos = '".$produto."', descricao = '".$descricao."', id_pedido = '".$pedido."', qtd = '".$qtd."', id_status_separacao= '1', data_cad = '".$this->Formata->date2banco($data)."' WHERE id = '".$id."'");
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
	* fechar ordem separacao
	* @param $id
	*/
	public function fecharOrdem($id){
		$ordem = $this->pegaOrdemSeparacao("", "", "", "", $id);
		$produto = $ordem[0]->getProdutos();
		if( $produto[0]->getEstoqueAtual() >= $ordem[0]->getQtd()  ){
			$pedido = $ordem[0]->getPedidos();
			
			$this->ConexaoSQL->updateQuery("UPDATE ordem_separacao SET data_status = NOW(), id_status_separacao = '2' WHERE id = '".$id."'");
			$this->Estoque->removeEstoque( $produto[0]->id, $pedido[0]->id, "Ordem Separação: ".$ordem[0]->getId()." para o pedido: ".$pedido[0]->codigo , $ordem[0]->getQtd() );
			
			$lstOrdens = $this->pegaOrdemSeparacao("", $pedido[0]->id, "","","","", 1);// pega todas ordens pra esse pedido que esteja aberta
			if( count($lstOrdens) == 0){//não exste nenhuma aberta, altera status pedido
				$this->Pedidos->alteraStatusPedidoSeparado( $pedido[0]->id );
			}
		}else{
			print "<script>window.alert('Não existe estoque suficiente para este produto Estoque atual: ".$produto[0]->getEstoqueAtual()." ');</script>";
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