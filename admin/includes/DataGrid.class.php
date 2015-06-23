<?php
# - - - - - - - - - - - - - - - -  ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/01/08
#  
#  Classe DataGrid
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Classe respons�vel pelo DataGrid Padr�o
 *
 * @author Augusto Gava
 * @version 1.0
 */
class DataGrid {
	private $ConexaoSQL;
	private $Query = '';
	private $Limite = '';
	private $LimiteAtual = 0;
	private $Order = '';
	private $Editar = 0;
	private $Excluir = 0;
	private $NomeDivPai = '';
	private $NomeTable = '';
	private $FlagRefresh = 0;
	private $Busca;
	private $Id;
	private $Tabela;
	private $Exportar = 1;
	private $Colunas = array();
	private $collumnsCurrency = array();
	private $CadastroExtra = array();
	private $camposIgnoradosVisu = array("");
	private $camposIgnorados = array("");
	private $camposIgnoradosBusca = array("");
	private $camposIgnoradosAdd = array("id_estado", "id_cidade");
	
	
    /**
	 * M�todo construtor.
	 *
	 * @param ConexaoSQL com o banco
     * @param Formata formata
	 */
    public function DataGrid($ConexaoSQL){
        $this->ConexaoSQL = $ConexaoSQL;
    }//end function
    
    /**
     * Altera automaticamente no banco
     * 
     * @param Dados
     * 
     */
    public function SalvarDataGrid($Dados){
    	if(is_array($Dados)){
    		foreach($Dados as $k=>$v){
    			if( !empty($k)){
    				$p = explode("edit_",$k);
    				if(!empty($p[1])){
						if(eregi("data", $p[1]) || eregi("nascimento", $p[1])){
							$fields[$p[1]] =  Formata::date2banco($v);
						}else if(eregi("preco", $p[1]) || $this->isCurrencyCollumn($p[1]) ){
							$fields[$p[1]] =  Formata::valor2banco($v);
						}else{
							$fields[$p[1]] =  $v;
						}
						
					}
    			}//end if
    		}//end foreach
    	}//end if
    	
    	$this->ConexaoSQL->Update($fields, $this->getTabela(), $this->getId());
    	
    }//end function
    
     /**
     * Adiciona Automaticamente no banco.
     * 
     * @param Dados
     * 
     */
    public function AdicionarDataGrid($Dados){
    	if(is_array($Dados)){
    		foreach($Dados as $k=>$v){
    			if(!empty($v) && !empty($k)){
    				$p = explode("edit_",$k);
    				if(!empty($p[1])){
    					$fields[$p[1]] =  $v;
    				}
    			}//end if
    		}//end foreach
    	}//end if
    	//Salvar
    	
    	if($this->verificaCadastroDuplicado($Dados)){
    		$this->ConexaoSQL->Inserir($fields, $this->getTabela());
    	}else{
    		print "<script>window.alert('".ucfirst($this->getTabela())." j� cadastrado')</script>";
    	}
    }//end function
    
    /**
     * Verifica se pode cadastrar, se existe duplicidade.
     */
    public function verificaCadastroDuplicado($dados){
    	$campos = $this->pegarCamposValidar();
    	if(isset($campos)){
			foreach($campos as $valor){
    			$valorCampo = $this->buscaValorCampo($dados, $valor);
    			$where = " AND ".$valor." LIKE '".$valorCampo."' ";
    		}
    		$query = "SELECT id FROM ".$this->getTabela()." WHERE 1 ".$where;
			$RetornoConsulta = $this->ConexaoSQL->Select($query);
			if(count($RetornoConsulta) > 0){
				return false;
			}else{
    			return true;							
			}
    		print $query;
    	}else{
    		return true;
    	}
    }
    
    /**
     * Busca valor na array
     */
    public function buscaValorCampo($Dados, $nomeCampo){
    	
    	if(is_array($Dados)){
    		foreach($Dados as $k=>$v){
    			if(!empty($v) && !empty($k)){
    				$p = explode("edit_",$k);
    				if(!empty($p[1])&& $p[1] == $nomeCampo){
    					return $v;
    				}
    			}//end if
    		}//end foreach
    	}//end if
    	
    	return "";
    }
    
    /**
     * 
     */
    public function pegarCamposValidar(){
    	$query = "SELECT campos.nome FROM validacoes_duplicados INNER JOIN cadastros ON cadastros.id =  validacoes_duplicados.id_cadastros INNER JOIN campos ON campos.id =  validacoes_duplicados.id_campos WHERE cadastros.nome = '".$this->getTabela()."'";
    	
    	$RetornoConsulta = $this->ConexaoSQL->Select($query);
    	for($j=0; $j<count($RetornoConsulta); $j++){
			$campos[] = $RetornoConsulta[$j]["nome"];
    	}
    	
    	return $campos;
    	
    }
    
	public function verificaFiltro($nome){
	
		$filtros = array("cpf"=>"14", "rg"=>"13", "cnpj"=>"18", "cep"=>"9", "tel"=>"14", "site"=>"100", "data"=>"10", "nascimento"=>"10", "fax"=>"14", "cel"=>"14");
		$filtrosNumeros = array();
		
		foreach($filtros as $key=>$valor){
			if(eregi("^".$key, $nome)){
				$retorno["nome"] = $key;
				$retorno["tamanho"] = $valor;
				return $retorno;
			}
		}
		
		return "";
	
	}
	
	public function verificaFiltroReal($nome){
	
		$filtros = array("valor", "preco");

		foreach($filtros as $valor){
			if(eregi($valor, $nome) || $this->isCurrencyCollumn($nome) ){
				return "onKeyPress=\"mascaras.Formata(this,20,event,2)\"";
			}
		}
		
		return "";
	
	}
	
	public function verificaRequerido($tabela, $campo){
		
		$qtd = $this->ConexaoSQL->RetornaQuantidadeQuery("SELECT * FROM validacoes INNER JOIN campos ON campos.id = validacoes.id_campos AND campos.nome = '".$campo."' INNER JOIN cadastros ON cadastros.id = validacoes.id_cadastros AND cadastros.nome = '".$tabela."'  ");
		if($qtd > 0){
			 return "require efeitos";
		}else{
			return "";
		}
	}
	
