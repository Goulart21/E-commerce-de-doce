<?php
session_start(); // Inicia a sessão

// Verifica se o carrinho existe na sessão, caso contrário, cria um carrinho vazio
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Conta o número de produtos no carrinho
$counter = count($_SESSION['cart']);

// Retorna o contador como um JSON
echo json_encode(['counter' => $counter]);
?>