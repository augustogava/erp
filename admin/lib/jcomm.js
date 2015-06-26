//Variaveis Globais
var el_drag='';
var z_index = 1, el_resize=0,xa=0, ya=0,a=0,b=0,x=0,y=0,digitando=0,existeTextarea=0, xX, drag=2, finalX = 0, finalY = 0, startX = 0, startY = 0, startYIn = 0, startXIn = 0, andarL = 0, andarT = 0;
var tipNameSpaceURI = "http://www.w3.org/1999/xhtml";
var ignore = Array();
var camposData = Array();

//Fun��o retorno
function $(divr){
	return document.getElementById(divr);
}	

var windowS = {
	/*
		Propriedade: getWidth
		Retorna um valor inteiro representando a largura do browser(sem barra)
	*/
	getWidth: function(){
		if (this.webkit419) return this.innerWidth;
		if (this.opera) return document.body.clientWidth;
		return document.documentElement.clientWidth;
	},
	/*
		Propriedade: getHeight
		Retorna um valor inteiro representando a altura do browser(sem barra)
	*/
	getHeight: function(){
		if (this.webkit419) return this.innerHeight;
		if (this.opera) return document.body.clientHeight;
		return document.documentElement.clientHeight;
	},
	/*
		Propriedade: getScrollWidth
		Retorna um valor inteiro representando a largura do scroll
				
		Veja:
		<http://developer.mozilla.org/en/docs/DOM:element.scrollWidth>
	*/
	getScrollWidth: function(){
		if (this.ie) return Math.max(document.documentElement.offsetWidth, document.documentElement.scrollWidth);
		if (this.webkit) return document.body.scrollWidth;
		return document.documentElement.scrollWidth;
	},
	/*
		Propriedade: getScrollHeight
		Retorna um valor inteiro representando a altura do scroll
		
		Veja:
		<http://developer.mozilla.org/en/docs/DOM:element.scrollHeight>
	*/
	getScrollHeight: function(){
		if (this.ie) return Math.max(document.documentElement.offsetHeight, document.documentElement.scrollHeight);
		if (this.webkit) return document.body.scrollHeight;
		return document.documentElement.scrollHeight;
	},
	/*
		Propriedade: getScrollLeft
		Retorna um valor inteiro representando a largura do scroll (quantos pixels a janela scrollo para esquerda)
	*/
	getScrollLeft: function(){
		return this.pageXOffset || document.documentElement.scrollLeft;
	},
	/*
		Propriedade: getScrollTop
		Retorna um valor inteiro representando a altura do scroll (quantos pixels a janela scrollo para topo)
	*/
	getScrollTop: function(){
		return this.pageYOffset || document.documentElement.scrollTop;
	},
	/*
		Propriedade: getSize
		retorna um objeto com valores 
		alert(windowS.getSize().size.x)
	*/
	getSize: function(){
		return {
			'size': {'x': this.getWidth(), 'y': this.getHeight()},
			'scrollSize': {'x': this.getScrollWidth(), 'y': this.getScrollHeight()},
			'scroll': {'x': this.getScrollLeft(), 'y': this.getScrollTop()}
		};
	}
}
//
// Classe evento, tratamento de eventos
// adicionar, remover, changeDivText, move
//
var evento = {
	/**
		Adicione seus metodos do onLoad.	
	*/
	carrega: function (){
		setTimeout("evento.carregaTime();", 1000)
	},
	carregaTime: function (){
		var existe = $('menu');
		if(existe != null){
			evento.adicionar($('menu'), 'mouseover', function (evt) { mudaMenu(1) });
			evento.adicionar($('menu'), 'mouseout', function (evt) { mudaMenu(0) });
		}
	},
	/*
		IE
		$('div_3').attachEvent('onclick',function () {
			  alert('aaa');
			});
		Firefox
		$('div_3').addEventListener('click',function () {
			  alert('aaa');
		},false);
	*/
	/*
		Propriedade: adicionar
		Adiciona um evento a um elemto
		Exemplo:
		evento.adicionar($('div_3'), 'click', function (evt) { efeitos.appearDown('div_4'); });
	*/
	adicionar: function (elem,type,func) {
		var newfunc = func;
		if (elem != null && elem["on"+type]) {
			var oldfunc = elem["on"+type];
			newfunc = function(event) {
				var ret1 = oldfunc(event);
				var ret2 = func(event);
				return ret1 && ret2;
			}
		}
		elem["on"+type] = newfunc;
	},
	/*
		Propriedade: remover
		remove um evento a um elemto
		Exemplo:
		evento.remover($('div_3'), 'click', function (evt) { efeitos.appearDown('div_4'); });
	*/
	remover: function ( obj, type, fn ) {
			if ( obj.detachEvent ) {
				obj.detachEvent( 'on'+type, obj[type+fn] );
				obj[type+fn] = null;
			} else // Bons Browsers
				obj.removeEventListener( type, fn, false );
	},
	/*
		Propriedade: addEventsTag
		Adiciona um evento a todos as tags
		Exemplo:
		evento.addEventsTag('li', 'click', function (evt) { efeitos.appearDown('div_4'); });
	*/
	addEventsTag: function (tag,evento,funcao){
		var container = main.pegar_tags(tag)
		for(var i=0; i<container.length; i++){
			this.adicionar($(container[i]), evento, funcao);
		}
	},
	/*
		Propriedade: removeEventsTag
		remove um evento de todos as tags
		Exemplo:
		evento.removeEventsTag('li', 'click', function (evt) { efeitos.appearDown('div_4'); });
	*/
	removeEventsTag: function (tag,evento,funcao){
		var container = main.pegar_tags(tag)
		for(var i=0; i<container.length; i++){
			this.remover($(container[i]), evento, funcao);
		}
	},
	/*
		Propriedade: addEventClass
		Adiciona um evento a todos as classes
		Exemplo:
		evento.addEventClass('classeName', 'click', function (evt) { efeitos.appearDown('div_4'); });
	*/
	addEventClass: function (classN,evento,funcao){
		//Procurar elementos que usam esta Classe
		b=classA.getElementsByClassName(classN);
		for(i=0; i<b.length; i++){
			  this.adicionar($(b[i]), evento, funcao);
		}
	},
	/*
		Propriedade: removeEventClass
		remove um evento de todos as classes
		Exemplo:
		evento.removeEventClass('classeName', 'click', function (evt) { efeitos.appearDown('div_4'); });
	*/
	removeEventClass: function (classN,evento,funcao){
		//Procurar elementos que usam esta Classe
		b=classA.getElementsByClassName(classN);
		for(i=0; i<b.length; i++){
			 this.remover($(b[i]), evento, funcao);
		}
	}
}
var arrayMa = {
	/*
		Propriedade: existeDentroarray
		Retorna true caso exista o valor dentro da array
		Exemplo:
		main.existeDentroarray(array,valor);
	*/
	existeDentroarray: function (arrayN, value){
		for (xX in arrayN){
			if(arrayN[xX]==value)
				return true;
		}
		return false;
	}
}

