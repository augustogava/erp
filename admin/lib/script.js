//For All

function mudaMenu(flag) {

	if (flag == 1) {

		$('menu').style.left = '0px';

		$('menu').style.position = 'relative';

		$('content').style.width = '70%';

	} else if (flag == 0) {

		$('menu').style.left = '-190px';

		$('menu').style.position = 'absolute';

		$('content').style.width = '90%';

	}

}

function change(ele, img) {

	if ($(ele).style.display == 'none') {

		$(ele).style.display = 'block'

		$(img).style.background = 'url(layout/icon-dnld.gif) no-repeat 0 4px';

	} else {

		$(ele).style.display = 'none';

		$(img).style.background = 'url(layout/icon-morearrow.gif) no-repeat 0 4px';

	}

}

function addPop_openLoading(width) {
	popup = $('addPop');
	popup.style.display = "block";
	popup.style.width = (width) + "px";
	popup.style.left = (windowS.getWidth() / 2) + 'px';
	popup.style.top = (windowS.getScrollTop() + (windowS.getHeight() / 2))
			+ 'px';
	popup.style.margin = '-' + (popup.offsetHeight / 2) + 'px 0 0 -'
			+ (width / 2) + 'px';

	jQuery(".modal").show();

	if ($('main-body') != undefined)
		$('main-body').onclick = function() {
			return false;
		}
}

function addPop_open(width) {
	popup = $('addPop');
	popup.style.display = "block";
	popup.style.width = (width) + "px";
	popup.style.left = (windowS.getWidth() / 2) + 'px';
	popup.style.top = (windowS.getScrollTop() + (windowS.getHeight() / 2))
			- (windowS.getHeight() / 3) + 'px';
	popup.style.margin = '-' + (popup.offsetHeight / 2) + 'px 0 0 -'
			+ (width / 2) + 'px';

	jQuery(".modal").show();

	if ($('main-body') != undefined)
		$('main-body').onclick = function() {
			return false;
		}
}// end function

function addPop_close() {
	jQuery(".modal").hide();

	if ($('main-body') != undefined)
		$('main-body').onclick = function() {
			return true;
		}

	addPopa = $('addPop');
	addPopa.style.display = "none";
}// end function

function Campo2Array(col) {
	a = new Array();
	for (i = 0; i < col.length; i++)
		a[a.length] = col[i];
	return a;
}

// pegar campos form
function PegarCampos() {
	inputs = Campo2Array(document.getElementsByTagName("input"));
	inputs = inputs
			.concat(Campo2Array(document.getElementsByTagName("select")));

	buffer = "?";

	for (i = 0; i < inputs.length; i++) {
		if (inputs[i].type != 'button' && inputs[i].type != 'checkbox')

			buffer += inputs[i].name + "=" + inputs[i].value + "&";

		if (inputs[i].type == 'checkbox' && inputs[i].checked == true)

			buffer += inputs[i].name + "=" + inputs[i].value + "&";

	}

	return buffer;

}

function abrirPopVisu(campoatual, tabela) {

	window.open('visualizarpopup.php?campoatual=' + campoatual + '&tabela='
			+ tabela + '&id=' + $(campoatual).value, 'Busca',
			"height=600, width=550, scrollbars=yes, resizable=yes")

}

// /////////////////////////////////////////////

// /////////////// Inico Login ////////////////

// ///////////////////////////////////////////

var acaoLogin = '';

function valida_login(url, acao)

{
	acaoLogin = acao;

	var login = document.getElementById('form1').logina.value;
	var senha = document.getElementById('form1').senha.value;

	doAjax(url + "?login=" + login + "&acao=" + acao + "&senha=" + senha,
			'retorno_login', 2, 'lendo');

}

function retorno_login(xmlhttp) {
	executaScript(xmlhttp);

	if (acaoLogin == "senha") {
		if (xmlhttp == '1') {
			document.getElementById('div_ve').innerHTML = '<font color=green>Você será redirecionado!</font>';
			document.getElementById('form1').logina.disabled = true;
			document.getElementById('form1').senha.disabled = true;

			setTimeout("document.getElementById('form1').submit()", 1000);

		} else if (xmlhttp == '2') {
			document.getElementById('div_ve').innerHTML = '<font color=red>Usuário já logado!</font>';

		} else {

			document.getElementById('div_ve').innerHTML = '<font color=red>Usuário ou Senha Incorreta</font>';

		}

	}

}

// /////////////////////////////////////////////
// /////////////// Fim Login ////////////////
// ///////////////////////////////////////////

// /////////////////////////////////////////////
// //////////// Inicio Relat?rios /////////////
// ///////////////////////////////////////////

function abrirRelatorioClientes() {

	var filtro1 = radioInput.selecionaValor('filtro1');

	var filtro2 = $('filtro2').value;

	var filtro3 = $('filtro3').value;

	var filtro4 = $('edit_id_cidade').value;

	window.open('relatorios.php?cadastro=clientes&filtro1=' + filtro1
			+ '&filtro2=' + filtro2 + '&filtro3=' + filtro3 + '&filtro4='
			+ filtro4, "janelaRelatorios",
			"height=600, width=800, scrollbars=yes, resizable=yes");

}

function abrirRelatorioProducao() {
	var filtro1 = $('filtro1').value;
	window.open('relatorios.php?cadastro=producao&filtro1=' + filtro1,
			"janelaRelatorios", "height=600, width=" + jQuery(document).width()
					+ ", scrollbars=yes, resizable=yes");
}

function abrirRelatorioEstoqueAtual() {
	var filtro1 = $('filtro1').value;
	window.open('relatorios.php?cadastro=estoqueAtual&filtro1=' + filtro1,
			"janelaRelatorios",
			"height=600, width=800, scrollbars=yes, resizable=yes");
}