    /**
     * Monta Pagina com acoes do dataGrid.
     * 
     * @param Acao acao
     */
    public function editaAddDataGrid($Acao, $Campo = ""){
    	$this->Html .= "<form action=\"\" name=\"edit\" id =\"edit\"><table border=\"1\" width=\"100%\" cellpadding=\"0\" cellspacing=\"5\" align=\"left\">";
    	$this->Html .= "<tr style=\"border-bottom: 1px solid #ddd; height: 30px;\">";
		
		if($Acao == "adicionarPopUp"){
			$AcaoT = "Adicionar";
		}else{
			$AcaoT = $Acao;
		}

		$this->Html .= "<td align=\"left\" width=\"30%\"><h2>".ucfirst($AcaoT)." Cadastro</h2> </td>";
		if($Acao != "adicionarPopUp")
			$this->Html .= "<td align=\"right\" width=\"70%\"><button type=\"button\" class=\"btn btn-default btn-xs\" aria-label=\"Left Align\" onclick=\"addPop_close();\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span> Fechar </button></td>";
		$this->Html .= "</tr>";
    	$this->Html .= "<tr><td align=\"center\" colspan=\"3\" id=\"erro\" style=\"color:red;\">&nbsp;</td></tr>";
    	
    	//Pegar dados para inserir ou editar
    	if( $Acao == "editar" ||  $Acao == "abrir"){
    		$Query = $this->Query." WHERE id = '".$this->getId()."' ";
    		$RetornoConsulta = $this->ConexaoSQL->Select($Query);
    	}
    	
    	$Campos = $this->ConexaoSQL->pegaCamposTabela($this->getTabela());
    	
    	$Paramentros = $this->montaParametros();
    	
    	//percorre campos
    	for($i=0; $i<count($Campos); $i++){
	    	
			if(!is_int($Campos[$i]) && eregi("^img",$Campos[$i])  ){
				
				$this->Html .= "<tr>";
    			$this->Html .= "<td align=\"right\" style=\"font-family: Lucida Grande, Verdana, sans-serif;font-size:11px;color: #383d44;\"><b>".ucfirst($Campos[$i]).":</b></td>";
				
				if(!empty($RetornoConsulta[0][$Campos[$i]])){
					$imagem = "../img_prod/".$RetornoConsulta[0][$Campos[$i]];
				}else{
					$imagem = "../img_prod/noImg.gif";
				}
				$idQ = $this->getId();
				if(!empty($idQ)){
					$this->Html .= "<td align=\"left\" ><img width=\"100px\" src=\"".$imagem."\" alt=\"produto\" id=\"editimg_".$Campos[$i]."\" onClick=\"javascript:window.open('exibiEditaImagem.php?campoatual=".$Campos[$i]."&tabela=".$this->getTabela()."&id=".$this->getId()."', 'Busca', 'height = 200, width = 350, location = no, toolbar = no, menubar=no')\"><td>";
				}else{
					$this->Html .= "<td align=\"left\" >Liberado apenas alteração</td>";
				}
    			$this->Html .= "</tr>";
				
			}else if(!is_int($Campos[$i]) && $Campos[$i]!="id" && !eregi("^id",$Campos[$i]) && !in_array($Campos[$i] , $this->camposIgnorados) ){
				$this->Html .= "<tr>";
    			$this->Html .= "<td align=\"right\" style=\"font-family: Lucida Grande, Verdana, sans-serif;font-size:11px;color: #383d44;\"><b>".ucfirst(Formata::removeCaractres($Campos[$i])).":</b></td>";
				if($ret = $this->verificaFiltro($Campos[$i])){
					$valida = "onkeypress=\"mascaras.mascara(this,'".$ret["nome"]."')\" maxlength=\"".$ret["tamanho"]."\"";
				}else if($ret = $this->verificaFiltroReal($Campos[$i])){
					$valida = $ret;
				}else{
					$valida = "";
				}
				
				//Formata Valor e data
				if(eregi("data", $Campos[$i]) || eregi("nascimento", $Campos[$i])){
					$valorFormatado =  Formata::banco2date($RetornoConsulta[0][$Campos[$i]]);
					$camposData[] = "edit_".$Campos[$i];
				}else if(eregi("preco", $Campos[$i]) || $this->isCurrencyCollumn($Campos[$i]) ){
					$valorFormatado =  Formata::banco2valor($RetornoConsulta[0][$Campos[$i]]);
				}else{
					$valorFormatado =  $RetornoConsulta[0][$Campos[$i]];
				}

				if(count($camposData) > 0){
					
					$scriptAdicionar = "
							var campos = new Array('".implode("','", $camposData)."');
							dataGrid.addCalendar(campos); ";
				}
				$requerido = $this->verificaRequerido($this->getTabela(), $Campos[$i]);
				
    			$this->Html .= "<td align=\"left\" ><input class=\"form-control input-xs\" type=\"text\" name=\"edit_".$Campos[$i]."\" id=\"edit_".$Campos[$i]."\" ".$valida." title=\"".$Campos[$i]."\" class=\"".$requerido."\" value=\"".$valorFormatado."\"><td>";
    			$this->Html .= "</tr>";
    			if(empty($campo))
    				$campo = $Campos[$i];
    		//Relacionamento 1x1
    		}else if(!is_int($Campos[$i]) && eregi("^id_",$Campos[$i]) && !eregi("data",$Campos[$i]) && !in_array($Campos[$i] , $this->camposIgnorados) ){
				
				$requerido = $this->verificaRequerido($this->getTabela(), $Campos[$i]);
				
				$queyCidade = "";
				$onChangeEstado = eregi("id_estado",$Campos[$i]) ? "onChange=\"dataGrid.pegarCidades(this.value);\"" : ""; 
				if( eregi("id_cidade",$Campos[$i]) ){
					
					if( !empty($RetornoConsulta[0]["id_estado"]) ){
						$queyCidade = " WHERE id_estado = '".$RetornoConsulta[0]["id_estado"]."' "; 
					}
				}
				$NomeTabelaRelacionamento = Formata::retornaNomeTabela($Campos[$i]);
				
				$QueryRel = " SELECT * FROM ".$NomeTabelaRelacionamento." ".$queyCidade." Order By id ASC ";
				$CamposRela = $this->ConexaoSQL->pegaCamposTabela($NomeTabelaRelacionamento);
    			$RetornoConsultaRel = $this->ConexaoSQL->Select($QueryRel);
    			if(count($RetornoConsultaRel) > 0){
					$this->Html .= "<tr>";
	    			$this->Html .= "<td align=\"right\"><b>".ucfirst( Formata::removeCaractres($NomeTabelaRelacionamento) ).":</b></td>";
	    			$this->Html .= "<td align=\"left\" id = \"td_".$Campos[$i]."\" class=\"form-inline\" style=\"font-size: 13px;\">";
	    			$this->Html .= "<select class=\"form-control input-xs size-80\" name=\"edit_".$Campos[$i]."\" id=\"edit_".$Campos[$i]."\" title=\"".ucfirst($NomeTabelaRelacionamento)."\" class=\"".$requerido."\" ".$onChangeEstado.">";
		    		//Se for campo tipo cidade e estiver inserindo nao exibi alista intera
		    		if( eregi("id_cidade",$Campos[$i]) && ( $Acao == "adicionarPopUp" || $Acao == "adicionar" ) ){
		    			$this->Html .= "<option value=\"\">Selecione Estado</option>";
		    		}else{
		    			$this->Html .= "<option value=\"\">Selecione</option>";
		    			for($j=0; $j<count($RetornoConsultaRel); $j++){
		    				if($RetornoConsultaRel[$j]["id"] == $RetornoConsulta[0][$Campos[$i]])
		    					$Texto = "selected";
		    				else $Texto = "";
		    				$Nm = ($RetornoConsultaRel[$j]["codigo"]) ? $RetornoConsultaRel[$j]["codigo"] : $RetornoConsultaRel[$j]["id"];
		    				$Nm .= " - ";
		    				$Nm .= ($RetornoConsultaRel[$j]["nome"]) ? $RetornoConsultaRel[$j]["nome"] : $RetornoConsultaRel[$j]["id"];
		    				$this->Html .= "<option value=\"".$RetornoConsultaRel[$j]["id"]."\" ".$Texto.">".$Nm."</option>";
		    			}
		    		}
	    			$this->Html .= "</select>";
					if($Acao != "adicionarPopUp" ){
						if(!in_array($Campos[$i] , $this->camposIgnoradosVisu)){
							$this->Html .= "<a href=\"#\" onClick=\"javascript:abrirPopVisu('edit_".$Campos[$i]."', '".$NomeTabelaRelacionamento."');\">
												<span class=\"glyphicon fa fa-desktop\" aria-hidden=\"true\"></span>
											</a>";
						}
						
						if(!in_array($Campos[$i] , $this->camposIgnoradosBusca)){
							$this->Html .= "<a href=\"#\" onClick=\"javascript:window.open('buscapopup.php?campoatual=edit_".$Campos[$i]."&tabela=".$NomeTabelaRelacionamento."', 'Busca', 'height = 300, width = 250, location = no, toolbar = no, menubar=no')\">
												<span class=\"glyphicon fa fa-search\" aria-hidden=\"true\"></span>
											</a>";
						}
						
						if(!in_array($Campos[$i] , $this->camposIgnoradosAdd)){
							$this->Html .= "<a href=\"#\" onClick=\"javascript:window.open('addpopup.php?campoatual=edit_".$Campos[$i]."&tabela=".$NomeTabelaRelacionamento."', 'Busca', 'height=".((count($CamposRela) * 20) + 200).", width=550, scrollbars=yes, resizable=yes')\">
												<span class=\"glyphicon fa fa-plus\" aria-hidden=\"true\"></span>
											</a>";
						}
						
					}
					
	    			$this->Html .= "</td>";
	    			$this->Html .= "</tr>";
    			}
			}else if(!is_int($Campos[$i]) && !eregi("data",$Campos[$i])){
				if(eregi("^id",$Campos[$i]) && !in_array("codigo", $Campos)){
					$valorFormatado =  $RetornoConsulta[0][$Campos[$i]];
					
					$this->Html .= "<tr>";
	    			$this->Html .= "<td align=\"right\" style=\"font-family: Lucida Grande, Verdana, sans-serif;font-size:11px;color: #383d44;\"><b>C�digo:</b></td>";
	    			$this->Html .= "<td align=\"left\" >".$valorFormatado."<td>";
	    			$this->Html .= "</tr>";
				}
				
				$this->Html .= "<input type=\"hidden\" name=\"edit_".$Campos[$i]."\" id=\"edit_".$Campos[$i]."\" value=\"".$RetornoConsulta[0][$Campos[$i]]."\">";
			}//end if
    	}//end for
    	$this->Html .= "<tr><td align=\"center\" colspan=\"3\">&nbsp;</td></tr>";
		
		if($Acao == "adicionarPopUp"){
			$FuncJava = "dataGrid.EnviarEditPopUP('".$Paramentros."', '".$Campo."', '".$this->getTabela()."'); "; 
		}else{
			$FuncJava = "dataGrid.EnviarEdit('".$Paramentros."');"; 
		}
		
    	if($Acao != "abrir")
    		$this->Html .= "<tr><td align=\"center\" colspan=\"3\">
    								<div class=\"btn-group\" role=\"group\" aria-label=\"...\">
    									<button class=\"btn btn-success btn-sm\" type=\"button\" value=\"Salvar\" onclick=\"if(confirm('Deseja salvar?')){ if(formm.verificaF(this.id,'require efeitos','erro')){ ".$FuncJava." } }\">
											<span class=\"glyphicon fa fa-save\" aria-hidden=\"true\"></span> Salvar
										</button>  
    									<input class=\"btn btn-danger btn-sm\" type=\"button\" value=\"Cancelar\" onclick=\"addPop_close();\">
    								</div>
    						</td></tr>";
    	
    	if($Acao == "adicionarPopUp"){	
	    	$this->Html .= "<input type=\"hidden\" value=\"\" name=\"urlHidden\" id=\"urlHidden\">";
			$this->Html .= "<input type=\"hidden\" value=\"\" name=\"queryB\" id=\"queryB\">";
    	}
		
    	$this->Html .= "<input type=\"hidden\" name=\"acao\" id=\"acao\" value=\"".$Acao."\">";
    	$this->Html .= "</table>  </form> <script>
					document.onkeypress = function (evt){
						if(main.procuraTecla(evt,13)){
							if(confirm('Deseja salvar?')){ if(formm.verificaF(this.id,'efeitos','erro')){ ".$FuncJava." } }
						}
					} 
					".$scriptAdicionar."
				</script>  ";
		
    	print $this->Html;
    }//end function
    
