<?php
session_start();

// Verificar autenticación
if(!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header('Location: login.php');
    exit();
}

require_once '../config/database.php';

// Obtener estadísticas
try {
    // Total de mensajes
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM mensajes_contacto");
    $total_mensajes = $stmt->fetch()['total'];
    
    // Mensajes no leídos
    $stmt = $pdo->query("SELECT COUNT(*) as no_leidos FROM mensajes_contacto WHERE leido = 0");
    $no_leidos = $stmt->fetch()['no_leidos'];
    
    // Mensajes de hoy
    $stmt = $pdo->query("SELECT COUNT(*) as hoy FROM mensajes_contacto WHERE DATE(fecha_envio) = CURDATE()");
    $hoy = $stmt->fetch()['hoy'];
    
} catch(PDOException $e) {
    $total_mensajes = 0;
    $no_leidos = 0;
    $hoy = 0;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Panel Admin</title>
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
        .stats-card {
            border-radius: 10px;
            transition: transform 0.3s;
            cursor: pointer;
        }
        .stats-card:hover {
            transform: translateY(-5px);
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
                    <a class="nav-link active" href="dashboard.php">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a class="nav-link" href="ver_mensajes.php">
                        <i class="fas fa-envelope"></i> Mensajes
                        <?php if($no_leidos > 0): ?>
                            <span class="badge bg-danger ms-2"><?php echo $no_leidos; ?></span>
                        <?php endif; ?>
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
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </h2>
                    <div class="text-muted">
                        <i class="fas fa-calendar-alt"></i> <?php echo date('d/m/Y H:i:s'); ?>
                    </div>
                </div>
                
                <!-- Tarjetas de estadísticas -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card stats-card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Total Mensajes</h6>
                                        <h2 class="mb-0"><?php echo $total_mensajes; ?></h2>
                                    </div>
                                    <i class="fas fa-envelope fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="card stats-card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">No Leídos</h6>
                                        <h2 class="mb-0"><?php echo $no_leidos; ?></h2>
                                    </div>
                                    <i class="fas fa-envelope-open-text fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="card stats-card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Hoy</h6>
                                        <h2 class="mb-0"><?php echo $hoy; ?></h2>
                                    </div>
                                    <i class="fas fa-calendar-day fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Últimos mensajes -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-clock"></i> Últimos Mensajes
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php
                        try {
                            $stmt = $pdo->query("SELECT * FROM mensajes_contacto ORDER BY fecha_envio DESC LIMIT 5");
                            $ultimos_mensajes = $stmt->fetchAll();
                            
                            if(count($ultimos_mensajes) > 0):
                        ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Mensaje</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($ultimos_mensajes as $msg): ?>
                                            <tr>
                                                <td><?php echo date('d/m/Y H:i', strtotime($msg['fecha_envio'])); ?></td>
                                                <td><?php echo htmlspecialchars($msg['nombre']); ?></td>
                                                <td><?php echo htmlspecialchars($msg['correo']); ?></td>
                                                <td><?php echo substr(htmlspecialchars($msg['mensaje']), 0, 50); ?>...</td>
                                                <td>
                                                    <?php if($msg['leido'] == 0): ?>
                                                        <span class="badge bg-warning">No leído</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-success">Leído</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center mt-3">
                                <a href="ver_mensajes.php" class="btn btn-primary">
                                    Ver todos los mensajes
                                </a>
                            </div>
                        <?php else: ?>
                            <p class="text-center text-muted">No hay mensajes aún</p>
                        <?php endif;
                        } catch(PDOException $e) {
                            echo '<div class="alert alert-danger">Error al cargar mensajes</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>