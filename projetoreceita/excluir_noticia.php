<?php
require 'conexao.php';
require 'funcoes.php';
verificaLogin();

$id = $_GET['id'];
$isAdmin = isset($_SESSION['user_nivel']) && $_SESSION['user_nivel'] == 2;

if($isAdmin) {
    $stmt = $pdo->prepare("DELETE FROM noticias WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin.php");
} else {
    $stmt = $pdo->prepare("DELETE FROM noticias WHERE id = ? AND autor_id = ?");
    $stmt->execute([$id, $_SESSION['user_id']]);
    header("Location: dashboard.php");
}
?>