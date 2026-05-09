CREATE DATABASE compufix;
USE compufix;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('cliente','admin') DEFAULT 'cliente',
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE servicios (
    id_servicio INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    precio DECIMAL(10,2)
);

CREATE TABLE citas (
    id_cita INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_servicio INT,
    equipo VARCHAR(100),
    problema TEXT,
    fecha DATE,
    hora TIME,
    estado ENUM('Pendiente','En proceso','Finalizado') DEFAULT 'Pendiente',
    
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_servicio) REFERENCES servicios(id_servicio)
);

/*agregar los mantenimientos*/
INSERT INTO servicios(nombre, descripcion, precio) VALUES
('Mantenimiento Preventivo', 'Limpieza y optimización', 25.00),

('Reparación de Hardware', 'Diagnóstico y reparación física', 40.00),

('Instalación de Software', 'Instalación de programas y drivers', 20.00),

('Formateo Completo', 'Reinstalación de sistema operativo', 35.00);