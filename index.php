<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Portafolio Personal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Barra de Navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-code"></i> Mi Portafolio
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">
                        <i class="fas fa-home"></i> Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contacto.php">
                        <i class="fas fa-envelope"></i> Contacto
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sección Hero -->
<section class="hero-section text-center">
    <div class="container">
        <!-- Contenedor circular para la foto -->
        <div class="foto-container">
            <img src="img/imagen.png" alt="Mi foto" class="foto-perfil">
        </div>
        <h1 class="display-4 mt-4">¡Hola! Soy Iván Coral</h1>
        <p class="lead">Estudiante | Me gusta la Tecnología</p>
        <div class="mt-3">
            <a href="#" class="text-white me-3"><i class="fab fa-github fa-2x"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-linkedin fa-2x"></i></a>
            <a href="#" class="text-white"><i class="fab fa-twitter fa-2x"></i></a>
        </div>
    </div>
</section>

<div class="container">
    <!-- Biografía -->
    <div class="row mb-5">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-center mb-4">
                        <i class="fas fa-user-circle"></i> Sobre Mí
                    </h2>
                    <p class="lead">
                        Soy estudiante de quinto ciclo de Tecnologías de la Información. Me encanta aprender nuevas tecnologías y compartir 
                        conocimiento con los demás.
                    </p>
                    <p>
                        Actualmente trabajo en una empresa farmacéutica. 
                        Mi objetivo es crear soluciones digitales que mejoren la vida de las personas.
                    </p>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-graduation-cap"></i> Educación</h5>
                            <ul>
                                <li>Tecnología de la Información - Universidad Técnica Particular de Loja</li>
                                <li>Curso de PHP y MySQL </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-code"></i> Habilidades que estoy aprendiendo</h5>
                            <ul>
                                <li>HTML5, JavaScript</li>
                                <li>PHP, MySQL, Laravel</li>
                                <li>Bootstrap, Tailwind CSS</li>
                                <li>Git, GitHub, VS Code</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hobbies -->
    <h2 class="text-center mb-4">
        <i class="fas fa-heart"></i> Mis Hobbies
    </h2>
    <div class="row mb-5">
        <div class="col-md-3 mb-3">
            <div class="card hobby-card text-center shadow">
                <div class="card-body">
                    <i class="fas fa-laptop-code fa-3x text-primary mb-3"></i>
                    <h5>Correr</h5>
                    <p>Me encanta salir por las mañanas a correr</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card hobby-card text-center shadow">
                <div class="card-body">
                    <i class="fas fa-book fa-3x text-success mb-3"></i>
                    <h5>Lectura</h5>
                    <p>Libros de tecnología y ficción</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card hobby-card text-center shadow">
                <div class="card-body">
                    <i class="fas fa-music fa-3x text-danger mb-3"></i>
                    <h5>Música</h5>
                    <p>Me gusta la música género rock y punk</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card hobby-card text-center shadow">
                <div class="card-body">
                    <i class="fas fa-hiking fa-3x text-warning mb-3"></i>
                    <h5>Senderismo</h5>
                    <p>Explorar la naturaleza los fines de semana</p>
                </div>
            </div>
        </div>
    </div>

  <!-- Proyectos Destacados -->
<h2 class="text-center mb-4">
    <i class="fas fa-project-diagram"></i> Proyectos Destacados
</h2>

<div class="row mb-5 justify-content-center">
    <div class="col-md-4 mb-3">
        <div class="card shadow">
            <div class="card-body">
                <h5>Curso de Medicinas</h5>
                <p>Curso sobre principios activos y excipientes en medicamentos.</p>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Footer -->
<div class="text-center mt-2">
    <small>
        <a href="admin/login.php" class="text-muted text-decoration-none">
            <i class="fas fa-lock"></i> Área Administrativa
        </a>
    </small>
</div>

<footer class="bg-dark text-white text-center py-4 mt-5">
    <div class="container">
        <p>&copy; 2026 Mi Portafolio Personal. Todos los derechos reservados.</p>
        <p>Desarrollado por Iván Coral</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>