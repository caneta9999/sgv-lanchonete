<?php
//com usuário master
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login']!=1)
{
		header('location:../../Login/login.php');	
  }
?>
<?php
require '../../../CamadaDados/conectar.php';
$tb = "Funcionario";        
$send=filter_input(INPUT_POST,'alterarFuncionarioConsultarCodigoSubmit',FILTER_SANITIZE_STRING);
if($send){
	$codigo = filter_input(INPUT_POST,'codigo',FILTER_SANITIZE_NUMBER_INT);
    try{
		if($codigo < 0 || $codigo>99999999999 || !(is_numeric($codigo))){
			$codigo = 0;
		}
		$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb WHERE codigoFuncionario=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->bindParam(':codigo',$codigo);
		$select_msg_cont->execute();
		$naocadastrado=0;
		foreach($select_msg_cont->fetchAll() as $linha_array){
			if($linha_array['quantidade'] != 1){
				$naocadastrado = 1;
				$_SESSION['msgErr'] = "Funcionario não cadastrado";}}
		if($naocadastrado == 0){
				$result_msg_cont = "SELECT * FROM $db.$tb WHERE codigoFuncionario=:codigo";
				$select_msg_cont = $conx->prepare($result_msg_cont);
				$select_msg_cont->bindParam(':codigo',$codigo);
				$select_msg_cont->execute();
				$select_msg_cont = $select_msg_cont->fetchAll();
				$administrador = 0;
				foreach($select_msg_cont as $linha_array){
					$administrador = $linha_array['administrador'];
				}
				if($codigo==1){
					$_SESSION['msgErr'] = "Não pode alterar o usuário 1";	
				}
				else if($administrador == 0 || $_SESSION['loginCodigo'] == $codigo || $_SESSION['loginCodigo'] == 1){
					$_SESSION['queryAlterarFuncionario1'] = $select_msg_cont;
					$_SESSION['mensagemFinalizacao'] = 'Operação finalizada com sucesso!';}
				else{
					$_SESSION['msgErr'] = "Não pode alterar outro administrador";	
				}}
		header("Location: ./alterarFuncionarios.php");		
	}
    catch(PDOException $e) {
            $msgErr = "Erro na consulta:<br />" . $e->getMessage();
            $_SESSION['msgErr'] = $msgErr;
			header("Location: ../indexFuncionarios.php");			
    }
}else{
	$_SESSION['msgErr'] = "<p>A consulta de alterar o funcionario não conseguiu ser iniciada</p>";
	header("Location: ../indexFuncionarios.php");	
}
//sem usuário master
/*session_start();
if(!isset($_SESSION['login']) || $_SESSION['login']!=1)
{
		header('location:../../Login/login.php');	
  }
?>
<?php
require '../../../CamadaDados/conectar.php';
$tb = "Funcionario";        
$send=filter_input(INPUT_POST,'alterarFuncionarioConsultarCodigoSubmit',FILTER_SANITIZE_STRING);
if($send){
	$codigo = filter_input(INPUT_POST,'codigo',FILTER_SANITIZE_NUMBER_INT);
    try{
		if($codigo < 0 || $codigo>99999999999 || !(is_numeric($codigo))){
			$codigo = 0;
		}
		$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb WHERE codigoFuncionario=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->bindParam(':codigo',$codigo);
		$select_msg_cont->execute();
		$naocadastrado=0;
		foreach($select_msg_cont->fetchAll() as $linha_array){
			if($linha_array['quantidade'] != 1){
				$naocadastrado = 1;
				$_SESSION['msgErr'] = "Funcionario não cadastrado";}}
		if($naocadastrado == 0){
				$result_msg_cont = "SELECT * FROM $db.$tb WHERE codigoFuncionario=:codigo";
				$select_msg_cont = $conx->prepare($result_msg_cont);
				$select_msg_cont->bindParam(':codigo',$codigo);
				$select_msg_cont->execute();
				$select_msg_cont = $select_msg_cont->fetchAll();
				$administrador = 0;
				foreach($select_msg_cont as $linha_array){
					$administrador = $linha_array['administrador'];
				}
				if($administrador == 0 || $_SESSION['loginCodigo'] == $codigo){
					$_SESSION['queryAlterarFuncionario1'] = $select_msg_cont;
					$_SESSION['mensagemFinalizacao'] = 'Operação finalizada com sucesso!';}
				else{
					$_SESSION['msgErr'] = "Não pode alterar outro administrador";	
				}}
		header("Location: ./alterarFuncionarios.php");		
	}
    catch(PDOException $e) {
            $msgErr = "Erro na consulta:<br />" . $e->getMessage();
            $_SESSION['msgErr'] = $msgErr;
			header("Location: ../indexFuncionarios.php");			
    }
}else{
	$_SESSION['msgErr'] = "<p>A consulta de alterar o funcionario não conseguiu ser iniciada</p>";
	header("Location: ../indexFuncionarios.php");	
}*/
?>