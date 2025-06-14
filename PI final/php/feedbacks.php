<?php
session_start();
include 'config.php';

// Check if user is logged in (optional)
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_nome'] : 'Usuário Anônimo';
$userID = $isLoggedIn ? $_SESSION['user_id'] : null;

// Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name'] ?: $userName);
    $rating = intval($_POST['rating']);
    $comment = $conn->real_escape_string($_POST['comment']);

    // Insert feedback (allow anonymous submission)
    $insertQuery = "INSERT INTO feedbacks (user_id, name, rating, comment)
                    VALUES (NULL, '$name', '$rating', '$comment')";
    $conn->query($insertQuery);
   
    header("Location: feedbacks.php");
    exit;
}

// Fetch all feedbacks
$feedbacksQuery = "SELECT * FROM feedbacks ORDER BY created_at DESC";
$feedbacksResult = $conn->query($feedbacksQuery);
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

  <link rel="stylesheet" href="../css/feedbacks.css">

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

    <main class="container mt-5">
        <h1 class="text-center mb-4">Feedbacks dos Clientes</h1>

        <!-- Feedbacks Display Section -->
        <section id="existing-feedbacks">
            <?php if ($feedbacksResult->num_rows > 0): ?>
                <?php while($feedback = $feedbacksResult->fetch_assoc()): ?>
                    <div class="feedback-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><?= htmlspecialchars($feedback['name']) ?></h5>
                            <div>
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <span class="star <?= $i <= $feedback['rating'] ? 'text-warning' : '' ?>">★</span>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <p><?= htmlspecialchars($feedback['comment']) ?></p>
                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($feedback['created_at'])) ?></small>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">Ainda não há feedbacks. Seja o primeiro a avaliar!</p>
            <?php endif; ?>
        </section>

        <!-- Feedback Submission Section -->
        <section id="submit-feedback" class="mt-5">
            <h2 class="text-center">Faça sua Avaliação</h2>
            <form method="post" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label">Seu Nome (opcional)</label>
                    <input type="text" class="form-control" id="name" name="name"
                           placeholder="<?= $isLoggedIn ? $userName : 'Anônimo' ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Sua Avaliação</label>
                    <div class="star-rating">
                        <?php for($i = 5; $i >= 1; $i--): ?>
                            <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" required>
                            <label for="star<?= $i ?>" class="star">★</label>
                        <?php endfor; ?>
                    </div>
                </div>
               
                <div class="mb-3">
                    <label for="comment" class="form-label">Comentário</label>
                    <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                </div>
               
                <button type="submit" class="btn btn-primary w-100">Enviar Feedback</button>
            </form>
        </section>
        <script>
        // Star rating interaction
        document.querySelectorAll('.star-rating input').forEach(input => {
            input.addEventListener('change', function() {
                document.querySelectorAll('.star-rating label').forEach(label => {
                    label.classList.toggle('active',
                        parseInt(label.getAttribute('for').replace('star', '')) <= parseInt(this.value)
                    );
                });
            });
        });
    </script>
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