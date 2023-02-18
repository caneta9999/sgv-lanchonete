//Pesquisa Produto no Servidor
function pesquisarProduto(idBarraPesquisa, idMostrarLista) {
  $("#" + idBarraPesquisa).keyup(function () {
    let searchText = $(this).val();
    if (searchText != "") {
      $.ajax({
        url: "../../../php/autocomplete.php",
        method: "post",
        data: {
          query: searchText,
        },
        success: function (response) {
          $("#" + idMostrarLista).html(response);
        },
      });
    } else {
      $("#" + idMostrarLista).html("");
    }
  });
}

// Coloca o texto pesquisado no campo de texto
function inserirTextoBarra(idBarraPesquisa, idMostrarLista) {
  $(document).on("click", ".anchorOpcoes", function () {
    $("#" + idBarraPesquisa).val($(this).text());
    $("#" + idMostrarLista).html("");
  });
}

//Adiciona o item na tabela
function adicionarItemTabela(idBarraPesquisa, idBotaoAdicionar, idErro, idMostrarLista, stringVarItensComanda, stringVarCodigosProdutos) {
  $("#" + idBotaoAdicionar).on("click", function () {
    let itemAdicionar = $("#" + idBarraPesquisa).val();
    if (itemAdicionar != "") {
      $.ajax({
        url: "../../../php/inserirItemComanda.php",
        method: "post",
        data: {
          query: itemAdicionar,
        },
        success: function (response) {

          //Variável de sessão que guarda os itens da comanda. Se não existir, é criada
          if (sessionStorage.getItem(stringVarItensComanda) == null) {
            sessionStorage.setItem(stringVarItensComanda, '[]');
          }

          //Variável de sessão que guarda os códigos de itens da comanda. Necessário para a exclusão
          if (sessionStorage.getItem(stringVarCodigosProdutos) == null) {
            sessionStorage.setItem(stringVarCodigosProdutos, '[]');
          }


          if (response.replace(/\s/g, "") !== "ERRO") {
            let itensAntigos = JSON.parse(sessionStorage.getItem(stringVarItensComanda));
            let codigosItensAntigos = JSON.parse(sessionStorage.getItem(stringVarCodigosProdutos));
            let adicionarNovoItem = true;

            //Verifica se o valor já existe antes de adicionar
            for (i = 0; i < itensAntigos.length; i++) {
              let itemAtual = JSON.parse(itensAntigos[i]);
              let itemNovo = JSON.parse(response);
              if (itemAtual.codigoProduto == itemNovo.codigoProduto) {
                adicionarNovoItem = false;
                let objetoErro = document.getElementById(idErro);
                objetoErro.innerHTML = "<p class='text-danger'>Produto já foi adicionado antes!</p>"
                break;
              }
            }

            //Adiciona o novo item, se não existir ainda na lista
            if (adicionarNovoItem) {
              let objetoErro = document.getElementById(idErro);
              objetoErro.innerHTML = ""  
              itensAntigos.push(response);
              codigosItensAntigos.push(JSON.parse(response).codigoProduto);
              sessionStorage.setItem(stringVarItensComanda, JSON.stringify(itensAntigos));
              sessionStorage.setItem(stringVarCodigosProdutos, JSON.stringify(codigosItensAntigos));
            }
          } else {
            let objetoErro = document.getElementById(idErro);
            objetoErro.innerHTML = "<p class='text-danger'>Esse produto não está cadastrado!</p>"
          }

          document.getElementById(idMostrarLista).innerHTML = "";
          tabelaItensComanda();
          $("#" + idBarraPesquisa).val("");
        },
      })
    }
  })
}