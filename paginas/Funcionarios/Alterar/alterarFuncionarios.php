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
        <h1 class="titulos">Alterar funcionário</h1>
        <input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = '../indexFuncionarios.php'">
		<h2 class="subtitulos">Insira o codigo do funcionario para realizar a alteração</h2>
		<br />
		<form id="formConsultarItem" method="POST" action="camadaNegociosConsultarCodigo.php">
		<label for="codigoFuncionarioAlterarConsultar">Código do funcionario:</label> <input id="codigoFuncionarioAlterarConsultar" value=1 class="form-control" name="codigo" type="number" placeholder="Código do funcionario" min="0" max="99999999999" required>
		<input name="alterarFuncionarioConsultarCodigoSubmit" class="inputSubmit btn btn-large col-sm-15 btn-funcionarios mb-3" type="submit" value="Enviar" />
		</form>
		<hr>
		<br/>
		<?php
		if(isset($_SESSION['queryAlterarFuncionario1'])){
        echo '<form id="formCadastros" method="POST" action="camadaNegocios.php">';
		$nome = 'Nome';
		$login = 'Login';
		$codigo = 1;
		$senha = '12345678';
		$cpf = 1;
		$administrador = 0;
		foreach($_SESSION['queryAlterarFuncionario1'] as $linha_array){
			$nome = $linha_array['nomeFuncionario'];
			$login = $linha_array['loginFuncionario'];
			$codigo = $linha_array['codigoFuncionario'];
			$senha = $linha_array['senhaFuncionario'];
			$cpf = $linha_array['CPF'];
			$administrador = $linha_array['administrador'];
		}
		    echo '<label for="codigoFuncionarioAlterar">Código:</label> <input value='.$codigo.' id="codigoFuncionarioAlterar" class="form-control" name="codigo" type="number" placeholder="Codigo do funcionário" min="0" max="99999999999" required readonly="readonly"/>';
            echo '<label for="nomeFuncionarioAlterar">Nome:</label> <input value='."'$nome'".' id="nomeFuncionarioAlterar" class="form-control" name="nome" type="text" placeholder="Nome do funcionário" maxlength="50" required />';
			echo '<label for="loginFuncionarioAlterar">Login:</label> <input value='."'$login'".' id="loginFuncionarioAlterar" class="form-control" name="login" type="text" placeholder="Login do funcionário" maxlength="50" required />';
			echo '<label for="senhaFuncionarioAlterar">Senha:</label> <input value='."'$senha'".' id="senhaFuncionarioAlterar" class="form-control" name="senha" type="password" placeholder="Senha do funcionário" minlength="8" maxlength="50" required />';
			echo '<label for="cpfFuncionarioAlterar">CPF:</label> <input value='.$cpf.' id="cpfFuncionarioAlterar" class="form-control" name="cpf" type="number" placeholder="CPF do funcionário" min="1" max="99999999999" required />';
			echo '<br/>';
			echo '<label for="administradorFuncionarioAlterar">Administrador:</label>'; 
			echo '<select id="administradorFuncionarioAlterar" name="administrador">';
			if($administrador){
			echo '<option value="0">Não</option>';
			echo '<option value="1" selected>Sim</option>';
			}
			else{
			echo '<option value="0" selected>Não</option>';
			echo '<option value="1">Sim</option>';				
			}
			echo '</select>';
			echo '<br/>';
			echo '<input name="alterarFuncionarioSubmit" class="inputSubmit btn btn-large col-sm-15 btn-funcionarios" type="submit" value="Alterar" />';
        echo '</form>';
		unset($_SESSION['queryAlterarFuncionario1']);}
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
	<div class='push' style="height: 156px;"></div>
    <div id="footer"></div>
</body>
</html>