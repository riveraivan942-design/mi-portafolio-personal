<?php
session_start();
require_once 'config/database.php';

// Verificar que sea método POST
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contacto.php');
    exit();
}

// Obtener y limpiar datos
$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');

// Validaciones del servidor
$errores = [];

if(empty($nombre)) {
    $errores[] = "El nombre es obligatorio";
} elseif(strlen($nombre) < 3) {
    $errores[] = "El nombre debe tener al menos 3 caracteres";
} elseif(strlen($nombre) > 100) {
    $errores[] = "El nombre no puede exceder 100 caracteres";
}

if(empty($correo)) {
    $errores[] = "El correo es obligatorio";
} elseif(!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El correo no es válido";
}

if(empty($mensaje)) {
    $errores[] = "El mensaje es obligatorio";
} elseif(strlen($mensaje) < 10) {
    $errores[] = "El mensaje debe tener al menos 10 caracteres";
} elseif(strlen($mensaje) > 500) {
    $errores[] = "El mensaje no puede exceder 500 caracteres";
}

// Si hay errores, mostrar mensaje
if(!empty($errores)) {
    $_SESSION['mensaje'] = implode(", ", $errores);
    $_SESSION['tipo'] = "danger";
    header('Location: contacto.php');
    exit();
}

try {
    // Guardar en base de datos
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    
    $sql = "INSERT INTO mensajes_contacto (nombre, correo, mensaje, ip_usuario) 
            VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $correo, $mensaje, $ip]);
    
    // Enviar correo de notificación (opcional)
    $to = "ana.garcia@example.com"; // Tu correo
    $subject = "Nuevo mensaje de contacto - " . $nombre;
    $body = "Nombre: $nombre\n";
    $body .= "Correo: $correo\n";
    $body .= "Mensaje:\n$mensaje\n";
    $headers = "From: $correo";
    
    // Descomentar para enviar correo
    // mail($to, $subject, $body, $headers);
    
    $_SESSION['mensaje'] = "¡Mensaje enviado con éxito! Te responderé pronto.";
    $_SESSION['tipo'] = "success";
    
} catch(PDOException $e) {
    $_SESSION['mensaje'] = "Error al enviar el mensaje. Por favor intenta nuevamente.";
    $_SESSION['tipo'] = "danger";
}

header('Location: contacto.php');
exit();
?>