    /**
     * 
     *  Monta exporta��o.
     * 
     */
    public function exportar($tipo){
    	
		if($tipo != "csv"){
			$this->Html = "<table border=\"1\" width=\"100%\" height=\"100px\"  cellpadding=\"0\" cellspacing=\"0\" align=\"left\">";
			$this->Html .= "<tr class=\"tituloRelatorio\">";
				
				if($tipo == "html"){
					$this->Html .= "<td width='10%'>";
					$this->Html .= "<div class=\"logo\"></div>";
					$this->Html .= "</td>";
				}

				$this->Html .= "<td  width='90%' align='center'>";
					$this->Html .= "Impressão ".ucfirst($this->getTabela());
				$this->Html .= "</td>";
			$this->Html .= "</tr>";
			$this->Html .= "</table><br />";
			
			$this->Html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"1\" id=\"tabletest\" class=\"table-relatorio\">";
			
			if($this->verficaErros()){
				print $this->Html;
				return;
			}
			
			$this->Html .= "<tr class=\"titulo\">";
			
			//$this->Html .= "<td width=\"5%\" class=\"ColunaInfo\">#</td>";
			@$Porcentagem = 100 / count($this->Colunas);
			
			foreach($this->Colunas as $Ind=>$NomeColuna){
				$Nome = explode(".",$NomeColuna);
				$NomeTabelaRelacionamento = "";
				//Busca relacionamento outra tabela 
				if( eregi("^id_", $Nome[1]) ){
						$NomeTabelaRelacionamento = Formata::retornaNomeTabela($Nome[1]);
				}//end if eregi
				$NomeNovo = ($NomeTabelaRelacionamento) ? $NomeTabelaRelacionamento : $Nome[1];
				if( eregi("^id", $Nome[1]) ){
					$NomeNovo = "C�digo";
				}
				$this->Html .= "<td width=\"".$Porcentagem."\" >";
				$this->Html .= ucfirst($NomeNovo);
				$this->Html .= "</td>";
			}//end foreach
			
			$this->Html .= "</tr>";
			
			$RetornoConsulta = $this->ConexaoSQL->Select($this->montaQuery());
			for($i=0; $i<count($RetornoConsulta); $i++){
				if(($i%2) == 0){
					$linha = "linha";
				}else{
					$linha = "linhaMu";
				}
				$this->Html .= "<tr class=\"".$linha."\" id=\"linhaDataGrid_".$i."\">";
				//Numeracao
				//$this->Html .= "<td width=\"5%\" class=\"ColunaInfo\"> ".($this->getLimiteAtual()+$i+1)." </td>";
				
				//Porcentagem das colunas, em iguais
				@$Porcentagem = 100 / count($this->Colunas);
				$Paramentros = $this->montaParametros();
				
				foreach($this->Colunas as $Ind=>$NomeColuna){
					//Busca relacionamento outra tabela
					if( eregi(".id_", $NomeColuna) ){
						$NomeTabelaRelacionamento = Formata::retornaNomeTabela($NomeColuna);
						$RetornoConsultaRel = $this->ConexaoSQL->SelectAuto($NomeTabelaRelacionamento, array("*"), $RetornoConsulta[$i][$this->pegaNomeCampo($NomeColuna)] );
					}else{ unset($RetornoConsultaRel); }
					
					
					$this->Html .= "<td class=\"relatorio\" width=\"".$Porcentagem."\" >";
					$Teste[$i][$NomeColuna] = $RetornoConsulta[$i][$Ind];
					$Teste[$i][$Ind] = $RetornoConsulta[$i][$Ind];
					//Formata Valor e data
					if(eregi("data", $this->pegaNomeCampo($NomeColuna))){
						$valorFormatado =  Formata::banco2date($RetornoConsulta[$i][$this->pegaNomeCampo($NomeColuna)]);
					}else if(eregi("preco", $this->pegaNomeCampo($NomeColuna)) || $this->isCurrencyCollumn($NomeColuna)){
						$valorFormatado =  Formata::banco2valor($RetornoConsulta[$i][$this->pegaNomeCampo($NomeColuna)]);
					}else{
						$valorFormatado =  $RetornoConsulta[$i][$this->pegaNomeCampo($NomeColuna)];
					}
					
					$this->Html .= (count($RetornoConsultaRel) > 0) ? ($RetornoConsultaRel[0]["nome"]) ? $RetornoConsultaRel[0]["nome"] : $RetornoConsultaRel[0]["id"]  : $valorFormatado;
					$this->Html .= "</td>";
				}//end foreach
	
				$this->Html .= "</tr>";
			}//end for
			
			$this->Html .= "</table>";
			
			if($tipo == "excel"){
				
				$arquivo = Exportacao::criaArquivo("/", $this->Html);
				Exportacao::gerarExceldeArquivoTemporario($arquivo, "exportacao");
			}else if($tipo == "html"){
				print $this->Html;
			}
			
		}else{
			$this->Html = "";
			
			foreach($this->Colunas as $Ind=>$NomeColuna){
				$Nome = explode(".",$NomeColuna);
				$NomeTabelaRelacionamento = "";
				//Busca relacionamento outra tabela 
				if( eregi("^id_", $Nome[1]) ){
						$NomeTabelaRelacionamento = Formata::retornaNomeTabela($Nome[1]);
				}//end if eregi
				$NomeNovo = ($NomeTabelaRelacionamento) ? $NomeTabelaRelacionamento : $Nome[1];
				if( eregi("^id", $Nome[1]) ){
					$NomeNovo = "C�digo";
				}
				
				$this->Html .= "\"".ucfirst($NomeNovo)."\",";
			}//end foreach
			
			$this->Html = substr($this->Html, 0, strlen($this->Html)-1);
			$this->Html .= ";\n";
			
			$RetornoConsulta = $this->ConexaoSQL->Select($this->montaQuery());
			for($i=0; $i<count($RetornoConsulta); $i++){
				
				$Paramentros = $this->montaParametros();
				
				foreach($this->Colunas as $Ind=>$NomeColuna){
					//Busca relacionamento outra tabela
					if( eregi(".id_", $NomeColuna) ){
						$NomeTabelaRelacionamento = Formata::retornaNomeTabela($NomeColuna);
						$RetornoConsultaRel = $this->ConexaoSQL->SelectAuto($NomeTabelaRelacionamento, array("*"), $RetornoConsulta[$i][$this->pegaNomeCampo($NomeColuna)] );
					}else{ 
						unset($RetornoConsultaRel); 
					}

					if(eregi("data", $this->pegaNomeCampo($NomeColuna))){
						$valorFormatado =  Formata::banco2date($RetornoConsulta[$i][$this->pegaNomeCampo($NomeColuna)]);
					}else if(eregi("preco", $this->pegaNomeCampo($NomeColuna)) || $this->isCurrencyCollumn($NomeColuna) ){
						$valorFormatado =  Formata::banco2valor($RetornoConsulta[$i][$this->pegaNomeCampo($NomeColuna)]);
					}else{
						$valorFormatado =  $RetornoConsulta[$i][$this->pegaNomeCampo($NomeColuna)];
					}
					
					$this->Html .= "\"";
					$this->Html .= (count($RetornoConsultaRel) > 0) ? ($RetornoConsultaRel[0]["nome"]) ? $RetornoConsultaRel[0]["nome"] : $RetornoConsultaRel[0]["id"]  : $valorFormatado;

					$this->Html .= "\",";
	
				}//end foreach
	
				$this->Html = substr($this->Html, 0, strlen($this->Html)-1);
	
				$this->Html .= ";\n";
				
			}//end for
			
			$arquivo = Exportacao::criaArquivo("/", $this->Html);
			Exportacao::gerarCsvdeArquivoTemporario($arquivo, "exportacao");
		}
    }
    
