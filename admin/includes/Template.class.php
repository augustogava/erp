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

/**
 * Classe respons�vel que busca parametros padroes
 *
 * @author Augusto Gava
 * @version 1.0
 */
class Template {
    public $ConexaoSQL;
	
    /**
	 * M�todo construtor.
	 *
	 * @param ConexaoSQL conex�o com o banco
	 */
    public function Template($ConexaoSQL){
        $this->ConexaoSQL = $ConexaoSQL;
    }//end function
    
    /**
     * Pega �ltimo login usu�rio.
     */
    public function montaMenuAdmin(){
    	$saida = "<div class=\"logo\"></div> <div class=\"sidebar-collapse\">
						<ul class=\"nav menu-nav ng-isolate-scope\">";
				
				$Retorno = $this->ConexaoSQL->Select("SELECT menus.* FROM menus INNER JOIN permissoes_niveis ON permissoes_niveis.id_menus = menus.id WHERE permissoes_niveis.id_niveis = '".$_SESSION["niveluser"]."' AND menus.id_menus = '0' ORDER By menus.ordem ASC ");
				for($i=0; $i<count($Retorno); $i++){
					$saida .= "<li id=\"".$Retorno[$i]["id"]."\" class=\"ng-scope\" onmouseover=\"changeMenu('".$Retorno[$i]["id"]."')\">
									<a href=\"#\" alt=\"".$Retorno[$i]["nome"]."\"> 
										<span class=\"glyphicon fa ".$Retorno[$i]["icone"]."\" aria-hidden=\"true\"></span>
									</a>
								</li>";
				}
					
			$saida .= "	</ul>";
		$saida .= "</div>";
			
		return $saida;
    }
    
    public function montaMenuFilhos(){
    	$saida = "<div class=\"menu-submenu-nav menu-submenu-nav-hide\" selected-item=\"selectedItem\" style=\"height: 1164px;\"> ";
			    	$Retorno = $this->ConexaoSQL->Select("SELECT menus.* FROM menus INNER JOIN permissoes_niveis ON permissoes_niveis.id_menus = menus.id WHERE permissoes_niveis.id_niveis = '".$_SESSION["niveluser"]."' AND menus.id_menus = '0' ORDER By menus.ordem ASC ");
			    	for($i=0; $i<count($Retorno); $i++){
						$RetornoSubMenu = $this->ConexaoSQL->Select("SELECT menus.* FROM menus INNER JOIN permissoes_niveis ON permissoes_niveis.id_menus = menus.id AND permissoes_niveis.id_niveis = '".$_SESSION["niveluser"]."'  WHERE menus.id_menus = '".$Retorno[$i]["id"]."' ORDER By menus.ordem ASC ");
						
						if( count($RetornoSubMenu) == 0 )
							continue ;
						
						$saida .= "<div id=\"menuFilho".$Retorno[$i]["id"]."\" class=\"container\">
										<div class=\"row\">
											<div class=\"col-sm-12\" style=\"margin-bottom: 10px; color: #FFF;\">
												<h5 style=\"width: 260px; font-weight: bold;\" translate=\"\" class=\"ng-scope ng-binding\">
													".$Retorno[$i]["nome"]."
												</h5>
											</div>
										</div> ";
																			
						for($e=0; $e<count($RetornoSubMenu); $e++){
	
							$icone = empty($RetornoSubMenu[$e]["icone"]) ? $Retorno[$i]["icone"] : $RetornoSubMenu[$e]["icone"];
	    					$saida .= "<div class=\"row\">
												<div class=\"col-sm-12 ng-scope\" ng-repeat=\"submenuItem in submenuItems\">
													<a href=\"".$RetornoSubMenu[$e]["link"]."\" alt=\"".$RetornoSubSubMenu[$e]["alt"]."\" title=\"".$RetornoSubSubMenu[$e]["alt"]."\" class=\"button-submenu\"> <span></span> 
														<span translate=\"\" class=\"ng-scope ng-binding\">".$RetornoSubMenu[$e]["nome"]."</span> 
														<span class=\"glyphicon fa ".$icone."\"></span>
													</span>
													</a>
												</div>
											</div>
										";
	    						
	    					$RetornoSubSubMenu = $this->ConexaoSQL->Select("SELECT menus.* FROM menus INNER JOIN permissoes_niveis ON permissoes_niveis.id_menus = menus.id AND permissoes_niveis.id_niveis = '".$_SESSION["niveluser"]."' WHERE menus.id_menus = '".$RetornoSubMenu[$e]["id"]."' ORDER By menus.ordem ASC ");
	    					for($j=0; $j<count($RetornoSubSubMenu); $j++){
	    						$icone = empty($RetornoSubSubMenu[$j]["icone"]) ? $Retorno[$i]["icone"] : $RetornoSubSubMenu[$j]["icone"];
	    						$saida .= "<div class=\"row\">
											<div class=\"col-sm-12 ng-scope\" ng-repeat=\"submenuItem in submenuItems\">
												<a href=\"".$RetornoSubSubMenu[$j]["link"]."\" alt=\"".$RetornoSubSubMenu[$j]["alt"]."\" title=\"".$RetornoSubSubMenu[$j]["alt"]."\" class=\"button-submenu smallsubmenu\"> <span></span> 
													<span translate=\"\" class=\"ng-scope ng-binding\">".$RetornoSubSubMenu[$j]["nome"]."</span> 
												</span>
												</a>
											</div>
										</div>
									";
	    					}
	    				}
	    				
	    				$saida .= "</div>";
			    	}
    	$saida .= "</div>";
    	
    	return $saida;
    }
}
?>