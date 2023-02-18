<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header('location:../../Login/login.php');
}
?>
<?php
require '../../../CamadaDados/conectar.php';
$tb = 'Produto';
$tb2 = 'ItemComanda';
$send = filter_input(INPUT_POST, 'excluirProdutoSubmit', FILTER_SANITIZE_STRING);
if ($send) {
    $codigo = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_NUMBER_INT);
    try {
		if($codigo < 0 || $codigo>99999999999 || !(is_numeric($codigo))){
			$codigo = 0;
		}	
		$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb WHERE codigoProduto=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->execute(['codigo' => $codigo]);
		foreach($select_msg_cont->fetchAll() as $linha_array){
			if($linha_array['quantidade'] < 1){
				$_SESSION['excluirProdutoFalha'] = "Item inexistente, não pode ser deletado!";
				header("Location: ./excluirProdutos.php");
			}
		}
		if(!(isset($_SESSION['excluirProdutoFalha']))){
        $result_msg_cont = "DELETE FROM $db.$tb2 WHERE Produto_codigoProduto=:codigo";
        $delete_msg_cont = $conx->prepare($result_msg_cont);
        $delete_msg_cont->bindParam(':codigo', $codigo);
        $delete_msg_cont->execute();

        $result_msg_cont = "DELETE FROM $db.$tb WHERE codigoProduto=:codigo";
        $delete_msg_cont = $conx->prepare($result_msg_cont);
        $delete_msg_cont->bindParam(':codigo', $codigo);
        $delete_msg_cont->execute();
        $_SESSION['mensagemFinalizacaoExclusao'] = 'Exclusão finalizada com sucesso!';

        header("Location: ../indexProdutos.php");}
    } catch (PDOException $e) {
        $msgErr = "Erro na exclusão:<br />" . $e->getMessage();
        $_SESSION['msgErr'] = $msgErr;
        header("Location: ../indexProdutos.php");
    }
} else {
    $_SESSION['msgErr'] = "<p>A exclusão não conseguiu ser iniciada</p>";
    header("Location: ../indexProdutos.php");
}
?>
