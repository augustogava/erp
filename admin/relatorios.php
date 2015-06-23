<?php
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main ();
$Main->Seguranca->verificaLogado ();

$dados = $Main->Relatorios->geraRelatorio ( $_GET );
// print_r($dados);
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<head>
<title>MultPoint</title>
<style>
* {
	margin: 0;
	padding: 0;
	border: 0;
}

a img {
	border: 0;
}

ul, ol {
	list-style: none;
}

.img_left img {
	float: left;
}

.left {
	float: left;
}

.right {
	float: right;
}

.over1 {
	overflow: hidden;
	height: 1px;
}

.block {
	display: block;
}

.del {
	display: none;
}

.null {
	visibility: hidden;
}

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
	width: 240px;
	height: 70px;
	background: #FFF;
	margin: 5px 0;
	padding: 5px 5px 5px 5px;
	border: solid 1px #dcdcdc;
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
.table-relatorio{ border-spacing: 0;   box-sizing: border-box;  border-collapse: collapse; width: 99%; margin: 5px auto 0 auto; }
.table-relatorio .linha{ background: rgba(30, 150, 205, 0.1) !important; height: 20px; border-bottom: 1px solid #ddd; }
.table-relatorio .linhaMu{ background: rgba(30, 150, 205, 0.15) !important; height: 20px; border-bottom: 1px solid #ddd; }
.table-relatorio .linha:hover, .table-relatorio .linhaMu:hover{ background: rgba(30, 150, 205, 0.4) !important; }
</style>
</head>
<body>
	<div
		style="padding: 0px 0 0 0; margin: 0 0 0px 0; font-size: 95%; border-bottom: 1px solid #dcdcdc; position: relative; background: #006B9C;">
		<div style="margin: 0 auto; padding: 0px 0 0 20px; text-align: left;">
			<table border="0" width="100%">
				<tr>
					<td width="10%" height="80">
						<div class="logo"></div>
					</td>
					<td width="90%">
						<p align="center"
							style="margin-top: 10px; margin-bottom: 10px; font-family: Lucida Grande, Verdana, sans-serif; font-size: 19px; color: white;"><?=$dados["titulo"]?></p>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<table style="" class="table-relatorio">
		<tr class="titulo">
			<?
			for($i = 0; $i < count ( $dados ["campos"] ); $i ++) {
				print "<td>" . ucfirst ( $dados ["campos"] [$i] ) . "</td>";
			}
			?>
			</tr>
			
			<?
			if(  count( $dados ["valores"] ) > 0 ){
				for($i = 0; $i < count ( $dados ["valores"] ); $i ++) {
					if(($i%2) == 0){
						$linha = "linha";
					}else{
						$linha = "linhaMu";
					}
					
					print "<tr class=\"".$linha."\">";
					if (isset ( $dados ["valores"] [$i] )) {
						$index = 0;
						foreach ( $dados ["valores"] [$i] as $campo => $valor ) {
							$align = ( $dados ["align"][$index++]);
							
							print "<td style=\"text-align:".$align.";font-size:11px;\">&nbsp;" . $valor . "</td>";
						}
					}
					print "</tr>";
				}
			}else{
				print "<tr class=\"linha\"> <td colspan=\"".count ( $dados ["campos"] )."\">Sem Registros</td></tr>";
			}
			?>
		</table>

	<hr />

</body>
</html>
