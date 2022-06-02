<?php
session_start();
require_once 'bd.php';

try{

    if(isset($_POST['emailV'])&& isset ($_POST['senhaV'])){
        $emailV = $_POST['emailV'];
        $senhaV = $_POST['senhaV'];

        $comando = $pdo->prepare('SELECT * FROM nutricionista WHERE email = :emailV' );
        $comando->bindParam(':emailV', $emailV);
        $comando->execute();
        $resultado = $comando->fetch();
        if ($resultado>0){
            if ($senhaV === $resultado['senha']){
                $_SESSION['autenticado'] = 1;
                $_SESSION['autorizado'] = 1;
                $_SESSION['nome_usuario'] = $resultado["nome"];
                unset( $_SESSION['pilantra'] );
                setcookie('autenticado', 'sim', time()+60);
                header('Location: pagina_nutri.php');
                exit();
            }
            else{
                setcookie('autenticado', 'nao', time()+60);
                header('Location: LoginNutri.php');
                exit();
            } 
        }else{
        setcookie('autenticado', 'nao', time()+60);
        header('Location: LoginNutri.php');
        exit();
        }
    }
}catch (PDOException $e) {
echo 'Erro ao executar comando no banco de dados: ' . $e->getMessage();
exit();
}