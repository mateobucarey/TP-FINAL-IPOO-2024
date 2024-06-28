CREATE DATABASE bdviajes;

CREATE TABLE empresa(
    idempresa bigint AUTO_INCREMENT,
    enombre varchar(150),
    edireccion varchar(150),
    PRIMARY KEY (idempresa)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;

CREATE TABLE persona (
    nombre varchar(150),
    apellido varchar(150),
    nrodocumento varchar(15),
    PRIMARY KEY (nrodocumento)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE responsable (
    rnumeroempleado bigint AUTO_INCREMENT,
    rnumerolicencia bigint,
    rnrodocumento varchar(15),
    PRIMARY KEY (rnumeroempleado),
    FOREIGN KEY (rnrodocumento) REFERENCES persona(nrodocumento) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;

CREATE TABLE viaje (
    idviaje bigint AUTO_INCREMENT,
    vdestino varchar(150),
    vcantmaxpasajeros int,
    idempresa bigint,
    rnumeroempleado bigint,
    vimporte float,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (rnumeroempleado) REFERENCES responsable (rnumeroempleado) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;

CREATE TABLE pasajero (
    pdocumento varchar(15) PRIMARY KEY,
    ptelefono int,
    idviaje bigint,
    FOREIGN KEY (idviaje) REFERENCES viaje (idviaje) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (pdocumento) REFERENCES persona(nrodocumento) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;