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
	<div class="divListar">
		<div id="navbar"></div>
		<?php
		if (isset($_SESSION['mensagemFinalizacao'])) {
			echo "<p class='text-success'>" . $_SESSION['mensagemFinalizacao'] . "</p>";
			unset($_SESSION['mensagemFinalizacao']);
		}
		?>
		<h1 class="titulos">Listar comandas cadastradas</h1>
		<div><input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = '../indexComandas.php'"></div>
		<div>
			<a href="#" class="btn-comandas btn col-sm-15 mb-3" onclick="inserirDataDeHoje()">Comandas de hoje</a>


		</div>
		<form id="formCadastros" method="POST" action="camadaNegocios.php">
			<label for="primeiraDataComandasListar">Primeira data:</label> <input id="primeiraDataComandasListar" name="dataInicio" class="form-control" type="date" required>
			<label for="segundaDataComandasListar">Segunda data:</label> <input id="segundaDataComandasListar" name="dataTermino" class="form-control" type="date" required>
			<input name="listarComandaSubmit" class="inputSubmit btn btn-large col-sm-15 btn-comandas mb-3" type="submit" value="Listar" />
		</form>
		<?php
		require '../../../php/formatarReais.php';
		if (isset($_SESSION['queryComanda5'])) {
			echo "<table class='sortable'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th >Código</th>";
			echo "<th >Valor</th>";
			echo "<th >Fechada</th>";
			echo "<th >Troco</th>";
			echo "<th >Data/Hora</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			foreach ($_SESSION['queryComanda5'] as $linha_array) {
				echo "<tr>";
				echo "<td>" . $linha_array['codigoComanda'] . "</td>";
				echo "<td>" . formatarReais($linha_array['valorTotalComanda']) . "</td>";
				echo "<td>", $linha_array['fechadaComanda'] ? "Sim" : "Não" . "</td>";
				echo "<td>" . formatarReais($linha_array['trocoComanda']) . "</td>";
				echo  "<td>" . $linha_array['dataHoraAtendimento'] . "</td>";
				echo "</tr>";
			}
			echo  "</tbody>";
			echo "</table>";
			unset($_SESSION['queryComanda5']);
		} else {
			if (isset($_SESSION['queryComanda5Falha'])) {
				echo "<p class='text-danger'>" . $_SESSION['queryComanda5Falha'] . "</p>";
				unset($_SESSION['queryComanda5Falha']);
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
	<script src="../../../js/jquery-3.6.0.min.js"></script>
	<script>
		function inserirDataDeHoje() {
			let hoje = new Date();
			let anoHoje = hoje.getFullYear();
			let mesHoje = hoje.getMonth() + 1;
			let diaHoje = hoje.getDate();
			hoje = anoHoje + '-' + mesHoje + '-' + diaHoje;
			$('#primeiraDataComandasListar').val(hoje);
			$('#segundaDataComandasListar').val(hoje);
		}
	</script>
	<div class='push' style="height: 210px;"></div>
	<div id="footer"></div>
</body>

</html>