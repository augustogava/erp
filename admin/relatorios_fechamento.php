<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

$tipoDespesas = $Main->Fluxo->pegaTiposDespesas($_GET["filtro1"], $_GET["filtro2"]);

?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
<title>MultPoint</title>
<style>
* {margin:0; padding:0; border: 0;}
a img {border: 0;}
ul, ol {list-style:none;}
.img_left img{float:left;}
.left {float:left;}
.right {float:right;}
.over1 {overflow:hidden; height:1px;}
.block {display:block;}
.del{display:none;}
.null{visibility:hidden;}

body {
	margin: 0;
	padding: 0px 0 0 0;
	font-family: "Lucida Grande", Verdana, sans-serif;
	font-size: small;
	text-align: center;
	color: #383d44;
}
#logo .imga {
	margin: 0px 0 0 0;	
	display: block;
	width: 0;
}
#logo span {
	display: block;
	width: 191px;
	height: 60px;
	padding: 0;
	border-style: none;
}

#caixaTopo {
	width:240px;
	height: 70px;
	background: #FFF;
	margin: 5px 0 ;
	padding: 5px 5px 5px 5px;
	border:solid 1px #dcdcdc;
	font-size: 10px;
}

.logo {
  height: 60px;
  background: url(layout/logo/logo.png);
  background-size: 220px;
  background-position: 22px;
  background-repeat: no-repeat;
  width: 80px;
  margin-top: 5px;
}


.titulo{
	background:#1E96CD;
	color: white;
	font-weight: bold;
	height:26px;
}
.table-relatorio{ border-spacing: 0;   box-sizing: border-box;   width: 99%; margin: 5px auto 0 auto; }
.table-relatorio td { border: 1px solid rgba(3, 163, 236, 0.12); font-size:12px;   padding: 3px; } 
.table-relatorio .linha{ background: rgba(30, 150, 205, 0.1) !important; height: 20px;  }
.table-relatorio .linhaMu{ background: rgba(30, 150, 205, 0.15) !important; height: 20px; }
.table-relatorio .linha:hover, .table-relatorio .linhaMu:hover{ background: rgba(30, 150, 205, 0.4) !important; }

</style>
</head>
<body>
<div style="padding: 0px 0 0 0;
	margin: 0 0 0px 0;
	font-size: 95%;
	border-bottom: 1px solid #dcdcdc;
	position:relative;
	background: #006B9C;">
	<div style="margin: 0 auto;
							padding: 0px 0 0 20px;
							text-align: left;">
		<table border="0" width="100%">
			 <tr>
			 	<td width="10%" height="80">
			 			<div class="logo"></div>
			 	</td>
			 	<td width="90%">
			 		<p align="center" style="margin-top:10px;margin-bottom:10px;font-family: Lucida Grande,Verdana,sans-serif; font-size: 19px; color: white;">Relatório Fechamento Mês <? $dt=explode("/", $_GET["filtro1"]); print date("m", mktime($dt[0], $dt[0], $dt[0]))?></p>
			 	</td>
			</tr>
	     </table>
	     
	     
	</div>
</div>
<table border="1" class="table-relatorio">
    <tr class="titulo">
		<td align="left" colspan="4">Entrada</td>
	</tr>
    <tr class="titulo">
            <td align="left" width="40%">Nome</td>
            <td align="left" width="30%">Pedido</td>
            <td align="left" width="10%">Qtd</td>
            <td align="left" width="30%">Valor Total</td>
        </tr>
    <?
    $pedidos = $Main->Pedidos->pegaPedidosRelatorioFechamento($_GET["filtro1"], $_GET["filtro2"]);
    //print count($pedidos);
    for($j=0; $j<count($pedidos); $j++){
        $total += $pedidos[$j]["valor"];
        $totalQtd += $pedidos[$j]["qtd"];
        
        if(($i%2) == 0){
        	$linha = "linha";
        }else{
        	$linha = "linhaMu";
        }
    ?>
         <tr class="<?=$linha?>">
            <td align="left" width="40%"><?=$pedidos[$j]["nome"]?></td>
            <td align="left" width="30%"><?=$pedidos[$j]["codigo"]?></td>
            <td align="left" width="10%"><?=$pedidos[$j]["qtd"]?></td>
            <td align="left" width="30%"><?=$Main->Formata->banco2valor($pedidos[$j]["valor"]);?></td>
        </tr>
    <?
    }
    ?>
        <tr class="titulo">
            <td align="left" width="40%">Total:</td>
            <td align="left" width="30%"><? print count($pedidos); ?> Pedidos</td>
            <td align="left" width="10%"><?=$totalQtd?></td>
            <td align="left" width="30%"><?=$Main->Formata->banco2valor($total);?></td>
        </tr>
</table>

<br>
<br>

<table border="1" class="table-relatorio">
	<tr class="titulo">
		<td align="left" colspan="3">Entrada</td>
	</tr>
        <?
        $total = 0;
        if(isset($tipoDespesas))
            foreach($tipoDespesas as $id=>$nome){
                $despesas = $Main->Fluxo->pegaDespesas($_GET["filtro1"], $_GET["filtro2"], $id);
        ?>

                <tr class="titulo">
                    <td align="left"><?=(($nome)?$nome:"Sem descrição")?></td>
                </tr>
                <tr >
                    <td align="left">

                        <table  class="table-relatorio">

                           <?

                           for($j=0; $j<count($despesas); $j++){
                                $total +=$despesas[$j]->getValor();
                                if(($i%2) == 0){
                                	$linha = "linha";
                                }else{
                                	$linha = "linhaMu";
                                }
                                
                           ?>
                            <tr class="<?=$linha?>">
                                <td align="left" width="30%"><?=$Main->Formata->banco2date($despesas[$j]->getData())?></td>
                                <td align="left" width="40%"><?=$despesas[$j]->getOcorrencia()?></td>
                                <td align="left" width="30%"><?=$Main->Formata->banco2valor($despesas[$j]->getValor());?></td>
                            </tr>
                             <?
                            }
                            ?>

                        </table>

                    </td>
                </tr>
        <?
            }
        ?>
        <tr class="titulo">
            <td align="left">Total: <?=$Main->Formata->banco2valor($total);?></td>
        </tr>
</table>

<hr />

</body>
</html>
