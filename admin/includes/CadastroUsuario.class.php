<?php
/*
  EaZyCommerce 1.0
  http://www.eazycommerce.info

  Copyright (c) 2007 EaZyCommerce 1.0
  Author: Augusto Gava (augusto_gava@msn.com)
  Criado:13/05/07
  
  Classe cadastro
*/
class CadastroUsuario {
	public $_POST;
    public $ConexaoSQL;
    public $Seguranca;
    public $Formata;
    
    /**
	 * M�todo construtor.
	 *
	 * @param ConexaoSQL com o banco
     * @param Seguranca seguranca
	 */
    public function CadastroUsuario($ConexaoSQL, $Seguranca, $Formata){
        $this->ConexaoSQL = $ConexaoSQL;
        $this->Seguranca = $Seguranca;
        $this->Formata = $Formata;
    }//end function
    
    /**
     *
     * Cadastra usu�rio.
	 *
	 */
	public function cadastrar(){
		$Chave = md5(rand(100,9999));
        //Inserir Cliente
		$dados_cliente = array('codigo'=>$Chave,'nome'=>$_POST["nome"],'email'=>$_POST["email"],'cpf'=>$_POST["cpf"],'rg'=>$_POST["rg"],'sexo'=>$_POST["sexo"],'nascimento'=>$this->Formata->date2banco($_POST["nascimento"]),'ju_razao'=>$_POST["ju_razao"],'ju_nome'=>$_POST["ju_nome"],'ju_cnpj'=>$_POST["ju_cnpj"],'ju_ie'=>$_POST["ju_ie"],'senha'=>$_POST["senha"],'data'=>date('Y-m-d'));
		$this->ConexaoSQL->Inserir($dados_cliente,"cliente");
		
		//Inserir Cliente_entrega
		$lastid = $this->ConexaoSQL->pegaLastId();
		$dados_entrega = array('cliente_id'=>$lastid,'cep'=>$_POST["cep"],'endereco'=>$_POST["endereco"],'numero'=>$_POST["numero"],'complemento'=>$_POST["complemento"],'bairro'=>$_POST["bairro"],'cidade'=>$_POST["cidade"],'estado'=>$_POST["estado"],'tel'=>$_POST["tel"],'referencia'=>$_POST["referencia"]);
		$this->ConexaoSQL->Inserir($dados_entrega,"cliente_ent");
		//Enviar Email
		
		$msg = "Parabêns cadastro efetuado com sucesso! <br> Para desbloquear sua conta <a href=\"".$config[0][base]."/desbloqueio.php?email=".$_POST["email"]."&cpf=".$_POST["cpf"]."&chave=".$Chave."\">clique aqui</a>";
		//mail($_POST["email"],"Cadastro Efetuado",$msg,"From:$config[0][nome]<$config[0][email]>\nContent-type: text/html\n");
		
		header("Location: obrigado.php?text=Cadastro efetuado com sucesso, acesse seu email para desbloqueio da conta!");
		exit;
	}//Final Function
    
    /**
	 *  Funo de busca de Endereço pelo CEP .
     *  -   Desenvolvido Felipe Olivaes para ajaxbox.com.br 
     *  -   Utilizando WebService de CEP da republicavirtual.com.br 
	 *
	 * @param cep do usuário
     *
     * @return retorno do webservice
	 */
    public function BuscaCep($cep){  
        $resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');  
        if(!$resultado){  
             $resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";  
        }  
        parse_str($resultado, $retorno);   
        return $retorno;  
    }//end function
}
?>