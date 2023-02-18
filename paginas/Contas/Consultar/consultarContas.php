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
    <div class="divCadastros" >
	    <div id="navbar"></div>
		<?php
			if(isset($_SESSION['mensagemFinalizacao'])){
				echo "<p class='text-success'>".$_SESSION['mensagemFinalizacao']."</p>";
				unset($_SESSION['mensagemFinalizacao']);
			}
		?>
        <h1 class="titulos">Consultar conta</h1>
		<input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = '../indexContas.php'">
		<h2 class="subtitulos">A consulta por nome tem prioridade sobre a pesquisa por código</h2>
        <form id="formCadastros" method="POST" action="camadaNegocios.php">
            <label for="codigoContaConsultar">Código:</label> <input id="codigoContaConsultar" class="form-control" name="codigo" type="number" placeholder="Código da conta"  min="0" max="99999999999"/>
			<label for="nomeContaConsultar">Nome:</label> <input id="nomeContaConsultar" class="form-control" name="nome" type="text" placeholder="Nome da conta" maxlength="50"/>
            <input name="consultarContaSubmit" class="inputSubmit btn btn-large col-sm-15 btn-contas" type="submit" value="Consultar" />
        </form>
		<?php
				require '../../../php/formatarReais.php';
				if(isset($_SESSION['queryConta1'])){
				echo "<table class='sortable'>";
				echo "<thead>";
					echo"<tr>";
					  echo"<th >Código</th>";
					  echo"<th >Nome</th>";
					  echo"<th >Saldo</th>";
					echo"</tr>";
				echo "</thead>";
				echo "<tbody>";
				foreach($_SESSION['queryConta1'] as $linha_array) {
				echo "<tr>";
                echo "<td>". $linha_array['codigoConta'] ."</td>";        
                echo "<td>". $linha_array['nomeConta'] ."</td>";
                echo "<td>". formatarReais($linha_array['saldoConta']) ."</td>";		
				echo "</tr>";}
				echo  "</tbody>";
				echo "</table>";
				unset($_SESSION['queryConta1']);
				}
				else{
				if(isset($_SESSION['queryConta1Falha'])){
					echo "<p class='text-danger'>".$_SESSION['queryConta1Falha']."</p>";
					unset($_SESSION['queryConta1Falha']);
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
	<div class='push' style="height: 187px;"></div>
    <div id="footer"></div>
</body>
</html>