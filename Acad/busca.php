<?php
session_start();
require_once 'bd.php';

if(!isset($_GET['cleinte'])){
    header("Location: pagina_nutri.php");
    exit;
}

$cliente = "%".trim($_GET['cliente'])."%";
$comando = $pdo->prepare('SELECT * FROM cliente WHERE nome = :nome' );
$comando->bindParam(':nome', $nome, PDO::PARAM_STR);
$comando->execute();

$resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
print_r($resultados);exit;

if (count($resulrados)){
    foreach($resulrados as $resulrados){
    echo $resulrados['nome'];
    }
}else{
    echo 'Nao foi encontrado';

}
?>
