const idSelect = "selectStatusComanda";
const idDivRecebimento = "divRecebimento";
const idCodigoConta = "inputCodigoConta";
const idCheckDinheiro = "checkDinheiro";
const idCheckCartao = "checkCartao";
const idCheckPix = "checkPix";
const idConjuntoDinheiro = "conjuntoDinheiro";
const idConjuntoCartao = "conjuntoCartao";
const idConjuntoPix = "conjuntoPix";
const idQuantiaDinheiro = "inputQuantiaDinheiro";
const idQuantiaCartao = "inputQuantiaCartao";
const idQuantiaPix = 'inputQuantiaPix';

function formularioComandasCompleto(json) {

    let configuracoes = JSON.parse(json);

    if (configuracoes != null) {
        let nulos = ""
        if (configuracoes.idBarraPesquisa == null) {
            nulos += "idBarraPesquisa\n";
        }
        if (configuracoes.idBotaoAdicionar == null) {
            nulos += "idBotaoAdicionar\n";
        }
        if (configuracoes.idMensagemErro == null) {
            nulos += "idMensagemErro\n";
        }
        if (configuracoes.idMostrarLista == null) {
            nulos += "idMostrarLista";
        }
        if (nulos != "") {
            throw "Os seguintes campos estão nulos: " + nulos;
        }
    } else {
        throw "As configurações do formulário estão nulas!"
    }

    let inputCodigoComanda = "";

    if (configuracoes.idComanda != null) {
        inputCodigoComanda = `<input id="codigoComanda" name="codigoComanda" type="hidden" value="` + configuracoes.idComanda + `">`;
    }

    const formularioComandasCompleto = document.getElementById("formularioComandasCompleto");
    formularioComandasCompleto.innerHTML = `<form id="formAdicionaItens" method="POST" action="" class="p-3">`
        + `<p>Itens</P>`
        + `<div class="input-group">`
        + `<input type="text" id="` + configuracoes.idBarraPesquisa + `" class="form-control form-control-lg col-sm-3 rounded-0 border-info fs-6" placeholder="Nome do produto" autocomplete="off">`
        + `<a id="` + configuracoes.idBotaoAdicionar + `" class="btn btn-info btn-lg rounded-0 btn-comandas">Adicionar</a>`
        + `</div>`
        + `<div class="col-sm-2 fs-6" style="position: absolute;" id="` + configuracoes.idMostrarLista + `">`
        + `</div>`
        + `<div class="col-12" id="` + configuracoes.idMensagemErro + `"></div>`
        + `</form>`
        + `<div class="container mb-3 mt-3">`
        + `<div class="position-relative col-sm-3 mx-auto">`
        + `<div id="tabelaItensComanda"></div>`
        + `</div>`
        + `</div>`
        + `</div>`
        + `<div class="position-relative col-sm-3 mx-auto">`
        + `<form id="formComandas" method="POST" action="camadaNegocios.php">`
        + inputCodigoComanda
        + `<input id="itensComandaCadastrar" name="itens" type="hidden">`
        + `<label for="`+ idSelect + `">Status:</label>`
        + `<select id="` + idSelect + `" name="status" onchange="mostrarRecebimento()">`
        + ` <option value="0">Aberta</option>`
        + ` <option value="1">Fechada</option>`
        + `</select>`

        + `<div id="` + idDivRecebimento + `" style="display: none">`

        + `<h2>Recebimento</h2>`
        + `<label for="` + idCodigoConta + `">Código da conta:</label> <input id="` + idCodigoConta + `" class="form-control" name="codigoConta" type="number" placeholder="Código da conta" min="0" max="99999999999">`


        + `<p><input type="checkbox" class="linhaCheckbox" id="` + idCheckDinheiro + `" onchange="mostrarQuantiaDinheiro()"><label for="` + idCheckDinheiro + `" class="linhaCheckbox">Dinheiro</label></p>`
        + `<p class="conjuntoQuantia" id="` + idConjuntoDinheiro + `"><label for="` + idQuantiaDinheiro +`">Quantia:</label> <input name="quantiaDinheiro" id="` + idQuantiaDinheiro +`" type="number" class="form-control" placeholder="Quantia de dinheiro" step="0.01" min="0" max="999999999.99" /></p>`

        + `<p><input type="checkbox" class="linhaCheckbox" id="` + idCheckCartao +  `" onchange="mostrarQuantiaCartao()"><label for="` + idCheckCartao +`" class="labelCheckbox">Cartão</label></p>`
        + `<p class="conjuntoQuantia" id="` + idConjuntoCartao + `"><label for="` + idQuantiaCartao + `">Quantia:</label> <input name="quantiaCartao" id="`+ idQuantiaCartao + `" type="number" class="form-control" placeholder="Quantia no cartão" step="0.01" min="0" max="999999999.99" /></p>`

        + `<p><input type="checkbox" class="linhaCheckbox" id="` + idCheckPix + `" onchange="mostrarQuantiaPix()"><label for="` + idCheckPix + `" class="linhaCheckbox">Pix</label></p>`
        + `<p class="conjuntoQuantia" id="` + idConjuntoPix + `"><label for="`+ idQuantiaPix + `">Quantia:</label> <input name="quantiaPix" id="` + idQuantiaPix + `" type="number" class="form-control" placeholder="Quantia no pix" step="0.01" min="0" max="999999999.99" /></p>`

        + `</div>`

        + `<div class="col-12"><input name="comandaSubmit" class="inputSubmit btn btn-large col-sm-15 btn-comandas mb-3" type="submit" value="Enviar" /></div>`
        + `</form>`
        + `</div>`
}

function mostrarRecebimento() {
    if (document.getElementById(idSelect).value == 0) {
        document.getElementById(idDivRecebimento).style.setProperty("display", "none");
        document.getElementById(idCodigoConta).value = "";
        document.getElementById(idCheckDinheiro).checked = false;
        mostrarQuantiaDinheiro();
        document.getElementById(idCheckCartao).checked = false;
        mostrarQuantiaCartao();
        document.getElementById(idCheckPix).checked = false;
        mostrarQuantiaPix();
    } else {
        document.getElementById(idDivRecebimento).style.setProperty("display", "block");
    }
}

function mostrarQuantiaDinheiro() {
    mostrarQuantia(idCheckDinheiro, idConjuntoDinheiro, idQuantiaDinheiro)
}

function mostrarQuantiaCartao() {
    mostrarQuantia(idCheckCartao, idConjuntoCartao, idQuantiaCartao)
}

function mostrarQuantiaPix() {
    mostrarQuantia(idCheckPix, idConjuntoPix, idQuantiaPix)
}

function mostrarQuantia(idCheckbox, idConjunto, idQuantia) {
    if (document.getElementById(idCheckbox).checked) {
        document.getElementById(idConjunto).style.setProperty("display", "block");
    } else {
        document.getElementById(idConjunto).style.setProperty("display", "none");
        document.getElementById(idQuantia).value = "";
    }
}