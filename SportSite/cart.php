<?php
session_start();

if (isset($_GET['clear']) || isset($_POST['clear'])) {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .cart-container {
      max-width: 800px;
      margin: 40px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    th, td {
      padding: 12px 16px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #5a3afa;
      color: #fff;
    }
    .total {
      font-weight: bold;
      text-align: right;
      font-size: 18px;
      margin-top: 10px;
    }
    .btn-red, .btn-checkout, .btn-back {
      border: none;
      padding: 12px 25px;
      border-radius: 25px;
      cursor: pointer;
      font-size: 16px;
      margin: 10px 5px;
    }
    .btn-red {
      background-color: crimson;
      color: white;
    }
    .btn-checkout {
      background-color: #28a745;
      color: white;
    }
    .btn-back {
      background-color: #555;
      color: white;
      text-decoration: none;
      display: inline-block;
      line-height: 40px;
    }
    .actions {
      text-align: center;
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="cart-container">
      <h1>🛒 Your Cart</h1>

      <?php if (!empty($_SESSION['cart'])): ?>
        <table>
          <thead>
            <tr>
              <th>Product</th>
              <th>Price ($)</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $total = 0;
              foreach ($_SESSION['cart'] as $item):
                if (!is_array($item) || !isset($item['name']) || !isset($item['price'])) continue;

                $name = htmlspecialchars($item['name']);
                $price = floatval($item['price']);
                $total += $price;
            ?>
              <tr>
                <td><?= $name ?></td>
                <td>$<?= number_format($price, 2) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <?php
          $delivery = 5.00;
          $grand_total = $total + $delivery;
        ?>

        <p class="total">Subtotal: $<?= number_format($total, 2) ?></p>
        <p class="total">Delivery: $<?= number_format($delivery, 2) ?></p>
        <p class="total">Total: <strong>$<?= number_format($grand_total, 2) ?></strong></p>

        <div class="actions">
          <form method="POST" style="display:inline;">
            <button type="submit" name="clear" class="btn-red">🗑 Clear Cart</button>
          </form>
          <button class="btn-checkout">✅ Complete Order</button>
          <a href="products.html" class="btn-back">⬅ Back to Products</a>
        </div>

      <?php else: ?>
        <p>Your cart is empty.</p>
        <div class="actions">
          <a href="products.html" class="btn-back">⬅ Back to Products</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
