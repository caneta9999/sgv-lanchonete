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
	
	<!--Sortable Table -->
	<script src="../../../js/sorttable.js"></script>

	<!--jQuery-->
    <script src="../../../js/jquery-3.6.0.min.js"></script>

	<!--Pagination Table-->
	<script src='../../../js/jquery-paginate-master/jquery-paginate.min.js'></script>
</head>
<body>
    <div class="divCadastros" >
		<div id="navbar"></div>
		<?php
		if(isset($_SESSION['mensagemFinalizacao'])){
			echo "<p class='text-success'>".$_SESSION['mensagemFinalizacao']."</p>";
			unset($_SESSION['mensagemFinalizacao']);
		}
		?>
        <h1 class="titulos">Consultar funcionário</h1>
        <input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = '../indexFuncionarios.php'">
		<h2 class="subtitulos">Prioridade das consultas: Nome>Login>Código</h2>	
		<h2 class="subtitulos">Se pesquisar pelo código, também será retornado os atendimentos do funcionário</h2>
        <form id="formCadastros" method="POST" action="camadaNegocios.php">
            <label for="codigoFuncionarioConsultar">Código:</label> <input id="codigoFuncionarioConsultar" class="form-control" name="codigo" type="number" placeholder="Código do funcionario" min="0" max="99999999999"  />
			<label for="nomeFuncionarioConsultar">Nome:</label> <input id="nomeFuncionarioConsultar" class="form-control" name="nome" type="text" placeholder="Nome do funcionario" maxlength="50"  />
			<label for="loginFuncionarioConsultar">Login:</label> <input id="loginFuncionarioConsultar" class="form-control" name="login" type="text" placeholder="Login do funcionario" maxlength="50"  />
            <input name="consultarFuncionarioSubmit" class="inputSubmit btn btn-large col-sm-15 btn-funcionarios" type="submit" value="Consultar" />
        </form>

		<?php
				if(isset($_SESSION['queryFuncionario1'])){
					echo "<table class='sortable'>";
					echo "<thead>";
					echo"<tr>";
					echo "<th >Código</th>";
					echo "<th >Nome</th>";
					echo "<th >Login</th>";
					echo "<th >CPF</th>";
					echo "<th >Administrador</th>";
					echo"</tr>";
					echo "</thead>";
					echo "<tbody>";
					foreach($_SESSION['queryFuncionario1'] as $linha_array) {
					echo "<tr>";
					echo "<td>". $linha_array['codigoFuncionario'] ."</td>";        
					echo  "<td>". $linha_array['nomeFuncionario'] ."</td>";
					echo  "<td>". $linha_array['loginFuncionario'] ."</td>";							
					echo  "<td>". $linha_array['CPF'] ."</td>";				
					echo  "<td>",$linha_array['administrador']?"Sim":"Não"."</td>";		
					echo "</tr>";}
					echo  "</tbody>";
					echo "</table>";
					unset($_SESSION['queryFuncionario1']);
					if(isset($_SESSION['queryFuncionarioAtendimento1'])){
						echo "<h2>Atendimentos</h2>";
						echo "<table id='funcionarioAtendimento'>";
						echo "<thead>";
						echo"<tr>";
						echo "<th >Atendimento</th>";
						echo "<th >Comanda</th>";
						echo "<th >Data e Hora</th>";
						echo"</tr>";
						echo "</thead>";
						echo "<tbody>";
						foreach($_SESSION['queryFuncionarioAtendimento1'] as $linha_array){
							echo "<tr>";
							echo "<td>".$linha_array['codigoAtendimento']."</td>";
							echo "<td>".$linha_array['Comanda_codigoComanda']."</td>";
							echo "<td>".$linha_array['dataHoraAtendimento']."</td>";
							echo "</tr>";}
						echo  "</tbody>";
						echo "</table>";
						echo "<script>$('#funcionarioAtendimento').paginate({ limit: 5 });</script>";
						unset($_SESSION['queryFuncionarioAtendimento1']);}
					else if(isset($_SESSION['queryFuncionarioAtendimento1Falha'])){
						echo "<h2>Atendimentos</h2>";
						echo "<p class='text-danger'>".$_SESSION['queryFuncionarioAtendimento1Falha']."</p>";				
						unset($_SESSION['queryFuncionarioAtendimento1Falha']);}
				}
				else{
					if(isset($_SESSION['queryFuncionario1Falha'])){
						echo "<p class='text-danger'>".$_SESSION['queryFuncionario1Falha']."</p>";
						unset($_SESSION['queryFuncionario1Falha']);					
					}
				}
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
	<div class='push' style="height: 87px;"></div>
    <div id="footer"></div>
</body>
</html>