function abrirRelatorioCurvaABC() {

	var filtro1 = $('filtro1').value;
	var filtro2 = $('filtro2').value;
	var filtro3 = $('filtro3').value;

	window.open('relatorios.php?cadastro=curvaabc&filtro1=' + filtro1
			+ '&filtro2=' + filtro2 + '&filtro3=' + filtro3,
			"janelaRelatorios",
			"height=600, width=800, scrollbars=yes, resizable=yes");

}

function abrirRelatorioRepresentantes() {

	var filtro1 = $('filtro1').value;
	var filtro2 = $('filtro2').value;
	var filtro3 = $('filtro3').value;

	window.open('relatorios.php?cadastro=representantes&filtro1=' + filtro1
			+ '&filtro2=' + filtro2 + '&filtro3=' + filtro3,
			"janelaRelatorios",
			"height=600, width=800, scrollbars=yes, resizable=yes");

}

function abrirRelatorioFaturamento() {

	var filtro1 = radioInput.selecionaValor('filtro1');

	var filtro2 = $('filtro2').value;

	var filtro3 = $('filtro3').value;

	window.open('relatorios.php?cadastro=faturamento&filtro1=' + filtro1
			+ '&filtro2=' + filtro2 + '&filtro3=' + filtro3,
			"janelaRelatorios",
			"height=600, width=800, scrollbars=yes, resizable=yes");

}

function abrirRelatorioVendas() {

	var filtro1 = radioInput.selecionaValor('filtro1');

	var filtro2 = $('filtro2').value;

	var filtro3 = $('filtro3').value;

	var filtro4 = $('filtro4').value;

	window.open('relatorios.php?cadastro=vendas&filtro1=' + filtro1
			+ '&filtro2=' + filtro2 + '&filtro3=' + filtro3 + '&filtro4='
			+ filtro4, "janelaRelatorios",
			"height=600, width=800, scrollbars=yes, resizable=yes");

}

function abrirRelatorioEtiquetas() {

	window.open('rel_etiquetas_gerar.php', "janelaRelatorios",
			"height=600, width=800, scrollbars=yes, resizable=yes");

}

function abrirRelatorioFluxo() {

	window.open('relatorios.php?cadastro=fluxo', "janelaRelatorios",
			"height=600, width=800, scrollbars=yes, resizable=yes");

}

// ///////////////////////////////////////////

// ////////////// FIM Relat?rios /////////////

// ///////////////////////////////////////////

// /////////////////////////////////////////////

// /////////////// Inicio Pedidos /////////////

// ///////////////////////////////////////////

function excluirPedido(id) {

	doAjaxSemRetorno('ajax_com/pedidos_acao.php?acao=deletar&id=' + id, 1,
			'SaidaMain');

	refreshPedido();

	alert('Excluído com sucesso!');

}

function excluirItemPedido(id, idPedido) {

	if (confirm('Deseja deletar item do pedido?')) {

		doAjaxSemRetorno('ajax_com/pedidos_acao.php?acao=deletarItemPedido&id='
				+ id, 1, '');

		doAjaxSemRetorno('ajax_com/pedidos.php?acao=listarItens&idPedido='
				+ idPedido, 1, 'bodyID');

		alert('Excluído com sucesso!');

	}

}

function adicionarItemPedido(id, itemVerificar) {

	if (verificaPrecoEspecifico(itemVerificar)) {

		doAjaxSemRetorno('ajax_com/pedidos_acao.php?acao=adicionarItem&id='
				+ id, 1, '');

		doAjaxSemRetorno(
				'ajax_com/pedidos.php?acao=listarItens&idPedido=' + id, 1,
				'bodyID');

	}

}

function selecionaProdutoItenPedido(id, indice, idItem) {

	doAjaxSemRetorno('ajax_com/pedidos.php?acao=selecionaProduto&idProduto='
			+ id + '&indice=' + indice + '&idItem=' + idItem, 1, '');

	calculaPrecoPedido();

}

function salvaCampo(campo, valor, idItem, indice) {

	doAjaxSemRetorno('ajax_com/pedidos_acao.php?acao=salvarItem&indice='
			+ indice + '&campo=' + campo + '&valor=' + valor + '&idItem='
			+ idItem, 1, '');

}

function calculaPrecoPedido() {

	var somaQtd = 0, somaPreco = 0;

	/*
	 * var valor = $('valorComissao').value;
	 * 
	 * v = valor.replace(/\./g,"");
	 * 
	 * v = v.replace(/\,/g,".");
	 */

	var contI = $('totalItens').value;

	for (var i = 0; i < contI; i++) {

		var precoIten = $('preco' + i).value;

		precoIten = precoIten.replace(/\./g, "");

		precoIten = precoIten.replace(/\,/g, ".");

		somaQtd += parseInt($('qtd' + i).value);

		$('campoTotal_' + i).innerHTML = $('qtd' + i).value
				* parseFloat(precoIten);

		somaPreco += parseInt($('campoTotal_' + i).innerHTML);

		/*
		 * 
		 * //somaPreco += $('qtd'+i).value * $('preco'+i).value;
		 * 
		 * 
		 * 
		 * if($('tipoComissao1').checked == true){
		 * 
		 * $('campoTotal_'+i).innerHTML = ($('qtd'+i).value *
		 * $('preco'+i).value) - ( ( ($('preco'+i).value * v ) / 100) *
		 * $('qtd'+i).value );
		 * 
		 * somaPreco += parseFloat($('campoTotal_'+i).innerHTML);
		 * 
		 * }else{
		 * 
		 * $('campoTotal_'+i).innerHTML = ($('qtd'+i).value *
		 * $('preco'+i).value) - (v * $('qtd'+i).value );
		 * 
		 * somaPreco += parseFloat($('campoTotal_'+i).innerHTML);
		 *  }
		 */

	}

	$('qtdTotalItens').innerHTML = somaQtd;

	$('precoTotalItens').innerHTML = somaPreco;

}

