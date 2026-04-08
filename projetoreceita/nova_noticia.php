<?php
require 'conexao.php';
require 'funcoes.php';
verificaLogin();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = trim($_POST['titulo']);
    $conteudo = trim($_POST['conteudo']);
    $imagem = trim($_POST['imagem']);
    $autor = $_SESSION['user_id'];
    
    if(!empty($titulo) && !empty($conteudo)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO noticias (titulo, noticia, imagem, autor_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$titulo, $conteudo, $imagem, $autor]);
            header("Location: dashboard.php?msg=publicado");
            exit;
        } catch(PDOException $e) {
            $erro = 'Erro ao publicar: ' . $e->getMessage();
        }
    } else {
        $erro = 'Preencha todos os campos obrigatórios.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Publicação - Gastronomia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=<?= time() ?>">
    <style>
        :root { --primary: #5D4037; --primary-dark: #3E2723; --primary-light: #8D6E63; --background: #F5F5F5; --white: #FFFFFF; --text: #3E2723; }
        body { font-family: 'Poppins', sans-serif; background: var(--background); color: var(--text); min-height: 100vh; display: flex; flex-direction: column; }
        h1, h2, h3, .navbar-brand { font-family: 'Playfair Display', serif; }
        .navbar { background: var(--white); box-shadow: 0 4px 20px rgba(93, 64, 55, 0.1); }
        .navbar-brand { color: var(--primary) !important; }
        .nav-link { color: var(--text) !important; }
        .nav-link:hover, .nav-link.active { color: var(--primary) !important; }
        .nova-header { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; padding: 80px 0; margin-bottom: 50px; border-radius: 0 0 50px 50px; }
        .nova-card { border: none; border-radius: 25px; box-shadow: 0 15px 50px rgba(93, 64, 55, 0.15); background: white; padding: 50px 40px; }
        .form-label { font-weight: 600; color: var(--primary); margin-bottom: 8px; }
        .form-control { border: 2px solid #e0e0e0; border-radius: 12px; padding: 14px 18px; font-size: 1rem; transition: all 0.3s ease; background: #fafafa; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(93, 64, 55, 0.1); background: white; }
        textarea.form-control { resize: vertical; min-height: 200px; }
        .form-text { color: var(--text); font-size: 0.85rem; margin-top: 5px; }
        .btn-custom { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; border: none; border-radius: 50px; padding: 14px 40px; font-weight: 600; transition: all 0.3s; box-shadow: 0 4px 20px rgba(93, 64, 55, 0.3); }
        .btn-custom:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(93, 64, 55, 0.4); color: white; }
        .btn-secondary-custom { background: #6c757d; color: white; border: none; border-radius: 50px; padding: 14px 40px; font-weight: 600; transition: all 0.3s; }
        .btn-secondary-custom:hover { background: #5a6268; color: white; transform: translateY(-2px); }
        .alert-custom { border-radius: 15px; border: none; padding: 20px 25px; font-weight: 500; margin-bottom: 30px; }
        footer { background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%); }
        .preview-img { max-width: 300px; max-height: 200px; border-radius: 10px; object-fit: cover; margin-top: 10px; display: none; }
        .preview-img.show { display: block; }
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
                    <li class="nav-item"><a class="nav-link" href="perfil.php">Meu Perfil</a></li>
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Minhas Publicações</a></li>
                    <li class="nav-item"><a class="btn btn-outline-danger ms-2" href="logout.php">Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="nova-header text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-2">📰 Publicar Receita ou Notícia</h1>
            <p class="lead opacity-90">Compartilhe suas criações e novidades com nossa comunidade</p>
        </div>
    </header>

    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="nova-card">
                    <?php if(isset($erro)): ?>
                        <div class="alert alert-danger alert-custom">
                            <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($erro) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-heading me-2"></i>Título da Publicação
                            </label>
                            <input type="text" name="titulo" class="form-control form-control-lg" 
                                   placeholder="Ex: Bolo de Chocolate Fácil ou Nova Tendência Gastronômica" 
                                   required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-image me-2"></i>URL da Imagem
                            </label>
                            <input type="url" name="imagem" class="form-control form-control-lg" 
                                   id="imagemInput"
                                   placeholder="https://exemplo.com/imagem.jpg"
                                   onchange="previewImagem()">
                            <div class="form-text"><i class="fas fa-info-circle me-1"></i>Cole o link de uma imagem da internet</div>
                            <img src="" alt="Preview" id="previewImagem" class="preview-img">
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-file-alt me-2"></i>Conteúdo (Receita ou Notícia)
                            </label>
                            <textarea name="conteudo" class="form-control form-control-lg" rows="12" 
                                      placeholder="Descreva a receita com ingredientes e modo de preparo, ou escreva sua notícia gastronômica..." 
                                      required></textarea>
                            <div class="form-text"><i class="fas fa-info-circle me-1"></i>Para receitas: liste ingredientes e passo a passo. Para notícias: escreva o conteúdo completo.</div>
                        </div>
                        
                        <div class="d-flex gap-3 flex-wrap">
                            <button type="submit" class="btn btn-custom btn-lg">
                                <i class="fas fa-save me-2"></i>Publicar
                            </button>
                            <a href="dashboard.php" class="btn btn-secondary-custom btn-lg">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-white text-center py-4 mt-auto">
        <p class="mb-0">&copy; 2023 Portal Gastronomia. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImagem() {
            const input = document.getElementById('imagemInput');
            const preview = document.getElementById('previewImagem');
            if(input.value) {
                preview.src = input.value;
                preview.classList.add('show');
                preview.onerror = function() { this.classList.remove('show'); };
            } else {
                preview.classList.remove('show');
            }
        }
    </script>
</body>
</html>