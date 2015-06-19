<?php
# - - - - - - - - - - - - - - - -  ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/01/08
#  
#  Classe respons�vel pelos relat�rios
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Classe respons�vel pelos relat�rios
 *
 * @author Augusto Gava
 * @version 1.0
 */
class Relatorios {
    public $ConexaoSQL;
    public $mes = Array("Janeiro", "Fevereiro", "Marco", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outrubro", "Novembro", "Desembro");
	
    /**
	 * M�todo construtor.
	 *
	 * @param ConexaoSQL conex�o com o banco.
	 * @param Formata formata dados.
	 */
    public function Relatorios($ConexaoSQL){
        $this->ConexaoSQL = $ConexaoSQL;
    }//end function
    
    /**
     *
	 * Monta query de busca de clietes.
	 *
	 *@param parametros GET
	 *@return query
	 */
    private function montaRelClientes($parametros){

		if(!empty($parametros["filtro3"])){
			$queryWhere = " AND clientes.id_estado = '".$parametros["filtro3"]."' ";
		}
		
		if(!empty($parametros["filtro4"])){
			$queryWhere .= " AND clientes.id_cidade = '".$parametros["filtro4"]."' ";
		}
		
        if($parametros["filtro1"] == 1){
        	$query = "SELECT clientes.nome, clientes.razao, clientes.telefone1, clientes.telefone2, clientes.contato FROM clientes WHERE clientes.id_status_geral = '1' AND clientes.id NOT IN ( SELECT pedidos.id_clientes FROM pedidos) ".$queryWhere." ";
        	$retorno["titulo"] = "Clientes que nunca compraram";
        }else{
			$query = "SELECT clientes.nome, clientes.razao, clientes.telefone1, clientes.telefone2, clientes.contato, pedidos.data_fechada FROM clientes INNER JOIN pedidos ON pedidos.id_clientes = clientes.id WHERE clientes.id_status_geral = '1' AND data_fechada <= '".Formata::date2banco($parametros["filtro2"])."' ".$queryWhere."";
			$retorno["titulo"] = "Clientes que não compram desde ".$parametros["filtro2"];
        }
        
        $RetornoConsultaRel = $this->ConexaoSQL->Select($query);
    	
    	$retorno["campos"] = array("nome","razao","telefone1","telefone2","contato","data_fechada");
    	
		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$retorno["valores"][$j]["nome"] = $RetornoConsultaRel[$j]["nome"];
				$retorno["valores"][$j]["razao"] = $RetornoConsultaRel[$j]["razao"];
				$retorno["valores"][$j]["telefone1"] = $RetornoConsultaRel[$j]["telefone1"];
				$retorno["valores"][$j]["telefone2"] = $RetornoConsultaRel[$j]["telefone2"];
				$retorno["valores"][$j]["contato"] = $RetornoConsultaRel[$j]["contato"];
				$retorno["valores"][$j]["data Fechada"] = $RetornoConsultaRel[$j]["data_fechada"];
			}
		}
		
