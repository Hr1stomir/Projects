<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Път към SQLite база данни
$dbFile = 'my_database.db';
$db = new SQLite3($dbFile);

// Създаване на таблицата
$query = "CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL
)";
$db->exec($query);

echo "Базата данни и таблицата са създадени успешно!";
$db->close();
?>
