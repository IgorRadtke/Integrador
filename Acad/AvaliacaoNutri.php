<?php
session_start();
require_once 'bd.php';
$CPF = $_SESSION['cpfV'];
$CRN = $_SESSION['crnV'];
try{
    //echo 'nao entrou em nada';

    if(isset($_POST['toma_med'])&& isset ($_POST['doencas'])&& isset ($_POST['lesoes'])){   ///////////////
        //Verifica se tem algo em avaliacao, se tiver os dados eles são mostrados dentro das caixas e podem ser atualizados, se não eles são adicionados.
        $comando = $pdo->prepare('SELECT * FROM avaliacao where cpf = :CPF');
        $comando->bindParam(':CPF', $CPF);
        $comando->execute();
        $Preenchido = $comando->fetchAll(PDO::FETCH_ASSOC);
        //echo ' nao entrou no if';

        // puxa os dados do form html ou da sessão.
        
        //$CRN = $_SESSION['CRN'];
        $TomaMed = $_POST['toma_med'];
        $Doencas = $_POST['doencas'];
        $Lesoes = $_POST['lesoes'];
        $TipoFisico = $_POST['tipo_fisico'];
        $Objetivo = $_POST['objetivo'];

        //caso já possua avaliacao cadastrada, ela é atualizada, caso contrário é inserida
        if (isset($_SESSION['autorizado'])){
            if (count($Preenchido) > 0){
                //$CRN = $_POST['CRN'];
                $comando = $pdo->prepare('UPDATE avaliacao 
                                            SET cpf = :CPF,
                                            Toma_medicamento = :TomaMed,
                                            doencas = :Doencas,
                                            lesoes = :Lesoes,
                                            tipo_fisico = :TipoFisico,
                                            Objetivo = :Objetivo,
                                            crn = :CRN
                                            WHERE cpf = :CPF');
                $comando->bindParam(':CPF', $CPF);
                $comando->bindParam(':TomaMed', $TomaMed);
                $comando->bindParam(':Doencas', $Doencas);
                $comando->bindParam(':Lesoes', $Lesoes);
                $comando->bindParam(':TipoFisico', $TipoFisico);
                $comando->bindParam(':Objetivo', $Objetivo);
                $comando->bindParam(':CRN', $CRN);
                $comando->execute();
                
            }
            else{
                //$CRN = $_POST['CRN'];
                $comando = $pdo->prepare('INSERT INTO avaliacao (cpf, toma_medicamento, doencas, lesoes, tipo_fisico, objetivo, crn) VALUES (:CPF, :TomaMed, :Doencas, :Lesoes, :TipoFisico, :Objetivo, :CRN)');
                $comando->bindParam(':CPF', $CPF);
                $comando->bindParam(':TomaMed', $TomaMed);
                $comando->bindParam(':Doencas', $Doencas);
                $comando->bindParam(':Lesoes', $Lesoes);
                $comando->bindParam(':TipoFisico', $TipoFisico);
                $comando->bindParam(':Objetivo', $Objetivo);
                $comando->bindParam(':CRN', $CRN);
                $comando->execute();
                unset($_SESSION['pilantra']);
                //echo 'deu boa';
            }
        }else{
            setcookie('pilantra', 1, time()+5);
    }
}


}catch (PDOException $e) {
    echo $CPF;
    echo 'Erro ao executar comando no banco de dados: ' . $e->getMessage();
    exit();
}
    $comando = $pdo->prepare('SELECT * FROM avaliacao where cpf = :CPF');
    $comando->bindParam(':CPF', $CPF);
    $comando->execute();
    $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação</title>
    <link rel="stylesheet" href="CSS/avaliacao.css">
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
        <!-- Aqui começa o menu -->
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
                </span>
            </div>
            <ul class="list-nav">
                <li class="item-nav">
                    <a class="link-nav" href="Cli/Treinos_Nutri.php">
                    <i class="fa-solid fa-dumbbell" style="padding-right: 5px;"></i>
                    Treinos                    
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav" href="Cli/medidasNutri.php">
                    <i class="fa-solid fa-ruler-vertical" style="padding-right: 5px;"></i>
                    Incluir Medidas                  
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav" href="AvaliacaoNutri.php">
                    <i class="fa-solid fa-dna"style="padding-right: 5px;"></i>
                    Incluir Avaliação              
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav" href="refeicoesNutri.php">
                    <i class="fa-solid fa-utensils" style="padding-right: 5px;"></i>
                    Refeições            
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav" href="pagina_nutri.php">
                    <i class="fa-solid fa-weight-scale" style="padding-right: 5px"></i>
                    Voltar a Página inicial           
                    </a>
                </li>
                <li class="item-nav">
                    <a class="link-nav-arrow"></a>
                    <ul class="list-nav-second hide"></ul>
                </li>
            </ul>
            
        </nav>
    </div><!-- Fim menu -->
    <div class="content">
        <div class="Avalia">
            <h1 class="title">Incluir Avaliação</h1>
            <form action = "AvaliacaoNutri.php" method = "Post">
                <br><h2>Responda com sinceridade as perguntas a seguir.</h2>
                <h5> (Caso já possua e queira editar seus dados, apenas escreva em cima dos existentes.)<h5><br>
                <!-- pega os dados do banco e passa para uma variavel php-->
                <?php
                    if (isset($Preenchido)){
                        $comando = $pdo->prepare('SELECT toma_medicamento, doencas, lesoes, tipo_fisico, objetivo FROM avaliacao where cpf = :CPF');
                        $comando->bindParam(':CPF', $CPF);
                        $comando->execute();
                        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
                    }
                ?>
                <!--se o paciente já tiver uma avaliacao cadastrada, ela é mostrada, caso contrario não aparecerá nada.--> 
                <p>Toma algum medicamento? Se sim, qual?</p>
                <textarea row="6" style="width: 26em" id="objetivo" name="toma_med" placeholder = "<?php
                        foreach($resultado as $linha) {
                            echo $linha['toma_medicamento'];
                        }
                    ?>"></textarea> 
                
                <br><br>
                <p>Possui algum tipo de doença? Se sim, qual?</p>
                <textarea row="6" style="width: 26em" id="objetivo" name="doencas" placeholder = "<?php
                        foreach($resultado as $linha) {
                            echo $linha['doencas'];
                        }
                    ?>"></textarea> 
                   
                <br><br>
                <p>Tem algum tipo de lesão? Se sim, qual?</p>
                <textarea row="6" style="width: 26em" id="objetivo" name="lesoes" placeholder = "<?php
                        foreach($resultado as $linha) {
                            echo $linha['lesoes'];
                        }
                    ?>"></textarea> 
                <br><br>
                <p>Qual o seu tipo Físico (selecione uma das opções abaixo).</p>
                <br>
                <select name="tipo_fisico">
                    <option value="Ectomorfo">Ectomorfo</option>
                    <option value="Mesomorfo">Mesomorfo</option>
                    <option value="Endomorfo">Endomorfo</option>  
                </select>
                    <?php
                        foreach($resultado as $linha) {
                            echo "<b><font color=\"#ffffff\">
                            Dado Atual: ". $linha['tipo_fisico']. "
                            </font></b>";
                        }
                    ?>
                <br><br>
                <p>Descreva abaixo em poucas palavras qual seu objetivo com a academia.</p>
                <textarea row="6" style="width: 26em" id="objetivo" name="objetivo" placeholder = "<?php
                        foreach($resultado as $linha) {
                            echo $linha['objetivo'];
                        }
                    ?>"></textarea>                  
                <br>
                <button type="submit">Salvar</button><?php
                    if (isset($_COOKIE['pilantra'])){
                        echo "<b><font color=\"##ff0000\" font size = 2> Somente uma nutricionista pode cadastrar ou atualizar sua avaliação. </font></b>";
                    }
                ?>
            </form>
        </div>
    </div>
</div>
</div>
<script src="https://kit.fontawesome.com/4a3ddc1d42.js" crossorigin="anonymous"></script>
<script src="JS/app.js"></script>
</body>
</html>