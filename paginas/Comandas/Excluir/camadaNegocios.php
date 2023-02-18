<?php
session_start();
if(!isset($_SESSION['login']))
{
  header('location:../../Login/login.php');
  }
?>
<?php
require '../../../CamadaDados/conectar.php';
$tb = "Comanda";        
$tb2 = "Recebimento";
$tb3 = "Conta";               
$tb5 = "ItemComanda";
$tb6 = "Atendimento";
$send=filter_input(INPUT_POST,'excluirComandaSubmit',FILTER_SANITIZE_STRING);
if($send){
	$codigo = filter_input(INPUT_POST,'codigo',FILTER_SANITIZE_NUMBER_INT);
    try{
	$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb WHERE codigoComanda=:codigo";
	$select_msg_cont = $conx->prepare($result_msg_cont);
	$select_msg_cont->execute(['codigo' => $codigo]);
	$select_msg_cont = $select_msg_cont->fetchAll();
	foreach($select_msg_cont as $linha_array){
		if($linha_array['quantidade'] < 1){
			$_SESSION['excluirComandaFalha'] = "Item inexistente, não pode ser deletado!";}
	}
	if(!(isset($_SESSION['excluirComandaFalha']))){	
	$result_msg_cont = "SELECT * FROM $db.$tb WHERE codigoComanda=:codigo";
	$select_msg_cont = $conx->prepare($result_msg_cont);
	$select_msg_cont->execute(['codigo' => $codigo]);
	$select_msg_cont = $select_msg_cont->fetchAll();
	foreach($select_msg_cont as $linha_array){
	$valorTotal = $linha_array['valorTotalComanda'];
	$aberta = $linha_array['fechadaComanda'];}
	
	if($aberta == 0 || $_SESSION['login'] == 1){
	if($aberta == 1){		
	$result_msg_cont = "SELECT * FROM $db.$tb2 WHERE Comanda_codigoComanda=:codigo";
	$select_msg_cont = $conx->prepare($result_msg_cont);
	$select_msg_cont->execute(['codigo' => $codigo]);
	$select_msg_cont = $select_msg_cont->fetchAll();
	foreach($select_msg_cont as $linha_array){
	$codigoConta = $linha_array['Conta_codigoConta'];}
	
	$result_msg_cont = "DELETE FROM $db.$tb2 WHERE Comanda_codigoComanda=:codigo";
    $delete_msg_cont = $conx->prepare($result_msg_cont);
	$delete_msg_cont->bindParam(':codigo',$codigo);
	$delete_msg_cont->execute();}		
	$result_msg_cont = "DELETE FROM $db.$tb5 WHERE Comanda_codigoComanda=:codigo";
    $delete_msg_cont = $conx->prepare($result_msg_cont);
	$delete_msg_cont->bindParam(':codigo',$codigo);
	$delete_msg_cont->execute();
	
	$result_msg_cont = "DELETE FROM $db.$tb6 WHERE Comanda_codigoComanda=:codigo";
    $delete_msg_cont = $conx->prepare($result_msg_cont);
	$delete_msg_cont->bindParam(':codigo',$codigo);
	$delete_msg_cont->execute();
	
	$result_msg_cont = "DELETE FROM $db.$tb WHERE codigoComanda=:codigo";
    $delete_msg_cont = $conx->prepare($result_msg_cont);
	$delete_msg_cont->bindParam(':codigo',$codigo);
	$delete_msg_cont->execute();
	if($aberta == 1){	
	$result_msg_cont = "SELECT * FROM $db.$tb3 WHERE codigoConta=:codigoConta";
	$select_msg_cont = $conx->prepare($result_msg_cont);
	$select_msg_cont->execute(['codigoConta' => $codigoConta]);
	$select_msg_cont = $select_msg_cont->fetchAll();
	$saldoNovoConta = $valorTotal;
	foreach($select_msg_cont as $linha_array){
		$saldoNovoConta = $linha_array['saldoConta'] - $saldoNovoConta;
	}
	$result_msg_cont = "UPDATE $db.$tb3 SET saldoConta=:saldoConta WHERE codigoConta = :codigo";
	$update_msg_cont = $conx->prepare($result_msg_cont);
	$update_msg_cont->execute(['codigo'=>$codigoConta,'saldoConta'=>$saldoNovoConta]);}
	$_SESSION['mensagemFinalizacao'] = 'Operação finalizada com sucesso!';
	header("Location: ../indexComandas.php");
	}else{
	$_SESSION['msgComandaFechada'] = 'Comanda fechada, não pode excluir!';
	header("Location: ./excluirComandas.php");}}
	else{
		header("Location: ./excluirComandas.php");
	}
}
    catch(PDOException $e) {
            $msgErr = "Erro na exclusão:<br />" . $e->getMessage();
            $_SESSION['msgErr'] = $msgErr; 
			header("Location: ../indexComandas.php");	
    }
}else{
	$_SESSION['msgErr'] = "<p>A exclusão não conseguiu ser iniciada</p>";
	header("Location: ../indexComandas.php");	
}
?>
