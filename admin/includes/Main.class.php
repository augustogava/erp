<?php
# - - - - - - - - - - - - - - - -  ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/01/08
#  Classe principal, com includes
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

//inclui as configurações
include "Configuracoes.class.php";
//Inclui relacionamento com banco
include "ConexaoMySQL.class.php";
//Inclui relacionamento com banco
include "Seguranca.class.php";
//Inclui formata dados
include "Formata.class.php";
//Inclui dados padroes
include "Padrao.class.php";
//Inclui email
include "Email.class.php";
//Inclui template
include "Template.class.php";

include "Estoque.class.php";
include "Pedidos.class.php";
include "Exportacao.class.php";
include "OrdemSeparacao.class.php";
include "OrdemProducao.class.php";
include "DataGrid.class.php";
include "Fluxo.class.php";
include "FluxoBanco.class.php";
include "Relatorios.class.php";
include "Imagem.class.php";
include "Compras.class.php";
include "Composicao.class.php";

/**
 * Classe principal
 *
 * @author Augusto Gava
 * @version 1.0
 */
class Main {
	public $Configuracoes;
    public $ConexaoSQL;
    public $Seguranca;
    public $Formata;
    public $Padrao;
    public $Login;
    public $DataGrid;
    public $Template;
    public $Pedidos;
    public $Estoque;
    public $Fluxo;
    public $Email;
    public $Relatorios;
    public $OrdemProducao;
    public $OrdemSeparacao;
    public $Imagem;
    public $Composicao;
    public $FluxoBanco;
    
    /**
	 * M�todo construtor.
	 *
	 */
    public function Main(){
        $this->Configuracoes 	= new Configuracoes();
        //prepara o objeto do sql para ser usado pela api
		$this->ConexaoSQL 		= new ConexaoMySQL($this->Configuracoes);
        //prepara o objeto de seguran�a
		$this->Seguranca 		= new Seguranca($this->ConexaoSQL);
        //prepara o objeto de seguran�a
		$this->Formata 			= new Formata();
        //prepara o objeto dados padroes
		$this->Padrao 			= new Padrao($this->ConexaoSQL);
		//prepara o email
		$this->Email 			= new Email($this->ConexaoSQL);
        //prepara o objeto template
		$this->Template 		= new Template($this->ConexaoSQL);
		$this->Estoque 			= new Estoque($this->ConexaoSQL);
    	$this->OrdemSeparacao 	= new OrdemSeparacao($this->ConexaoSQL);
		$this->Pedidos 			= new Pedidos($this->ConexaoSQL, $this->Configuracoes);
        $this->OrdemProducao 	= new OrdemProducao($this->ConexaoSQL);
        $this->DataGrid 		= new DataGrid($this->ConexaoSQL);
        $this->Fluxo 			= new Fluxo($this->ConexaoSQL);
        $this->FluxoBanco 		= new FluxoBanco($this->ConexaoSQL);
        $this->Relatorios 		= new Relatorios($this->ConexaoSQL);
        $this->Imagem 			= new Imagem($this->ConexaoSQL);
        $this->Composicao 		= new Composicao($this->ConexaoSQL);
        $this->Compras 			= new Compras($this->ConexaoSQL, $this->Configuracoes);
    }
    
     /**
     *
	 * Adiciona Classe Login.
	 *
	 */
    public function AdicionaLogin(){
        include "Login.class.php";

        $this->Login = new Login($this->ConexaoSQL, $this->Seguranca);
    }

     /**
     * Adiciona Classe Compras.
	 *
	 */
    public function AdicionaCompras(){
        include "Compras.class.php";
		include "Exportacao.class.php";

		$this->Compras = new Compras($this->ConexaoSQL, $this->Formata, $this->Configuracoes, new Exportacao());
    }
}
?>