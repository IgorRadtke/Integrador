<?php
    session_start();
    require_once 'bd.php';



    $comando1 = $pdo->prepare('SELECT nome FROM cliente' );
    $comando1->execute();
    $resultado1 = $comando1->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Coordenador</title>
    <link rel="stylesheet" href="CSS/stlNutri.css">
</head>
<body>
  <div class="container">
    <header class="header">
        <div class="logo">
            <img src="img/logo.png" alt= "Logotipo">
        </div>
        <div class="icon-menu">
            <svg width="21.999999999999996" height="21.999999999999996" xmlns="http://www.w3.org/2000/svg" style="padding-right: 10px;">
                <g>
                    <line stroke="#fff" class="firstLine" y2="4.146656" x2="25.477124" y1="4.146656" x1="-1.973854"
                        stroke-width="3.5" style="color: azure;" />
                    <line stroke="#fff" class="secondLine" y2="11.151682" x2="25.607844" y1="11.020963" x1="-2.104574"
                        stroke-width="3.5" style="color:azure;" />
                    <line stroke="#fff" class="thirdLine" y2="17.804165" x2="24.852663" y1="17.673446" x1="-1.683284"
                        stroke-width="3.5" style="color: azure;" />
                </g>
            </svg>
        </div> 
    </header><!-- Fim header -->
    <div class="menu">
        <nav class="navigation-menu">
            <div class="profile">
                <span class="profile-img">
                    <img src="IMG/perfil.png" alt="Imagem de perfil">    
                </span>
                <span>
                    <p class="name"><h1>
                    <?php
                        echo $_SESSION['nome_usuario'];
                    ?>  
                    </h1></p>
                    <p>Nutricionista</p>
                </span>
            </div>
            <ul class="list-nav">
                <li class="item-nav">
                    <a class="link-nav" href="CadastroCli.php">
                    <i class="fa-regular fa-address-book"style="padding-right: 5px;"></i>
                    Cadastrar Clientes                    
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav-arrow">
                    <ul class="list-nav-second hide"></ul>
                </li>
                
                <div class="busca-nav">
                    <form action = "Edita.php" method = "Post">  
                        <input type="text" id="pesquisa" name="cliente" onkeyup="pesquisar()"class="busca-txt" placeholder="Buscar Clientes">
                        <i class="fa fa-search"></i><br>
                        <ul id = "menu">
                            <li><?php
                                    if (!isset($_COOKIE['nomeI'])){
                                        foreach($resultado1 as $linha) {
                                            echo $linha['nome'] . '<br>';                                                        
                                            $_SESSION['nomeCli'] = $linha['nome'];
                                        }
                                    }else{
                                        echo "<b><font color=\"##ff0000\" font size = 2> Nome inexistente </font></b><br>";
                                        foreach($resultado1 as $linha) {
                                            echo $linha['nome'] . '<br>';
                                        }
                                    }
                                ?>
                              
                        </ul>                            
                    </form>
                </div>
        </nav><!-- Fim nav -->
    </div><!-- Fim menu -->
    <div class="content">
        <h1>Seja bem vindo <?php echo $_SESSION['nome_usuario']; ?></h1>    
    </div>
</div>
<script src="https://kit.fontawesome.com/4a3ddc1d42.js" crossorigin="anonymous"></script>
<script src="JS/app.js"></script>
</body>
</html>
