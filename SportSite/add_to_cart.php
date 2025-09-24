<?php
session_start();

// Проверка дали формата е изпратена чрез POST и има данни
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['product'], $_POST['price'])) {
    $product = htmlspecialchars($_POST['product']); // за защита от XSS
    $price = floatval($_POST['price']); // преобразуваме в число

    // Създаваме количката ако я няма
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Добавяме продукта като асоциативен масив (име и цена)
    $_SESSION['cart'][] = [
        'name' => $product,
        'price' => $price
    ];
}

// Пренасочване обратно към страницата с количката
header("Location: cart.php");
exit();
?>
