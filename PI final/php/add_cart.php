<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] !== true) {
    // Redireciona para página de login se não estiver logado
    echo"Você precisa estar logado para adicionar produtos ao carrinho";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product = json_decode(file_get_contents('php://input'), true);

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Verifica se já atingiu 18 itens
    $totalItems = count($_SESSION['cart']);

    // Se já tiver 18 ou mais itens, ajusta o preço
    if ($totalItems >= 17) {
        // Armazena o preço original se ainda não tiver sido armazenado
        $product['price_original'] = $product['price'];
        $product['price'] = 18.50;
    }

    // Adiciona o novo produto
    $_SESSION['cart'][] = $product;

    // Se atingir 18 itens, ajusta preços de todos os itens anteriores
    if (count($_SESSION['cart']) >= 18) {
        foreach ($_SESSION['cart'] as &$item) {
            // Armazena o preço original se ainda não tiver sido armazenado
            if (!isset($item['price_original'])) {
                $item['price_original'] = $item['price'];
            }
            $item['price'] = 18.50;
        }
    }

    echo json_encode(['status' => 'success', 'total_items' => count($_SESSION['cart'])]);
    exit;
}
?> 