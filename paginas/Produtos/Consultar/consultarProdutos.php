<?php
session_start();
if(!isset($_SESSION['login']))
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
    <div class="divCadastros">
		<div id="navbar"></div>
		<?php
			if(isset($_SESSION['mensagemFinalizacao'])){
				echo "<p class='text-success'>".$_SESSION['mensagemFinalizacao']."</p>";
				unset($_SESSION['mensagemFinalizacao']);
			}
		?>
        <h1 class="titulos">Consultar produto</h1>
		<input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = '../indexProdutos.php'">
        <h2 class="subtitulos">A consulta por nome tem prioridade sobre a pesquisa por código</h2>
        <form id="formCadastros" method="POST" action="camadaNegocios.php">
            <label for="codigoProdutoConsultar">Código:</label><input class="form-control" id="codigoProdutoConsultar" name="codigo" type="number" placeholder="Consultar pelo código" min="0" max="99999999999" />
			<label for="nomeProdutoConsultar">Nome:</label><input class="form-control" id="nomeProdutoConsultar" name="nome" type="text" placeholder="Consultar pelo nome" maxlength="50"  />
            <input name="consultarProdutoSubmit" class='btn btn-large col-sm-15 btn-produtos' type="submit" value="Consultar" />
        </form>
        <?php
				require '../../../php/formatarReais.php';
				if(isset($_SESSION['queryProduto1'])){
				echo "<table class='sortable'>";
				echo "<thead>";
					echo"<tr>";
					  echo"<th >Código</th>";
					  echo"<th >Nome</th>";
					  echo"<th >Valor</th>";
					echo"</tr>";
				echo "</thead>";
				echo "<tbody>";
				foreach($_SESSION['queryProduto1'] as $linha_array) {
				echo "<tr>";
                echo "<td>". $linha_array['codigoProduto'] ."</td>";        
                echo "<td>". $linha_array['nomeProduto'] ."</td>";
                echo "<td>". formatarReais($linha_array['valorProduto']) ."</td>";		
				echo "</tr>";}
				echo  "</tbody>";
				echo "</table>";
				unset($_SESSION['queryProduto1']);
				}
				else{
					if(isset($_SESSION['queryProduto1Falha'])){
						echo "<p class='text-danger'>".$_SESSION['queryProduto1Falha']."</p>";
						unset($_SESSION['queryProduto1Falha']);
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
</body>
<div class='push' style="height: 192px;"></div>
<div id="footer"></div>
</html>