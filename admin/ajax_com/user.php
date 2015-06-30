<?
include "../includes/Main.class.php";
// chama a classe principal
$Main = new Main();
$Main->Seguranca->verificaLogado();

if($_GET["acao"] == "editar"){ 
	$usuario = $Main->User->pegaUsuario($_GET["id"]);
?>
<div style="border: 1px solid rgb(235, 240, 253);" id="SaidaPop">
	<form id="edit" name="edit" action="">
		<table cellspacing="5" cellpadding="0" border="1" align="left" width="100%">
			<tbody>
				<tr style="border-bottom: 1px solid #ddd; height: 30px;">
					<td align="left" width="30%" style="padding-bottom: 5px;">
						<h2>Alterar</h2>
					</td>
					<td align="right" width="70%" style="padding-bottom: 5px;">
						<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="addPop_close();">
						  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Fechar
						</button>
					</td>
				</tr>
				<tr>
					<td align="center" style="color: red;" id="erro" colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td align="right"><b>Nome:</b></td>
					<td align="left">
						<input type="text" class="form-control input-xs" name="nome" id="nome" size="" value="<? if($usuario[0]) print $usuario[0]->getNome()?>" >
					</td>
				</tr>
				<tr>
					<td align="right"><b>E-mail:</b></td>
					<td align="left">
						<input type="text" class="form-control input-xs" name="email" id="email" size=""   value="<? if($usuario[0]) print $usuario[0]->getEmail()?>">
					</td>
				</tr>
				
				<tr>
					<td align="right"><b>Login:</b></td>
					<td align="left">
						<input type="text" class="form-control input-xs" name="login" id="login" size=""   value="<? if($usuario[0]) print $usuario[0]->getUsuario()?>">
					</td>
				</tr>
				
				<tr>
					<td align="center" colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" colspan="3">
						<div class="btn-group" role="group" aria-label="...">
							<input class="btn btn-success btn-sm " type="button" onclick="verifyPnotifyConfirm( 'Deseja Salvar?', 'salvarUsuario(<?=$_GET["id"]?>)' );" value="Salvar" /> 
							<input class="btn btn-danger btn-sm" type="button" onclick="addPop_close();" value="Cancelar"/>
						</div>
						
						<input type="hidden" name="id" id="id" value="<?=$_GET["id"]?>"/>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
	<script>
	document.onkeypress = function (evt){
		if(main.procuraTecla(evt,13)){
			if(confirm('Deseja salvar?')){ salvarUsuario(<?=$_GET["id"]?>); } 
		}
	}
	</script>
</div>
<?php 
}else if($_GET["acao"] == "editarSenha"){ 
	$usuario = $Main->User->pegaUsuario($_GET["id"]);
?>
<div style="border: 1px solid rgb(235, 240, 253);" id="SaidaPop">
	<form id="edit" name="edit" action="">
		<table cellspacing="5" cellpadding="0" border="1" align="left" width="100%">
			<tbody>
				<tr style="border-bottom: 1px solid #ddd; height: 30px;">
					<td align="left" width="30%" style="padding-bottom: 5px;">
						<h2>Alterar</h2>
					</td>
					<td align="right" width="70%" style="padding-bottom: 5px;">
						<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="addPop_close();">
						  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Fechar
						</button>
					</td>
				</tr>
				<tr>
					<td align="center" style="color: red;" id="erro" colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td align="right"><b>Senha Antiga:</b></td>
					<td align="left">
						<input type="password" class="form-control input-xs" name="senhaAntiga" id="senhaAntiga" size="" value="" >
					</td>
				</tr>
				<tr>
					<td align="right"><b>Senha Nova:</b></td>
					<td align="left">
						<input type="password" class="form-control input-xs" name="senhaNova1" id="senhaNova1" size=""   value="">
					</td>
				</tr>
				
				<tr>
					<td align="right"><b></b></td>
					<td align="left">
						<input type="password" class="form-control input-xs" name="senhaNova" id="senhaNova" size="" onBlur="verificaSenhaIgual(this);" value="">
					</td>
				</tr>
				
				<tr>
					<td align="center" colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" colspan="3">
						<div class="btn-group" role="group" aria-label="...">
							<input class="btn btn-success btn-sm " type="button" onclick="verifyPnotifyConfirm( 'Deseja salvar ?', 'salvarUsuarioSenha(<?=$_GET["id"]?>)' );" value="Salvar" /> 
							<input class="btn btn-danger btn-sm" type="button" onclick="addPop_close();" value="Cancelar"/>
						</div>
						
						<input type="hidden" name="id" id="id" value="<?=$_GET["id"]?>"/>
						<input type="hidden" name="saveOK" id="saveOK" value="0"/>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
	<script>
	document.onkeypress = function (evt){
		if(main.procuraTecla(evt,13)){
			if(confirm('Deseja salvar?')){ salvarUsuarioSenha(<?=$_GET["id"]?>); } 
		}
	}
	</script>
</div>
<? 
}
?>