<?
$sql=mysql_query("SELECT nivel.menu,nivel.submenu FROM login,nivel WHERE login.funcionario='$fun' AND login.nivel=nivel.id");
$resn=mysql_fetch_array($sql);
$menus=explode(",",$resn["menu"]);
$sub=explode(",",$resn["submenu"]);
?>
<h1>O que deseja fazer em sua conta?</h1>
			<table width=95% align=center border=0 cellpadding=4 cellspacing=0>
				<TR>
				<Td width=1%><a href='javascript:start_service()'><img src='imagens/bulletgreen.gif' border=0></a></td>
				
				<td width=100% nowrap><nobr><a href='index.php?url=clientes.php&acao=alt'>Alterar o meu cadastro</a></td>
				<TR>
			</table><br>
			<h1>Painel De Controle</h1><br>
			 <? 
				 $sql=mysql_query("SELECT * FROM menu ORDER By ordem ASC");
				 while($res=mysql_fetch_array($sql)){
				 	if(in_array($res["id"],$menus)){
			 ?>
                <a name='<?= $res["nome"]; ?>'></a><b><?= $res["nome"]; ?><BR><img src='imagens/pixel.gif' height=4 width=1 border=0><div height=1 width=100% style='border:solid 0px red; background-repeat:no-repeat; background-image:url(imagens/hr-rl.gif)'><img src='imagens/pixel.gif' height=1></div></b><br>
				<table width="100%" height="90" border="0" cellpadding="0" cellspacing="0">
			<? 
				 $sqls=mysql_query("SELECT * FROM submenu WHERE pai='$res[id]' ORDER By ordem ASC");
				 $i=0;
				 print "<Td width='100%' ><table border=0 cellpadding=4 cellspacing=0><TR>";
					 while($ress=mysql_fetch_array($sqls)){
					 	if(in_array($ress["id"],$sub)){
						if($i==0) print "<TR>"; 
			 ?>
					  
					  
						<Td>
							<table border=0 width="100" height="90" onClick="select_action('<?= $ress["id"]; ?>', '<?= $ress["url"]; ?>')" class='tableitem_unselected' id='tableaction<?= $ress["id"]; ?>' onMouseOver="action_onover('<?= $ress["id"]; ?>')" onMouseOut="action_onout('<?= $ress["id"]; ?>')" cellpadding=2 cellspacing=0>
								<Td height=1% align=center><img src='imagens/website_install.gif' border=0></td>
								<TR height=99% valign=center><Td align=center><?= $ress["nome"]; ?></td></TR>
						  </table>
						</td> 
						
						
					  <? 
					  	$i++; if($i==5){ print "</TR>"; $i=0; } }
					 } 
					  ?>
				</table>
				<?
					 } 
				} 
				?>