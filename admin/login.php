<?php
session_start();

// Si ya está logueado, redirigir al dashboard
if(isset($_SESSION['admin_logueado']) && $_SESSION['admin_logueado'] === true) {
    header('Location: dashboard.php');
    exit();
}

require_once '../config/database.php';

$error = '';
$debug_info = '';

if($_POST) {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    
    if(empty($usuario) || empty($password)) {
        $error = "Todos los campos son obligatorios";
    } else {
        try {
            // Verificar primero si la tabla existe
            $check_table = $pdo->query("SHOW TABLES LIKE 'administradores'");
            if($check_table->rowCount() == 0) {
                $error = "La tabla de administradores no existe. Contacta al administrador del sistema.";
                $debug_info = "Ejecuta el script SQL para crear la tabla administradores";
            } else {
                $sql = "SELECT id, usuario, password FROM administradores WHERE usuario = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$usuario]);
                $admin = $stmt->fetch();
                
                if($admin) {
                    if(password_verify($password, $admin['password'])) {
                        $_SESSION['admin_logueado'] = true;
                        $_SESSION['admin_id'] = $admin['id'];
                        $_SESSION['admin_usuario'] = $admin['usuario'];
                        header('Location: dashboard.php');
                        exit();
                    } else {
                        $error = "Contraseña incorrecta";
                        $debug_info = "Verifica que la contraseña sea correcta";
                    }
                } else {
                    $error = "Usuario no encontrado: " . $usuario;
                    $debug_info = "El usuario '$usuario' no existe en la base de datos";
                }
            }
        } catch(PDOException $e) {
            $error = "Error en la base de datos";
            $debug_info = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Mi Portafolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-user-shield fa-4x text-primary"></i>
                            <h3 class="mt-2">Panel Administrativo</h3>
                            <p class="text-muted">Ingresa tus credenciales</p>
                        </div>
                        
                        <?php if($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle"></i> 
                                <strong>Error:</strong> <?php echo $error; ?>
                                <?php if($debug_info): ?>
                                    <br><small class="text-muted"><?php echo $debug_info; ?></small>
                                <?php endif; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-user"></i> Usuario
                                </label>
                                <input type="text" name="usuario" class="form-control form-control-lg" 
                                       placeholder="admin" required autofocus>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-key"></i> Contraseña
                                </label>
                                <input type="password" name="password" class="form-control form-control-lg" 
                                       placeholder="admin123" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-sign-in-alt"></i> Ingresar
                            </button>
                        </form>
                        
                        <hr>
                        
                        <div class="text-center">
                            <a href="../index.php" class="text-decoration-none">
                                <i class="fas fa-arrow-left"></i> Volver al sitio
                            </a>
                        </div>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                Credenciales por defecto: admin / admin123
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>