var ajaxEfeitos = {
	gerarCombo: function (tabela, campoAntigo){
		$('saidaBusca').style.display = 'block';
		doAjaxSemRetorno('ajax_com/busca.php?tipo=autoComplete&campoatual='+campoAntigo+'&tabela='+tabela+'&valor='+$('valor').value+'&campo='+$('campo').value, 0, 'saidaBusca');
	},
	enviaValor: function (campo, valor){
		eval('window.opener.document.edit.'+campo+'.value = '+valor);
		window.close();
	},
	enviaValorImg: function (campo, valor){
		eval('window.opener.document.edit.'+campo+'.src = \''+valor+'\'');
		window.close();
	}
}

/**
* Classe com metodos para o select.
*
* @author Augusto Gava
* @version 1.0
*/
var selectInput = {
	selecionaValor: function ( valor, campo ){
		var campo = $(campo);
		var tamanho = campo.options.length;
		
		for(var i=0; i<tamanho; i++){
			if(campo[i].value == valor)
				campo.selectedIndex = i;
		}
		
	},
	adicionarCampoSelect: function (campo, id, valor){
		eval('var sel = window.opener.document.edit.'+campo);
		var tam = sel.options.length;
		
		if(!document.all){ // Firefox
			sel.options[tam] = new Option(valor, id);
		}else{ //ie7 lixo

			var doc = sel.ownerDocument;
			if (!doc) doc = sel.document;
			var opt = doc.createElement("OPTION");
			opt.value = id;
			opt.text = valor;
	
			sel.add(opt, sel.options.length);
		}
		sel.selectedIndex = tam;		
		window.close();
	}
}

/**
* Classe com metodos para o radio.
*
* @author Augusto Gava
* @version 1.0
*/
var radioInput = {
	selecionaValor: function ( campo ){
		var campo = eval("document.edit." + campo);
		for (i=0;i<campo.length;i++){
			if (campo[i].checked){
	          return campo[i].value;
		    }
		}
	}
}

