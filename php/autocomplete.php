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
            $result_msg_cont = "SELECT * FROM $db.$tb WHERE nomeProduto LIKE :nome ORDER BY nomeProduto LIMIT 10";
            $select_msg_cont = $conx->prepare($result_msg_cont);
            $select_msg_cont->execute(['nome' => '%' . $nome . '%']);
            $result = $select_msg_cont->fetchAll();
            if ($result) {
                foreach($result as $linha) {   
                    echo "<a href='#' class='list-group-item list-group-item-action anchorOpcoes' style='z-index: 10;'>".$linha['nomeProduto']."</a>";
                }
            } else {
                echo '<p class="list-group-item border-1">Sem resultados</p>';
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