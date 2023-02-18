<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login']!=1)
{
		header('location:../../Login/login.php');	
  }
?>
<?php
require '../../../CamadaDados/conectar.php';
$tb = 'Produto';
$send=filter_input(INPUT_POST,'alterarProdutoSubmit',FILTER_SANITIZE_STRING);
if($send){
	$nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
	$valor = filter_input(INPUT_POST,'valor',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
	$codigo = filter_input(INPUT_POST,'codigo',FILTER_SANITIZE_NUMBER_INT);
    try{
	if(strlen($nome)<1 || strlen($nome) > 50){
		$nome = "ProdutoSemNome".rand(0,500);
	}
	if($valor < 0 || $valor>999999999.99 || !(is_numeric($valor))){
		$valor = 0;
	}
	if($codigo < 0 || $codigo>99999999999 || !(is_numeric($codigo))){
		$codigo = 0;
	}
	$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb Where nomeProduto=:nome and codigoProduto!=:codigo";
    $select_msg_cont = $conx->prepare($result_msg_cont);
    $select_msg_cont->bindParam(':nome',$nome);
    $select_msg_cont->bindParam(':codigo',$codigo);
	$select_msg_cont->execute();
	foreach($select_msg_cont as $linha_array){
		if($linha_array['quantidade'] > 0){
			$_SESSION['msgErr'] = "Já existe um produto com esse nome";
		}
	}
	if(!(isset($_SESSION['msgErr']))){
    $result_msg_cont = "UPDATE $db.$tb SET nomeProduto = :nome,valorProduto = :valor WHERE codigoProduto=:codigo";
    $update_msg_cont = $conx->prepare($result_msg_cont);
    $update_msg_cont->bindParam(':nome',$nome);
	if($valor < 0){
		$valor = 0;
	}
	$valor = floatval(str_replace(',', '.', $valor));
	$update_msg_cont->bindParam(':valor',$valor);
	$update_msg_cont->bindParam(':codigo',$codigo);
    $update_msg_cont->execute();
    $_SESSION['mensagemFinalizacaoAlteracao'] = 'Operação finalizada com sucesso!';}
    header("Location: ../indexProdutos.php");}
    catch(PDOException $e) {
            $msgErr = "Erro na alteração:<br />" . $e->getMessage();
            $_SESSION['msgErr'] = $msgErr;
			header("Location: ../indexProdutos.php");				
    }
}else{
	$_SESSION['msgErr'] = "<p>A alteração não conseguiu ser iniciada</p>";
	header("Location: ../indexProdutos.php");	
}
?>
