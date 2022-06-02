<?php
session_start();
require_once '../bd.php';
$CPF = $_SESSION['cpfV'];
$CRN = $_SESSION['crnV'];
try{
    //Verifica se tem alguma medida cadastrada para o cliente. Se tiver os dados eles são mostrados dentro das caixas e podem ser atualizados, se não eles são adicionados.
    $comando = $pdo->prepare('SELECT imc FROM medidas where cpf = :CPF');
    $comando->bindParam(':CPF', $CPF);
    $comando->execute();
    $Cadastrado = $comando->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST['imc'])&& isset ($_POST['peso'])&& isset ($_POST['bf'])){ ///////////////

        $IMC = ($_POST['imc']);
        $Peso = ($_POST['peso']);
        $BF = ($_POST['bf']);
        $MedidaCoxa = ($_POST['coxa']);
        $MedidaBraco = ($_POST['braco']);
        $Torax = ($_POST['torax']);
        $DataRes = ($_POST['dataInclu']);
        $comando = $pdo->prepare('INSERT INTO medidas (cpf, bf, imc, medida_coxa, medida_braco, medida_torax, peso, datares) VALUES (:CPF, :BF, :IMC, :MedidaCoxa, :MedidaBraco, :MedidaTorax, :Peso, :DataInclu)');
        $comando->bindParam(':BF', $BF);
        $comando->bindParam(':IMC', $IMC);
        $comando->bindParam(':MedidaCoxa', $MedidaCoxa);
        $comando->bindParam(':MedidaBraco', $MedidaBraco);
        $comando->bindParam(':MedidaTorax', $Torax);
        $comando->bindParam(':Peso', $Peso);
        $comando->bindParam(':DataInclu', $DataRes);
        $comando->bindParam(':CPF', $CPF);
        $comando->execute();

    }

}catch (PDOException $e) {
    echo 'Erro ao executar comando no banco de dados: ' . $e->getMessage();
    exit();
}
    //parte que pega a data para comparar os resultados
    if (isset($_POST['dataV'])){
        $DataRes = $_POST['dataV'];
        $comando = $pdo->prepare('SELECT * FROM medidas where cpf = :CPF AND DataRes = :DataRes');
        $comando->bindParam(':DataRes', $DataRes);
        $comando->bindParam(':CPF', $CPF);
        $comando->execute();
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
        if (count($resultado)===0){
            setcookie('dataI', 1, time()+1); 
            header('Location: medidasNutri.php');
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
    <title>Medidas</title>
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
                        echo $_SESSION['nome_usuario'];
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
            <h1 class="name" align = center><?php echo $_SESSION['nomeD'];?></h1><br>
            <form action = "medidasNutri.php" method = "Post"><br>
                <h2> Caso já tenha medidas cadastradas, selecione ao lado a data que você deseja visualizar.
                    <input type = "date" name = "dataV"><?php 
                    if (isset($_COOKIE['dataI'])){
                        echo "<b><font color=\"#FF0000\" font size = 2> Nenhuma medida encontrada para esta data </font></b>";
                    };
                    ?>
                    <button type="submit"> Ver </button></h2><br>
            </form>
                
            <h1 class="title">Inclusão de Medidas</h1>
            <form action = "medidasNutri.php" method = "Post">
                <p>Insira a data de inclusão dos dados:&nbsp;&nbsp;
                    <input type = "date" name = "dataInclu">
                </p><br><br>
                <?php
                    if (count($Cadastrado)>0){
                        //$DataRes = $_SESSION['ultima_data'];
                        $comando = $pdo->prepare('SELECT * FROM medidas where cpf = :CPF AND DataRes = :DataRes');
                        $comando->bindParam(':DataRes', $DataRes);
                        $comando->bindParam(':CPF', $CPF);
                        $comando->execute();
                        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
                    }
                ?>
                <p>Indice de massa corportal (IMC):</p>
                <input type = "text" name = "imc" placeholder="<?php
                        if (isset($_POST['dataV'])){
                            foreach($resultado as $linha) {
                                echo $linha['imc'];
                            }
                        }                        
                ?>">
                
                <br><br>  
                <p>Body Fat (BF):</p>
                <input type = "text" name = "bf"placeholder="<?php
                if (isset($_POST['dataV'])){
                    foreach($resultado as $linha) {
                        echo $linha['bf'];
                    }
                }    
                ?>">
                
                <br><br>                
                <p>Peso:</p>
                <input type = "text"  name = "peso" placeholder="<?php
                if (isset($_POST['dataV'])){
                    foreach($resultado as $linha) {
                        echo $linha['peso'];
                    }
                }
                ?>">
                
                <br><br>
                    <h3>Medidas:</h3><br>
                <!-- BRACO -->
                <table style="color: #fff">
                    <td><img src="../IMG/braco.png" alt="imgBraco" style="width:50px;"></td>
                    <td><p><b>Braço:</b></p>
                    <p>Antebraço estendido e palmas para cima. Posição <b>sem</b> Contração.</p>
                    <p>Braço Direito: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type = "number" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" name = "braco" placeholder="<?php
                        if (isset($_POST['dataV'])){
                            foreach($resultado as $linha) {
                                echo $linha['medida_braco'];
                            }
                        }
                        ?>">
                        
                        </p>
                     
                    
                </table>
                <!-- COXA -->
                <table style="color: #fff">
                    <td><img src="../IMG/coxa.png" alt="imgCoxa" style="width:50px;"></td>
                    <td><p><b>Coxas:</b></p>
                    <p>10 a 20 cm acima da borda superior da patela. Manter a coxa contraída.</p>
                    <p>20 cm: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type = "number" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" name = "coxa" placeholder="<?php
                        if (isset($_POST['dataV'])){
                            foreach($resultado as $linha) {
                                echo $linha['medida_coxa'];
                            }
                        }
                        ?>">
                        
                    </p><br>
                </table>
                <!-- TORAX -->
                <table style="color: #fff">
                    <td><img src="../IMG/torax.png" alt="imgCoxa" style="width:50px;"></td>
                    <td><p><b>Tórax:</b></p>
                    <p>A fita métrica passa abaixo da axila.</p>
                    <p>Circunferência Tórax: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type = "number" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" name = "torax" placeholder=" <?php
                        if (isset($_POST['dataV'])){
                            foreach($resultado as $linha) {
                                echo $linha['medida_torax'];
                            }
                        }
                        ?>">
                        
                    </p><br></td>
                </table>            
                <br><button type="submit">Salvar</button>
                
            </form>
        </div>
    </div>
</div>
</div>
<script src="https://kit.fontawesome.com/4a3ddc1d42.js" crossorigin="anonymous"></script>
<script src="../JS/app.js"></script>
</body>
</html>