<?php
// config/database.php
$host = 'localhost';
$dbname = 'portafolio_db';  // Cambia por tu nombre de BD
$username = 'root';
$password = '';
$puerto = '3308';

try {
    $pdo = new PDO("mysql:host=$host;port=$puerto;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // ELIMINA ESTA LÍNEA: echo "✅ Conexión exitosa";
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>