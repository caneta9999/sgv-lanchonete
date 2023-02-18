<?php
session_start();
if(!isset($_SESSION['login']))
{
		header('location:../../Login/login.php');	
  }
?>
<!DOCTYPE html>
<html lang="en">
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
		require '../../../php/formatarReais.php';
		if(isset($_SESSION['mensagemFinalizacao'])){
			echo "<p class='text-success'>".$_SESSION['mensagemFinalizacao']."</p>";
			unset($_SESSION['mensagemFinalizacao']);
		}?>
        <h1 class="titulos">Listar produtos cadastrados</h1>
		<input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = '../indexProdutos.php'">
		<br/>
		<form id="formCadastros" method="POST" action="camadaNegocios.php">
            <input name="listarProdutoSubmit" class='btn btn-large col-sm-15 btn-produtos' type="submit" value="Listar" />
        </form>
		<?php
				if(isset($_SESSION['queryProduto2'])){
				echo "<table class='sortable'>";
				echo "<thead>";
					echo"<tr>";
					  echo"<th >Código</th>";
					  echo"<th >Nome</th>";
					  echo"<th >Valor</th>";
					echo"</tr>";
				echo "</thead>";
				echo "<tbody>";
				foreach($_SESSION['queryProduto2'] as $linha_array) {
				echo "<tr>";
                echo "<td>". $linha_array['codigoProduto'] ."</td>";        
                echo "<td>". $linha_array['nomeProduto'] ."</td>";
                echo "<td>". formatarReais($linha_array['valorProduto']) ."</td>";
				echo "</tr>";}
				echo  "</tbody>";
				echo "</table>";
				unset($_SESSION['queryProduto2']);
				}
				else{
					if(isset($_SESSION['queryProduto2Falha'])){
					echo "<p class='text-danger'>".$_SESSION['queryProduto2Falha']."</p>";
					unset($_SESSION['queryProduto2Falha']);}
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
	<div class='push' style="height: 355px;"></div>
    <div id="footer"></div>
</body>
</html>