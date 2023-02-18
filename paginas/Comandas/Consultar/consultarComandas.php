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
			echo "<p class='text-success'>" . $_SESSION['mensagemFinalizacao'] . "</td>";
			unset($_SESSION['mensagemFinalizacao']);
		}
		if (isset($_SESSION['msgErr'])) {
			echo "<p class='text-danger'>" . $_SESSION['msgErr'] . "</p>";
			unset($_SESSION['msgErr']);
		}
		?>
		<h1 class="titulos">Consultar comanda</h1>
		<input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = '../indexComandas.php'">
		<br />
		<form id="formCadastros" method="POST" action="camadaNegocios.php">
			<label for="codigoComandaConsultar">Código:</label> <input class="form-control" id="codigoComandaConsultar" name="codigo" type="number" placeholder="Código da comanda" min="0" max="99999999999" required />
			<input name="consultarComandaSubmit" class="inputSubmit btn btn-large col-sm-15 btn-comandas mb-3" type="submit" value="Consultar" />
		</form>
		<?php
		require "../../../CamadaDados/conectar.php";
		require "../../../php/formatarReais.php";
		$tb = "Comanda";
		$result_msg_cont = "SELECT codigoComanda FROM $db.$tb Order By codigoComanda DESC limit 1";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->execute();
		$select_msg_cont = $select_msg_cont->fetchAll();
		foreach ($select_msg_cont as $linha_array) {
			echo "<p><b>Código da última comanda inserida </b>: " . $linha_array['codigoComanda'] . "</td>";
		}
		if (isset($_SESSION['queryComanda1']) && isset($_SESSION['queryComanda2']) && isset($_SESSION['queryComanda3']) && isset($_SESSION['queryComanda4'])) {
			//Comandas
			echo "<h2>Comanda</h2>";
			echo "<table class='sortable'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th >Código</th>";
			echo "<th >Valor</th>";
			echo "<th >Fechada</th>";
			echo "<th >Troco</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			$valorTotalComanda = -1;
			foreach ($_SESSION['queryComanda1'] as $linha_array) {
				echo "<tr>";
				echo "<td>" . $linha_array['codigoComanda'] . "</td>";;
				echo "<td>" . formatarReais($linha_array['valorTotalComanda']) . "</td>";
				$valorTotalComanda = $linha_array['valorTotalComanda'];
				echo "<td>", $linha_array['fechadaComanda'] ? "Sim" : "Não" . "</td>";
				echo "<td>" . formatarReais($linha_array['trocoComanda']) . "</td>";
				echo "</tr>";
			}
			echo  "</tbody>";
			echo "</table>";

			//Itens de comanda
			echo "<h2>Itens da comanda</h2>";
			echo "<table class='sortable'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th >Nome</th>";
			echo "<th >Quantidade</th>";
			echo "<th>Valor Unitário</th>";
			echo "<th>Subtotal</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			$somaItensComanda = 0;
			foreach ($_SESSION['queryComanda3'] as $linha_array) {
				echo "<tr>";
				echo "<td>" . $linha_array['nomeProduto'] . "</td>";
				echo  "<td>" . $linha_array['quantidadeItemComanda'] . "</td>";
				echo  "<td>" . formatarReais($linha_array['valorProduto']) . "</td>";
				echo  "<td>" . formatarReais($linha_array['valorProduto'] * $linha_array['quantidadeItemComanda']) . "</td>";
				$somaItensComanda += $linha_array['quantidadeItemComanda'] * $linha_array['valorProduto'];
				echo "</tr>";
			}
			if ($somaItensComanda != $valorTotalComanda) {
				$diferenca = $valorTotalComanda - $somaItensComanda;
				echo "<tr>";
				echo "<td> Itens Excluídos </td>";
				echo  "<td> - </td>";
				echo  "<td> - </td>";
				echo "<td>" . formatarReais($diferenca)  . "</td>";
				echo "</tr>";
			}
			echo  "</tbody>";
			echo "</table>";

			//Recebimentos
			if ($_SESSION['queryComanda2'] != null) {
				echo "<h2>Recebimento</h2>";
				echo "<table class='sortable'>";
				echo "<thead>";
				echo "<tr>";
				echo "<th >Método</th>";
				echo "<th >Valor</th>";
				echo "<th >Código da Conta</th>";
				echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
				foreach ($_SESSION['queryComanda2'] as $linha_array) {
					echo "<tr>";
					echo "<td>" . $linha_array['metodoPagamentoRecebimento'] . "</td>";
					echo  "<td>" . formatarReais($linha_array['valorRecebimento']) . "</td>";
					echo  "<td>" . $linha_array['Conta_codigoConta'] . "</td>";
					echo "</tr>";
				}
				echo  "</tbody>";
				echo "</table>";
			}

			//Atendimento
			echo "<h2>Atendimento</h2>";
			echo "<table class='sortable'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th >Nome do Funcionário</th>";
			echo "<th>Data/Hora";
			echo "<th>Status</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			foreach ($_SESSION['queryComanda4'] as $linha_array) {
				echo "<tr>";
				echo "<td>" . $linha_array['nomeFuncionario'] . "</td>";
				echo "<td>" . $linha_array['dataHoraAtendimento'] . "</td>";
				if ($linha_array['status'] == 0) {
					echo "<td>Pausado</td>";
				} else if ($linha_array['status'] == 1) {
					echo "<td>Encerrado</td>";
				} else {
					echo "<td>ERRO AO CONSULTAR O STATUS!</td>";
				}
				echo "</tr>";
			}
			echo  "</tbody>";
			echo "</table>";
			unset($_SESSION['queryComanda1']);
			unset($_SESSION['queryComanda2']);
			unset($_SESSION['queryComanda3']);
			unset($_SESSION['queryComanda4']);
		} else {
			if (isset($_SESSION['queryComanda1Falha'])) {
				echo "<p class='text-danger'>" . $_SESSION['queryComanda1Falha'] . "</p>";
				unset($_SESSION['queryComanda1Falha']);
			}
		}
		?>
	</div>
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
	<div class='push' style="height: 230px;"></div>
	<div id="footer"></div>
</body>

</html>