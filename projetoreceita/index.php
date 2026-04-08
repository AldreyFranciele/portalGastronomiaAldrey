<?php
require 'conexao.php';
require 'funcoes.php';

$sql = "SELECT n.*, u.nome as autor_nome FROM noticias n 
        JOIN usuarios u ON n.autor_id = u.id 
        ORDER BY n.data_publicacao DESC";
$noticias = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$mousses = [
    ['id' => 1, 'titulo' => 'Mousse de Chocolate Clássico', 'tempo' => '20 min', 'dificuldade' => 'Fácil', 'imagem' => 'https://areademulher.r7.com/wp-content/uploads/2023/02/1-20.jpg', 'ingredientes' => ['1 lata de leite condensado', '1 lata de creme de leite', '1/2 xícara de chocolate em pó', '1 colher (sopa) de manteiga', 'Chocolate granulado para decorar'], 'modo_preparo' => ['Bata no liquidificador o leite condensado, o creme de leite e o chocolate em pó por 3 minutos.', 'Derreta a manteiga e adicione à mistura, batendo rapidamente.', 'Despeje em taças individuais.', 'Leve à geladeira por 20 minutos.', 'Decore com granulado e sirva.']],
    ['id' => 2, 'titulo' => 'Mousse de Maracujá', 'tempo' => '15 min', 'dificuldade' => 'Fácil', 'imagem' => 'https://s2-receitas.glbimg.com/LM1z7kvNyZxCGdVLVQ3cX-pxuWI=/0x0:1366x768/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_1f540e0b94d8437dbbc39d567a1dee68/internal_photos/bs/2024/U/1/NKCkfISMaHYqyIB3VB3w/mousse-de-maracuja-facil.jpg', 'ingredientes' => ['1 lata de leite condensado', '1 lata de creme de leite', 'Suco de 3 maracujás', 'Sementes de maracujá para decorar'], 'modo_preparo' => ['Bata no liquidificador o leite condensado e o suco de maracujá por 2 minutos.', 'Adicione o creme de leite e bata rapidamente só para misturar.', 'Despeje em taças.', 'Decore com as sementes de maracujá.', 'Leve à geladeira por 15 minutos antes de servir.']],
    ['id' => 3, 'titulo' => 'Mousse de Morango', 'tempo' => '25 min', 'dificuldade' => 'Fácil', 'imagem' => 'https://www.receitasja.com.br/wp-content/uploads/2025/09/Mousse-de-morango-com-a-fruta.jpg', 'ingredientes' => ['1 lata de leite condensado', '1 lata de creme de leite', '1 xícara de morangos frescos', '1 colher (sopa) de açúcar', 'Morangos fatiados para decorar'], 'modo_preparo' => ['Lave e corte os morangos.', 'Bata no liquidificador o leite condensado e os morangos.', 'Adicione o creme de leite e bata rapidamente.', 'Despeje em taças.', 'Decore com morangos fatiados.', 'Leve à geladeira por 20 minutos.']],
    ['id' => 4, 'titulo' => 'Mousse de Limão', 'tempo' => '15 min', 'dificuldade' => 'Fácil', 'imagem' => 'https://static.itdg.com.br/images/1200-630/eb563ae2982ee653128838938d240331/181207-original.jpg', 'ingredientes' => ['1 lata de leite condensado', '1 lata de creme de leite', 'Suco de 3 limões', 'Raspas de limão para decorar'], 'modo_preparo' => ['Bata no liquidificador o leite condensado e o suco de limão.', 'A mistura vai engrossar naturalmente.', 'Adicione o creme de leite e misture delicadamente.', 'Despeje em taças.', 'Decore com raspas de limão.', 'Geladeira por 15 minutos.']],
    ['id' => 5, 'titulo' => 'Mousse de Doce de Leite', 'tempo' => '10 min', 'dificuldade' => 'Fácil', 'imagem' => 'https://guiadacozinha.com.br/wp-content/uploads/2015/01/mousse-de-doce-de-leite.jpg', 'ingredientes' => ['1 lata de leite condensado', '1 lata de creme de leite', '1/2 xícara de doce de leite', 'Canela em pó para decorar'], 'modo_preparo' => ['Bata no liquidificador o leite condensado e o doce de leite.', 'Adicione o creme de leite e bata rapidamente.', 'Despeje em taças.', 'Polvilhe canela em pó.', 'Sirva imediatamente ou leve 10 minutos à geladeira.']],
    ['id' => 6, 'titulo' => 'Mousse de Café', 'tempo' => '20 min', 'dificuldade' => 'Fácil', 'imagem' => 'https://static.itdg.com.br/images/640-360/c1fed2bbc3ad5aa15b53377413126420/135912-original.jpg', 'ingredientes' => ['1 lata de leite condensado', '1 lata de creme de leite', '1/2 xícara de café forte', 'Café em pó para decorar'], 'modo_preparo' => ['Prepare o café forte e deixe esfriar.', 'Bata no liquidificador o leite condensado e o café.', 'Adicione o creme de leite e bata rapidamente.', 'Despeje em taças.', 'Polvilhe café em pó por cima.', 'Leve à geladeira por 15 minutos.']],
    ['id' => 7, 'titulo' => 'Mousse de Coco', 'tempo' => '20 min', 'dificuldade' => 'Fácil', 'imagem' => 'https://static.ric.com.br/uploads/2020/08/mousse-de-coco-sem-gelatina-1068x600.jpg', 'ingredientes' => ['1 lata de leite condensado', '1 lata de creme de leite', '1/2 xícara de coco ralado', '1/2 xícara de leite de coco', 'Coco ralado tostado para decorar'], 'modo_preparo' => ['Bata no liquidificador o leite condensado e o leite de coco.', 'Adicione metade do coco ralado e bata.', 'Misture o creme de leite delicadamente.', 'Despeje em taças.', 'Decore com coco ralado tostado.', 'Leve à geladeira por 15 minutos.']]
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastronomia - Receitas e Notícias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=<?= time() ?>">
    <style>
        :root {
            --primary: #5D4037;
            --primary-dark: #3E2723;
            --primary-light: #8D6E63;
            --background: #F5F5F5;
            --white: #FFFFFF;
            --text: #3E2723;
        }
        
        body {
            background: var(--background);
        }
        
        .section-title {
            position: relative;
            display: inline-block;
            margin-bottom: 50px;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: 2px;
        }
        
        /* === HERO COM IMAGEM DE FUNDO === */
        .hero {
            background: linear-gradient(135deg, rgba(62, 39, 35, 0.9) 0%, rgba(93, 64, 55, 0.8) 100%),
                        url('imagens/banner.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            padding: 150px 0;
            border-radius: 0 0 50px 50px;
            margin-bottom: 60px;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 15s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        
        .mousse-destaque {
            border: 3px solid var(--primary);
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            height: 100%;
            min-height: 500px;
        }
        .mousse-destaque:hover {
            border-color: var(--primary-light);
            box-shadow: 0 20px 60px rgba(93, 64, 55, 0.3);
            transform: translateY(-10px);
        }
        .mousse-destaque::before {
            content: '🍰 ESPECIAL';
            position: absolute;
            top: 10px;
            right: -35px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            padding: 5px 40px;
            font-weight: bold;
            font-size: 0.8rem;
            transform: rotate(45deg);
            z-index: 1;
            box-shadow: 0 3px 10px rgba(93, 64, 55, 0.3);
            transition: all 0.3s ease;
        }
        .mousse-destaque:hover::before {
            right: -30px;
        }
        .mousse-destaque .card-img-top {
            height: 300px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .mousse-destaque:hover .card-img-top {
            transform: scale(1.05);
        }
        .mousse-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: white;
            color: var(--primary);
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: bold;
            box-shadow: 0 3px 10px rgba(93, 64, 55, 0.2);
            z-index: 2;
            font-size: 1rem;
        }
        .mousse-destaque:hover .mousse-badge {
            transform: scale(1.1);
        }
        
        .card-noticia {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            background: white;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            box-shadow: 0 5px 20px rgba(93, 64, 55, 0.1);
        }
        .card-noticia:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 20px 40px rgba(93, 64, 55, 0.2);
        }
        .card-noticia .card-img-top {
            height: 200px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .card-noticia:hover .card-img-top {
            transform: scale(1.1);
        }
        .card-noticia .card-body {
            padding: 20px;
        }
        .card-noticia .card-title {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }
        
        .receita-modal .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 60px rgba(93, 64, 55, 0.3);
        }
        .receita-modal .modal-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            border: none;
        }
        .mousse-item {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            box-shadow: 0 3px 15px rgba(93, 64, 55, 0.08);
            cursor: pointer;
        }
        .mousse-item:hover {
            transform: translateX(10px);
            border-color: var(--primary-light);
            box-shadow: 0 8px 25px rgba(93, 64, 55, 0.15);
        }
        .mousse-item h6 {
            color: var(--primary);
            font-weight: bold;
            margin-bottom: 15px;
        }
        .preparo-list {
            counter-reset: preparo;
            list-style: none;
            padding: 0;
        }
        .preparo-list li {
            counter-increment: preparo;
            padding-left: 40px;
            margin-bottom: 15px;
            position: relative;
            line-height: 1.6;
        }
        .preparo-list li::before {
            content: counter(preparo);
            position: absolute;
            left: 0;
            top: 0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
        }
        
        .badge-chocolate {
            background: var(--primary) !important;
            color: white !important;
        }
        .badge-chocolate-light {
            background: var(--primary-light) !important;
            color: white !important;
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        @media (max-width: 768px) {
            .hero {
                padding: 100px 0;
                border-radius: 0 0 30px 30px;
            }
            .mousse-destaque {
                min-height: auto;
            }
            .mousse-destaque .card-img-top {
                height: 200px;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="fas fa-utensils"></i> Gastronomia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="quem-somos.php">Quem Somos</a></li>
                    <li class="nav-item"><a class="nav-link" href="contato.php">Contato</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="perfil.php">Meu Perfil</a></li>
                        <li class="nav-item"><a class="nav-link" href="dashboard.php">Minhas Publicações</a></li>
                        <li class="nav-item"><a class="btn btn-outline-danger ms-2" href="logout.php">Sair</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Entrar</a></li>
                        <li class="nav-item"><a class="btn btn-custom ms-2" href="cadastro.php">Cadastre-se</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero text-center">
        <div class="container position-relative" style="z-index: 2;">
            <h1 class="display-3 fw-bold">Sabores e Notícias</h1>
            <p class="lead">Receitas deliciosas e novidades da culinária.</p>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="nova_noticia.php" class="btn btn-warning btn-lg mt-3 fw-bold shadow">
                    <i class="fas fa-plus-circle me-2"></i>Publicar Receita ou Notícia
                </a>
            <?php endif; ?>
        </div>
    </header>

    <div class="container mb-5">
        <div class="text-center">
            <h3 class="fw-bold section-title">📰 Receitas e Notícias</h3>
        </div>
        
        <div class="row mb-4">
            <div class="col-lg-8 col-md-12 mb-4 fade-in">
                <div class="card card-noticia shadow-sm mousse-destaque" data-bs-toggle="modal" data-bs-target="#modalMousses" style="cursor: pointer;">
                    <img src="https://areademulher.r7.com/wp-content/uploads/2023/02/1-20.jpg" class="card-img-top" alt="7 Mousses">
                    <span class="mousse-badge"><i class="fas fa-clock"></i> 30 min</span>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold" style="font-size: 1.5rem;">🍰 7 Mousses em 30 Minutos</h5>
                        <p class="text-muted mb-3">
                            <i class="fas fa-utensils"></i> 7 receitas deliciosas &bull; 
                            <i class="fas fa-signal"></i> Todas fáceis de fazer
                        </p>
                        <p class="card-text flex-grow-1" style="font-size: 1.1rem;">Descubra 7 receitas incríveis de mousses que você pode fazer rapidamente! Chocolate, maracujá, morango, limão, doce de leite, café e coco. Clique para ver todas as receitas completas.</p>
                        <button class="btn btn-custom btn-lg w-100 mt-3">
                            <i class="fas fa-eye"></i> Ver Todas as 7 Receitas
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-12">
                <div class="row">
                    <?php 
                    $primeiras_receitas = array_slice($noticias, 0, 2);
                    foreach($primeiras_receitas as $n): 
                    ?>
                        <div class="col-md-12 mb-3 fade-in">
                            <div class="card card-noticia shadow-sm">
                                <?php if($n['imagem']): ?>
                                    <img src="<?= htmlspecialchars($n['imagem']) ?>" class="card-img-top" alt="<?= htmlspecialchars($n['titulo']) ?>">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/400x200?text=Sem+Imagem" class="card-img-top">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold"><?= htmlspecialchars($n['titulo']) ?></h5>
                                    <p class="text-muted small mb-2">
                                        <i class="far fa-user"></i> <?= htmlspecialchars($n['autor_nome']) ?>
                                    </p>
                                    <a href="noticia.php?id=<?= $n['id'] ?>" class="btn btn-outline-dark w-100">Ler Mais</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <?php if(count($noticias) > 2): ?>
            <div class="row mt-4">
                <div class="col-12">
                    <h4 class="fw-bold mb-4" style="color: var(--primary);">📋 Mais Publicações</h4>
                </div>
                <?php 
                $restante_receitas = array_slice($noticias, 2);
                foreach($restante_receitas as $index => $n): 
                ?>
                    <div class="col-lg-4 col-md-6 mb-4 fade-in" style="transition-delay: <?= $index * 0.1 ?>s;">
                        <div class="card card-noticia shadow-sm">
                            <?php if($n['imagem']): ?>
                                <img src="<?= htmlspecialchars($n['imagem']) ?>" class="card-img-top" alt="<?= htmlspecialchars($n['titulo']) ?>">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/400x200?text=Sem+Imagem" class="card-img-top">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold"><?= htmlspecialchars($n['titulo']) ?></h5>
                                <p class="text-muted small mb-2">
                                    <i class="far fa-user"></i> <?= htmlspecialchars($n['autor_nome']) ?> &bull; 
                                    <i class="far fa-clock"></i> <?= formatarData($n['data_publicacao']) ?>
                                </p>
                                <p class="card-text flex-grow-1"><?= resumoTexto($n['noticia']) ?></p>
                                <a href="noticia.php?id=<?= $n['id'] ?>" class="btn btn-outline-dark w-100 mt-3">Ler Mais</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if(count($noticias) == 0): ?>
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>
                        Nenhuma publicação ainda. <a href="cadastro.php">Crie uma conta</a> e publique a primeira receita ou notícia!
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="modal fade receita-modal" id="modalMousses" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold mb-1">🍰 7 Mousses em 30 Minutos</h5>
                        <p class="mb-0 opacity-90">Receitas rápidas, fáceis e deliciosas!</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> <strong>Dica:</strong> Clique em cada receita para ver os detalhes completos!
                    </div>
                    <div class="row">
                        <?php foreach($mousses as $mousse): ?>
                            <div class="col-md-6 mb-4">
                                <div class="mousse-item" data-bs-toggle="collapse" data-bs-target="#mousse<?= $mousse['id'] ?>">
                                    <div class="d-flex align-items-start gap-3">
                                        <img src="<?= $mousse['imagem'] ?>" alt="<?= $mousse['titulo'] ?>" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-2"><?= $mousse['titulo'] ?></h6>
                                            <div class="d-flex gap-2 mb-2">
                                                <span class="badge badge-chocolate"><i class="fas fa-clock"></i> <?= $mousse['tempo'] ?></span>
                                                <span class="badge badge-chocolate-light"><i class="fas fa-check"></i> <?= $mousse['dificuldade'] ?></span>
                                            </div>
                                            <small class="text-muted"><i class="fas fa-chevron-down"></i> Clique para ver a receita</small>
                                        </div>
                                    </div>
                                    <div class="collapse mt-3" id="mousse<?= $mousse['id'] ?>">
                                        <hr>
                                        <h6 class="fw-bold"><i class="fas fa-shopping-basket" style="color: var(--primary);"></i> Ingredientes</h6>
                                        <ul class="list-unstyled ingredientes-list mb-3">
                                            <?php foreach($mousse['ingredientes'] as $ingrediente): ?>
                                                <li><i class="fas fa-check text-success me-2"></i><?= $ingrediente ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <h6 class="fw-bold"><i class="fas fa-list-ol" style="color: var(--primary);"></i> Modo de Preparo</h6>
                                        <ol class="preparo-list">
                                            <?php foreach($mousse['modo_preparo'] as $passo): ?>
                                                <li><?= $passo ?></li>
                                            <?php endforeach; ?>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-custom" onclick="window.print()">
                        <i class="fas fa-print"></i> Imprimir Todas
                    </button>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-4">
        <p class="mb-0">&copy; 2023 Portal Gastronomia. Todos os direitos reservados.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fadeElements = document.querySelectorAll('.fade-in');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if(entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });
            fadeElements.forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>