/**
* Classe dataGrid
*
* @author Augusto Gava
* @version 1.0
*/
var dataGrid = {
	criarTimeoutRefresh: function( divpai, tempo) {
		tempo *= 1000;
		url = $('urlHidden').value;
		
		doAjaxSemRetorno(url , 2, divpai);
		//setTimeout("dataGrid.criarTimeoutRefresh('"+divpai+"',"+tempo+");", tempo)	
	},
	Limite: function( param){
		var url = ''; 
		url = $('queryB').value;
		doAjaxSemRetorno('ajax_com/montaDataGrid.php?nd=nd&busca=' + url + param + '&limite=' + $('Limite').value, 2, 'Saida');
	},
	Enviar: function( param){
		var url = ''; 
		url = $('queryB').value;
		doAjaxSemRetorno('ajax_com/montaDataGrid.php?nd=nd&busca=' + url + param + '&limite=' + $('Limite').value, 2, 'Saida');
	},
	EnviarEdit: function( param){
		var url = ''; 
		url = $('queryB').value;
		doAjaxSemRetorno('ajax_com/acaoDataGrid.php' + PegarCampos() + param , 2, 'addPop');
		
		dataGrid.Enviar(param);
	},
	EnviarEditPopUP: function( param, campo, tabela){
		var url = ''; 
		url = $('queryB').value;
		doAjaxSemRetorno('ajax_com/acaoDataGrid.php' + PegarCampos() + param , 2, 'addPop');
		doAjaxSemRetorno('ajax_com/adicionar.php?campo=' + campo + '&tabela=' + tabela , 1, '');
	},
	Deletar: function( param){
		var url = ''; 
		url = $('queryB').value;
		doAjaxSemRetorno('ajax_com/montaDataGrid.php?acao=Deletar&busca=' + url + param + '&limite=' + $('Limite').value, 2, 'Saida');
	},
	enviarget: function (valor, param){ 
		Valores = valor.split( ',' ); 
		var url = ''; 
		for(var i=0; i<Valores.length -1; i++){ 
			parte = Valores[i].split('.'); 
			if($(parte[1]).value != ''){ 
				url += parte[0] + '-' + parte[1] + '.' + parte[2]  + '|' + $(parte[1]).value + ',';
			 }  
		}
		$('queryB').value = url;
		dataGrid.Enviar( param);
		
	},
	pegarCidades: function (valor){
		doAjaxSemRetorno('ajax_com/pegaCidades.php?acao=pegaCidades&estado=' + valor, 1, '');
	},
	pegarCidadesSite: function (valor){
		doAjaxSemRetorno('ajax_com/pegaCidades.php?acao=pegaCidadesSite&estado=' + valor, 1, '');
	},
	/*
	*	Criado este metodo para funcionar calendar atraves do ajax, parece que precisava terminar de carregar tudo para depois chamar a classe dhtmlCalendarObject.
	*/
	addCalendar: function (campos){
		camposData = campos;
		setTimeout("dataGrid.addCalendarFix();", 1000)
	},
	addCalendarFix: function (){
		var mCal;
		mCal = new dhtmlxCalendarObject(camposData);
		mCal.setDateFormat("%d/%m/%Y");
	}
	
}
//
// Classe main, fun��es globais
// procuraTecla, ret_valor, changeDivText, move
//
var main = {
	/*
		Propriedade: getPos
		Retorna posicao abosluta X e Y do objeto
		Exemplo:
		a = main.getPos($('DIV'));
		a[0] = top, a[1] = left
	*/
	getPos: function (obj) {
		posLeft = obj.offsetLeft;
		posTop = obj.offsetTop;
		while (obj.offsetParent != null) {
			objPar = obj.offsetParent;
			posLeft += objPar.offsetLeft;
			posTop += objPar.offsetTop;
			obj = objPar;
		}
		return [posTop,posLeft];
	},
	/*
		Propriedade: trocad
		Troca display do elemento
		Exemplo:
		main.trocad(elemento);
	*/
	trocad: function (el){
		$(el).style.display = ($(el).style.display == 'none') ? 'block' : 'none';
	},
	/*
		Propriedade: pegar_tags
		Retorna array com ids das tags achadas
		Exemplo:
		main.pegar_tags('div ul a');
		Vai achar todos os A que estiverem dentro de um UL que estiverem dentro de uma DIV
	*/
	pegar_tags: function(tagN){
		var sp = new Array();
		var elements = new Array();
		var Index = 0;
		var tem = false;
		sp = tagN.split(' ');
		
		tag = document.getElementsByTagName(sp[0]);
		if(sp.length>1)
			for (var e = 0; e < tag.length; e++){
				para = $(tag[e].id);
				for (var a = 0; para.childNodes[a]; a++){
					if(para.childNodes[a].nodeName.toLowerCase() == sp[1]){
						//alert(para.childNodes[a].id)
						for (var aa = 0; para.childNodes[a].childNodes[aa]; aa++){
							if(para.childNodes[a].childNodes[aa].nodeName.toLowerCase() == sp[2]){
									elements[Index] = para.childNodes[a].childNodes[aa].id;
									Index++;
									tem = true;
							}
						}
						if(!tem){
							elements[Index] = para.childNodes[a].id;
							Index++;
						}
					}
				}
			}
		else{
			for(var i=0; i<tag.length; i++){
				elements[Index] = tag[i].id;
				Index++;
			}
		}
		return elements;
	},
	/*
		Propriedade: procuraTecla
		retorna true se tecla for pressionada
		Exemplo:
		$(el).onkeypress = function (evt){
				if(main.procuraTecla(evt,13)){
				}
			}
	*/
	procuraTecla: function (evt,keyPress) {
		evt = (evt) ? evt : event
		var c = (evt.which) ? evt.which : evt.keyCode
		if (c == keyPress) {
			return true
		}
		return false
	},
	/*
		Propriedade: ret_valor
		retorna valor separado de px
		Exemplo:
		main.ret_valor('120px') = 120
	*/
	ret_valor: function (valor){
		var part=valor.split('px');
		return part[0];
	},
	/*
		Propriedade: changeDivText
		Div aparece um campo Textarea para preenchimento, e quando ENTER eh pressionado ele adiciona o texto ao corpo da DIV
		Exemplo:
		main.changeDivText('div')
	*/
	changeDivText: function (el){
		digitando=1;
			$(el).innerHTML='';
			$(el).innerHTML+='<textarea name="texto[]" id="texto'+el+'" class="textarea">Digite o Texto Aqui!</textarea>';
			$(el).onkeypress = function (evt){
				if(main.procuraTecla(evt,13)){
					digitando=0;
					$('texto'+el).style.display='none';
					$(el).innerHTML=$('texto'+el).value;
				}
			}
	},
	/*
		Propriedade: changeDivtoInput
		Div aparece um campo text para preenchimento, e quando ENTER ou blur move texto
		Exemplo:
		main.changeDivText('div')
	*/
	changeDivtoInput: function (el){
	
		if(digitando == 0){
			digitando=1;
			Valor = $(el).innerHTML;
			$(el).innerHTML = '';
			
			$(el).innerHTML+='<input type="text" name="texto[]" id="texto'+el+'" class="inputText" value="' + Valor + '">';
			$('texto' + el).focus();
		}
		
		$(el).onkeypress = function (evt){
			if(main.procuraTecla(evt,13)){
				digitando=0;
				$('texto'+el).style.display='none';
				$(el).innerHTML=$('texto'+el).value;
			}
		}
		
		$('texto'+el).onblur = function (){
				digitando=0;
				$('texto'+el).style.display='none';
				$(el).innerHTML=$('texto'+el).value;
		}
	},
	/*
		Propriedade: move
		Preenche os valores X e Y com as coordenadas do mouse
	*/
	move: function (evt) {
		if (document.all) {//IE
			x = (document.documentElement && document.documentElement.scrollLeft) ? document.documentElement.scrollLeft : document.body.scrollLeft;
			y = (document.documentElement && document.documentElement.scrollTop) ? document.documentElement.scrollTop : document.body.scrollTop;
			x += window.event.clientX;
			y += window.event.clientY;
			
		} else {//Bons Browsers ;)
			x = evt.pageX;
			y = evt.pageY;
		}
		dragA.dragVerificacoes()
	},
	/*
		Propriedade: next
		Tem que ser usado atra�ves de um elemento para detec��o do evento, pula para o proximo campo, quando determina tecla for pressionada!
		Exemplo:
		evento.adicionar($('texto1'), 'keypress', function (evt) { main.next(evt,'texto2'); });
	*/
	next: function (evt,el){
		if(main.procuraTecla(evt,13))
		   document.getElementById(el).focus();
	},
	/*
	Abre janelas tanto IE Firefox.
	*/
	openWindow: function(URL, Width, Height) {
		
		//Attributes = 'dialogWidth:' + Width + 'px;dialogHeight:' + Height + 'px;';
		Attributes = 'height = ' + Height + ', width = ' + Width + ', location = yes, toolbar = no, menubar=yes, scrollbars=yes';
		var UA = navigator.userAgent;
		if (UA.indexOf('Firefox') > -1) { // IE (apenas IE tem esse m�todo)
			return(window.open(URL, "", Attributes));
		}else { // Browsers normais =)
			return(window.open(URL, '_blank', Attributes));
		}
	},
	/*
	Imprimi.
	*/
	imprimir: function(){
		window.print();
	}
}

