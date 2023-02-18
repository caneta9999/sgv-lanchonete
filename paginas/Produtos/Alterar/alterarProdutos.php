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
			if(isset($_SESSION['mensagemFinalizacao'])){
				echo "<p class='text-success'>".$_SESSION['mensagemFinalizacao']."</p>";
				unset($_SESSION['mensagemFinalizacao']);
			}
			if(isset($_SESSION['msgErr'])){
				echo "<p class='text-danger'>".$_SESSION['msgErr']."</p>";
				unset($_SESSION['msgErr']);
			}
		?>
        <h1 class="titulos">Alterar produto</h1>
        <input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = '../indexProdutos.php'">
		<h2 class="subtitulos">Insira o codigo do produto para realizar a alteração</h2>
		<br />
		<form id="formConsultarItem" method="POST" action="camadaNegociosConsultarCodigo.php">
		<label for="codigoProdutoAlterarConsultar">Código do produto:</label> <input id="codigoProdutoAlterarConsultar" value=1 class="form-control" name="codigo" type="number" placeholder="Código do produto" min="0" max="99999999999" required>
		<input name="alterarProdutoConsultarCodigoSubmit" class="inputSubmit btn btn-large col-sm-15 btn-produtos mb-3" type="submit" value="Enviar" />
		</form>
		<hr>
		<br/>
		<?php
		if(isset($_SESSION['queryAlterarProduto1'])){
        echo '<form id="formCadastros" method="POST" action="camadaNegocios.php">';
		$nome = 'Produto';
		$valor = 1;
		$codigo = 1;
		foreach($_SESSION['queryAlterarProduto1'] as $linha_array){
			$nome = $linha_array['nomeProduto'];
			$valor = $linha_array['valorProduto'];
			$codigo = $linha_array['codigoProduto'];
		}
		echo '<label for="codigoProdutoAlterar">Código:</label><input value='.$codigo.' id="codigoProdutoAlterar" class="form-control" name="codigo" type="number" placeholder="Código do produto" min="0" max="99999999999" required readonly="readonly"/>';
		echo '<label for="nomeProdutoAlterar">Nome:</label> <input value='."'$nome'".'id="nomeProdutoAlterar" class="form-control" name="nome" type="text" placeholder="Nome do produto" maxlength="50" required />';
        echo '<label for="valorProdutoAlterar">Valor:</label> <input value='.$valor.' id="valorProdutoAlterar" class="form-control" name="valor" type="number" placeholder="Valor do produto" step="0.01" min="0" max="999999999.99" required />';
        echo '<input name="alterarProdutoSubmit" class="inputSubmit btn btn-large col-sm-15 btn-produtos" type="submit" value="Alterar" />';
        echo '</form>';
		unset($_SESSION['queryAlterarProduto1']);}
		?>
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
	</script>
	<div class='push' style="height: 165px;"></div>
    <div id="footer"></div>
</body>
</html>