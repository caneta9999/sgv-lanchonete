let codigosProdutos = "";
let itensComanda = "";
let idLabelTotal = "";
let idInputEnvio = "";

//Transforma o codigosProdutos em uma array de objetos
function getArrayCodigosProdutos() {
    return JSON.parse(sessionStorage.getItem(codigosProdutos));
}

function setArrayCodigosProdutos(array) {
    sessionStorage.setItem(codigosProdutos, JSON.stringify(array));
}

function getArrayItensComanda() {
    return JSON.parse(sessionStorage.getItem(itensComanda));
}

//Transforma uma array de objetos no itensComanda, salvando no sessionStorage
function setArrayItensComanda(array) {
    sessionStorage.setItem(itensComanda, JSON.stringify(array));
}


function setArrayItensComanda(array, posicaoItemInserido) {
    array[posicaoItemInserido] = JSON.stringify(array[posicaoItemInserido]);
    sessionStorage.setItem(itensComanda, JSON.stringify(array));
}



//Pega a posicao do CodigoProduto no Array
function getPosicaoCodigoProduto(codigoProduto) {
    let arrayCodigosProdutos = getArrayCodigosProdutos();
    if (arrayCodigosProdutos != null) {
        for (let i = 0; i < arrayCodigosProdutos.length; i++) {
            if (codigoProduto == arrayCodigosProdutos[i]) {
                return i;
            }
        }
    }

    return null;
}

//Transforma um itemComanda em objeto pelo codigo do Produto
function getItemComanda(codigoProduto) {
    let arrayCodigosProdutos = getArrayCodigosProdutos();
    if (arrayCodigosProdutos != null) {
        posicaoCodigoProduto = getPosicaoCodigoProduto(codigoProduto)
        if (posicaoCodigoProduto != null) {
            return JSON.parse(getArrayItensComanda()[posicaoCodigoProduto])
        }
    }

    return null;
}

//Transforma um objeto em itemComanda e salva no sessionStorage
function setItemComanda(objetoItemComanda) {
    let arrayItensComanda = getArrayItensComanda();
    if (arrayItensComanda != null) {
        let velhoObjetoItemComanda = getItemComanda(objetoItemComanda.codigoProduto);
        if (velhoObjetoItemComanda != null) {
            let posicaoItemComandaNoArray = getPosicaoCodigoProduto(objetoItemComanda.codigoProduto);
            arrayItensComanda[posicaoItemComandaNoArray] = objetoItemComanda;
            setArrayItensComanda(arrayItensComanda, posicaoItemComandaNoArray);
        } else {
            throw "ItemComanda com o código " + objetoItemComanda.codigoProduto + " não encontrado";
        }
    } else {
        throw "Array com códigos dos produtos não encontrada";
    }
}

//Salva a quantidade no objeto
function salvarQuantidade(codigoProduto, quantidade) {
    let itemComandaModificado = getItemComanda(codigoProduto);
    if (itemComandaModificado != null) {
        itemComandaModificado.quantidade = quantidade;
        setItemComanda(itemComandaModificado)
    } else {
        throw "Produto " + codigoProduto + " não encontrado";
    }
}

//Para pegar o codigoProduto de um input
function getCodigoProduto(idInput) {
    return idInput.replace(/\D/g, "");
}

//Para pegar a quantidade de um input
function getQuantidade(idInput) {
    return document.getElementById(idInput).value;
}

function calcularTotal() {
    let total = 0;
    let arrayItensComanda = getArrayItensComanda();
    if (arrayItensComanda != null) {
        for (let i = 0; i < arrayItensComanda.length; i++) {
            let itemComandaAtual = JSON.parse(arrayItensComanda[i])
            let quantidade = itemComandaAtual.quantidade;
            let valor = itemComandaAtual.valorProduto;
            total += quantidade * valor
        }
        return total;
    } else {
        return 0;
    }

}

function atualizarValor(idEste, idValor, preco) {
    //Atualiza valor na tabela
    let valorFinal = (preco * document.getElementById(idEste).value).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
    document.getElementById(idValor).innerHTML = valorFinal;

    //Salva quantidade
    salvarQuantidade(getCodigoProduto(idEste), getQuantidade(idEste));

    //Atualiza Total
    document.getElementById(idLabelTotal).innerHTML = calcularTotal().toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });

    //Atualiza Input de Envio
    document.getElementById(idInputEnvio).value = stringFormulario()

}

