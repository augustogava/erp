<?php
# - - - - - - - - - - - - - - - -  ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/01/08
#  
#  Classe respons�vel que busca parametros padroes
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
include_once("properties/PropriedadesPadrao.php");

/**
 * Classe respons�vel que busca parametros padroes
 *
 * @author Augusto Gava
 * @version 1.0
 */
class Padrao {
    public $ConexaoSQL;
	
    /**
	 * M�todo construtor.
	 *
	 * @param ConexaoSQL conex�o com o banco
	 */
    public function Padrao($ConexaoSQL){
        $this->ConexaoSQL = $ConexaoSQL;
        
        $this->pegarParametros();
    }//end function
    
    /**
     *
	 * Pega todos parametros e adiciona na classe.
	 *
	 */
    private function pegarParametros(){
        $Dados = $this->ConexaoSQL->SelectAuto("param",array('nome','valor'));
        
        for($i=0; $i<count($Dados); $i++){
            $this->$Dados[$i]['nome'] = $Dados[$i]['valor'];
        }//end for
    }//end function
    
    /**
     * Pega nome do perfil de permiss�o do usu�rio logado.
     */
    public function pegaNomePerfil(){
    	$RetornoConsulta = $this->ConexaoSQL->Select("SELECT * FROM niveis WHERE id = '".$_SESSION["niveluser"]."'");
    	if(count($RetornoConsulta) > 0)
    		return $RetornoConsulta[0]["nome"];
    	else
    		return "Não Achado";
    }
    
    /**
     * Pega último login usuário.
     */
    public function pegaUltimoLogin(){
    	$RetornoConsulta = $this->ConexaoSQL->Select("SELECT data FROM auditoria WHERE acao = 'login' AND id_usuarios = '".$_SESSION["niveluser"]."' ORDER By data DESC Limit 1, 1");
    	if(count($RetornoConsulta) > 0)
    		return Formata::banco2date($RetornoConsulta[0]["data"]);
    	else
    		return "Primeiro Acesso";
    }
    
    /**
	* retorna lista de estado.
	*@return array estado.
	*/
	public function pegaEstados( $id = "" ){
		
		if(!empty($id))
			$where = " AND estado.id = '".$id."'";
				
		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT * FROM estado WHERE 1 ".$where." ORDER By estado.nome ASC");
    	
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
	 * retorna lista tipos de produtos
	 *@return array .
	 */
	public function pegaTiposProdutos( $id = "" ){
	
		if(!empty($id))
			$where = " AND tipo_produdo.id = '".$id."'";
	
		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT * FROM tipo_produdo WHERE 1 ".$where." ORDER By tipo_produdo.nome ASC");
		 
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
	* retorna lista de estado.
	*@return array estado.
	*/
	public function pegaCidades( $id = "" ){
		
		if(!empty($id))
			$where = " AND cidade.id = '".$id."'";
				
		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT * FROM cidade WHERE 1 ".$where." ORDER By cidade.nome ASC");
    	
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