DROP DATABASE IF EXISTS DW3_EDERLI_MIRANDA_MITONO_SEPULVEDA;

CREATE DATABASE DW3_EDERLI_MIRANDA_MITONO_SEPULVEDA;

USE DW3_EDERLI_MIRANDA_MITONO_SEPULVEDA;

CREATE TABLE permisos(
	IDPERMISOS TINYINT(2) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	CREAR TINYINT(1) NOT NULL,
	EDITAR TINYINT(1) NOT NULL,
	BORRAR TINYINT(1) NOT NULL,
	MODERAR_COMENTARIOS TINYINT(1) NOT NULL,
	MODERAR_USUARIOS TINYINT(1) NOT NULL,
	MODERAR_POSTS TINYINT(1) NOT NULL
)ENGINE=InnoDB;

CREATE TABLE usuarios(
	IDUSUARIOS INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	NOMBRE_COMPLETO VARCHAR(50) NOT NULL,
	NICK VARCHAR(50),
	EMAIL VARCHAR(50) NOT NULL UNIQUE,
	EDAD TINYINT(3),
	CONTRASENIA VARCHAR(32) NOT NULL,
	FECHA_ALTA DATETIME,
	U_ESTADO TINYINT(2),
	FKPERMISOS TINYINT(2) UNSIGNED,

	FOREIGN KEY(FKPERMISOS) REFERENCES permisos(IDPERMISOS)
)ENGINE=InnoDB;

CREATE TABLE tipo_chucherias(
	IDCHUCHERIA INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	TIPO_CHUCHERIA VARCHAR(30) UNIQUE NOT NULL
)ENGINE=InnoDB;

CREATE TABLE articulos(
	IDARTICULO INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	TITULO VARCHAR(50) NOT NULL,
	FECHA_ALTA DATETIME NOT NULL, 
	VIDEO VARCHAR(50),
	IMAGENES TEXT(500),
	IMG_DESTACADA VARCHAR(50) NOT NULL,
	DESCRIPCION TEXT(500) NOT NULL,
	A_ESTADO TINYINT(2),
	FKUSUARIO INT UNSIGNED,
	FKCHUCHERIA INT UNSIGNED,

	FOREIGN KEY(FKUSUARIO) REFERENCES usuarios(IDUSUARIOS),
	FOREIGN KEY(FKCHUCHERIA) REFERENCES tipo_chucherias(IDCHUCHERIA)
)ENGINE=InnoDB;

CREATE TABLE categorias(
	IDCATEGORIA TINYINT(2) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	CATEGORIA VARCHAR(30) UNIQUE NOT NULL
)ENGINE=InnoDB;

CREATE TABLE articulos_categorias(
	FKARTICULO INT UNSIGNED,
	FKCATEGORIA TINYINT(2) UNSIGNED,
	PRIMARY KEY(FKARTICULO, FKCATEGORIA),
	
	FOREIGN KEY (FKARTICULO) REFERENCES articulos(IDARTICULO),
	FOREIGN KEY (FKCATEGORIA) REFERENCES categorias(IDCATEGORIA)	
)ENGINE=InnoDB;

CREATE TABLE comentarios(
	IDCOMENTARIO INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	COMENTARIO TEXT NOT NULL,
	FECHA_COMENTARIO DATETIME,
	C_ESTADO TINYINT(2),
	FKUSUARIO INT UNSIGNED,
	FKARTICULO INT UNSIGNED,
	
	FOREIGN KEY(FKUSUARIO) REFERENCES usuarios(IDUSUARIOS)
	ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(FKARTICULO) REFERENCES articulos(IDARTICULO)	
)ENGINE=InnoDB;

CREATE TABLE recuperar_pass(
	EMAIL VARCHAR(50) NOT NULL UNIQUE,
	CLAVE_NUEVA VARCHAR(32) NOT NULL,
	TOKEN_SEGURIDAD VARCHAR(32) NOT NULL,
	
	FOREIGN KEY(EMAIL) REFERENCES usuarios(EMAIL)
)ENGINE=InnoDB;

