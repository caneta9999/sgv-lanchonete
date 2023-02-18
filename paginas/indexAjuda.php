<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('location:./Login/login.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css" />
    <title>Sistema de Gerenciamento de Vendas da Lanchonete Bar</title>
	<style>
    #divAtalhos {
      display: none;
    }
	</style>
    <!--Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">

    <!--Componentes -->
    <script type="module" src="../js/componentesPadrao.js"></script>

</head>

<body>
    <div class="divIndexs">
	    <div id="navbar"></div>
        <h1 class="titulos">Ajuda</h1>
        <input type="button" class="btn btn-light mt-1" value="Voltar" onClick="window.location.href = 'index.php'">
		<br/>
        <input type="button" class="btn btn-light mt-1" value="Mostrar Lista de Atalhos" onClick="mostrarAtalhos()">
		<div id="divAtalhos">
		<h2 class="titulos">Atalhos do teclado</h2>
		<ul>
		<li>F2 - Página de ajuda</li>
		<li>F8 - Página principal</li>
		<li>F9 - Página de cadastro de comandas</li>
		</ul>
		</div>
		<h2 class="titulos">Entre em contato por email</h2>
        <form id="formAjuda2" method="POST">
            <label for="emailAjuda">Email: </label><input name="email" id="emailAjuda" class="form-control" type="email" placeholder="Email" maxlength="100" required />
            <label for="nomeAjuda">Nome: </label><input name="nome" id="nomeAjuda" class="form-control" type="text" placeholder="Nome da pessoa" maxlength="100" required />
			<br/>
            <label for="descricaoAjuda">Descrição:</label> 
			<br/>
			<textarea name="descricao" id="descricaoAjuda" class="form-control" rows="4" maxlength="300" placeholder="Descrição do problema..."  required ></textarea/>
            <input class="inputSubmit" type="submit" value="Enviar"/>
        </form>
		<h2 class="titulos">Entre em contato por telefone</h2>
		<p class="subtitulos">Primeiro telefone: +55ZZ9XXXXYYYY </p>
		<p class="subtitulos">Segundo telefone:  +55ZZ9YYYYXXXX </p>
    </div>
	<div class='push' style="height: 120px;"></div>
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
		function mostrarAtalhos(){
			divatalhos = document.getElementById("divAtalhos");
			if(divatalhos.style.display == "none" || divatalhos.style.display == ""){
				divatalhos.style.display = "block";
			}
			else{
				divatalhos.style.display = "none";
			}
		}
	</script>
</body>
</html>