function calculaPrecoPedidoTotal() {

	var somaPreco = 0;

	var valor = $('valorComissao').value;

	v = valor.replace(/\./g, "");

	v = v.replace(/\,/g, ".");

	for (var i = 0; i < $('totalItens').value; i++) {

		somaPreco += $('qtd' + i).value * $('preco' + i).value;

	}

	$('precoTotalItens').innerHTML = somaPreco;

	/*
	 * 
	 * if($('tipoComissao1').checked == true){
	 * 
	 * $('precoTotalItens').innerHTML = somaPreco - ( (somaPreco * v ) / 100);
	 * 
	 * }else{
	 * 
	 * $('precoTotalItens').innerHTML = somaPreco - v;
	 *  }
	 */

}

function salvaPedido(idPedido, status) {

	if (confirm('Deseja salvar o Pedido?')) {

		if ((status == 4 || status == 5)
				&& !confirm('Pedido fechado, certeza que deseja alterar?')) {

			return;

		}

		if (formm.verificaF(this.id, 'erroForm', 'erro')) {

			if (verificaPreco()) {
				doAjaxSemRetorno(
						'ajax_com/pedidos_acao.php?acao=salvarPedido&tipo_entrega='
								+ $('tipoentrega').value + '&obs='
								+ $('obs').value + '&codigo='
								+ $('codigo').value + '&status='
								+ $('status').value + '&clientes='
								+ $('clientes').value + '&representantes='
								+ $('representantes').value + '&idPedido='
								+ idPedido + '&formaPagamento='
								+ $('formapagamento').value + '&imposto='
								+ $('imposto').value + '&valorEntrega='
								+ $('valorEntrega').value + '&comissao='
								+ $('comissao').value + '&dataimposto='
								+ $('dataimposto').value, 1, 'bodyID');

				doAjaxSemRetorno(
						'ajax_com/pedidos.php?acao=listarItens&idPedido='
								+ idPedido, 1, 'bodyID');

				doAjaxSemRetorno('ajax_com/pedidos.php?acao=listar&clientes='
						+ $('clientesBusca').value + '&status='
						+ $('statusBusca').value, 1, 'SaidaMain');

				alert('Salvo com sucesso!');

			}

		}

	}

}

function verificaPreco() {

	var contI = $('totalItens').value;

	for (var i = 0; i < contI; i++) {

		var precoIten = $('preco' + i).value;

		if (precoIten == '0,00') {

			if (confirm('Este produto é garantia?')) {

				return true;

			} else {

				$('preco' + i).focus();

				return false;

			}

		}

	}

	return true;

}

function verificaPrecoEspecifico(valorItem) {

	if (valorItem >= 0) {

		var precoIten = $('preco' + valorItem).value;

		if (precoIten == '0,00') {

			if (confirm('Este produto é garantia?')) {

				return true;

			} else {

				$('preco' + valorItem).focus();

				return false;

			}

		}

	}

	return true;

}

function fecharPedido(idPedido, status) {

	if (confirm('Deseja realmente enviar para separação?\nOperação não pode ser cancelada posteriormente!')) {

		if (status != 5) {

			if (status != 4) {

				if (status == 1) {

					doAjaxSemRetorno(
							'ajax_com/pedidos_acao.php?acao=fecharPedido&id='
									+ idPedido, 1, '');
					doAjaxSemRetorno('ajax_com/pedidos.php?acao=listar', 1,
							'SaidaMain');

				} else {

					alert('Status do pedido deve estar Aberto para poder ser fechado.');

				}

			} else {

				alert('Pedido já separando!');

			}

		} else {

			alert('Pedido já enviado!');

		}

	}

}

function enviarPedido(idPedido, status) {

	if (confirm('Deseja realmente mudar status do pedido para enviado?\nOperação não pode ser cancelada posteriormente!')) {

		if (status != 5) {

			if (status == 6) {

				doAjaxSemRetorno(
						'ajax_com/pedidos_acao.php?acao=enviarPedido&id='
								+ idPedido, 1, '');
				doAjaxSemRetorno('ajax_com/pedidos.php?acao=listar', 1,
						'SaidaMain');

			} else {

				alert('Status do pedido deve estar Separado para poder ser alterado para enviado.\nFeche todas separações na tela de Ordem de Separação!');

			}

		} else {

			alert('Pedido já enviado!');

		}

	}

}

function pegaRepresentantePedido(cliente) {

	doAjax('ajax_com/pedidos_acao.php?acao=pegarRepresentanteCliente&cliente='
			+ cliente, 'retornoPegaRepresentantePedido', 0, '');

}

function retornoPegaRepresentantePedido(retorno) {

	selectInput.selecionaValor(retorno, 'representantes');

}

function pegaDadosClientePedido(cliente) {

	window.setTimeout("pegaDadosClientePedidoTime('" + cliente + "')", 2000);

}

function pegaDadosClientePedidoTime(cliente) {

	doAjax('ajax_com/pedidos_acao.php?acao=pegarDadosClientes&cliente='
			+ cliente, 'retornoPegaDadosClientePedido', 0, '');

}

function retornoPegaDadosClientePedido(retorno) {

	$('dadosClientes').innerHTML = retorno;

}

function enviarEmailPedido(idPedido, idCliente) {

	window
			.open('enviarEmail.php?tipo=fluxo&id=' + idPedido + '&idCliente='
					+ idCliente, 'Email',
					'height = 200, width = 300, location = no, toolbar = no, menubar=no')

}

function impressaoPedido(idPedido) {

	window.open('impressao.php?cadastro=pedido&id=' + idPedido, 'Email',
			"height=600, width=850, scrollbars=yes, resizable=yes")

}

