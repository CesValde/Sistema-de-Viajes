    CREATE DATABASE bdviajes; 

    CREATE TABLE empresa(
        idempresa bigint AUTO_INCREMENT,
        enombre varchar(150),
        edireccion varchar(150),
        PRIMARY KEY (idempresa)
    )    ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
        
    CREATE TABLE viaje (
        idviaje bigint AUTO_INCREMENT,
        vdestino varchar(150),
        vcantmaxpasajeros int,
        idempresa bigint,
        rnumeroempleado bigint,
        vimporte float,
        PRIMARY KEY (idviaje),
        FOREIGN KEY (idempresa) REFERENCES empresa (idempresa),
        FOREIGN KEY (rnumeroempleado) REFERENCES responsable (rnumeroempleado)
    )    ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;

    CREATE TABLE pasajero_viaje (
        idviaje BIGINT,
        nrodocumento BIGINT,
        PRIMARY KEY (idviaje, nrodocumento),
        FOREIGN KEY (idviaje) REFERENCES viaje(idviaje) ON DELETE CASCADE,
        FOREIGN KEY (nrodocumento) REFERENCES pasajero(nrodocumento) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    CREATE TABLE persona (
        nrodocumento BIGINT PRIMARY KEY,
        nombre VARCHAR(150),
        apellido VARCHAR(150)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

   CREATE TABLE responsable (
        rnumeroempleado BIGINT AUTO_INCREMENT PRIMARY KEY,
        rnumerolicencia BIGINT,
        nrodocumento BIGINT,
        FOREIGN KEY (nrodocumento) REFERENCES persona(nrodocumento) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    CREATE TABLE pasajero (
        nrodocumento BIGINT PRIMARY KEY,
        ptelefono VARCHAR(50), 
        idviaje BIGINT,
        FOREIGN KEY (nrodocumento) REFERENCES persona(nrodocumento) ON DELETE CASCADE,
        FOREIGN KEY (idviaje) REFERENCES viaje(idviaje) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;