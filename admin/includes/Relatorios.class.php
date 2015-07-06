<?php
# - - - - - - - - - - - - - - - -  ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/01/08
#  
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * @author Augusto Gava
 * @version 1.0
 */
class Relatorios {
    public $ConexaoSQL;
    public $mes = Array("Janeiro", "Fevereiro", "Marco", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outrubro", "Novembro", "Desembro");
	
    /**
	 * M�todo construtor.
	 *
	 * @param ConexaoSQL conexão com o banco.
	 * @param Formata formata dados.
	 */
    public function Relatorios($ConexaoSQL){
        $this->ConexaoSQL = $ConexaoSQL;
    }
    
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
        
    }

 	/**
     *
	 * Monta query de busca de producao.
	 *
	 *@param parametros GET
	 *@return query
	 */
    private function montaRelProducao($parametros){

    	if(!empty($parametros["filtro1"])){
    		$where = " AND op.id_status_ordem = '".$parametros["filtro1"]."'";
    	}

    	$query = "SELECT SUM(op.qtd) as total, c.nome, pr.codigo, p.id from ordem_producao as op
					INNER JOIN pedidos p ON p.id = op.id_pedido 
					INNER JOIN clientes c ON c.id = p.id_clientes
					INNER JOIN produtos pr ON pr.id = op.id_produtos
    				WHERE 1 ".$where." 
					group by p.id_clientes , op.id_produtos
					ORDER By pr.codigo, c.nome";
				
		$retorno["titulo"] = "Ordem de Produção ";
		
	    $RetornoConsultaRel = $this->ConexaoSQL->Select($query);
    	
	    $retorno["campos"][] = "Produto";
		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				$campos[$RetornoConsultaRel[$j]["nome"]] = $RetornoConsultaRel[$j]["nome"];
				
				$dados[$RetornoConsultaRel[$j]["codigo"]][ $RetornoConsultaRel[$j]["nome"] ] = $RetornoConsultaRel[$j]["total"];
			}

			$retorno["align"][] = "left";
			foreach ( $campos  as $c ){ 
				$retorno["campos"][] = $c;
				$retorno["align"][] = "center";
			}
			
			
			$i = 0;
			foreach ( $dados  as $produto => $clientes ) {
				$retorno["valores"][$i][ "Produto" ] = $produto;
				
				for($j=0; $j<count($retorno["campos"]); $j++){
					if( $retorno["campos"][$j] == "Produto")
						continue;
					
					
					$retorno["valores"][$i][ $retorno["campos"][$j] ] = $clientes[ $retorno["campos"][$j] ];
					
					$total[$produto] += $clientes[ $retorno["campos"][$j] ];
					$totalCliente[$retorno["campos"][$j]] += $clientes[ $retorno["campos"][$j] ];
				}
				
				$i++;
			}

			/** COLUNA TOTAL */
			$retorno["align"][] = "right";
			$retorno["campos"][] = "Total";
			$i=0;
			foreach ( $total as $t ) {
				$retorno["valores"][$i++]["Total"] = "<b>".$t."</b>";
			}
			
