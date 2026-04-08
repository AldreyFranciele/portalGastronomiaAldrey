<?php
require 'conexao.php';
require 'funcoes.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT n.*, u.nome as autor_nome FROM noticias n JOIN usuarios u ON n.autor_id = u.id WHERE n.id = ?");
$stmt->execute([$id]);
$noticia = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$noticia) {
    die("<div class='container mt-5'><div class='alert alert-danger text-center'><h4>❌ Publicação não encontrada!</h4><p>A receita ou notícia que você está procurando não existe ou foi removida.</p><a href='index.php' class='btn btn-primary'>Voltar ao início</a></div></div>");
}

$pode_editar = false;
if(isset($_SESSION['user_id'])) {
    if($_SESSION['user_id'] == $noticia['autor_id'] || (isset($_SESSION['user_nivel']) && $_SESSION['user_nivel'] == 2)) {
        $pode_editar = true;
    }
}

// Detecta se é receita ou notícia baseado no tamanho do conteúdo
$eh_receita = strlen($noticia['noticia']) < 500;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($noticia['titulo']) ?> - Gastronomia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=<?= time() ?>">
    <style>
        :root { --primary: #5D4037; --primary-dark: #3E2723; --primary-light: #8D6E63; --background: #F5F5F5; --white: #FFFFFF; --text: #3E2723; --text-light: #795548; }
        body { font-family: 'Poppins', sans-serif; background: var(--background); color: var(--text); min-height: 100vh; display: flex; flex-direction: column; }
        h1, h2, h3, .navbar-brand { font-family: 'Playfair Display', serif; }
        .navbar { background: var(--white); box-shadow: 0 4px 20px rgba(93, 64, 55, 0.1); }
        .navbar-brand { color: var(--primary) !important; }
        .nav-link { color: var(--text) !important; }
        .nav-link:hover, .nav-link.active { color: var(--primary) !important; }
        .noticia-header { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; padding: 80px 0; margin-bottom: 50px; border-radius: 0 0 50px 50px; }
        .noticia-conteudo { background: white; border-radius: 25px; padding: 50px 40px; box-shadow: 0 15px 50px rgba(93, 64, 55, 0.15); margin-bottom: 30px; transition: box-shadow 0.3s; }
        .noticia-conteudo:hover { box-shadow: 0 20px 60px rgba(93, 64, 55, 0.25); }
        .noticia-imagem { border-radius: 20px; overflow: hidden; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(93, 64, 55, 0.15); }
        .noticia-imagem img { width: 100%; max-height: 500px; object-fit: cover; transition: transform 0.4s ease; }
        .noticia-imagem:hover img { transform: scale(1.05); }
        .autor-box { background: #f8f9fa; padding: 25px; border-radius: 20px; margin-bottom: 30px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; transition: transform 0.3s; }
        .autor-box:hover { transform: translateX(5px); }
        .autor-info { display: flex; align-items: center; gap: 15px; }
        .autor-avatar { width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-light)); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.5rem; }
        .btn-voltar { background: white; color: var(--primary); border: 2px solid var(--primary); border-radius: 50px; padding: 10px 30px; font-weight: 600; transition: all 0.3s; }
        .btn-voltar:hover { background: var(--primary); color: white; transform: translateY(-2px); }
        .conteudo-texto { font-size: 1.15rem; line-height: 1.9; color: var(--text); }
        .conteudo-texto p { margin-bottom: 25px; }
        .badge-tipo { background: var(--primary); color: white; padding: 8px 20px; border-radius: 50px; font-weight: 600; font-size: 0.9rem; }
        footer { background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%); }
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

    <header class="noticia-header text-center">
        <div class="container">
            <a href="javascript:history.back()" class="btn btn-voltar mb-4">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
            <span class="badge-tipo mb-3">
                <?= $eh_receita ? '🍳 Receita' : '📰 Notícia' ?>
            </span>
            <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($noticia['titulo']) ?></h1>
            <p class="lead opacity-90">
                <i class="far fa-calendar-alt me-2"></i>Publicado em <?= date('d/m/Y', strtotime($noticia['data_publicacao'])) ?> 
                às <?= date('H:i', strtotime($noticia['data_publicacao'])) ?>
            </p>
        </div>
    </header>

    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <?php if($noticia['imagem']): ?>
                    <div class="noticia-imagem">
                        <img src="<?= htmlspecialchars($noticia['imagem']) ?>" alt="<?= htmlspecialchars($noticia['titulo']) ?>">
                    </div>
                <?php endif; ?>

                <div class="autor-box">
                    <div class="autor-info">
                        <div class="autor-avatar"><?= strtoupper(substr($noticia['autor_nome'], 0, 1)) ?></div>
                        <div>
                            <h6 class="mb-0 fw-bold">Publicado por</h6>
                            <p class="mb-0 text-muted"><?= htmlspecialchars($noticia['autor_nome']) ?></p>
                        </div>
                    </div>
                    <div class="text-muted">
                        <i class="far fa-clock me-1"></i><?= formatarData($noticia['data_publicacao']) ?>
                    </div>
                </div>

                <div class="noticia-conteudo">
                    <div class="conteudo-texto">
                        <?= nl2br(htmlspecialchars($noticia['noticia'])) ?>
                    </div>
                </div>

                <?php if($pode_editar): ?>
                    <div class="text-center mb-4">
                        <a href="editar_noticia.php?id=<?= $noticia['id'] ?>" class="btn btn-warning btn-lg me-3">
                            <i class="fas fa-edit me-2"></i>Editar
                        </a>
                        <a href="excluir_noticia.php?id=<?= $noticia['id'] ?>" class="btn btn-danger btn-lg" 
                           onclick="return confirm('⚠️ Tem certeza que deseja EXCLUIR esta publicação?\n\nEsta ação não pode ser desfeita.');">
                            <i class="fas fa-trash me-2"></i>Excluir
                        </a>
                    </div>
                <?php endif; ?>

                <div class="text-center mt-5">
                    <a href="index.php" class="btn btn-custom btn-lg">
                        <i class="fas fa-home me-2"></i>Voltar ao Início
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-white text-center py-4 mt-auto">
        <p class="mb-0">&copy; 2023 Portal Gastronomia. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>