<?php
# - - - - - - - - - - - - - - - -  ERP - - - - - - - - - - - - - - - - - -
# ERP
#
#  Copyright (c) 2008
#  Author: Augusto Gava (augusto_gava@msn.com)
#  Criado: 14/01/08
#  
#  Classe responsável imagens
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

/**
 * Classe responsável tratamento imagens
 *
 * @author Augusto Gava
 * @version 1.0
 */
class Imagem {
    public $ConexaoSQL;
    public $Formata;
	
    /**
	 * Método construtor.
	 *
	 * @param ConexaoSQL conexão com o banco
	 */
    public function Imagem($ConexaoSQL, $Formata){
        $this->ConexaoSQL = $ConexaoSQL;
        $this->Formata = $Formata;
    }//end function
    
    
    /**
     * Redimensior a $img.
     */
    public function redimensionarImagem($imagem, $nomeSaida, $width, $height){
    	//DEFINE OS PARÂMETROS DA MINIATURA
		$largura = $width;
		$altura = $height;
		
		//NOME DO ARQUIVO DA MINIATURA
		$imagem_gerada = explode(".", $imagem);
		$imagem_gerada = $imagem_gerada[0]."_mini.jpg";
		
		//CRIA UMA NOVA IMAGEM
		$imagem_orig = ImageCreateFromJPEG($imagem);

		//LARGURA
		$pontoX = ImagesX($imagem_orig);
		//ALTURA
		$pontoY = ImagesY($imagem_orig);
		if($width > $pontoX && $height > $pontoY){
			$largura = $pontoX;
			$altura = $pontoY;
		}
		//CRIA O THUMBNAIL
		$imagem_fin = ImageCreateTrueColor($largura, $altura);
		//COPIA A IMAGEM ORIGINAL PARA DENTRO
		ImageCopyResampled($imagem_fin, $imagem_orig, 0, 0, 0, 0, $largura+1, $altura+1, $pontoX, $pontoY);
		
		//SALVA A IMAGEM
		ImageJPEG($imagem_fin, $nomeSaida);
		
		//LIBERA A MEMÓRIA
		ImageDestroy($imagem_orig);
		ImageDestroy($imagem_fin);

    }
    
    /**
     * Salva o nome da imagem na tabela.
     */
    public function salvaImg($campo, $tabela, $id, $nomeImg){
    	
    	$this->ConexaoSQL->updateQuery("UPDATE ".$tabela." SET ".$campo." = '".$nomeImg."' WHERE id = '".$id."'");
    	
    }
    
}
?>