//
// Classe class, tratamento de classes de container
// hasClasse, getElementsByClassName, removeClass, addClass
//
var classA = {
	/*
		Propriedade: hasClasse
		Verifica se existe a classe no elemento
	*/
	hasClasse: function (element,classn){
		have=false;
		var conta = 0;
		b = $(element).className.split(' ');
		c = classes = classn.split(' ');
		for(e=0; e<b.length; e++){
			for(f=0; f<c.length; f++){
				if(b[e]== c[f]){
					conta++;
				}
			}
		}
		if(conta == (c.length))
			have = true;
		return have;
	},
	/*
		Propriedade: getElementsByClassName
		Retorna uma array com todos os elementos que possuem determinada classe
		Exemplo:
		classA.getElementsByClassName('classe');
	*/
	getElementsByClassName: function (classna){
		var children = document.getElementsByTagName('*') || document.all;
		var elements = [];
		
		for(i=0; i<children.length; i++){
			if(children[i].id){
				a = children[i].id;
				if(a.id != 'id')
					if(classA.hasClasse(children[i].id,classna)){  elements.push(children[i].id); }
			}
		}
		return elements;
	},
	/*
		Propriedade: removeClass
		Remove classe de determinado elemento
		Exemplo:
		classA.removeClass('div','classeName');
	*/
	removeClass: function (element,classn){
		var newClassName = '';
		
		a=$(element).className.split(' ');
		for(e=0; e<a.length; e++){
			if(a[e] != classn){
				if (i > 0) 
					newClassName += ' ';
				newClassName += a[e];
			}
		}
		$(element).className=newClassName;
	},
	/*
		Propriedade: addClass
		Adiciona Classe a determinado elemento
		Exemplo:
		classA.addClass('div','classeName');
	*/
	addClass: function (element,classn){
		classA.removeClass(element,classn);
		$(element).className+=' ' + classn;
	}
}
var efeitos = {
	/*
		Propriedade: visibility
		Muda valor de visibilidade do elemento
		Exemplo:
		efeitos.visibility('div',8);
	*/
	visibility: function (el,valor) {
		$(el).style.filter = 'alpha(opacity=' + valor + ');';
		$(el).style.opacity = '.' + valor + ';';
	},
	/*
		Propriedade: desliza
		Faz efeito de apari��o para baixo, objeto tem que estar com display=none
		Exemplo:
		efeitos.desliza('div',-25 ou 25);
	*/
	desliza: function (el,topir, sumir) {
		if(topir>=0){
			var top = main.ret_valor($(el).style.top);
			if(top!=0){
				$(el).style.display = 'block';
				$(el).style.top = eval(top) + 5 + 'px';
				top = main.ret_valor($(el).style.top);
				if(top<topir)
					setTimeout("efeitos.desliza('"+el+"',"+topir+","+sumir+")",20);	
				else Velocidade = 3;
			}
		}else{
			var top = main.ret_valor($(el).style.top);
			$(el).style.top = top - 5 + 'px';
			top = main.ret_valor($(el).style.top);
			if(top>topir)
				setTimeout("efeitos.desliza('"+el+"',"+topir+","+sumir+")",20);		
			else{
				Velocidade = 3;
				if(sumir == 1)
					$(el).style.display = 'none';
			}
		}
	},
	/*
		Propriedade: appearDown
		Faz efeito de apari��o para baixo, objeto tem que estar com display=none
		Exemplo:
		efeitos.appearDown('div');
	*/
	appearDown: function (el) {
		if($(el).style.display=='none'){
			var height = main.ret_valor($(el).style.height);
			$(el).style.height = '10px';
			$(el).style.display = 'block';
			efeitos.fadeIn(el,10,0,10);
				efeitos.fadeDown(el,50,height);
		}
	},
	/*
		Propriedade: fadeDown
		abaixa o elemtno, utilizado pelo appearDown
	*/
	fadeDown: function (cont,speed,valor){
		$(cont).style.height = eval(main.ret_valor($(cont).style.height)) + 8 + 'px';
			if(eval(main.ret_valor($(cont).style.height))<valor)
				setTimeout("efeitos.fadeDown('"+cont+"',"+speed+","+valor+")",speed);
			
	},
	/*
		Propriedade: fadeUp
		abaixa o elemtno, utilizado pelo appearUP
	*/
	fadeUp: function (cont,speed,valor){
		$(cont).style.height = eval(main.ret_valor($(cont).style.height)) - 8 + 'px';
			if(eval(main.ret_valor($(cont).style.height))>valor){
				setTimeout("efeitos.fadeUp('"+cont+"',"+speed+","+valor+")",speed);
			}
	},
	/*
		Propriedade: fadeIn
		Muda valor de visibilidade do elemento
		Exemplo:
		Elemento, valociade, valor inicial que deve ser 0 e valor final que pode ser ate 10
		efeitos.fadeIn('div',1,0,10);
	*/
	fadeIn: function (cont,speed,valor,fimfi){
			valor=eval(valor)+1;
			if(valor==9) valor=99
			$(cont).style.filter = 'alpha(opacity=' + valor*10 + ');';
			$(cont).style.opacity = '.' + valor + ';';
		if(valor<fimfi)
			setTimeout("efeitos.fadeIn('"+cont+"',"+speed+","+valor+","+fimfi+")",speed);
	},
	/*
		Propriedade: fadeOut
		Muda valor de visibilidade do elemento
		Exemplo:
		Elemento, valociade, valor inicial que deve ser 10 e valor final que pode ser ate 0
		efeitos.fadeOut('div',1,10,0);
	*/
	fadeOut: function (cont,speed,valorfo,fimfo){
			valorfo=eval(valorfo)-1;
			$(cont).style.filter = 'alpha(opacity=' + valorfo*10 + ');';
			$(cont).style.opacity = '.' + valorfo + ';';
		if(valorfo>fimfo){
			setTimeout("efeitos.fadeOut('"+cont+"',"+speed+","+valorfo+","+fimfo+")",speed);
		}
	},
	/*
		Propriedade: sumir
		Faz uma animacao de fadeout e some com elemento
		Exemplo:
		efeitos.sumir('div');
	*/
	sumir: function (el){
		efeitos.fadeOut(el,10,10,5);
		//setTimeout("efeitos.fadeIn('" + el + "',1,0);" , 200);
		setTimeout("$('" + el + "').style.display = 'none';" , 200);
	},
	fadeOutIE: function (cont,speed,valorfo,fimfo,totalTd){
			valorfo=eval(valorfo)-1;
			for(i=0; i<totalTd; i++){
				$(cont + '_' + i).style.filter = 'alpha(opacity=' + valorfo*10 + ');';
				$(cont + '_' + i).style.opacity = '.' + valorfo + ';';
			}
		if(valorfo>fimfo){
			setTimeout("efeitos.fadeOutIE('"+cont+"',"+speed+","+valorfo+","+fimfo+","+totalTd+")",speed);
		}
	},
	/*
		Propriedade: sumir
		Faz uma animacao de fadeout e some com elemento
		Exemplo:
		efeitos.sumir('div');
	*/
	sumirIE: function (el, totalTd){
		
		efeitos.fadeOutIE(el,10,10,0,totalTd);
		//setTimeout("efeitos.fadeIn('" + el + "',1,0);" , 200);
		setTimeout("$('" + el + "').style.display = 'none';" , 200);
	},
	/*
		Propriedade: piscar
		Pisca o elemento
		Exemplo:
		efeitos.piscar('div',8);
	*/
	piscar: function (el){
		efeitos.fadeOut(el,10,10,1);
		setTimeout("efeitos.fadeIn('" + el + "',1,0,10);" , 50);
	},
	/*
		Propriedade: animar
		Anima um elemento, utilizado pelo DRAG
	*/
	animar: function (ele){
		//Constante movimento left
		andarL = 10;
		//Calculo foda, pra pega quanto anda
		andarT = ((finalY - main.ret_valor($(ele).style.top)) * andarL) / (finalX - main.ret_valor($(ele).style.left));
		//Bug
		if(andarT<0) andarT *= -1;
		efeitos.move(el_drag,finalX,finalY,1);
	},
	/*
		Propriedade: move
		Move um elemento para determinada coordenada
		Exemplo:
		Elemento, destinoX, destinoY e velocidade
		efeitos.move('div',500,600,10);
	*/
	move: function (cont, xa, ya, speed){
		xini=main.ret_valor($(cont).style.left);
		yini=main.ret_valor($(cont).style.top);
	
		if(xa>xini){
			if(xa>xini){ if(ya) lefta=andarL; else lefta=15; }else{ lefta=0; }
			bc=eval(xini)+eval(lefta);
			if(xa<bc && bc!='Infinity'){ $(cont).style.left=xa + 'px'; return 0; }
			agora=eval(main.ret_valor($(cont).style.left)) + lefta;
			$(cont).style.left=agora  + 'px';
		}
		if(ya>yini){
			if(ya>yini){ topa=andarT; }else{ topa=0; yini=ya;  }
			bc2=eval(yini)+eval(topa);
			if(ya<bc2 && bc2!='Infinity'){ $(cont).style.top=ya + 'px'; }
			agora2=eval(main.ret_valor($(cont).style.top)) + topa;
			$(cont).style.top=agora2 + 'px';
		}
		if(ya<yini){
			if(ya<yini){ topa=andarT; }else{ topa=0; yini=ya; };
			bc2=eval(yini)-eval(topa);
			if(ya>bc2 && bc2!='Infinity'){ $(cont).style.top=ya + 'px'; }
			agora2=eval(main.ret_valor($(cont).style.top)) - topa;
			$(cont).style.top=agora2  + 'px';
		}
		if(xa<xini){
			if(xa<xini){ if(ya) lefta=andarL; else lefta=15; }else{ lefta=0; }
			bc=eval(xini)-eval(lefta);
			if(xa>bc && bc!='Infinity'){ $(cont).style.left=xa + 'px'; return 0; }
			agora=eval(main.ret_valor($(cont).style.left)) - lefta;
			$(cont).style.left=agora  + 'px';
		}
		if(xa>xini || xa<xini || ya<yini || ya>yini)
			setTimeout("efeitos.move('"+cont+"',"+xa+","+ya+","+speed+")",speed);
	}
}
/*
	Funcoes de transi��o para anima��o, a implementar!
*/
var trans = {
	  sinoidal: function(pos) {
		return (-Math.cos(pos*Math.PI)/2) + 0.5;
	  },
	  reverse: function(pos) {
		return 1-pos;
	  },
	  flicker: function(pos) {
		return ((-Math.cos(pos*Math.PI)/4) + 0.75) + Math.random()/4;
	  },
	  wobble: function(pos) {
		return (-Math.cos(pos*Math.PI*(9*pos))/2) + 0.5;
	  },
	  pulse: function(pos, pulses) { 
		pulses = pulses || 5; 
		return (
		  Math.round((pos % (1/pulses)) * pulses) == 0 ? 
				((pos * pulses * 2) - Math.floor(pos * pulses * 2)) : 
			1 - ((pos * pulses * 2) - Math.floor(pos * pulses * 2))
		  );
	  },
	  none: function(pos) {
		return 0;
	  },
	  full: function(pos) {
		return 1;
	  }
};
//
// Classe Drag, contem:
// criar_dragClass, criar_dragEl, startDrag, stopDrag, dragVerificacoes, verificaCursor
//
var Targets = [];
var dragA = {
	/*
		Propriedade: option
		Ajustar op��es drag
		Exemplo:
		dragA.option(false);
	*/
	option: function (ghost){
		this.ghost = ghost;
	},
	/*
		Propriedade: criar_dragEl
		Criar drag a um elemento
		Exemplo:
		dragA.criar_dragEl('drag',1);
	*/
	criar_dragEl: function (el,resize){
			evento.adicionar($(el), 'mousedown', function (ev) { dragA.startDrag(el,resize); dragA.bugie(ev); return false; });
	},
	bugie: function(ev){
		var UA = navigator.userAgent;
		if (UA.indexOf('MSIE') > -1) {
		   this.Loko();
		} else if (UA.indexOf('Firefox') > -1) {
		   dragA.BugIevai();
		}
	},
	BugIevai: function(){
		return;
	},
	/*
		Propriedade: startDrag
		Inicio Drag, seta as vari�veis utilizados pelo Drag
	*/
	startDrag: function (el, resize){
		if(this.ghost){
			startYIn = main.ret_valor($(el).style.top)-y;
			startXIn = main.ret_valor($(el).style.left)-x;
			
			startY = main.ret_valor($(el).style.top);
			startX = main.ret_valor($(el).style.left);
		}
		//Alterar z-index pra frente
		$(el).style.zIndex = z_index;
		z_index++;
		
		drag=1;
		el_drag=el;
		el_resize=resize;
		//Valores do mouse
		ya=main.ret_valor($(el_drag).style.top)-y;
		xa=main.ret_valor($(el_drag).style.left)-x;
		//Verifica se pode, e se ta na posicao correta para rezise
		if(ya<-(main.ret_valor($(el_drag).style.height)-5) && xa<-(main.ret_valor($(el_drag).style.width)-5) && resize){
			drag=3;
		}
		//Coloca Transparencia
		efeitos.visibility(el,80);
		$(el_drag).onmouseup = function (){ dragA.stopDrag(el);  }
	},
	/*
		Propriedade: stopDrag
		Fim Drag, seta as vari�veis finais, chamado no mouseOut
	*/
	stopDrag: function (el){
		//alert(4)
		el_drag=el;
		finalX = x + startXIn;
		finalY = y + startYIn;
		
		//se for ghosty volta posicao original
		if(this.ghost && drag==1)
			dragA.voltar_pos();
		
		//Verifica se soltou em cima de algum target
		dragA.verificaDropTargets();
		
		drag=2;
		//Volta Visibility
		efeitos.visibility(el,99);
	},
	/*
		Propriedade: dragVerificacoes
		Verifica��es de posicionamento do mouse, para utilizacao no drag
	*/
	dragVerificacoes: function (){
		//Dragar
		if(!digitando){
			if(drag==1){
				$(el_drag).style.top = (y + ya) + 'px';
				$(el_drag).style.left = (x + xa) + 'px';
				return false;
			//Resize
			}else if(drag==3){
				$(el_drag).style.height = (a*-1)+2 + 'px';
				$(el_drag).style.width = (b*-1)+2 + 'px';
				return false;
			}
			//Mudar Cursor, e atribuir valores a variaves
			dragA.verificaCursor();
			return false;
		}
	},
	/*
		Propriedade: verificaCursor
		Verifica��es troca de cursor
	*/
	verificaCursor: function (){
		if(el_drag){
				//Mudar cursor
				a=main.ret_valor($(el_drag).style.top)-y;
				b=main.ret_valor($(el_drag).style.left)-x;
				
				if(a<-(main.ret_valor($(el_drag).style.height)-5) && b<-(main.ret_valor($(el_drag).style.width)-5) && el_resize)
					$(el_drag).style.cursor='nw-resize';
				else
					$(el_drag).style.cursor='move';
			return false;
		}
	},
	/*
		Propriedade: voltar_pos
		Chama funcao de animar quando opcao ghost = true
	*/
	voltar_pos: function (){
		$(el_drag).style.top = startY + 'px';
		$(el_drag).style.left = startX + 'px';
		//Funcao para animar
		efeitos.animar(el_drag);
	},
	verificaDropTargets: function (){
		for(var i=0; i<Targets.length; i++){
			var curTarget  = Targets[i];
			var targPos    = main.getPos(curTarget);
			var targWidth  = parseInt(curTarget.offsetWidth);
			var targHeight = parseInt(curTarget.offsetHeight);
			/*alert(finalX + " > " + targPos[1]);
			alert(finalX + " < " + (targPos[1] + targWidth));
			alert(finalY + " > " + targPos[0]);
			alert(finalY + " < " + (targPos[0] + targWidth));*/

			if(
				(finalX > targPos[1])                &&
				(finalX < (targPos[1] + targHeight))  &&
				(finalY > targPos[0])                &&
				(finalY < (targPos[0] + targWidth))){
					alert(2);
			}
		}
	},
	addTarget: function (Target){
		Targets.push(Target);
	}
}