function refreshPedido() {

	doAjaxSemRetorno('ajax_com/pedidos.php?acao=listar&clientes='
			+ $('clientesBusca').value + '&status=' + $('statusBusca').value
			+ '&dataIni=' + $('dataIni').value + '&dataFim='
			+ $('dataFim').value + '&codigo=' + $('codigoBusca').value
			+ '&dataEnvioIni=' + $('dataEnvioIni').value + '&dataEnvioFim='
			+ $('dataEnvioFim').value, 1, 'SaidaMain');

}

// /////////////////////////////////////////////

// /////////////// Fim Pedidos ////////////////

// ///////////////////////////////////////////

function enviarEmail(id, tipo, email) {

	doAjaxSemRetorno('ajax_com/enviarEmail.php?id=' + id + '&tipo=' + tipo
			+ '&email=' + email, 1, 'Saida');

	alert('Enviado com sucesso')

	window.close();

}

// /////////////////////////////////////////////

// /////////////// Inicio ESTOQUE /////////////

// ///////////////////////////////////////////

function refreshEstoque() {

	doAjaxSemRetorno('ajax_com/estoque.php?acao=listar&produto='
			+ $('produtoBusca').value + '&tipo=' + $('tipoBusca').value
			+ '&dataIni=' + $('dataIni').value + '&dataFim='
			+ $('dataFim').value, 1, 'Saida');

}

function salvaEstoque() {

	if (confirm('Deseja salvar?')) {

		if (formm.verificaF(this.id, 'erroForm', 'erro')) {

			doAjaxSemRetorno('ajax_com/estoque_acao.php?acao=salvar&descricao='
					+ $('descricao').value + '&produto=' + $('produto').value
					+ '&id=' + $('id').value + '&tipo=' + $('tipo').value
					+ '&qtd=' + $('qtd').value + '&preco=' + $('preco').value
					+ '&data=' + $('data').value, 1, '');

			refreshEstoque();

			addPop_close();

			alert('Salvo com sucesso!');

		}

	}

}

function excluirEstoque(id) {

	doAjaxSemRetorno('ajax_com/estoque_acao.php?acao=deletar&id=' + id, 1, '');

	refreshEstoque();

	alert('Excluído com sucesso!');

}

// /////////////////////////////////////////////

// /////////////// Fim Estoque ////////////////

// ///////////////////////////////////////////

// /////////////////////////////////////////////

// //////////// Inicio Ordem Producao//////////

// ///////////////////////////////////////////

function refreshOrdemProducao() {

	doAjaxSemRetorno('ajax_com/ordem_producao.php?acao=listar&produto='
			+ $('produtoBusca').value + '&pedido=' + $('pedidoBusca').value
			+ '&dataIni=' + $('dataIni').value + '&dataFim='
			+ $('dataFim').value, 1, 'Saida');

}

function salvaOrdemProducao() {

	if (confirm('Deseja salvar?')) {

		if (formm.verificaF(this.id, 'erroForm', 'erro')) {

			doAjaxSemRetorno(
					'ajax_com/ordem_producao_acao.php?acao=salvar&descricao='
							+ $('descricao').value + '&produto='
							+ $('produto').value + '&id=' + $('id').value
							+ '&pedido=' + $('pedido').value + '&qtd='
							+ $('qtd').value + '&data=' + $('data').value, 1,
					'');

			refreshOrdemProducao();

			addPop_close();

			alert('Salvo com sucesso!');

		}

	}

}

function excluirOrdemProducao(id, status) {

	if (status != 2) {

		doAjaxSemRetorno('ajax_com/ordem_producao_acao.php?acao=deletar&id='
				+ id, 1, '');

		refreshOrdemProducao();

		alert('Excluío com sucesso!');

	} else {

		alert('Ordem já fechado!');

	}

}

function fecharOrdemProducao(id, status) {

	if (status != 2) {

		if (status == 1) {
			if (confirm('Deseja Alterar ordem para Produzindo?')) {
				doAjaxSemRetorno(
						'ajax_com/ordem_producao_acao.php?acao=produzirOrdem&id='
								+ id, 1, '');
				refreshOrdemProducao();
			}
		} else if (status == 4) {
			if (confirm('Deseja realmente fechar Ordem?\nIr? ser dada entrada no estoque\nOperação não pode ser cancelada posteriormente!')) {
				doAjaxSemRetorno(
						'ajax_com/ordem_producao_acao.php?acao=fecharOrdem&id='
								+ id, 1, '');
				refreshOrdemProducao();
			}
		} else {

			alert('Status da ordem de produção deve estar A fabricar para poder ser fechado.');

		}

	} else {

		alert('Ordem já fechado!');

	}

}

// /////////////////////////////////////////////

// /////////// Fim Ordem Producao /////////////

// ///////////////////////////////////////////

// ///////////////////////////////////////////

// //////////// Inicio Ordem Separacao//////////

// ///////////////////////////////////////////

function refreshOrdemSeparacao() {

	doAjaxSemRetorno('ajax_com/ordem_separacao.php?acao=listar&produto='
			+ $('produtoBusca').value + '&pedido=' + $('pedidoBusca').value
			+ '&dataIni=' + $('dataIni').value + '&dataFim='
			+ $('dataFim').value, 1, 'Saida');

}

function salvaOrdemSeparacao() {

	if (confirm('Deseja salvar?')) {

		if (formm.verificaF(this.id, 'erroForm', 'erro')) {

			doAjaxSemRetorno(
					'ajax_com/ordem_separacao_acao.php?acao=salvar&descricao='
							+ $('descricao').value + '&produto='
							+ $('produto').value + '&id=' + $('id').value
							+ '&pedido=' + $('pedido').value + '&qtd='
							+ $('qtd').value + '&data=' + $('data').value, 1,
					'');

			refreshOrdemSeparacao();

			addPop_close();

			alert('Salvo com sucesso!');

		}

	}

}

function excluirOrdemSeparacao(id, status) {

	if (status != 2) {

		doAjaxSemRetorno('ajax_com/ordem_separacao_acao.php?acao=deletar&id='
				+ id, 1, '');

		refreshOrdemSeparacao();

		alert('Excluío com sucesso!');

	} else {

		alert('Ordem já fechado!');

	}

}

