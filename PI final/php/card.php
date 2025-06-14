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

  <link rel="stylesheet" href="../css/card.css">
  <script src="../js/main.js" defer></script>
</head>

<body>
  <!-- Header -->
  <header>
    <div class="header">
      <div class="container-fluid">
        <div class="row align-items-center">
          <!-- Logo -->
            <div class="col-3 col-md-2">
            <a class="header-brand d-flex justify-content-start" href="index.php">
            <img src="../img/BAO (1).png" alt="Logo" class="img-fluid"  />
            </a>
          </div>

          <!-- Search Bar -->
          <div class="col-12 col-md-8 d-flex justify-content-center my-3 my-md-0">
            <div class="search-container w-100">
              <form class="search-bar" onsubmit="event.preventDefault();">
                <input type="text" class="search-input form-control" id="search" placeholder="Busque seu doce favorito...">
                <i class="bi bi-search search-bar-icon "></i>
              </form>
            </div>
          </div>

          <!-- Icons -->
          <div class="col-9 col-md-2 d-flex justify-content-end align-items-center">
            <div class="header-icons d-flex align-items-center">
              <a class="text-light me-3 position-relative" href="cart.php">
                <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
                <i class="bi bi-cart3 "></i>
              </a>
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
      <a href="index.php">Home</a>
      <a href="feedbacks.php">Feedbacks</a>
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
    <div class="main">
      <h1 class="h1"><b>Produtos</b></h1>
      <div class="products-container">
        <?php
        $products = include 'products.php';
        if (is_array($products)) {
          foreach ($products as $product) {
            echo '<div class="product-card">';
            echo '<img src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '">';
            echo '<span>' . '<b> R$' . number_format($product['price'], 2, ',', '.') . '</b><br>' . '</span>';
            echo '<span>' . htmlspecialchars($product['name']) . '</span>';
            echo '<button id="comprar" onclick="addProduct(\'' . htmlspecialchars($product['name']) . '\', ' . $product['price'] . ', \'' . htmlspecialchars($product['image']) . '\')">Adicionar ao carrinho</button>';
            echo '</div>';
          }
        } else {
          echo "<p>Erro: Não foi possível carregar os produtos.</p>";
        }
        ?>
      </div>
    </div>

    <button id="scrollToTopBtn" class="scroll-btn"><i class="bi bi-caret-up-fill"></i></button>
    <script> // Scroll to top button
    const scrollToTopBtn = document.getElementById('scrollToTopBtn');
    window.onscroll = function() {
      if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        scrollToTopBtn.style.display = 'block';
      } else {
        scrollToTopBtn.style.display = 'none';
      }
    };

    scrollToTopBtn.addEventListener('click', function() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });</script>



  </main>

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