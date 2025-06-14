<?php
// register.php
// Inicia a sessão
session_start();

// Inclui o arquivo de configuração do banco de dados
include 'config.php';

// Verifica se o método de requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Captura os dados do formulário
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $numero = $_POST['tel'];  // Captura o número do telefone com o nome correto
  $password = $_POST['password'];

  // Previne SQL Injection
  $nome = $conn->real_escape_string($nome);
  $email = $conn->real_escape_string($email);
  $numero = $conn->real_escape_string($numero);
  
  // Criptografa a senha
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Verifica se o usuário já existe
  $checkUserQuery = "SELECT * FROM users WHERE email = '$email' OR number = '$numero'";
  $checkUser = $conn->query($checkUserQuery);

  if ($checkUser->num_rows > 0) {
    // Se encontrar algum usuário com o mesmo email ou número
    echo "Usuário já cadastrado.";
  } else {
    // Insere o novo usuário no banco de dados
    $query = "INSERT INTO users (name, email, number, password) VALUES ('$nome', '$email', '$numero', '$hashedPassword')";
    if ($conn->query($query) === TRUE) {
      header("Location: login.php"); // Redireciona para a página de login
      exit;
    } else {
      // Se houver erro ao inserir no banco de dados
      echo "Erro ao cadastrar: " . $conn->error;
    }
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

  <link rel="stylesheet" href="../css/register.css">

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

  </header>

  <main>
    <section class="container mt-5">
      <h1 class="text-center mt-1">Cadastrar-se</h1>
      <form method="post">
        <div class="mb-3">
          <label for="nome" class="form-label">Nome</label>
          <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome Completo" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
        </div>
        <div class="mb-3">
          <label for="telefone" class="form-label">Telefone</label>
          <input type="tel" class="form-control" id="telefone" name="tel" placeholder="Telefone" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Senha</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
      </form>

      <div class="text-center mt-3">
        <p>Já tem uma conta? <a href="login.php" class="text-primary"><b>Faça login</b></a></p>
      </div>

    </section>
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
