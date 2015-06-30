<?
include "includes/Main.class.php";
// chama a classe principal
$Main = new Main();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title> :: ERP :: <? print $Main->Padrao->nome; ?></title>
		<meta charset="utf-8">
		<meta name="description" content="<? print $Main->Padrao->descricao; ?>" >
		<meta name="keywords" content="<? print $Main->Padrao->keywords; ?>" >
		<meta name="author" content="Augusto Gava" >
		
		<link rel="stylesheet" type="text/css" media="screen, projection" href="css/css.css" >
		<link rel="stylesheet" type="text/css" href="codebase/dhtmlxcalendar.css">
	    
		<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="lib/font-awesome/css/font-awesome.min.css">
    		<link rel="stylesheet" href="lib/pnotify/pnotify.custom.min.css" media="all" type="text/css" />

		<link REL="SHORTCUT ICON" HREF="layout/favicon.ico">
	    
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
	
		<script src="lib/jquery/jquery-2.1.3.min.js"></script>
		<script src="lib/jquery/jquery-ui.min.js"></script>
		<script src="lib/pnotify/pnotify.custom.min.js" type="text/javascript"></script>		
		<script src="lib/script.js?t=11" type="text/javascript"></script>
		
	    <script>
			window.dhx_globalImgPath = "codebase/imgs/";
	
			$.noConflict();
		</script>
		<script type="text/javascript" src="codebase/dhtmlxcommon.js"></script>
		<script type="text/javascript" src="codebase/dhtmlxcalendar.js"></script>
		
		<style type="text/css">
			<!--
			#lendo{
				position:absolute;
				width:20;
				height:20;
				z-index:0;
				left:50;
			}
			#login{
				font: normal 10px verdana;
				border:solid 1px #3182E7;
				width:400px;
				background:#F5F3EF;
				text-align:left;
				top: 32%;
				left: 32%;
				z-index:0;
			    margin:100px auto;
			}
			-->
			</style>
	</head>

	<body class="login">
		
		<div class="modal"></div>
		<div id="addPop" class="caixa"></div>
		
		<div class="container">
    	<div class="row no-padding">
    		<div class="col-lg-12">
    			<div class="panel pull-right" resize="" style="margin-top: 180px;">
	    				<div class="panel-body">
	    					<div class="logo-container">
	    						<img src="layout/logo/logo.png" style="width: 300px; margin-top: 30px;">
	    					</div>
	    					
	    					<h5 id="div_ve" translate=""></h5>
	    					
	    					<div class="col-xs-10 col-xs-offset-1">
		    					<div >
									<form action="index.php" method="post" name="form1" id="form1">
						        		<fieldset>
						        		 	<div class="form-group">
							                    <input class="form-control fullsize" type="text" id="logina" name="logina" placeholder="Nome de usuário" autocomplete="off" required="" style="  margin-top: 20px;">
							                    <input class="form-control fullsize" style="margin-bottom: 10px;" type="password" id="senha" name="senha" placeholder="Senha" autocomplete="off" required="">
						                    	
						                    	<input name="button" onclick="valida_login('ajax_com/LoginSistema.php', 'senha');" class="btn  btn-sm btn-custom fullsize" value="Entrar">
							                </div>
						                </fieldset>
									</form>
								</div>
							</div>
	    				</div>
	    			</div>
	    		</div>
	        </div>
        </div>
        
		<script>
			evento.adicionar($('senha'), 'keypress', function (evt) { if(main.procuraTecla(evt,13)){ valida_login('ajax_com/LoginSistema.php', 'senha'); } });
		</script>
	</body>
</html>
