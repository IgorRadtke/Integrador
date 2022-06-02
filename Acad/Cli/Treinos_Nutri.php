<?php
session_start();
require_once '../bd.php';
$cpf = $_SESSION['cpfV'];
$CRN = $_SESSION['crnV'];
try{
    //Verifica se tem alguma medida cadastrada para o cliente. Se tiver os dados eles são mostrados dentro das caixas e podem ser atualizados, se não eles são adicionados.
    $comando = $pdo->prepare('SELECT * FROM nutricionista where crn = :CRN');
    $comando->bindParam(':CRN', $CRN);
    $comando->execute();
    $NomeN = $comando->fetchAll(PDO::FETCH_ASSOC);
    foreach($NomeN as $linha) {
        $_SESSION['NomeN'] = $linha['nome'];
    }
    if(isset($_POST['id_treino'])&& isset ($_POST['exercicio'])&& isset ($_POST['repeticoes'])){ ///////////////
        if (isset($_SESSION['autorizado'])){
            $exercicio = ($_POST['exercicio']);
            $Peso = ($_POST['peso']);
            $repeticoes = ($_POST['repeticoes']);
            $id_treino = $_POST['id_treino'];
            $comando = $pdo->prepare('INSERT INTO treino (cpf, crn, id_treino, repeticoes, peso, exercicios ) VALUES (:CPF, :CRN, :id_treino, :repeticoes, :peso, :exercicio)');
            $comando->bindParam(':CPF', $cpf);
            $comando->bindParam(':CRN', $CRN);
            $comando->bindParam(':id_treino', $id_treino);
            $comando->bindParam(':repeticoes', $repeticoes);
            $comando->bindParam(':peso', $Peso);
            $comando->bindParam(':exercicio', $exercicio);
            $comando->execute();
            unset( $_SESSION['pilantra'] ); 
        }else{
            $_SESSION['pilantra'] = 1;
        }

    }

}catch (PDOException $e) {
    echo 'Erro ao executar comando no banco de dados: ' . $e->getMessage();
    exit();
}
    //parte que pega a data para comparar os resultados
    if (isset($_POST['treinoV'])){
        $treinoV = $_POST['treinoV'];
        $comando = $pdo->prepare('SELECT * FROM treino where cpf = :CPF AND id_treino = :treinoV');
        $comando->bindParam(':treinoV', $treinoV);
        $comando->bindParam(':CPF', $cpf);
        $comando->execute();
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
        if (count($resultado)===0){
            setcookie('treinoI', 1, time()+5); 
            header('Location: Treinos_Nutri.php');
            exit; 
        }
    }
    if (isset($_SESSION['autorizado'])){
        if (isset($_POST['deletaV'])){
            $deletaV = $_POST['deletaV'];
            $comando = $pdo->prepare('SELECT id_treino FROM treino where cpf = :CPF AND id_treino = :deletaV');
            $comando->bindParam(':deletaV', $deletaV);
            $comando->bindParam(':CPF', $cpf);
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            if (count($resultado)===0){
                setcookie('deletaI', 1, time()+5); 
                header('Location: Treinos_Nutri.php');
                exit; 
            }
            else{
                $comando = $pdo->prepare('DELETE FROM TREINO WHERE cpf = :CPF and id_treino = :deletaV');
                $comando->bindParam(':deletaV', $deletaV);
                $comando->bindParam(':CPF', $cpf);
                $comando->execute();
            }
        }
    }else{
        setcookie('pilantra', 1, time()+5); 
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
                    <img src="../IMG/perfil.png" alt="Imagem de perfil">    
                </span>
                <span>
                    <p class="name"><h1>
                    <?php
                        echo $_SESSION['NomeN'];
                    ?>  
                    </h1></p>
                </span>
            </div>
            <ul class="list-nav">
                <li class="item-nav">
                    <a class="link-nav" href="Treinos_Nutri.php">
                    <i class="fa-solid fa-dumbbell" style="padding-right: 5px;"></i>
                    Treinos                    
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav" href="medidasNutri.php">
                    <i class="fa-solid fa-ruler-vertical" style="padding-right: 5px;"></i>
                    Incluir Medidas                  
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav" href="../AvaliacaoNutri.php">
                    <i class="fa-solid fa-dna"style="padding-right: 5px;"></i>
                    Incluir Avaliação              
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav" href="../refeicoesNutri.php">
                    <i class="fa-solid fa-utensils" style="padding-right: 5px;"></i>
                    Refeições            
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav" href="../pagina_nutri.php">
                    <i class="fa-solid fa-arrow-rotate-left" style="padding-right: 5px;"></i>
                    Voltar a página inicial           
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
            <form action = "Treinos_Nutri.php" method = "Post"><br>
                <h1 class="name" align = center><?php echo $_SESSION['nomeD'];?></h1><br>
                <h2> Caso já tenha algum treino cadastrado, selecione ao lado o nome do mesmo para visualiza-lo.
                    <input type = "text" name = "treinoV"><?php 
                    if (isset($_COOKIE['treinoI'])){
                        echo "<b><font color=\"#FF0000\" font size = 2> Nenhuma treino encontrado com este nome </font></b>";
                    };
                    ?></h2>
                    <button type="submit"> Ver </button>
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
            <form action = "Treinos_Nutri.php" method = "Post"><br>
            <h1 class="title">Inclusão de Treino</h1>
                <!-- imprime na tela os dados do treino -->
                

                <br><br>

                <p>Escreva qual treino voce quer adicionar: 
                <input type = "text" name = "id_treino" placeholder="nome"></p>
                
                <br><br>  
                <p>exercício:
                <input type = "text" name = "exercicio"placeholder="nome">                
                Carga: 
                <input type = "text"  name = "peso" placeholder="kg">

                Quantidade de repeticoes: 
                <input type = "text"  name = "repeticoes" placeholder="qtd"></p>
                
                    </p><br></td>
                </table>            
                <br><button type="submit"> Adicionar </button><?php
                    if (isset($_COOKIE['pilantra'])){
                        echo "<b><font color=\"##ff0000\" font size = 2> Pilantra detectado </font></b>";
                    }
                ?>
            </form>
            <form action = "Treinos_Nutri.php" method = "Post"><br>
                <p>Caso queira deletar um treino, digite o nome do mesmo e clique no botão abaixo</p>
                <input type = "text"  name = "deletaV">
                <button type="submit"> deletar treino </button><?php
                    if (isset($_COOKIE['deletaI'])){
                            echo "<b><font color=\"##ff0000\" font size = 2> Nenhum treino encontrado com esse nome </font></b>";
                        }
                    if (isset($_COOKIE['pilantra'])){
                        echo "<b><font color=\"##ff0000\" font size = 2> Pilantra detectado </font></b>";
                    }
                    ?>
            </form>
        </div>
    </div>
</div>
</div>
<script src="https://kit.fontawesome.com/4a3ddc1d42.js" crossorigin="anonymous"></script>
<script src="../JS/app.js"></script>
</body>
</html>