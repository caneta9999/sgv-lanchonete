<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
	header('location:../../Login/login.php');
}
?>
<?php
require '../../../CamadaDados/conectar.php';
$tb = "Comanda";
$tb2 = "Recebimento";
$tb3 = "ItemComanda";
$tb4 = "Produto";
$send = filter_input(INPUT_POST, 'alterarComandaConsultarCodigoSubmit', FILTER_SANITIZE_STRING);
if ($send) {
	$codigo = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_NUMBER_INT);
	try {
		$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb WHERE codigoComanda=:codigo";
		$select_msg_cont = $conx->prepare($result_msg_cont);
		$select_msg_cont->bindParam(':codigo', $codigo);
		$select_msg_cont->execute();
		$naocadastrada = 0;
		foreach ($select_msg_cont->fetchAll() as $linha_array) {
			if ($linha_array['quantidade'] != 1) {
				$naocadastrada = 1;
				$_SESSION['msgErr'] = "Comanda não cadastrada";
				header("Location: ./alterarComandas.php");
			}
		}
		if ($naocadastrada == 0) {
			$result_msg_cont = "SELECT * FROM $db.$tb WHERE codigoComanda=:codigo";
			$select_msg_cont = $conx->prepare($result_msg_cont);
			$select_msg_cont->bindParam(':codigo', $codigo);
			$select_msg_cont->execute();
			$_SESSION['queryAlterarComanda1'] = $select_msg_cont->fetchAll();
			foreach ($_SESSION['queryAlterarComanda1'] as $linha_array) {
				$status = $linha_array['fechadaComanda'];
			}
			if ($status == 1) {
				unset($_SESSION['queryAlterarComanda1']);
				$_SESSION['msgErr'] = "Comanda fechada! Não pode ser alterada!";
			} else {
				$_SESSION['codigoComanda'] = $codigo;

				$result_msg_contItensComanda = "SELECT Produto_codigoProduto, quantidadeItemComanda from $db.$tb3 WHERE Comanda_codigoComanda=:codigo";
				$select_msg_cont = $conx->prepare($result_msg_contItensComanda);
				$select_msg_cont->bindParam(':codigo', $codigo);
				$select_msg_cont->execute();
				$codigosProdutos = [];
				$quantidades = [];
				$contador = 0;
				foreach ($select_msg_cont as $linha_array) {
					$codigosProdutos[$contador] = $linha_array['Produto_codigoProduto'];
					$quantidades[$contador] = $linha_array['quantidadeItemComanda'];
					$contador++;
				}
				
				$nomesProdutos = [];
				$valoresProdutos = [];

				$contador = 0;

				$codigosProdutosAlterar = [];
				$itensComandaAlterar = [];

				foreach ($codigosProdutos as $codigoProduto) {
					$codigoProduto = (int) $codigoProduto;
					$codigosProdutosAlterar[$contador] = $codigoProduto;

					$result_msg_contProdutos = "SELECT nomeProduto, valorProduto from $db.$tb4 where codigoProduto=:codigoProduto";
					$select_msg_cont = $conx->prepare($result_msg_contProdutos);
					$select_msg_cont->bindParam(':codigoProduto', $codigoProduto);
					$select_msg_cont->execute();
					foreach ($select_msg_cont as $linha_array) {
						$nomesProdutos[$contador] = $linha_array['nomeProduto'];
						$valoresProdutos[$contador] = $linha_array['valorProduto'];
					}

					$itensComandaAlterar[$contador] = [
						'codigoProduto' => $codigoProduto,
                        'nomeProduto' => $nomesProdutos[$contador],
                        'quantidade' => $quantidades[$contador],
                        'valorProduto' => $valoresProdutos[$contador] 
					];

					$itensComandaAlterar[$contador] = json_encode($itensComandaAlterar[$contador]);

					$contador++;
				}

				$_SESSION['codigosProdutosAlterar'] = json_encode(json_encode($codigosProdutosAlterar));
				$_SESSION['itensComandaAlterar'] = json_encode(json_encode($itensComandaAlterar));			
			}
			header("Location: ./alterarComandas.php");
		}
	} catch (PDOException $e) {
		$msgErr = "Erro na consulta:<br />" . $e->getMessage();
		$_SESSION['msgErr'] = $msgErr;
		header("Location: ../indexComandas.php");
	}
} else {
	$_SESSION['msgErr'] = "<p>A consulta de alterar a comanda não conseguiu ser iniciada</p>";
	header("Location: ../indexComandas.php");
}
?>