var formm = {
	/*
		Propriedade: verificaF
		Pega todos campos com determinada classe, e verifica se est� vazio, se estiver exibe erro no Campo erroD, e pega o Title do campo para ser o T�tutlo
		formm.verificaF(this.id,'efeitos','erro');
	*/
	verificaF: function (camp, claan, erroD){
		inputs=classA.getElementsByClassName(claan);
		
		$(erroD).innerHTML  = '';
		for(var i=0; i<inputs.length; i++){
			$(inputs[i]).focus();
			titulo = $(inputs[i]).title;
			if($(inputs[i]).value == ''){
				if(!arrayMa.existeDentroarray(ignore,inputs[i])){
					
					$(erroD).innerHTML += titulo + ', Preencha corretamente o campo <br>';
					$(inputs[i]).focus();
					erro = true;
					return false;
				}
			}else{
				if(titulo.indexOf("cpf") != -1){
					if( !validacoes.cpf($(inputs[i]).value) ){
						$(erroD).innerHTML += titulo + ', Incorreto! <br>';
						$(inputs[i]).focus();
						erro = true;
						return false;
					}
				}else if(titulo.indexOf("cnpj") != -1){
					if( !validacoes.cnpj($(inputs[i]).value) ){
						$(erroD).innerHTML += titulo + ', Incorreto! <br>';
						$(inputs[i]).focus();
						erro = true;
						return false;
					}
				}
					
			}
		}
		return true;
	},
	/*
		Propriedade: changeColor
		Pega todos campos com determinada classe, e muda a cor de fundo do campo
		formm.changeColor(this.id,'efeitos','#000','#FFF');
	*/
	changeColor: function (camp, claan, cornova, corori){
		inputs=classA.getElementsByClassName(claan);
		for(var i=0; i<inputs.length; i++){
			if(inputs[i])
				if(inputs[i]==camp)	$(camp).style.background = cornova;	
					else $(inputs[i]).style.background = corori;
		}
	},
	/*
		Propriedade: changebox
		Pega todos campos com determinada classe, e seta uma caixa com instru��es do lado, sendo o Titutlo: title e Descricao: alt
		formm.changebox(this.id,'efeitos','erro');
	*/
	changebox: function (camp, claan){
		inputs=classA.getElementsByClassName(claan);
		
		for(var i=0; i<inputs.length; i++){
			if(inputs[i]==camp){
				posi = main.getPos($(inputs[i]));
				desc = $(inputs[i]).title;
				desc2 = $(inputs[i]).alt;
				$('box_').style.top = posi[0] - 10  + 'px';
				$('box_').style.left = posi[1] + 230 + 'px';
				$('box_').style.display = 'block';
				$('box_').innerHTML = '<h4>' + desc + '</h4>' + desc2;
			}
		}
		
	}	
}
var domM = {
	/*
		Propriedade: addEl
		Criar um elemento
		Exemplo:
		domM.addEl('teste','input','div_3')
	*/	
	addEl: function (nome , tipo, appe){
		eleme = document.createElementNS ? document.createElementNS(tipNameSpaceURI, tipo) : document.createElement(tipo);
		eleme.setAttribute("id",nome);
		$(appe).appendChild(eleme);
		//
	},
	/*
		Propriedade: chandepro
		Adicionar ou alterar propriedade de um elemetno
		Exemplo:
		domM.chandepro('teste','value','Mudar')
	*/
	chandepro: function (idp , nomep, valorp){
		$(idp).setAttribute(nomep,valorp);
	},
	/*
		Propriedade: removepro
		Remove uma propriedade de um elemetno
		Exemplo:
		domM.removepro('teste','value')
	*/
	removepro: function (idp , nomep){
		$(idp).removeAttribute(nomep);
	}
}