    /**
     * 
     *  Monta DataGrid Final.
     * 
     */
    public function montaDataGrid(){
    	
    	
    	if($this->verficaErros()){
    		print $this->Html;
    		return;
    	}
		
    	$this->Html .= "<table border=\"1\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"".$this->getNomeTable()."\" class=\"table-erp\">";
    	
    	
    	$this->geraTituloData();

    	//print $Query;
    	$RetornoConsulta = $this->ConexaoSQL->Select($this->montaQuery());
    	for($i=0; $i<count($RetornoConsulta); $i++){
    		if(($i%2) == 0){
    			$linha = "linha";
    		}else{
    			$linha = "linhaMu";
    		}
    		$this->Html .= "<tr class=\"".$linha."\" id=\"linhaDataGrid_".$i."\">";
    		//Numeracao
    		//$this->Html .= "<td width=\"5%\" class=\"ColunaInfo\"> ".($this->getLimiteAtual()+$i+1)." </td>";
    		
    		//Porcentagem das colunas, em iguais
    		@$Porcentagem = 85 / count($this->Colunas);
    		$Paramentros = $this->montaParametros();
    		
    		foreach($this->Colunas as $Ind=>$NomeColuna){
	    		//Busca relacionamento outra tabela
    			if( eregi(".id_", $NomeColuna) ){
    				$NomeTabelaRelacionamento = Formata::retornaNomeTabela($NomeColuna);
	    			$RetornoConsultaRel = $this->ConexaoSQL->SelectAuto($NomeTabelaRelacionamento, array("*"), $RetornoConsulta[$i][$this->pegaNomeCampo($NomeColuna)] );
    			}else{ unset($RetornoConsultaRel); }
				
    			
    			$this->Html .= "<td id=\"linhaDataGrid_".$i."_".$Ind."\" id=\"dataGridTd_".$i."_".$Ind."\" onClick=\"javascript:doAjaxSemRetorno('ajax_com/editaAddDataGrid.php?acao=abrir&id=".$RetornoConsulta[$i]["id"].$Paramentros."',1,'addPop');addPop_open(650);\">";
    			$Teste[$i][$NomeColuna] = $RetornoConsulta[$i][$Ind];
    			$Teste[$i][$Ind] = $RetornoConsulta[$i][$Ind];
				//Formata Valor e data
				if(eregi("data", $this->pegaNomeCampo($NomeColuna))){
					$valorFormatado =  Formata::banco2date($RetornoConsulta[$i][$this->pegaNomeCampo($NomeColuna)]);
				}else if(eregi("preco", $this->pegaNomeCampo($NomeColuna)) || $this->isCurrencyCollumn($NomeColuna)){
					$valorFormatado =  Formata::banco2valor($RetornoConsulta[$i][$this->pegaNomeCampo($NomeColuna)]);
				}else{
					$valorFormatado =  $RetornoConsulta[$i][$this->pegaNomeCampo($NomeColuna)];
				}
				
    			$this->Html .= (count($RetornoConsultaRel) > 0) ? ($RetornoConsultaRel[0]["nome"]) ? $RetornoConsultaRel[0]["nome"] : $RetornoConsultaRel[0]["id"]  : $valorFormatado;
    			$this->Html .= "</td>";
    		}//end foreach
    		
    		$this->Html .= "<td align=\"right\">";
    		
			if(isset($this->CadastroExtra)){
				foreach($this->CadastroExtra as $res){
					 $this->Html .= "<a href=\"ajax_com/".$res[1]."?id=".$RetornoConsulta[$i]["id"]."\">
									<span class=\"glyphicon fa fa-".$res[0]."\" aria-hidden=\"true\"></span>
								</a>";
				}
			}
			
			//Botoes
              
			
			
	    		$this->Html .= "<a href=\"#\" onclick=\"main.openWindow('impressaoDataGrid.php?id=".$RetornoConsulta[$i]["id"].$Paramentros."','400','400');\">
									<span class=\"glyphicon fa fa-print\" aria-hidden=\"true\"></span>
								</a>";
	
	    		if($this->getEditar())
	    			$this->Html .= "<a href=\"javascript:doAjaxSemRetorno('ajax_com/editaAddDataGrid.php?acao=editar&id=".$RetornoConsulta[$i]["id"].$Paramentros."',1,'addPop');addPop_open(630);\">
										<span class=\"glyphicon fa fa-edit\" aria-hidden=\"true\"></span>
									</a>";
	    		
	    		if($this->getExcluir())
	    			$this->Html .= "<a href=\"javascript:if(confirm('Deseja Excluir?')){efeitos.sumirIE('linhaDataGrid_".$i."', ".count($this->Colunas).");dataGrid.Deletar('&idData=".$RetornoConsulta[$i]["id"].$Paramentros."'); }\">
										<span class=\"glyphicon fa fa-trash\" aria-hidden=\"true\"></span>
									</a>";
	    	$this->Html .= "</td>";
    		$this->Html .= "</tr>";
    	}
    	
    	$this->Html .= "<tr><td colspan=\"".(count($this->Colunas)+3)."\" align=\"left\" class='form-inline'>Exibir: <select class='form-control input-xs size-60px' name=\"Limite\" id=\"Limite\" onChange=\"dataGrid.Limite('".$Paramentros."'); \">
								<option value=\"15\" ".(($this->getLimite()==15)?"selected":"").">15</option>
								<option value=\"30\" ".(($this->getLimite()==30)?"selected":"").">30</option>
								<option value=\"999999\" ".(($this->getLimite()==999999)?"selected":"").">Todos</option>
							</select></td></tr>";
    	
    	//Se estiver vazio
    	if(count($RetornoConsulta) == 0){
    		$this->Html .= "<tr class=\"linha\">";
    		$this->Html .= "<td width=\"100%\" class=\"ColunaInfo\" colspan=\"".(count($this->Colunas) + 1)."\"> Não Existem Registros";
    		$this->Html .= "</td>";
    		$this->Html .= "</tr>";
    	}//end if
    	
    	$this->Html .= "</table>";
    	
    	$this->Html .= "<script> $('urlHidden').value = 'ajax_com/montaDataGrid.php?ordena=".$this->getOrder().$this->montaParametros()."'</script>";
    	
    	if($this->getFlagRefresh())
    		$this->criarRefresh($this->getFlagRefresh());
    		
    	print $this->Html;
    	
    	
    }//end function
    
