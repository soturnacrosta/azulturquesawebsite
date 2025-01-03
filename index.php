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
/*foi utilizado o seguinte passo a passo para que as tags não se repetissem durante os f5:
iniciar sessão apenas uma vez, pois se não controlar a sessão ele contibilizava indefinidademente;
no mysql, resetar o banco de daddos desativando a foreign key:
SET FOREIGN_KEY_CHECKS = 0;  -- Desabilita a verificação de chave estrangeira
DELETE FROM pagina_tags;     -- Exclui os dados relacionados
DELETE FROM paginas;         -- Exclui as páginas
DELETE FROM tags;            -- Exclui as tags
SET FOREIGN_KEY_CHECKS = 1;  -- Reabilita a verificação de chave estrangeira

depois:
DELETE FROM pagina_tags;  -- Exclui as associações de tags com páginas
DELETE FROM paginas;      -- Exclui as páginas
DELETE FROM tags;         -- Exclui as tags

A LINHA:
ALTER TABLE paginas ADD UNIQUE (titulo);

IMPEDE QUE DUPLIQUE OS DADOS;
*/
// Inicia a sessão para controlar a execução
session_start();

// Conexão com o banco de dados
$con = mysqli_connect('localhost', 'root', '', 'tags');

// Verificar se a conexão foi bem-sucedida
if (!$con) {
    error_log("Conexão falhou: " . mysqli_connect_error());
    exit;
}