function fecharOrdemSeparacao(id, status) {
	if (status != 2) {
		if (status == 1) {
			if (confirm('Deseja realmente fechar?\nIrá ser dada saida no estoque')) {
				doAjaxSemRetorno(
						'ajax_com/ordem_separacao_acao.php?acao=fecharOrdem&id='
								+ id, 1, '');
				refreshOrdemSeparacao();
			}
		}
	} else {
		alert('Ordem já fechada!');
	}
}

function cancelarOrdemSeparacao(id, status) {
	if (status == 2) {
		if (confirm('Deseja realmente cancelar Separação?\nIrá ser dada entrada no estoque')) {
			doAjaxSemRetorno(
					'ajax_com/ordem_separacao_acao.php?acao=cancelarOrdem&id='
							+ id, 1, '');
			refreshOrdemSeparacao();
		}
	}

}

// /////////////////////////////////////////////

// /////////// Fim Ordem Separacao /////////////

// ///////////////////////////////////////////

// /////////////////////////////////////////////

// /////////////// Inicio Fluxo /////////////

// ///////////////////////////////////////////

function refreshFluxo() {

	doAjaxSemRetorno('ajax_com/fluxo.php?acao=listar&cliente='
			+ $('clienteBusca').value + '&tipo=' + $('tipoBusca').value
			+ '&tipoFluxo=' + $('tipoFluxoBusca').value + '&dataIni='
			+ $('dataIni').value, 1, 'Saida');

}

function excluirFluxo(id) {

	doAjaxSemRetorno('ajax_com/fluxo_acao.php?acao=deletar&id=' + id, 1, '');
	refreshFluxo();
	alert('Excluído com sucesso!');

}

// /////////////////////////////////////////////

// /////////////// Fim Fluxo ////////////////

// ///////////////////////////////////////////

// /////////////////////////////////////////////

// /////////////// Inicio Fluxo Banco /////////////

// ///////////////////////////////////////////

function refreshFluxoBanco() {

	doAjaxSemRetorno('ajax_com/fluxoBanco.php?acao=listarBancos&tipo='
			+ $('tipoBusca').value + '&tipoFluxo=' + $('tipoFluxoBusca').value
			+ '&dataIni=' + $('dataIni').value, 1, 'Saida');

}

function refreshFluxoBancoFluxo(idBanco) {

	doAjaxSemRetorno('ajax_com/fluxoBanco.php?acao=listar&idBanco=' + idBanco
			+ '&tipo=' + $('tipoBusca').value + '&tipoFluxo='
			+ $('tipoFluxoBusca').value + '&dataIni=' + $('dataIni').value, 1,
			'Saida');

}

function salvarFluxoBanco(idFluxo) {

	if (confirm('Deseja salvar?')) {

		if (formm.verificaF(this.id, 'erroForm', 'erro')) {

			doAjaxSemRetorno('ajax_com/fluxoBanco_acao.php?acao=salvar&id='
					+ $('id').value + '&idBanco=' + $('banco').value + '&tipo='
					+ $('tipo').value + '&tipoFluxo=' + $('tipoFluxo').value
					+ '&ocorrencia=' + $('ocorrencia').value + '&valor='
					+ $('valor').value + '&data=' + $('data').value
					+ '&numeroDoc=' + $('numero_doc').value, 1, '');

			refreshFluxoBancoFluxo($('idBanco').value);

			addPop_close();

			alert('Salvo com sucesso!');

		}

	}

}

function excluirFluxoBanco(id, idBanco) {

	doAjaxSemRetorno('ajax_com/fluxoBanco_acao.php?acao=deletar&id=' + id, 1,
			'');

	refreshFluxoBancoFluxo(idBanco);

	alert('Excluído com sucesso!');

}

function pagarBanco(id, idBanco) {
	if (confirm('Deseja Pagar?')) {
		var valorP = prompt('Adicionar alguma informação adicional ?');
		doAjaxSemRetorno('ajax_com/fluxoBanco_acao.php?acao=pagar&id=' + id
				+ '&info=' + valorP, 1, '');
		refreshFluxoBancoFluxo(idBanco);
	}
}

// /////////////////////////////////////////////

// /////////////// Fim Fluxo Banco ////////////////

// ///////////////////////////////////////////

// /////////////////////////////////////////////
// /////////////// Inicio Contas Receber /////////////
// ///////////////////////////////////////////

function refreshContasReceber() {
	doAjaxSemRetorno('ajax_com/contas_receber.php?acao=listar', 1, 'Saida');
}

function cancelarContasReceber(id) {
	doAjaxSemRetorno('ajax_com/contas_receber_acao.php?acao=cancelar&id=' + id,
			1, '');
	refreshContasReceber();
	alert('Cancelado com sucesso!');
}

function salvarContasReceber(idFluxo) {
	if (confirm('Deseja salvar?')) {
		// radioInput.selecionaValor('filtro1');
		if (formm.verificaF(this.id, 'erroForm', 'erro')) {
			doAjaxSemRetorno('ajax_com/fluxo_acao.php?acao=salvar&cliente='
					+ $('clientes').value + '&id=' + $('id').value + '&banco='
					+ $('banco').value + '&tipo=' + $('tipo').value
					+ '&tipoFluxo=' + $('tipoFluxo').value + '&ocorrencia='
					+ $('ocorrencia').value + '&valor=' + $('valor').value
					+ '&data=' + $('data').value + '&statusFluxo='
					+ $('statusFluxo').value, 1, '');
			refreshContasReceber();
			addPop_close();
			alert('Salvo com sucesso!');
		}
	}
}

// /////////////////////////////////////////////
// /////////////// Fim Contas Receber ////////////////
// ///////////////////////////////////////////

