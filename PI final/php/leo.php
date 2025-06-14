<?php
session_start();
include 'config.php'; // Ensure database connection

// Check if user is admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    echo "Acesso negado.";
    exit;
}

// Load existing products
$products = include 'products.php';

// Handle product addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $newProduct = [
        'name' => $_POST['name'],
        'price' => floatval($_POST['price']),
        'image' => $_POST['image'],
        'description' => $_POST['description']
    ];

    // Add the new product to the array
    $products[] = $newProduct;

    // Save the updated products array
    file_put_contents('products.php', '<?php

return ' . var_export($products, true) . ';

?>');
}

// Handle product deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $productToDelete = $_POST['product_name'];
    
    // Remove the product from the array
    $products = array_filter($products, function($product) use ($productToDelete) {
        return $product['name'] !== $productToDelete;
    });

    // Save the updated products array
    file_put_contents('products.php', '<?php

return ' . var_export($products, true) . ';

?>');
}

// Fetch orders
$ordersQuery = "SELECT * FROM orders ORDER BY orderID DESC";
$ordersResult = $conn->query($ordersQuery);
$orders = [];
if ($ordersResult) {
    while ($order = $ordersResult->fetch_assoc()) {
        $orders[] = $order;
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

  <link rel="stylesheet" href="../css/leo.css">

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
        <script src="../js/modal.js"></script>
  </header>

<body>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-6">
                <!-- Adicionar Produto -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Adicionar Novo Produto
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="add">
                            <div class="form-group">
                                <label>Nome do Produto</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>Preço</label>
                                <input type="number" step="0.01" class="form-control" name="price" required>
                            </div>
                            <div class="form-group">
                                <label>Caminho da Imagem</label>
                                <input type="text" class="form-control" name="image" required>
                            </div>
                            <div class="form-group">
                                <label>Descrição</label>
                                <textarea class="form-control" name="description" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Adicionar Produto</button>
                        </form>
                    </div>
                </div>

                <!-- Remover Produto -->
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        Remover Produto
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="delete">
                            <div class="form-group">
                                <label>Selecione o Produto para Remover</label>
                                <select class="form-control" name="product_name" required>
                                    <?php foreach ($products as $product): ?>
                                        <option value="<?= htmlspecialchars($product['name']) ?>">
                                            <?= htmlspecialchars($product['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-danger">Remover Produto</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Lista de Pedidos -->
                <div class="card">
                    <div class="card-header bg-info text-white">
                        Pedidos Realizados
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID Pedido</th>
                                        <th>Nome</th>
                                        <th>Número</th>
                                        <th>Endereço</th>
                                        <th>Data</th>
                                        <th>Pagamento</th>
                                        <th>Itens</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($orders)): ?>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($order['orderID']) ?></td>
                                                <td><?= htmlspecialchars($order['name']) ?></td>
                                                <td><?= htmlspecialchars($order['number']) ?></td>
                                                <td><?= htmlspecialchars($order['address']) ?></td>
                                                <td><?= date('d/m/Y', strtotime($order['dateIssuance'])) ?></td>
                                                <td><?= htmlspecialchars($order['payment']) ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary" data-toggle="modal" 
                                                            data-target="#orderItemsModal<?= $order['orderID'] ?>">
                                                        Ver Itens
                                                    </button>
                                                </td>
                                            </tr>
                                            
                                            <!-- Modal for Order Items -->
                                            <div class="modal fade" id="orderItemsModal<?= $order['orderID'] ?>" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Itens do Pedido #<?= $order['orderID'] ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <pre><?= htmlspecialchars($order['items']) ?></pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Nenhum pedido encontrado.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
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