<?php
# - - - - - - - - - - - - - - - -  ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/01/08
#  Classe principal, com includes
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

//inclui as configura��es
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
    public $CadastroUsuario;
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
        $this->Configuracoes = new Configuracoes();
        //prepara o objeto do sql para ser usado pela api
		$this->ConexaoSQL = new ConexaoMySQL($this->Configuracoes);
        //prepara o objeto de seguran�a
		$this->Seguranca = new Seguranca($this->ConexaoSQL);
        //prepara o objeto de seguran�a
		$this->Formata = new Formata();
        //prepara o objeto dados padroes
		$this->Padrao = new Padrao($this->ConexaoSQL, $this->Formata);
		//prepara o email
		$this->Email = new Email($this->ConexaoSQL, $this->Formata);
        //prepara o objeto template
		$this->Template = new Template($this->ConexaoSQL, $this->Formata);
    }
    
    /**
	 * Adiciona Classe dinamicamente.
	 *
	 * @param NomeClasse nome classe
	 */
    public function AdicionaClasse($NomeClasse){
        include( $this->Configuracoes->INCLUDE_DIR.$NomeClasse.".class.php" );
        eval("\$this->$NomeClasse = new $NomeClasse();");
    }
    
     /**
     *
	 * Adiciona Classe Login.
	 *
	 */
    public function AdicionaLogin(){
        include "Login.class.php";
        //prepara o objeto de seguran�a
		$this->Login = new Login($this->ConexaoSQL, $this->Seguranca);
    }
    
    /**
     *
	 * Adiciona Classe Login.
	 *
	 */
    public function AdicionaCadastrousuario(){
        include "CadastroUsuario.class.php";
        //prepara o objeto de seguran�a
		$this->CadastroUsuario = new CadastroUsuario($this->ConexaoSQL, $this->Seguranca, $this->Formata);
    }
    
    /**
     * Adiciona Classe DataGrid.
	 *
	 */
    public function AdicionaDataGrid(){
        include "DataGrid.class.php";
		include "Exportacao.class.php";
        //prepara o objeto de seguran�a
		$this->DataGrid = new DataGrid($this->ConexaoSQL, $this->Formata, new Exportacao());
    }
	
	 /**
     * Adiciona Classe Pedidos.
	 *
	 */
    public function AdicionaPedidos(){
        include "Pedidos.class.php";
		include "Exportacao.class.php";
        //prepara o objeto de seguran�a
		$this->Pedidos = new Pedidos($this->ConexaoSQL, $this->Formata, $this->Configuracoes, new Exportacao());
    }
    
    /**
     * Adiciona Classe Estoque.
	 *
	 */
    public function AdicionaEstoque(){
        include "Estoque.class.php";
        //prepara o objeto de seguran�a
		$this->Estoque = new Estoque($this->ConexaoSQL, $this->Formata);
    }
    
     /**
     * Adiciona Classe Fluxo.
	 *
	 */
    public function AdicionaFluxo(){
        include "Fluxo.class.php";
        //prepara o objeto de seguran�a
		$this->Fluxo = new Fluxo($this->ConexaoSQL, $this->Formata);
    }

    /**
     * Adiciona Classe Fluxo Banco.
	 *
	 */
    public function AdicionaFluxoBanco(){
        include "FluxoBanco.class.php";
        //prepara o objeto de seguran�a
        $this->FluxoBanco = new FluxoBanco($this->ConexaoSQL, $this->Formata);
    }
    
    /**
     * Adiciona Classe Relatorios.
	 *
	 */
    public function AdicionaRelatorios(){
        include "Relatorios.class.php";
        //prepara o objeto de seguran�a
		$this->Relatorios = new Relatorios($this->ConexaoSQL, $this->Formata);
    }
    
    /**
     * Adiciona Classe Ordem Producao.
	 *
	 */
    public function AdicionaOrdemProducao(){
        $this->AdicionaPedidos();
        $this->AdicionaEstoque();
        include "OrdemProducao.class.php";
        //prepara o objeto de seguran�a
		$this->OrdemProducao = new OrdemProducao($this->ConexaoSQL, $this->Formata, $this->Pedidos, $this->Estoque);
    }
    
    /**
     * Adiciona Classe Ordem Producao.
     *
     */
    public function AdicionaOrdemSeparacao(){
    	$this->AdicionaPedidos();
    	$this->AdicionaEstoque();
    	include "OrdemSeparacao.class.php";
    	//prepara o objeto de seguran�a
    	$this->OrdemSeparacao = new OrdemSeparacao($this->ConexaoSQL, $this->Formata, $this->Pedidos, $this->Estoque);
    }
    
    /**
     * Adiciona Classe imagem.
	 *
	 */
    public function AdicionaImagem(){
        include "Imagem.class.php";
        //prepara o objeto de seguran�a
		$this->Imagem = new Imagem($this->ConexaoSQL, $this->Formata);
    }
	
	 /**
     * Adiciona Classe composicao produtos.
	 *
	 */
    public function AdicionaComposicao(){
        include "Composicao.class.php";
        //prepara o objeto de seguran�a
		$this->Composicao = new Composicao($this->ConexaoSQL, $this->Formata);
    }

     /**
     * Adiciona Classe Compras.
	 *
	 */
    public function AdicionaCompras(){
        include "Compras.class.php";
	include "Exportacao.class.php";
        //prepara o objeto de seguran�a
	$this->Compras = new Compras($this->ConexaoSQL, $this->Formata, $this->Configuracoes, new Exportacao());
    }
}
?>