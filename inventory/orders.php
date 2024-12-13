<?php
session_start();
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch orders grouped by status
$query = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[$row['status']][] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        header {
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        header h1 {
            margin: 0;
            font-size: 2rem;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .status-section {
            margin-bottom: 30px;
        }
        .status-header {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: #495057;
            border-bottom: 2px solid #6c757d;
            padding-bottom: 5px;
            display: flex;
            align-items: center;
        }
        .status-header i {
            margin-right: 10px;
            color: #6c757d;
        }
        .order {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background-color: #e9ecef;
        }
        .order-details {
            max-width: 70%;
        }
        .order-details p {
            margin: 5px 0;
            font-size: 0.9rem;
        }
        .order-details p strong {
            font-weight: bold;
        }
        .order-icon {
            font-size: 2.5rem;
            color: #6c757d;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #343a40;
            color: #fff;
        }
        @media (max-width: 600px) {
            .order {
                flex-direction: column;
                align-items: flex-start;
            }
            .order-icon {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>My Orders</h1>
    </header>
    <div class="container">
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $status => $orderList): ?>
                <div class="status-section">
                    <div class="status-header">
                        <i class="fas fa-tag"></i> <?= htmlspecialchars($status) ?>
                    </div>
                    <?php foreach ($orderList as $order): ?>
                        <div class="order">
                            <div class="order-details">
                                <p><strong>Order ID:</strong> <?= htmlspecialchars($order['id']) ?></p>
                                <p><strong>Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
                                <p><strong>Total:</strong> $<?= htmlspecialchars($order['total_amount']) ?></p>
                            </div>
                            <div class="order-icon">
                                <i class="fas fa-box"></i>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>
    <footer>
        &copy; <?= date("Y") ?> My E-Commerce Store. All Rights Reserved.
    </footer>
</body>
</html>