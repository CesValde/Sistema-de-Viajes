<?php 

    class Pasajero extends Persona {
        private $nroTelPasaj ; 
        private $viaje ; 
        private $mensajeOperacion ; 

        public function __construct($nombrePasaj = "", $apellidoPasaj = "", $nroDocPasaj = "") {
            parent::__construct($nombrePasaj, $apellidoPasaj, $nroDocPasaj);
            $this -> nroTelPasaj = 0 ; 
            $this -> viaje = new Viaje() ; 
            $this -> mensajeOperacion = "" ;  
        }
 
        public function getNroTelefPasajero() {
            return $this -> nroTelPasaj ; 
        }
        public function getMensajeOperacion() {
            return $this -> mensajeOperacion ; 
        }
        public function getViaje() {
            return $this -> viaje ; 
        }

        public function setNroTelefPasajero($nroTelPasaj) {
            $this -> nroTelPasaj = $nroTelPasaj ; 
        }
        public function setmensajeoperacion($mensajeOperacion) {
            $this -> mensajeOperacion = $mensajeOperacion ; 
        }
        public function setViaje($viaje) {
            $this -> viaje = $viaje ; 
        }

        /**
         * @param string $nombrePasaj
         * @param string $apellidoPasaj
         * @param int $nroDocPasaj
         * @param int $nroTelPasaj
         * @param object $viaje
         * Carga el objeto con los valores que se pasan por parametro
         */
        public function cargar($nombrePasaj, $apellidoPasaj, $nroDocPasaj, $nroTelPasaj, $viaje) {
            $this->setNombre($nombrePasaj);
            $this->setApellido($apellidoPasaj);
            $this->setNroDocumento($nroDocPasaj);
            $this->setNroTelefPasajero($nroTelPasaj);
            $this->setViaje($viaje);
        }

        /**
         * Recupera los datos de una persona por dni, retorna true en caso de encontrar y cargar los datos, false en caso contrario
         * @param int $dni
         * @return true  
         */		
        public function Buscar($dni) {
            $base = new BaseDatos() ;
            $consultaPersona = "
            SELECT p.nrodocumento, p.nombre, p.apellido, ps.ptelefono, ps.idviaje
            FROM pasajero ps
            JOIN persona p ON ps.nrodocumento = p.nrodocumento
            WHERE ps.nrodocumento = " .$dni;
            $resp = false ;

            if($base -> Iniciar()) {
                if($base -> Ejecutar($consultaPersona)) {
                    if($row = $base -> Registro()) {					
                        $this -> setNroDocumento($dni) ;
                        $this -> setNombre($row['nombre']) ;
                        $this -> setApellido($row['apellido']) ;
                        $this -> setNroTelefPasajero($row['ptelefono']) ;
                        $this -> setViaje($row['idviaje']) ; 
                        $resp = true ;
                    }				
                } else {
                    $this -> setmensajeoperacion($base -> getError()) ;
                }
            } else {
                $this -> setmensajeoperacion($base -> getError()) ; 
            }		
            return $resp ; 
        }	

       public function listar($condicion = "") {
            $coleccPasajero = null;
            $base = new BaseDatos();
            
           $consulta = "SELECT pa.*, p.nombre, p.apellido, p.nrodocumento
             FROM pasajero pa
             INNER JOIN persona p ON pa.nrodocumento = p.nrodocumento";

            if ($condicion != "") {
                $consulta .= " WHERE " . $condicion;
            }
            $consulta .= " ORDER BY p.apellido";

            if($base->Iniciar()) {
                if($base->Ejecutar($consulta)) {
                    $coleccPasajero = [];
                    while ($row = $base->Registro()) {
                        $nombrePasaj = $row['nombre'];
                        $apellidoPasaj = $row['apellido'];
                        $nroDocPasaj = $row['nrodocumento'];
                        $nroTelPasaj = $row['ptelefono'];
                        $viaje = new Viaje();
                        $viaje = $viaje->buscar($row['idviaje']);

                        $pasajero = new Pasajero();
                        $pasajero->cargar($nombrePasaj, $apellidoPasaj, $nroDocPasaj, $nroTelPasaj, $viaje);
                        $coleccPasajero[] = $pasajero;
                    }
                } else {
                    $this->setmensajeoperacion($base->getError());
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
            return $coleccPasajero;
        } 
        
        /**
         * Inserta un objeto pasajero en la base de datos, retorna true si se pudo y false en caso contrario
         * @return boolean
         */
        public function insertar() {
            $base = new BaseDatos() ;
            $resp = false ; 

            if(parent::insertar()) {
                $consulta = "INSERT INTO pasajero(ptelefono, nrodocumento, idviaje) 
                        VALUES ('" .
                            $this -> getNroTelefPasajero(). "','" .
                            $this -> getNroDocumento(). "','" .
                            $this -> getViaje()->getIdViaje() . "')" ;
                
                if($base -> Iniciar()) {
                    if($base -> Ejecutar($consulta)) {
                        $resp =  true ;
                    } else {
                        $this -> setmensajeoperacion($base -> getError()) ;  
                    }
                } else {
                        $this -> setmensajeoperacion($base -> getError()) ;
                }
            }
            return $resp ;
        }
        
        /**
         * Modifica los datos de un pasajero, retorna true si se pudo y false en caso contrario
         * @return boolean 
         */
        public function modificar(){
            $resp = false ; 
            $base = new BaseDatos() ;
            $consulta = "UPDATE pasajero SET 
                apellido = '" . $this -> getApellido() .
                "' ,nombre= '" . $this -> getNombre() .
                "' ,ptelefono= '" . $this -> getNroTelefPasajero() .
                "' ,idviaje= '" . $this -> getViaje() -> getIdViaje() .
                "' WHERE nrodocumento=" . $this -> getNroDocumento() ;

            if($base -> Iniciar()) {
                if($base -> Ejecutar($consulta)) {
                    $resp =  true ;
                } else {
                    $this -> setmensajeoperacion($base -> getError()) ;
                }
            } else {
                $this -> setmensajeoperacion($base -> getError()) ;
            }
            return $resp;
        }
        
        /**
         * Elimina un pasajero de la base de datos, retorna true si se pudo y false en caso contrario
         * @return boolean
         */
        public function eliminar() {
            $base = new BaseDatos() ;
            $resp = false ;

            if($base -> Iniciar()) {
                $consulta = "DELETE FROM pasajero WHERE nrodocumento = " . $this -> getNroDocumento() ;
                if($base -> Ejecutar($consulta)) {
                    if(parent::eliminar()) {
                        $resp = true;
                    } else {
                        $this->setMensajeOperacion("Error al eliminar persona: " . $this->getMensajeOperacion());
                    }
                } else {
                    $this -> setmensajeoperacion($base -> getError()) ;
                }
            } else {
                $this -> setmensajeoperacion($base -> getError()) ;
            }
            return $resp ; 
        }

        /**
         * Lista todos los pasajeros asociados a un viaje específico utilizando el ID del viaje.
         * Realiza un JOIN entre las tablas persona y pasajero, filtrando por el ID del viaje.
         * Por cada registro, crea un objeto Pasajero cargado con sus datos personales y el objeto Viaje correspondiente.
         *
         * @param int $idViaje ID del viaje del cual se quieren obtener los pasajeros
         * @return array 
         */
        public function listarPorViaje($idViaje) {
            $coleccPasajeros = [];
            $base = new BaseDatos();
            $consulta = "
                SELECT p.nombre, p.apellido, ps.nrodocumento, ps.ptelefono
                FROM pasajero ps
                JOIN persona p ON ps.nrodocumento = p.nrodocumento
                WHERE ps.idviaje = $idViaje
            ";

            if($base->Iniciar()) {
                if($base->Ejecutar($consulta)) {
                    while($row = $base->Registro()) {
                        $pasajero = new Pasajero();

                        $viaje = new Viaje();
                        $viaje->Buscar($idViaje);

                        $pasajero->cargar(
                            $row['nombre'],
                            $row['apellido'],
                            $row['nrodocumento'],
                            $row['ptelefono'],
                            $viaje
                        );
                        $coleccPasajeros[] = $pasajero;
                    }
                }
            }
            return $coleccPasajeros;
        }

        public function __toString() {
            $cadena = parent::__toString();
            return 
                $cadena.  
                "Nro de Telefono: " . $this -> getNroTelefPasajero() . "\n" ;
        }    
    }