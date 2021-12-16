DROP DATABASE proyecto;

CREATE DATABASE proyecto;

CREATE TABLE usuarios (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR (100) NOT NULL,
    nombre VARCHAR (50) NOT NULL,
    apellido VARCHAR (50) NOT NULL,
    contrasena VARCHAR(200) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE gastos (
    id INT,
    localId INT NOT NULL AUTO_INCREMENT,
    descripcion VARCHAR(200),
    fecha DATE,
	tipo VARCHAR(50),
	gasto FLOAT,
	PRIMARY KEY(localId)
);
CREATE TABLE ingresos (
    id INT,
    localId INT NOT NULL AUTO_INCREMENT,
    descripcion VARCHAR(200),
    fecha DATE,
	tipo VARCHAR(50),
	ingreso FLOAT,
	PRIMARY KEY(localId)
);