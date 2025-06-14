<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Verifica se o número de itens é 18 ou mais
if (count($_SESSION['cart']) >= 18) {
    foreach ($_SESSION['cart'] as &$product) {
        // Armazena o preço original se ainda não tiver sido armazenado
        if (!isset($product['price_original'])) {
            $product['price_original'] = $product['price'];
        }
        $product['price'] = 18.50;
    }
} elseif (count($_SESSION['cart']) < 18) {
    // Restaura os preços originais
    foreach ($_SESSION['cart'] as &$product) {
        if (isset($product['price_original'])) {
            $product['price'] = $product['price_original'];
            unset($product['price_original']);
        }
    }
}

$cart = $_SESSION['cart'];
$totalCart = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Catálogo | Bão D'oce</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

  <link rel="stylesheet" href="../css/cart.css">

</head>

<body>
  <!-- Header -->
  <header>
    <div class="header">
      <div class="container-fluid">
        <div class="row align-items-center">
          <!-- Logo -->
          <div class="col-3 col-md-2">
            <a class="header-brand d-flex justify-content-start" href="index.html">
            <img src="../img/BAO (1).png" alt="Logo" class="img-fluid"  />
            </a>
          </div>

          <!-- Icons -->
          <div class="col-12 col-md-10 d-flex justify-content-end align-items-center">
            <div class="header-icons d-flex align-items-center">
              <div class="accessibility-icon me-3" onclick="toggleAccessibilityMenu()">
                <i class="bi bi-universal-access-circle "></i>
              </div>
              <div class="profile-icon" onclick="toggleProfileMenu()">
                <i class="bi bi-person-circle "></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Links -->
    <nav class="links">
      <a href="index.html">Home</a>
      <a href="card.php">Catálogo</a>
     
    </nav>

    <!-- Menu de Perfil -->
    <div class="profile-menu" id="profileMenu">
            <ul>
                <li><a href="logout.php">Fazer Logout</a></li>
            </ul>
        </div>
  </header>
<!-- Overlay para o modal de acessibilidade -->
<div id="accessibilityModalOverlay" class="accessibility-modal-overlay"></div>

<!-- Accessibility Modal -->
<div id="accessibilityModal" class="accessibility-modal">
    <h4>Menu de Acessibilidade</h4>
    <div class="accessibility-options">
        <button id="toggle-dark-mode">Modo Escuro</button>
        <button id="toggle-contrast">Alto Contraste</button>
        <button id="increase-font">Aumentar Texto</button>
        <button id="decrease-font">Diminuir Texto</button>
        <button id="read-text">Leitor de Texto</button>
        <button id="reset-accessibility">Resetar Configurações</button>
    </div>
    <button onclick="accessibilityManager.toggleAccessibilityMenu()">Fechar</button>
    <script src="../js/modal.js"></script>
</div>

<main>    
  <div class="container">
        <h1 class="my-4">Carrinho de Compras</h1>

        <div id="products-cart">
            <?php if (count($cart) > 0): ?>
                <ul id="list-cart">
                    <?php
                    // Exibe os produtos do carrinho
                    foreach ($cart as $index => $product):
                        $totalCart += $product['price'];
                    ?>
                        <li>
                            <div style="display: flex; align-items: center;">
                                <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                                <div>
                                    <strong><?= $product['name'] ?></strong><br>
                                    <span>R$ <?= number_format($product['price'], 2, ',', '.') ?></span>
                                </div>
                            </div>
                            <form action="remove.php" method="post" style="display: inline-block;">
                                <input type="hidden" name="index" value="<?= $index ?>">
                                <button type="submit" class="btn-remover">Remover</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p id="total-cart">Total: R$ <?= number_format($totalCart, 2, ',', '.') ?></p>
                <a href="card.php" class="btn btn-primary mt-3">Voltar ao Catálogo</a>
                <a href="order.php" class="btn btn-success mt-3">Finalizar Compra</a>
            <?php else: ?>
                <p>Seu carrinho está vazio!</p>
            <?php endif; ?>
        </div>

    </div></main>


<!-- Footer -->
<footer class="footer">
    <div class="container text-center">
      <div class="social-icons">
        <a href="" target="_blank" class="social-icon">
          <i class="bi bi-whatsapp"></i>
        </a>
        <a href="" target="_blank" class="social-icon">
          <i class="bi bi-facebook"></i>
        </a>
      </div>
      <p id="copy">&copy; 2024 Bão D’oce. Todos os direitos reservados.</p>
    </div>
  </footer>

</body>

</html>