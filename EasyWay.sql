CREATE TABLE usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    contrasena VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE vehiculo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tipo VARCHAR(50) NOT NULL,
    color VARCHAR(50) NOT NULL,
    peso INT NOT NULL,
    numero_puertas INT,
    cilindrada VARCHAR(50),
    numero_cadenas_nieve INT,
    longitud INT
);

CREATE TABLE reserva (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    id_vehiculo INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id),
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculo(id)
);

INSERT INTO vehiculo (tipo, color, peso, numero_puertas, cilindrada, numero_cadenas_nieve, longitud)
VALUES ('Coche', 'Rojo', 1500, 4, NULL, 0, NULL),
    ('Coche', 'Azul', 1600, 2, NULL,2, NULL),
    ('Coche', 'Verde', 1700, 4, NULL, 0, NULL),
    ('Coche', 'Blanco', 1750, 4, NULL, 4, NULL),
    ('Coche', 'Amarillo', 1800, 2, NULL, 0, NULL),
    ('Camion', 'Blanco', 5000, 2, NULL, NULL, 10),
    ('Camion', 'Amarillo', 6000, 2, NULL, NULL, 15),
    ('Camion', 'Gris', 7000, 2, NULL, NULL, 20),
    ('Camion', 'Negro', 6500, 2, NULL, NULL, 18),
    ('Dos_ruedas', 'Blanco', 100, NULL, 125, NULL, NULL),
    ('Dos_ruedas', 'Negro', 150, NULL, 250, NULL, NULL),
    ('Dos_ruedas', 'Amarillo', 200, NULL, 1250, NULL, NULL),
    ('Dos_ruedas', 'Rojo', 220, NULL, 2500, NULL, NULL);
