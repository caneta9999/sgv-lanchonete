<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login']!=1)
{
		header('location:../../Login/login.php');	
  }
?>
<?php
require '../../../CamadaDados/conectar.php';
$tb = "Comanda";        
$tb2 = "Recebimento";                     
$tb4 = "Produto";
$tb5 = "ItemComanda";
$tb6 = "Atendimento";
$tb7 = "Funcionario";
$send=filter_input(INPUT_POST,'consultarComandaSubmit',FILTER_SANITIZE_STRING);
if($send){
	$codigo = filter_input(INPUT_POST,'codigo',FILTER_SANITIZE_NUMBER_INT);
    try{
		if($codigo < 0 || $codigo>99999999999 || !(is_numeric($codigo))){
			$codigo = 0;
		}
		$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb WHERE codigoComanda=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->execute(['codigo' => $codigo]);
		foreach($select_msg_cont->fetchAll() as $linha_array){
			if($linha_array['quantidade'] < 1){
				$_SESSION['queryComanda1Falha'] = 'Não há itens registrados com essas especificações';}
		}
		if(!(isset($_SESSION['queryComanda1Falha']))){
		$result_msg_cont = "SELECT * FROM $db.$tb WHERE codigoComanda=:codigo";
		$result_msg_cont2 = "SELECT Conta_codigoConta,metodoPagamentoRecebimento,valorRecebimento from $db.$tb2 WHERE Comanda_codigoComanda = :codigo";
		$result_msg_cont3 = "SELECT P1.nomeProduto,I1.quantidadeItemComanda,P1.valorProduto from $db.$tb5 I1 inner join $db.$tb4 P1 ON I1.Produto_codigoProduto = P1.codigoProduto Where Comanda_codigoComanda = :codigo";
		$result_msg_cont4 = "SELECT A1.dataHoraAtendimento,F1.nomeFuncionario,A1.status from $db.$tb6 A1 inner join $db.$tb7 F1 ON A1.Funcionario_codigoFuncionario = F1.codigoFuncionario where A1.Comanda_codigoComanda = :codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->execute(['codigo' => $codigo]);
		$select_msg_cont2 = $conx->prepare($result_msg_cont2);
		$select_msg_cont2->execute(['codigo' => $codigo]);
		$select_msg_cont3 = $conx->prepare($result_msg_cont3);
		$select_msg_cont3->execute(['codigo' => $codigo]);
		$select_msg_cont4 = $conx->prepare($result_msg_cont4);
		$select_msg_cont4->execute(['codigo' => $codigo]);		
		$_SESSION['queryComanda1'] = $select_msg_cont->fetchAll();
		$_SESSION['queryComanda2'] = $select_msg_cont2->fetchAll();
		$_SESSION['queryComanda3'] = $select_msg_cont3->fetchAll();
		$_SESSION['queryComanda4'] = $select_msg_cont4->fetchAll();
		$_SESSION['mensagemFinalizacao'] = 'Operação finalizada com sucesso!';}
		header("Location: ./consultarComandas.php");
}
    catch(PDOException $e) {
            $msgErr = "Erro na consulta:<br />" . $e->getMessage();
            $_SESSION['msgErr'] = $msgErr;
			header("Location: ../indexComandas.php");			
    }
}else{
	$_SESSION['msgErr'] = "<p>A consulta não conseguiu ser iniciada</p>";
	header("Location: ../indexComandas.php");	
}
?>
