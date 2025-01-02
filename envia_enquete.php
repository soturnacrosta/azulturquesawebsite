<?php

$voto = $_GET['voto'];

$con = mysqli_connect('localhost','root','', 'enquete');

    if ($voto = $_GET['voto']=='Sim'){
        $sql = "UPDATE enquete SET quant_votos_sim = quant_votos_sim + 1 where id = 1";
        $query = mysqli_query ($con, $sql);

    }

    if ($voto = $_GET['voto']=='Nao'){
        $sql = "UPDATE enquete SET quant_votos_nao = quant_votos_nao + 1 where id = 1";
        $query = mysqli_query ($con, $sql);

    }

    if ($voto = $_GET['voto']=='Um pouco'){
        $sql = "UPDATE enquete SET quant_votos_um_pouco = quant_votos_um_pouco + 1 where id = 1";
        $query = mysqli_query ($con, $sql);

    }

$con->close();
?>

<h4>Seu voto foi computado, obrigado.</h4>
<a href="index.php">VOLTAR PARA A PÁGINA INICIAL</a>