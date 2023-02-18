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
</head>
<body>
    <div class="divCadastros">
		<div id="navbar"></div>
		<?php
		if(isset($_SESSION['msgComandaFechada'])){
				echo "<p class='text-danger'>".$_SESSION['msgComandaFechada']."</p>";
				unset($_SESSION['msgComandaFechada']);}			
		if(isset($_SESSION['excluirComandaFalha'])){
				echo "<p class='text-danger'>".$_SESSION['excluirComandaFalha']."</p>";
				unset($_SESSION['excluirComandaFalha']);}	
		?>
        <h1 class="titulos">Excluir comanda</h1>
		<input type="button" class="btn btn-light mt-1 mb-3" value="Voltar" onClick="window.location.href = '../indexComandas.php'">
		<br/>
        <form id="formCadastros" method="POST" action="camadaNegocios.php">
            <label for="codigoComandaExcluir">Código:</label> <input class="form-control" id="codigoComandaExcluir" name="codigo" type="number" placeholder="Código da comanda" min="0" max="99999999999" required />
            <input name="excluirComandaSubmit" class="inputSubmit btn btn-large col-sm-15 btn-comandas mb-3" type="submit" value="Excluir" onClick="return confirmarSubmit()"/>
        </form>
		<?php
			require "../../../CamadaDados/conectar.php";
			$tb = "Comanda";
			$result_msg_cont = "SELECT codigoComanda FROM $db.$tb Order By codigoComanda DESC limit 1";
			$select_msg_cont = $conx->prepare($result_msg_cont);
			$select_msg_cont->execute();
			$select_msg_cont = $select_msg_cont->fetchAll();
			foreach($select_msg_cont as $linha_array) {
                echo "<p><b>Código da última comanda inserida </b>: ". $linha_array['codigoComanda'] ."</p>";}
		?>
    </div>
	<script>
		document.onkeyup = function (e){
		if(e.key == 'F2'){
				window.location.href = '../../indexAjuda.php';
		}else if(e.key == 'F8'){
				window.location.href= '../../index.php';
		}else if(e.key== 'F9'){
				window.location.href='../Cadastrar/cadastrarComandas.php';
		}}
		function confirmarSubmit()
		{
		var confirmar=confirm("Você deseja realmente excluir esse elemento?");
		return confirmar? true:false}
	</script>
    <div class='push' style="height: 233px;"></div>
    <div id="footer"></div>
</body>
</html>