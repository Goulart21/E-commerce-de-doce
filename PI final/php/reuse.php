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

  <link rel="stylesheet" href="../css/reuse.css">

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
      <a href="index.php">Home</a>
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

  

</head>
<body>
    <div class="reuse-container">
        <h1 class="reuse-title">Dê uma Nova Vida ao Seu Potinho!</h1>
       
        <div class="reuse-card">
            <h3>Por que Reutilizar?</h3>
            <p>Ao reutilizar nossos potes de vidro, você contribui diretamente para a redução do impacto ambiental. O vidro pode ser reutilizado infinitas vezes, mantendo sua qualidade e durabilidade.</p>
        </div>

        <div class="reuse-card">
            <h3>Ideias Criativas de Reutilização</h3>
            <ul class="tip-list">
                <li>Organize temperos e grãos na cozinha</li>
                <li>Crie um mini jardim suculento</li>
                <li>Armazene material de escritório</li>
                <li>Monte um terrário decorativo</li>
                <li>Faça um porta-velas artesanal</li>
                <li>Guarde produtos de banheiro</li>
            </ul>
        </div>

        <div class="reuse-card">
            <h3>Como Preparar seu Pote</h3>
            <ul class="tip-list">
                <li>Lave bem com água morna e sabão neutro</li>
                <li>Retire completamente o rótulo</li>
                <li>Seque totalmente antes de reutilizar</li>
                <li>Esterilize com água fervente se for usar para alimentos</li>
            </ul>
        </div>

        <div class="eco-message">
            "Cada pequeno gesto de reutilização faz uma grande diferença para nosso planeta 🌍"
        </div>

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