			/** Linha TOTAL */
			$i = count($retorno["valores"]);
			for($j=0; $j<count($retorno["campos"]); $j++){
				if( $retorno["campos"][$j] == "Produto"){
					$retorno["valores"][$i]["Produto"] = "<b>Total</b>";
					continue;
				}
			
				$retorno["valores"][$i][ $retorno["campos"][$j]] = "<b>".$totalCliente[ $retorno["campos"][$j] ]."</b>";
				$totalGeral +=  $totalCliente[ $retorno["campos"][$j] ];
				
			}
			
// 			print_r($retorno["align"]);
			$retorno["valores"][$i]["Total"] = "<b>".$totalGeral."</b>";
			
		}
		
		return $retorno;
        
    }
    
    /**
     *
     * Monta query de busca de producao.
     *
     *@param parametros GET
     *@return query
     */
    private function montaRelEstoqueAtual($parametros){
    
    	if(!empty($parametros["filtro1"])){
    		$where = " AND produtos.id_tipo_produdo = '".$parametros["filtro1"]."'";
    	}
    
    	$query = "SELECT produtos.codigo, produtos.nome, produtos.descricao, tipo_produdo.nome as tipo_produto,
					produtos.estoque_atual, case when os.qtd is null then 0 else sum(os.qtd) end as qtd
					FROM produtos
					INNER JOIN tipo_produdo ON tipo_produdo.id = produtos.id_tipo_produdo
					LEFT JOIN ordem_separacao os on os.id_produtos = produtos.id
					WHERE
					case when os.id IS NOT NULL then
						os.id_status_separacao = 1
						else
						1
					end
    				".$where."
					group by produtos.id
					ORDER By produtos.id_tipo_produdo, produtos.codigo
					;";
    
    	$retorno["titulo"] = "Estoque Atual";
    
    	$RetornoConsultaRel = $this->ConexaoSQL->Select($query);
    	 
    	$retorno["campos"] = array("Tipo", "Produto", "Estoque Atual" ,"Em Separaçao", "Total");
    	$retorno["align"] = array("center", "left", "right" ,"right", "right");
    	 
    	if(count($RetornoConsultaRel) > 0){
    		for($j=0; $j<count($RetornoConsultaRel); $j++){
    			$retorno["valores"][$j]["Tipo"] = $RetornoConsultaRel[$j]["tipo_produto"];
    			$retorno["valores"][$j]["Produto"] = $RetornoConsultaRel[$j]["codigo"]." - ".$RetornoConsultaRel[$j]["descricao"];
    			$retorno["valores"][$j]["Estoque"] = $RetornoConsultaRel[$j]["estoque_atual"];
    			$retorno["valores"][$j]["Separacao"] = $RetornoConsultaRel[$j]["qtd"];
    			$retorno["valores"][$j]["Total"] = $RetornoConsultaRel[$j]["estoque_atual"]-$RetornoConsultaRel[$j]["qtd"];
    		}
    	}
    
    	return $retorno;
    
    }
    
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
				
		$retorno["titulo"] = "Curva ABC";