// /////////////////////////////////////////////
// /////////////// Inicio Contas Pagar /////////////
// ///////////////////////////////////////////

function refreshContasPagar() {
	doAjaxSemRetorno('ajax_com/contas_pagar.php?acao=listar', 1, 'Saida');
}

function excluirContasPagar(id) {
	doAjaxSemRetorno('ajax_com/contas_receber_acao.php?acao=cancelar&id=' + id,
			1, '');
	refreshContasPagar();
	alert('Cancelado com sucesso!');
}

function salvarContasPagar(idFluxo) {
	if (confirm('Deseja salvar?')) {
		if (formm.verificaF(this.id, 'erroForm', 'erro')) {
			doAjaxSemRetorno('ajax_com/fluxo_acao.php?acao=salvar&banco='
					+ $('banco').value + '&id=' + $('id').value
					+ '&fornecedor=' + $('fornecedor').value + '&tipo='
					+ $('tipo').value + '&tipoFluxo=' + $('tipoFluxo').value
					+ '&ocorrencia=' + $('ocorrencia').value + '&valor='
					+ $('valor').value + '&data=' + $('data').value
					+ '&statusFluxo=' + $('statusFluxo').value, 1, '');
			refreshContasPagar();
			addPop_close();
			alert('Salvo com sucesso!');
		}
	}
}

// /////////////////////////////////////////////
// /////////////// Fim Contas Pagar ////////////////
// ///////////////////////////////////////////

// /////////////////////////////////////////////

// /////////////// Inicio Composicao /////////////

// ///////////////////////////////////////////

function refreshComposicao(id) {

	doAjaxSemRetorno('ajax_com/composicao.php?acao=listar&id=' + id
			+ '&itensBusca=' + $('itensBusca').value, 1, 'Saida');

}

function salvaComposicao() {

	if (confirm('Deseja salvar?')) {

		if (formm.verificaF(this.id, 'erroForm', 'erro')) {

			doAjaxSemRetorno(
					'ajax_com/composicao_acao.php?acao=salvar&descricao='
							+ $('descricao').value + '&produto='
							+ $('produto').value + '&id=' + $('id').value
							+ '&qtd=' + $('qtd').value + '&idComposicao='
							+ $('idComposicao').value, 1, '');

			refreshComposicao($('id').value);

			addPop_close();

			alert('Salvo com sucesso!');

		}

	}

}

function excluirComposicao(id, idpai) {

	doAjaxSemRetorno('ajax_com/composicao_acao.php?acao=deletar&id=' + id, 1,
			'');

	refreshComposicao(idpai);

	alert('Excluído com sucesso!');

}

// /////////////////////////////////////////////

// /////////////// Fim Composicao ////////////////

// ///////////////////////////////////////////

// /////////////////////////////////////////////

// /////////////// Inicio Compras /////////////

// ///////////////////////////////////////////

function excluirCompraCotacao(id) {

	doAjaxSemRetorno('ajax_com/compras_acao.php?acao=deletar&id=' + id, 1,
			'SaidaMain');

	refreshCotacao();

	alert('Excluído com sucesso!');

}

function excluirCompraCompra(id) {

	doAjaxSemRetorno('ajax_com/compras_acao.php?acao=deletar&id=' + id, 1,
			'SaidaMain');

	refreshCompra();

	alert('Excluído com sucesso!');

}

function excluirItemCompra(id, idCompra) {

	if (confirm('Deseja deletar item?')) {

		doAjaxSemRetorno('ajax_com/compras_acao.php?acao=deletarItemCompra&id='
				+ id, 1, '');

		doAjaxSemRetorno('ajax_com/compras.php?acao=listarItens&idCompra='
				+ idCompra, 1, 'bodyID');

		alert('Excluído com sucesso!');

	}

}

function excluirFormaPgtoCompra(id, idCompra) {

	if (confirm('Deseja deletar?')) {

		doAjaxSemRetorno('ajax_com/compras_acao.php?acao=deletarFormaPgto&id='
				+ id, 1, '');

		doAjaxSemRetorno('ajax_com/compras.php?acao=listarItens&idCompra='
				+ idCompra, 1, 'bodyID');

		alert('Excluído com sucesso!');

	}

}

function salvaCampoCompra(campo, valor, idItem, indice) {

	doAjaxSemRetorno('ajax_com/compras_acao.php?acao=salvarItem&indice='
			+ indice + '&campo=' + campo + '&valor=' + valor + '&idItem='
			+ idItem, 1, '');

}

function salvaCampoCompraFormaPgto(campo, valor, idItem, indice) {

	doAjaxSemRetorno('ajax_com/compras_acao.php?acao=salvarFormaPgto&indice='
			+ indice + '&campo=' + campo + '&valor=' + valor + '&idItem='
			+ idItem, 1, '');

}

function calculaPrecoCompraFormaPgto() {

	var somaPreco = 0;

	/*
	 * var valor = $('valorComissao').value;
	 * 
	 * v = valor.replace(/\./g,"");
	 * 
	 * v = v.replace(/\,/g,".");
	 */

	var contI = $('totalFormaPgto').value;

	for (var i = 0; i < contI; i++) {

		var precoIten = $('valor' + i).value;

		precoIten = precoIten.replace(/\./g, "");

		precoIten = precoIten.replace(/\,/g, ".");

		somaPreco += parseFloat(precoIten);

	}

	$('precoTotalForma').innerHTML = somaPreco;

}

