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
    <link rel="icon" href="../assets/img/icone favicon.png"> <!--o valor do favicon é icon--> 
    <title>Downloads</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css" type="text/css">
</head>

<body>

    <header>
        
    </header>
        <nav aria-label="Navegação primávia">
            <ul>
                <legend><b>Menu</b></legend>

                <li>
                    <a href="../index.php">Página inicial</a>
                </li>

                <li>
                    <a href="./sobre_nos.php">Sobre nós</a>
                </li>

                <li>
                    <a href="./downloads.php">Downloads</a>
                </li>

                <li>
                    <a href="./letras.php">Letras de nossas músicas</a>
                </li>

                <li>
                    <a href="./fotos.php">Galeria de fotos</a>
                </li>

                <li>
                    <a href="./onde_ouvir.php">Onde nos ouvir</a>
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
                        <form method="GET" action="../envia_enquete.php">
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
    <main>

        <h1>Downloads</h1>

        <div style="text-align: center;">
            <img src="../assets/img/materias/downloads/azul-turquesa-logo.png" alt="Azul Turquesa logo" width="500" height="auto">
        </div>
        <br><br>

        <div class="music-container">

            <p> Aqui fica disponível para Download gratuito alguns trabalhos da Azul Turquesa em boa qualidade para todos curtirem.</p> <br><br>

            <img src="../assets/img/materias/downloads/azul-turquesa-demos.jpg" alt="Azul Turquesa Demos 2022" width="300" height="auto">
            <br><br>
            <p>Azul Turquesa - Demos (2022)<br>
                <b>Download</b> - <a href="https://drive.google.com/file/d/1O087zlwNTaukasYHazVQCjgZx549W9UL/view?usp=sharing" alt="Google Drive">Google Drive</a>
            <br><rbr>

            <img src="../assets/img/materias/downloads/espelho-de-cristal-azul-turquesa.jpg" alt="Azul Turquesa Espelho de Cristal 2023" width="300" height="auto">
            <br><br>
            <p>Azul Turquesa - Espelho de Cristal (2023)<br>
                <b>Download</b> - <a href="https://drive.google.com/file/d/1r8IyJQjmnTboZUSYkwa8gnDj6QnhXbSn/view?usp=share_link" alt="Google Drive">Google Drive</a>
            <br><br>

            <img src="../assets/img/materias/downloads/azul-turquesa-anacoreta .jpg" alt="Azul Turquesa Anacoreta 2023" width="300" height="auto">
            <br><br>
            <p>Azul Turquesa - Anacoreta (2023)<br>
                <b>Download</b> - <a href="https://drive.google.com/file/d/1URW89FkVFE0YcQwHhv5RmfdUbgg9L3Xt/view?usp=sharing" alt="Google Drive">Google Drive</a>
            <br><br>

            <img src="../assets/img/materias/downloads/cid-10-f19-5.png" alt="Azul Turquesa CID 10 F19.5 2023" width="300" height="auto">
            <br><br>
            <p>Azul Turquesa - CID 10 F19.5 (2023)<br>
                <b>Download</b> - <a href="https://drive.google.com/file/d/1O_0y5ygjjtz8YemdGLrTc7RW_WmS29Ct/view?usp=sharing" alt="Google Drive">Google Drive</a>
            <br><br>
            
            <img src="../assets/img/materias/downloads/Pusilanime-Azul-Turquesa.jpg" alt="Azul Turquesa Pusilanime 2024" width="300" height="auto">
            <br><br>
            <p>
                    Pusilânime (2024)<br>
                    Tracklist:<br>
                    
                    1. CID 10 F19.5<br>

                    02. Obsessão (Compulsão, repulsão)<br>

                    03. Pusilânime<br>

                    04. Cacofonia<br>
                
                    <b>Download</b> <a href="https://drive.google.com/file/d/1aDw0JnSfLjlNHK3EnJxn6dAoEdg2rRr2/view" alt="Google Drive">Google Drive</a>
            </p>
            <br><br>

            <img src="../assets/img/materias/downloads/Nostalgia-Azul-Turquesa.jpg" alt="Azul Turquesa Nostalgia 2024" width="300" height="auto">
            <br><br>
            <p>Azul Turquesa - Nostalgia (2024)<br>
                <b>Download</b> - <a href="https://drive.google.com/file/d/12J2BECnzZqyTqtUVv3eg4QDLBqv6CrD-/view?usp=sharing alt="Google Drive">Google Drive</a>
            <br><br>


        </div>

    </main>
    <aside>Relacionados</aside>
    <footer> <p>&copy; 2025 Azul Turquesa. Todos os direitos reservados.</p></footer>

</body>

</html>