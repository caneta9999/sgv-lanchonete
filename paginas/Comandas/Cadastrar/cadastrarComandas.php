<?php
session_start();
if (!isset($_SESSION['login'])) {
  header('location:../../Login/login.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../../css/index.css" />
  <title>Sistema de Gerenciamento de Vendas da Lanchonete</title>
  <style>
    .linhaCheckbox {
      display: inline-block;
    }

    .conjuntoQuantia {
      display: none;
    }
  </style>
  <!--Bootstrap -->
  <link rel="stylesheet" href="../../../bootstrap/css/bootstrap.css">

  <!--Componentes -->
  <script type="module" src="../../../js/componentesPadrao.js"></script>

</head>

<body>
  <?php
  require "../../../CamadaDados/conectar.php";
  $tb = "Produto";
  $result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb";
  $select_msg_cont = $conx->prepare($result_msg_cont);
  $select_msg_cont->execute();
  $select_msg_cont = $select_msg_cont->fetchAll();
  $quantidadeProdutos = 0;
  foreach ($select_msg_cont as $linha_array) {
    $quantidadeProdutos = $linha_array['quantidade'];
  }

  $tb2 = "Conta";
  $result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb2";
  $select_msg_cont = $conx->prepare($result_msg_cont);
  $select_msg_cont->execute();
  $select_msg_cont = $select_msg_cont->fetchAll();
  $quantidadeContas = 0;
  foreach ($select_msg_cont as $linha_array) {
    $quantidadeContas = $linha_array['quantidade'];
  }

  if ($quantidadeProdutos > 0 and $quantidadeContas > 0) {
    echo '<div class="divCadastros">
    <div id="navbar"></div>
    <h1 class="titulos">Cadastrar comanda</h1>
    <input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = \'../indexComandas.php\'">
    <br />

    <div id="formularioComandasCompleto"></div>

  </div>
  
  <script src="../../../js/jquery-3.6.0.min.js"></script>

  <!--Formulário de Comandas -->
  <script src="../../../js/Comandas/formularioComandasCompleto.js"></script>

  <!--Funções de Comandas -->
  <script src="../../../js/Comandas/funcoesPesquisa.js"></script>

  <!--Tabela de Comandas -->
  <script src="../../../js/Comandas/tabelaItensComanda.js"></script>


  <script>
    $(document).ready(function() {
      //Prepara o json de configuração do formularo
      let configuracoesFormulario = {
        idBarraPesquisa: \'barraPesquisaProduto\',
        idBotaoAdicionar: \'btnAdicionar\',
        idMensagemErro: \'mensagemErro\',
        idMostrarLista: \'mostrarLista\'
      }

      //Desenha o formulário de comandas
      formularioComandasCompleto(JSON.stringify(configuracoesFormulario));

      //Prepara o json de configuração da tabela
      let configuracoesTabela = {
        codigosProdutos: "codigosProdutos",
        itensComanda: "itensComanda",
        idLabelTotal: "labelTotal",
        idInputEnvio: "itensComandaCadastrar"
      };

      //Configura a tabela
      configurarTabela(JSON.stringify(configuracoesTabela));

      //Desenha a tabela
      tabelaItensComanda()
      
      //Mostrar Lista
      pesquisarProduto(configuracoesFormulario.idBarraPesquisa, configuracoesFormulario.idMostrarLista)

      //Inserir texto na barra de pesquisa
      inserirTextoBarra(configuracoesFormulario.idBarraPesquisa, configuracoesFormulario.idMostrarLista)

      //Inserir item na tabela
      adicionarItemTabela(configuracoesFormulario.idBarraPesquisa, configuracoesFormulario.idBotaoAdicionar, 
      configuracoesFormulario.idMensagemErro, configuracoesFormulario.idMostrarLista, configuracoesTabela.itensComanda, configuracoesTabela.codigosProdutos)

    
    });
  </script>

  <!-- //Para o spinner com mais e com menos -->
  <script src="../../../js/bootstrap-input-spinner.js"></script>
  <script>
    $(".bootstrapSpinner").inputSpinner();
  </script>';
  } else {
    $mensagem = "";
    if ($quantidadeProdutos == 0) {
      $mensagem .= "<p class='text-danger'>Antes de cadastrar comandas, é necessário ter pelo menos um produto cadastrado!</p>";
    }
    if ($quantidadeContas == 0) {
      $mensagem .= "<p class='text-danger'>Antes de cadastrar comandas, é necessário ter pelo menos uma conta cadastrada!</p>";
    }
    echo '<div class="divCadastros">
        <div id="navbar"></div>
        <h1 class="titulos">Cadastrar comanda</h1>
        <input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = \'../indexComandas.php\'">
        ' . $mensagem . '
        <br />
        </div>';
  }
  ?>

  <script>
    document.onkeyup = function(e) {
      if (e.key == 'F2') {
        window.location.href = '../../indexAjuda.php';
      } else if (e.key == 'F8') {
        window.location.href = '../../index.php';
      } else if (e.key == 'F9') {
        window.location.href = './cadastrarComandas.php';
      }
    }
  </script>
  <div class='push' style="height: 50px;"></div>
  <div id="footer"></div>
</body>

</html>