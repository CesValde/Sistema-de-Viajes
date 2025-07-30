<?php 

class Persona {
    private $nombre;
    private $apellido;
    private $nroDocumento;
    private $mensajeOperacion;

    public function __construct($nombre = "", $apellido = "", $nroDocumento = "") {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->nroDocumento = $nroDocumento;
        $this->mensajeOperacion = "";
    }

    public function getNombre() {
        return $this->nombre;
    }
    public function getApellido() {
        return $this->apellido;
    }
    public function getNroDocumento() {
        return $this->nroDocumento;
    }
    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }
    public function setNroDocumento($nroDocumento) {
        $this->nroDocumento = $nroDocumento;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function cargarPersona($nombre, $apellido, $nroDocumento) {
        $this->setNombre($nombre);
        $this->setApellido($apellido);
        $this->setNroDocumento($nroDocumento);
    }

    /**
     * Busca una persona por su idpersona y carga los datos en el objeto
     * @param int $idpersona
     * @return bool true si encontró y cargó la persona, false si no
     */
    public function buscar($nroDocumento) {
        $base = new BaseDatos();
        $resp = false;
        $consulta = "SELECT * FROM persona WHERE nrodocumento = " . $nroDocumento;

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($row = $base->Registro()) {
                    $this->setNombre($row['nombre']);
                    $this->setApellido($row['apellido']);
                    $this->setNroDocumento($row['nrodocumento']);
                    $resp = true;
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    public function insertar() {
        $base = new BaseDatos();
        $resp = false;
        $consulta = "INSERT INTO persona(nombre, apellido, nrodocumento) VALUES (
            '" . $this->getNombre() . "',
            '" . $this->getApellido() . "',
            '" . $this->getNroDocumento() . "')";

        if($base -> Iniciar()){
            if($base->Ejecutar($consulta)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        }
        return $resp;
    }

    public function modificar() {
        $base = new BaseDatos();
        $resp = false;
        $consulta = "UPDATE persona SET 
            nombre = '" . $this->getNombre() . "',
            apellido = '" . $this->getApellido() . "',
            WHERE nrodocumento = " . $this->getNroDocumento();

        if($base->Iniciar()) {
            if($base->Ejecutar($consulta)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

     /**
     * Elimina el responsable de la base de datos
     */
    public function eliminar() {
        $base = new BaseDatos();
        $resp = false;

        $consulta = "DELETE FROM persona WHERE nrodocumento = " . $this->getNroDocumento();
        if($base->Iniciar()) {
            if($base->Ejecutar($consulta)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }

        return $resp;
    }


    /**
     * Consulta en la base de datos si existe un pasajero o un responsable con los datos pasados, retorna true si existe, false en caso contrario
     * @param string $nombre
     * @param string $apellido
     * @param int $nroDocumento
     * @return boolean
     */
    public function existePersona($nombre, $apellido, $nroDocumento, $idViaje) {
        $base = new BaseDatos();
        $resp = false;

        if($idViaje == null) {
            $consulta = "
            SELECT * 
            FROM responsable r 
            JOIN persona p ON r.nrodocumento = p.nrodocumento 
            WHERE r.rnumerolicencia = '$nroDocumento'
            AND p.nombre = '$nombre' 
            AND p.apellido = '$apellido'";
        } else {
            $consulta = "
            SELECT * 
            FROM pasajero ps 
            JOIN persona p ON ps.nrodocumento = p.nrodocumento 
            WHERE p.nrodocumento = '$nroDocumento' 
            AND p.nombre = '$nombre' 
            AND p.apellido = '$apellido' 
            AND ps.idviaje = $idViaje";
        }
        if($base->Iniciar()) {
            if($base->Ejecutar($consulta)) {
                if($base->Registro()) {
                    $resp = true;
                }
            }
        }
        return $resp;
    }

    /**
     * Consulta en la base de datos si un pasajero con un nroDocumento ya está registrado en un viaje específico
     * @param int $nroDocumento
     * @param int $idViaje
     * @return boolean
     */
        public function existePasajeroEnViaje($nroDocumento, $idViaje) {
        $base = new BaseDatos();
        $resp = false;

        $consulta = "
            SELECT 1 
            FROM pasajero_viaje pv
            WHERE pv.nrodocumento = '$nroDocumento' 
            AND pv.idviaje = $idViaje
            LIMIT 1";

        if($base->Iniciar()) {
            if($base->Ejecutar($consulta)) {
                if($base->Registro()) {
                    $resp = true;
                }
            }
        }
        return $resp;
    }

    public function __toString() {
        return "\n".
        "Nombre: " . $this->getNombre() . "\n" .
        "Apellido: " . $this->getApellido() . "\n" .
        "DNI: " . $this->getNroDocumento() . "\n";
    }
}
