<?php
session_start();

function verificaLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}

function formatarData($data) {
    $timestamp = strtotime($data);
    return date('d/m/Y', $timestamp) . ' às ' . date('H:i', $timestamp);
}

function resumoTexto($texto, $limite = 150) {
    return strlen($texto) > $limite ? substr($texto, 0, $limite) . "..." : $texto;
}
function getFotoPerfil($foto_db, $nome, $tamanho = 150) {
    if($foto_db && file_exists($foto_db)) {
        return htmlspecialchars($foto_db);
    }
    $inicial = strtoupper(substr($nome, 0, 1));
    return 'https://via.placeholder.com/' . $tamanho . '/667eea/ffffff?text=' . urlencode($inicial);
}
?>