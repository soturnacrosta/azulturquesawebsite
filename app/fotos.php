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
<?php
// Inicia a sessão para controlar a execução
session_start();

// Conexão com o banco de dados
$con = mysqli_connect('localhost', 'root', '', 'tags');

// Verificar se a conexão foi bem-sucedida
if (!$con) {
    error_log("Conexão falhou: " . mysqli_connect_error());
    exit; // Termina a execução em caso de erro
}

// Verificar se a página "Galeria de fotos" já foi inserida nesta sessão
if (!isset($_SESSION['galeria_fotos_inserida'])) {
    // Verificar se a página já existe no banco de dados
    $titulo = 'Galeria de fotos';
    $conteudo = 'Fotos promocionais da banda Azul Turquesa';
    $tipo = 'galeria';

    $stmt = mysqli_prepare($con, "SELECT id FROM paginas WHERE titulo = ?");
    mysqli_stmt_bind_param($stmt, 's', $titulo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 0) {
        // Inserção da página se não existir
        $stmt = mysqli_prepare($con, "INSERT INTO paginas (titulo, conteudo, tipo) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sss', $titulo, $conteudo, $tipo);

        if (mysqli_stmt_execute($stmt)) {
            $pagina_id = mysqli_insert_id($con);

            // Lista de tags a serem associadas à página
            $tags = ['azul turquesa', 'fotos da azul turquesa', 'Soturna Crosta', 'Efemera', 'Azul Turquesa Duo'];

            foreach ($tags as $tag_nome) {
                // Verificar se a tag já existe
                $stmt = mysqli_prepare($con, "SELECT id FROM tags WHERE nome = ?");
                mysqli_stmt_bind_param($stmt, 's', $tag_nome);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 0) {
                    // Inserir a tag se não existir
                    $stmt = mysqli_prepare($con, "INSERT INTO tags (nome) VALUES (?)");
                    mysqli_stmt_bind_param($stmt, 's', $tag_nome);
                    if (mysqli_stmt_execute($stmt)) {
                        $tag_id = mysqli_insert_id($con);
                    }
                } else {
                    // Obter o ID da tag existente
                    mysqli_stmt_bind_result($stmt, $tag_id);
                    mysqli_stmt_fetch($stmt);
                }

                // Associar a página com a tag
                $stmt = mysqli_prepare($con, "INSERT INTO pagina_tags (pagina_id, tag_id) VALUES (?, ?)");
                mysqli_stmt_bind_param($stmt, 'ii', $pagina_id, $tag_id);
                mysqli_stmt_execute($stmt);
            }

            // Marcar que a página foi inserida nesta sessão
            $_SESSION['galeria_fotos_inserida'] = true;
        } else {
            error_log("Erro ao inserir a página: " . mysqli_error($con));
        }
    } else {
        error_log("Página 'Galeria de fotos' já existe no banco de dados.");
    }
}

