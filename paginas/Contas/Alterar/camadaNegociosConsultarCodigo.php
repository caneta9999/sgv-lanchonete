<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login']!=1)
{
		header('location:../../Login/login.php');	
  }
?>
<?php
require '../../../CamadaDados/conectar.php';
$tb = "Conta";        
$send=filter_input(INPUT_POST,'alterarContaConsultarCodigoSubmit',FILTER_SANITIZE_STRING);
if($send){
	$codigo = filter_input(INPUT_POST,'codigo',FILTER_SANITIZE_NUMBER_INT);
    try{
	if($codigo < 0 || $codigo>99999999999 || !(is_numeric($codigo))){
		$codigo = 0;
	}
			$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb WHERE codigoConta=:codigo";
			$select_msg_cont = $conx->prepare($result_msg_cont);
			$select_msg_cont->bindParam(':codigo',$codigo);
			$select_msg_cont->execute();
			$naocadastrado=0;
			foreach($select_msg_cont->fetchAll() as $linha_array){
				if($linha_array['quantidade'] != 1){
					$naocadastrado = 1;
					$_SESSION['msgErr'] = "Conta não cadastrada";}}
		if($naocadastrado == 0){
		$result_msg_cont = "SELECT * FROM $db.$tb WHERE codigoConta=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->bindParam(':codigo',$codigo);
		$select_msg_cont->execute();
		$_SESSION['queryAlterarConta1'] = $select_msg_cont->fetchAll();
		$_SESSION['mensagemFinalizacao'] = 'Operação finalizada com sucesso!';}
		header("Location: ./alterarContas.php");
}
    catch(PDOException $e) {
            $msgErr = "Erro na consulta:<br />" . $e->getMessage();
            $_SESSION['msgErr'] = $msgErr;
			header("Location: ../indexContas.php");			
    }
}else{
	$_SESSION['msgErr'] = "<p>A consulta de alterar a conta não conseguiu ser iniciada</p>";
	header("Location: ../indexContas.php");	
}
?>