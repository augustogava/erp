<?php
require_once("fpdf/fpdf.php");

include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->AdicionaPedidos();

$busca = $Main->Pedidos->pegaClientes();
// Variaveis de Tamanho

$mesq = "5"; // Margem Esquerda (mm)
$mdir = "5"; // Margem Direita (mm)
$msup = "12"; // Margem Superior (mm)
$leti = "72"; // Largura da Etiqueta (mm)
$aeti = "27"; // Altura da Etiqueta (mm)
$ehet = "3,2"; // Espa�o horizontal entre as Etiquetas (mm)
$pdf=new FPDF('P','mm','Letter'); // Cria um arquivo novo tipo carta, na vertical.
$pdf->Open(); // inicia documento
$pdf->AddPage(); // adiciona a primeira pagina
$pdf->SetMargins('5','12,7'); // Define as margens do documento
$pdf->SetAuthor("Jonas Ferreira"); // Define o autor
$pdf->SetFont('helvetica','',7); // Define a fonte
$pdf->SetDisplayMode('fullpage');

$coluna = 0;
$linha = 0;
//MONTA A ARRAY PARA ETIQUETAS

for($j=0; $j<count($busca); $j++){
$nome = $busca[$j]->getNome();
$ende = $busca[$j]->getEndereco();
$bairro = $busca[$j]->getBairro();
$local = $bairro . " - " . $busca[$j]->getCidade() . " - " . $busca[$j]->getEstado();
$cep = "CEP: " . $busca[$j]->getCep();
if($linha == "10") {
$pdf->AddPage();
$linha = 0;
}

if($coluna == "3") { // Se for a terceira coluna
$coluna = 0; // $coluna volta para o valor inicial
$linha = $linha +1; // $linha � igual ela mesma +1
}

if($linha == "10") { // Se for a �ltima linha da p�gina
$pdf->AddPage(); // Adiciona uma nova p�gina
$linha = 0; // $linha volta ao seu valor inicial
}

$posicaoV = $linha*$aeti;
$posicaoH = $coluna*$leti;

if($coluna == "0") { // Se a coluna for 0
$somaH = $mesq; // Soma Horizontal � apenas a margem da esquerda inicial
} else { // Sen�o
$somaH = $mesq+$posicaoH; // Soma Horizontal � a margem inicial mais a posi��oH
}

if($linha =="0") { // Se a linha for 0
$somaV = $msup; // Soma Vertical � apenas a margem superior inicial
} else { // Sen�o
$somaV = $msup+$posicaoV; // Soma Vertical � a margem superior inicial mais a posi��oV
}

$pdf->Text($somaH,$somaV,$nome); // Imprime o nome da pessoa de acordo com as coordenadas
$pdf->Text($somaH,$somaV+4,$ende); // Imprime o endere�o da pessoa de acordo com as coordenadas
$pdf->Text($somaH,$somaV+8,$local); // Imprime a localidade da pessoa de acordo com as coordenadas
$pdf->Text($somaH,$somaV+12,$cep); // Imprime o cep da pessoa de acordo com as coordenadas

$coluna = $coluna+1;
}

$pdf->Output();
?>
<script>window.close()</script>