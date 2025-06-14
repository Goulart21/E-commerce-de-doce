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

  <link rel="stylesheet" href="../css/index.css">

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
            
                <li><a href="./php/logout.php">Fazer Logout</a></li>
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

  <div class="container text-center">
    <h1 style="margin-top: 50px; font-size: 60px;" id="title">Bão d’oce</h1>
    <p id="title" style="font-size: 20px;">Varejo de doces de pote</p>
    <div class="main-buttons " style="margin-top: 50px;">
      <a href="card.php">Catálogo</a>
      <a href="/descontos.html">Descontos</a>
      <a href="reuse.php">Reutilize</a>
      <a href="feedbacks.php">Feedbacks</a>
    </div>
  </div>
    
</main>


<div class="discount-overlay" id="discountOverlay"></div>
<div class="discount-popup" id="discountPopup">
  <h2>Oferta Especial!</h2>
  <p>Na compra de 18 unidades ou mais, aproveite um desconto especial em todos os nossos doces!</p>
 
  <div class="price-container">
    <div class="original-price">R$ 23,00</div>
    <div class="new-price">R$ 18,50</div>
  </div>
 
  <button class="close-popup" onclick="closeDiscountPopup()">Fechar</button>
</div>

<script>
document.querySelector('a[href="/descontos.html"]').addEventListener('click', function(e) {
  e.preventDefault();
  document.getElementById('discountOverlay').style.display = 'block';
  document.getElementById('discountPopup').style.display = 'block';
});

function closeDiscountPopup() {
  document.getElementById('discountOverlay').style.display = 'none';
  document.getElementById('discountPopup').style.display = 'none';
}

document.getElementById('discountOverlay').addEventListener('click', closeDiscountPopup);
</script>

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