// Verificar se a página "Homepage" já foi inserida nesta sessão
if (!isset($_SESSION['homepage_inserida'])) {
    // Verificar se a página já existe no banco de dados para evitar duplicidade
    $titulo = 'Homepage';
    $conteudo = 'Homepage do site da Azul Turquesa';
    $tipo = 'homepage';

    $stmt = mysqli_prepare($con, "SELECT id FROM paginas WHERE titulo = ?");
    mysqli_stmt_bind_param($stmt, 's', $titulo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 0) {
        // Inserir a página caso não exista
        $stmt = mysqli_prepare($con, "INSERT INTO paginas (titulo, conteudo, tipo) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sss', $titulo, $conteudo, $tipo);
        if (mysqli_stmt_execute($stmt)) {
            $pagina_id = mysqli_insert_id($con);

            // Lista de tags a serem associadas à página
            $tags = ['homepage do site azul turquesa', 'posts'];

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
            $_SESSION['homepage_inserida'] = true;
        }
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
    <link rel="icon" href="./assets/img/icone favicon.png"> <!--o valor do favicon é icon--> 
    <title>Azul Turquesa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css" type="text/css">

    <style>
        p {
            word-break: break-word; /*para colocar hífens e quebra automatica de linha */
        }

    </style>

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
    <main>
        
        <div class="mainpage-container">

            <h2>Sobre nós</h2><br>
            <div class="mainpage-container1">
                <!--a primeira postagem tem sua foto maior que as outras como padrão -- >
                <img src="./assets/img/materias/sobre_nos/soturna-azulTurquesa.jpg" alt="Soturna Crosta da banda de black metal paraibana Azul Turquesa"  width="500" height="auto" class="left-img"><br>
                <p>Azul Turquesa é uma one man band paraibana de Doom e Black Metal que experimenta novas formas de fazer som a cada lançamento. Explorando o contraste entre a brutalidade e crueza do Black Metal e
                    a beleza e soturnez do Doom Metal, Azul Turquesa aborda questões existenciais e depressão, além de romances e histórias de horror.<br>
                    A banda foi originalmente formada no dia 30 de novembro de 2021 quando fora lançada a demo intitulada AZUL TURQUESA (DEMO) contendo as faixas Obsessão (DEMO) e Mal Encorpado (DEMO). Embora formada nessa data, a banda já 
                    viera sendo planejada pelo membro fundador Mailton "Soturna Cröstä" Lemos.<br><br>
                <a href="./app/sobre_nos.php" alt="Sobre nós">Ler mais</a></p>
            </div>
            <br><br>
            <hr>

            <br>
            <h2>Downloads</h2><br>
            <div class="mainpage-container2">
                <img src="./assets/img/materias/downloads/Pusilanime-Azul-Turquesa.jpg" alt="Pusilânime capa Azul Turquesa"  width="300" height="auto" class="left-img"><br>
                <p>Aqui fica disponível para Download gratuito alguns trabalhos da Azul Turquesa em boa qualidade para todos curtirem.<br><br>
                <a href="./app/downloads.php" alt="Downloads">Ler mais</a></p>
            </div>
            <br><br>
            <hr>

            
            <br>
            <h2>Onde nos ouvir</h2><br>
            <div class="mainpage-container3">
                <img src="./assets/img/materias/galeria_de_fotos/azul-turquesa-logo-branco.png" alt="Azul Turquesa logo"  width="300" height="auto" class="left-img"><br>
                <p>Alguns dos links da banda reunidos.</br><br>
                <a href="./app/onde_ouvir.php" alt="Onde ouvir">Ler mais</a></p>
            </div>
            <br><br>
            <hr>


            <br>
            <h2>Letras de nossas músicas</h2><br>
            <div class="mainpage-container4">
                <img src="./assets/img/materias/galeria_de_fotos/azul-turquesa-logo-branco.png" alt="Azul Turquesa logo"  width="300" height="auto" class="left-img"><br>
                <p>Letras de todas as músicas da Azul Turquesa lançadas até agora, reunidas em um só lugar.<br><br>
                <a href="./app/letras.php" alt="Letras da Azul Turquesa">Ler mais</a></p>
            </div>
            <br><br>
            <hr>
                
            <br>
            <h2>Galeria de fotos</h2><br>
            <div class="mainpage-container5">
                <img src="./assets/img/materias/galeria_de_fotos/primeira-formacao-azul-turquesa.jpeg" alt="Azul Turquesa primeira formação"  width="300" height="auto" class="left-img"><br>
                <p>Fotos selecionadas da Azul Turquesa<br>
                <a href="./app/fotos.php" alt="Fotos da Azul Turquesa">Ler mais</a></p><br>
                <br><br>
                <!-- último não leva barra hr -->
            </div>
            
        </div>
        
    </main>
    
    <aside>

    <h3>Últimos posts</h3><br>

    <a href="./app/sobre_nos.php" alt="Sobre nós">Sobre nós</a>
        <ul>
            <li>História da banda</li>
            <li>Curiosidades</li>
            <li>Membros</li>
        </ul>
    <br>
    <hr>
    <br>

    <a href="./app/downloads.php" alt="Downloads">Downloads</a>
        <ul>
            <li>Downloads das músicas</li>
            <li>Gratuito</li>
            <li>Boa qualidade</li>
        </ul>
    <br>
    <hr>
    <br>

    <a href="./app/onde_ouvir.php" alt="Onde nos ouvir">Onde nos ouvir</a>
        <ul>
            <li>Links da banda</li>
            <li>Streaming gratuito e pago</li>
            <li>Várias opções</li>
        </ul>
    <br>
    <hr>
    <br>

    <a href="./app/onde_ouvir.php" alt="Onde nos ouvir">Onde nos ouvir</a>
        <ul>
            <li>Links da banda</li>
            <li>Streaming gratuito e pago</li>
            <li>Várias opções</li>
        </ul>
    <br>
    <hr>
    <br>

    <a href="./app/letras.php" alt="Letras">Letras de nossas músicas</a>
        <ul>
            <li>Links da banda</li>
            <li>Letras de nossas músicas</li>
            <li>Todas em um único lugar</li>
        </ul>
    <br>
    <hr>
    <br>

    <a href="./app/fotos.php" alt="Fotos">Galeria de fotos</a>
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