<?php
//votos sim
$con = mysqli_connect('localhost','root','', 'enquete');
$sql="SELECT quant_votos_sim FROM enquete";
$retorno=mysqli_query($con, $sql);
$dados=mysqli_fetch_assoc($retorno);
$votossim = $dados['quant_votos_sim'];

//votos não
$sql="SELECT quant_votos_nao FROM enquete";
$retorno=mysqli_query($con, $sql);
$dados=mysqli_fetch_assoc($retorno);
$votosnao = $dados['quant_votos_nao'];

//votos um pouco 
$sql="SELECT quant_votos_um_pouco FROM enquete";
$retorno=mysqli_query($con, $sql);
$dados=mysqli_fetch_assoc($retorno);
$votosumpouco = $dados['quant_votos_um_pouco'];

//quantidade de votos

$totalvotos = $votossim + $votosnao + $votosumpouco;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="author" content = "Mailton Lemos">
    <meta name="description" content="Azul Turquesa Website"> <!-- se atentar nos valores das tags, não é freestyle. -->
    <link rel="icon" href="./assets/img/icone favicon.png"> <!--o valor do favicon é icon--> 
    <title>Azul Turquesa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css" type="text/css">
</head>

<body>

    <header>
        
    </header>
        <nav aria-label="Navegação primávia">
            <ul>
                <legend><b>Menu</b></legend>

                <li>
                    <a href="./index.php">Página inicial</a>
                </li>

                <li>
                    <a href="./app/sobre_nos.php">Sobre nós</a>
                </li>

                <li>
                    <a href="./app/downloads.php">Downloads</a>
                </li>

                <li>
                    <a href="./app/letras.php">Letras de nossas músicas</a>
                </li>

                <li>
                    <a href="./app/fotos.php">Galeria de fotos</a>
                </li>

                <li>
                    <a href="./app/onde_ouvir.php">Onde nos ouvir</a>
                </li>
                <br>
                <hr>

            </ul>

            <!-- Spotify Embed -->
        <div class="spotify-container">
            <iframe style="border-radius:12px" src="https://open.spotify.com/embed/album/4HJDpFAYVhMTFpUdfIkAco?utm_source=generator" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>        </div>
        
            <div class="list">
            <ul style="list-style: none; padding: 0; text-align: center;">
                <li>
                    <a href="https://www.facebook.com/Azul-Turquesa-100564319187499" target="_blank" style="text-decoration: none; color: inherit;">
                        <img src="https://i.imgur.com/schYrX3.png" alt="Facebook" style="width: 50px; height: auto;">
                        <div style="font-size: 14px; margin-top: 5px;">Facebook</div>
                    </a>
                </li>
                <li>
                    <a href="https://www.youtube.com/channel/UCFNR2eraIieEESKRySyJ1Xw" target="_blank" style="text-decoration: none; color: inherit;">
                        <img src="https://i.imgur.com/rtNeHYe.png" alt="YouTube" style="width: 50px; height: auto;">
                        <div style="font-size: 14px; margin-top: 5px;">YouTube</div>
                    </a>
                </li>
                <li>
                    <a href="https://www.instagram.com/azulturquesadoomblack/" target="_blank" style="text-decoration: none; color: inherit;">
                        <img src="https://i.imgur.com/DLcSzOa.png" alt="Instagram" style="width: 50px; height: auto;">
                        <div style="font-size: 14px; margin-top: 5px;">Instagram</div>
                    </a>
                </li>
            </ul>            
           
            <ul>
                <section class="enquete">
                <fieldset>  
                <h1>Você gostou do novo site?</h1>
                <form method="GET" action="envia_enquete.php">
                    <!-- Opções da enquete -->
                        <input type="radio" name="voto" value="Sim">Sim!<br> <!-- o nome deve ser igual para não poder dar dois votos ao mesmo tempo -->
                        <input type="radio" name="voto" value="Nao">Não!<br>
                        <input type="radio" name="voto" value="Um pouco">Um pouco...<br>
                    <input class="botao" type="submit" value="Votar">
                    <br><hr>
                    <h4>Resultado da enquete<h4>
                        <p>Sim! <?php echo $votossim;?></p>
                        <p>Não! <?php echo $votosnao;?></p>
                        <p>Um pouco... <?php echo $votosumpouco;?></p>
                        <p>Total de votos: <?php echo $totalvotos;?></p>
                    </section>

                </form>
                </fieldset>
                <br>
            </ul>

            <iframe style="border: 0; width: 236px; height: 350px;" src="https://bandcamp.com/EmbeddedPlayer/track=1189228237/size=large/bgcol=ffffff/linkcol=0687f5/tracklist=false/transparent=true/" seamless><a href="https://azulturquesa.bandcamp.com/track/nostalgia">Nostalgia by Azul Turquesa</a></iframe>

            <ul>
                <h4>Email para contato:<br> azulturquesabanda@gmail.com</h4>
            </ul>
        
        </div>
     </nav>
    <main>Principal</main>
    <aside>Relacionados</aside>
    <footer> <p>&copy; 2025 Azul Turquesa. Todos os direitos reservados.</p></footer>

</body>

</html>