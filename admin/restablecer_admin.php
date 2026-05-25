<?php
session_start();
require_once '../config/database.php';

$mensaje = '';
$tipo = '';

// Procesar el formulario
if($_POST) {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $confirmar = trim($_POST['confirmar']);
    
    if(empty($usuario) || empty($password)) {
        $mensaje = "Todos los campos son obligatorios";
        $tipo = "danger";
    } elseif(strlen($password) < 6) {
        $mensaje = "La contraseña debe tener al menos 6 caracteres";
        $tipo = "danger";
    } elseif($password !== $confirmar) {
        $mensaje = "Las contraseñas no coinciden";
        $tipo = "danger";
    } else {
        // Verificar si ya existe el usuario
        $stmt = $pdo->prepare("SELECT id FROM administradores WHERE usuario = ?");
        $stmt->execute([$usuario]);
        
        if($stmt->rowCount() > 0) {
            // Actualizar contraseña existente
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE administradores SET password = ? WHERE usuario = ?");
            if($update->execute([$hash, $usuario])) {
                $mensaje = "✅ Contraseña actualizada correctamente para el usuario: $usuario";
                $tipo = "success";
            } else {
                $mensaje = "❌ Error al actualizar";
                $tipo = "danger";
            }
        } else {
            // Crear nuevo administrador
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare("INSERT INTO administradores (usuario, password, email) VALUES (?, ?, ?)");
            if($insert->execute([$usuario, $hash, $_POST['email'] ?? "$usuario@example.com"])) {
                $mensaje = "✅ Administrador creado exitosamente. Usuario: $usuario";
                $tipo = "success";
            } else {
                $mensaje = "❌ Error al crear administrador";
                $tipo = "danger";
            }
        }
    }
}

// Listar administradores existentes
$administradores = [];
try {
    $stmt = $pdo->query("SELECT id, usuario, email, fecha_creacion FROM administradores");
    $administradores = $stmt->fetchAll();
} catch(PDOException $e) {
    $administradores = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-key"></i> Restablecer Administrador
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php if($mensaje): ?>
                            <div class="alert alert-<?php echo $tipo; ?> alert-dismissible fade show">
                                <?php echo $mensaje; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-user"></i> Usuario
                                </label>
                                <input type="text" name="usuario" class="form-control" 
                                       value="admin" required>
                                <small class="text-muted">Ej: admin, ivanc, etc.</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-envelope"></i> Email (opcional)
                                </label>
                                <input type="email" name="email" class="form-control" 
                                       value="admin@example.com">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-lock"></i> Nueva Contraseña
                                </label>
                                <input type="password" name="password" class="form-control" 
                                       placeholder="Mínimo 6 caracteres" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-check-circle"></i> Confirmar Contraseña
                                </label>
                                <input type="password" name="confirmar" class="form-control" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save"></i> Guardar/Crear Administrador
                            </button>
                        </form>
                        
                        <hr>
                        
                        <h5>Administradores existentes:</h5>
                        <?php if(count($administradores) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Usuario</th>
                                            <th>Email</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($administradores as $admin): ?>
                                            <tr>
                                                <td><?php echo $admin['id']; ?></td>
                                                <td><?php echo htmlspecialchars($admin['usuario']); ?></td>
                                                <td><?php echo htmlspecialchars($admin['email']); ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($admin['fecha_creacion'])); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                No hay administradores registrados. Crea uno usando el formulario.
                            </div>
                        <?php endif; ?>
                        
                        <div class="text-center mt-3">
                            <a href="login.php" class="btn btn-link">
                                <i class="fas fa-arrow-left"></i> Volver al Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>