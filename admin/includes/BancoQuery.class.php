<?php
# - - - - - - - - - - - - - - - -  Eazycommerce - - - - - - - - - - - - - - - - - -
# EaZyCommerce 1.0
# http://www.eazycommerce.info
#
#  Copyright (c) 2007 EaZyCommerce 1.0
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 05/03/07
#  
#  Classe bd, extends Banco
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Classe responsável pelos recursos do banco automatizado
 *
 * @author Augusto Gava
 * @version 1.0
 */
class banco_query {
	
    /**
    *
    * Seta campos automaticamente.
    *
    * @param fields array
    *
    * @return String com parte da query
    */
	function setQuery($fields){
		if(is_array($fields)){
			$query = "SET ";
			$separador = "";
			foreach($fields as $field => $valor){
				//Não deixar entra id pra atualizar!!
				if($field!="id"){
					$query.=$separador."$field='$valor'";
					$separador=",";
				}
			}
			return $query;
		}
	}//end function
    
	/**
    *
    * Gera query total de insercao.
    *
    * @param fields array
    * @param table_name nome tabela
    *
    * @return String com a query
    */
	function inserirQuery($fields, $table_name){
		if($fields){
			$query = "INSERT INTO $table_name ";
			$query.= $this->setQuery($fields);
			return $query;
		}else
			return "Erro gerar query insert";
	}//end function
    
    /**
    *
    * Gerar Query Update.
    *
    * @param fields array
    * @param table_name nome tabela
    * @param where
    *
    * @return String com parte da query
    */
	function update_query($fields, $table_name, $where){
		if($fields){
			$query = "UPDATE $table_name ";
			$query.= $this->setQuery($fields);
			if(is_numeric($where)){
				$query.= " WHERE id='".$where."'";
			}else if($where){
				$query.= " WHERE ".$where;
			}
			return $query;
		}else
			return "Erro gerar query insert";
	}//end function
    
    /**
    *
    * Gerar select automatico.
    *
    * @param table_name nome tabela
    * @param campos array dos campos
    * @param where
    * @param order
    * @param limiti inicio
    * @param limitf fim
    *
    * @return String com query
    */
	function select_query($table_name, $campos = array(), $where = "", $order = "", $limiti, $limitf){
		if(count($campos)>0)
			$cp = implode(",",$campos); else $cp= "*";
			
		$query = "SELECT $cp FROM $table_name";
			if(is_numeric($where)){
				$query.= " WHERE $table_name.id='".$where."'";
			}else if($where){
				$query.= " WHERE ".$where;
			}
			if($order)
				$query.= " ORDER By $order";
				
			$query.= " limit $limiti,$limitf";
		return $query;
	}//end function
	
	public function pegaCamposTabela($Tabela){
		$result = $this->executaQuery(" SHOW COLUMNS FROM ".$Tabela." ");
		if(mysql_num_rows($result))
			while($r = mysql_fetch_array($result)){
				$cont[] =  $r['Field'];
			}
		
		return $cont;
	}
}
?>