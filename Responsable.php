<?php 

    
class Responsable extends Persona {
    private $nroEmpleado;
    private $nroLicencia;
    private $mensajeOperacion;

    public function __construct($nombreResp = "", $apellidoResp = "", $nroDocumento = "") {
        parent::__construct($nombreResp, $apellidoResp, $nroDocumento = "");
        $this->nroEmpleado = 0;
        $this->nroLicencia = 0;
        $this->mensajeOperacion = "";
    }

    public function getNroEmpleado() {
        return $this->nroEmpleado;
    }
    public function getNroLicencia() {
        return $this->nroLicencia;
    }
    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    public function setNroEmpleado($nroEmpleado) {
        $this->nroEmpleado = $nroEmpleado;
    }
    public function setNroLicencia($nroLicencia) {
        $this->nroLicencia = $nroLicencia;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    /**
     * Carga el objeto Responsable con los datos pasados por parámetro
     */
    public function cargarResp($nroDocumento, $nombre, $apellido, $nroEmpleado, $nroLicencia) {
        $this->setNroDocumento($nroDocumento);
        $this->setNombre($nombre);
        $this->setApellido($apellido);
        $this->setNroEmpleado($nroEmpleado);
        $this->setNroLicencia($nroLicencia);
    }

    /**
     * Recupera los datos de un responsable por número de empleado.
     * Retorna true si lo encuentra, false en caso contrario.
     * @param int $nroEmpleado
     * @return boolean
     */
    public function Buscar($nroEmpleado) {
        $base = new BaseDatos();
        $resp = false;

        $consulta = "SELECT r.*, p.* 
                    FROM responsable r 
                    INNER JOIN persona p ON r.nrodocumento = p.nrodocumento 
                    WHERE r.rnumeroempleado = " . $nroEmpleado;

        if ($base->Iniciar()) {
            if($base->Ejecutar($consulta)) {
                if ($row = $base->Registro()) {
                    // Datos heredados de Persona
                    $this->setNombre($row['nombre']);
                    $this->setApellido($row['apellido']);
                    $this->setNroDocumento($row['nrodocumento']);

                    // Datos propios de Responsable
                    $this->setNroEmpleado($row['rnumeroempleado']);
                    $this->setNroLicencia($row['rnumerolicencia']);

                    $resp = true;
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }

        return $resp;
    }

    public function insertar() {
        $base = new BaseDatos();
        $resp = false;

        if (parent::insertar()) {
            $consulta = "INSERT INTO responsable (rnumerolicencia, nrodocumento) VALUES (" .
                $this->getNroLicencia() . ", " .
                $this->getNroDocumento() . ")";

            if ($base->Iniciar()) {
                if ($base->Ejecutar($consulta)) {
                    $resp = true;
                } else {
                    $this->setMensajeOperacion($base->getError());
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        }

        return $resp;
    }

    /**
     * Lista los responsables de la base de datos y los retorna en un array
     * @param string $condicion
     * @return array|null
     */
    public function listar($condicion = "") {
        $coleccResponsable = null;
        $base = new BaseDatos();
        $consulta = "SELECT r.*, p.nombre, p.apellido, p.nrodocumento
                    FROM responsable r 
                    INNER JOIN persona p ON r.nrodocumento = p.nrodocumento";

        if ($condicion != "") {
            $consulta .= " WHERE " . $condicion;
        }
        $consulta .= " ORDER BY p.apellido";

        if($base->Iniciar()) {
            if($base->Ejecutar($consulta)) {
                $coleccResponsable = [];
                while($row = $base->Registro()) {
                    $nroEmpleado = $row['rnumeroempleado'];
                    $nroLicencia = $row['rnumerolicencia'];
                    $nombreResp = $row['nombre'];
                    $apellidoResp = $row['apellido'];
                    $nroDocumento = $row['nrodocumento'];

                    $responsable = new Responsable();
                    $responsable->cargarResp($nroDocumento, $nombreResp, $apellidoResp, $nroEmpleado, $nroLicencia);
                    $coleccResponsable[] = $responsable;
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }

        return $coleccResponsable;
    }

    /**
     * Modifica el responsable en la base de datos
     */
    public function modificar() {
        $base = new BaseDatos();
        $resp = false;

        if(parent::modificar()) {
            $consulta = "UPDATE responsable SET 
                rnumerolicencia = '" . $this->getNroLicencia() . "'
                WHERE rnumeroempleado = " . $this->getNroEmpleado();

            if($base->Iniciar()) {
                if($base->Ejecutar($consulta)) {
                    $resp = true;
                } else {
                    $this->setMensajeOperacion($base->getError());
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        }

        return $resp;
    }

    /**
     * Elimina el responsable de la base de datos
     */
    public function eliminar() {
        $base = new BaseDatos();
        $resp = false;

        $consulta = "DELETE FROM responsable WHERE rnumeroempleado = " . $this->getNroEmpleado();
        if($base->Iniciar()) {
            if($base->Ejecutar($consulta)) {
                if(parent::eliminar()) {
                    $resp = true;
                } else {
                    $this->setMensajeOperacion("Error al eliminar persona: " . $this->getMensajeOperacion());
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }

        return $resp;
    }

    public function __toString() {
        $cadena = parent::__toString();
        return $cadena .
               "Nro Empleado: " . $this->getNroEmpleado() . "\n" .
               "Nro Licencia: " . $this->getNroLicencia() . "\n";
    }
}