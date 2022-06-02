<?php
      
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="CSS/login_stl.css">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">
    <title>Login Nutri</title>
</head>
<body>
    <div class="login"style="width: 370px; top: 50%;">
        <form action = "LoginCli.php" method = "Post">
            <h1>Cadastro</h1>
            <p>Nome</p>
            <input type = "text" name = "Nome" placeholder="Insira seu nome">
            <p>Email</p>
            <input type = "text" name = "Email" placeholder="Insira seu email">
            <p>Senha</p>
            <input type = "password" name = "Senha" placeholder="Insira sua senha">
            <p>Fone</p>
            <input type = "text" name = "Fone" placeholder="Insira seu telefone">
            <p>CPF</p>
            <input type = "text" name = "CPF" placeholder="Insira seu CPF">
            <p>CRN Nutricionista</p>
            <?php session_start();
                if(isset($_COOKIE['crn'])){
                    echo "<b><font color=\"#FF0000\">
                    Insira um CRN que existe. 
                    </font></b>";
                }
            ?>
            <input type = "text" name = "CRN" placeholder="Insira o CRN">
            <p>Data de Nascimento</p>
            <input type = "date" name = "DataNasc" placeholder="Insira sua data de nascimento">
            <input type = "submit" name = "Login">

        </form>
     </div>
</body>