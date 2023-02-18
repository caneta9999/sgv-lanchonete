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
$tb2 = 'Atendimento';
$send=filter_input(INPUT_POST,'consultarFuncionarioSubmit',FILTER_SANITIZE_STRING);
if($send){
	$codigo = filter_input(INPUT_POST,'codigo',FILTER_SANITIZE_NUMBER_INT);
	$nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
	$login = filter_input(INPUT_POST,'login',FILTER_SANITIZE_STRING);
    try{
	$naocadastrado=0;
	if($nome != ""){
		if(strlen($nome)<1 || strlen($nome) > 100){
			$nome = "FuncionarioSemNome";
		}
		$nome = "%".$nome."%";
		$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb WHERE nomeFuncionario like :nome";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->bindParam(':nome',$nome);
		$select_msg_cont->execute();
			foreach($select_msg_cont->fetchAll() as $linha_array){
				$_SESSION['queryFuncionario1Falha'] = $linha_array['quantidade'];
				if($linha_array['quantidade'] < 1){
					$naocadastrado = 1;
					$_SESSION['queryFuncionario1Falha'] = "Não há itens registrados com essas especificações";}}
		if($naocadastrado == 0){
	    $result_msg_cont = "SELECT codigoFuncionario, loginFuncionario, nomeFuncionario, CPF, administrador FROM $db.$tb WHERE nomeFuncionario like :nome";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->execute(['nome' => $nome]);}
	}else if($login!=""){
		if(strlen($login)<1 || strlen($login) > 50){
			$login = "LoginAleatorio";
		}
		$login = "%".$login."%";
		$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb WHERE loginFuncionario like :login";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->bindParam(':login',$login);
		$select_msg_cont->execute();
			foreach($select_msg_cont->fetchAll() as $linha_array){
				$_SESSION['queryFuncionario1Falha'] = $linha_array['quantidade'];
				if($linha_array['quantidade'] < 1){
					$naocadastrado = 1;
					$_SESSION['queryFuncionario1Falha'] = "Não há itens registrados com essas especificações";}}
		if($naocadastrado == 0){
	    $result_msg_cont = "SELECT codigoFuncionario, loginFuncionario, nomeFuncionario, CPF, administrador FROM $db.$tb WHERE loginFuncionario like :login";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->execute(['login' => $login]);}
	}else{
		if($codigo < 0 || $codigo>99999999999 || !(is_numeric($codigo))){
			$codigo = 0;
		}
		$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb WHERE codigoFuncionario=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->bindParam(':codigo',$codigo);
		$select_msg_cont->execute();
			foreach($select_msg_cont->fetchAll() as $linha_array){
				if($linha_array['quantidade'] < 1){
					$naocadastrado = 1;
					$_SESSION['queryFuncionario1Falha'] = "Não há itens registrados com essas especificações";}}		
	    if($naocadastrado == 0){
		$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb2 WHERE Funcionario_codigoFuncionario=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->bindParam(':codigo',$codigo);
		$select_msg_cont->execute();
		foreach($select_msg_cont->fetchAll() as $linha_array){
			if($linha_array['quantidade'] < 1){
				$_SESSION['queryFuncionarioAtendimento1Falha'] = 'Não há atendimentos registrados para esse funcionário';
			}
			else{
				$result_msg_cont = "SELECT codigoAtendimento,Comanda_codigoComanda,dataHoraAtendimento FROM $db.$tb2 WHERE Funcionario_codigoFuncionario=:codigo";
				$select_msg_cont = $conx->prepare($result_msg_cont);
				$select_msg_cont->bindParam(':codigo',$codigo);
				$select_msg_cont->execute();				
				$_SESSION['queryFuncionarioAtendimento1'] = $select_msg_cont->fetchAll();
			}
		}
		$result_msg_cont = "SELECT codigoFuncionario, loginFuncionario, nomeFuncionario, CPF, administrador FROM $db.$tb WHERE codigoFuncionario=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->execute(['codigo' => $codigo]);}
	}
	if($naocadastrado == 0){
	unset($_SESSION['queryFuncionario1Falha']);
	$_SESSION['queryFuncionario1'] = $select_msg_cont->fetchAll();
	$_SESSION['mensagemFinalizacao'] = 'Operação finalizada com sucesso!';}
	header("Location: ./consultarFuncionarios.php");	
}
    catch(PDOException $e) {
            $msgErr = "Erro na consulta:<br />" . $e->getMessage();
            $_SESSION['msgErr'] = $msgErr;
			header("Location: ../indexFuncionarios.php");			
    }
}else{
	$_SESSION['msgErr'] = "<p>A consulta não conseguiu ser iniciada</p>";
	header("Location: ../indexFuncionarios.php");					
}
?>
