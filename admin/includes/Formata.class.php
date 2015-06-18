<?php
# - - - - - - - - - - - - - - - -  ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/01/08
#  
#  Classe de formatações
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Formatações diversas
 * extende a configuração padrão.
 *
 * @author Augusto Gava
 * @version 1.0
 */
class Formata {
    
    
    /**
     * Preenche com zero a esquerda.
     * @param valor.
     * @param qtd
     * @return valor formatado.
     */
    public function preencheZero($valor, $qtd){
    	$zero = "";
    	for($i=0; $i<$qtd-strlen($valor); $i++){
    		$zero .= "0";
    	}
    	$zero = $zero.$valor;
    	
    	return $zero;
    }
    
	/**
	 * Formata valor para banco.
	 *
	 * @param valor Data
     * @return data formatada
	 */
    public function valor2banco($valor){
		$valor = str_replace(".","",$valor);
		$valor = str_replace(",",".",$valor);

	    return	$valor;
    }//end function
	
	/**
	 * Formata valor para decimal.
	 *
	 * @param valor Data
     * @return data formatada
	 */
    public function banco2valor($valor){
		$valor = number_format($valor, 2, ',', '.'); 
	    return	$valor;
    }//end function
	
    /**
	 * Formata data para valor válido do banco.
	 *
	 * @param valor Data
     * @return data formatada
	 */
    public function date2banco($valor){
        return	implode(array_reverse(explode("/",$valor)),"-");
    }//end function
    
     /**
	 * Formata data para valor br.
	 *
	 * @param valor Data
     * @return data formatada
	 */
    public function banco2date($valor){
		if(strlen($valor) > 10){
			$p1 = explode(" ", $valor);
			$Data = implode(array_reverse(explode("-",$p1[0])),"/");
			return $Data." ".$p1[1];
		}else{
			return	implode(array_reverse(explode("-",$valor)),"/");
		}
        	
    }//end function
    
    
    /**
     * Trata string apra retornar nome tabela
     * 
     * @tabela tabela
     * @return Ret
     */
    public function retornaNomeTabela($tabela){
    	$Ret = explode("id_", $tabela);
		$Ret = $Ret[1];
		return $Ret;
    }
	
	/**
     * Remove caracteres estranhos.
     * 
     * @palavra palavra
     * @return str_replace
     */
	public function removeCaractres($palavra){
		return str_replace("_", " ", $palavra);  
	}
    
}
?>