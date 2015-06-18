<?php
# - - - - - - - - - - - - - - - -  ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/01/08
#  
#  Classe responsбvel que busca parametros padroes
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
include_once("properties/PropriedadesPadrao.php");

/**
 * Classe responsбvel pelas exportacoes especiais.
 *
 * @author Augusto Gava
 * @version 1.0
 */
class Exportacao {
	
    /**
	 * Mйtodo construtor.
	 */
    public function Exportacao(){
        
    }//end function
    
	//--funзгo que cria o arquivo e insere o conteudo
	function criaArquivo($diretorio, $conteudo)
	{
		$nomeArquivo = "exportrel.flex";
		$localizacao = $diretorio.$nomeArquivo;
		unlink($localizacao);
		touch($localizacao);
		$handle = fopen($localizacao, 'a');
		fwrite($handle, $conteudo);
		return $localizacao;
	}
    
   
	//--funзгo que cria o arquivo e insere o conteudo
	function gerarExceldeArquivoTemporario($nomeArquivo, $nomeArquivoSaida)
	{

		$fp = fopen($nomeArquivo,'r');
		$conteudo = fread($fp, filesize($nomeArquivo));

		$this->GeraArquivoExcel($conteudo,$nomeArquivoSaida);
	}
	
	//funзгo que gera arquivos do excel(simplesmente recebe o html formatado e imprime uma saнda .xls)
	function GeraArquivoExcel($hml,$nomedoarquivo){
			
		$nomedoarquivo = eregi_replace("['.']","_", $nomedoarquivo); 

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=easy".$nomedoarquivo.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		header("Content-Description: Download File");
		header("Content-Type: application/force-download");
		header("Pragma: public");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: application/octet-stream");
		header("Content-Transfer-Encoding: binary");
	
		echo $hml;
	
	}
	
	//--funзгo que cria o arquivo e insere o conteudo
	function gerarCsvdeArquivoTemporario($nomeArquivo, $nomeArquivoSaida)
	{

		$fp = fopen($nomeArquivo,'r');
		$conteudo = fread($fp, filesize($nomeArquivo));

		$this->GeraArquivoCsv($conteudo,$nomeArquivoSaida);
	}
	
	//funзгo que gera arquivos do excel(simplesmente recebe o html formatado e imprime uma saнda .xls)
	function GeraArquivoCsv($hml,$nomedoarquivo){
			
		$nomedoarquivo = eregi_replace("['.']","_", $nomedoarquivo); 

		header('Content-type: text/plain');
		header("Content-Disposition: attachment; filename=easy".$nomedoarquivo.".txt");
		header("Pragma: no-cache");
		header("Expires: 0");
		header("Content-Description: Download File");
		header("Content-Type: application/force-download");
		header("Pragma: public");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: application/octet-stream");
		header("Content-Transfer-Encoding: binary");
	
		echo $hml;
	
	}
   
   
	
}
?>