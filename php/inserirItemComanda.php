<?php
session_start();
if(!isset($_SESSION['login']))
{
		header('location:paginas/Login/login.php');	
  }
?>
<?php
   require '../CamadaDados/conectar.php';

   $tb="Produto";

   if (isset($_POST["query"])) {
       $nome = $_POST["query"];
       try {
           if ($nome != "") {
            $result_msg_cont = "SELECT * FROM $db.$tb WHERE nomeProduto = :nome";
            $select_msg_cont = $conx->prepare($result_msg_cont);
            $select_msg_cont->execute(['nome' => $nome]);
            $result = $select_msg_cont->fetchAll();
            
            $result_msg_cont_contagem = "SELECT COUNT(*) FROM $db.$tb WHERE nomeProduto = :nome";
            $select_msg_cont_contagem = $conx->prepare($result_msg_cont_contagem);
            $select_msg_cont_contagem->execute(['nome' => $nome]);
            $result_contagem = $select_msg_cont_contagem->fetchColumn();
            
            if ($result && $result_contagem == 1) {
                foreach($result as $linha) {   
                    $array = [
                        'codigoProduto' => $linha['codigoProduto'],
                        'nomeProduto' => $linha['nomeProduto'],
                        'quantidade' => 1,
                        'valorProduto' => $linha['valorProduto'] 
                    ];
                    echo json_encode($array);
                }
            } else {
                echo 'ERRO';
            }
        }

       } catch (PDOException $e) {
            $msgErr = "Erro na consulta:<br />" . $e->getMessage();
            echo $msgErr;
            $_SESSION['msg'] = $msgErr;
            //header("Location: ./cadastrarComandas.php");	
       }
    }else{
        $_SESSION['msg'] = "<p>Consulta...</p>";
    }
   /*if(isset($_POST['query'])) {
        $inptText=$_POST['query'];
        $query="SELECT $tb FROM $db WHERE nomeProduto LIKE '%inpText%'";
        $result = $conx->query($query);
        ;     
        echo "<p class='list-group-item border-1'>Não existe</p>";
    }*/
?>