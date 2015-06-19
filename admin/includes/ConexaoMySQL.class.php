<?php
# - - - - - - - - - - - - - - - -  ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/01/08
#  
#  Classe bd, conexão
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

//$campos = array("nome"=>"augusto35","email"=>"teste@teste.com.br35");

/*
Inserir **
$class["banco"]->inserir($campos,"cliente");
Update **
$class["banco"]->update($campos,"cliente","id=1");
Select simples **
$a=$class["banco"]->select("cliente",array('nome','id'),1,"nome ASC",0,10);
print $a[0]["nome"];
Select SEU **
$a=$class["banco"]->selects("select nome from cliente");
print $a[0]["nome"];
*/
require_once('BancoQuery.class.php');

/**
 * Classe respons�vel pelo Banco
 *
 * @author Augusto Gava
 * @version 1.0
 */
class ConexaoMySQL extends banco_query {
	//Var Inis
	public $table_name;
	public $Configuracoes;
    public $ConexaoSQL;
    
    /**
	 * M�todo construtor.
	 *
	 * @param Configuracoes configura��o padr�o da classe Configuracoes.
	 */
    public function ConexaoMySQL($Configuracoes){
        $this->Configuracoes = $Configuracoes;
    }//end function
    
     /**
	 * M�todo pega nome tabela.
	 *
	 * @return table_name
	 */
    public function getTable(){
        return $this->table_name;
    }//end function
    
    /**
	 * M�todo de tratamento de erro.
	 *
	 * @param MensagemDeErro mensagem de erro.
	 */
	public function Erro($MensagemDeErro) {
		exit ("\n\n ".$MensagemDeErro."\n <br> Abortando o script!!\n\n");
	}//end function
    
    /**
    *
    * M�todo de conex�o com banco.
    *
    * @return true or false
    */
	public function conecta(){	
        $this->ConexaoSQL = mysql_connect($this->Configuracoes->MySQLHostname, $this->Configuracoes->MySQLUsuario, $this->Configuracoes->MySQLSenha) or $erro="Nao foi possivel Conectar!";
        if (!mysql_select_db($this->Configuracoes->BancodeDados, $this->ConexaoSQL)) {
            $this->Erro("Ocorreu um erro ao conectar no banco de dados. ".mysql_error());
            return false;
        }//end if
        return true;
	}//end function
    
    /**
    *
    * M�todo que executa query qualquer.
    *
    * @param query utilizada
    * @return result
    */
	public function executaQuery($query){
		if (!$this->ConexaoSQL)
			$DBConnecta = $this->conecta();
            
        $result = mysql_query($query);
		if($result === false){
			$this->erro.="Erro na Query <br>";
			return false;
		}else
			return $result;
	}//end function
	
	/**
    *
    * M�todo que executa query para Inser��o.
    *
    * @param query utilizada
    * @return result
    */
	public function insertQuery($query){
		if (!$this->ConexaoSQL)
			$DBConnecta = $this->conecta();
           
        $this->salvarAuditoriaInsert($query);
       
		
        $result = mysql_query($query);

		$this->salvarPermissao($query, mysql_insert_id());

		if($result === false){
			$this->erro.="Erro na Query <br>";
			return false;
		}else
			return $result;
	}//end function
	
	/**
    *
    * M�todo que executa query para update.
    *
    * @param query utilizada
    * @return result
    */
	public function updateQuery($query){
		if (!$this->ConexaoSQL)
			$DBConnecta = $this->conecta();
           
        $this->salvarAuditoriaUpdate($query);
        
        $result = mysql_query($query);
		if($result === false){
			$this->erro.="Erro na Query <br>";
			return false;
		}else
			return $result;
	}//end function
	
	/**
    *
    * M�todo que executa query de delete.
    *
    * @param query utilizada
    * @return result
    */
	public function deleteQuery($query){
		if (!$this->ConexaoSQL)
			$DBConnecta = $this->conecta();
           
        $this->salvarAuditoriaDelete($query);
        
        $result = mysql_query($query);
		if($result === false){
			$this->erro.="Erro na Query <br>";
			return false;
		}else
			return $result;
	}//end function
    
    /**
    *
    * Executa query e retorna quantidade de registros.
    *
    * @param query utilizada
    * @return Quantidade registros
    */
	public function RetornaQuantidadeQuery($query){
		if (!$this->ConexaoSQL)
			$DBConnecta = $this->conecta();
        
        $result = mysql_query($query);
		if($result === false){
			$this->erro.="Erro na Query <br>";
			return false;
		}else
			return mysql_num_rows($result);
	}//end function
    
