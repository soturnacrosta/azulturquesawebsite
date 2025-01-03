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
    exit;
}

// Verificar se a página "Onde nos ouvir" já foi inserida nesta sessão
if (!isset($_SESSION['onde_nos_ouvir_inserida'])) {
    // Verificar se a página já existe no banco de dados
    $stmt = mysqli_prepare($con, "SELECT id FROM paginas WHERE titulo = ?");
    $titulo = 'Onde nos ouvir';
    mysqli_stmt_bind_param($stmt, 's', $titulo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 0) {
        // Inserção da página "Onde nos ouvir"
        $conteudo = 'Onde ouvir a Azul Turquesa';
        $tipo = 'links';
        
        $stmt = mysqli_prepare($con, "INSERT INTO paginas (titulo, conteudo, tipo) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sss', $titulo, $conteudo, $tipo);

        if (mysqli_stmt_execute($stmt)) {
            $pagina_id = mysqli_insert_id($con);
            
            // Lista de tags a serem associadas à página
            $tags = ['onde ouvir azul turquesa', 'links turquesa', 'onde achar azul turquesa', 'azul turquesa spotify', 'azul turquesa youtube'];
            
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
                if (!mysqli_stmt_execute($stmt)) {
                    error_log("Erro ao associar a página com a tag '$tag_nome': " . mysqli_error($con));
                }
            }

            // Marcar que a página foi inserida nesta sessão
            $_SESSION['onde_nos_ouvir_inserida'] = true;
        } else {
            error_log("Erro ao inserir a página: " . mysqli_error($con));
        }
    } else {
        error_log("A página 'Onde nos ouvir' já existe no banco de dados!");
    }
} else {
    error_log("A página 'Onde nos ouvir' já foi inserida nesta sessão!");
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
    <title>Onde nos ouvir</title>
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

        <h1>Onde nos ouvir</h1>

        <div class="links-containers">
            <h3>Spotify</h3>
            <iframe style="border-radius:12px" src="https://open.spotify.com/embed/album/4HJDpFAYVhMTFpUdfIkAco?utm_source=generator" width="40%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
            
            <h3>Youtube</h3>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/uym7d-FZ4WQ?si=rhpxzUCC26LmLACr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            
            <h3>Deezer</h3>
            <iframe title="deezer-widget" src="https://widget.deezer.com/widget/dark/track/2944263121" width="550" height="300" frameborder="0" allowtransparency="true" allow="encrypted-media; clipboard-write"></iframe>
            
            <h3>Apple Music</h3>
            <iframe allow="autoplay *; encrypted-media *; fullscreen *; clipboard-write" frameborder="0" height="440" style="width:100%;max-width:550px;overflow:hidden;border-radius:10px;" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-storage-access-by-user-activation allow-top-navigation-by-user-activation" src="https://embed.music.apple.com/br/album/anacoreta-single/1686812424"></iframe>
            
            <h3>Soundcloud</h3>
            <iframe width="40%" height="300" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/1423181056&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"></iframe><div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"><a href="https://soundcloud.com/user-262121079-817891411" title="Azul Turquesa" target="_blank" style="color: #cccccc; text-decoration: none;">Azul Turquesa</a> · <a href="https://soundcloud.com/user-262121079-817891411/espelho-de-cristal" title="Espelho De Cristal" target="_blank" style="color: #cccccc; text-decoration: none;">Espelho De Cristal</a></div>
            
            <h3>Bandcamp</h3>
            <iframe style="border: 0; width: 50%; height: 120px;" src="https://bandcamp.com/EmbeddedPlayer/track=1189228237/size=large/bgcol=ffffff/linkcol=0687f5/tracklist=false/artwork=small/transparent=true/" seamless><a href="https://azulturquesa.bandcamp.com/track/nostalgia">Nostalgia by Azul Turquesa</a></iframe>
            
            <br>
            <p><b>Sabia que você pode baixar gratuitamente as músicas da Azul Turquesa em boa qualidade? Clique abaixo!</b>
                <a href="./downloads.html" alt="Página de Download">Página de Downloads</a> 
            </p>
    </div>
            
            <footer>
                <?php
                    // Conexão com o banco de dados
                    $con = mysqli_connect('localhost', 'root', '', 'tags');

                    // Verificar se a conexão foi bem-sucedida
                    if (!$con) {
                        die("Conexão falhou: " . mysqli_connect_error());
                    }

                    // Inserção da página
                    $titulo = 'Onde nos ouvir';
                    $conteudo = 'Links para ouvir Azul Turquesa';
                    $sql = "INSERT INTO paginas (titulo, conteudo) VALUES ('$titulo', '$conteudo')";
                    mysqli_query($con, $sql);
                    $pagina_id = mysqli_insert_id($con); // Obtém o ID da página inserida

                    // Definir a tag que você deseja associar à página
                    $tag_nome = 'ondeouvir'; // Exemplo de tag

                    // Verificar se a tag já existe
                    $sql = "SELECT id FROM tags WHERE nome = '$tag_nome'";
                    $result = mysqli_query($con, $sql);

                    if (mysqli_num_rows($result) == 0) {
                        // Caso a tag não exista, insere a nova tag
                        $sql = "INSERT INTO tags (nome) VALUES ('$tag_nome')";
                        mysqli_query($con, $sql);
                        $tag_id = mysqli_insert_id($con); // Obtém o ID da tag inserida
                    } else {
                        // Caso a tag já exista, obtém o ID da tag
                        $row = mysqli_fetch_assoc($result);
                        $tag_id = $row['id'];
                    }

                    // Associar a página com a tag
                    $sql = "INSERT INTO pagina_tags (pagina_id, tag_id) VALUES ($pagina_id, $tag_id)";
                    mysqli_query($con, $sql);

                    // Fechar a conexão
                    mysqli_close($con);
                    ?>
                </footer>

    </main>
    <aside>Relacionados</aside>
    <footer> <p>&copy; 2025 Azul Turquesa. Todos os direitos reservados.</p></footer>

</body>

</html>