    /**
     * Gera titulo dataGrid.
     */
    private function geraTituloData(){
    	
    	$Paramentros = $this->montaParametros();
    	
		$this->Html .= "<tr class=\"titulo\">";
		$this->Html .= "<td colspan=\"".(count($this->Colunas))."\" align=\"center\" width=\"96%\"> Exibindo ".$this->getLimiteAtual()." a ".($this->getLimiteAtual()+$this->getLimite())."  </td>";
		if($this->getExportar()){
			$this->Html .= "<td align='right'><a href=\"#\" onClick=\"main.openWindow('exportarDataGrid.php?a=1&ordena=".$this->getOrder().$Paramentros."', '300', '150')\">
								<span class=\"glyphicon fa fa-print\" style=\"font-size: 30px !important;\" aria-hidden=\"true\"></span>
							</a></td>";
		}
		$this->Html .= "</tr>";
		
		$this->Html .= "<tr class=\"titulo\">";
    	
    	//$this->Html .= "<td width=\"5%\" class=\"ColunaInfo\">#</td>";
    	@$Porcentagem = 80 / count($this->Colunas);
    	    	
    	foreach($this->Colunas as $Ind=>$NomeColuna){
    		$Nome = explode(".",$NomeColuna);
    		$NomeTabelaRelacionamento = "";
    		//Busca relacionamento outra tabela 
    		if( eregi("^id_", $Nome[1]) ){
    				$NomeTabelaRelacionamento = Formata::retornaNomeTabela($Nome[1]);
    		}//end if eregi
    		$NomeNovo = ($NomeTabelaRelacionamento) ? $NomeTabelaRelacionamento : $Nome[1];
    		if( eregi("^id", $Nome[1]) ){
    			$NomeNovo = "C�digo";
    		}
    		$this->Html .= "<td width=\"".$Porcentagem."%\" onClick=\"dataGrid.Enviar('&flagOrdena=S&ordena=".$Nome[0].".".$Nome[1].$Paramentros."');\">";
    		$this->Html .= ucfirst($NomeNovo);
    		$this->Html .= "</td>";
    	}//end foreach

        //Coluna para exportacao
        $this->Html .= "<td align=\"right\" width=\"20%\">";

        //Paginacao
    	if($this->getEditar())
    		$this->Html .= "<a href=\"javascript:dataGrid.Enviar('&flag=anterior&ordena=".$this->getOrder().$Paramentros."');\">
								<span class=\"glyphicon fa fa-arrow-circle-left\" aria-hidden=\"true\"></span>
							</a>";
    		
    	if($this->pegaQtditens() > ($this->getLimiteAtual() + $this->getLimite()) ){
    		$this->Html .= "<a href=\"javascript:dataGrid.Enviar('&flag=proximo&ordena=".$this->getOrder().$Paramentros."');\">
								<span class=\"glyphicon fa fa-arrow-circle-right\" aria-hidden=\"true\"></span>
							</a>";
        }else{
			$this->Html .= "<span class=\"glyphicon fa fa-arrow-circle-right\" aria-hidden=\"true\"></span>";
        }
    	
        $this->Html .= "</td>";
        
    	$this->Html .= "</tr>";
    }//end function
    
