<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login']!=1)
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
        <h1 class="titulos">Cadastrar funcionário</h1>
        <input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = '../indexFuncionarios.php'">
		<br/>
        <form id="formCadastros" method="POST" action="camadaNegocios.php">
            <label for="nomeFuncionarioCadastrar">Nome: </label><input class="form-control" id="nomeFuncionarioCadastrar" name="nome" type="text" placeholder="Nome do funcionário" maxlength="100" required />
			<label for="loginFuncionarioCadastrar">Login: </label><input class="form-control" id="loginFuncionarioCadastrar" name="login" type="text" placeholder="Login do funcionário" maxlength="50" required />
			<label for="senhaFuncionarioCadastrar">Senha: </label><input class="form-control" id="senhaFuncionarioCadastrar" name="senha" type="password" placeholder="Senha do funcionário" minlength="8" maxlength="50" required />
			<label for="cpfFuncionarioCadastrar">CPF: </label><input class="form-control" id="cpfFuncionarioCadastrar" name="cpf" type="number" placeholder="CPF do funcionário" min="1" max="99999999999" required />
            <br/>
			<label for="administradorFuncionarioCadastrar">Administrador:</label> 
			<select id="administradorFuncionarioCadastrar" name="administrador">
			<option value="0">Não</option>
			<option value="1">Sim</option>
			</select>
			<br/>
			<input name="cadastrarFuncionarioSubmit" class="inputSubmit btn btn-large col-sm-15 btn-funcionarios" type="submit" value="Cadastrar" />
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
	</script>
	<div class='push' style="height: 53px;"></div>
    <div id="footer"></div>
</body>
</html>

