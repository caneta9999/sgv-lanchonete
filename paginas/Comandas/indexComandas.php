<?php
session_start();
if(!isset($_SESSION['login']))
{
  header('location:../Login/login.php');
  }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="stylesheet" href="../../css/index.css"/>
    <title>Sistema de Gerenciamento de Vendas da Lanchonete</title>

    <!--Bootstrap -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../bootstrap-icons/bootstrap-icons.css">

    <!--Componentes -->
    <script type="module" src="../../js/componentesPadrao.js"></script>
</head>
<body>
    <div class="divIndexs">
        <div id="navbar"></div>
		<?php
			require "../../php/limparSessao.php"; 
			if(isset($_SESSION['mensagemFinalizacao'])){
				echo "<p class='text-success'>".$_SESSION['mensagemFinalizacao']."</p>";
				limparSessao('codigosProdutos', 'itensComanda');
				unset($_SESSION['mensagemFinalizacao']);
			}
			if(isset($_SESSION['comandaResultado'])){
				echo"<p class='text-success'>".$_SESSION['comandaResultado']."</p>";
				unset($_SESSION['comandaResultado']);
			}
			if(isset($_SESSION['comandaResultado2'])){
				echo"<p class='text-danger'>".$_SESSION['comandaResultado2']."</p>";
				unset($_SESSION['comandaResultado2']);
			}
			if(isset($_SESSION['msgErr'])){
				echo "<p class='text-danger'>".$_SESSION['msgErr']."</p>";
				unset($_SESSION['msgErr']);
			}
		?>
        <h1 class="titulos">Comandas</h1>
		<input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = '../index.php'">
        <br>
        <?php 
		?>
		<br>
        <div class="btn-group-vertical">
        <a href="./Listar/listarComandas.php" class="btn btn-large col-sm-2 btn-comandas mb-3">Ver comandas cadastradas</a>
        <a href="./Cadastrar/cadastrarComandas.php" class="btn btn-large col-sm-2 btn-comandas mb-3">Cadastrar comanda</a>
        <a href="./Consultar/consultarComandas.php" class="btn btn-large col-sm-2 btn-comandas mb-3">Consultar comanda</a>
        <a href="./Alterar/alterarComandas.php" class="btn btn-large col-sm-2 btn-comandas mb-3">Alterar comanda</a>
        <a href="./Excluir/excluirComandas.php" class="btn btn-large col-sm-2 btn-comandas">Excluir comanda</a>    
        </div>

    </div>
	<script>
		document.onkeyup = function (e){
		if(e.key == 'F2'){
				window.location.href = '../indexAjuda.php';
		}else if(e.key == 'F8'){
				window.location.href= '../index.php';
		}else if(e.key== 'F9'){
				window.location.href='./Cadastrar/cadastrarComandas.php';
		}}
	</script>
	<div class='push' style="height: 131px;"></div>
    <div id="footer" ></div>
</body>
</html>