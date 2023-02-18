<?php
/*session_start();
if(!isset($_SESSION['login']))
{
		header('location:../paginas/Login/login.php');	
  }*/
?>
<?php
require ("preparar_conexao.php");
try {
     $conx = new PDO("mysql:host=$host;dbname=$db", $user,$pass); 
     $conx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
     $msgErr =  "Falha de conexão...<br />" . $e->getMessage();
     $_SESSION['msgErr'] = $msgErr; 
} 
?>
