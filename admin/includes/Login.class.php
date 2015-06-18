<?php
# - - - - - - - - - - - - - - - -  ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/01/08
#  
#  Classe login
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Classe responsável pela tela acoes login
 *
 * @author Augusto Gava
 * @version 1.0
 */
class Login {
	public $ConexaoSQL;
    public $Seguranca;
    public $email;
	public $senha;
	public $cpf;
    public $chave;
	
    /**
	 * Método construtor.
	 *
	 * @param ConexaoSQL com o banco
     * @param Seguranca seguranca
	 */
    public function Login($ConexaoSQL, $Seguranca){
        $this->ConexaoSQL = $ConexaoSQL;
        $this->Seguranca = $Seguranca;
    }//end function
    
    /**
	 * Efetua Login usuário.
	 *
	 * @erro_page endereco pagina erro
	 */
	public function efetuar_login($erro_page = ""){
		//Verifica tentativas de acesso
		if($this->Seguranca->pegar_tentativa() <= 9)
			//Verifica no banco se cliente esta cadastrado
			if($this->ConexaoSQL->RetornaQuantidadeQuery("SELECT * FROM cliente WHERE email = '".$this->email."' AND senha = '".$this->senha."' AND sit = '1'")){
				$PegarId = $this->ConexaoSQL->Select("SELECT * FROM cliente WHERE email = '".$this->email."' AND senha = '".$this->senha."'");
                $Id = $PegarId[0]['id'];
                
                $red=$this->ConexaoSQL->SelectAuto("cliente",array('id','nome','email'),$PegarId[0]['id']);

				$_SESSION["logado_id"] = $red[0]['id'];
				$_SESSION["logado_nome"] = $red[0]['nome'];
				$_SESSION["logado_email"] = $red[0]['email'];
				header("Location: my_space.php");
				exit;
			}else{
				$this->Seguranca->inserir_tentativa();
				$tenta = $this->Seguranca->pegar_tentativa();
				header("Location: ".$erro_page."?erro=E-mail/Senha Inválidos Você utilizou ".$tenta." das 9 tentativas de acesso&email=".$this->email);
				exit;
			}// end IF
		else{
			header("Location: ".$erro_page."?erro=Você já ultrapassou quantidades de tentativas disponíveis! ");
			exit;
		}//end IF
	}//end Function
    
    /**
     *
	 * Muda senha usuário.
	 *
	 */
	public function mandarSenha(){
		$sel = $this->ConexaoSQL->SelectAuto("cliente",array('nome','email','senha'),"email = '".$this->email."'");
		if(count($sel)>0){
			//mail($this->email,"Senha","Olá ".$sel[0][nome]." , <br> Sua senha é: ".$sel[0][senha]);
			header("Location: obrigado.php?text=Senha enviada com sucesso!");
            exit;
		}else{
			header("Location: forgotPass.php?erro=E-mail não cadastrado! ");
			exit;
		}//end IF
	}//end Function
    
    /**
	 * Desbloqueia usuário.
	 *
	 */
	public function desloquear(){
		$sel=$this->ConexaoSQL->SelectAuto("cliente",array('id'),"email = '".$this->email."' AND cpf = '".$this->cpf."' AND (codigo = '".$this->chave."' OR senha = '".$this->senha."')");
		if(count($sel)>0){
			$this->ConexaoSQL->executaQuery("UPDATE cliente SET sit = '1' WHERE id = '".$sel[0][id]."'");
			header("Location: obrigado.php?text=Desbloqueado com sucesso, agora já pode efetuar o logon!");
			exit;
		}else{
			header("Location: desbloqueio.php?erro=Cadastro não localizado, verifique as informações! ");
			exit;
		}//end IF
	}//end Function
}
?>