<?php
session_start();
require_once 'bd.php';

try{

    if(isset($_POST['emailV'])&& isset ($_POST['senhaV'])){
        $emailV = $_POST['emailV'];
        $senhaV = $_POST['senhaV'];

        $comando = $pdo->prepare('SELECT * FROM cliente WHERE email = :emailV' );
        $comando->bindParam(':emailV', $emailV);
        $comando->execute();
        $resultado = $comando->fetch();
        if ($resultado>0){
            if ($senhaV === $resultado['senha']){
                $_SESSION['autenticado'] = 1;
                $_SESSION['nome_usuario'] = $resultado["nome"];
                $_SESSION['CPF'] = $resultado["codcli"];
                $_SESSION['CRN'] = $resultado["crn"];
                setcookie('autenticado', 'sim', time()+60);
                unset( $_SESSION['autorizado'] ); 
                //header('location: pagina_cliente.php? emailV='.$emailV);
                header('Location: pagina_cliente.php');
                exit();
                
            }
            else{
                setcookie('autenticado', 'nao', time()+60);
                unset( $_SESSION['autorizado'] ); 
                header('location: LoginCli.php');
                exit();
            }      
        }    
        else{
        setcookie('autenticado', 'nao', time()+60);
        header('location: LoginCli.php');
        unset( $_SESSION['autorizado'] ); 
        exit();
        }
    }
}catch (PDOException $e) {
echo 'Erro ao executar comando no banco de dados: ' . $e->getMessage();
exit();
}
?>