    /**
     * Monta a busca que vai em cima da lista.
     * 
     * @return html com impress�o
     */
    public function montarBusca(){
    	$Paramentros = $this->montaParametros();
    	
    	$Ret = "<div id=\"busca\" class=\"linhaConfig\"> ";
    	$Ret .= "<ul class=\"nav nav-tabs\" role=\"tablist\">
    				<li role=\"presentation\" class=\"\"><a href=\"#\"  onclick=\"main.trocad('buscaDiv');\" aria-controls=\"home\" role=\"tab\" data-toggle=\"tab\"><span class=\"glyphicon fa fa-search\" aria-hidden=\"true\"></span> Consultar</a></li>
    				<li role=\"presentation\" class=\"\"><a href=\"#\"  onclick=\"doAjaxSemRetorno('ajax_com/editaAddDataGrid.php?acao=adicionar".$Paramentros."',1,'addPop');addPop_open(630);\" aria-controls=\"home\" role=\"tab\" data-toggle=\"tab\"><span class=\"glyphicon fa fa-file\" aria-hidden=\"true\"> Cadastrar Novo</a></li>
    			</ul>";

    	$Ret .= "<div id=\"buscaDiv\" style=\"display:none;\"> <div class=\"form-group form-inline\"> ";
    	
    	//Monta as buscas com colunas
		$Valores = $this->getColunas();
		for($i=0; $i<count($this->getColunas()); $i++){
			$Nome = explode(".",$Valores[$i]);
			$QueryBusca .= $Nome[0].".".$Nome[1].".".$Nome[2].",";
			//Monta Relacionamento 1x1
			if( eregi("^id_",$Nome[1]) ){
				$NomeTabelaRelacionamento = Formata::retornaNomeTabela($Nome[1]);
				
				$QueryRel = " SELECT * FROM ".$NomeTabelaRelacionamento." Order By id ASC ";
    			$RetornoConsultaRel = $this->ConexaoSQL->Select($QueryRel);
    			if(count($RetornoConsultaRel) > 0){
	    			$Ret .= " ".ucfirst($NomeTabelaRelacionamento);
	    			$Ret .= "<select class=\"form-control input-xs\" name=\"".$Nome[1]."\" id=\"".$Nome[1]."\">";
	    			$Ret .= "<option value=\"0\">Selecione</option>";
	    			for($j=0; $j<count($RetornoConsultaRel); $j++){
	    				$Nm = ($RetornoConsultaRel[$j]["nome"]) ? $RetornoConsultaRel[$j]["nome"] : $RetornoConsultaRel[$j]["id"];
	    				$Ret .= "<option value=\"".$RetornoConsultaRel[$j]["id"]."\">".$Nm."</option>";
	    			}//end for
	    			$Ret .= "</select>";
	    			$Ret .= "<td>";
	    			$Ret .= "</tr>";
    			}//end if
			}else{
			
				$Ret .= "<label for=\"".$Nome[1]."\">".ucfirst($Nome[1])."</label> <input class=\"form-control input-xs\" type=\"text\" name=\"$Nome[1]\" id=\"$Nome[1]\" > ";
			}//end if eregi
		}//end for

		$Ret .= "<button type=\"button\" class=\"btn btn-sm btn-default\" onClick=\"dataGrid.enviarget('".$QueryBusca."', '".$Paramentros."');\">Buscar</button>";
				
		$Ret .= "<input type=\"hidden\" value=\"\" name=\"urlHidden\" id=\"urlHidden\">";
		$Ret .= "<input type=\"hidden\" value=\"\" name=\"queryB\" id=\"queryB\">";
		
		$Ret .= " </div>
				</div>
			</div>";
				
		return $Ret;
    }//end function
    
    /**
     * Monta a query de busca.
     * 
     * @param $Query set $Query
     * @return query where
     */
    public function MontaQueryWhere($Query){
    	//Busca Automatica
    	if($this->getBusca()){
    		if(!eregi("where", $Query))
    			$Where = "WHERE 1 ";

    		$Parts = explode(",",$this->getBusca());
    		for($e=0; $e<count($Parts); $e++){
    			$Valores = explode("|",$Parts[$e]);
    			$Valores[0] = explode(".", $Valores[0]);
    			if($Valores[0][1] == 'like')
    				$Operador = " LIKE '%".$Valores[1]."%' ";
    			else
    				$Operador = " = '".$Valores[1]."' ";
				if(!empty($Valores[1])){
					$Valores[0][0] = str_replace("-",".",$Valores[0][0]);
					$Where .= " AND ".$Valores[0][0]." ".$Operador;
				}//end if
    		}//end for
    		return $Where;
    	}//end if
    }//end function
    
    /**
     * Deleta o registro.
     * 
     * @id set id
     */
    function deletaDataGrid($Id){
    	$this->ConexaoSQL->deleteQuery("DELETE FROM ".$this->getTabela()." WHERE id = '".$Id."' ");
    }//end function
    
    /**
     * cria timeout a cada x tempo.
     * 
     * @param TempoRefresh tempo do refresh
     */
    public function criarRefresh($TempoRefresh){
    	print "<script>dataGrid.criarTimeoutRefresh('".$this->getNomeDivPai()."' ,".$TempoRefresh.");</script>";
    }
    
