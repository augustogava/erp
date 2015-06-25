<?php
# - - - - - - - - - - - - - - - -  ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/01/08
#  
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
include_once("properties/PropriedadesUsuario.php");

/**
 * Classe responsável usuário
 *
 * @author Augusto Gava
 * @version 1.0
 */
class User {
    public $ConexaoSQL;
	
    /**
	 * M�todo construtor.
	 *
	 * @param ConexaoSQL conex�o com o banco
	 */
    public function User($ConexaoSQL){
        $this->ConexaoSQL = $ConexaoSQL;
    }//end function
    
	/**
	 * retorna lista usuários
	 *@return array .
	 */
	public function pegaUsuario( $id = "" ){
	
		if(!empty($id))
			$where = " AND usuarios.id = '".$id."'";
	
		$RetornoConsultaRel = $this->ConexaoSQL->Select("SELECT * FROM usuarios WHERE 1 ".$where."");
			
		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$Retorno[$j] = new PropriedadesUsuario();
				$Retorno[$j]->setId($RetornoConsultaRel[$j]["id"]);
				$Retorno[$j]->setNome($RetornoConsultaRel[$j]["nome"]);
				$Retorno[$j]->setEmail($RetornoConsultaRel[$j]["email"]);
				$Retorno[$j]->setUsuario($RetornoConsultaRel[$j]["login"]);
				$Retorno[$j]->setSenha($RetornoConsultaRel[$j]["senha"]);
			}
		}
		return $Retorno;
	}
	
	public function salvar($id = "", $nome = "", $email = "", $login = ""){
		$this->ConexaoSQL->updateQuery("UPDATE usuarios SET nome = '".$nome."', email = '".$email."', login = '".$login."' WHERE id = '".$id."'");
	}
	
	public function salvarSenha($id = "", $senhaAntiga = "", $senhaNova = ""){
		$usuario = $this->pegaUsuario($id);
		if( $usuario[0]->getSenha() == $senhaAntiga){
			$this->ConexaoSQL->updateQuery("UPDATE usuarios SET senha = '".$senhaNova."' WHERE id = '".$id."'");
		}else{
			print "<script>alert('Senha antiga está errada');</script>";
		}
	}
	
}
?>