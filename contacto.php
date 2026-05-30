<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Mi Portafolio</title>
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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-navbar="navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-home"></i> Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="contacto.php">
                        <i class="fas fa-envelope"></i> Contacto
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Mostrar mensaje de confirmación si existe -->
<?php if(isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-<?php echo $_SESSION['tipo']; ?> alert-floating shadow">
        <i class="fas fa-<?php echo $_SESSION['tipo'] == 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
        <?php 
            echo $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
            unset($_SESSION['tipo']);
        ?>
    </div>
<?php endif; ?>

<div class="container mt-5">
    <div class="row">
        <!-- Información de contacto -->
        <div class="col-md-4 mb-4">
            <div class="contact-info text-center">
                <i class="fas fa-map-marker-alt contact-icon"></i>
                <h4>Ubicación</h4>
                <p>Ciudad de Quito, Ecuador</p>
                
                <i class="fas fa-envelope contact-icon mt-4"></i>
                <h4>Email</h4>
                <p>rivera.ivan.942@example.com</p>
                
                <i class="fas fa-phone contact-icon mt-4"></i>
                <h4>Teléfono</h4>
                <p>+593 99 123 4567</p>
                
                <hr class="bg-white">
                <div class="mt-3">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-2x"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-2x"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-2x"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-github fa-2x"></i></a>
                </div>
            </div>
        </div>

        <!-- Formulario de contacto -->
        <div class="col-md-8 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-center mb-4">
                        <i class="fas fa-paper-plane"></i> Envíame un Mensaje
                    </h2>
                    <form action="enviar_contacto.php" method="POST" id="contactForm">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-user"></i> Nombre Completo *
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="nombre" 
                                   name="nombre" 
                                   required 
                                   minlength="3"
                                   maxlength="100"
                                   placeholder="Ej: Iván Coral">
                            <div class="invalid-feedback">
                                Por favor ingresa tu nombre completo (mínimo 3 caracteres)
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label">
                                <i class="fas fa-envelope"></i> Correo Electrónico *
                            </label>
                            <input type="email" 
                                   class="form-control" 
                                   id="correo" 
                                   name="correo" 
                                   required 
                                   placeholder="ejemplo@dominio.com">
                            <div class="invalid-feedback">
                                Por favor ingresa un correo electrónico válido
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="mensaje" class="form-label">
                                <i class="fas fa-comment"></i> Mensaje *
                            </label>
                            <textarea class="form-control" 
                                      id="mensaje" 
                                      name="mensaje" 
                                      rows="5" 
                                      required 
                                      minlength="10"
                                      maxlength="500"
                                      placeholder="Escribe tu mensaje aquí..."></textarea>
                            <div class="invalid-feedback">
                                El mensaje debe tener al menos 10 caracteres
                            </div>
                            <small class="text-muted">
                                <span id="charCount">0</span>/500 caracteres
                            </small>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terminos" required>
                            <label class="form-check-label" for="terminos">
                                Acepto los <a href="#" data-bs-toggle="modal" data-bs-target="#terminosModal">términos y condiciones</a> *
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-paper-plane"></i> Enviar Mensaje
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Términos -->
<div class="modal fade" id="terminosModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Términos y Condiciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tus datos serán utilizados únicamente para responder a tu consulta. 
                   No compartiremos tu información con terceros.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->

<footer class="bg-dark text-white text-center py-4 mt-5">
    <div class="container">
        <p>&copy; 2024 Mi Portafolio Personal. Todos los derechos reservados.</p>
    </div>
</footer>

<script>
// Contador de caracteres
const mensaje = document.getElementById('mensaje');
const charCount = document.getElementById('charCount');

mensaje.addEventListener('input', function() {
    charCount.textContent = this.value.length;
});

// Validación en tiempo real
document.getElementById('contactForm').addEventListener('submit', function(e) {
    const nombre = document.getElementById('nombre');
    const correo = document.getElementById('correo');
    const mensaje = document.getElementById('mensaje');
    let isValid = true;

    // Validar nombre
    if(nombre.value.length < 3) {
        nombre.classList.add('is-invalid');
        isValid = false;
    } else {
        nombre.classList.remove('is-invalid');
    }

    // Validar correo
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if(!emailRegex.test(correo.value)) {
        correo.classList.add('is-invalid');
        isValid = false;
    } else {
        correo.classList.remove('is-invalid');
    }

    // Validar mensaje
    if(mensaje.value.length < 10) {
        mensaje.classList.add('is-invalid');
        isValid = false;
    } else {
        mensaje.classList.remove('is-invalid');
    }

    if(!isValid) {
        e.preventDefault();
    }
});

// Quitar validación al escribir
document.querySelectorAll('input, textarea').forEach(element => {
    element.addEventListener('input', function() {
        this.classList.remove('is-invalid');
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>