    /**
     * Monta tela de impressao.
     */
    public function montaImpressao(){
       $this->Html = "<table border=\"1\" width=\"100%\" height=\"100px\"  cellpadding=\"0\" cellspacing=\"0\" align=\"left\">";
            $this->Html .= "<tr class=\"tituloRelatorio\">";

                    
                    $this->Html .= "<td width='10%'>";
                    $this->Html .= "<div class=\"logo\"></div>";
                    $this->Html .= "</td>";


                    $this->Html .= "<td  width='90%' align='center'>";
                            $this->Html .= "Impressão ".ucfirst($this->getTabela());
                    $this->Html .= "</td>";
            $this->Html .= "</tr>";
            $this->Html .= "</table><br />";

        $this->Html .= "<table border=\"1\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" align=\"left\" class=\"table-relatorio\">";

        $Query = $this->Query." WHERE id = '".$this->getId()."' ";
    	$RetornoConsulta = $this->ConexaoSQL->Select($Query);

        $Campos = $this->ConexaoSQL->pegaCamposTabela($this->getTabela());
        for($i=0; $i<count($Campos); $i++){
            if(!is_int($Campos[$i]) && eregi("^img",$Campos[$i])  ){

                $this->Html .= "<tr>";
                    $this->Html .= "<td align=\"right\" style=\"font-family: Lucida Grande, Verdana, sans-serif;font-size:11px;color: #383d44;\"><b>".ucfirst($Campos[$i]).":</b></td>";

                    if(!empty($RetornoConsulta[0][$Campos[$i]])){
                            $imagem = "../img_prod/".$RetornoConsulta[0][$Campos[$i]];
                    }else{
                            $imagem = "../img_prod/noImg.gif";
                    }
                    $idQ = $this->getId();
                    if(!empty($idQ)){
                            $this->Html .= "<td align=\"left\" ><img width=\"100px\" src=\"".$imagem."\" alt=\"produto\" id=\"editimg_".$Campos[$i]."\" ><td>";
                    }else{
                            $this->Html .= "<td align=\"left\" >Liberado apenas altera��o</td>";
                    }
                $this->Html .= "</tr>";

            }else if(!is_int($Campos[$i]) && $Campos[$i]!="id" && !eregi("^id",$Campos[$i]) && !in_array($Campos[$i] , $this->camposIgnorados) ){
		$this->Html .= "<tr>";
                    $this->Html .= "<td align=\"right\" style=\"font-family: Lucida Grande, Verdana, sans-serif;font-size:11px;color: #383d44;\"><b>".ucfirst(Formata::removeCaractres($Campos[$i])).":</b></td>";

                    //Formata Valor e data
                    if(eregi("data", $Campos[$i]) || eregi("nascimento", $Campos[$i])){
                            $valorFormatado =  Formata::banco2date($RetornoConsulta[0][$Campos[$i]]);
                            $camposData[] = "edit_".$Campos[$i];
                    }else if(eregi("preco", $Campos[$i]) || $this->isCurrencyCollumn($Campos[$i]) ){
                            $valorFormatado =  Formata::banco2valor($RetornoConsulta[0][$Campos[$i]]);
                    }else{
                            $valorFormatado =  $RetornoConsulta[0][$Campos[$i]];
                    }

                        $this->Html .= "<td align=\"left\" >".$valorFormatado."<td>";
                    $this->Html .= "</tr>";
    			if(empty($campo))
    				$campo = $Campos[$i];
            //Relacionamento 1x1
            }else if(!is_int($Campos[$i]) && eregi("^id_",$Campos[$i]) && !eregi("data",$Campos[$i]) && !in_array($Campos[$i] , $this->camposIgnorados) ){


                $queyCidade = "";
                
                $queyCidade = " WHERE id = '".$RetornoConsulta[0][$Campos[$i]]."'";
               
                $NomeTabelaRelacionamento = Formata::retornaNomeTabela($Campos[$i]);

                $QueryRel = " SELECT * FROM ".$NomeTabelaRelacionamento." ".$queyCidade." Order By id ASC ";
                //print $QueryRel;
                $CamposRela = $this->ConexaoSQL->pegaCamposTabela($NomeTabelaRelacionamento);
                $RetornoConsultaRel = $this->ConexaoSQL->Select($QueryRel);
                if(count($RetornoConsultaRel) > 0){
                        $this->Html .= "<tr>";
                            $this->Html .= "<td align=\"right\"><b>".ucfirst( Formata::removeCaractres($NomeTabelaRelacionamento) ).":</b></td>";
                            $this->Html .= "<td align=\"left\" id = \"td_".$Campos[$i]."\">".$RetornoConsultaRel[0]["nome"]."";
                            $this->Html .= "</td>";
                        $this->Html .= "</tr>";
                    }
            }else if(!is_int($Campos[$i]) && !eregi("data",$Campos[$i])){
                if(eregi("^id",$Campos[$i]) && !in_array("codigo", $Campos)){
                        $valorFormatado =  $RetornoConsulta[0][$Campos[$i]];

                    $this->Html .= "<tr>";
                    $this->Html .= "<td align=\"right\" style=\"font-family: Lucida Grande, Verdana, sans-serif;font-size:11px;color: #383d44;\"><b>C�digo:</b></td>";
                    $this->Html .= "<td align=\"left\" >".$valorFormatado."<td>";
                    $this->Html .= "</tr>";
                }
            }//end if
        }



        $this->Html .= "<tr><td align=\"center\" colspan=\"3\">&nbsp;</td></tr>";

        $this->Html .= "</table>";

        print $this->Html;
    }

    /**
     * Verifica se tem erros na gera��o do dataGrid e joga na tela.
     * 
     * @return flag
     */
    private function verficaErros(){
    	$erro = false;
    	if(count($this->Colunas) == 0){
    		$Saida = "<br>Erro DataGrid: Contate o Administrador; Colunas devem ser cadastradas  !";
    		$erro = true;
    	}//end if
    	
    	if($this->getQuery() == ''){
    		$Saida .= "<br>Erro DataGrid: Contate o Administrador; Query deve existir !";
    		$erro = true;
    	}//end if
    	
    	if($this->getNomeTable() == ''){
    		$Saida .= "<br>Erro DataGrid: Contate o Administrador; Nome tabela n�o especificado !";
    		$erro = true;
    	}//end if
    	
    	if($this->getNomeDivPai() == ''){
    		$Saida .= "<br>Erro DataGrid: Contate o Administrador; Elemento de retorno n�o especificado !";
    		$erro = true;
    	}//end if
    	
    	if($erro)
    		$this->Html = "<div class=\"erro\">".$Saida."</div>";
    		
    	return $erro;
    	
    }//end function
    
    /**
     * Monta Parametro para passar pro ajax.
     * @return parametro
     */
    public function montaParametros(){
    	$Colunas = implode(",",$this->Colunas);
    	$collumnsCurrency = implode(",",$this->collumnsCurrency);
    	$camposIgnorados = implode(",",$this->camposIgnorados);
    	
		if(isset($this->CadastroExtra)){
			foreach($this->CadastroExtra as $res){
				$cadastrosExtra[] = implode(",", $res);
			}
			if(count($cadastrosExtra) > 1)
				$cadastroExtra = implode("|", $cadastrosExtra);
			else
				$cadastroExtra = $cadastrosExtra[0];
			
		}
		
    	return "&query=".$this->Query."&camposIgnorados=".$camposIgnorados."&collumnsCurrency=".$collumnsCurrency."&colunas=".$Colunas."&tabela=".$this->getNomeTable()."&editar=".$this->getEditar()."&excluir=".$this->getExcluir()."&nomedivpai=".$this->getNomeDivPai()."&tabelaBD=".$this->getTabela()."&limite=".$this->getLimite()."&limiteatual=".$this->getLimiteAtual()."&buscaItens=".$this->getBusca()."&cadastroExtras=".$cadastroExtra;
    }//end function
	
	/*
	Retorna query dataGrid.
	*/
	public function montaQuery($usarLimite = true){
		$query = $this->getQuery();
    	
    	$query = $query.$this->MontaQueryWhere($Query);

//Define Tipo do Order 
    	if($_SESSION["flag"]){
	    	if( $_SESSION["OrdenaTipo"] != " DESC" ){
	    		$_SESSION["OrdenaTipo"] = " DESC";
	    	}else{
	    		$_SESSION["OrdenaTipo"] = " ASC";	    		
	    	}
    	}else{
    		$_SESSION["OrdenaTipo"] = $_SESSION["OrdenaTipo"];
    	}
    	
    	//Ordenacao
    	if($this->getOrder())
    		$query .= " ORDER By ".$this->getOrder().$_SESSION["OrdenaTipo"];
    
    	//Pagina��o
    	if($this->getLimite() && $usarLimite)
    		$query .= " LIMIT ".$this->getLimiteAtual().", ".$this->getLimite();	
			
		return $query;
	}
	