var mascaras = {
	mascara: function(o,f){
		v_obj=o
		v_fun=f
    	setTimeout("mascaras.execmascara()",1)
	},
	
	execmascara: function(){
    	v_obj.value=eval('mascaras.'+v_fun+'("'+v_obj.value+'")');
	},
	
	cpf: function(v){
		v=v.replace(/\D/g,"")                    //Remove tudo o que n�o � d�gito
		v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto d�gitos
		v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto d�gitos
												 //de novo (para o segundo bloco de n�meros)
		v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um h�fen entre o terceiro e o quarto d�gitos
		return v;
	},
	
	soNumeros: function (v){
		 return v.replace(/\D/g,"")
	},
	
	tel: function (v){
		v=v.replace(/\D/g,"")                 //Remove tudo o que n�o � d�gito
		v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca par�nteses em volta dos dois primeiros d�gitos
		v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca h�fen entre o quarto e o quinto d�gitos
		return v
	},
	
	cel: function (v){
		v=v.replace(/\D/g,"")                 //Remove tudo o que n�o � d�gito
		v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca par�nteses em volta dos dois primeiros d�gitos
		v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca h�fen entre o quarto e o quinto d�gitos
		return v
	},
	
	fax: function (v){
		v=v.replace(/\D/g,"")                 //Remove tudo o que n�o � d�gito
		v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca par�nteses em volta dos dois primeiros d�gitos
		v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca h�fen entre o quarto e o quinto d�gitos
		return v
	},
	
	preco: function (v){
		v=v.replace(/\D/g,"")                    //Remove tudo o que n�o � d�gito
		return v
	},
	
	rg: function (v){
		v=v.replace(/\D/g,"")                    //Remove tudo o que n�o � d�gito
		v=v.replace(/(\d{2})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto d�gitos
		v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto d�gitos
		v=v.replace(/(\d{3})(\d)/,"$1-$2")       //Coloca um ponto entre o terceiro e o quarto d�gitos
												 //de novo (para o segundo bloco de n�meros)
		return v
	},
	
	cep: function (v){
		v=v.replace(/D/g,"")                //Remove tudo o que n�o � d�gito
		v=v.replace(/^(\d{5})(\d)/,"$1-$2") //Esse � t�o f�cil que n�o merece explica��es
		return v
	},
	
	data: function (v){
		v=v.replace(/\D/g,"")  
		v=v.replace(/(\d{2})(\d)/,"$1/$2") //Esse � t�o f�cil que n�o merece explica��es
		v=v.replace(/(\d{2})(\d)/,"$1/$2") //Esse � t�o f�cil que n�o merece explica��es
	
		return v
	},
	
	nascimento: function (v){
		v=v.replace(/\D/g,"")  
		v=v.replace(/(\d{2})(\d)/,"$1/$2") //Esse � t�o f�cil que n�o merece explica��es
		v=v.replace(/(\d{2})(\d)/,"$1/$2") //Esse � t�o f�cil que n�o merece explica��es
	
		return v
	},
	
	cnpj: function (v){
		v=v.replace(/\D/g,"")                           //Remove tudo o que n�o � d�gito
		v=v.replace(/^(\d{2})(\d)/,"$1.$2")             //Coloca ponto entre o segundo e o terceiro d�gitos
		v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") //Coloca ponto entre o quinto e o sexto d�gitos
		v=v.replace(/\.(\d{3})(\d)/,".$1/$2")           //Coloca uma barra entre o oitavo e o nono d�gitos
		v=v.replace(/(\d{4})(\d)/,"$1-$2")              //Coloca um h�fen depois do bloco de quatro d�gitos
		return v
	},
	
	romanos: function (v){
		v=v.toUpperCase()             //Mai�sculas
		v=v.replace(/[^IVXLCDM]/g,"") //Remove tudo o que n�o for I, V, X, L, C, D ou M
		//Essa � complicada! Copiei daqui: http://www.diveintopython.org/refactoring/refactoring.html
		while(v.replace(/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/,"")!="")
			v=v.replace(/.$/,"")
		return v
	},
	
	site: function (v){
		//Esse sem comentarios para que voc� entenda sozinho ;-)
		v=v.replace(/^http:\/\/?/,"")
		dominio=v
		caminho=""
		if(v.indexOf("/")>-1)
			dominio=v.split("/")[0]
			caminho=v.replace(/[^\/]*/,"")
		dominio=dominio.replace(/[^\w\.\+-:@]/g,"")
		caminho=caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g,"")
		caminho=caminho.replace(/([\?&])=/,"$1")
		if(caminho!="")dominio=dominio.replace(/\.+$/,"")
		v="http://"+dominio+caminho
		return v
	},
	Limpar: function (valor, validos) {
		// retira caracteres invalidos da string
		var result = "";
		var aux;
		for (var i=0; i < valor.length; i++) {
		aux = validos.indexOf(valor.substring(i, i+1));
		if (aux>=0) {
		result += aux;
		}
		}
		return result;
	},
		
	//onKeyPress="Formata(this,20,event,2)"
	Formata: function(campo,tammax,teclapres,decimal) {
		var tecla = teclapres.keyCode;
		vr = mascaras.Limpar(campo.value,"0123456789");
		tam = vr.length;
		dec=decimal
		
		if (tam < tammax && tecla != 8){ tam = vr.length + 1 ; }
		if (tecla == 8 ){ 
			tam = tam - 1 ; 
		}
		
		if ( tecla == 0 || tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ){
			if ( tam <= dec ){ 
				campo.value = vr ; 
			}
			if ( (tam > dec) && (tam <= 5) ){
				campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec, tam ) ; 
			}
			if ( (tam >= 6) && (tam <= 8) ){
				campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
			}
			if ( (tam >= 9) && (tam <= 11) ){
				campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
			}
			if ( (tam >= 12) && (tam <= 14) ){
				campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
			}
			if ( (tam >= 15) && (tam <= 17) ){
				campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14, 3 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam ) ;
			}
		} 
		
	}
}
var validacoes = {
	cpf: function (cpf){
		var cpf = cpf.replace(/\./g, "");
		cpf = cpf.replace(/\-/g,"");
		var numeros, digitos, soma, i, resultado, digitos_iguais;
	 digitos_iguais = 1;
	  if (cpf.length < 11)
			return false;
	  for (i = 0; i < cpf.length - 1; i++)
			if (cpf.charAt(i) != cpf.charAt(i + 1))
				  {
				  digitos_iguais = 0;
				  break;
				  }
	  if (!digitos_iguais)
			{
			numeros = cpf.substring(0,9);
			digitos = cpf.substring(9);
			soma = 0;
			for (i = 10; i > 1; i--)
				  soma += numeros.charAt(10 - i) * i;
			resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
			if (resultado != digitos.charAt(0))
				  return false;
			numeros = cpf.substring(0,10);
			soma = 0;
			for (i = 11; i > 1; i--)
				  soma += numeros.charAt(11 - i) * i;
			resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
			if (resultado != digitos.charAt(1))
				  return false;
			return true;
		}
	  else
			return false;
	  },
	  
	  cnpj: function (cnpj){
      	var cnpj = cnpj.replace(/\./g, "");
		cnpj = cnpj.replace(/\-/g,"");
		cnpj = cnpj.replace(/\//g,"");

	  var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
      digitos_iguais = 1;
      if (cnpj.length < 14 && cnpj.length < 15)
            return false;
      for (i = 0; i < cnpj.length - 1; i++)
            if (cnpj.charAt(i) != cnpj.charAt(i + 1)){
				digitos_iguais = 0;
				break;
            }
      if (!digitos_iguais){
            tamanho = cnpj.length - 2
            numeros = cnpj.substring(0,tamanho);
            digitos = cnpj.substring(tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--){
                  soma += numeros.charAt(tamanho - i) * pos--;
                  if (pos < 2)
                        pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
           
		   if (resultado != digitos.charAt(0))
                  return false;
            
			tamanho = tamanho + 1;
            numeros = cnpj.substring(0,tamanho);
            soma = 0;
            pos = tamanho - 7;
           
		   for (i = tamanho; i >= 1; i--){
                  soma += numeros.charAt(tamanho - i) * pos--;
                  if (pos < 2)
                        pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1))
                  return false;
				  
            return true;
			
	}else
            return false;
    } 
}

document.onload = evento.carrega();
//Pegar Posicao do Mouse
document.onmousemove = function (evt) { main.move (evt)}; 