<?php
session_start();
if (!isset($_SESSION['login'])) {
	header('location:../../Login/login.php');
}
?>
<?php
require '../../../CamadaDados/conectar.php';
require '../../../php/formatarReais.php';
$tb = "Comanda";
$tb2 = "Recebimento";
$tb3 = "Conta";
$tb4 = "Produto";
$tb5 = "ItemComanda";
$tb6 = "Atendimento";
$send = filter_input(INPUT_POST, 'comandaSubmit', FILTER_SANITIZE_STRING);
if ($send) {
	//Obtém e filtra os dados recebidos do formulário
	$itens = filter_input(INPUT_POST, 'itens', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
	$codigoConta = filter_input(INPUT_POST, 'codigoConta', FILTER_SANITIZE_NUMBER_INT);
	$quantiaDinheiro = filter_input(INPUT_POST, 'quantiaDinheiro', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$quantiaCartao = filter_input(INPUT_POST, 'quantiaCartao', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$quantiaPix = filter_input(INPUT_POST, 'quantiaPix', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

	//Valida e insere no banco de dados, caso esteja tudo certo
	try {

		//Obtém os códigos dos produtos e calcula o valor total da comanda
		$itensArray = explode(" ", $itens);
		$valorTotal = 0;
		$erro = "";
		foreach ($itensArray as $itemArray) {
			$result_msg_cont = "SELECT * FROM $db.$tb4 WHERE codigoProduto=:codigo";
			$select_msg_cont = $conx->prepare($result_msg_cont);
			$itemArraySeparado = explode(";", $itemArray);
			$select_msg_cont->execute(['codigo' => $itemArraySeparado[0]]);
			$select_msg_cont = $select_msg_cont->fetchAll();
			if ($select_msg_cont != null) {
				foreach ($select_msg_cont as $linha_array) {
					if ($itemArraySeparado[1] == 0) {
						$erro = "A COMANDA POSSUI UM OU MAIS ITENS COM QUANTIDADE IGUAL A ZERO. COMANDA NÃO CADASTRADA!";
						break 2;
					} else if ($itemArraySeparado[1] < 0) {
						$erro = "A COMANDA POSSUI UM OU MAIS ITENS COM QUANTIDADE NEGATIVA. COMANDA NÃO CADASTRADA!";
						break 2;
					} else {
						$valorTotal += $linha_array['valorProduto'] * $itemArraySeparado[1];
					}
				}
			} else {
				$erro = "UM OU MAIS PRODUTOS INSERIDOS NÃO ESTÃO CADASTRADOS. COMANDA NÃO CADASTRADA!";
				break;
			}
		}


		//Antes de prosseguir, confirma se nenhum valor inválido foi encontrado nos itens
		if ($erro == "") {
			//Se um valor errôneo foi inserido no status, corrige
			if (($status != 0 and $status != 1) or ($status == null)) {
				$status = 1;
			}

			//Obtém o código da conta
			$result_msg_cont = "SELECT count(*) 'quantidade' FROM $db.$tb3 WHERE codigoConta=:codigoConta";
			$select_msg_cont = $conx->prepare($result_msg_cont);
			$select_msg_cont->bindParam(':codigoConta', $codigoConta);
			$select_msg_cont->execute();

			//Se não houver exatamente 1 código de conta, então significa que não foi inserido um código de conta ou foi inserido um código
			$cadastrada = 1;
			foreach ($select_msg_cont->fetchAll() as $linha_array) {
				if ($linha_array['quantidade'] != 1) {
					$cadastrada = 0;
				}
			}
			
			//Se nenhum dos valores é negativo, calcula o total de recebimentos e arredonda caso haja alguma conta cadastrada
			if ($cadastrada) {
				if (($quantiaDinheiro < 0 and $quantiaDinheiro != "") or ($quantiaCartao < 0 and $quantiaCartao != "") or ($quantiaPix < 0 and $quantiaPix !="")) {
					$totalRecebimento = -1;
				} else {
					$totalRecebimento = (float)$quantiaDinheiro + (float)$quantiaCartao + (float)$quantiaPix;
					round($totalRecebimento, 2);
				}
			}

			//Se:
			//Valor recebido é maior ou igual ao valor total da comanda OU a comanda está aberta E 
			//Valor da comanda é maior que 0 E
			//Valor do recebimento é maior que 0 com a comanda fechada OU a comanda está aberta E
			//Valor da comanda não é muito grande E
			//Valor do recebimento não é muito grande E
			//Não há conta cadastrada mas a comanda está aberta OU Há conta cadastrada com a comanda fechada
			//ENTÃO: Insere no banco de dados
			if ((($totalRecebimento >= $valorTotal and $status == 1) or ($status == 0)) and $valorTotal > 0 and (($totalRecebimento > 0 and $status == 1) or ($status == 0)) and $valorTotal <= 999999999.99 and $totalRecebimento <= 999999999.99 and (($cadastrada == 0 and $status == 0) or ($cadastrada == 1 and $status == 1))) {
				//Insere comanda no banco de dados
				$result_msg_cont = "INSERT INTO $db.$tb (valorTotalComanda,fechadaComanda,trocoComanda) VALUES (:valorTotalComanda,:status,:trocoComanda)";
				$insert_msg_cont = $conx->prepare($result_msg_cont);
				if ($status == 1) {
					$troco = round($totalRecebimento - $valorTotal, 2);
					if ($troco) {
						$_SESSION['comandaResultado'] = 'Valor do troco: ' . formatarReais($troco);
					} else {
						$_SESSION['comandaResultado'] = 'Sem troco!';
					}
				} else {
					$troco = 0;
				}
				$insert_msg_cont->execute([':valorTotalComanda' => $valorTotal, ':status' => $status, ':trocoComanda' => $troco]);


				//Pega o código da comanda que acabou de ser inserida
				$codigo = $conx->lastInsertId();

				//Insere o atendimento no banco de dados
				$result_msg_cont = "INSERT INTO $db.$tb6 (Funcionario_codigoFuncionario, Comanda_codigoComanda, dataHoraAtendimento, status) VALUES (:codigoFuncionario,:codigoComanda, now(), :status)";
				$insert_msg_cont = $conx->prepare($result_msg_cont);
				$codigoFuncionario = $_SESSION['loginCodigo'];
				$insert_msg_cont->execute([':codigoFuncionario' => $codigoFuncionario, ':codigoComanda' => $codigo, ':status' => $status]);

				//Insere os itens de comanda no banco de dados
				foreach ($itensArray as $itemArray) {
					$result_msg_cont = "INSERT INTO $db.$tb5 (Produto_codigoProduto,Comanda_codigoComanda,quantidadeItemComanda) VALUES (:codigoProduto,:codigoComanda,:quantidade)";
					$insert_msg_cont = $conx->prepare($result_msg_cont);
					$itemArraySeparado = explode(";", $itemArray);
					$insert_msg_cont->bindParam(':codigoProduto', $itemArraySeparado[0]);
					$insert_msg_cont->bindParam(':codigoComanda', $codigo);
					$insert_msg_cont->bindParam(':quantidade', $itemArraySeparado[1]);
					$insert_msg_cont->execute();
				}

				//Se a conta estiver cadastrada com a comanda fechada, atualiza o saldo da conta e insere os recebimentos no banco de dados
				if ($cadastrada == 1 and $status == 1) {
					//Busca a conta e atualiza o seu saldo
					$result_msg_cont = "SELECT * FROM $db.$tb3 WHERE codigoConta=:codigoConta";
					$select_msg_cont = $conx->prepare($result_msg_cont);
					$select_msg_cont->execute(['codigoConta' => $codigoConta]);
					$select_msg_cont = $select_msg_cont->fetchAll();
					$saldoNovoConta = $valorTotal;
					foreach ($select_msg_cont as $linha_array) {
						$saldoNovoConta += $linha_array['saldoConta'];
					}
					$result_msg_cont = "UPDATE $db.$tb3 SET saldoConta=:saldoConta WHERE codigoConta = :codigo";
					$update_msg_cont = $conx->prepare($result_msg_cont);
					$update_msg_cont->execute(['codigo' => $codigoConta, 'saldoConta' => $saldoNovoConta]);
					$conx->exec('set foreign_key_checks = 0');

					//Se a quantia de dinheiro for maior que 0, insere o recebimento no banco de dados
					if ($quantiaDinheiro > 0) {
						$result_msg_cont = "INSERT INTO $db.$tb2 (metodoPagamentoRecebimento,Conta_codigoConta,Comanda_codigoComanda,valorRecebimento) VALUES (:metodoPagamentoRecebimento,:Conta_codigoConta,:Comanda_codigoComanda,:valorRecebimento)";
						$insert_msg_cont = $conx->prepare($result_msg_cont);
						$metodo = "Dinheiro";
						$insert_msg_cont->execute(['metodoPagamentoRecebimento' => $metodo, 'Conta_codigoConta' => $codigoConta, 'Comanda_codigoComanda' => $codigo, 'valorRecebimento' => $quantiaDinheiro]);
					}

					//Se a quantia de cartão for maior que 0, insere o recebimento no banco de dados
					if ($quantiaCartao > 0) {
						$result_msg_cont = "INSERT INTO $db.$tb2 (metodoPagamentoRecebimento,Conta_codigoConta,Comanda_codigoComanda,valorRecebimento) VALUES (:metodoPagamentoRecebimento,:codigoConta,:codigoComanda,:valorRecebimento)";
						$insert_msg_cont = $conx->prepare($result_msg_cont);
						$metodo = "Cartão";
						$insert_msg_cont->execute(['metodoPagamentoRecebimento' => $metodo, 'codigoConta' => $codigoConta, 'codigoComanda' => $codigo, 'valorRecebimento' => $quantiaCartao]);
					}

					//Se a quantia de Pix for maior que 0, insere o recebimento no banco de dados
					if ($quantiaPix > 0) {
						$result_msg_cont = "INSERT INTO $db.$tb2 (metodoPagamentoRecebimento,Conta_codigoConta,Comanda_codigoComanda,valorRecebimento) VALUES (:metodoPagamentoRecebimento,:codigoConta,:codigoComanda,:valorRecebimento)";
						$insert_msg_cont = $conx->prepare($result_msg_cont);
						$metodo = "Pix";
						$insert_msg_cont->execute(['metodoPagamentoRecebimento' => $metodo, 'codigoConta' => $codigoConta, 'codigoComanda' => $codigo, 'valorRecebimento' => $quantiaPix]);
					}
				}

				//Encerra a inserção com sucesso
				$_SESSION['mensagemFinalizacao'] = 'Operação finalizada com sucesso!';
			} else {
				if ($valorTotal == 0) {
					$_SESSION['comandaResultado2'] = 'A COMANDA ESTÁ VAZIA. COMANDA NÃO CADASTRADA!';
				} else if ($valorTotal < 0) {
					$_SESSION['comandaResultado2'] = 'A COMANDA POSSUI UM VALOR TOTAL NEGATIVO. COMANDA NÃO CADASTRADA!';
				} else if ($valorTotal > 999999999.99) {
					$_SESSION['comandaResultado2'] = 'O VALOR DA COMANDA É GRANDE DEMAIS! COMANDA NÃO CADASTRADA!';
				} else if ($cadastrada == 0 and $status == 1) {
					$_SESSION['comandaResultado2'] = 'INSIRA UM CÓDIGO VÁLIDO PARA A CONTA. COMANDA NÃO CADASTRADA!';
				} else if ($totalRecebimento == 0) {
					$_SESSION['comandaResultado2'] = 'O TOTAL DO RECEBIMENTO É NULO. COMANDA NÃO CADASTRADA!';
				} else if ($totalRecebimento < 0) {
					$_SESSION['comandaResultado2'] = 'UM OU MAIS VALORES RECEBIDOS SÃO NEGATIVOS. COMANDA NÃO CADASTRADA!';
				} else if ($cadastrada == 1 and $status == 0) {
					$_SESSION['comandaResultado2'] = 'NÃO É POSSÍVEL INSERIR RECEBIMENTOS COM A COMANDA ABERTA. COMANDA NÃO CADASTRADA!';
				} else if ($totalRecebimento > 999999999.99) {
					$_SESSION['comandaResultado2'] = 'O VALOR DO RECEBIMENTO É GRANDE DEMAIS! COMANDA NÃO CADASTRADA!';
				} else if ($totalRecebimento < $valorTotal) {
					$_SESSION['comandaResultado2'] = 'VALOR INSUFICIENTE! COMANDA NÃO CADASTRADA!';
				} else {
					$_SESSION['comandaResultado2'] = 'UM PROBLEMA ACONTECEU DURANTE O CADASTRO DA COMANDA. COMANDA NÃO CADASTRADA!';
				}
			}
		} else {
			$_SESSION['comandaResultado2'] = $erro;
		}
		header("Location: ../indexComandas.php");
	} catch (PDOException $e) {
		$msgErr = "Erro na inclusão:<br />" . $e->getMessage();
		$_SESSION['msgErr'] = $msgErr;
		header("Location: ../indexComandas.php");
	}
} else {
	$_SESSION['msgErr'] = "<p>A inclusão não conseguiu ser iniciada</p>";
	header("Location: ../indexComandas.php");
}
?>