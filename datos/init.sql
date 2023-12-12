CREATE DATABASE IF NOT EXISTS usuariosbd;

USE usuariosbd;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(40) NOT NULL,
    email VARCHAR(40) NOT NULL,
    jamon VARCHAR(40) NOT NULL
);

INSERT INTO usuarios (nombre, email, jamon) VALUES
    ('pedro', 'pedrojcros@gmail.com', '1'),
    ('manolo', 'jve@ieslasfuentezuelas.com', '1'),
    ('docker', 'docker@gmail.com', '0');