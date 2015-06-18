<?php
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main ();
$Main->Seguranca->verificaLogado ();
$Main->AdicionaRelatorios ();

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

	<table border="1" style="background: #EBF0FD; width: 100%;">
		<tr
			style="background: #CFDEFF; color: #215DF6; border-bottom: 1px solid #000; font-weight: bold; height: 26px;">
			<?
			for($i = 0; $i < count ( $dados ["campos"] ); $i ++) {
				print "<td>" . ucfirst ( $dados ["campos"] [$i] ) . "</td>";
			}
			?>
			</tr>
			
			<?
			for($i = 0; $i < count ( $dados ["valores"] ); $i ++) {
				print "<tr style=\"background: #EBF0FD;height:32px;\">";
				if (isset ( $dados ["valores"] [$i] )) {
					foreach ( $dados ["valores"] [$i] as $campo => $valor ) {
						print "<td style=\"text-align:left;font-size:10px;\">&nbsp;" . $valor . "</td>";
					}
				}
				print "</tr>";
			}
			?>
		</table>

	<hr />

</body>
</html>
