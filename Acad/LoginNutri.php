<?php   
session_start();
require_once 'bd.php';

try{

    if(isset($_POST['Email'])&& isset ($_POST['Senha'])){
        $Email = ($_POST['Email']);
        $Nome = ($_POST['Nome']);
        $Senha = ($_POST['Senha']);
        $CRN = ($_POST['crn']);
        $comando = $pdo->prepare('INSERT INTO nutricionista (email, nome, senha, crn) VALUES (:Email, :Nome, :Senha, :CRN)');
        $comando->bindParam(':Email', $Email);
        $comando->bindParam(':Nome', $Nome);
        $comando->bindParam(':Senha', $Senha);
        $comando->bindParam(':CRN', $CRN);

        $comando->execute();
    }

}catch (PDOException $e) {
    echo 'Erro ao executar comando no banco de dados: ' . $e->getMessage();
    exit();
}
    $comando = $pdo->prepare('SELECT * FROM nutricionista');
    $comando->execute();
    $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultado) > 0) {
        foreach($resultado as $linha) {
            echo 'a senha de: ' . $linha['email'] . ', eh: ' . $linha['senha'] . '<br>';
        }
    } else {
        echo 'Nenhum usuário encontrado';
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="CSS/login_stl.css">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">
    <title>Login Nutri</title>
</head>
<body>
    <div class="logo">
        <img src="IMG/logo_olymp.png" alt= "Logotipo" style="width: 350px; margin-left: 1100px; margin-top: 50px;">
    </div>
    <div class="login">
        <form action = "autenticaNutri.php" method = "Post">
            <h1>Login</h1>
            <?php
            if(isset($_COOKIE['autenticado'])){
                echo "<b><font color=\"#FF0000\">
                Email ou senha incorreto ou inexistentes"."<br>"."verifique suas credenciais e tente novamente.
                </font></b>";
            }
            ?>
            <p>Email</p>
            <input type = "text" name = "emailV" placeholder="Insira seu email">
            <p>Senha</p>
            <input type = "password" name = "senhaV" placeholder="Insira sua senha">
            <input type = "submit" name = "Login">
            <a href="CadastroNutri.php" style="color: #fff;">Cadastrar-se</a>
        </form>
    </div>
</body>
</html>