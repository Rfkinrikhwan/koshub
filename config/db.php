<?php
$host = 'odmwd.h.filess.io';
$port = "3307";
$db = 'koshub_liveairmad';
$user = 'koshub_liveairmad';
$pass = '967c8b55f82f8c6d438ed86f106e862c1087a517';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
