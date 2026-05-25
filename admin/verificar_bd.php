<?php
require_once '../config/database.php';

echo "<h2>Diagnóstico de Base de Datos</h2>";

// Verificar si la tabla existe
try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'administradores'");
    if($stmt->rowCount() > 0) {
        echo "<p style='color:green'>✅ Tabla 'administradores' existe</p>";
        
        // Mostrar administradores
        $stmt = $pdo->query("SELECT id, usuario, password, email FROM administradores");
        $admins = $stmt->fetchAll();
        
        echo "<h3>Administradores registrados:</h3>";
        if(count($admins) > 0) {
            echo "<ul>";
            foreach($admins as $admin) {
                echo "<li>ID: {$admin['id']} - Usuario: {$admin['usuario']} - Email: {$admin['email']}</li>";
            }
            echo "</ul>";
        } else {
            echo "<p style='color:red'>❌ No hay administradores registrados</p>";
        }
    } else {
        echo "<p style='color:red'>❌ Tabla 'administradores' NO existe</p>";
        echo "<p>Ejecuta este SQL:</p>";
        echo "<pre>
CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO administradores (usuario, password, email) 
VALUES ('admin', '" . password_hash('admin123', PASSWORD_DEFAULT) . "', 'admin@example.com');
        </pre>";
    }
} catch(PDOException $e) {
    echo "<p style='color:red'>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<br><a href='login.php' class='btn btn-primary'>Volver al Login</a>";
?>