function calculaPrecoCompra() {

	var somaQtd = 0, somaPreco = 0.0;

	/*
	 * var valor = $('valorComissao').value;
	 * 
	 * v = valor.replace(/\./g,"");
	 * 
	 * v = v.replace(/\,/g,".");
	 */

	var contI = $('totalItens').value;

	for (var i = 0; i < contI; i++) {

		var precoIten = $('preco' + i).value;

		precoIten = precoIten.replace(/\./g, "");

		precoIten = precoIten.replace(/\,/g, ".");

		somaQtd += parseInt($('qtd' + i).value);

		$('campoTotal_' + i).innerHTML = $('qtd' + i).value
				* parseFloat(precoIten);

		somaPreco += parseFloat($('campoTotal_' + i).innerHTML);

		/*
		 * 
		 * //somaPreco += $('qtd'+i).value * $('preco'+i).value;
		 * 
		 * 
		 * 
		 * if($('tipoComissao1').checked == true){
		 * 
		 * $('campoTotal_'+i).innerHTML = ($('qtd'+i).value *
		 * $('preco'+i).value) - ( ( ($('preco'+i).value * v ) / 100) *
		 * $('qtd'+i).value );
		 * 
		 * somaPreco += parseFloat($('campoTotal_'+i).innerHTML);
		 * 
		 * }else{
		 * 
		 * $('campoTotal_'+i).innerHTML = ($('qtd'+i).value *
		 * $('preco'+i).value) - (v * $('qtd'+i).value );
		 * 
		 * somaPreco += parseFloat($('campoTotal_'+i).innerHTML);
		 *  }
		 */

	}

	$('qtdTotalItens').innerHTML = somaQtd;

	var precoImposto = $('imposto').value.replace(/\./g, "");
	precoImposto = precoImposto.replace(/\,/g, ".");

	var precoDesc = $('desconto').value.replace(/\./g, "");
	precoDesc = precoDesc.replace(/\,/g, ".");

	$('precoTotalItens').innerHTML = parseFloat(somaPreco)
			+ parseFloat(precoImposto) - parseFloat(precoDesc);

}

function salvaCompra(idCompra, status, local) {

	if (confirm('Deseja salvar ?')) {

		if ((status == 1)
				&& !confirm('Está fechado, certeza que deseja alterar?')) {

			return;

		}

		if (formm.verificaF(this.id, 'erroForm', 'erro')) {

			doAjaxSemRetorno(
					'ajax_com/compras_acao.php?acao=salvarCompra&tipo_entrega=&obs='
							+ $('obs').value + '&codigo=' + $('codigo').value
							+ '&fornecedores=' + $('fornecedores').value
							+ '&idCompra=' + idCompra + '&imposto='
							+ $('imposto').value + '&desconto='
							+ $('desconto').value + '&tipoFluxo='
							+ $('tipoFluxo').value, 1, 'bodyID');

			doAjaxSemRetorno('ajax_com/compras.php?acao=listarItens&idCompra='
					+ idCompra, 1, 'bodyID');

			if (local == "cotacao") {
				doAjaxSemRetorno(
						'ajax_com/compras.php?acao=listarCotacao&fornecedores='
								+ $('fornecedoresBusca').value, 1, 'SaidaMain');
			} else {
				doAjaxSemRetorno(
						'ajax_com/compras.php?acao=listarCompras&fornecedores='
								+ $('fornecedoresBusca').value, 1, 'SaidaMain');
			}

			alert('Salvo com sucesso!');

		}

	}

}

function virarCompra(idCotacao) {

	if (confirm('Deseja realmente fechar cotacao e virar Compra?\nOperação não pode ser cancelada posteriormente!')) {

		doAjaxSemRetorno('ajax_com/compras_acao.php?acao=virarCompra&id='
				+ idCotacao, 1, '');

		doAjaxSemRetorno('ajax_com/compras.php?acao=listarCotacao', 1,
				'SaidaMain');

	}

}

function fecharCompra(idCompra, status) {

	if (confirm('Deseja realmente fechar compra?\nOperação não pode ser cancelada posteriormente!')) {

		if (status == 0) {
			if (confirm('Deseja lancar fluxo?')) {
				doAjaxSemRetorno(
						'ajax_com/compras_acao.php?acao=fecharCompra&fluxo=s&id='
								+ idCompra, 1, '');

				doAjaxSemRetorno('ajax_com/compras.php?acao=listarCompras', 1,
						'SaidaMain');
			} else {
				doAjaxSemRetorno(
						'ajax_com/compras_acao.php?acao=fecharCompra&fluxo=n&id='
								+ idCompra, 1, '');

				doAjaxSemRetorno('ajax_com/compras.php?acao=listarCompras', 1,
						'SaidaMain');
			}

		} else {

			alert('Status da compra deve estar Aberto para poder ser fechado.');

		}

	}

}

function selecionaProdutoItenCompra(id, indice, idItem) {

	doAjaxSemRetorno('ajax_com/compras.php?acao=selecionaProduto&idProduto='
			+ id + '&indice=' + indice + '&idItem=' + idItem, 1, '');

	calculaPrecoCompra();

}

function impressaoCompra(idCompra, tipo) {

	window.open('impressao.php?cadastro=compra&id=' + idCompra + '&tipo='
			+ tipo, 'Email',
			"height=600, width=850, scrollbars=yes, resizable=yes")

}

function refreshCotacao() {

	doAjaxSemRetorno('ajax_com/compras.php?acao=listarCotacao&fornecedores='
			+ $('fornecedoresBusca').value + '&dataIni=' + $('dataIni').value
			+ '&dataFim=' + $('dataFim').value + '&codigo='
			+ $('codigoBusca').value, 1, 'SaidaMain');

}

function refreshCompras() {

	doAjaxSemRetorno('ajax_com/compras.php?acao=listarCompras&fornecedores='
			+ $('fornecedoresBusca').value + '&dataIni=' + $('dataIni').value
			+ '&dataFim=' + $('dataFim').value + '&codigo='
			+ $('codigoBusca').value, 1, 'SaidaMain');

}

function adicionarItemCompra(id, itemVerificar) {

	doAjaxSemRetorno('ajax_com/compras_acao.php?acao=adicionarItem&id=' + id,
			1, '');

	doAjaxSemRetorno('ajax_com/compras.php?acao=listarItens&idCompra=' + id, 1,
			'bodyID');

}

