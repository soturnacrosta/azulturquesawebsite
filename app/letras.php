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
    exit; // Interrompe a execução caso a conexão falhe
}

// Configura para mostrar erros de SQL (desenvolvimento)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Função para inserir tags
function inserirTag($con, $tag_nome) {
    // Verifica se a tag já existe
    $stmt = mysqli_prepare($con, "SELECT id FROM tags WHERE nome = ?");
    mysqli_stmt_bind_param($stmt, 's', $tag_nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 0) {
        // Inserir a tag se não existir
        $stmt = mysqli_prepare($con, "INSERT INTO tags (nome) VALUES (?)");
        mysqli_stmt_bind_param($stmt, 's', $tag_nome);
        mysqli_stmt_execute($stmt);
        return mysqli_insert_id($con); // Retorna o ID da tag inserida
    } else {
        // Obter o ID da tag existente
        mysqli_stmt_bind_result($stmt, $tag_id);
        mysqli_stmt_fetch($stmt);
        return $tag_id; // Retorna o ID da tag existente
    }
}

// Verificar se a página "Letras de nossas músicas" já foi inserida nesta sessão
if (!isset($_SESSION['letras_musicas_inserida'])) {
    // Definir o título e conteúdo
    $titulo = 'Letras de nossas músicas';
    $conteudo = 'Letras das músicas da Azul Turquesa';

    // Verifique se as variáveis estão definidas corretamente
    if (empty($titulo) || empty($conteudo)) {
        error_log("Erro: O título ou conteúdo não foi definido corretamente.");
        exit; // Interrompe a execução se as variáveis estiverem vazias
    }

    // Verificar se a página já existe no banco de dados
    $stmt = mysqli_prepare($con, "SELECT id FROM paginas WHERE titulo = ?");
    mysqli_stmt_bind_param($stmt, 's', $titulo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 0) {
        // A página ainda não existe, pode ser inserida
        // Preparando a query para evitar SQL injection
        $stmt = mysqli_prepare($con, "INSERT INTO paginas (titulo, conteudo) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, 'ss', $titulo, $conteudo);

        if (!mysqli_stmt_execute($stmt)) {
            error_log("Erro ao inserir a página: " . mysqli_error($con));
            exit; // Interrompe a execução em caso de erro
        }

        $pagina_id = mysqli_insert_id($con);

        // Lista de tags a serem associadas à página
        $tags = ['letras da azul turquesa', 'musicas da azul turquesa', 'azul turquesa'];

        // Inserir tags e associá-las à página
        foreach ($tags as $tag_nome) {
            $tag_id = inserirTag($con, $tag_nome);

            // Associar a página com a tag
            $stmt = mysqli_prepare($con, "INSERT INTO pagina_tags (pagina_id, tag_id) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, 'ii', $pagina_id, $tag_id);
            if (!mysqli_stmt_execute($stmt)) {
                error_log("Erro ao associar a página com a tag '$tag_nome': " . mysqli_error($con));
            }
        }

        // Marcar que a página foi inserida nesta sessão
        $_SESSION['letras_musicas_inserida'] = true;
    } else {
        // A página já existe, não faz nada
        error_log("A página '$titulo' já existe no banco de dados.");
    }
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
    <title>Letras de nossas músicas</title>
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

        <h1>Letras de nossas músicas</h1>

        <div style="text-align: center;">
            <img src="../assets/img/materias/downloads/azul-turquesa-logo.png" alt="Azul Turquesa logo" width="500" height="auto">
        </div>
        <br><br>

        <div class="Lyrics-container">

            <iframe width="560" height="315" src="https://www.youtube.com/embed/uym7d-FZ4WQ?si=YYvtrbty4w2vEXwZ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <br>
            <h3>Poema Fúnebre</h3>
            <p>
                É uma pena
                Quem para e pensa
                Acaba sofrendo a pena
                De uma sentença
                Semeado em saraiva
                E terra tenra

                O brilho do broto 
                descansa em dor plena
                Como se o sol desaparecesse 
                as dezessete e cinquenta
                E a lua tomasse a cor sangrenta

                É noite de Halloween
                É importante para ti 
                Também para mim 
                Uma vez no ano os mortos 
                saem dos túmulos e pisam nos jardins 
                Do cemitério assim 
                Marchando de porta em porta
                com um olhar carmesim 

                Tolos aqueles que se amedrontam 
                Com os que aqui já não se encontram 
                Bendito aqueles que os enfrentam 
                E assim espantam
                Os mortos e mortas das portas
                
                É com esse ar febril
                Com uma canção fúnebre 
                Que reside o covil 
                lapidado em azul anil 
                Talvez não seja necessário 
                Tomar tanto espaço 
                O dia é brilhante e
                há coisas a fazer 
                Não tem a crer que o tolo sol pode desmerecer
                Ou entristecer 
                Afinal só os bravos 
                andam no anoitecer 
                E também os atormentados 

                (Refrão)
                O astro precisa de um alto astral 
                O astro reside no antro em espiral 
                A entropia ou o caracol 
                É com certeza muito maior 
                Que arrogância de um orador menor 

                Enquanto aqueles que procuram
                na ciência a resolução 
                da equação do  universo 
                Os mortos descansam em solo fértil 
                Dos nutrientes dos corpos decrépitos 

                Paralisados sob madeira ou concreto 
                Mas todos eles se foram 
                com um lado secreto 
                Do seu pensar, decerto

                Há tantas coisas que a lua 
                Influencia nas ruas 
                A caminhada dos vampiros e dos zumbis 
                Das almas perdidas e das alcateias 

                É Halloween 
                Não precisa terminar assim 
                A lua está cheia e o céu nublado 
                Isso não precisa entristecer seu quarto 
                Pois a dor que a consome é do erro de um homem 

                Que esta tentativa não seja inútil 
                Embora talvez seja mais fútil 
                Do que penso em meu culto 
                Que possa florescer mesmo com o açoite 
                E brilhe antes da meia noite
            </p>

            <iframe width="560" height="315" src="https://www.youtube.com/embed/dHdDZdHt25g?si=5KQ2b0rzMRvd9bmo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <br>
            <h3>Mal Encorpado</h3>
            <p>
                Num vazio inevitável
                Uma perseguição incansável 
                Mata na alvorada
                O medo se alimenta mais uma vez

                Daquele vulto em sua casa
                Descendo as escadas 
                As luzes se apagam
                E as paredes se afastam

                O barulho acompanha 
                O clarão
                Estremece os vasos 
                Se despedaçam pelo chão

                O medo pelo desconhecido toma a alma
                Preso em sua própria casa
                Os amigos imaginários
                Saem dos armários 

                Num vazio inevitável
                Uma perseguição incansável 
                Mata na alvorada
                O medo se alimenta mais uma vez

                Daquele vulto em sua casa
                Descendo as escadas 
                As luzes se apagam
                E as paredes se afastam

                O barulho acompanha 
                O clarão
                Estremece os vasos 
                Se despedaçam pelo chão

                O medo pelo desconhecido toma a alma
                Preso em sua própria casa
                Os amigos imaginários
                Saem dos armários 

                Cansado dessa humilhação
                Que escurece a visão 
                Mais um dia que não se chega
                Esmagado e mastigado 
                Pelo mal encorpado


            </p>
            
            <iframe width="560" height="315" src="https://www.youtube.com/embed/aeuijptoFV8?si=VShwZCONJCVjtpNe" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <h3>Fada sem Asas</h3>
            <p>
                Enquanto caminho por campos decrépitos
                O futuro se abriga num conto incerto
                Infinito são os galhos desse vale eterno
                Sem uma visão clara que me salve desse inferno
                Vagando pelo desconhecido terreno infértil
                Encontro-me pálido, nesse jardim de desertos
                Decerto há almas e diabinhos espertos
                Em qual desses trapaceiros posso chegar perto?
                Qual caminho seguir é um indecifrável mistério

                Como um caminho estreito nesse pequeno vale
                Causa tanto desgaste e me corrói completamente a carne
                Eu não entendo como alguém poderia sobreviver a esse entrave
                Mas com pouca força em mãos, eu poderei sobreviver a esse escarne

                Ah
                Se eu pudesse entender de uma vez
                Como eu devo caminhar
                Por um seguro lugar
                Aonde eu possa descansar
                Em paz sob o luar
                Ah
                Floresta perdida, porta de entrada
                A fada sem asa
                O caminho de casa
                A dor sem causa
                O perigo disfarça
                O enigma de uma máscara 

                Perdido entre as árvores
                Na madeira eu talho a disposição do meu passo
                Tentando compreender o que eu faço
                Para ter você, meu querido morro florado 
                Viajo entre as nuvens e as estrelas
                Procurando por uma direção qualquer
                Não consigo me manter de pé
                Para onde é o norte? 
                Talvez lá eu encontre meu velho amigo, a morte

                Ah
                Se eu pudesse entender de uma vez
                Como eu devo caminhar
                Por um seguro lugar
                Aonde eu possa descansar
                Em paz sob o luar
                Ah
                Floresta perdida, porta de entrada
                A fada sem asa
                O caminho de casa
                A dor sem causa
                O perigo disfarça
                O enigma de uma máscara

            </p>
        
            <iframe width="560" height="315" src="https://www.youtube.com/embed/7e2A9ATNxSA?si=gccQljRpz3LufZlY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <h3>Vazio</h3>
            <p>
                Que dor é essa 
                Que mal chega e me disseca
                Me põe pra baixo 
                Me deixa de lado

                Que dor é essa
                Que me corta em peças 
                Me fode com força 
                Nem mesmo me perdoa

                Quanto conflito enquanto estou vivo 
                Quanta tristeza em minha cabeça
                As vozes me dizem para tentar mais uma vez
                "PULA"!!!
            </p>

            <iframe width="560" height="315" src="https://www.youtube.com/embed/Bn_gDS77bZw?si=CqfpaNEcSrWTv5xW" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <h3>Obsessão</h3>
            <p>
                Obsessão
                Compulsão
                Repulsão

                Obsessão
                Compulsão
                Aquietação

                Até que dia
                A euforia
                Vai me arruinar então

                A flor se abria
                Eu jamais sorria
                Enquanto não for minha

                Obsessão
                Compulsão
                Repulsão

                Obsessão
                Compulsão
                Aquietação

                Como se as coisas
                Não tivessem vida
                É minha partida

                Crente em nenhum deus
                Amigos nunca foram meus
                Mais uma vez, me esqueceu

                Oh a vida
                A vida tem melodia
                A vida tem magia

                A vida é minha
                Aquela striga
                É toda minha

                Ela é toda minha
                Me enfeitiça enquanto sorria
                Sua alma é toda minha

                Para toda vida

                Obsessão
                Compulsão
                Repulsão

                Obsessão
                Compulsão
                Aquietação

                Dor e morte
                Má sorte
                Faça o corte

                Dor e morte
                Má sorte
                Faça o corte

                Obsessão
                Uma doença
                Que a essa altura
                Não se cura

                Obsessão
                Compulsão
                Aquietação

                Como se as coisas
                Não tivessem vida
                É minha partida

                Crente em nenhum deus
                Amigos nunca foram meus
                Mais uma vez, me esqueceu

                Oh a vida
                A vida tem melodia
                A vida tem magia, a magia

                A vida é minha
                Aquela striga
                É toda minha

                Ela é toda minha
                Me enfeitiça enquanto sorria
                Sua magia é toda minha

                A vida é minha
                A vida tem magia
                A vida é minha

                Aquela striga é toda minha
                Ela é toda minha
                Me enfeitiça enquanto sorria

                Sua alma é toda minha

                Ela nunca poderá me deixar
                Isso não pode acabar
                Para sempre vamos ficar

                Para sempre vamos ficar
                Com certeza vamos estar
                Juntos ao luar

                Ela nunca poderá me deixar
                Isso não pode acabar
                Para sempre vamos ficar
            </p>

            <iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?si=g222hKyabtgQKqtC&amp;list=OLAK5uy_nh4u3vo8iI0Ucu05dZk51zVc4X3Qr2q6Q" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <h3>Espelho de Cristal</h3>
            <p>
                Numa vaga lembrança 
                O jovem se esbanja 
                Lamúria plutônica 
                De uma paixão platônica 

                O desespero em seu corpo
                Já tornou-se um estorvo 
                E a pressa que o consome
                Tampouco não some 

                A vida jamais bela 
                Pela amada ele espera 
                Com o sangue nos dentes 
                E o repúdio dos mais crentes 

                O seu coração por ela bate 
                A rejeição é um impasse 
                É necessário uma mudança 
                Sua mente é insana 

                Suspense dos ritos
                Suas preces, seus gritos
                A amargura engana
                O sabor nas entranhas 

                Os pesos, a loucura 
                A dor e a doçura 
                De uma história obscura 
                De uma mente impura 

                Um dia perdido 
                Cansado e esguio
                No campo das pampas
                Onde a luz jamais alcança 

                A luz escura 
                Brilha como quem procura
                Uma presa para maltratar 
                Logo pensou que era seu lugar

                Um espelho de cristal 
                Que reluzia uma luz como tal
                Tão fascinante e hipnotizante
                Tal qual a mais bela aurora boreal 

                Logo lembrou de presentear
                A sua amada para lhe amar 
                "O teu coração será só meu 
                E meu coração será só teu"

                Correu saltitante para a vila
                Como se toda sua vida 
                Passasse diante de seus olhos 
                Fez suas preces para os mortos

                "O meu coração, eu entrego em tuas mãos
                Para que com o sangue em tinta, sua compleição seja toda minha"
                "O meu coração, eu entrego em tuas mãos
                Para que com o sangue em tinta, sua compleição seja toda minha"

                Suspense dos ritos
                Suas preces, seus gritos
                A amargura engana
                O sabor nas entranhas 

                Os pesos, a loucura 
                A dor e a doçura 
                De uma história obscura 
                De uma mente impura 

                Na casa da amada, logo bateu em sua porta
                Nem prestou atenção, ela estava em sua horta 
                Atrás de sua casa, preparando a comida para a estrada 
                Pois no dia seguinte, era tempo de homenagear pessoas mortas 

                Os instantes se passaram, a paciência se acabou 
                O jovem amante se estressou, e logo logo ele gritou 
                A jovem correu para entender, o porque de toda essa gritaria, para conter 

                "Minha amada, tu és a mais bela moradia para meu coração.
                Quando toco tua pele, eu não sinto mais nenhum estresse, sinto minha respiração falhar
                Aceite esse presente, espero que aceite, o entrego com muito carinho"

                A jovem se estressou e o punho o serrou
                As sobrancelhas franziu e nem mesmo sorriu
                A sua fúria era grande por ser importunada em um momento importante
                Era momento de trabalho para homenagear o seu tio morto, também amado 

                Ela se irritou e nada falou 
                Ela fechou a porta na hora
                Ela se irritou e nada falou 
                Ela fechou a porta na hora

                O jovem triste e arrasado 
                Sem rumo e cansado 
                Chorava pela desilusão 
                Que tomava sua emoção 

                Não chore, jovem amante
                O seu amor não ficará numa estante 
                Há vida pela frente 
                Há várias pretendentes

                Naquele livro de angústia
                Para o espelho de cristal 
                Ele mais uma vez olhou 
                Por algum motivou ele se enfeitiçou 

                Naquele vidro de cristal 
                Tudo era magnífico
                Tão glorioso, tão imenso 
                De uma intensa beleza astral 

                A graciosidade e as feições 
                Que ele via em suas ações 
                Só ocorriam no espelho 
                Uma realização do seu desejo

                Era tão bela a visão 
                Que estava em suas mãos 
                Que tudo que estava a seu redor 
                Se tornava tão menor 

                Em pouco tempo ele se fechou
                Sua amada desamou 
                Sua família ele esqueceu 
                E sua vida social, perdeu 

                Suspense dos ritos
                Suas preces, seus gritos
                A amargura engana
                O sabor nas entranhas 

                Os pesos, a loucura 
                A dor e a doçura 
                De uma história obscura 
                De uma mente impura

                Era tanto amor pela imagem 
                Que um feitiço lhe inspirou coragem 
                Também força, felicidade, vaidade 
                Passou a amar a si mesmo, na verdade 

                No espelho de cristal 
                Na verdade o que ele via no final 
                Era a imagem da sua amada
                Cuidando das coisas no seu quintal 

                No espelho de cristal 
                A matéria prima é o mal 

                O espelho se quebrou 
                Quando no chão caiu 
                E o amor se acabou 
                O sol se deitou 

                E o jovem descansou
            </p>

            <iframe width="560" height="315" src="https://www.youtube.com/embed/HUvMTKfc2fY?si=2sE8iXoemzXLf2UH" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <h3>Anacoreta</h3>
            <p>
                Enquanto vivo em solitude
                Eu me sinto cada vez mais
                Presa a tua vaga quietude
                Refém do teu amor fugaz

                O tempo que aqui não corre
                Causa o ponteiro do relógio
                Pilha nossas almas para o norte
                Imaculado amor simplório

                No céu azul eu vejo estrelas
                Na luz das estrelas eu vejo a nós
                No amor diurno tua fraqueza
                Lá no infinito estamos as sós 

                Em meio as ondas, me seduz
                Em ti que encontrei a farta luz 
                Vencida à própria solidão
                Taciturna estendes tuas mãos

                "Desde que você me deixou
                Memórias não são mais que cinzas 
                O tempo aqui jamais passou
                Viver é lembrar dores extintas"

                O ponteiro que aqui não corre
                Lá foge do vão de emoções
                Lá nos astros projeto meus cortes
                O planeta e suas rotações

                O medo que me afaga o peito
                Caprichosa última esperança
                Sofrimento, caminho estreito
                Espera póstuma, ode aliança

                Meu amor alegre me comove
                Sinto nostalgia na dor
                Ao me injetarem remédios às nove
                Sem me pedirem por favor
                
                Eles chamam de esquizofrênicas
                Por tudo que passamos juntas
                Com tais bobagens acadêmicas
                E suas religiões imundas

                Nossa história não acabou
                Sei que você não me esqueceu
                Você sempre, sempre me amou
                Estar só sempre me doeu

                "Desde que você me deixou
                Os dias não têm as mesmas cores
                O canto do galo se calou
                As comidas não tem sabores"

                O ponteiro que aqui não corre
                Lá foge do vão de emoções
                Lá nos astros projeto meus cortes
                O planeta e suas rotações

                O medo que me afaga o peito
                Caprichosa última esperança
                Sofrimento, caminho estreito
                Espera póstuma, ode aliança

                "Eu até me recordo das noites
                De quando ficávamos as sós
                Fugindo, com medo do açoite
                Mas eu amava ouvir tua voz

                Daquele tempo de magias
                De quando estávamos sedadas
                Pelo céu que reluzia
                O violeta em nossas estradas

                Mas por que tudo isso  acabou?
                Se em nenhuma ferida pisamos
                Desde quando o padre chegou
                Tal amor não mais encontramos

                Tantas vezes tentei  fugir
                Quantas vezes sonhei escapar

                Lá no fundo escondo uma martir

                Não pertenço a este lugar"

                "Lá no fundo escondo uma martir
                Não pertenço a este lugar"

                O ponteiro que aqui não corre
                Lá foge do vão de emoções
                Lá nos astros projeto meus cortes
                O planeta e suas rotações

                O medo que me afaga o peito
                Caprichosa última esperança
                Sofrimento, caminho estreito
                Espera póstuma, ode aliança
            </p><br>

        <h2>Pusilânime (2024):</h2>

            <iframe width="560" height="315" src="https://www.youtube.com/embed/BVBuItyTrLQ?si=tW2U_Xp2aZ_cBQYp" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <h3>CID 10 F19.5</h3>
            <p>
                E nesta fria noite que começa
                Eu caminho sob as luzes dos postes
                A árdua esperança em mim que carrega
                O canto e coros das aves por estrofes
                Agora as vejo negras, pois me cega
                Do breu que cresce aqui dentro, dos cortes
                Emitindo uma luz fraca bem distante
                Que se afunda em minha alma dissonante

                Ao meu lado, o parque e dez crianças
                Elas brincam, correm, gritam, se escondem
                Como se não houvesse um único homem
                Aguardando-as, com perseverança
                Que talvez pudesse dizer para elas
                Que há criaturas habitando as trevas

                Mas não é que a inocência é assim?
                Os fortes não irão se acanhar
                Encorajando quem irá enfrentar
                No fim da história, o rei carmesim
                Com a espada de prata em suas duas mãos
                E que suas mortes não sejam em vão

                Mas não é que a inocência é assim?
                Os fortes não irão se acanhar
                Encorajando quem irá enfrentar
                No fim da história, o rei carmesim
                Com a espada de prata em suas duas mãos
                E que suas mortes não sejam em vão

                E que as lágrimas dos entes queridos
                De alguma maneira são sim abrigos
                Para as almas dos caídos perdidos
                Em seus túmulos vão descansar em paz
                Para que enfim, não sofrer jamais
            </p>

            <iframe width="560" height="315" src="https://www.youtube.com/embed/_aRHdFb-HmQ?si=rAPBI2dsvSvV54nX" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <h3>Obsessão (Compulsão, Repulsão)</h3>
            <p>
                (Obsessão, compulsão, repulsão)
                (Obsessão, compulsão, aquietação)

                Mas até que dia a tua partida
                Vai convencer as nuas mãos?
                Daquela sua dor sofrida
                Que a minha mente vazia
                Decolou rumo ao céu sem chão

                (Obsessão, compulsão, repulsão)
                (Obsessão, compulsão, aquietação)

                Como se as coisas não tivessem
                Vida, chegou  minha partida
                Porque sou crente em nenhum deus
                E seu amor não me convenceu

                (Obsessão, compulsão, repulsão)
                (Obsessão, compulsão, aquietação)
                (Obsessão, compulsão, repulsão)
                (Obsessão, compulsão, aquietação)

                Como se as coisas não tivessem
                Vida, chegou  minha partida
                Porque sou crente em nenhum deus
                E seu amor não me convenceu
            </p>


            <iframe width="560" height="315" src="https://www.youtube.com/embed/0MY4onoB5FU?si=nbmhNb7W2FvP4j9w" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <h3>Pusilânime</h3>
            <p>
                O vazio eu vivi
                Numa noite eu andei
                Tanto medo senti 
                Por tudo que amei

                Quantas noites sonhei
                Só para tê-la em mãos
                Quantas coisas deixei
                A ter seu coração

                Se eu pudesse sair
                Como algum girassol
                Que segue por aí
                O sol ao seu redor

                (Mas a lua me procura
                A noite logo vem
                Assim que me deslumbra
                A calma me mantém)

                Cortado em seis pedaços
                À luz da lamparina
                Diante do carrasco
                Queimando a parafina

                Já estou condenado
                Sem refúgio acima
                Sem amigo cá embaixo
                Entregue à chacina

                Mas se tudo o que faço
                É te encarar  por trás
                Pegar teu ante-braço
                E te deixar em paz

                A artéria que bombeia
                O sangue no meu corpo
                Segura como areia
                Se desfaz pelo torso
            </p>

            <iframe width="560" height="315" src="https://www.youtube.com/embed/SdxAx_i5o78?si=67Xqjd-vCsJGFPFx" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>        <h3>Cacofonia</h3>
            <p>(Instrumental)</p>

            <iframe width="560" height="315" src="https://www.youtube.com/embed/Dl1pPuuLRZ4?si=-KW6p2UYEJHvJ4a5" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <h3>Nostalgia</h3>
            <p>
                Como vivo?
                Em castigo
                Que maldita
                Nostalgia

                Entre alguém
                Sou ninguém
                Um vazio
                Invisível

                Todo dia
                A Maldita
                Melodia
                Melodia

                Me assombra
                Me transtorna
                Me apavora
                E me consome

                Me destrói
                Me corrói
                Quão me dói
                Quão me dói

                Como vivo?
                Em castigo
                Que maldita
                Nostalgia

                Entre alguém
                Sou ninguém
                Um vazio
                Invisível

                Todo dia
                A Maldita
                Melodia
                Melodia

                Me assombra
                Me transtorna
                Me apavora
                E me consome

                Me destrói
                Me corrói
                Quão me dói
                Quão me dói

                "O corvo na janela
                Me observa atentamente
                Bate as asas e ri
                De asas abertas

                Eu olho então
                Com o papel e caneta na mão
                Escrevo com essas palavras
                Que logo logo, lágrimas cairão

                Sabe-se lá como consigo
                Escrever o que aqui está escrito
                A tristeza que me acompanha
                Ninguém mais estranha

                É tão comum
                Assim como dois é igual um mais um
                Que eu sou soturno assim
                Ninguém estranharia um poema triste vindo de mim"
            </p>
            <br><br>

            <p><b>Sabia que você pode baixar gratuitamente as músicas da Azul Turquesa em boa qualidade? Clique abaixo!</b>
            <a href="./downloads.html" alt="Página de Download">Página de Downloads</a> 
             </p>

        </div>
    
    </main>
    <aside>Relacionados</aside>
    <footer> <p>&copy; 2025 Azul Turquesa. Todos os direitos reservados.</p></footer>

</body>

</html>