// Fechar a conexão
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="author" content = "Mailton Lemos">
    <meta name="description" content="Azul Turquesa Website"> <!-- se atentar nos valores das tags, não é freestyle. -->
    <link rel="icon" href="../assets/img/icone favicon.png"> <!--o valor do favicon é icon--> 
    <title>Galeria de fotos</title>
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

        <h1>Galeria de fotos</h1>

        <div class="fotos-container">

            <figure>
                <img src="../assets/img/materias/galeria_de_fotos/azul-turquesa-logo-branco.png" alt="Logo branca">
                <figcaption>Azul Turquesa logo branca</figcaption>
            </figure>
            <br>
            <figure>
                <img src="../assets/img/materias/galeria_de_fotos/icone-azul-turquesa.png" alt="Icone branco">
                <figcaption>Azul Turquesa icone branco</figcaption>
            </figure>
            <br>
            <figure>
                <img src="../assets/img/materias/galeria_de_fotos/primeira-formacao-azul-turquesa.jpeg" alt="Primeira formação Azul Turquesa">
                <figcaption>Azul Turquesa - Primeira Formação</figcaption>
            </figure>
            <br>
            <figure>
                <img src="../assets/img/materias/galeria_de_fotos/primeiro-ensaio-azul-turquesa.jpeg" alt="Primeiro ensaio Azul Turquesa">
                <figcaption>Azul Turquesa - Primeiro Ensaio</figcaption>
            </figure>
            <br>
            <figure>
                <img src="../assets/img/materias/galeria_de_fotos/promo-lancamento-anacoreta.jpeg" alt="Anacoreta - Foto promocional">
                <figcaption>Anacoreta - Foto promocional</figcaption>
            </figure>
            <br>
            <figure>
                <img src="../assets/img/materias/galeria_de_fotos/soturna-e-efemera-azul-turquesa.jpeg" alt="Soturna e Efêmera - Azul Turquesa">
                <figcaption>Soturna e Efêmera - Anacoreta (2023)</figcaption>
            </figure>
            <br>
            <figure>
                <img src="../assets/img/materias/galeria_de_fotos/efemera-e-soturna-azul-turquesa.jpeg" alt="Efêmera e Soturna - Anacoreta">
                <figcaption>Soturna e Efêmera - Anacoreta (2023)</figcaption>
            </figure>
            <br>
            <figure>
                <img src="../assets/img/materias/galeria_de_fotos/efemera-soturna-azul-turquesa-2024.jpg" alt="Efêmera e Soturna - Pusilânime release">
                <figcaption>Soturna e Efêmera (Pusilânime)</figcaption>
            </figure>
            <br>
            <figure>
                <img src="../assets/img/materias/galeria_de_fotos/azul-turquesa-duo.jpg" alt="Duo paraibano de Black Metal Azul Turquesa">
                <figcaption>Soturna e Efêmera (Pusilânime)</figcaption>
            </figure>
            <br>
            <figure>
                <img src="../assets/img/materias/galeria_de_fotos/soturna-azul-turquesa.jpg" alt="Soturna - Azul Turquesa">
                <figcaption>Soturna (Pusilânime)</figcaption>
            </figure>
            <br>
            <figure>
                <img src="../assets/img/materias/galeria_de_fotos/soturna-da-azul-turquesa.jpg" alt="Soturna - Azul Turquesa">
                <figcaption>Soturna (Pusilânime)</figcaption>
            </figure>
        </div>
        
    </main>
    
    <aside>

        <h3>Últimos posts</h3><br>

        <a href="./sobre_nos.php" alt="Sobre nós">Sobre nós</a>
            <ul>
                <li>História da banda</li>
                <li>Curiosidades</li>
                <li>Membros</li>
            </ul>
        <br>
        <hr>
        <br>

        <a href="./downloads.php" alt="Downloads">Downloads</a>
            <ul>
                <li>Downloads das músicas</li>
                <li>Gratuito</li>
                <li>Boa qualidade</li>
            </ul>
        <br>
        <hr>
        <br>

        <a href="./onde_ouvir.php" alt="Onde nos ouvir">Onde nos ouvir</a>
            <ul>
                <li>Links da banda</li>
                <li>Streaming gratuito e pago</li>
                <li>Várias opções</li>
            </ul>
        <br>
        <hr>
        <br>

        <a href="./letras.php" alt="Letras">Letras de nossas músicas</a>
            <ul>
                <li>Links da banda</li>
                <li>Letras de nossas músicas</li>
                <li>Todas em um único lugar</li>
            </ul>
        <br>
        <hr>
        <br>

        <a href="./fotos.php" alt="Fotos">Galeria de fotos</a>
            <ul>
                <li>Fotos da banda</li>
                <li>Ensaios fotográficos</li>
                <li>Todas as formações</li>
            </ul>
        <br>
        <hr>
        <br>

</aside>

    <footer> <p>&copy; 2025 Azul Turquesa. Todos os direitos reservados.</p></footer>

</body>

</html>