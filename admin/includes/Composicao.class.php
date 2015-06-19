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
 * Classe responsável pelos metodos Composicao.
 *
 * @author Augusto Gava
 * @version 1.0
 */
 
include_once("properties/PropriedadesComposicao.php");
include_once("properties/PropriedadesPadrao.php");

class Composicao  {
	public $ConexaoSQL;
	
    /**
	 * Método construtor.
	 *
	 * @param ConexaoSQL conexão com o banco
	 */
    public function Composicao($ConexaoSQL){
        $this->ConexaoSQL = $ConexaoSQL;
    }
    
    /**
	* retorna lista de  composicao do iten
	*@param clientes.
	*@param status.
	*@return array clientes.
	*/
	public function pegaComposicao($idPai = "", $produto = "", $idComposicao = "", $limite = ""){
		$qtd = 15;
		
		if(!empty($idPai))
			$busca .= " AND composicao.id_produtos_pai = '".$idPai."' ";
			
		if(!empty($produto))
			$busca .= " AND composicao.id_produtos = '".$produto."' ";
		
		if(!empty($idComposicao))
			$busca .= " AND composicao.id = '".$idComposicao."' ";
			
		if(empty($limite) || $limite < 0)
			$limite = "0";

		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT composicao.*, produtos.id as IdProduto, produtos.nome as nomeProduto, produtos.codigo as codigoProduto FROM composicao INNER JOIN produtos ON produtos.id = composicao.id_produtos WHERE 1 ".$busca." ORDER By id DESC Limit ".$limite.", ".$qtd." ");
    	
		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$Retorno[$j] = new PropriedadesComposicao();
				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
				$Retorno[$j]->setProdutoId($RetornoConsultaRel[$j]["IdProduto"]);
				$Retorno[$j]->setProdutoNome($RetornoConsultaRel[$j]["codigoProduto"]." ".$RetornoConsultaRel[$j]["nomeProduto"]);
				$Retorno[$j]->setQtd($RetornoConsultaRel[$j]["qtd"]);
				$Retorno[$j]->setDescricao($RetornoConsultaRel[$j]["descricao"]);
			}
		}
		
		return $Retorno;
		
	}
	
	/**
	* Salvar ou Adicionar composicao.
	* @param $id
	*/
	public function salvarComposicao($id = "", $idComposicao = "", $produto = "", $qtd = "", $descricao = ""){
		if(empty($idComposicao)){
			$this->ConexaoSQL->insertQuery("INSERT INTO composicao (id_produtos_pai, id_produtos, qtd, descricao) VALUES('".$id."', '".$produto."','".$qtd."', '".$descricao."')");
		}else{
			$this->ConexaoSQL->updateQuery("UPDATE composicao SET id_produtos = '".$produto."', descricao = '".$descricao."', qtd = '".$qtd."' WHERE id = '".$idComposicao."'");
		}
	}
	
	/**
	* Excluir composicao
	* @param $id
	*/
	public function excluir($id){
			$this->ConexaoSQL->deleteQuery("DELETE FROM composicao WHERE id = '".$id."'");
	}
	
	
}
?>