function adicionarFormaPgtoCompra(id, itemVerificar) {

	doAjaxSemRetorno('ajax_com/compras_acao.php?acao=adicionarFormaPgto&id='
			+ id, 1, '');

	doAjaxSemRetorno('ajax_com/compras.php?acao=listarItens&idCompra=' + id, 1,
			'bodyID');

}

function pagarContasPagar(id) {
	if (confirm('Deseja Pagar?')) {
		doAjaxSemRetorno('ajax_com/contas_receber_acao.php?acao=pagar&id=' + id
				+ '&tipoPagamento='+ $('tipoPagamento').value + '&ocorrencia='+ $('ocorrencia').value  + '&valor='+ $('valor').value, 1, '');
		
		refreshContasPagar();
		addPop_close();
		alert('Salvo com sucesso!');
	}
}

function descontarContasPagar(id) {
	if (confirm('Deseja Descontar?')) {
		doAjaxSemRetorno('ajax_com/contas_receber_acao.php?acao=descontar&id='+ id 
				+ '&tipoPagamento='+ $('tipoPagamento').value + '&ocorrencia='+ $('ocorrencia').value  + '&valor='+ $('valor').value, 1, '');
		refreshContasPagar();
		
		refreshContasPagar();
		addPop_close();
		alert('Salvo com sucesso!');
	}
}


function pagarContasReceber(id) {
	if (confirm('Deseja Pagar?')) {
		doAjaxSemRetorno('ajax_com/contas_receber_acao.php?acao=pagar&id=' + id
				 + '&tipoPagamento='+ $('tipoPagamento').value + '&ocorrencia='+ $('ocorrencia').value  + '&valor='+ $('valor').value, 1, '');
		
		refreshContasReceber();
		addPop_close();
		alert('Salvo com sucesso!');
	}
}

function descontarContasReceber(id) {
	if (confirm('Deseja Descontar?')) {
		doAjaxSemRetorno('ajax_com/contas_receber_acao.php?acao=descontar&id=' + id
				+ '&tipoPagamento='+ $('tipoPagamento').value + '&ocorrencia='+ $('ocorrencia').value  + '&valor='+ $('valor').value, 1, '');
		
		refreshContasReceber();
		addPop_close();
		alert('Salvo com sucesso!');
	}
}

// /////////////////////////////////////////////

// /////////////// Fim Compras ////////////////

// ///////////////////////////////////////////

function abrirRelatorioFechamento() {
	main.openWindow('relatorios_fechamento.php?filtro1=' + $('filtro1').value
			+ '&filtro2=' + $('filtro2').value, '700', '500');
}

function abrirRelatorioDespesas() {
	main.openWindow('relatorios_despesas.php?filtro1=' + $('filtro1').value
			+ '&filtro2=' + $('filtro2').value, '700', '500');
}

function radioValue(radioButton) {

	var i;

	for (i = 0; i <= radioButton.length; i++) {

		if (radioButton[i].checked == true) {

			return radioButton[i].value;

		}// end if

	}// end for

	// if it didn't find anything, return the .value (behaviour of single radio
	// btn)

	return radioButton.value;

}// end function

function salvarUsuario() {

	if (confirm('Deseja salvar?')) {

		console.info( $('nome').value  )
		if (formm.verificaF(this.id, 'erroForm', 'erro')) {

			doAjaxSemRetorno('ajax_com/user_acao.php?acao=salvar'
					+ '&id=' + $('id').value 
					+ '&nome=' + $('nome').value 
					+ '&email=' + $('email').value
					+ '&login=' + $('login').value
						, 1, '');

			addPop_close();

			alert('Salvo com sucesso!');

		}
	}
}

function salvarUsuarioSenha() {

	if (confirm('Deseja salvar?')) {
		
		if( $('saveOK').value == 1 ){
			if (formm.verificaF(this.id, 'erroForm', 'erro')) {
	
				doAjaxSemRetorno('ajax_com/user_acao.php?acao=salvarSenha'
						+ '&id=' + $('id').value 
						+ '&senhaAntiga=' + $('senhaAntiga').value 
						+ '&senhaNova=' + $('senhaNova').value
							, 1, '');
	
				addPop_close();
	
				alert('Salvo com sucesso!');
	
			}
		}else{
			alert('Senhas devem ser iguais.');
		}
	}
}

function verificaSenhaIgual( field ){
	if( $('senhaNova1').value == field.value ){
		$('saveOK').value = '1';
	}else{
		alert('Senhas devem ser iguais.');
		$('saveOK').value = '0';
	}
}

jQuery(window).resize(function() {
	fixHeight();
});
jQuery(document).ready(function() {
	setTimeout("fixHeight()", 500);
	makeAnimationMenu();
});

function fixHeight() {
	var hei = jQuery(window).height();
	console.info("1")
	if ($("popup") != undefined) {
		jQuery("#header, #main-body").width(jQuery(window).width());
		console.info(jQuery(window).width())
	} else {
		jQuery("#wrapper").height(hei);

		jQuery("#header, #main-body").width((jQuery(document).width() - 100));

		jQuery("#Saida, #SaidaMain").height(
				(hei - 150) - jQuery("#busca").height());

		jQuery(".modal").height(hei);
		jQuery(".modal").width(jQuery(document).width());

		jQuery(".panel.pull-right").css("margin-top", (hei / 2) - 50);
	}

}

function makeAnimationMenu() {

	jQuery(".sidebar-collapse").mouseenter(function() {
		jQuery(".menu-submenu-nav").animate({
			'width' : "295px"
		}, 100, function() {

		});
	});

	jQuery(".navbar-default").mouseleave(function() {
		jQuery(".menu-submenu-nav").animate({
			'width' : "0px"
		}, 200, function() {
		});
	});

}

function changeMenu(id) {
	jQuery(".container").hide();
	jQuery("#menuFilho" + id).toggle();
}