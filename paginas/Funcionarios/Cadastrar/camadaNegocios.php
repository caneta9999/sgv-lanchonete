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
$send=filter_input(INPUT_POST,'cadastrarFuncionarioSubmit',FILTER_SANITIZE_STRING);
if($send){
	$nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
	$login = filter_input(INPUT_POST,'login',FILTER_SANITIZE_STRING);
	$senha = filter_input(INPUT_POST,'senha',FILTER_SANITIZE_STRING);
	$CPF = filter_input(INPUT_POST,'cpf',FILTER_SANITIZE_NUMBER_INT);
	$administrador = filter_input(INPUT_POST,'administrador',FILTER_SANITIZE_NUMBER_INT);
    try{
	if(strlen($nome)<1 || strlen($nome) > 100){
		$nome = "FuncionarioSemNome";
	}
	if(strlen($login)<1 || strlen($login) > 50){
		$login = "LoginAleatorio".rand(0,500);
	}
	if(strlen($senha)<8 || strlen($senha)>50){
		$senha = "11111111";
	}
	if($CPF < 1 || $CPF>99999999999 || !(is_numeric($CPF))){
		$CPF = rand(1,99999999999);
	}
	if($administrador != 0 && $administrador !=1){
		$administrador = 0;
	}
	$result_msg_cont = "SELECT count(*) 'NumeroRegistros' FROM $db.$tb WHERE loginFuncionario=:login";
	$select_msg_cont = $conx->prepare($result_msg_cont);
	$select_msg_cont->execute(['login' => $login]);
	foreach($select_msg_cont as $linha_array) {
		$loginExiste = $linha_array['NumeroRegistros'];}
	$result_msg_cont = "SELECT count(*) 'NumeroRegistros' FROM $db.$tb WHERE CPF=:CPF";
	$select_msg_cont = $conx->prepare($result_msg_cont);
	$select_msg_cont->execute(['CPF' => $CPF]);
	foreach($select_msg_cont as $linha_array) {
		$CPFExiste = $linha_array['NumeroRegistros'];}
	if($loginExiste == 0 && $CPFExiste == 0){
	$result_msg_cont = "INSERT INTO $db.$tb (loginFuncionario,nomeFuncionario,senhaFuncionario,CPF,administrador) VALUES (:login,:nome,:senha,:cpf,:administrador)";
    $insert_msg_cont = $conx->prepare($result_msg_cont);
    $insert_msg_cont->bindParam(':nome',$nome);
	$insert_msg_cont->bindParam(':login',$login);
    $insert_msg_cont->bindParam(':senha',$senha);
	if($administrador != 1 and $administrador !=0){
		$administrador = 0;
	}
	$insert_msg_cont->bindParam(':administrador',$administrador);
	$insert_msg_cont->bindParam(':cpf',$CPF);
    $insert_msg_cont->execute();
    $_SESSION['mensagemFinalizacao'] = 'Operação finalizada com sucesso!';}
	else{
		if($loginExiste){
		$_SESSION['msgErr'] = 'Já existe um usuário com esse nome de login';}
		else{
		$_SESSION['msgErr'] = 'Já existe um usuário com esse CPF';
		}
	}
    header("Location: ../indexFuncionarios.php");}
    catch(PDOException $e) {
            $msgErr = "Erro na inclusão:<br />" . $e->getMessage();
            $_SESSION['msgErr'] = $msgErr;      
			header("Location: ../indexFuncionarios.php");			
    }
}else{
	$_SESSION['msgErr'] = "<p>A inclusão não conseguiu ser iniciada</p>";
	header("Location: ../indexFuncionarios.php");	
}
?>
