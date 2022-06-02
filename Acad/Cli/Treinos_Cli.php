<?php
session_start();
require_once '../bd.php';
$cpf = $_SESSION['CPF'];
$CRN = $_SESSION['CRN'];
    if (isset($_POST['treinoV'])){
        $treinoV = $_POST['treinoV'];
        $comando = $pdo->prepare('SELECT * FROM treino where cpf = :CPF AND id_treino = :treinoV');
        $comando->bindParam(':treinoV', $treinoV);
        $comando->bindParam(':CPF', $cpf);
        $comando->execute();
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
        if (count($resultado)===0){
            setcookie('treinoI', 1, time()+5); 
            header('Location: Treinos_Cli.php');
            exit; 
        }
    }
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treinos</title>
    <link rel="stylesheet" href="../CSS/Medi.css">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">
</head>
<body>
  <div class="container">
    <header class="header">
        <div class="logo">
            <img src="../IMG/logo.png" alt= "Logotipo">
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
                    <img src="../IMG/perfilCli.png" alt="Imagem de perfil">    
                </span>
                <span>
                    <p class="name"><h1>
                    <?php
                        echo $_SESSION['nome_usuario'];
                    ?>  
                    </h1></p>
                </span>
            </div>
            <ul class="list-nav">
                <li class="item-nav">
                    <a class="link-nav" href="TreinosCli.php">
                    <i class="fa-solid fa-dumbbell" style="padding-right: 5px;"></i>
                    Treinos                    
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav" href="medidasCli.php">
                    <i class="fa-solid fa-ruler-vertical" style="padding-right: 5px;"></i>
                    Incluir Medidas                  
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav" href="../AvaliacaoCli.php">
                    <i class="fa-solid fa-dna"style="padding-right: 5px;"></i>
                    Incluir Avaliação              
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav" href="../refeicoesCli.php">
                    <i class="fa-solid fa-utensils" style="padding-right: 5px;"></i>
                    Refeições            
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav" href="../pagina_cliente.php">
                    <i class="fa-solid fa-arrow-rotate-left" style="padding-right: 5px;"></i>
                    Voltar a Página inicial          
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav-arrow"></a>
                    <ul class="list-nav-second hide"></ul>
                </li>
            </ul>
            
        </nav><!-- Fim nav -->
    </div><!-- Fim menu -->
    <div class="content">
        <div class="Avalia">
            <form action = "Treinos_Cli.php" method = "Post">
                <h2> Selecione o treino desejado (caso você não saiba o nome do seu treino peça para sua nutricionista)
                    <input type = "text" name = "treinoV"><?php 
                    if (isset($_COOKIE['treinoI'])){
                        echo "<b><font color=\"#FF0000\" font size = 2> Nenhuma treino encontrado com este nome </font></b>";
                    };
                    ?>
                    <button type="submit"> Ver </button></h2><br>
            </form> 
            <?php
                    if (isset($_POST['treinoV'])){
                        echo $treinoV;                        
                        echo "<font color = #ffffff> <background-color= #ffffff> <table border = 2> <tr> <td>exercício</td> <td>peso</td> <td>repetições</td> </tr> ";
                        foreach($resultado as $linha) {
                            echo "<tr> <td>". $linha['exercicios']. "</td> <td> ". $linha['peso']. "</td><td>". $linha['repeticoes']. "</td>". "
                            </tr>";
                        }
                        echo "</table>";

                        /*foreach($resultado as $linha) {
                            echo "<b><font color=\"#ffffff\"><div align = right>". "Treino A". "<br>"."
                            :". "remada baixa | 50kg | 15"."<br>". "
                            </font></b></div>";
                        }*/
                    }
            ?>
            
                

                <br><br>
            </div>
    </div>
</div>
</div>
<script src="https://kit.fontawesome.com/4a3ddc1d42.js" crossorigin="anonymous"></script>
<script src="../JS/app.js"></script>
</body>
</html>