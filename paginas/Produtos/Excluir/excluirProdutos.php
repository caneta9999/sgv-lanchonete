<?php
session_start();
if(!isset($_SESSION['login']) && $_SESSION['login']!=1)
{
		header('location:../../Login/login.php');	
  }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="stylesheet" href="../../../css/index.css"/>
    <title>Sistema de Gerenciamento de Vendas da Lanchonete</title>
	<!--Bootstrap -->
    <link rel="stylesheet" href="../../../bootstrap/css/bootstrap.css">

    <!--Componentes -->
    <script type="module" src="../../../js/componentesPadrao.js"></script>
</head>
<body>
    <div class="divCadastros">
		<div id="navbar"></div>
		<?php
				if(isset($_SESSION['excluirProdutoFalha'])){
				echo "<p class='text-danger'>".$_SESSION['excluirProdutoFalha']."</p>";
				unset($_SESSION['excluirProdutoFalha']);}
		?>
        <h1 class="titulos">Excluir produto</h1>
		<input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = '../indexProdutos.php'">
        <br/>
		<form id="formCadastros" method="POST" action="camadaNegocios.php">
            <label for="codigoProdutoExcluir">Código:</label> <input for="codigoProdutoExcluir" class="form-control" name="codigo" type="number" placeholder="Código do produto" min="0" max="99999999999" required />
            <input name="excluirProdutoSubmit" class='btn btn-large col-sm-15 btn-produtos' type="submit" value="Excluir" onClick="return confirmarSubmit()" />
        </form>
    </div>
	<script>
		document.onkeyup = function (e){
		if(e.key == 'F2'){
				window.location.href = '../../indexAjuda.php';
		}else if(e.key == 'F8'){
				window.location.href= '../../index.php';
		}else if(e.key== 'F9'){
				window.location.href='../../Comandas/Cadastrar/cadastrarComandas.php';
		}}
		function confirmarSubmit()
		{
		var confirmar=confirm("Você deseja realmente excluir este elemento?");
		return confirmar? true:false}
	</script>
	<div class='push' style="height: 292px;"></div>
    <div id="footer"></div>
</body>
</html>