<?php
require 'conexao.php';
require 'funcoes.php';

$mensagem_enviada = false;
$erro = false;
$erro_mensagem = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $assunto = trim($_POST['assunto']);
    $mensagem = trim($_POST['mensagem']);
    
    // Validação
    if(empty($nome) || empty($email) || empty($assunto) || empty($mensagem)) {
        $erro = true;
        $erro_mensagem = 'Por favor, preencha todos os campos.';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = true;
        $erro_mensagem = 'Por favor, digite um email válido.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO contatos (nome, email, assunto, mensagem) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nome, $email, $assunto, $mensagem]);
            $mensagem_enviada = true;
            
            // Limpar POST
            $_POST = array();
        } catch(PDOException $e) { 
            $erro = true;
            $erro_mensagem = 'Erro ao enviar: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - Gastronomia</title>
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
            --text-light: #795548;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--background);
            color: var(--text);
        }
        
        h1, h2, h3, .navbar-brand {
            font-family: 'Playfair Display', serif;
        }
        
        .navbar {
            background: var(--white);
            box-shadow: 0 4px 20px rgba(93, 64, 55, 0.1);
        }
        .navbar-brand { color: var(--primary) !important; }
        .nav-link { color: var(--text) !important; }
        .nav-link:hover, .nav-link.active { color: var(--primary) !important; }
        
        .contato-hero {
            background: linear-gradient(135deg, rgba(62, 39, 35, 0.9) 0%, rgba(93, 64, 55, 0.8) 100%);
            color: white;
            padding: 100px 0;
            margin-bottom: 60px;
            border-radius: 0 0 50px 50px;
        }
        
        .info-box {
            background: white;
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(93, 64, 55, 0.1);
            transition: transform 0.3s;
            height: 100%;
        }
        .info-box:hover { transform: translateY(-5px); }
        .info-box i {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
        }
        .info-box h5 {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .card-contato {
            border: none;
            border-radius: 25px;
            box-shadow: 0 15px 50px rgba(93, 64, 55, 0.15);
            background: white;
        }
        .card-contato .card-body { padding: 50px 40px; }
        
        .form-label {
            font-weight: 600;
            color: var(--primary);
        }
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 12px 15px;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(93, 64, 55, 0.1);
        }
        
        .btn-custom {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 14px 40px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(93, 64, 55, 0.4);
            color: white;
        }
        
        footer {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
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
                    <li class="nav-item"><a class="nav-link active" href="contato.php">Contato</a></li>
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

    <header class="contato-hero text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Entre em Contato</h1>
            <p class="lead">Estamos aqui para ouvir você!</p>
        </div>
    </header>

    <div class="container mb-5">
        <div class="row mb-5">
            <div class="col-md-4 mb-4">
                <div class="info-box">
                    <i class="fas fa-map-marker-alt"></i>
                    <h5>Endereço</h5>
                    <p class="text-muted mb-0">Rua da Gastronomia, 123<br>São Paulo, SP</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="info-box">
                    <i class="fas fa-envelope"></i>
                    <h5>Email</h5>
                    <p class="text-muted mb-0">contato@gastronomia.com</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="info-box">
                    <i class="fas fa-phone"></i>
                    <h5>Telefone</h5>
                    <p class="text-muted mb-0">(11) 99999-9999</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card card-contato">
                    <div class="card-body">
                        <h3 class="text-center mb-4" style="color: var(--primary);">
                            <i class="fas fa-paper-plane me-2"></i>Envie sua Mensagem
                        </h3>
                        
                        <?php if($mensagem_enviada): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Mensagem enviada com sucesso!</strong><br>
                                Entraremos em contato em breve.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($erro): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <strong>Erro ao enviar mensagem!</strong><br>
                                <?= htmlspecialchars($erro_mensagem) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><i class="fas fa-user me-2"></i>Nome</label>
                                    <input type="text" name="nome" class="form-control" 
                                           value="<?= isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : '' ?>"
                                           placeholder="Seu nome completo" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><i class="fas fa-envelope me-2"></i>Email</label>
                                    <input type="email" name="email" class="form-control" 
                                           value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                                           placeholder="seu@email.com" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-tag me-2"></i>Assunto</label>
                                <input type="text" name="assunto" class="form-control" 
                                       value="<?= isset($_POST['assunto']) ? htmlspecialchars($_POST['assunto']) : '' ?>"
                                       placeholder="Qual o assunto da mensagem?" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-comment-alt me-2"></i>Mensagem</label>
                                <textarea name="mensagem" class="form-control" rows="6" 
                                          placeholder="Escreva sua mensagem..." required><?= isset($_POST['mensagem']) ? htmlspecialchars($_POST['mensagem']) : '' ?></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-custom w-100">
                                <i class="fas fa-paper-plane me-2"></i>Enviar Mensagem
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-white text-center py-4">
        <p class="mb-0">&copy; 2023 Portal Gastronomia. Todos os direitos reservados.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>