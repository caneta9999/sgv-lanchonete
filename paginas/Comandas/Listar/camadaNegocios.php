<?php
session_start();
if (!isset($_SESSION['login'])) {
	header('location:../../Login/login.php');
}
?>
<?php
require '../../../CamadaDados/conectar.php';
$tb = "Comanda";
$tb6 = "Atendimento";
$send = filter_input(INPUT_POST, 'listarComandaSubmit', FILTER_SANITIZE_STRING);
if ($send) {
	$regexData = "/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/";
	$data1 = filter_input(INPUT_POST, 'dataInicio', FILTER_SANITIZE_STRING);
	$data2 = filter_input(INPUT_POST, 'dataTermino', FILTER_SANITIZE_STRING);
	if(preg_match($regexData, $data1) !=1 || preg_match($regexData,$data2) != 1){
		$data1 = "1900-01-01";
		$data2 = "1900-02-02";
	}
	try {
		$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb C1 inner join $db.$tb6 A1 on C1.codigoComanda = A1.Comanda_codigoComanda where A1.dataHoraAtendimento between :data1 and DATE_ADD(:data2, INTERVAL 1 DAY)";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->execute(['data1' => $data1, 'data2' => $data2]);
		foreach ($select_msg_cont->fetchAll() as $linha_array) {
			if ($linha_array['quantidade'] < 1) {
				$_SESSION['queryComanda5Falha'] = 'Não há itens registrados com essas especificações';
			}
		}
		if (!(isset($_SESSION['queryComanda5Falha']))) {
			$result_msg_cont = "SELECT C1.codigoComanda, C1.valorTotalComanda, C1.fechadaComanda, C1.trocoComanda, A1.dataHoraAtendimento FROM $db.$tb C1 inner join $db.$tb6 A1 on C1.codigoComanda = A1.Comanda_codigoComanda where A1.dataHoraAtendimento between :data1 and DATE_ADD(:data2, INTERVAL 1 DAY)";
			$select_msg_cont = $conx->prepare($result_msg_cont);
			$select_msg_cont->execute(['data1' => $data1, 'data2' => $data2]);
			$_SESSION['queryComanda5'] = $select_msg_cont->fetchAll();
			$_SESSION['mensagemFinalizacao'] = 'Operação finalizada com sucesso!';
		}
		header("Location: ./listarComandas.php");
	} catch (PDOException $e) {
		$msgErr = "Erro na listagem:<br />" . $e->getMessage();
		$_SESSION['msgErr'] = $msgErr;
		header("Location: ../indexComandas.php");
	}
} else {
	$_SESSION['msgErr'] = "<p>A listagem não conseguiu ser iniciada</p>";
	header("Location: ../indexComandas.php");
}
?>
