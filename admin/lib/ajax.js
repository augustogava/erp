function getHTTPObject() { var xmlhttp; /*@cc_on @if (@_jscript_version >= 5) try { xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); } catch (e) { try { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); } catch (E) { xmlhttp = false; } } @else xmlhttp = false; @end @*/ if (!xmlhttp && typeof XMLHttpRequest != 'undefined') { try { xmlhttp = new XMLHttpRequest(); } catch (e) { xmlhttp = false; } } return xmlhttp; }
function executaScript(texto){
    // inicializa o inicio ><
    var ini = 0;
    // loop enquanto achar um script
    while (ini!=-1){
        // procura uma tag de script
        ini = texto.indexOf('<script', ini);
        // se encontrar
        if (ini >=0){
            // define o inicio para depois do fechamento dessa tag
            ini = texto.indexOf('>', ini) + 1;
            // procura o final do script
            var fim = texto.indexOf('</script>', ini);
            // extrai apenas o script
            codigo = texto.substring(ini,fim);
            // executa o script
            eval(codigo);
        }
    }
}
// Globais
var http = getHTTPObject();
var func = '';

var ifila = 0
var fila = new Array();
	
function arrumaFile(){
	ifila++;
    if(ifila<fila.length){
        //Caso tenha mais solicitacoes na fila, executa a proxima
        setTimeout("doRealAjaxSemRetorno()",20);
    }else{
        //Caso nao tenha mais solicitacoes na fila, reinicia a fila
        fila = null;
        fila = new Array();
        ifila = 0;
    }
}

/**
* Adiciona na fila ajax sem retorno Definido.
*
* @param url da requisicao
* @exibirloading flag se vai exibir llading
* @IdEleLoading o elemento q vai aparecer o loading e sera colocado o retorno
*
**/
function doAjaxSemRetorno(url, exibirloading, IdEleLoading){
	if(url != ''){
		//Cria a conex�o e envia para o fim da fila
		fila[fila.length]=[url, exibirloading, IdEleLoading, null];
		if(fila.length==1){
			doRealAjaxSemRetorno();
		}
	}
}

/**
* Executa requisi��o real Ajax
*
**/
function doRealAjaxSemRetorno(){
	var url = fila[ifila][0];
	var exibirloading = fila[ifila][1];
	var IdEleLoading = fila[ifila][2];
	http.open("GET", url, true);
	http.send(null);
	
	if(exibirloading == 1 && IdEleLoading != '' && IdEleLoading != ' '){
		$(IdEleLoading).innerHTML = '';
		$(IdEleLoading).innerHTML = '<div class="loadingAjax">Carregando...<br><img src="layout/load.gif" border="0"></div>';
	}else if(exibirloading == 2){
		/*var tipNameSpaceURI = "http://www.w3.org/1999/xhtml";
		tipContainer = document.createElementNS ? document.createElementNS(tipNameSpaceURI, "div") : document.createElement("div");
		tipContainer.setAttribute("id", 'addPop');
		tipContainer.setAttribute('class', 'caixa');
		document.getElementById("global").appendChild(tipContainer);*/
		//$('global').innerHTML += '<div id=\"addPop\" class=\"caixa\"></div>';

		$('addPop').innerHTML = '<div class="loadingAjax">Carregando...<br><img src="layout/load.gif" border="0"></div>';
		
		addPop_open(350);
	}
	http.onreadystatechange = function(){
		if(http.readyState==4){
			resultado = http.responseText.replace(/\+/g," "); // Resolve o problema dos acentos 
			resultado = resultado.replace("'","\'");
			resultado = unescape(resultado);
			
			executaScript(resultado);
			
			if(exibirloading == 2){
				addPop_close();
				fixHeight();
			}
			if(IdEleLoading != '')
				$(IdEleLoading).innerHTML = resultado;
			
			fixHeight();
			
			arrumaFile();
		}
	}
}


/**
* Faz request via ajax Assin.
*
* @param url da requisicao
* @funci que ser� executada
*
**/
function doAjax(url, funci, exibirloading, IdEleLoading){
	func = funci;
	http.open("GET", url, true);
	http.send(null);
	if(exibirloading == 1){
		$(IdEleLoading).innerHTML = '';
		$(IdEleLoading).innerHTML = '<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div>';
	}else if(exibirloading == 2){
		
		$('addPop').innerHTML = '<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div>';
		
		addPop_openLoading(350);
	}
	http.onreadystatechange = function(){
			if(http.readyState==4){
				if(exibirloading == 1){
                    $(IdEleLoading).innerHTML = '';
                }else if(exibirloading == 2){
				    addPop_close();
				    fixHeight();
                }
                doReturnAjax(http.responseText);
			}
		}
}

/**
* M�todo que executa funcao.
*
**/
function doReturnAjax(resultado){
	eval(func + '("' +  resultado + '")');
}