<?php
session_start();

// Verificar autenticación
if(!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header('Location: login.php');
    exit();
}

require_once '../config/database.php';

// Marcar mensaje como leído
if(isset($_GET['marcar_leido']) && is_numeric($_GET['marcar_leido'])) {
    $id = $_GET['marcar_leido'];
    try {
        $stmt = $pdo->prepare("UPDATE mensajes_contacto SET leido = 1 WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: ver_mensajes.php');
        exit();
    } catch(PDOException $e) {
        // Error
    }
}

// Eliminar mensaje
if(isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    try {
        $stmt = $pdo->prepare("DELETE FROM mensajes_contacto WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: ver_mensajes.php');
        exit();
    } catch(PDOException $e) {
        // Error
    }
}

// Obtener todos los mensajes
try {
    $stmt = $pdo->query("SELECT * FROM mensajes_contacto ORDER BY fecha_envio DESC");
    $mensajes = $stmt->fetchAll();
} catch(PDOException $e) {
    $mensajes = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Mensajes - Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: white;
            padding: 12px 20px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.2);
            border-radius: 5px;
        }
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.3);
            border-radius: 5px;
        }
        .mensaje-card {
            transition: all 0.3s;
            border-left: 4px solid #667eea;
        }
        .mensaje-card:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .no-leido {
            background-color: #fff3cd;
            border-left-color: #ffc107;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 p-0 sidebar">
                <div class="text-center py-4">
                    <i class="fas fa-user-shield fa-3x text-white"></i>
                    <h5 class="text-white mt-2">Admin Panel</h5>
                    <small class="text-white-50"><?php echo $_SESSION['admin_usuario']; ?></small>
                </div>
                <hr class="bg-white">
                <nav class="nav flex-column">
                    <a class="nav-link" href="dashboard.php">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a class="nav-link active" href="ver_mensajes.php">
                        <i class="fas fa-envelope"></i> Mensajes
                    </a>
                    <a class="nav-link text-danger" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                </nav>
            </div>
            
            <!-- Main content -->
            <div class="col-md-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>
                        <i class="fas fa-envelope"></i> Mensajes de Contacto
                        <span class="badge bg-primary"><?php echo count($mensajes); ?> total</span>
                    </h2>
                    <a href="dashboard.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                
                <?php if(count($mensajes) > 0): ?>
                    <?php foreach($mensajes as $msg): ?>
                        <div class="card mb-3 mensaje-card <?php echo $msg['leido'] == 0 ? 'no-leido' : ''; ?>">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="mb-1">
                                                    <i class="fas fa-user-circle text-primary"></i>
                                                    <?php echo htmlspecialchars($msg['nombre']); ?>
                                                </h5>
                                                <p class="mb-1">
                                                    <i class="fas fa-envelope"></i> 
                                                    <?php echo htmlspecialchars($msg['correo']); ?>
                                                </p>
                                                <p class="mb-1">
                                                    <i class="fas fa-calendar-alt"></i> 
                                                    <?php echo date('d/m/Y H:i:s', strtotime($msg['fecha_envio'])); ?>
                                                </p>
                                                <p class="mb-1">
                                                    <i class="fas fa-network-wired"></i> 
                                                    IP: <?php echo htmlspecialchars($msg['ip_usuario']); ?>
                                                </p>
                                                <hr>
                                                <p class="mb-0">
                                                    <strong>Mensaje:</strong><br>
                                                    <?php echo nl2br(htmlspecialchars($msg['mensaje'])); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <div class="mb-2">
                                            <?php if($msg['leido'] == 0): ?>
                                                <span class="badge bg-warning">No leído</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">Leído</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="btn-group-vertical w-100" role="group">
                                            <?php if($msg['leido'] == 0): ?>
                                                <a href="?marcar_leido=<?php echo $msg['id']; ?>" 
                                                   class="btn btn-sm btn-success mb-2">
                                                    <i class="fas fa-check"></i> Marcar como leído
                                                </a>
                                            <?php endif; ?>
                                            <a href="?eliminar=<?php echo $msg['id']; ?>" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('¿Estás seguro de eliminar este mensaje?')">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-info text-center">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <h5>No hay mensajes aún</h5>
                        <p>Cuando los usuarios envíen mensajes, aparecerán aquí.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>