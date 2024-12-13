<?php
session_start();
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user ID from session
$user_id = $_SESSION['user_id'];

// Get product quantities from the form submission
$quantities = $_POST['quantity'];

$total_amount = 0; // Initialize total amount
$order_items = []; // Initialize order items array

// Calculate the total amount and prepare order items
foreach ($quantities as $product_id => $quantity) {
    if ($quantity > 0) { // Process only if quantity is greater than 0
        // Fetch the product price
        $query = "SELECT price FROM products WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();

        $price = $product['price'];
        $total_amount += $price * $quantity; // Update total amount
        $order_items[] = [
            'product_id' => $product_id,
            'quantity' => $quantity,
            'price' => $price
        ];
    }
}

// Insert order into the `orders` table
$query = "INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'Pending')";
$stmt = $conn->prepare($query);
$stmt->bind_param("id", $user_id, $total_amount);
$stmt->execute();
$order_id = $stmt->insert_id; // Get the generated order ID
$stmt->close();

// Insert each item into the `order_items` table
$query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
foreach ($order_items as $item) {
    $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
    $stmt->execute();
}
$stmt->close();
$conn->close();

// Redirect the user to the orders page
header("Location: orders.php");
exit();
?>
