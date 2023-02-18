<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login']!=1)
{
		header('location:../../Login/login.php');	
  }
?>
<?php
require '../../../CamadaDados/conectar.php';
$tb = 'Conta';
$send=filter_input(INPUT_POST,'cadastrarContaSubmit',FILTER_SANITIZE_STRING);
if($send){
	$nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
	$saldo = filter_input(INPUT_POST,'saldo',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    try{
	if(strlen($nome)<1 || strlen($nome) > 50){
		$nome = "ContaSemNome".rand(0,500);
	}
	if($saldo < -999999999.99 || $saldo>999999999.99 || !(is_numeric($saldo))){
		$saldo = 0;
	}
    $result_msg_cont = "INSERT INTO $db.$tb (nomeConta,saldoConta) VALUES (:nome,:saldo)";
    $insert_msg_cont = $conx->prepare($result_msg_cont);
    $insert_msg_cont->bindParam(':nome',$nome);
	$insert_msg_cont->bindParam(':saldo',$saldo);
    $insert_msg_cont->execute();
    $_SESSION['mensagemFinalizacao'] = 'Operação finalizada com sucesso!';
    header("Location: ../indexContas.php");	
	}
    catch(PDOException $e) {
            $msgErr = "Erro na inclusão:<br />" . $e->getMessage();
            $_SESSION['msgErr'] = $msgErr;     
			header("Location: ../indexContas.php");			
    }
}else{
	$_SESSION['msgErr'] = "<p>A inclusão não conseguiu ser iniciada</p>";
	header("Location: ../indexContas.php");	
}
?>
