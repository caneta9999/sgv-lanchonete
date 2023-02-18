<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login']!=1)
{
		header('location:../../Login/login.php');	
  }
?>
<?php
require '../../../CamadaDados/conectar.php';
$tb = "Produto";        
$send=filter_input(INPUT_POST,'alterarProdutoConsultarCodigoSubmit',FILTER_SANITIZE_STRING);
if($send){
	$codigo = filter_input(INPUT_POST,'codigo',FILTER_SANITIZE_NUMBER_INT);
    try{
	if($codigo < 0 || $codigo>99999999999 || !(is_numeric($codigo))){
		$codigo = 0;
	}
			$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb WHERE codigoProduto=:codigo";
			$select_msg_cont = $conx->prepare($result_msg_cont);
			$select_msg_cont->bindParam(':codigo',$codigo);
			$select_msg_cont->execute();
			$naocadastrado=0;
			foreach($select_msg_cont->fetchAll() as $linha_array){
				if($linha_array['quantidade'] != 1){
					$naocadastrado = 1;
					$_SESSION['msgErr'] = "Produto não cadastrado";}}
		if($naocadastrado == 0){
		$result_msg_cont = "SELECT * FROM $db.$tb WHERE codigoProduto=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->bindParam(':codigo',$codigo);
		$select_msg_cont->execute();
		$_SESSION['queryAlterarProduto1'] = $select_msg_cont->fetchAll();
		$_SESSION['mensagemFinalizacao'] = 'Operação finalizada com sucesso!';}
		header("Location: ./alterarProdutos.php");
}
    catch(PDOException $e) {
            $msgErr = "Erro na consulta:<br />" . $e->getMessage();
            $_SESSION['msgErr'] = $msgErr;
			header("Location: ../indexProdutos.php");			
    }
}else{
	$_SESSION['msgErr'] = "<p>A consulta de alterar o produto não conseguiu ser iniciada</p>";
	header("Location: ../indexProdutos.php");	
}
?>