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
$tb = 'Funcionario';
$tb2 = 'Atendimento';
$send=filter_input(INPUT_POST,'excluirFuncionarioSubmit',FILTER_SANITIZE_STRING);
if($send){
	$codigo = filter_input(INPUT_POST,'codigo',FILTER_SANITIZE_NUMBER_INT);
    try{
		if($codigo < 0 || $codigo>99999999999 || !(is_numeric($codigo))){
				$codigo = 0;
		}
		$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb WHERE codigoFuncionario=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->execute(['codigo' => $codigo]);
		foreach($select_msg_cont->fetchAll() as $linha_array){
			if($linha_array['quantidade'] < 1){
				$_SESSION['excluirFuncionarioFalha'] = "Item inexistente, não pode ser deletado!";
				header("Location: ./excluirFuncionarios.php");
			}
		}
		$result_msg_cont = "SELECT * FROM $db.$tb WHERE codigoFuncionario=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->bindParam(':codigo',$codigo);
		$select_msg_cont->execute();
		$select_msg_cont = $select_msg_cont->fetchAll();
		$administrador = 0;
		foreach($select_msg_cont as $linha_array){
			$administrador = $linha_array['administrador'];
		}
		if($codigo == 1){
			$_SESSION['excluirFuncionarioFalha'] = "Não pode excluir o usuário 1";
			header("Location: ./excluirFuncionarios.php");			
		}
		else if($administrador == 1 && $_SESSION['loginCodigo'] != $codigo && $_SESSION['loginCodigo'] != 1){
			$_SESSION['excluirFuncionarioFalha'] = "Não pode excluir outro administrador";
			header("Location: ./excluirFuncionarios.php");
		}
		if(!(isset($_SESSION['excluirFuncionarioFalha']))){
			$result_msg_cont = "DELETE FROM $db.$tb2 WHERE Funcionario_codigoFuncionario=:codigo";
			$delete_msg_cont = $conx->prepare($result_msg_cont);
			$delete_msg_cont->bindParam(':codigo',$codigo);
			$delete_msg_cont->execute();
			$result_msg_cont = "DELETE FROM $db.$tb WHERE codigoFuncionario=:codigo";
			$delete_msg_cont = $conx->prepare($result_msg_cont);
			$delete_msg_cont->bindParam(':codigo',$codigo);
			$delete_msg_cont->execute();
			$_SESSION['mensagemFinalizacao'] = 'Operação finalizada com sucesso!';
			header("Location: ../indexFuncionarios.php");}}
    catch(PDOException $e) {
            $msgErr = "Erro na exclusão:<br />" . $e->getMessage();
            $_SESSION['msgErr'] = $msgErr;        
			header("Location: ../indexFuncionarios.php");	
    }
}else{
	$_SESSION['msgErr'] = "<p>A exclusão não conseguiu ser iniciada</p>";
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
$tb = 'Funcionario';
$tb2 = 'Atendimento';
$send=filter_input(INPUT_POST,'excluirFuncionarioSubmit',FILTER_SANITIZE_STRING);
if($send){
	$codigo = filter_input(INPUT_POST,'codigo',FILTER_SANITIZE_NUMBER_INT);
    try{
		if($codigo < 0 || $codigo>99999999999 || !(is_numeric($codigo))){
				$codigo = 0;
		}
		$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb WHERE codigoFuncionario=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->execute(['codigo' => $codigo]);
		foreach($select_msg_cont->fetchAll() as $linha_array){
			if($linha_array['quantidade'] < 1){
				$_SESSION['excluirFuncionarioFalha'] = "Item inexistente, não pode ser deletado!";
				header("Location: ./excluirFuncionarios.php");
			}
		}
		$result_msg_cont = "SELECT * FROM $db.$tb WHERE codigoFuncionario=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->bindParam(':codigo',$codigo);
		$select_msg_cont->execute();
		$select_msg_cont = $select_msg_cont->fetchAll();
		$administrador = 0;
		foreach($select_msg_cont as $linha_array){
			$administrador = $linha_array['administrador'];
		}
		if($administrador == 1 && $_SESSION['loginCodigo'] != $codigo){
			$_SESSION['excluirFuncionarioFalha'] = "Não pode excluir outro administrador";
			header("Location: ./excluirFuncionarios.php");
		}
		if(!(isset($_SESSION['excluirFuncionarioFalha']))){
			$result_msg_cont = "DELETE FROM $db.$tb2 WHERE Funcionario_codigoFuncionario=:codigo";
			$delete_msg_cont = $conx->prepare($result_msg_cont);
			$delete_msg_cont->bindParam(':codigo',$codigo);
			$delete_msg_cont->execute();
			$result_msg_cont = "DELETE FROM $db.$tb WHERE codigoFuncionario=:codigo";
			$delete_msg_cont = $conx->prepare($result_msg_cont);
			$delete_msg_cont->bindParam(':codigo',$codigo);
			$delete_msg_cont->execute();
			$_SESSION['mensagemFinalizacao'] = 'Operação finalizada com sucesso!';
			header("Location: ../indexFuncionarios.php");}}
    catch(PDOException $e) {
            $msgErr = "Erro na exclusão:<br />" . $e->getMessage();
            $_SESSION['msgErr'] = $msgErr;        
			header("Location: ../indexFuncionarios.php");	
    }
}else{
	$_SESSION['msgErr'] = "<p>A exclusão não conseguiu ser iniciada</p>";
	header("Location: ../indexFuncionarios.php");	
}*/
?>
