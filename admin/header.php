<!DOCTYPE html>
<html lang="en">
	<head>
		<title> ERP <? print $Main->Padrao->nome; ?></title>
		<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
		<meta name="description" content="<? print $Main->Padrao->descricao; ?>" >
		<meta name="keywords" content="<? print $Main->Padrao->keywords; ?>" >
		<meta name="author" content="Augusto Gava" >
		<link REL="SHORTCUT ICON" HREF="layout/favicon.ico">
		
		<link rel="stylesheet" href="css/css.css" media="screen, projection" type="text/css">
	    <link rel="stylesheet" href="codebase/dhtmlxcalendar.css" type="text/css">
	    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="lib/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="lib/pnotify/pnotify.custom.min.css" media="all" type="text/css" />
		
		<script>
			function loadJs(filename){
	
				var fileref=document.createElement('script');
				fileref.setAttribute("type","text/javascript");
				fileref.setAttribute("src", filename + "?t=" + new Date().getTime());
			
				if (typeof fileref!="undefined"){
					document.getElementsByTagName("head")[0].appendChild(fileref);
				}
			}
		</script>
				
		<script src="lib/jcomm.js" type="text/javascript"></script>
		<script src="lib/ajax.js" type="text/javascript"></script>
	
		<script src="lib/jquery/jquery-2.1.3.min.js" type="text/javascript"></script>
		<script src="lib/jquery/plugins/jquery-mask-v1.11.4.js" type="text/javascript"></script>
		
		<script src="lib/pnotify/pnotify.custom.min.js" type="text/javascript"></script>		

		<script src="lib/script.js?t=11" type="text/javascript"></script>
		
	    <script>
			window.dhx_globalImgPath = "codebase/imgs/";
			$.noConflict();
		</script>
		<script type="text/javascript" src="codebase/dhtmlxcommon.js"></script>
		<script type="text/javascript" src="codebase/dhtmlxcalendar.js"></script>
		
	</head>

	<body role="document">
		<div class="modal"></div>
		<div id="wrapper" class="">
			<div id="addPop" class="caixa"></div>
			
			<? include ($Main->Configuracoes->MENU_NADMIN); ?>
			
			<div id="header">
				<div class="row">
  					<div class="col-md-4">
	  			 		<p class="welcome"><b>Bem Vindo</b></p>
					</div>
					<div class="col-md-6" style="padding: 15px; text-align: right;">
	  			 		<b>Permissão:</b>  <?=$Main->Padrao->pegaNomePerfil()?> <b>Último Login:</b> <?=$Main->Padrao->pegaUltimoLogin()?><br />
					</div>
					<div class="col-md-2">
						<ul class="nav navbar-top-links navbar-right" style="margin-right: 10px;">
							<li>
								<i class="glyphicon glyphicon-user"></i>
								<span class="hidden-xs ng-binding"><?=$_SESSION["nomeuser"]?></span>
							</li>
							<li>
								<a class="dropdown-toggle" data-toggle="dropdown">
									<i class="glyphicon glyphicon-chevron-down"></i>
								</a>
								<ul class="dropdown-menu">
									<li>
										<a class="dropdown-toggle" href="javascript:doAjaxSemRetorno('ajax_com/user.php?acao=editar&id=<?=$_SESSION["iduser"]?>',1,'addPop');addPop_open(550);">
											<span class="fa fa-pencil-square-o submenu-icon"></span>
											Meus Dados
										</a>
									</li>
									<li>
										<a class="dropdown-toggle" href="javascript:doAjaxSemRetorno('ajax_com/user.php?acao=editarSenha&id=<?=$_SESSION["iduser"]?>',1,'addPop');addPop_open(550);">
											<span class="fa fa-key submenu-icon"></span>
											Alterar Senha
										</a>
									</li>
									<li>
										<a href="logout.php" class="dropdown-toggle" role="menuitem">
											<span class="fa fa-sign-out submenu-icon"></span>
											Sair
										</a>
									</li>										
								</ul>
							</li>
						</ul>
					</div>
					
						
				</div>
			</div>
