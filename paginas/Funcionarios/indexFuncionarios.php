<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
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
			if(isset($_SESSION['mensagemFinalizacao'])){
			echo "<p class='text-success'>".$_SESSION['mensagemFinalizacao']."</p>";
			unset($_SESSION['mensagemFinalizacao']);
			}
			if(isset($_SESSION['msgErr'])){
				echo "<p class='text-danger'>".$_SESSION['msgErr']."</p>";
				unset($_SESSION['msgErr']);
			}
		?>
        <h1 class="titulos">Funcionários</h1>
        <input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = '../index.php'">
        <br>
        <div class="btn-group-vertical">
            <a href="./Listar/listarFuncionarios.php" class="btn btn-large col-sm-2 btn-funcionarios mb-3">Ver funcionarios cadastrados</a></li>
            <a href="./Cadastrar/cadastrarFuncionarios.php" class="btn btn-large col-sm-2 btn-funcionarios mb-3">Cadastrar funcionario</a></li>
            <a href="./Consultar/consultarFuncionarios.php" class="btn btn-large col-sm-2 btn-funcionarios mb-3">Consultar funcionario</a></li>
            <a href="./Alterar/alterarFuncionarios.php" class="btn btn-large col-sm-2 btn-funcionarios mb-3">Alterar funcionario</a></li>
            <a href="./Excluir/excluirFuncionarios.php" class="btn btn-large col-sm-2 btn-funcionarios">Excluir funcionario</a></li>
        </div>
    </div>
	<script>
		document.onkeyup = function (e){
		if(e.key == 'F2'){
				window.location.href = '../indexAjuda.php';
		}else if(e.key == 'F8'){
				window.location.href= '../index.php';
		}else if(e.key== 'F9'){
				window.location.href='../Comandas/Cadastrar/cadastrarComandas.php';
		}}
	</script>
	<div class='push' style="height: 156px;"></div>
	<div id="footer"></div>
</body>

</html>