<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dbFile = 'my_database.db';
$db = new SQLite3($dbFile);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $passwordInput = $_POST['password'];

    if (empty($username) || empty($email) || empty($passwordInput)) {
        header("Location: account.php?register=error");
        exit();
    }

    $password = password_hash($passwordInput, PASSWORD_DEFAULT);

    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($result->fetchArray()) {
        // Имейл вече съществува
        header("Location: account.php?register=error");
        exit();
    } else {
        $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->bindValue(':name', $username, SQLITE3_TEXT);
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);
        $stmt->bindValue(':password', $password, SQLITE3_TEXT);

        if ($stmt->execute()) {
            $db->close();
            header("Location: account.php?register=success");
            exit();
        } else {
            header("Location: account.php?register=error");
            exit();
        }
    }
}

$db->close();
?>