function removerItemComanda(codigoProduto) {
    let arrayCodigosProdutos = getArrayCodigosProdutos();
    let arrayItensComanda = getArrayItensComanda();
    arrayCodigosProdutos.splice(getPosicaoCodigoProduto(codigoProduto), 1);
    arrayItensComanda.splice(getPosicaoCodigoProduto(codigoProduto), 1);
    setArrayCodigosProdutos(arrayCodigosProdutos);
    setArrayItensComanda(arrayItensComanda);

    tabelaItensComanda();
}

function configurarTabela(json) {
    let objetoVariaveisTabela = JSON.parse(json);

    codigosProdutos = objetoVariaveisTabela.codigosProdutos;
    itensComanda =  objetoVariaveisTabela.itensComanda;
    idLabelTotal = objetoVariaveisTabela.idLabelTotal;
    idInputEnvio = objetoVariaveisTabela.idInputEnvio;
}

function tabelaItensComanda() {

    const tabelaComandas = document.getElementById("tabelaItensComanda");

    let arrayItensComanda = getArrayItensComanda();

    let linhasDaTabela = "";

    if (arrayItensComanda != null) {
        for (let i = 0; i < arrayItensComanda.length; i++) {
            let objetoAtual = JSON.parse(arrayItensComanda[i]);
            let subtotal = (objetoAtual.valorProduto * objetoAtual.quantidade).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' })

            let stringAtualizarValor = "atualizarValor("
                + "`inputItem" + objetoAtual.codigoProduto + "`,"
                + "`valorItem" + objetoAtual.codigoProduto + "`,"
                + objetoAtual.valorProduto
                + ")"

            linhasDaTabela += ""
                + "<tr class='table-secondary'>"
                + "   <td class='table-secondary'><button type='button' class='btn-close' aria-label='Close' onclick='removerItemComanda(" + objetoAtual.codigoProduto + ")'></button></td>"
                + "   <td class='table-secondary'>" + objetoAtual.nomeProduto + "</td>"
                + "   <td class='table-secondary'>"
                + "       <input id='inputItem" + objetoAtual.codigoProduto + "' type='number' class='bootstrapSpinner' value='" + objetoAtual.quantidade + "' min='1' max='100' step='1'"
                + " onchange='" + stringAtualizarValor + "'></td>"
                + "   <td class='table-secondary'>"
                + "     <p id='valorItem" + objetoAtual.codigoProduto + "'>" + subtotal + "</p>"
                + "   </td>"
                + " </tr>"
        }
    }

    let linhaTotal = "<tr class='table-secondary'>"
        + "   <td class='table-secondary'></td>"
        + "   <td class='table-secondary'></td>"
        + "   <td class='table-secondary'><p>Total: </p></td>"
        + "   <td class='table-secondary'><p id='" + idLabelTotal + "'>" + calcularTotal().toLocaleString('pt-br', { style: 'currency', currency: 'BRL' }) + "</p></td>"
        + " </tr>"


    tabelaComandas.innerHTML = "<table class='table'>"
        + "<tr class='table-secondary'>"
        + "<th></th>"
        + "<th>Nome</th>"
        + "<th>Quantidade</th>"
        + " <th>Subtotal</th>"
        + "</tr>"
        + "<tbody>"
        + linhasDaTabela
        + linhaTotal
        + "</tbody>"
        + "</table>"

    $(".bootstrapSpinner").inputSpinner();

    document.getElementById(idInputEnvio).value = stringFormulario();

    return tabelaComandas;

}

function stringFormulario() {
    let envio = "";
    let arrayItensComanda = getArrayItensComanda();
    if (arrayItensComanda != null) {
        for (let i = 0; i < arrayItensComanda.length; i++) {
            let objetoAtual = JSON.parse(arrayItensComanda[i]);
            envio += objetoAtual.codigoProduto + ";"
            envio += objetoAtual.quantidade
            if (i != arrayItensComanda.length - 1) {
                envio += " "
            }
        }
    }
    return envio
}