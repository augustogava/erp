<?php 
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();
$Main->AdicionaFluxo();
$Main->AdicionaPedidos();

$tipoDespesas = $Main->Fluxo->pegaTiposDespesas($_GET["filtro1"], $_GET["filtro2"]);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
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

</style>
</head>
<body>
<div style="padding: 0px 0 0 0;
	margin: 0 0 0px 0;
	font-size: 95%;
	border-bottom: 1px solid #dcdcdc;
	position:relative;
	background: #B5CAFF url(http://www.multpoint.ind.br/admin/layout/back_top.gif) repeat-y top left;">
	<div style="margin: 0 auto;
							padding: 0px 0 0 20px;
							text-align: left;">
		<table border="0" width="100%">
			 <tr>
			 	<td width="10%" height="80">
			 		<a href="http://www.multpoint.ind.br/"><img src="http://www.multpoint.ind.br/layout/logo/logo_MultPointpeq.gif" alt="MultPoint"></a>
			 	</td>
			 	<td width="90%">
			 		<p align="center" style="margin-top:10px;margin-bottom:10px;font-family: Lucida Grande,Verdana,sans-serif; font-size: 19px; color: rgb(56, 61, 68);">Relat�rio Fechamento M�s <? $dt=explode("/", $_GET["filtro1"]); print date("m", mktime($dt[0], $dt[0], $dt[0]))?></p>
			 	</td>
			</tr>
	     </table>
	</div>
</div>

<p align="left" style="margin-top:10px;margin-bottom:10px;font-family: Lucida Grande,Verdana,sans-serif; font-size: 19px; color: rgb(56, 61, 68);">Entrada</p>
<table border="1" style="background: #EBF0FD;width:100%;">
    <tr style="background:#CFDEFF;color:#215DF6;border-bottom: 1px solid #000;font-weight: bold;height:26px;">
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
    ?>
         <tr style="background:#EBF0FD;color:#383D44;border-bottom: 1px solid #000;height:20px;">
            <td align="left" width="40%"><?=$pedidos[$j]["nome"]?></td>
            <td align="left" width="30%"><?=$pedidos[$j]["codigo"]?></td>
            <td align="left" width="10%"><?=$pedidos[$j]["qtd"]?></td>
            <td align="left" width="30%"><?=$Main->Formata->banco2valor($pedidos[$j]["valor"]);?></td>
        </tr>
    <?
    }
    ?>
        <tr style="background:#CFDEFF;color:#215DF6;border-bottom: 1px solid #000;font-weight: bold;height:26px;">
            <td align="left" width="40%">Total:</td>
            <td align="left" width="30%"><? print count($pedidos); ?> Pedidos</td>
            <td align="left" width="10%"><?=$totalQtd?></td>
            <td align="left" width="30%"><?=$Main->Formata->banco2valor($total);?></td>
        </tr>
</table>

<p align="left" style="margin-top:10px;margin-bottom:10px;font-family: Lucida Grande,Verdana,sans-serif; font-size: 19px; color: rgb(56, 61, 68);">Sa�da</p>
<table border="1" style="background: #EBF0FD;width:100%;">
        <?
        $total = 0;
        if(isset($tipoDespesas))
            foreach($tipoDespesas as $id=>$nome){
                $despesas = $Main->Fluxo->pegaDespesas($_GET["filtro1"], $_GET["filtro2"], $id);
        ?>

                <tr style="background:#CFDEFF;color:#215DF6;border-bottom: 1px solid #000;font-weight: bold;height:26px;">
                    <td align="left"><?=(($nome)?$nome:"Sem descri��o")?></td>
                </tr>
                <tr style="background:#CFDEFF;color:#215DF6;border-bottom: 1px solid #000;font-weight: bold;height:26px;">
                    <td align="left">

                        <table  style="background: #EBF0FD;width:100%;">

                           <?

                           for($j=0; $j<count($despesas); $j++){
                                $total +=$despesas[$j]->getValor();
                           ?>
                            <tr style="background:#EBF0FD;color:#383D44;border-bottom: 1px solid #000;height:20px;">
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
        <tr style="background:#CFDEFF;color:#215DF6;border-bottom: 1px solid #000;font-weight: bold;height:26px;">
            <td align="left">Total: <?=$Main->Formata->banco2valor($total);?></td>
        </tr>
</table>

<hr />

</body>
</html>
