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
</head>
<body>
    <div class="divListar">
		<div id="navbar"></div>
		<?php
		if(isset($_SESSION['mensagemFinalizacao'])){
		echo "<p class='text-success'>".$_SESSION['mensagemFinalizacao']."</td>";
		unset($_SESSION['mensagemFinalizacao']);
		}
		?>
        <h1 class="titulos">Listar funcionários cadastrados</h1>
        <input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = '../indexFuncionarios.php'">
		<br/>
		<form id="formCadastros" method="POST" action="camadaNegocios.php">
            <input name="listarFuncionarioSubmit" class="inputSubmit btn btn-large col-sm-15 btn-funcionarios"  type="submit" value="Listar" />
        </form>
		<?php
				if(isset($_SESSION['queryFuncionario2'])){
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
				foreach($_SESSION['queryFuncionario2'] as $linha_array) {
				echo "<tr>";
                echo "<td>". $linha_array['codigoFuncionario'] ."</td>";        
                echo  "<td>". $linha_array['nomeFuncionario'] ."</td>";
                echo  "<td>". $linha_array['loginFuncionario'] ."</td>";							
                echo  "<td>". $linha_array['CPF'] ."</td>";				
                echo  "<td>",$linha_array['administrador']?"Sim":"Não"."</td>";		
				echo "</tr>";}
				echo  "</tbody>";
				echo "</table>";
				unset($_SESSION['queryFuncionario2']);
				}
				else{
					if(isset($_SESSION['queryFuncionario2Falha'])){
					echo "<p class='text-danger'>".$_SESSION['queryFuncionario2Falha']."</p>";
					unset($_SESSION['queryFuncionario2Falha']);}
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
	<div class='push' style="height:350px"></div>
    <div id="footer"></div>
</body>
</html>