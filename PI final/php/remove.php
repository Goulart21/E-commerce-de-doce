<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['index'])) {
    $index = $_POST['index'];

    // Remove o item específico do carrinho
    if (isset($_SESSION['cart'][$index])) {
        // Armazena o preço original antes de remover
        $priceOriginal = $_SESSION['cart'][$index]['price_original'] ?? $_SESSION['cart'][$index]['price'];
        
        unset($_SESSION['cart'][$index]);
        
        // Reindexar o array para evitar problemas
        $_SESSION['cart'] = array_values($_SESSION['cart']);

        // Se o número de itens cair abaixo de 18, restaurar preços originais
        if (count($_SESSION['cart']) < 18) {
            foreach ($_SESSION['cart'] as &$item) {
                // Restaurar preço original
                $item['price'] = $item['price_original'] ?? $item['price'];
                unset($item['price_original']);
            }
        }
    }

    // Redireciona de volta para o carrinho
    header('Location: cart.php');
    exit;
}
?>