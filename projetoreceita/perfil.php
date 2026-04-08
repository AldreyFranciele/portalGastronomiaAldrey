<?php
require 'conexao.php';
require 'funcoes.php';
verificaLogin();

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$user_id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

$mensagem = '';
$tipo_mensagem = '';

// === ATUALIZAR DADOS PESSOAIS ===
if(isset($_POST['atualizar_dados'])) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    
    try {
        $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
        $stmt->execute([$nome, $email, $user_id]);
        $_SESSION['user_nome'] = $nome;
        $mensagem = '✅ Dados atualizados com sucesso!';
        $tipo_mensagem = 'success';
        $usuario['nome'] = $nome;
        $usuario['email'] = $email;
    } catch(PDOException $e) {
        $mensagem = '❌ Erro: Este email já está em uso.';
        $tipo_mensagem = 'danger';
    }
}

// === ALTERAR SENHA ===
if(isset($_POST['atualizar_senha'])) {
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];
    
    if(!password_verify($senha_atual, $usuario['senha'])) {
        $mensagem = '❌ Senha atual incorreta.';
        $tipo_mensagem = 'danger';
    } elseif($nova_senha !== $confirmar_senha) {
        $mensagem = '❌ As novas senhas não coincidem.';
        $tipo_mensagem = 'warning';
    } elseif(strlen($nova_senha) < 6) {
        $mensagem = '❌ A senha deve ter pelo menos 6 caracteres.';
        $tipo_mensagem = 'warning';
    } else {
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
        $stmt->execute([$senha_hash, $user_id]);
        $mensagem = '✅ Senha alterada com sucesso!';
        $tipo_mensagem = 'success';
    }
}

