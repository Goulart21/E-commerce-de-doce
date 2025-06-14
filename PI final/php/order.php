<?php
session_start();

// Verificar se o carrinho não está vazio
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    header('Location: card.php');
    exit();
}

// Calcular total do carrinho
$totalCart = 0;
foreach ($_SESSION['cart'] as $product) {
    $totalCart += $product['price'];
}

// Formatar itens do carrinho para string
$itemsCart = implode(', ', array_map(function($item) {
    return $item['name'] . ' (R$ ' . number_format($item['price'], 2, ',', '.') . ')';
}, $_SESSION['cart']));
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

  <link rel="stylesheet" href="../css/order.css">

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
      <a href="login.php">Login</a>
      <a href="register.php">Registrar</a>
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
        <h2 class="mb-4">Finalizar Pedido</h2>
        <form  id="orderForm"  action="process_order.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="number" class="form-label">Número de Telefone</label>
                <input type="tel" class="form-control" id="number" name="number" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Endereço Completo</label>
                <textarea class="form-control" id="address" name="address" required></textarea>
            </div>
            <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf" required>
            </div>
            <div class="mb-3">
                <label for="payment" class="form-label">Forma de Pagamento</label>
                <select class="form-select" id="payment" name="payment" required>
                    <option value="">Selecione</option>
                    <option value="Pix">Pix</option>
                    <option value="Cartão de Crédito">Cartão de Crédito</option>
                    <option value="Cartão de Débito">Cartão de Débito</option>
                    <option value="Dinheiro">Dinheiro</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="coupon" class="form-label">Cupom (opcional)</label>
                <input type="text" class="form-control" id="coupon" name="coupon">
            </div>
            <input type="hidden" name="total" value="<?= $totalCart?>">
            <input type="hidden" name="items" value="<?= htmlspecialchars($itemsCart) ?>">
            <button type="submit" class="btn btn-success">Enviar Pedido</button>
        </form>
    </div>
    <script src="../js/order.js"></script>
</main>


<!-- Footer -->
<footer class="footer">
    <div class=" text-center">
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