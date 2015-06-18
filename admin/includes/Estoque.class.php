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
 
include_once("properties/PropriedadesEstoque.php");
include_once("properties/PropriedadesPadrao.php");

class Estoque  {
	public $ConexaoSQL;
    public $Formata;
	
    /**
	 * M�todo construtor.
	 *
	 * @param ConexaoSQL conex�o com o banco
	 */
    public function Estoque($ConexaoSQL, $Formata){
        $this->ConexaoSQL = $ConexaoSQL;
        $this->Formata = $Formata;
    }
    
    /**
	* retorna lista de clientes.
	*@param clientes.
	*@param status.
	*@return array clientes.
	*/
	public function pegaEstoque($produto = "", $tipo = "", $dataIni = "", $dataFim = "", $idEstoque = "", $limite = ""){
		$qtd = 15;
		if(!empty($produto))
			$busca = " AND estoque.id_produtos = '".$produto."' ";
		
		if(!empty($tipo))
			$busca .= " AND estoque.tipo = '".$tipo."' ";
			
		if(!empty($dataIni))
			$busca .= " AND estoque.data >= '".$this->Formata->date2banco($dataIni)."' ";
			
		if(!empty($dataFim))
			$busca .= " AND estoque.data <= '".$this->Formata->date2banco($dataFim)."' ";
		
		if(!empty($idEstoque))
			$busca .= " AND estoque.id = '".$idEstoque."' ";
			
		if(empty($limite) || $limite < 0)
			$limite = "0";

		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT estoque.*, produtos.id as IdProduto, produtos.nome as nomeProduto, produtos.codigo as codigoProduto FROM estoque INNER JOIN produtos ON produtos.id = estoque.id_produtos WHERE 1 ".$busca." ORDER By id DESC Limit ".$limite.", ".$qtd." ");
    	
		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$Retorno[$j] = new PropriedadesEstoque();
				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
				$Retorno[$j]->setProdutoId($RetornoConsultaRel[$j]["IdProduto"]);
				$Retorno[$j]->setProdutoNome($RetornoConsultaRel[$j]["codigoProduto"]." ".$RetornoConsultaRel[$j]["nomeProduto"]);
				$Retorno[$j]->setTipo($RetornoConsultaRel[$j]["tipo"]);
				$Retorno[$j]->setQtd($RetornoConsultaRel[$j]["qtd"]);
				$Retorno[$j]->setPreco($this->Formata->banco2valor($RetornoConsultaRel[$j]["preco"]));
				$Retorno[$j]->setData($this->Formata->banco2date($RetornoConsultaRel[$j]["data"]));
				$Retorno[$j]->setDescricao($RetornoConsultaRel[$j]["descricao"]);
			}
		}
		
		return $Retorno;
		
	}
	
	/**
	* Salvar ou Adicionar estoque.
	* @param $id
	*/
	public function salvarEstoque($id = "", $produto = "", $tipo = "", $qtd = "", $preco = "", $data = "", $descricao = ""){
		if(empty($id)){
			$this->ConexaoSQL->insertQuery("INSERT INTO estoque (id_produtos, tipo, qtd, preco, data, descricao) VALUES('".$produto."', '".$tipo."','".$qtd."','".$this->Formata->valor2banco($preco)."', '".$this->Formata->date2banco($data)."','".$descricao."')");
			
			if( $tipo == 1 )
				$this->ConexaoSQL->updateQuery("UPDATE produtos SET estoque_atual += '".$qtd."' WHERE id = '".$produto."'");
			else 
				$this->ConexaoSQL->updateQuery("UPDATE produtos SET estoque_atual -= '".$qtd."' WHERE id = '".$produto."'");
			
		}else{
			
			$estoqueAntigo = $this->pegaEstoque(null, null, null, null, $id, null );
			$qtdAntigo = $estoqueAntigo[0]->getQtd();
			
			$diff = abs( $qtdAntigo - $qtd );
			if( $qtdAntigo < $qtd )
				$this->ConexaoSQL->updateQuery("UPDATE produtos SET estoque_atual = estoque_atual + '".$diff."' WHERE id = '".$produto."'");
			else 
				$this->ConexaoSQL->updateQuery("UPDATE produtos SET estoque_atual = estoque_atual - '".$diff."' WHERE id = '".$produto."'");
			
			$this->ConexaoSQL->updateQuery("UPDATE estoque SET id_produtos = '".$produto."', descricao = '".$descricao."', tipo = '".$tipo."', qtd = '".$qtd."', preco = '".$this->Formata->valor2banco($preco)."', data = '".$this->Formata->date2banco($data)."' WHERE id = '".$id."'");
		}
	}
	
	/**
	* Excluir estoque
	* @param $id
	*/
	public function excluir($id){

		$stq = $this->pegaEstoque(null, null, null, null, $id, null );
		if( $stq[0]->getTipo() == 1 ){ //se foi estoque de entrada, agora tira pois está excluindo
			$this->ConexaoSQL->updateQuery("UPDATE produtos SET estoque_atual = estoque_atual - '".$stq[0]->getQtd()."' WHERE id = '".$stq[0]->getProdutoId()."'");
		}else if( $stq[0]->getTipo() == 2 ){ //se foi estoque de saida, agora adiciona pois está excluindo
			$this->ConexaoSQL->updateQuery("UPDATE produtos SET estoque_atual = estoque_atual + '".$stq[0]->getQtd()."' WHERE id = '".$stq[0]->getProdutoId()."'");
		}
		
		$this->ConexaoSQL->deleteQuery("DELETE FROM estoque WHERE id = '".$id."'");
	}
	
	/**
	 * Excluir estoque
	 * @param $id
	 */
	public function adicionaEstoque( $idProduto = "", $idPedido = "", $descr = "", $qtd = "" ){
		$this->ConexaoSQL->updateQuery("UPDATE produtos SET estoque_atual = estoque_atual + '".$qtd."' WHERE id = '".$idProduto."'");
		$this->ConexaoSQL->insertQuery("INSERT INTO estoque (id_produtos, id_pedidos, descricao, tipo, qtd, preco, data) VALUES('".$idProduto."', '".$idPedido."', '".$descr."', '1', '".$qtd."','', NOW())");
		
	}
	
	/**
	 * Excluir estoque
	 * @param $id
	 */
	public function removeEstoque( $idProduto, $idPedido, $descr, $qtd ){
		$this->ConexaoSQL->updateQuery("UPDATE produtos SET estoque_atual = estoque_atual - '".$qtd."' WHERE id = '".$idProduto."'");
		
		$this->ConexaoSQL->insertQuery("INSERT INTO estoque (id_produtos, id_pedidos, descricao, tipo, qtd, preco, data) VALUES('".$idProduto."', '".$idPedido."', '".$descr."', '2', '".$qtd."','', NOW())");
	}
	
}
?>