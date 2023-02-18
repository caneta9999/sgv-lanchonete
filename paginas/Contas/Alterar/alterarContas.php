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
        <h1 class="titulos">Alterar conta</h1>
		<input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = '../indexContas.php'">
		<h2 class="subtitulos">Insira o codigo da conta para realizar a alteração</h2>
		<br />
		<form id="formConsultarItem" method="POST" action="camadaNegociosConsultarCodigo.php">
		<label for="codigoContaAlterarConsultar">Código da conta:</label> <input id="codigoContaAlterarConsultar" value=1 class="form-control" name="codigo" type="number" placeholder="Código da conta" min="0" max="99999999999">
		<input name="alterarContaConsultarCodigoSubmit" class="inputSubmit btn btn-large col-sm-15 btn-contas mb-3" type="submit" value="Enviar" />
		</form>
		<hr>
		<br/>
        <?php
		if(isset($_SESSION['queryAlterarConta1'])){
        echo '<form id="formCadastros" method="POST" action="camadaNegocios.php">';
		$nome = 'Conta';
		$saldo = 0;
		$codigo = 1;
		foreach($_SESSION['queryAlterarConta1'] as $linha_array){
			$nome = $linha_array['nomeConta'];
			$saldo = $linha_array['saldoConta'];
			$codigo = $linha_array['codigoConta'];
		}
		echo '<form id="formCadastros" method="POST" action="camadaNegocios.php">';
        echo '<label for="codigoContaAlterar">Código:</label> <input value='.$codigo.' id="codigoContaAlterar" class="form-control" name="codigo" type="number" placeholder="Código da conta" min="0" max="99999999999" required readonly="readonly"/>';
        echo '<label for="nomeContaAlterar">Nome:</label> <input value='."'$nome'".' id="nomeContaAlterar" class="form-control" name="nome" type="text" placeholder="Nome da conta" maxlength="50" required />';
        echo '<label for="saldoContaAlterar">Saldo:</label> <input value='.$saldo.' id="saldoContaAlterar" class="form-control" name="saldo" type="number" placeholder="Saldo da conta" step="0.01" min="-999999999.99" max="999999999.99" required />';
        echo '<input name="alterarContaSubmit" class="inputSubmit btn btn-large col-sm-15 btn-contas" type="submit" value="Alterar" />';
        echo '</form>';
		unset($_SESSION['queryAlterarConta1']);}
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
	<div class='push' style="height: 164px;"></div>
    <div id="footer"></div>
</body>
</html>