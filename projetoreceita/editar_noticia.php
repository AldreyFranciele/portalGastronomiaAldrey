<?php
require 'conexao.php';
require 'funcoes.php';
verificaLogin();

$id = $_GET['id'];
$isAdmin = isset($_SESSION['user_nivel']) && $_SESSION['user_nivel'] == 2;

if($isAdmin) {
    $stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = ?");
    $stmt->execute([$id]);
} else {
    $stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = ? AND autor_id = ?");
    $stmt->execute([$id, $_SESSION['user_id']]);
}

$n = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$n) die("Notícia não encontrada ou sem permissão.");

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($isAdmin) {
        $stmt = $pdo->prepare("UPDATE noticias SET titulo=?, noticia=?, imagem=? WHERE id=?");
        $stmt->execute([$_POST['titulo'], $_POST['conteudo'], $_POST['imagem'], $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE noticias SET titulo=?, noticia=?, imagem=? WHERE id=? AND autor_id=?");
        $stmt->execute([$_POST['titulo'], $_POST['conteudo'], $_POST['imagem'], $id, $_SESSION['user_id']]);
    }
    header("Location: " . ($isAdmin ? "admin.php" : "dashboard.php"));
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?= time() ?>">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4 mx-auto" style="max-width: 800px;">
            <h2 class="mb-4">Editar Publicação</h2>
            <form method="POST">
                <div class="mb-3">
                    <label>Título</label>
                    <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($n['titulo']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>URL da Imagem</label>
                    <input type="url" name="imagem" class="form-control" value="<?= htmlspecialchars($n['imagem']) ?>">
                </div>
                <div class="mb-3">
                    <label>Receita</label>
                    <textarea name="conteudo" class="form-control" rows="10" required><?= htmlspecialchars($n['noticia']) ?></textarea>
                </div>
                <button type="submit" class="btn btn-custom">Salvar Alterações</button>
                <a href="<?= $isAdmin ? 'admin.php' : 'dashboard.php' ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>