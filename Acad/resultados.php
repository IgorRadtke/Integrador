<?php
session_start();
require_once 'bd.php';
try{
///////////////
    if(isset($_POST['imc'])&& isset ($_POST['peso'])&& isset ($_POST['bf'])){ ///////////////
        $comando = $pdo->prepare('SELECT codcli from cliente where email = emailV');
        $comando->bindParam(':emailV', $emailV);
        $comando->execute();

        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
        if ($resultado > 0){
            echo '$resultado';
        }
        else{
            echo 'pinto gordo';
        }
        $IMC = ($_POST['imc']);
        $Peso = ($_POST['peso']);
        $BF = ($_POST['bf']);
        $MedidaCoxa = ($_POST['coxa']);
        $MedidaBraco = ($_POST['braco']);
        $Torax = ($_POST['torax']);
        $DataRes = ($_POST['dataInclu']);
        $comando = $pdo->prepare('INSERT INTO medidas (bf, imc, medida_coxa, medida_braco, medida_torax, peso, datares, codcli) VALUES (:BF, :IMC, :MedidaCoxa, :MedidaBraco, :MedidaTorax, :Peso, :DataInclu, :CPF)');
        $comando->bindParam(':BF', $BF);
        $comando->bindParam(':IMC', $IMC);
        $comando->bindParam(':MedidaCoxa', $MedidaCoxa);
        $comando->bindParam(':MedidaBraco', $MedidaBraco);
        $comando->bindParam(':MedidaTorax', $Torax);
        $comando->bindParam(':Peso', $Peso);
        $comando->bindParam(':DataInclu', $DataRes);
        $comando->bindParam(':CPF', $resultado);
        $comando->execute();
        $_SESSION['Preenchido'] = 1;

    }

}catch (PDOException $e) {
    echo 'Erro ao executar comando no banco de dados: ' . $e->getMessage();
    exit();
}
    $comando = $pdo->prepare('SELECT * FROM medidas');
    $comando->execute();
    $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultado) > 0) {
        foreach($resultado as $linha) {
            echo 'a senha de: ' . $linha['bf'] . ', eh: ' . $linha['imc'] . '<br>';
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
    <title>Resultados</title>
    <link rel="stylesheet" href="CSS/Medi.css">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">
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
                    <p class="name"><h1>Mayara Morlin</h1></p>
                </span>
            </div>
            <ul class="list-nav">
                <li class="item-nav">
                    <a class="link-nav" href="#">
                    <i class="fa-solid fa-dumbbell" style="padding-right: 5px;"></i>
                    Treinos                    
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav" href="Cli/medidasCli.php">
                    <i class="fa-solid fa-ruler-vertical" style="padding-right: 5px;"></i>
                    Incluir Medidas                  
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav" href="Avaliacao.html">
                    <i class="fa-solid fa-dna"style="padding-right: 5px;"></i>
                    Incluir Avaliação              
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav" href="refeicoes.html">
                    <i class="fa-solid fa-utensils" style="padding-right: 5px;"></i>
                    Refeições            
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav" href="resultados.html">
                    <i class="fa-solid fa-weight-scale" style="padding-right: 5px"></i>
                    Resultados           
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
            <h1 class="title">Resultados</h1>
            <form action = "ind.php" method = "Post"><br>
                <p>Insira a Data inicio: &nbsp;&nbsp; <input type = "date" name = "DataInclu">
                    &nbsp;&nbsp;&nbsp;&nbsp; Insira a Data fim: &nbsp;&nbsp; <input type = "date" name = "DataInclu">
                </p><br><br>
                <!-- IMC -->
                <p>Índice de massa corporal (IMC): &nbsp;&nbsp;&nbsp; </p><br><br>
                <!-- BF -->
                <p>Body Fat (BF): &nbsp; <input type = "text" name = "BF"></p><br><br>
                <!-- Peso -->
                <p>Peso: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     <input type = "number" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" name = "peso" placeholder="KG">
                </p><br><br><br>
                <h3><b> <i class="fa-solid fa-ruler" style="padding-right: 10px;"></i>  Medidas</b></h3><br>
                <!-- Braço direito/esquerdo -->
                <p>Braço Direito: &nbsp;&nbsp;
                    <input type = "number" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" name = "braDir" placeholder="CM">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Braço Esquerdo: &nbsp;&nbsp;
                    <input type = "number" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" name = "braEsq" placeholder="CM">
                </p><br><br>
                <!-- Coxa direita/esquerda -->
                <p>Coxa Direita: &nbsp;&nbsp;
                    <input type = "number" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" name = "coxaDir" placeholder="CM">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Coxa Esquerda: &nbsp;&nbsp;
                    <input type = "number" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" name = "coxaEsq" placeholder="CM">
                </p><br><br>
                <!-- torax -->
                <p>Circunferência do Tórax: &nbsp;&nbsp;&nbsp;
                    <input type = "number" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" name = "torax" placeholder="CM">
                </p>

                <br><button type="submit">Salvar</button>
            </form>
        </div>
    </div>
</div>
</div>
<script src="https://kit.fontawesome.com/4a3ddc1d42.js" crossorigin="anonymous"></script>
<script src="JS/app.js"></script>
</body>
</html>