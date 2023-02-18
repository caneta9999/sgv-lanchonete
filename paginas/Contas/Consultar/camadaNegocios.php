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
$send=filter_input(INPUT_POST,'consultarContaSubmit',FILTER_SANITIZE_STRING);
if($send){
	$codigo = filter_input(INPUT_POST,'codigo',FILTER_SANITIZE_NUMBER_INT);
	$nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
    try{
	$naocadastrado=0;	
	if($nome != ""){
		if(strlen($nome)<1 || strlen($nome) > 50){
			$nome = "ContaSemNome";
		}
		$nome = "%".$nome."%";
		$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb WHERE nomeConta like :nome";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->bindParam(':nome',$nome);
		$select_msg_cont->execute();
			foreach($select_msg_cont->fetchAll() as $linha_array){
				$_SESSION['queryConta1Falha'] = $linha_array['quantidade'];
				if($linha_array['quantidade'] < 1){
					$naocadastrado = 1;
					$_SESSION['queryConta1Falha'] = "Não há itens registrados com essas especificações";}}
		if($naocadastrado == 0){
	    $result_msg_cont = "SELECT * FROM $db.$tb WHERE nomeConta like :nome";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->execute(['nome' => $nome]);}
	}else{
		if($codigo < 0 || $codigo>99999999999 || !(is_numeric($codigo))){
			$codigo = 0;
		}
		$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb WHERE codigoConta=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->bindParam(':codigo',$codigo);
		$select_msg_cont->execute();
			foreach($select_msg_cont->fetchAll() as $linha_array){
				if($linha_array['quantidade'] < 1){
					$naocadastrado = 1;
					$_SESSION['queryConta1Falha'] = "Não há itens registrados com essas especificações";}}		
	    if($naocadastrado == 0){
		$result_msg_cont = "SELECT * FROM $db.$tb WHERE codigoConta=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->execute(['codigo' => $codigo]);}
	}
	if($naocadastrado == 0){
	unset($_SESSION['queryConta1Falha']);
	$_SESSION['queryConta1'] = $select_msg_cont->fetchAll();
	$_SESSION['mensagemFinalizacao'] = 'Operação finalizada com sucesso!';}
	header("Location: ./consultarContas.php");	
}
    catch(PDOException $e) {
            $msgErr = "Erro na consulta:<br />" . $e->getMessage();
            $_SESSION['msgErr'] = $msgErr;
			header("Location: ../indexContas.php");		
    }
}else{
	$_SESSION['msgErr'] = "<p>A consulta não conseguiu ser iniciada</p>";
	header("Location: ../indexContas.php");
}
?>
