<?php
session_start();
if(!isset($_SESSION['login']))
{
		header('location:../../Login/login.php');	
  }
?>
<?php
require '../../../CamadaDados/conectar.php';
$tb = 'Produto';
$send=filter_input(INPUT_POST,'consultarProdutoSubmit',FILTER_SANITIZE_STRING);
if($send){
	$codigo = filter_input(INPUT_POST,'codigo',FILTER_SANITIZE_NUMBER_INT);
	$nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
    try{
	$naocadastrado=0;
	if($nome != ""){
		if(strlen($nome)<1 || strlen($nome) > 50){
			$nome = "ProdutoSemNome";
		}
		$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb WHERE nomeProduto like :nome";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$nome = "%".$nome."%";
		$select_msg_cont->bindParam(':nome',$nome);
		$select_msg_cont->execute();
			foreach($select_msg_cont->fetchAll() as $linha_array){
				if($linha_array['quantidade'] < 1){
					$naocadastrado = 1;
					$_SESSION['queryProduto1Falha'] = "Não há itens registrados com essas especificações";}}
		if($naocadastrado == 0){
	    $result_msg_cont = "SELECT * FROM $db.$tb WHERE nomeProduto like :nome";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->execute(['nome' => $nome]);}
	}else{
		if($codigo < 0 || $codigo>99999999999 || !(is_numeric($codigo))){
			$codigo = 0;
		}	
		$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb WHERE codigoProduto=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->bindParam(':codigo',$codigo);
		$select_msg_cont->execute();
			foreach($select_msg_cont->fetchAll() as $linha_array){
				if($linha_array['quantidade'] < 1){
					$naocadastrado = 1;
					$_SESSION['queryProduto1Falha'] = "Não há itens registrados com essas especificações";}}		
	    if($naocadastrado == 0){
		$result_msg_cont = "SELECT * FROM $db.$tb WHERE codigoProduto=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->execute(['codigo' => $codigo]);}
	}
	if($naocadastrado == 0){
	unset($_SESSION['queryProduto1Falha']);
	$_SESSION['queryProduto1'] = $select_msg_cont->fetchAll();
	$_SESSION['mensagemFinalizacao'] = 'Operação finalizada com sucesso!';}
	header("Location: ./consultarProdutos.php");	
}
    catch(PDOException $e) {
            $msgErr = "Erro na consulta:<br />" . $e->getMessage();
            $_SESSION['msgErr'] = $msgErr;
			header("Location: ../indexProdutos.php");			
    }
}else{
	$_SESSION['msgErr'] = "<p>A consulta não conseguiu ser iniciada</p>";
	header("Location: ../indexProdutos.php");	
}
?>
