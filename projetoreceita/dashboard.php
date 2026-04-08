<?php
require 'conexao.php';
require 'funcoes.php';
verificaLogin();

$stmt = $pdo->prepare("SELECT * FROM noticias WHERE autor_id = ? ORDER BY data_publicacao DESC");
$stmt->execute([$_SESSION['user_id']]);
$minhas = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_receitas = count($minhas);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Publicações - Gastronomia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=<?= time() ?>">
    <style>
        :root { --primary: #5D4037; --primary-dark: #3E2723; --primary-light: #8D6E63; }
        .dashboard-header { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; padding: 80px 0 100px; margin-bottom: 40px; }
        .dashboard-card { border: none; border-radius: 20px; box-shadow: 0 10px 40px rgba(93,64,55,0.1); overflow: hidden; }
        .stat-box { background: white; padding: 25px; border-radius: 15px; text-align: center; box-shadow: 0 5px 20px rgba(93,64,55,0.08); transition: transform 0.3s; }
        .stat-box:hover { transform: translateY(-5px); }
        .stat-box i { font-size: 2.5rem; color: var(--primary); margin-bottom: 15px; }
        .btn-custom { background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; border-radius: 50px; padding: 10px 30px; font-weight: 600; transition: all 0.3s; }
        .btn-custom:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(93,64,55,0.3); color: white; }
        .empty-state { text-align: center; padding: 60px 20px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top" style="background:white; box-shadow:0 4px 20px rgba(93,64,55,0.1);">
        <div class="container">
            <a class="navbar-brand" href="index.php" style="color:var(--primary)!important;">
                <i class="fas fa-utensils"></i> Gastronomia
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="quem-somos.php">Quem Somos</a></li>
                    <li class="nav-item"><a class="nav-link" href="contato.php">Contato</a></li>
                    <li class="nav-item"><a class="nav-link" href="perfil.php">Meu Perfil</a></li>
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php">Minhas Publicações</a></li>
                    <li class="nav-item"><a class="btn btn-outline-danger ms-2" href="logout.php">Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="dashboard-header text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-2">📰 Minhas Publicações</h1>
            <p class="lead opacity-90">Gerencie suas receitas e notícias</p>
        </div>
    </header>

    <div class="container mb-5">
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="stat-box">
                    <i class="fas fa-newspaper"></i>
                    <h3><?= $total_receitas ?></h3>
                    <p class="text-muted mb-0">Publicações</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stat-box">
                    <i class="fas fa-user"></i>
                    <h3><?= htmlspecialchars($_SESSION['user_nome']) ?></h3>
                    <p class="text-muted mb-0">Seu Perfil</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stat-box">
                    <i class="fas fa-calendar-alt"></i>
                    <h3><?= date('d/m/Y') ?></h3>
                    <p class="text-muted mb-0">Data de Hoje</p>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold">📋 Receitas e Notícias</h4>
            <a href="nova_noticia.php" class="btn btn-custom">
                <i class="fas fa-plus"></i> Nova Publicação
            </a>
        </div>

        <?php if($total_receitas > 0): ?>
            <div class="card dashboard-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:50px;">#</th>
                                    <th style="width:80px;">Imagem</th>
                                    <th>Título</th>
                                    <th style="width:150px;">Data</th>
                                    <th style="width:200px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($minhas as $n): ?>
                                <tr>
                                    <td><strong><?= $n['id'] ?></strong></td>
                                    <td>
                                        <?php if($n['imagem']): ?>
                                            <img src="<?= htmlspecialchars($n['imagem']) ?>" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                                        <?php else: ?>
                                            <div style="width:60px;height:60px;background:#f0f0f0;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                                <i class="fas fa-newspaper text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($n['titulo']) ?></strong>
                                        <br><small class="text-muted"><?= strlen($n['noticia']) > 50 ? substr($n['noticia'], 0, 50).'...' : $n['noticia'] ?></small>
                                    </td>
                                    <td><i class="far fa-calendar-alt text-muted"></i> <?= date('d/m/Y', strtotime($n['data_publicacao'])) ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="noticia.php?id=<?= $n['id'] ?>" class="btn btn-sm btn-outline-primary" target="_blank" title="Ver"><i class="fas fa-eye"></i></a>
                                            <a href="editar_noticia.php?id=<?= $n['id'] ?>" class="btn btn-sm btn-outline-warning" title="Editar"><i class="fas fa-edit"></i></a>
                                            <a href="excluir_noticia.php?id=<?= $n['id'] ?>" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Excluir?');"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="card dashboard-card">
                <div class="card-body empty-state">
                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                    <h4 class="mb-3">Você ainda não publicou nada</h4>
                    <p class="text-muted mb-4">Comece compartilhando receitas ou notícias!</p>
                    <a href="nova_noticia.php" class="btn btn-custom btn-lg">
                        <i class="fas fa-plus"></i> Primeira Publicação
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <p class="mb-0">&copy; 2023 Portal Gastronomia. Todos os direitos reservados.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>