		return $retorno;
        
    }//end function

 	/**
     *
	 * Monta query de busca de producao.
	 *
	 *@param parametros GET
	 *@return query
	 */
    private function montaRelProducao($parametros){

		$query = "SELECT 
						(SELECT sum(A.qtd) FROM estoque as A WHERE A.tipo = '1' AND A.id_produtos = B.id_produtos) as entrada,
						(SELECT sum(C.qtd) FROM estoque as C WHERE C.tipo = '2' AND C.id_produtos = B.id_produtos) as saida,
						 produtos.codigo, produtos.nome, produtos.descricao
				FROM estoque as B 
				INNER JOIN produtos ON B.id_produtos = produtos.id
				GROUP By B.id_produtos ORDER By produtos.codigo";
				
		$retorno["titulo"] = "Produção ";
		
	    $RetornoConsultaRel = $this->ConexaoSQL->Select($query);
    	
    	$retorno["campos"] = array("Produto","Estoque");
    	
		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$retorno["valores"][$j]["Produto"] = $RetornoConsultaRel[$j]["codigo"]." - ".$RetornoConsultaRel[$j]["descricao"];
				$retorno["valores"][$j]["Estoque"] = ($RetornoConsultaRel[$j]["entrada"] - $RetornoConsultaRel[$j]["saida"]);
			}
		}
		
		return $retorno;
        
    }//end function
    
    /**
     *
     * Monta query de busca da curva ABC (% de vendas de cada produto em um periodo).
     *
     *@param parametros GET
     *@return query
     */
    private function montaRelCurvaAbc($parametros){

        if(!empty($parametros["filtro3"])){
            $queryCliente = "A.id_clientes = '".$parametros["filtro3"]."' AND ";
        }

        $query = "SELECT SUM(qtd) as qtdTotal, SUM(qtd * 100) / (SELECT SUM( qtd ) AS qtd
                                                    FROM pedidos AS A
                                                    INNER JOIN pedidos_itens AS B ON A.id = B.id_pedidos
                                                    WHERE ".$queryCliente." A.data_fechada >= '".Formata::date2banco($parametros["filtro1"])." 00:00:01'
                                                                    AND A.data_fechada <= '".Formata::date2banco($parametros["filtro2"])." 23:59:59'
                                                                    AND A.id_status_pedidos
                                                                    IN ( 4, 5 )
                                                                                ) AS media,

                                C.codigo, C.nome, C.descricao FROM pedidos as A
                                INNER JOIN pedidos_itens AS B ON A.id = B.id_pedidos
                                INNER JOIN produtos AS C on C.id = B.id_produtos
                                WHERE ".$queryCliente." A.data_fechada >= '".Formata::date2banco($parametros["filtro1"])." 00:00:01' AND A.data_fechada <= '".Formata::date2banco($parametros["filtro2"])." 23:59:59'
                                AND A.id_status_pedidos IN (4, 5)
                                                GROUP By B.id_produtos Order By media DESC";
				
	$retorno["titulo"] = "Curva ABC ";

        //print $query;
        $RetornoConsultaRel = $this->ConexaoSQL->Select($query);

    	$retorno["campos"] = array("Produto","%", "Qtd");
    	
        if(count($RetornoConsultaRel) > 0){
            for($j=0; $j<count($RetornoConsultaRel); $j++){
                $retorno["valores"][$j]["Produto"] = $RetornoConsultaRel[$j]["codigo"]." - ".$RetornoConsultaRel[$j]["descricao"];
                $retorno["valores"][$j]["%"] = round($RetornoConsultaRel[$j]["media"], 2);
                $retorno["valores"][$j]["Qtd"] = $RetornoConsultaRel[$j]["qtdTotal"];
            }
        }

        return $retorno;
        
    }//end function
    
     /**
     *
	 * Monta query de busca de faturamento.
	 *
	 *@param parametros GET
	 *@return query
	 */
    private function montaRelFaturamento($parametros){

        if($parametros["filtro1"] == 1){
        	$query = "SELECT sum(fluxo.valor) as valor, fluxo.ocorrencia, pedidos.codigo as nome FROM fluxo 
																				INNER JOIN pedidos ON pedidos.id = fluxo.id_pedidos
																				WHERE fluxo.tipo = '1' 
																				AND fluxo.data >= '".Formata::date2banco($parametros["filtro2"])." 00:00:01'
																				AND fluxo.data <= '".Formata::date2banco($parametros["filtro3"])." 23:59:59' GROUP By pedidos.id ORDER By valor DESC";
																				
        	$retorno["titulo"] = "Faturamento por Pedido";
        	$retorno["campos"] = array("Có�digo","valor");
			
        }else if($parametros["filtro1"] == 2){
			$query = "SELECT SUM(fluxo.valor) as valor, representantes.nome as nome FROM fluxo 
																					INNER JOIN pedidos ON pedidos.id = fluxo.id_pedidos
																					LEFT JOIN representantes ON representantes.id = pedidos.id_representantes
																					WHERE fluxo.tipo = '1' 
																					AND fluxo.data >= '".Formata::date2banco($parametros["filtro2"])." 00:00:01'
																					AND fluxo.data <= '".Formata::date2banco($parametros["filtro3"])." 23:59:59'
																					GROUP By representantes.id ORDER By valor DESC";
			$retorno["titulo"] = "Faturamento por Representante";
			$retorno["campos"] = array("Nome","valor");
			
        }else if($parametros["filtro1"] == 3){
			$query = "SELECT SUM(fluxo.valor) as valor, clientes.nome as nome FROM fluxo 
																					INNER JOIN pedidos ON pedidos.id = fluxo.id_pedidos
																					LEFT JOIN clientes ON clientes.id = pedidos.id_clientes
																					WHERE fluxo.tipo = '1' 
																					AND fluxo.data >= '".Formata::date2banco($parametros["filtro2"])." 00:00:01'
																					AND fluxo.data <= '".Formata::date2banco($parametros["filtro3"])." 23:59:59'
																					GROUP By clientes.id ORDER By valor DESC";
			$retorno["titulo"] = "Faturamento por Cliente";
			$retorno["campos"] = array("Nome","valor");
        }
        
        $RetornoConsultaRel = $this->ConexaoSQL->Select($query);
    	
		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				if(empty($RetornoConsultaRel[$j]["nome"])){
					$RetornoConsultaRel[$j]["nome"] = "Sem Representante";
				}
				$retorno["valores"][$j][0] = $RetornoConsultaRel[$j]["nome"]. str_replace("<br>", "", $RetornoConsultaRel[$j]["ocorrencia"]);
				$retorno["valores"][$j][1] = Formata::banco2valor($RetornoConsultaRel[$j]["valor"]);
				
				$total += $RetornoConsultaRel[$j]["valor"];
			}
			
			$retorno["valores"][$j][0] = "<b>Total:</b> ";
			$retorno["valores"][$j][1] = "<b>".Formata::banco2valor( $total )."<b>";
				
		}
		
		return $retorno;
        
    }//end function
    
     /**
     *
	 * Monta query de busca de faturamento.
	 *
	 *@param parametros GET
	 *@return query
	 */
    private function montaRelVendas($parametros){

        if($parametros["filtro1"] == 1){

            $query = "SELECT SUM(pedidos_itens.qtd * pedidos_itens.preco) as valor, produtos.codigo as nome FROM pedidos
                    INNER JOIN pedidos_itens ON pedidos_itens.id_pedidos = pedidos.id
                    INNER JOIN produtos ON produtos.id = pedidos_itens.id_produtos
                    WHERE pedidos.data_fechada >= '".Formata::date2banco($parametros["filtro2"])." 00:00:01'
                    AND pedidos.data_fechada <= '".Formata::date2banco($parametros["filtro3"])."  23:59:59'
                    AND id_status_pedidos IN ('4', '5')
                    GROUP By produtos.id ORDER By valor DESC ";

        	$retorno["titulo"] = "Vendas por Produto";
        	$retorno["campos"] = array("Descricao","valor");
			
        }else if($parametros["filtro1"] == 2){
			$query = "SELECT SUM(pedidos_itens.qtd * pedidos_itens.preco) as valor, representantes.nome as nome,
                        SUM( CASE WHEN pedidos.comissao = 0 THEN
                                                                                ( (pedidos_itens.total * 7) / 100 )
                                                                        ELSE
                                                                                ((pedidos_itens.total * pedidos.comissao) / 100)
                                                                        END )
                                                                  as comissao
                                FROM pedidos
                                LEFT JOIN representantes ON representantes.id = pedidos.id_representantes
                                INNER JOIN pedidos_itens ON pedidos_itens.id_pedidos = pedidos.id
                                WHERE pedidos.data_fechada >= '".Formata::date2banco($parametros["filtro2"])." 00:00:01'
                                AND pedidos.data_fechada <= '".Formata::date2banco($parametros["filtro3"])."  23:59:59'
                                AND id_status_pedidos IN ('4', '5')
                                GROUP By representantes.id ORDER By valor DESC";

			$retorno["titulo"] = "Vendas por Representante";
			$retorno["campos"] = array("Nome","valor", "Comissão");
			
        }else if($parametros["filtro1"] == 3){
			$query = "SELECT SUM(pedidos_itens.qtd * pedidos_itens.preco) as valor, clientes.nome as nome,
                            								SUM(CASE WHEN pedidos.comissao = 0 THEN
                                                                                ( (pedidos_itens.total * 7) / 100 )
                                                                        ELSE
                                                                                ((pedidos_itens.total * pedidos.comissao) / 100)
                                                                        END )
                                                                  as comissao
                                    FROM pedidos
                                    LEFT JOIN clientes ON clientes.id = pedidos.id_clientes
                                    INNER JOIN pedidos_itens ON pedidos_itens.id_pedidos = pedidos.id
                                    WHERE pedidos.data_fechada >= '".Formata::date2banco($parametros["filtro2"])." 00:00:01'
                                    AND pedidos.data_fechada <= '".Formata::date2banco($parametros["filtro3"])."  23:59:59'
                                    AND id_status_pedidos IN ('4', '5')
                                    GROUP By clientes.id ORDER By valor DESC";

			$retorno["titulo"] = "Vendas por Clientes";
			$retorno["campos"] = array("Nome","valor");
        }else if($parametros["filtro1"] == 4){
			if( !empty($parametros["filtro4"]))
				$cli = "AND pedidos.id_clientes = '".$parametros["filtro4"]."'";
        	
			$query = "SELECT SUM(pedidos_itens.qtd * pedidos_itens.preco) as valor,SUM(pedidos_itens.qtd) as qtd, clientes.nome as nome,pedidos.codigo, pedidos.data_fechada
                            								
                                    FROM pedidos
                                    LEFT JOIN clientes ON clientes.id = pedidos.id_clientes
                                    INNER JOIN pedidos_itens ON pedidos_itens.id_pedidos = pedidos.id
                                    WHERE pedidos.data_fechada >= '".Formata::date2banco($parametros["filtro2"])." 00:00:01'
                                    AND pedidos.data_fechada <= '".Formata::date2banco($parametros["filtro3"])." 23:59:59'
                                    AND id_status_pedidos IN ('4', '5') AND pedidos_itens.id_produtos NOT IN('45','46') ".$cli."
                                    GROUP By pedidos.id ORDER By data_fechada DESC";

			$retorno["titulo"] = "Vendas por Clientes";
			$retorno["campos"] = array("Codigo","Cliente","Qtd","Valor Total", "Data");
        }
        
        if($parametros["filtro1"] == 5){
        	$retorno["titulo"] = "Vendas Mensalmente";
			$retorno["campos"] = array("Mes", "Qtd", "Valor");
			$j = 0;
			for($i=1; $i<=date("m"); $i++){
				$dtInicio 	= date("Y-m-d", mktime(0, 0, 0 , $i, 1, date("Y") ));
				$dtFim 		= date("Y-m-d", mktime(0, 0, 0 , $i+1, 1-1, date("Y") ));
				
				$query = "SELECT SUM(pedidos_itens.qtd * pedidos_itens.preco) as valor,SUM(pedidos_itens.qtd) as qtd 
                            								
                                    FROM pedidos
                                    LEFT JOIN clientes ON clientes.id = pedidos.id_clientes
                                    INNER JOIN pedidos_itens ON pedidos_itens.id_pedidos = pedidos.id
                                    WHERE pedidos.data_fechada >= '".$dtInicio." 00:00:01'
                                    AND pedidos.data_fechada <= '".$dtFim." 23:59:59'
                                    AND id_status_pedidos IN ('4', '5') AND pedidos_itens.id_produtos NOT IN('45','46') 
                                     ORDER By data_fechada DESC";
				
				$RetornoConsultaRel = $this->ConexaoSQL->Select($query);
				
				$retorno["valores"][$j][0] = $this->mes[$i-1];
				$retorno["valores"][$j][1] = $RetornoConsultaRel[0]["qtd"];
				$retorno["valores"][$j++][2] = Formata::banco2valor($RetornoConsultaRel[0]["valor"]);
				
			}
        	
        }else{
			//print $query;
	        $RetornoConsultaRel = $this->ConexaoSQL->Select($query);
	    	
			if(count($RetornoConsultaRel) > 0){
				if($parametros["filtro1"] == 4){
					for($j=0; $j<count($RetornoConsultaRel); $j++){
						$retorno["valores"][$j][0] = $RetornoConsultaRel[$j]["codigo"];
						$retorno["valores"][$j][1] = $RetornoConsultaRel[$j]["nome"];
						$retorno["valores"][$j][2] = $RetornoConsultaRel[$j]["qtd"];
						$retorno["valores"][$j][3] = Formata::banco2valor($RetornoConsultaRel[$j]["valor"]);
						$retorno["valores"][$j][4] = Formata::banco2date($RetornoConsultaRel[$j]["data_fechada"]);
						
						$totalValor += $RetornoConsultaRel[$j]["valor"];
						$totalQtd += $RetornoConsultaRel[$j]["qtd"];
					}
					
					$retorno["valores"][$j][0] = "<b>Total:</b> ";
					$retorno["valores"][$j][1] = "";
					$retorno["valores"][$j][2] = "<b>".$totalQtd."<b>";
					$retorno["valores"][$j][3] = "<b>".Formata::banco2valor( $totalValor )."<b>";
					$retorno["valores"][$j][4] = "";
				}else{
					for($j=0; $j<count($RetornoConsultaRel); $j++){
						$retorno["valores"][$j][0] = $RetornoConsultaRel[$j]["nome"];
						$retorno["valores"][$j][1] = Formata::banco2valor($RetornoConsultaRel[$j]["valor"]);
						if($parametros["filtro1"] == 2){
							$retorno["valores"][$j][2] = Formata::banco2valor($RetornoConsultaRel[$j]["comissao"]);
						}
						
						$total += $RetornoConsultaRel[$j]["valor"];
					}
					
					$retorno["valores"][$j][0] = "<b>Total:</b> ";
					$retorno["valores"][$j][1] = "<b>".Formata::banco2valor( $total )."<b>";				
				}
			}
        }
		
		return $retorno;
        
    }//end function

     /**
     *
     * Monta query de busca fluxo.
     *
     *@param parametros GET
     *@return query
     */
    private function montaRelFluxo($parametros){

		$retorno["titulo"] = "Fluxo ";

    	$retorno["campos"] = array("Mes", "Entrada", "Saida", "Total");
	for($i=0; $i<=12; $i++){
	        
			$dtInicio = date("Y-m-d", mktime(0,0,0, date("m")+$i, 1, date("Y")));
			$dtFim = date("Y-m-d", mktime(0,0,0, date("m")+$i+1, 1-1, date("Y")));
			
			$query = "SELECT fluxo.* FROM fluxo WHERE status = '0' AND data >= '".$dtInicio." 00:00:01' AND data <= '".$dtFim." 23:59:59' ORDER By fluxo.data ASC ";
	        $RetornoConsultaRel = $this->ConexaoSQL->Select($query);
	        
	        if(count($RetornoConsultaRel) > 0){
	           $totalEntrada = 0;
	           $totalSaida = 0;
	           
	           for($j=0; $j<count($RetornoConsultaRel); $j++){
	                if($RetornoConsultaRel[$j]["tipo"] == 1){
	                    $totalEntrada += $RetornoConsultaRel[$j]["valor"];
	                }else{
	                    $totalSaida -= $RetornoConsultaRel[$j]["valor"];
	                }
	            }
	            $totalEntradaEnd += $totalEntrada;
	            $totalSaidaEnd   += $totalSaida;

	            $retorno["valores"][$i]["Mes"] = date("m/Y", mktime(0,0,0, date("m")+$i, 1, date("Y")));
	            $retorno["valores"][$i]["Entrada"] = Formata::banco2valor($totalEntrada);
	            $retorno["valores"][$i]["Saida"] = Formata::banco2valor($totalSaida);
	            $retorno["valores"][$i]["Total"] = Formata::banco2valor( ($totalSaida+$totalEntrada) );
	        }else{
	            $retorno["valores"][$i]["Mes"] = date("m/Y", mktime(0,0,0, date("m")+$i, 1, date("Y")));
	            $retorno["valores"][$i]["Entrada"] = Formata::banco2valor(0);
	            $retorno["valores"][$i]["Saida"] = Formata::banco2valor(0);
	            $retorno["valores"][$i]["Total"] = Formata::banco2valor(0);
	        }
	}

	  $retorno["valores"][$i]["Mes"] = "Total";
	  $retorno["valores"][$i]["Entrada"] = Formata::banco2valor($totalEntradaEnd);
	  $retorno["valores"][$i]["Saida"] = Formata::banco2valor($totalSaidaEnd);
	  $retorno["valores"][$i]["Total"] = Formata::banco2valor( ($totalSaidaEnd + $totalEntradaEnd) );

        return $retorno;

    }
    
    /**
     *
     * Monta query de busca de representantes.
     *
     *@param parametros GET
     *@return query
     */
    private function montaRelRepresentantes($parametros){

        if(!empty($parametros["filtro3"])){
            $queryCliente = "A.id_representantes = '".$parametros["filtro3"]."' AND ";
        }

        $query = "SELECT A.codigo, A.data_fechada, B.nome, SUM( pedidos_itens.total ) as total,  
                                                                        SUM(CASE WHEN A.comissao = 0 THEN
                                                                                ( (pedidos_itens.total * 7) / 100 )
                                                                        ELSE
                                                                                ((pedidos_itens.total * A.comissao) / 100)
                                                                        END)
                                                                  as comissao, 
                                                                  CASE WHEN A.comissao = 0 THEN
                                                                  		'7'
                                                                  	ELSE
                                                                  		A.comissao
                                                                  	END as porcentagem,
                                                                  
                                                                  B.nome FROM pedidos as A
                                INNER JOIN clientes AS B ON B.id = A.id_clientes
                                INNER JOIN pedidos_itens ON pedidos_itens.id_pedidos = A.id
                                WHERE ".$queryCliente." A.data_fechada >= '".Formata::date2banco($parametros["filtro1"])." 00:00:01' AND A.data_fechada <= '".Formata::date2banco($parametros["filtro2"])." 23:59:59'
                                AND A.id_status_pedidos IN (4, 5)
                                                GROUP By A.id ORDER By A.data_fechada ASC";
				
		$retorno["titulo"] = "Representantes ";

        //print $query;
        $RetornoConsultaRel = $this->ConexaoSQL->Select($query);

    	$retorno["campos"] = array("Codigo", "Cliente", "Data", "Total", "Comissao", "%");
    	
        if(count($RetornoConsultaRel) > 0){
            for($j=0; $j<count($RetornoConsultaRel); $j++){
                $retorno["valores"][$j]["Codigo"] = $RetornoConsultaRel[$j]["codigo"];
                $retorno["valores"][$j]["Cliente"] = $RetornoConsultaRel[$j]["nome"];
                $retorno["valores"][$j]["Data"] = Formata::banco2date( $RetornoConsultaRel[$j]["data_fechada"] );
                $retorno["valores"][$j]["Total"] = Formata::banco2valor( $RetornoConsultaRel[$j]["total"] );
                $retorno["valores"][$j]["Comissao"] =  Formata::banco2valor( $RetornoConsultaRel[$j]["comissao"] );
                $retorno["valores"][$j]["%"] = $RetornoConsultaRel[$j]["porcentagem"];
                $tot += $RetornoConsultaRel[$j]["comissao"];
            }
            
            
             	$retorno["valores"][$j]["Codigo"] = "Total";
                $retorno["valores"][$j]["Cliente"] = "";
                $retorno["valores"][$j]["Data"] = "";
                $retorno["valores"][$j]["Total"] = "";
                $retorno["valores"][$j]["Comissao"] =  Formata::banco2valor( $tot );
        }
		
        return $retorno;
        
    }
    
    /**
     *
	 * Gera relatorios.
	 *
	 *@param parametros GET
	 */
    public function geraRelatorio($parametros){
        
        if($parametros["cadastro"] == "clientes"){
        	$dados = $this->montaRelClientes($parametros);
        }else if($parametros["cadastro"] == "producao"){
        	$dados = $this->montaRelProducao($parametros);
        }else if($parametros["cadastro"] == "curvaabc"){
        	$dados = $this->montaRelCurvaAbc($parametros);
        }else if($parametros["cadastro"] == "faturamento"){
        	$dados = $this->montaRelFaturamento($parametros);
        }else if($parametros["cadastro"] == "vendas"){
        	$dados = $this->montaRelVendas($parametros);
        }else if($parametros["cadastro"] == "fluxo"){
        	$dados = $this->montaRelFluxo($parametros);
        }else if($parametros["cadastro"] == "representantes"){
        	$dados = $this->montaRelRepresentantes($parametros);
        }
        
        return $dados;
        
    }
}
?>
