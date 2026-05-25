CREATE DATABASE portafolio_db;
USE portafolio_db;

CREATE TABLE mensajes_contacto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    correo VARCHAR(100),
    mensaje TEXT,
    ip_usuario VARCHAR(45),
    leido TINYINT(1) DEFAULT 0,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    email VARCHAR(100),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
