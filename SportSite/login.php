<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db = new SQLite3('my_database.db');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE name = :username");
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['name'];
        header("Location: index.php");
        exit();
    } else {
        // 🔴 Пренасочваме обратно с грешка
        header("Location: account.php?error=invalid");
        exit();
    }
}

$db->close();
?>
