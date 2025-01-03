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
    // Em caso de falha na conexão, você pode logar o erro ou redirecionar o usuário
    error_log("Conexão falhou: " . mysqli_connect_error());
    exit;
}

// Verificar se a página já foi inserida nesta sessão
if (!isset($_SESSION['pagina_inserida'])) {
    // Inserção da página
    $titulo = 'Sobre nós';
    $conteudo = 'Sobre a banda Azul Turquesa';
    $tipo = 'Sobre a Azul Turquesa';
    
    // Preparando a query para evitar SQL injection
    $stmt = mysqli_prepare($con, "INSERT INTO paginas (titulo, conteudo) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, 'ss', $titulo, $conteudo);
    
    if (!mysqli_stmt_execute($stmt)) {
        // Caso ocorra erro ao inserir a página, logar o erro
        error_log("Erro ao inserir a página: " . mysqli_error($con));
    }
    
    $pagina_id = mysqli_insert_id($con);
    
    // Definir a lista de tags a serem associadas
    $tags = ['sobre a azul turquesa', 'historia da azul turquesa', 'curiosidades azul turquesa', 'azul turquesa'];
    
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
            if (!mysqli_stmt_execute($stmt)) {
                // Caso ocorra erro ao inserir a tag, logar o erro
                error_log("Erro ao inserir a tag '$tag_nome': " . mysqli_error($con));
            }
            $tag_id = mysqli_insert_id($con);
        } else {
            // Obter o ID da tag existente
            mysqli_stmt_bind_result($stmt, $tag_id);
            mysqli_stmt_fetch($stmt);
        }

        // Associar a página com a tag
        $stmt = mysqli_prepare($con, "INSERT INTO pagina_tags (pagina_id, tag_id) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, 'ii', $pagina_id, $tag_id);
        if (!mysqli_stmt_execute($stmt)) {
            // Caso ocorra erro ao associar a página com a tag, logar o erro
            error_log("Erro ao associar a página com a tag '$tag_nome': " . mysqli_error($con));
        }
    }

    // Marcar que a página foi inserida nesta sessão
    $_SESSION['pagina_inserida'] = true;
} else {
    // Se a página já foi inserida, não faz nada
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
    <title>Sobre nós</title>
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
        <div class="sobre-nos">
        <h1>Sobre a Azul Turquesa</h1>

            <img src="../assets/img/materias/sobre_nos/soturna-azulTurquesa.jpg" alt="Soturna Crosta da banda de black metal paraibana Azul Turquesa"  width="500" height="auto" class="center-img"><br>

            <p> Azul Turquesa é uma one man band paraibana de Doom e Black Metal que experimenta novas formas de fazer som a cada lançamento. Explorando o contraste entre a brutalidade e crueza do Black Metal e
            a beleza e soturnez do Doom Metal, Azul Turquesa aborda questões existenciais e depressão, além de romances e histórias de horror.<br>
            A banda foi originalmente formada no dia 30 de novembro de 2021 quando fora lançada a demo intitulada AZUL TURQUESA (DEMO) contendo as faixas Obsessão (DEMO) e Mal Encorpado (DEMO). Embora formada nessa data, a banda já 
            viera sendo planejada pelo membro fundador Mailton "Soturna Cröstä" Lemos.<br>
            Azul Turquesa passou por algumas modificações na formação até agora: Soturna sempre gravou todos os instrumentos e produziu as músicas, no bom e velho faça você mesmo. 
            Os músicos paraibanos Sidney "Siel Boná" Dore, Pedro Dias, Bruna Penazzi e Tamyres "Efêmera" Meireles entraram na banda nos primeiros meses de sua existência. 
            Logo antes do fim do primeiro aniversário da banda foi decidido a saída dos membros, exceto de Efêmera, que continuou na bateria até janeiro de 2024.<br>
            <br>
            O duo já lançou quatro demos intitulados:<br><br>

            <ul>
                <li>Azul Turquesa (DEMO)</li>
                <li>Fada sem asas (DEMO)</li>
                <li>Vazio (DEMO)</li>
                <li>Poema Fúnebre (DEMO)</li>
            </ul>            
            
            <br>

            Também quatro singles intitulados:<br><br>

            <ul>
                <li>Espelho de Cristal;</li>
                <li>Anacoreta;</li>
                <li>-CID 10 F19.5;</li>
                <li>-Nostalgia.</li>
            </ul>

            <br>

            E um EP intitulado:<br><br>

            <ul><li>Pusilânime.</li></ul>

            <br>

            Apesar de não tocar ao vivo, ainda, a banda compromete-se a ser presente nas redes e em estúdio.<br>

            A banda é ligada ao underground antifascista do Black Metal e frequentemente aparece ao lado de bandas de Red & Anarchist Black Metal.  Sendo assim, é também uma banda de RABM.<br><br>

            Formação:<br><br>

            Soturna Cröstä: vocais, guitarras, baixo, teclas e bateria (programação).<br><br>

            Ex-membros:<br><br>

            <ul>
                <li>-Siel Boná: guitarra base;</li>
                <li>-Pedro Dias: guitarra solo;</li>
                <li>-Bruna Penazzi: contra-baixo;</li>
                <li>-Efêmera: bateria.</li>
            </ul>

            <br>

            Contato: azulturquesabanda@gmail.com<br>

            Links: Linktree<br>

            Instagram: @azulturquesadoomblack
            </p>
            <br>

            <h4>Última atualização: 31 de dezembro de 2024.</h4>
            </div>

    </main>
    <aside>Relacionados</aside>
    <footer> <p>&copy; 2025 Azul Turquesa. Todos os direitos reservados.</p></footer>

</body>

</html>