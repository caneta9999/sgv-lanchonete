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

	<!--Sortable Table -->
	<script src="../../../js/sorttable.js"></script>
</head>

<body>
	<div class="divCadastros">
		<div id="navbar"></div>
		<?php
		if (isset($_SESSION['mensagemFinalizacao'])) {
			echo "<p class='text-success'>" . $_SESSION['mensagemFinalizacao'] . "</p>";
			unset($_SESSION['mensagemFinalizacao']);
		}
		if (isset($_SESSION['msgErr'])) {
			echo "<p class='text-danger'>" . $_SESSION['msgErr'] . "</p>";
			unset($_SESSION['msgErr']);
		}
		?>
		<h1 class="titulos">Alterar comanda</h1>
		<input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = '../indexComandas.php'">
		<?php
		require "../../../CamadaDados/conectar.php";
		$tb = "Comanda";
		$tb2 = "Atendimento";
		$tb3 = "Funcionario";
		$result_msg_cont = "SELECT C1.codigoComanda,F1.nomeFuncionario FROM $db.$tb C1 inner join $db.$tb2 A1 ON C1.codigoComanda = A1.Comanda_codigoComanda inner join $db.$tb3 F1 ON A1.Funcionario_codigoFuncionario = F1.codigoFuncionario Where C1.fechadaComanda = 0";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->execute();
		$select_msg_cont = $select_msg_cont->fetchAll();

		if (!isset($_SESSION['queryAlterarComanda1']) and $select_msg_cont != null) {
			echo "<h2 class='subtitulos'>Insira o codigo da comanda para realizar a alteração</h2>";
			echo "<h2>Comandas abertas</h2>";
			echo "<table class='sortable'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th >Código da Comanda</th>";
			echo "<th >Nome do Funcionário</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			foreach ($select_msg_cont as $linha_array) {
				echo "<tr>";
				echo "<td>" . $linha_array['codigoComanda'] . "</td>";
				echo "<td>" . $linha_array['nomeFuncionario'] . "</td>";
				echo "</tr>";
			}
			echo  "</tbody>";
			echo "</table>";
			echo '<form id="formConsultarItem" method="POST" action="camadaNegociosConsultarCodigo.php">';
			echo '<label for="codigoComandaAlterarConsultar">Código da comanda:</label> <input id="codigoComandaAlterarConsultar" value=1 class="form-control" name="codigo" type="number" placeholder="Código da comanda" min="0" max="99999999999" required>';
			echo '<input name="alterarComandaConsultarCodigoSubmit" class="inputSubmit btn btn-large col-sm-15 btn-comandas mb-3" type="submit" value="Enviar" />';
			echo '</form>';

			$tb = "Comanda";
			$result_msg_cont = "SELECT codigoComanda FROM $db.$tb Order By codigoComanda DESC limit 1";
			$select_msg_cont = $conx->prepare($result_msg_cont);
			$select_msg_cont->execute();
			$select_msg_cont = $select_msg_cont->fetchAll();
			foreach ($select_msg_cont as $linha_array) {
				echo "<p><b>Código da última comanda inserida </b>: " . $linha_array['codigoComanda'] . "</p>";
			}
		} else if (!isset($_SESSION['queryAlterarComanda1'])) {
			echo "<h2 class='subtitulos'>Não há comandas abertas!</h2>";
		}
		?>

		<br />
		<?php
		if (isset($_SESSION['queryAlterarComanda1'])) {

			echo '<div><p>Código da Comanda: ' .$_SESSION['codigoComanda'] . '</p></div>';

			echo '<div id="formularioComandasCompleto"></div>';

			if (isset($_SESSION['codigosProdutosAlterar'])) {
				if (isset($_SESSION['itensComandaAlterar'])) {
					echo "<script>
						let jsonCodigosProdutosAlterar = " . $_SESSION['codigosProdutosAlterar'] . "
						let jsonItensComandaAlterar = " . $_SESSION['itensComandaAlterar'] . "
						sessionStorage.setItem('codigosProdutosAlterar', jsonCodigosProdutosAlterar);
						sessionStorage.setItem('itensComandaAlterar', jsonItensComandaAlterar);
					</script>";
				} else {
					echo "<p class='text-danger'>" . "Ocorreu um erro durante a consulta (itensComandaAlterar não encontrado)" . "</p>";
				}
			} else {
				echo "<p class='text-danger'>" . "Ocorreu um erro durante a consulta (codigosProdutosAlterar não encontrado)" . "</p>";
			}

			if (isset($_SESSION['queryAlterarComandaDinheiro'])) {
				foreach ($_SESSION['queryAlterarComandaDinheiro'] as $linha_array) {
					$codigoConta = $linha_array['Conta_codigoConta'];
					$dinheiro = $linha_array['valorRecebimento'];
				}
				unset($_SESSION['queryAlterarComandaDinheiro']);
			}

			echo  '<script src="../../../js/jquery-3.6.0.min.js"></script>

			<!--Formulário de Comandas -->
			<script src="../../../js/Comandas/formularioComandasCompleto.js"></script>
		  
			<!--Funções de Comandas -->
			<script src="../../../js/Comandas/funcoesPesquisa.js"></script>
		  
			<!--Tabela de Comandas -->
			<script src="../../../js/Comandas/tabelaItensComanda.js"></script>';


			echo "<script>
			  $(document).ready(function() {
				//Prepara o json de configuração do formularo
				let configuracoesFormulario = {
				  idBarraPesquisa: 'barraPesquisaProduto',
				  idBotaoAdicionar: 'btnAdicionar',
				  idMensagemErro: 'mensagemErro',
				  idMostrarLista: 'mostrarLista',
				  idComanda: '" . $_SESSION['codigoComanda'] ."'
				}
		  
				//Desenha o formulário de comandas
				formularioComandasCompleto(JSON.stringify(configuracoesFormulario));
		  
				//Prepara o json de configuração da tabela
				let configuracoesTabela = {
				  codigosProdutos: 'codigosProdutosAlterar',
				  itensComanda: 'itensComandaAlterar',
				  idLabelTotal: 'labelTotal',
				  idInputEnvio: 'itensComandaCadastrar'
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
				configuracoesFormulario.idMensagemErro, configuracoesFormulario.idMostrarLista,
				configuracoesTabela.itensComanda, configuracoesTabela.codigosProdutos)
		  
			  
			  });
			</script>";

			echo '
			<!-- //Para o spinner com mais e com menos -->
			<script src="../../../js/bootstrap-input-spinner.js"></script>
			<script>
			  $(".bootstrapSpinner").inputSpinner();
			</script>';


			unset($_SESSION['queryAlterarComanda1']);
		}
		?>
		<script type="text/javascript">
			function mostrarQuantia(idCheckbox, idConjunto, idQuantia) {
				if (document.getElementById(idCheckbox).checked) {
					document.getElementById(idConjunto).style.setProperty("display", "block");
				} else {
					document.getElementById(idConjunto).style.setProperty("display", "none");
					document.getElementById(idQuantia).value = "";
				}
			}

		</script>

		<script>
			document.onkeyup = function(e) {
				if (e.key == 'F2') {
					window.location.href = '../../indexAjuda.php';
				} else if (e.key == 'F8') {
					window.location.href = '../../index.php';
				} else if (e.key == 'F9') {
					window.location.href = '../Cadastrar/cadastrarComandas.php';
				}
			}
		</script>
		<div class='push'  style="height: 345px;"></div>
		<div id="footer"></div>
</body>

</html>