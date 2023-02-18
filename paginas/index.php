<?php
session_start();
if(!isset($_SESSION['login']))
{
  header('location:./Login/login.php');
  }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="stylesheet" href="../css/index.css"/>
    <title>Sistema de Gerenciamento de Vendas da Lanchonete</title>

    <!--Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.css">

    <!--Componentes -->
    <script type="module" src="../js/componentesPadrao.js"></script>
</head>
<body>
	<div class="divIndexs">
		<div id="navbar"></div>	
    <div class="container">
    <div class="divIndexs row">    
        <h1 class="titulos">Cadastros</h1>
        <div class="row d-flex gap-3 justify-content-center">
        <a href="./Comandas/indexComandas.php" class="btn btn-large col-8 col-sm-6 col-md-4 col-lg-2 btn-comandas"><i class="bi bi-file-post" style="font-size: 10rem"></i>
            <br/>Comandas</a>
        <a href="./Produtos/indexProdutos.php" class="btn btn-large col-8 col-sm-6 col-md-4 col-lg-2 btn-produtos"><i class="bi bi-cart4" style="font-size: 10rem"></i>
            <br/>Produtos</a>
        <?php
            if($_SESSION['login']==1){
            echo "<a href='./Contas/indexContas.php' class='btn btn-large col-8 col-sm-6 col-md-4 col-lg-2 btn-contas'><i class='bi bi-cash-coin' style='font-size: 10rem'></i>
                <br/>Contas</a>";
            echo "<a href='./Funcionarios/indexFuncionarios.php' class='btn btn-large col-8 col-sm-6 col-md-4 col-lg-2 btn-funcionarios'><i class='bi bi-people-fill' style='font-size: 10rem'></i>
                <br/>Funcionários</a>";
        }
		?>
        </div>
    </div>
    </div></div>
<div class='push' style="height: 185px;"></div>
<div id="footer"></div>
	<script>
		document.onkeyup = function (e){
		if(e.key == 'F2'){
				window.location.href = './indexAjuda.php';
		}else if(e.key == 'F8'){
				window.location.href= './index.php';
		}else if(e.key== 'F9'){
				window.location.href='Comandas/Cadastrar/cadastrarComandas.php';
		}}
	</script>
</body>
</html>