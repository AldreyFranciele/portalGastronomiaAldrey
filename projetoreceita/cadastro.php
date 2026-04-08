<?php
require 'conexao.php';

$erro = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];
    
    if(empty($nome) || empty($email) || empty($senha)) {
        $erro = 'Preencha todos os campos.';
    } elseif($senha !== $confirmar_senha) {
        $erro = 'As senhas não coincidem.';
    } elseif(strlen($senha) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres.';
    } else {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, nivel) VALUES (?, ?, ?, 1)");
            $stmt->execute([$nome, $email, $senha_hash]);
            header("Location: login.php?msg=sucesso");
            exit;
        } catch(PDOException $e) { 
            $erro = 'Este email já está cadastrado.'; 
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Gastronomia</title>
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        h1, h2, h3, .navbar-brand {
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
        
        /* === CADASTRO SECTION - COM MAIS ESPAÇAMENTO === */
        .cadastro-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 20px 60px; /* MAIS ESPAÇO NO TOPO */
            background: linear-gradient(135deg, rgba(93, 64, 55, 0.05) 0%, rgba(141, 110, 99, 0.1) 100%);
        }
        .cadastro-card {
            background: var(--white);
            border-radius: 25px;
            box-shadow: 0 25px 80px rgba(62, 39, 35, 0.3);
            padding: 50px 45px;
            width: 100%;
            max-width: 500px;
            animation: slideUp 0.6s ease;
            border: 2px solid rgba(93, 64, 55, 0.1);
            margin-top: 20px; /* ESPAÇO EXTRA ACIMA DO CARD */
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .cadastro-logo {
            text-align: center;
            margin-bottom: 35px;
        }
        
        .cadastro-logo i {
            font-size: 3.5rem;
            color: var(--primary);
            margin-bottom: 15px;
            display: block;
        }
        
        .cadastro-logo h3 {
            font-family: 'Playfair Display', serif;
            color: var(--primary);
            font-weight: 700;
            margin: 0;
            font-size: 2rem;
        }
        
        .cadastro-logo p {
            color: var(--text-light);
            font-size: 0.95rem;
            margin: 8px 0 0;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 8px;
            font-size: 0.95rem;
        }
        
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 13px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fafafa;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(93, 64, 55, 0.1);
            background: var(--white);
        }
        
        .input-group-text {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px 0 0 12px;
            padding: 13px 15px;
        }
        
        .input-group .form-control {
            border-radius: 0 12px 12px 0;
            border-left: none;
        }
        
        .form-text {
            color: var(--text-light);
            font-size: 0.85rem;
            margin-top: 5px;
        }
        
        .btn-cadastro {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 14px;
            font-size: 1.05rem;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(93, 64, 55, 0.3);
        }
        
        .btn-cadastro:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(93, 64, 55, 0.4);
            color: white;
        }
        
        .alert-custom {
            background: linear-gradient(135deg, #ffebee, #ffcdd2);
            border: 1px solid #ef9a9a;
            border-radius: 12px;
            color: var(--primary-dark);
            font-weight: 500;
            margin-bottom: 25px;
            padding: 15px 20px;
        }
        
        .cadastro-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid #eee;
        }
        
        .cadastro-footer p {
            color: var(--text-light);
            margin-bottom: 8px;
        }
        
        .cadastro-footer a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }
        
        .cadastro-footer a:hover {
            color: var(--primary-dark);
            transform: translateX(5px);
        }
        
        .cadastro-footer a i {
            margin-right: 5px;
        }
        
        /* === FOOTER IGUAL AO INDEX === */
        footer {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transition: all 0.3s ease;
        }
        footer:hover {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        }
        
        /* === RESPONSIVE === */
        @media (max-width: 480px) {
            .cadastro-section {
                padding: 60px 15px 40px;
            }
            .cadastro-card {
                padding: 40px 30px;
                margin: 10px;
            }
            .cadastro-logo i {
                font-size: 2.5rem;
            }
            .cadastro-logo h3 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>

    <!-- === NAVBAR COMPLETA (IGUAL AO INDEX) === -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-utensils"></i> Gastronomia
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="quem-somos.php">Quem Somos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contato.php">Contato</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Entrar</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-custom ms-2" href="cadastro.php">Cadastre-se</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- === SEÇÃO DE CADASTRO (COM MAIS ESPAÇO DO TOPO) === -->
    <section class="cadastro-section">
        <div class="cadastro-card">
            <!-- Logo -->
            <div class="cadastro-logo">
                <i class="fas fa-user-plus"></i>
                <h3>Crie sua Conta</h3>
                <p>Junte-se à nossa comunidade gastronômica!</p>
            </div>
            
            <!-- Mensagens de Erro -->
            <?php if($erro): ?>
                <div class="alert-custom alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?= $erro ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <!-- Formulário -->
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-user me-1"></i>Nome Completo
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" 
                               name="nome" 
                               class="form-control" 
                               placeholder="Seu nome completo" 
                               value="<?= isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : '' ?>"
                               required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-envelope me-1"></i>Email
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" 
                               name="email" 
                               class="form-control" 
                               placeholder="seu@email.com" 
                               value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                               required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-lock me-1"></i>Senha
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" 
                               name="senha" 
                               class="form-control" 
                               placeholder="Mínimo 6 caracteres" 
                               required 
                               minlength="6">
                    </div>
                    <div class="form-text"><i class="fas fa-info-circle me-1"></i>Use pelo menos 6 caracteres</div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-lock me-1"></i>Confirmar Senha
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" 
                               name="confirmar_senha" 
                               class="form-control" 
                               placeholder="Repita a senha" 
                               required>
                    </div>
                </div>
                
                <button type="submit" class="btn-cadastro">
                    <i class="fas fa-user-plus me-2"></i>Criar Conta
                </button>
            </form>
            
            <!-- Footer do Card -->
            <div class="cadastro-footer">
                <p class="mb-2">Já tem uma conta?</p>
                <a href="login.php">
                    <i class="fas fa-sign-in-alt"></i>Fazer login
                </a>
                <p class="mt-3 mb-0" style="font-size: 0.85rem;">
                    <a href="index.php" style="font-size: 0.85rem;">
                        <i class="fas fa-home"></i>Voltar ao início
                    </a>
                </p>
            </div>
        </div>
    </section>

    <!-- === FOOTER === -->
    <footer class="text-white text-center py-4 mt-auto">
        <p class="mb-0">&copy; 2023 Portal Gastronomia. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>