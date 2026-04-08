<?php
require 'funcoes.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quem Somos - Gastronomia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=<?= time() ?>">
    <style>
        /* === MESMO TEMA DO INDEX.PHP === */
        :root {
            --primary: #5D4037;
            --primary-dark: #3E2723;
            --primary-light: #8D6E63;
            --background: #F5F5F5;
            --white: #FFFFFF;
            --text: #3E2723;
            --text-light: #795548;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--background);
            color: var(--text);
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Playfair Display', serif;
        }
        
        /* === NAVBAR IGUAL AO INDEX === */
        .navbar {
            background: var(--white);
            box-shadow: 0 4px 20px rgba(93, 64, 55, 0.1);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        .navbar:hover {
            box-shadow: 0 6px 30px rgba(93, 64, 55, 0.15);
        }
        .navbar-brand {
            color: var(--primary) !important;
            font-size: 1.6rem;
            font-weight: bold;
            transition: transform 0.3s ease;
        }
        .navbar-brand:hover {
            transform: scale(1.05);
        }
        .nav-link {
            color: var(--text) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            position: relative;
            transition: color 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link:hover::after {
            width: 80%;
        }
        .nav-link:hover {
            color: var(--primary) !important;
        }
        .nav-link.active {
            color: var(--primary) !important;
        }
        .nav-link.active::after {
            width: 80%;
        }
        
        /* === HERO HEADER === */
        .sobre-hero {
            background: linear-gradient(135deg, rgba(62, 39, 35, 0.9) 0%, rgba(93, 64, 55, 0.8) 100%),
                        url('https://images.unsplash.com/photo-1556910103-1c02745a30bf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            padding: 120px 0;
            margin-bottom: 60px;
            position: relative;
            overflow: hidden;
            border-radius: 0 0 50px 50px;
        }
        .sobre-hero::before {
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
        
        /* === CARDS DE VALORES === */
        .valores-card {
            border: none;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            background: white;
            box-shadow: 0 10px 40px rgba(93, 64, 55, 0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
        }
        .valores-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 20px 50px rgba(93, 64, 55, 0.2);
        }
        .valores-card i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        .valores-card:hover i {
            transform: scale(1.1);
        }
        .valores-card h4 {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 15px;
        }
        .valores-card p {
            color: var(--text-light);
            line-height: 1.6;
        }
        
        /* === IMAGENS === */
        .equipe-img {
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(93, 64, 55, 0.15);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            width: 100%;
        }
        .equipe-img:hover {
            transform: scale(1.02);
            box-shadow: 0 15px 50px rgba(93, 64, 55, 0.25);
        }
        
        /* === STATS BOX === */
        .stats-box {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(93, 64, 55, 0.2);
        }
        .stats-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(93, 64, 55, 0.3);
        }
        .stats-box h3 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        /* === BOTÕES === */
        .btn-custom {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(93, 64, 55, 0.3);
        }
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(93, 64, 55, 0.4);
            color: white;
        }
        
        .btn-outline-dark {
            border: 2px solid var(--primary);
            color: var(--primary);
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-outline-dark:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }
        
        /* === ANIMAÇÃO DE SCROLL === */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* === FOOTER === */
        footer {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transition: all 0.3s ease;
        }
        footer:hover {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        }
        
        /* === SECTION TITLE === */
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
        
        /* === RESPONSIVE === */
        @media (max-width: 768px) {
            .sobre-hero {
                padding: 80px 0;
                border-radius: 0 0 30px 30px;
            }
            .sobre-hero h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

    <!-- NAVBAR IGUAL AO INDEX -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="fas fa-utensils"></i> Gastronomia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link active" href="quem-somos.php">Quem Somos</a></li>
                    <li class="nav-item"><a class="nav-link" href="contato.php">Contato</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="perfil.php">Meu Perfil</a></li>
                        <li class="nav-item"><a class="nav-link" href="dashboard.php">Minhas Publicações
</a></li>
                        <li class="nav-item"><a class="btn btn-outline-danger ms-2" href="logout.php">Sair</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Entrar</a></li>
                        <li class="nav-item"><a class="btn btn-custom ms-2" href="cadastro.php">Cadastre-se</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO HEADER -->
    <header class="sobre-hero text-center">
        <div class="container position-relative" style="z-index: 2;">
            <h1 class="display-4 fw-bold mb-3 fade-in">Quem Somos</h1>
            <p class="lead fs-4 fade-in">Conheça a história do nosso portal de gastronomia</p>
        </div>
    </header>

    <!-- CONTEÚDO PRINCIPAL -->
    <div class="container mb-5">
        
        <!-- HISTÓRIA -->
        <div class="row align-items-center mb-5 fade-in">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="https://cdn.qwenlm.ai/output/90c8eae6-ee26-4a5e-ac4e-50b01f5aa262/image_gen/59773ded-6a96-420d-9f82-2f79bd03e672/1775508619.png?key=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJyZXNvdXJjZV91c2VyX2lkIjoiOTBjOGVhZTYtZWUyNi00YTVlLWFjNGUtNTBiMDFmNWFhMjYyIiwicmVzb3VyY2VfaWQiOiIxNzc1NTA4NjE5IiwicmVzb3VyY2VfY2hhdF9pZCI6IjUzMDhjMmRjLTQ4MWYtNGI2ZC1hNzA1LTczMjU1ODI5Mzk0ZCJ9.2Xxq77yjSZw_1Wbe5L1XzCU93f05UQ9BqEmN18SfwLM&x-oss-process=image/resize,m_mfit,w_450,h_450" 
                     alt="Nossa Cozinha" class="img-fluid equipe-img">
            </div>
            <div class="col-lg-6">
                <h2 class="mb-4" style="color: var(--primary);">Nossa História</h2>
                <p class="lead text-muted">O Portal Gastronomia nasceu da paixão pela culinária e do desejo de compartilhar receitas incríveis com o mundo.</p>
                <p class="text-muted" style="line-height: 1.8;">Desde 2020, nos dedicamos a trazer as melhores receitas, dicas culinárias e novidades do mundo gastronômico. Nossa missão é inspirar pessoas a explorarem novos sabores e desenvolverem suas habilidades na cozinha.</p>
                <p class="text-muted" style="line-height: 1.8;">Acreditamos que cozinhar é uma forma de arte e que cada prato conta uma história. Por isso, trabalhamos com uma equipe de chefs e entusiastas da culinária para trazer conteúdo de qualidade e acessível para todos.</p>
            </div>
        </div>

        <!-- VALORES -->
        <div class="row mb-5 fade-in">
            <div class="col-12 text-center mb-5">
                <h2 class="display-5 fw-bold section-title">Nossos Valores</h2>
                <p class="lead text-muted">O que nos move todos os dias</p>
            </div>
            <div class="col-md-4 mb-4">
                <div class="valores-card">
                    <i class="fas fa-heart"></i>
                    <h4>Paixão</h4>
                    <p class="text-muted">Amamos o que fazemos e isso se reflete em cada receita que compartilhamos.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="valores-card">
                    <i class="fas fa-users"></i>
                    <h4>Comunidade</h4>
                    <p class="text-muted">Valorizamos nossa comunidade de food lovers e estamos sempre ouvindo você.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="valores-card">
                    <i class="fas fa-award"></i>
                    <h4>Qualidade</h4>
                    <p class="text-muted">Compromisso com receitas testadas e conteúdo de alta qualidade.</p>
                </div>
            </div>
        </div>

        <!-- ESTATÍSTICAS -->
        <div class="row mb-5 fade-in">
            <div class="col-md-3 mb-4">
                <div class="stats-box">
                    <h3>500+</h3>
                    <p class="mb-0">Receitas</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stats-box">
                    <h3>10k+</h3>
                    <p class="mb-0">Usuários</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stats-box">
                    <h3>50+</h3>
                    <p class="mb-0">Colaboradores</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stats-box">
                    <h3>3+</h3>
                    <p class="mb-0">Anos de História</p>
                </div>
            </div>
        </div>

        <!-- CHAMADA PARA AÇÃO -->
        <div class="row align-items-center fade-in">
            <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                <img src="https://cdn.qwenlm.ai/output/90c8eae6-ee26-4a5e-ac4e-50b01f5aa262/image_gen/f53d5db4-e860-4047-89fe-5aeb2994cb16/1775508475.png?key=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJyZXNvdXJjZV91c2VyX2lkIjoiOTBjOGVhZTYtZWUyNi00YTVlLWFjNGUtNTBiMDFmNWFhMjYyIiwicmVzb3VyY2VfaWQiOiIxNzc1NTA4NDc1IiwicmVzb3VyY2VfY2hhdF9pZCI6IjUzMDhjMmRjLTQ4MWYtNGI2ZC1hNzA1LTczMjU1ODI5Mzk0ZCJ9.x___sb_6YlVlql2spDAMI8iayDYLc3iAHlcK1LEF1us&x-oss-process=image/resize,m_mfit,w_450,h_450" 
                     alt="Nossa Equipe" class="img-fluid equipe-img">
            </div>
            <div class="col-lg-6 order-lg-1">
                <h2 class="mb-4" style="color: var(--primary);">Junte-se a Nós!</h2>
                <p class="lead text-muted">Faça parte da nossa comunidade gastronômica</p>
                <p class="text-muted" style="line-height: 1.8;">Se você ama cozinhar e quer compartilhar suas receitas com milhares de pessoas, cadastre-se agora mesmo! Você poderá publicar suas criações, interagir com outros food lovers e fazer parte de uma comunidade apaixonada por gastronomia.</p>
                <div class="mt-4">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="dashboard.php" class="btn btn-custom btn-lg me-3">
                            <i class="fas fa-plus"></i> Publicar Receita
                        </a>
                    <?php else: ?>
                        <a href="cadastro.php" class="btn btn-custom btn-lg me-3">
                            <i class="fas fa-user-plus"></i> Criar Conta
                        </a>
                    <?php endif; ?>
                    <a href="contato.php" class="btn btn-outline-dark btn-lg">
                        <i class="fas fa-envelope"></i> Fale Conosco
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER IGUAL AO INDEX -->
    <footer class="text-white text-center py-4 mt-auto">
        <p class="mb-0">&copy; 2023 Portal Gastronomia. Todos os direitos reservados.</p>
    </footer>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animação de scroll - fade in ao aparecer na tela (IGUAL AO INDEX)
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