	/**
    *
    * M�todo que insere banco.
    *
    * @param fields array com campos
    * @table_name nome da tabela
    */
	public function Inserir($fields,$table_name = ""){
		if (!$this->ConexaoSQL)
			$DBConnecta = $this->conecta();
            
        if(empty($table_name)) $table_name = $this->getTable();
		if(count($fields) > 0){
			$query = $this->inserirQuery($fields,$table_name);
			//print $query;
			$this->salvarAuditoriaInsert($query);
			$result = $this->executaQuery($query);
		}
	}//end  function
    
    /**
    *
    * M�todo que atualiza tabela, update($campos,"cliente","id=1"), update($campos,"cliente",1).
    *
    * @param fields array com campos
    * @param table_name nome da tabela
    * @param where Where da query
    */
	public function Update($fields,$table_name = "", $where = ""){
		if (!$this->ConexaoSQL)
			$DBConnecta = $this->conecta();
        
        if(empty($table_name)) $table_name = $this->getTable();
		if(count($fields)>0){
			$query = $this->update_query($fields,$table_name, $where);
			$this->salvarAuditoriaUpdate($query);
			$result = $this->executaQuery($query);
		}
	}//end  function
    
	/**
    *
    * M�todo que retorna registros da tabela print $cont[1]["nome"];.
    *
    * @param table_name nome tabela
    * @param campos array dos campos
    * @param where
    * @param order
    * @param limiti inicio
    * @param limitf fim
    */
	public function SelectAuto($table_name = "", $campos = array(), $where = "", $order = "", $limiti = 0, $limitf = 99999999){
		if (!$this->ConexaoSQL)
			$DBConnecta = $this->conecta();
        
        if(empty($table_name)) $table_name = $this->getTable();
		$query = $this->select_query($table_name, $campos, $where, $order, $limiti, $limitf);
       // print $query;
		$result = $this->executaQuery($query);
		if(mysql_num_rows($result))
			while($r = mysql_fetch_array($result)){
				$cont[] =  $r;
			}
		return $cont;
	}//end  function
    
	/**
    *
    * M�todo que executa query, trazendo fecth_array.
    *
    * @param query
    */
	public function Select($query){
		if (!$this->ConexaoSQL)
			$DBConnecta = $this->conecta();

        $result = $this->executaQuery($query);
		if(mysql_num_rows($result))
			while($r = mysql_fetch_array($result)){
				$cont[] =  $r;
			}
		return $cont;
	}//end function
    
    
    /**
    *
    * Pega ultimo id adicionado.
    *
    * @return ultimo id adicionado
    */
    public function pegaLastId(){
        return mysql_insert_id();
    }//end function 
    
    /**
     * Salva acoes insert.
     * @param query String
     */
    public function salvarAuditoriaInsert($query){
    	$Parte = explode("into", strtolower($query));
    	$Tabela = explode(" ", $Parte[1]);
    	$Tabela = $Tabela[1];
    	
    	if (!$this->ConexaoSQL)
			$DBConnecta = $this->conecta();
            
        mysql_query("INSERT INTO auditoria (id_usuarios, acao, pagina, data, ip) VALUES('".$_SESSION["iduser"]."','insert','".$Tabela."',NOW(),'".$_SERVER['REMOTE_ADDR']."') ");
    }
    
    /**
     * Salva acoes insert.
     * @param query String
     */
    public function salvarAuditoriaUpdate($query){
    	$Parte = explode("update", strtolower($query));
    	$Tabela = explode(" ", $Parte[1]);
    	$Tabela = $Tabela[1];
    	
    	if (!$this->ConexaoSQL)
			$DBConnecta = $this->conecta();
            
        mysql_query("INSERT INTO auditoria (id_usuarios, acao, pagina, data, ip) VALUES('".$_SESSION["iduser"]."','update','".$Tabela."',NOW(),'".$_SERVER['REMOTE_ADDR']."') ");
    }
    
    /**
     * Salva acoes delete.
     * @param query String
     */
    public function salvarAuditoriaDelete($query){
    	$Parte = explode("delete", strtolower($query));
    	$Tabela = explode(" ", $Parte[1]);
    	$Tabela = $Tabela[2];
    	
    	if (!$this->ConexaoSQL)
			$DBConnecta = $this->conecta();
            
        mysql_query("INSERT INTO auditoria (id_usuarios, acao, pagina, data, ip) VALUES('".$_SESSION["iduser"]."','delete','".$Tabela."',NOW(),'".$_SERVER['REMOTE_ADDR']."') ");
    }
	
	/**
     * Salva acoes insert.
     * @param query String
     */
    public function salvarPermissao($query, $id){
    	$Parte = explode("into", strtolower($query));
    	$Tabela = explode(" ", $Parte[1]);
    	$Tabela = $Tabela[1];
    	
    	if (!$this->ConexaoSQL)
			$DBConnecta = $this->conecta();
            
        mysql_query("INSERT INTO permissoes (id_usuarios, idtabela, tabela) VALUES('".$_SESSION["iduser"]."','".$id."','".$Tabela."') ");
    }
}
?>