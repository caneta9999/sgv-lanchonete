<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login']!=1)
{
		header('location:../../Login/login.php');	
  }
?>
<?php
require '../../../CamadaDados/conectar.php';
$tb = 'Funcionario';
$send=filter_input(INPUT_POST,'listarFuncionarioSubmit',FILTER_SANITIZE_STRING);
if($send){
    try{
	$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb";
	$select_msg_cont = $conx->prepare($result_msg_cont);
	$select_msg_cont->execute();
	foreach($select_msg_cont->fetchAll() as $linha_array){
		if($linha_array['quantidade'] < 1){
			$_SESSION['queryFuncionario2Falha'] = "Não há itens registrados";		
		}
	}
	if(!(isset($_SESSION['queryFuncionario2Falha']))){
	    $result_msg_cont = "SELECT codigoFuncionario, loginFuncionario, nomeFuncionario, CPF, administrador FROM $db.$tb";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->execute();
	$_SESSION['queryFuncionario2'] = $select_msg_cont->fetchAll();
	$_SESSION['mensagemFinalizacao'] = 'Operação finalizada com sucesso!';}
	header("Location: ./listarFuncionarios.php");	
}
    catch(PDOException $e) {
            $msgErr = "Erro na listagem:<br />" . $e->getMessage();
            $_SESSION['msgErr'] = $msgErr;
			header("Location: ../indexFuncionarios.php");			
    }
}else{
	$_SESSION['msgErr'] = "<p>A listagem não conseguiu ser iniciada</p>";
	header("Location: ../indexFuncionarios.php");	
}
?>
