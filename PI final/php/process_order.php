<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $number = $_POST['number']; 
    $address = $_POST['address'];
    $cpf = $_POST['cpf'];
    $payment = $_POST['payment'];
    $coupon = $_POST['coupon'] ?? '';
    $items = $_POST['items'];
    
    // Prepare the SQL statement
    $sql = "INSERT INTO orders (name, number, address, cpf, dateIssuance, payment, coupon, items) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?)";
    
    // Create prepared statement
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("sssssss", $name, $number, $address, $cpf, $payment, $coupon, $items);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Return success response
            echo json_encode(['status' => 'success', 'orderId' => $conn->insert_id]);
            $_SESSION['cart'] = [];
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $stmt->error]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Prepare statement failed: ' . $conn->error]);
    }
    
    exit();
}
?>