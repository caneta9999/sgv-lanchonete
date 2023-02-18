<?php
session_start();
require '../../CamadaDados/conectar.php';
$tb = 'Funcionario';
$send=filter_input(INPUT_POST,'loginSubmit',FILTER_SANITIZE_STRING);
if($send){
	$login = filter_input(INPUT_POST,'login',FILTER_SANITIZE_STRING);
	$senha = filter_input(INPUT_POST,'senha',FILTER_SANITIZE_STRING);
    try{
		if(strlen($login)<1 || strlen($login) > 50){
			$login = "";
		}
		if(strlen($senha)<8 || strlen($senha)>50){
			$senha = "";
		}
		$result_msgLogin_cont = "SELECT codigoFuncionario,senhaFuncionario,administrador FROM $db.$tb WHERE loginFuncionario=:login";
		$linha_array = $conx->prepare($result_msgLogin_cont);
		$linha_array->execute([':login'=>$login]);
		$linha_array = $linha_array->fetchAll();
		if(!$linha_array){
				unset ($_SESSION['login']);
				$_SESSION['msgLogin'] = 'Login inexistente';
				header("Location: ./login.php");}

		else{
		foreach($linha_array as $linha_array) {
				if((strcmp($linha_array['senhaFuncionario'], $senha))==0){
					unset ($_SESSION['msgLogin']);
					$_SESSION['loginCodigo'] = $linha_array['codigoFuncionario'];
					if($linha_array['administrador'] == 1){
						$_SESSION['login'] = 1;
					}else{
						$_SESSION['login'] = 2;}
					header("Location: ../index.php");	
				}else{
					unset ($_SESSION['login']);
					$_SESSION['msgLogin'] = 'Senha errada';
					header("Location: ./login.php");}}}
		}
    catch(PDOException $e) {
            $msgLoginErr = "Erro no login:<br />" . $e->getMessage();
            $_SESSION['msgLogin'] = $msgLoginErr;      
			header("Location: ./login.php");			
    }
}else{
	$_SESSION['msgLogin'] = "<p>msgLogin não enviada</p>";
	header("Location: ./login.php");	
}
?>
