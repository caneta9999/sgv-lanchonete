<?php
session_start();
if (!isset($_SESSION['login'])) {
	header('location:../Login/login.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../css/index.css" />
	<title>Sistema de Gerenciamento de Vendas da Lanchonete</title>

	<!--Bootstrap -->
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">

	<!--Componentes -->
	<script type="module" src="../../js/componentesPadrao.js"></script>

</head>

<body>
	<div class="divIndexs">
		<div id="navbar"></div>
		<?php
		require "../../php/limparSessao.php";
		if (isset($_SESSION['mensagemFinalizacao'])) {
			echo "<p class='text-success'>" . $_SESSION['mensagemFinalizacao'] . "</p>";
			unset($_SESSION['mensagemFinalizacao']);
		}
		if (isset($_SESSION['mensagemFinalizacaoAlteracao'])) {
			echo "<p class='text-success'>" . $_SESSION['mensagemFinalizacaoAlteracao'] . "</p>";
			limparSessao('codigosProdutos', 'itensComanda');
			limparSessao('codigosProdutosAlterar', 'itensComandaAlterar');
			unset($_SESSION['mensagemFinalizacaoAlteracao']);
		}
		if (isset($_SESSION['mensagemFinalizacaoExclusao'])) {
			echo "<p class='text-success'>" . $_SESSION['mensagemFinalizacaoExclusao'] . "</p>";
			limparSessao('codigosProdutos', 'itensComanda');
			limparSessao('codigosProdutosAlterar', 'itensComandaAlterar');
			unset($_SESSION['mensagemFinalizacaoExclusao']);
		}
		if (isset($_SESSION['msgErr'])) {
			echo "<p class='text-danger'>" . $_SESSION['msgErr'] . "</p>";
			unset($_SESSION['msgErr']);
		}
		?>
		<h1 class="titulos">Produtos</h1>
		<input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = '../index.php'">
		<br />
		<div class="btn-group-vertical">
			<a href="./Listar/listarProdutos.php" class="btn btn-large col-sm-2 btn-produtos mb-3">Ver produtos cadastrados</a></li>
			<?php
			if ($_SESSION['login'] == 1) {
				echo "<a href='./Cadastrar/cadastrarProdutos.php' class='btn btn-large col-sm-2 btn-produtos mb-3'>Cadastrar produto</a></li>";
			}
			?>
			<a href="./Consultar/consultarProdutos.php" class="btn btn-large col-sm-2 btn-produtos mb-3">Consultar produto</a></li>
			<?php
			if ($_SESSION['login'] == 1) {
				echo "<a href='./Alterar/alterarProdutos.php' class='btn btn-large col-sm-2 btn-produtos mb-3'>Alterar produto</a></li>";
				echo "<a href='./Excluir/excluirProdutos.php' class='btn btn-large col-sm-2 btn-produtos'>Excluir produto</a></li>";
			}
			?>
		</div>
	</div>
	<?php
	if ($_SESSION['login'] != 1) {
		echo "<div class='push' style='height: 296px;'></div>";
	} else {
		echo "<div class='push' style='height: 156px;'></div>";
	}
	?>
	<div id="footer"></div>
	<script>
		document.onkeyup = function(e) {
			if (e.key == 'F2') {
				window.location.href = '../indexAjuda.php';
			} else if (e.key == 'F8') {
				window.location.href = '../index.php';
			} else if (e.key == 'F9') {
				window.location.href = '../Comandas/Cadastrar/cadastrarComandas.php';
			}
		}
	</script>
</body>

</html>