// === EXCLUIR CONTA (apenas usuários comuns) ===
if(isset($_POST['excluir_conta'])) {
    $senha_confirm = $_POST['senha_confirm_excluir'];
    
    if(password_verify($senha_confirm, $usuario['senha'])) {
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$user_id]);
        session_destroy();
        header("Location: index.php?msg=conta_excluida");
        exit;
    } else {
        $mensagem = '❌ Senha incorreta. Conta não excluída.';
        $tipo_mensagem = 'danger';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - Gastronomia</title>
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
        
        /* === PERFIL HEADER === */
        .perfil-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            padding: 100px 0;
            margin-bottom: 60px;
            border-radius: 0 0 50px 50px;
            position: relative;
            overflow: hidden;
        }
        .perfil-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(240, 236, 236, 0.1) 0%, transparent 70%);
            animation: pulse 15s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        
        /* === PERFIL CARD === */
        .perfil-card {
            border: none;
            border-radius: 25px;
            box-shadow: 0 15px 50px rgba(228, 224, 223, 0.15);
            overflow: hidden;
            background: white;
            transition: all 0.3s ease;
        }
        .perfil-card:hover {
            box-shadow: 0 20px 60px rgba(255, 253, 253, 0.25);
            transform: translateY(-5px);
        }
        
        /* === AVATAR DO USUÁRIO === */
        .user-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 3rem;
            font-weight: bold;
            color: white;
            box-shadow: 0 10px 30px rgba(93, 64, 55, 0.3);
            border: 5px solid white;
            transition: transform 0.3s ease;
        }
        .user-avatar:hover {
            transform: scale(1.1);
        }
        
        /* === INFO ITEMS === */
        .info-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-item:hover {
            background: #fafafa;
            padding-left: 10px;
        }
        .info-item i {
            width: 35px;
            color: var(--primary);
            font-size: 1.2rem;
        }
        
        /* === ADMIN BADGE === */
        .admin-badge {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(248, 246, 246, 0.3);
        }
        
        /* === NAV PILLS === */
        .nav-pills .nav-link {
            color: var(--text);
            border-radius: 50px;
            padding: 12px 25px;
            margin-bottom: 10px;
            margin-right: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .nav-pills .nav-link:hover {
            background: rgba(93, 64, 55, 0.05);
            border-color: var(--primary-light);
        }
        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(93, 64, 55, 0.3);
        }
        .nav-pills .nav-link i {
            margin-right: 8px;
            width: 20px;
        }
        
        /* === TAB CONTENT === */
        .tab-content {
            padding: 30px;
            background: #fafafa;
            border-radius: 20px;
            margin-top: 20px;
        }
        
        /* === FORMULÁRIO === */
        .form-label {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 8px;
        }
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 13px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(93, 64, 55, 0.1);
        }
        
        /* === BOTÕES === */
        .btn-custom {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 14px 35px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(93, 64, 55, 0.3);
        }
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(93, 64, 55, 0.4);
            color: white;
        }
        
        /* === DANGER ZONE === */
        .danger-zone {
            border: 2px solid #dc3545;
            border-radius: 20px;
            padding: 30px;
            background: linear-gradient(135deg, #fff5f5, #ffe5e5);
            transition: all 0.3s ease;
        }
        .danger-zone:hover {
            box-shadow: 0 10px 30px rgba(220, 53, 69, 0.2);
        }
        
        /* === ALERTS === */
        .alert {
            border-radius: 15px;
            border: none;
            padding: 15px 20px;
            font-weight: 500;
            margin-bottom: 25px;
        }
        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
        }
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
        }
        .alert-warning {
            background: linear-gradient(135deg, #fff3cd, #ffe69c);
            color: #856404;
        }
        
        /* === FOOTER === */
        footer {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transition: all 0.3s ease;
            margin-top: auto;
        }
        footer:hover {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
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
        
        /* === RESPONSIVE === */
        @media (max-width: 768px) {
            .perfil-header {
                padding: 80px 0;
                border-radius: 0 0 30px 30px;
            }
            .nav-pills .nav-link {
                margin-right: 5px;
                padding: 10px 15px;
                font-size: 0.9rem;
            }
            .user-avatar {
                width: 100px;
                height: 100px;
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>

    <!-- === NAVBAR === -->
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
                    <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="quem-somos.php">Quem Somos</a></li>
                    <li class="nav-item"><a class="nav-link" href="contato.php">Contato</a></li>
                    <li class="nav-item"><a class="nav-link active" href="perfil.php">Meu Perfil</a></li>
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Minhas Publicações</a></li>
                    <li class="nav-item"><a class="btn btn-outline-danger ms-2" href="logout.php">Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- === HEADER === -->
    <header class="perfil-header text-center">
        <div class="container position-relative" style="z-index: 2;">
            <h1 class="display-5 fw-bold mb-2 fade-in">Meu Perfil</h1>
            <p class="lead opacity-90 fade-in">Gerencie suas informações e preferências</p>
        </div>
    </header>

    <!-- === CONTEÚDO PRINCIPAL === -->
    <div class="container mb-5">
        <?php if($mensagem): ?>
            <div class="alert alert-<?= $tipo_mensagem ?> alert-dismissible fade show fade-in visible" role="alert">
                <?= $mensagem ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- === COLUNA ESQUERDA: INFO DO USUÁRIO === -->
            <div class="col-lg-4 mb-4">
                <div class="card perfil-card text-center p-4 fade-in">
                    <!-- Avatar -->
                    <div class="user-avatar">
                        <?= strtoupper(substr($usuario['nome'], 0, 1)) ?>
                    </div>
                    
                    <h4 class="mt-3 fw-bold" style="color: var(--primary);"><?= htmlspecialchars($usuario['nome']) ?></h4>
                    <p class="text-muted mb-3"><?= htmlspecialchars($usuario['email']) ?></p>
                    
                    <span class="admin-badge mb-4">
                        <?= $usuario['nivel'] == 2 ? '👑 Administrador' : '👤 Usuário' ?>
                    </span>
                    
                    <div class="info-item">
                        <i class="far fa-calendar-alt"></i>
                        <span class="text-muted">Membro desde</span>
                        <span class="ms-auto fw-bold"><?= date('d/m/Y', strtotime($usuario['criado_em'])) ?></span>
                    </div>
                    
                    <?php
                    $stmt_stats = $pdo->prepare("SELECT COUNT(*) as total FROM noticias WHERE autor_id = ?");
                    $stmt_stats->execute([$user_id]);
                    $total_publicacoes = $stmt_stats->fetch(PDO::FETCH_ASSOC)['total'];
                    ?>
                    <div class="info-item">
                        <i class="fas fa-newspaper"></i>
                        <span class="text-muted">Publicações</span>
                        <span class="ms-auto fw-bold"><?= $total_publicacoes ?></span>
                    </div>
                </div>
            </div>

            <!-- === COLUNA DIREITA: ABAS DE EDIÇÃO === -->
            <div class="col-lg-8">
                <div class="card perfil-card p-4 fade-in">
                    <!-- Navegação das Abas -->
                    <ul class="nav nav-pills mb-4" id="perfilTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="dados-tab" data-bs-toggle="pill" data-bs-target="#dados" type="button">
                                <i class="fas fa-user-edit"></i> Dados Pessoais
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="senha-tab" data-bs-toggle="pill" data-bs-target="#senha" type="button">
                                <i class="fas fa-key"></i> Segurança
                            </button>
                        </li>
                        <?php if($usuario['nivel'] != 2): ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-danger" id="excluir-tab" data-bs-toggle="pill" data-bs-target="#excluir" type="button">
                                <i class="fas fa-trash-alt"></i> Excluir Conta
                            </button>
                        </li>
                        <?php endif; ?>
                    </ul>

                    <!-- Conteúdo das Abas -->
                    <div class="tab-content" id="perfilTabContent">
                        
                        <!-- ABA 1: DADOS PESSOAIS -->
                        <div class="tab-pane fade show active" id="dados" role="tabpanel">
                            <h5 class="mb-4 fw-bold" style="color: var(--primary);">
                                <i class="fas fa-user-edit me-2"></i>Editar Informações
                            </h5>
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-user me-2"></i>Nome Completo
                                    </label>
                                    <input type="text" 
                                           name="nome" 
                                           class="form-control form-control-lg" 
                                           value="<?= htmlspecialchars($usuario['nome']) ?>" 
                                           required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-envelope me-2"></i>Email
                                    </label>
                                    <input type="email" 
                                           name="email" 
                                           class="form-control form-control-lg" 
                                           value="<?= htmlspecialchars($usuario['email']) ?>" 
                                           required>
                                </div>
                                <button type="submit" name="atualizar_dados" class="btn btn-custom">
                                    <i class="fas fa-save me-2"></i>Salvar Alterações
                                </button>
                            </form>
                        </div>

                        <!-- ABA 2: SEGURANÇA/SENHA -->
                        <div class="tab-pane fade" id="senha" role="tabpanel">
                            <h5 class="mb-4 fw-bold" style="color: var(--primary);">
                                <i class="fas fa-key me-2"></i>Alterar Senha
                            </h5>
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-lock me-2"></i>Senha Atual
                                    </label>
                                    <input type="password" 
                                           name="senha_atual" 
                                           class="form-control form-control-lg" 
                                           required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-key me-2"></i>Nova Senha
                                    </label>
                                    <input type="password" 
                                           name="nova_senha" 
                                           class="form-control form-control-lg" 
                                           placeholder="Mínimo 6 caracteres" 
                                           required 
                                           minlength="6">
                                    <div class="form-text"><i class="fas fa-info-circle me-1"></i>Use pelo menos 6 caracteres</div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-lock me-2"></i>Confirmar Nova Senha
                                    </label>
                                    <input type="password" 
                                           name="confirmar_senha" 
                                           class="form-control form-control-lg" 
                                           required>
                                </div>
                                <button type="submit" name="atualizar_senha" class="btn btn-custom">
                                    <i class="fas fa-key me-2"></i>Alterar Senha
                                </button>
                            </form>
                        </div>

                        <!-- ABA 3: EXCLUIR CONTA (apenas usuários comuns) -->
                        <?php if($usuario['nivel'] != 2): ?>
                        <div class="tab-pane fade" id="excluir" role="tabpanel">
                            <div class="danger-zone">
                                <h5 class="mb-3 fw-bold text-danger">
                                    <i class="fas fa-exclamation-triangle me-2"></i>⚠️ Zona de Perigo
                                </h5>
                                <p class="text-muted mb-4">
                                    Esta ação é irreversível. Todos os seus dados e publicações serão excluídos permanentemente.
                                </p>
                                
                                <form method="POST" onsubmit="return confirm('⚠️ TEM CERTEZA? Esta ação não pode ser desfeita.');">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-lock me-2"></i>Digite sua senha para confirmar
                                        </label>
                                        <input type="password" 
                                               name="senha_confirm_excluir" 
                                               class="form-control form-control-lg" 
                                               required>
                                    </div>
                                    <button type="submit" name="excluir_conta" class="btn btn-danger btn-lg">
                                        <i class="fas fa-trash-alt me-2"></i>Excluir Minha Conta Permanentemente
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- === FOOTER === -->
    <footer class="text-white text-center py-4 mt-auto">
        <p class="mb-0">&copy; 2023 Portal Gastronomia. Todos os direitos reservados.</p>
    </footer>

    <!-- === SCRIPTS === -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animação de scroll - fade in ao aparecer na tela
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