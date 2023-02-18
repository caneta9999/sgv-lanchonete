<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/index.css"/>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
    <title>Sistema de Gerenciamento de Vendas da Lanchonete</title> 
    
    <!--Componentes -->
    <script type="module" src="../../js/componentesLogin.js"></script>

</head>
<body>
    <div class="divCadastros">
	<div id="navbar"></div>
		<?php
		session_start();
			if(isset($_SESSION['msgLogin'])){
				echo "<p class='text-danger'>".$_SESSION['msgLogin']."</p>";
				unset($_SESSION['msgLogin']);
			}
		?>
        <h1 class="titulos">Realizar login</h1>
        <form id="formCadastros" method="POST" action="camadaNegocios.php">
			<label for="loginLogin">Login: </label><input id="loginLogin" class="form-control" name="login" type="text" placeholder="Login" maxlength="50" required />
			<label for="senhaLogin">Senha: </label><input id="senhaLogin" class="form-control" name="senha" type="password" placeholder="Senha" minlength="8" maxlength="50" required />         
        <input name="loginSubmit" class="inputSubmit btn btn-light" type="submit" value="Entrar" />
        </form>
    </div>
<div class='push' style="height: 282px;"></div>
<div id="footer"></div>

</body>
</html>

