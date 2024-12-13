<?php
session_start();
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch available products
$query = "SELECT * FROM products";
$result = $conn->query($query);
$products = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .product img {
            width: 150px; /* Set width to 150px */
            height: 150px; /* Set height to 150px */
            object-fit: cover;
            border-radius: 8px;
        }
        .product input {
            width: 60px;
            text-align: center;
        }
        #total {
            font-size: 1.5em;
            margin-top: 20px;
            text-align: right;
            color: #333;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function updateTotal() {
            let total = 0;
            const quantities = document.querySelectorAll('.quantity');
            const prices = document.querySelectorAll('.price');
            quantities.forEach((quantity, index) => {
                total += quantity.value * prices[index].dataset.price;
            });
            document.getElementById('total').innerText = `Total: $${total.toFixed(2)}`;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Place Your Order</h1>
        <form action="submit_order.php" method="POST">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 150px; height: 150px;">
                        </td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td>
                            <input type="number" name="quantity[<?= $product['id'] ?>]" class="quantity" value="0" min="0" onchange="updateTotal()" />
                        </td>
                        <td>$<?= htmlspecialchars($product['price']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div id="total">Total: $0.00</div>
            <button type="submit">Place Order</button>
        </form>
    </div>
</body>
</html>
