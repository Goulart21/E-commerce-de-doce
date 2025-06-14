<?php
// login.php
// Inicia a sessão
session_start();

// Inclui o arquivo de configuração do banco de dados
include 'config.php';

// Verifica se o método de requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Captura os dados do formulário
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Previne SQL Injection
  $email = $conn->real_escape_string($email);

  // Verifica se o login é para o usuário administrador específico
  if ($email === 'leo@gmail.com' && $password === 'baooceadmin') {
    // Se for o admin, cria a sessão e redireciona para admin.php
    $_SESSION['user_email'] = $email;
    $_SESSION['is_admin'] = true; // Marcamos que é um admin
    header("Location: leo.php");
    exit;
  }

  // Verifica se o usuário existe no banco de dados
  $query = "SELECT * FROM users WHERE email = '$email'";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    // Se o usuário for encontrado, pega os dados
    $user = $result->fetch_assoc();

    // Verifica se a senha está correta
    if (password_verify($password, $user['password'])) {
      // Se a senha for correta, cria a sessão
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_nome'] = $user['nome'];
      $_SESSION['user_email'] = $user['email'];
      $_SESSION['is_admin'] = false; // Marcamos que não é admin
      $_SESSION['logged_in'] = true;


      // Redireciona o usuário para catalog.php
      header("Location: card.php");
      exit;
    } else {
      // Se a senha estiver errada
      $error = "Senha incorreta.";
    }
  } else {
    // Se o usuário não for encontrado
    $error = "E-mail não encontrado.";
  }
}

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

  <link rel="stylesheet" href="../css/login.css">

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
  </header>

  <main>
    <section class="container mt-5">
      <h1 class="text-center mt-1">Login</h1>

      <!-- Formulário de Login -->
      <form method="post">
        <?php if (isset($error)): ?>
          <div class="alert alert-danger" role="alert">
            <?= $error ?>
          </div>
        <?php endif; ?>
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Senha</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
      </form>

      <div class="text-center mt-3">
        <p>Ainda não tem uma conta? <a href="register.php" class="text-primary"><b>Cadastre-se</b></a></p>
      </div>

    </section>


  </main>

<!-- Footer -->
<footer class="footer">
    <div class="container-f text-center">
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