//         print $query;
        $RetornoConsultaRel = $this->ConexaoSQL->Select($query);

    	$retorno["campos"] = array("Produto", "Quantidade", "%");
    	$retorno["width"] = array("75%", "15%", "10%");
    	$retorno["align"] = array("left", "right", "right" );
    	
        if(count($RetornoConsultaRel) > 0){
            $sQtd=0;
            for($j=0; $j<count($RetornoConsultaRel); $j++){
                $retorno["valores"][$j]["Produto"] = $RetornoConsultaRel[$j]["codigo"]." - ".$RetornoConsultaRel[$j]["descricao"];
                $retorno["valores"][$j]["Qtd"] = $RetornoConsultaRel[$j]["qtdTotal"];
                $retorno["valores"][$j]["%"] = round($RetornoConsultaRel[$j]["media"], 2);
                
                $sQtd += $RetornoConsultaRel[$j]["qtdTotal"];
            }
            
            $retorno["valores"][$j][0] = "<b>Total:</b> ";
            $retorno["valores"][$j][1] = "<b>".$sQtd."<b>";
            $retorno["valores"][$j][2] = "<b>100%<b>";
        }

        return $retorno;
        
    }
    
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
        	
        	$queryTotal = "SELECT sum(fluxo.valor) as total FROM fluxo
																				INNER JOIN pedidos ON pedidos.id = fluxo.id_pedidos
																				WHERE fluxo.tipo = '1'
																				AND fluxo.data >= '".Formata::date2banco($parametros["filtro2"])." 00:00:01'
																				AND fluxo.data <= '".Formata::date2banco($parametros["filtro3"])." 23:59:59'";
																				
        	$retorno["titulo"] = "Faturamento por Pedido";
        	
        	$retorno["campos"] = array("Código", "Faturamento", "% Participação");
			$retorno["width"] = array("60%", "20%", "20%");
			
        }else if($parametros["filtro1"] == 2){
			$query = "SELECT SUM(fluxo.valor) as valor, representantes.nome as nome FROM fluxo 
																					INNER JOIN pedidos ON pedidos.id = fluxo.id_pedidos
																					LEFT JOIN representantes ON representantes.id = pedidos.id_representantes
																					WHERE fluxo.tipo = '1' 
																					AND fluxo.data >= '".Formata::date2banco($parametros["filtro2"])." 00:00:01'
																					AND fluxo.data <= '".Formata::date2banco($parametros["filtro3"])." 23:59:59'
																					GROUP By representantes.id ORDER By valor DESC";
			$queryTotal = "SELECT SUM(fluxo.valor) as total, representantes.nome as nome FROM fluxo
																					INNER JOIN pedidos ON pedidos.id = fluxo.id_pedidos
																					LEFT JOIN representantes ON representantes.id = pedidos.id_representantes
																					WHERE fluxo.tipo = '1'
																					AND fluxo.data >= '".Formata::date2banco($parametros["filtro2"])." 00:00:01'
																					AND fluxo.data <= '".Formata::date2banco($parametros["filtro3"])." 23:59:59'";
			
			$retorno["titulo"] = "Faturamento por Representante";
			$retorno["campos"] = array("Nome", "Faturamento", "% Participação");
			$retorno["width"] = array("60%", "20%", "20%");
			
        }else if($parametros["filtro1"] == 3){
			$query = "SELECT SUM(fluxo.valor) as valor, clientes.nome as nome FROM fluxo 
																					INNER JOIN pedidos ON pedidos.id = fluxo.id_pedidos
																					LEFT JOIN clientes ON clientes.id = pedidos.id_clientes
																					WHERE fluxo.tipo = '1' 
																					AND fluxo.data >= '".Formata::date2banco($parametros["filtro2"])." 00:00:01'
																					AND fluxo.data <= '".Formata::date2banco($parametros["filtro3"])." 23:59:59'
																					GROUP By clientes.id ORDER By valor DESC";
			
			$queryTotal = "SELECT SUM(fluxo.valor) as total from fluxo
																					INNER JOIN pedidos ON pedidos.id = fluxo.id_pedidos
																					LEFT JOIN clientes ON clientes.id = pedidos.id_clientes
																					WHERE fluxo.tipo = '1'
																					AND fluxo.data >= '".Formata::date2banco($parametros["filtro2"])." 00:00:01'
																					AND fluxo.data <= '".Formata::date2banco($parametros["filtro3"])." 23:59:59' ";

			$retorno["titulo"] = "Faturamento por Cliente";
			$retorno["campos"] = array("Nome", "Faturamento", "% Participação");
			$retorno["width"] = array("60%", "20%", "20%");
        }

        $retorno["align"] = array("left", "right", "right" );

        $RetornoConsultaRel = $this->ConexaoSQL->Select($query);
        $RetornoConsultaRelTotal = $this->ConexaoSQL->Select($queryTotal);
        
		if(count($RetornoConsultaRel) > 0){
			for($j=0; $j<count($RetornoConsultaRel); $j++){
				if(empty($RetornoConsultaRel[$j]["nome"])){
					$RetornoConsultaRel[$j]["nome"] = "Sem Representante";
				}
				$retorno["valores"][$j][0] = $RetornoConsultaRel[$j]["nome"]." - ". str_replace("<br>", "", $RetornoConsultaRel[$j]["ocorrencia"]);
				$retorno["valores"][$j][1] = "R$ ".Formata::banco2valor($RetornoConsultaRel[$j]["valor"]);
				$retorno["valores"][$j][2] = round( ( ( $RetornoConsultaRel[$j]["valor"]*100) / $RetornoConsultaRelTotal[0]["total"] ), 1)." %";
				
				$total += $RetornoConsultaRel[$j]["valor"];
			}
			
			$retorno["valores"][$j][0] = "<b>Total:</b> ";
			$retorno["valores"][$j][1] = "<b>R$ ".Formata::banco2valor( $total )."<b>";
			$retorno["valores"][$j][2] = "<b>100%<b>";
				
		}
		
		return $retorno;
        
    }
    
     /**
     *
	 * Monta query de busca de faturamento.
	 *
	 *@param parametros GET
	 *@return query
	 */
    private function montaRelVendas($parametros){

        if($parametros["filtro1"] == 1){

            $query = "SELECT SUM(pedidos_itens.qtd) as qtdTotal, SUM(pedidos_itens.qtd * ( pedidos_itens.preco + pedidos_itens.preco_especial ) ) as valor, produtos.codigo as nome FROM pedidos
                    INNER JOIN pedidos_itens ON pedidos_itens.id_pedidos = pedidos.id
                    INNER JOIN produtos ON produtos.id = pedidos_itens.id_produtos
                    WHERE pedidos.data_fechada >= '".Formata::date2banco($parametros["filtro2"])." 00:00:01'
                    AND pedidos.data_fechada <= '".Formata::date2banco($parametros["filtro3"])."  23:59:59'
                    AND id_status_pedidos IN ('4', '5')
                    GROUP By produtos.id ORDER By valor DESC ";

        	$retorno["titulo"] = "Vendas por Produto";
        	
        	$retorno["campos"] = array("Descricao", "Quantidade", "valor");
        	$retorno["align"] = array("left", "right", "right");
        	$retorno["width"] = array("60%", "15%", "25%");
			
        }else if($parametros["filtro1"] == 2){
			$query = "SELECT SUM(pedidos_itens.qtd) as qtdTotal, SUM(pedidos_itens.qtd * ( pedidos_itens.preco + pedidos_itens.preco_especial ) ) as valor, representantes.nome as nome,
                        SUM( CASE WHEN pedidos.comissao = 0 THEN
                                                                                ( ((pedidos_itens.total+pedidos_itens.total_especial) * 7) / 100 )
                                                                        ELSE
                                                                                (((pedidos_itens.total+pedidos_itens.total_especial) * pedidos.comissao) / 100)
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
			$retorno["campos"] = array("Nome", "Quantidade", "Valor", "Comissão");
			
			$retorno["align"] = array("left", "right", "right", "right");
			$retorno["width"] = array("60%", "10%", "15%", "15%");
			
        }else if($parametros["filtro1"] == 3){
			$query = "SELECT SUM(pedidos_itens.qtd) as qtdTotal, SUM(pedidos_itens.qtd * ( pedidos_itens.preco + pedidos_itens.preco_especial ) ) as valor, clientes.nome as nome,
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
			$retorno["campos"] = array("Nome", "Quantidade", "Valor");
			
			$retorno["align"] = array("left", "right", "right");
			$retorno["width"] = array("60%", "15%", "20%");
        }else if($parametros["filtro1"] == 4){
			if( !empty($parametros["filtro4"]))
				$cli = "AND pedidos.id_clientes = '".$parametros["filtro4"]."'";
        	
			$query = "SELECT SUM(pedidos_itens.qtd * ( pedidos_itens.preco + pedidos_itens.preco_especial ) ) as valor,SUM(pedidos_itens.qtd) as qtd, clientes.nome as nome,pedidos.codigo, pedidos.data_fechada
                            								
                                    FROM pedidos
                                    LEFT JOIN clientes ON clientes.id = pedidos.id_clientes
                                    INNER JOIN pedidos_itens ON pedidos_itens.id_pedidos = pedidos.id
                                    WHERE pedidos.data_fechada >= '".Formata::date2banco($parametros["filtro2"])." 00:00:01'
                                    AND pedidos.data_fechada <= '".Formata::date2banco($parametros["filtro3"])." 23:59:59'
                                    AND id_status_pedidos IN ('4', '5') AND pedidos_itens.id_produtos NOT IN('45','46') ".$cli."
                                    GROUP By pedidos.id ORDER By data_fechada DESC";

			$retorno["titulo"] = "Vendas por Clientes";
			$retorno["campos"] = array("Codigo","Cliente","Qtd","Valor Total", "Data");
			
			$retorno["align"] = array("left", "left", "right", "right", "right");
			$retorno["width"] = array("10%", "40%", "10%", "16%", "20%");
        }
        
        if($parametros["filtro1"] == 5){
        	$retorno["titulo"] = "Vendas Mensalmente";
			$retorno["campos"] = array("Mes", "Qtd", "Valor");
			
			$retorno["align"] = array("left", "right", "right");
			$retorno["width"] = array("70%", "10%", "30%");
			
			$j = 0;
			for($i=1; $i<=date("m"); $i++){
				$dtInicio 	= date("Y-m-d", mktime(0, 0, 0 , $i, 1, date("Y") ));
				$dtFim 		= date("Y-m-d", mktime(0, 0, 0 , $i+1, 1-1, date("Y") ));
				
				$query = "SELECT SUM(pedidos_itens.qtd) as qtdTotal, SUM(pedidos_itens.qtd * ( pedidos_itens.preco + pedidos_itens.preco_especial ) ) as valor,SUM(pedidos_itens.qtd) as qtd 
                            								
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
				$retorno["valores"][$j++][2] = "R$ ".Formata::banco2valor($RetornoConsultaRel[0]["valor"]);
				
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
						$retorno["valores"][$j][3] = "R$ ".Formata::banco2valor($RetornoConsultaRel[$j]["valor"]);
						$retorno["valores"][$j][4] = Formata::banco2date($RetornoConsultaRel[$j]["data_fechada"]);
						
						$totalValor += $RetornoConsultaRel[$j]["valor"];
						$totalQtd += $RetornoConsultaRel[$j]["qtd"];
					}
					
					$retorno["valores"][$j][0] = "<b>Total:</b> ";
					$retorno["valores"][$j][1] = "";
					$retorno["valores"][$j][2] = "<b>".$totalQtd."<b>";
					$retorno["valores"][$j][3] = "<b>R$".Formata::banco2valor( $totalValor )."<b>";
					$retorno["valores"][$j][4] = "";
				}else{
					for($j=0; $j<count($RetornoConsultaRel); $j++){
						$retorno["valores"][$j][0] = $RetornoConsultaRel[$j]["nome"];
						$retorno["valores"][$j][1] = $RetornoConsultaRel[$j]["qtdTotal"];
						$retorno["valores"][$j][2] = "R$ ".Formata::banco2valor($RetornoConsultaRel[$j]["valor"]);
						
						if($parametros["filtro1"] == 2){
							$retorno["valores"][$j][3] = "R$ ".Formata::banco2valor($RetornoConsultaRel[$j]["comissao"]);
						}
						
						$total += $RetornoConsultaRel[$j]["valor"];
						$totalQtd += $RetornoConsultaRel[$j]["qtdTotal"];
						$totalComissao += $RetornoConsultaRel[$j]["comissao"];
					}
					
					$retorno["valores"][$j][0] = "<b>Total:</b> ";
					$retorno["valores"][$j][1] = "<b>".$totalQtd."<b>";
					$retorno["valores"][$j][2] = "<b>R$ ".Formata::banco2valor( $total )."<b>";		

					if($parametros["filtro1"] == 2){
						$retorno["valores"][$j][3] = "<b>R$ ".Formata::banco2valor( $totalComissao )."<b>";
					}
				}
			}
        }
		
		return $retorno;
        
    }

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
    	$retorno["align"] = array("left", "right", "right" ,"right");
    	$retorno["width"] = array("40%", "20%", "20%", "20%");
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

		$retorno["valores"][$i]["Mes"] = "<b>Total</b>";
		$retorno["valores"][$i]["Entrada"] = "<b>R$".Formata::banco2valor($totalEntradaEnd)."</b>";
		$retorno["valores"][$i]["Saida"] = "<b>R$".Formata::banco2valor($totalSaidaEnd)."</b>";
		$retorno["valores"][$i]["Total"] = "<b>R$ ".Formata::banco2valor( ($totalSaidaEnd + $totalEntradaEnd) )."</b>";

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

        $query = "SELECT A.codigo, A.data_fechada, B.nome, SUM( pedidos_itens.total+pedidos_itens.total_especial ) as total,  
                                                                        SUM(CASE WHEN A.comissao = 0 THEN
                                                                                ( ( ( pedidos_itens.total+pedidos_itens.total_especial) * 7) / 100 )
                                                                        ELSE
                                                                                ( ( ( pedidos_itens.total+pedidos_itens.total_especial) * A.comissao) / 100)
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
    	$retorno["align"] = array("left", "left", "right", "right", "right", "right");
    	
        if(count($RetornoConsultaRel) > 0){
            for($j=0; $j<count($RetornoConsultaRel); $j++){
                $retorno["valores"][$j]["Codigo"] = $RetornoConsultaRel[$j]["codigo"];
                $retorno["valores"][$j]["Cliente"] = $RetornoConsultaRel[$j]["nome"];
                $retorno["valores"][$j]["Data"] = Formata::banco2date( $RetornoConsultaRel[$j]["data_fechada"] );
                $retorno["valores"][$j]["Total"] = "R$ ".Formata::banco2valor( $RetornoConsultaRel[$j]["total"] );
                $retorno["valores"][$j]["Comissao"] =  "R$ ".Formata::banco2valor( $RetornoConsultaRel[$j]["comissao"] );
                $retorno["valores"][$j]["%"] = $RetornoConsultaRel[$j]["porcentagem"];
                $tot += $RetornoConsultaRel[$j]["comissao"];
            }
            
            
             	$retorno["valores"][$j]["Codigo"] = "<b>Total</b>";
                $retorno["valores"][$j]["Cliente"] = "";
                $retorno["valores"][$j]["Data"] = "";
                $retorno["valores"][$j]["Total"] = "";
                $retorno["valores"][$j]["Comissao"] =  "<b>R$ ".Formata::banco2valor( $tot )."</b>";
                $retorno["valores"][$j]["%"] = "";
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
        }else if($parametros["cadastro"] == "estoqueAtual"){
        	$dados = $this->montaRelEstoqueAtual($parametros);
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