	/**
	* Retorna qtd itens.
	*/
	public function pegaQtditens(){
		$RetornoConsulta = $this->ConexaoSQL->Select($this->montaQuery(false));
		return count($RetornoConsulta);
	}
    
    /**
     *
	 * Set FlagRefresh.
	 * 
	 * @param FlagRefresh a user usada
	 *
	 */
	public function setFlagRefresh($flagRefresh){
		$this->FlagRefresh = $flagRefresh;
		$_SESSION["FlagRefresh"] = $flagRefresh;
	}//end Function
	
	/**
	 * Returns if Collums is currency type.
	 * 
	 * @param unknown $collumn
	 */
	public function isCurrencyCollumn($collumn){
		foreach($this->collumnsCurrency as $v){
			if( $collumn == $v)
				return true;
		}
		
		return false;
	}
	
	 /**
     * Pegar nome Tabela.
     * 
     * @return nome tabela
     */
    function pegarNomeTabela(){
    	$Pt = explode(".", $this->Colunas[0]);
    	return $Pt[0];
    }//end function
    
    /**
     * Retorna nome campo com tabela
     * 
     * @param $NomeCampo set $NomeCampo
     * @return Nome
     */
	public function pegaNomeCampo($NomeCampo){
		$Pt = explode(".", $NomeCampo);
    	return $Pt[1];
	}//end function
	
	 /**
     *
	 * get FlagRefresh.
	 * 
	 * @return FlagRefresh
	 */
	private function getFlagRefresh(){
		return $this->FlagRefresh;
	}//end Function
	
	/**
     *
	 * Set query.
	 * 
	 * @param query a user usada
	 *
	 */
	public function setQuery($query){
		$this->Query = $query;
	}//end Function
	
	 /**
     *
	 * get query.
	 * 
	 * @return Query
	 */
	private function getQuery(){
		return $this->Query;
	}//end Function
	
	/**
     *
	 * Set Busca.
	 * 
	 * @param Busca a user usada
	 *
	 */
	public function setBusca($busca){
		$this->Busca = $busca;
	}//end Function
	
	 /**
     *
	 * get Busca.
	 * 
	 * @return Busca
	 */
	private function getBusca(){
		return $this->Busca;
	}//end Function
	
	 /**
     *
	 * Set limite.
	 * 
	 * @param limite a user usada
	 *
	 */
	public function setLimite($limite){
		if(empty($limite))
			$limite = 15;
		$this->Limite = $limite;
	}//end Function
	
	 /**
     *
	 * get limite.
	 * 
	 * @return limite
	 */
	public function getLimite(){
		return $this->Limite;
	}//end Function
	
	/**
     *
	 * Set LimiteAtual.
	 * 
	 * @param LimiteAtual a user usada
	 *
	 */
	public function setLimiteAtual($limiteAtual){
		$this->LimiteAtual = $limiteAtual;
	}//end Function
	
	 /**
     *
	 * get LimiteAtual.
	 * 
	 * @return LimiteAtual
	 */
	public function getLimiteAtual(){
		return $this->LimiteAtual;
	}//end Function
	
	
	/**
     *
	 * Set Order.
	 * 
	 * @param Order a user usada
	 *
	 */
	public function setOrder($order){
		$this->Order = $order;
	}//end Function
	
	 /**
     *
	 * get Order.
	 * 
	 * @return Order
	 */
	private function getOrder(){
		return $this->Order;
	}//end Function
	
	/**
     *
	 * Set Editar.
	 * 
	 * @param Editar booean
	 *
	 */
	public function setEditar($editar){
		$this->Editar = $editar;
	}//end Function
	
	 /**
     *
	 * get Editar.
	 * 
	 * @return editar
	 */
	private function getEditar(){
		return $this->Editar;
	}//end Function
	
	/**
     *
	 * Set Excluir.
	 * 
	 * @param Excluir boolean
	 *
	 */
	public function setExcluir($excluir){
		$this->Excluir = $excluir;
	}//end Function
	
	 /**
     *
	 * get Excluir.
	 * 
	 * @return Excluir
	 */
	private function getExcluir(){
		return $this->Excluir;
	}//end Function
	
	/**
     *
	 * Set NomeTable.
	 * 
	 * @param NomeTable boolean
	 *
	 */
	public function setNomeTable($nomeTable){
		$this->NomeTable = $nomeTable;
	}//end Function
	
	 /**
     *
	 * get NomeTable.
	 * 
	 * @return NomeTable
	 */
	private function getNomeTable(){
		return $this->NomeTable;
	}//end Function
	
	/**
     *
	 * Set NomeDivPai.
	 * 
	 * @param NomeDivPai boolean
	 *
	 */
	public function setNomeDivPai($nomeDivPai){
		$this->NomeDivPai = $nomeDivPai;
	}//end Function
	
	 /**
     *
	 * get NomeDivPai.
	 * 
	 * @return NomeDivPai
	 */
	private function getNomeDivPai(){
		return $this->NomeDivPai;
	}//end Function
	
	/**
     *
	 * Set Colunas.
	 * 
	 * @param Colunas a user usada
	 *
	 */
	public function setColunas($coluna){
		$this->Colunas[] = $coluna;
	}
	
	/**
     *
	 * Set colunas.
	 *
	 */
	public function getColunas(){
		return $this->Colunas;
	}
	
	/**
	 *
	 * Set Colunas currency.
	 *
	 * @param Colunas a user usada
	 *
	 */
	public function addCollumnsCurrency($coluna){
		$this->collumnsCurrency[] = $coluna;
	}
	
	public function addCamposIgnorados($coluna){
		$this->camposIgnorados[] = $coluna;
	}
	
	
	/**
	 *
	 * Set colunas.
	 *
	 */
	public function getCollumnsCurrency(){
		return $this->collumnsCurrency;
	}
	
	/**
     *
	 * addCadastroExtra.
	 * 
	 * @param cadastros extras
	 *
	 */
	public function addCadastroExtra($cadastroExtra){
		$this->CadastroExtra[] = $cadastroExtra;
	}//end Function
	
	/**
     *
	 * getCadastroExtra.
	 *
	 */
	public function getCadastroExtra(){
		return $this->CadastroExtra;
	}//end Function
	
	/* Set Id.
	 * 
	 * @param Id 
	 *
	 */
	public function setId($Id){
		$this->Id = $Id;
	}//end Function
	
	 /**
     *
	 * get Id.
	 * 
	 * @return Id
	 */
	private function getId(){
		return $this->Id;
	}//end Function
	
	/**
	 *  Set Tabela.
	 * 
	 * @param Tabela 
	 *
	 */
	public function setTabela($Tabela){
		$this->Tabela = $Tabela;
	}//end Function
	
	 /**
     *
	 * get Tabela.
	 * 
	 * @return Tabela
	 */
	private function getTabela(){
		return $this->Tabela;
	}//end Function
	
	/**
	 *  Set Exportar.
	 * 
	 * @param Exportar
	 *
	 */
	public function setExportar($exportar){
		$this->Exportar = $exportar;
	}//end Function
	
	 /**
     *
	 * get Exportar.
	 * 
	 * @return Exportar
	 */
	private function getExportar(){
		return $this->Exportar;
	}//end Function
    
}
?>