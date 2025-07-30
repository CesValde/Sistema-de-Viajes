<?php 

    class Viaje {
        private $idViaje ; 
        private $destino ; 
        private $cantMaxPasajeros ; 
        private $empresa ;  
        private $coleccPasajeros ;  
        private $responsable ; 
        private $precioTicket ;
        private $mensajeOperacion ; 

        public function __construct() {
            $this -> idViaje = 0 ; 
            $this -> destino =  "" ;
            $this -> cantMaxPasajeros = 0 ;
            $this -> empresa = new Empresa();
            $this -> coleccPasajeros = [] ;
            $this -> responsable = new Responsable() ;
            $this -> precioTicket = 0 ;
            $this -> mensajeOperacion = "" ; 
        }

        public function getIdViaje() {
            return $this -> idViaje ; 
        }
        public function getDestino() {
            return $this -> destino ; 
        }
        public function getCantMaxPasajeros() {
            return $this -> cantMaxPasajeros ; 
        }
        public function getEmpresa() {
            return $this -> empresa ; 
        }
        public function getColeccPasajeros() {
            return $this -> coleccPasajeros ; 
        }
        public function getResponsable() {
            return $this -> responsable ; 
        }
        public function getPrecioTicket() {
            return $this -> precioTicket ; 
        }
        public function getMensajeOperacion() {
            return $this -> mensajeOperacion ; 
        }
        
        public function setIdViaje($idViaje) {
            $this -> idViaje = $idViaje ; 
        }
        public function setDestino($destino) {
            $this -> destino = $destino ;   
        }
        public function setCantMaxPasajeros($cantMaxPasajeros) {
            $this -> cantMaxPasajeros = $cantMaxPasajeros ; 
        }
        public function setEmpresa($empresa) {
            $this -> empresa = $empresa ; 
        }
        public function setColeccPasajeros($coleccPasajeros) {
            $this -> coleccPasajeros = $coleccPasajeros ; 
        }
        public function setResponsable($responsable) {
            $this -> responsable = $responsable ; 
        }
        public function setPrecioTicket($precioTicket) {
            $this -> precioTicket = $precioTicket ; 
        }
        public function setmensajeoperacion($mensajeOperacion) {
            $this -> mensajeOperacion = $mensajeOperacion ; 
        }

        /**
         * @param int $idViaje
         * @param string $destino
         * @param int $cantMaxPasajeros
         * @param object $empresa
         * @param array $coleccPasajeros
         * @param object $responsable
         * @param int $precioTicket
         * Carga el objeto con los valores que se pasan por parametro
         */
        public function cargar($idViaje, $destino, $cantMaxPasajeros, $empresa, $coleccPasajeros, $responsable, $precioTicket) {
            $this -> setIdViaje($idViaje) ; 
            $this -> setDestino($destino) ;
            $this -> setCantMaxPasajeros($cantMaxPasajeros) ; 
            $this -> setEmpresa($empresa) ; 
            $this -> setColeccPasajeros($coleccPasajeros) ; 
            $this -> setResponsable($responsable) ; 
            $this -> setPrecioTicket($precioTicket) ; 
        }

        /**
         * Recupera los datos de un viaje por codigo de viaje, retorna true en caso de encontrar y cargar los datos, false en caso contrario 
         * @param int $idViaje
         * @return boolean
         */		
        public function Buscar($idViaje) {
            $base = new BaseDatos() ;
            $consulta = "Select * from viaje  where idviaje = " . $idViaje ;
            $resp = false ;

            if($base -> Iniciar()) {
                if($base -> Ejecutar($consulta)) {
                    if($row = $base -> Registro()) {					
                        $this -> setIdViaje($idViaje) ;
                        $this -> setDestino($row['vdestino']) ;
                        $this -> setCantMaxPasajeros($row['vcantmaxpasajeros']) ;
                        $this -> setPrecioTicket($row['vimporte']) ;
                        $empresa = new Empresa();
                        $empresa->buscar($row['idempresa']);
                        $this->setEmpresa($empresa);
                        $responsable = new Responsable();
                        $responsable->buscar($row['rnumeroempleado']);
                        $this->setResponsable($responsable);
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

        /**
         * Lista los viajes de la base de datos y los retorna en un array
         * @param string $condicion
         * @return array,null
         */
        public function listar($condicion = "") {
            $coleccViajes = null ;
            $base = new BaseDatos() ;
            $consulta = "Select * from viaje " ;

            if($condicion != "") {
                $consulta = $consulta . ' where ' . $condicion;
            }

            $consulta .= " order by idviaje " ;
            if($base -> Iniciar()) {
                if($base -> Ejecutar($consulta)) {				
                    while($row = $base -> Registro()) {
                        $idViaje = $row['idviaje'] ; 
                        $destino = $row['vdestino'] ; 
                        $cantMaxPasajeros = $row['vcantmaxpasajeros'] ;
                        $precioTicket = $row['vimporte'] ;
                        $empresa = new Empresa();
                        $empresa->buscar($row['idempresa']);
                        $responsable = new Responsable();
                        $responsable->buscar($row['rnumeroempleado']);

                        /* $pasajero = new Pasajero() ;
                        $coleccPasajeros = $pasajero -> listar() ;  */
                        $pasajero = new Pasajero();
                        $coleccPasajeros = $pasajero->listarPorViaje($idViaje);

                        $viaje = new Viaje() ;
                        $viaje -> cargar($idViaje, $destino, $cantMaxPasajeros, $empresa, $coleccPasajeros, $responsable, $precioTicket) ;
                        $coleccViajes[] = $viaje;               
                    }
                } else {
                    $this -> setmensajeoperacion($base -> getError()) ;
                }
            } else {
                $this -> setmensajeoperacion($base -> getError()) ;
            }	
            return $coleccViajes ;
        } 
        
        /**
         * Inserta un objeto viaje en la base de datos, retorna true si se pudo y false en caso contrario
         * @return boolean
         */
        public function insertar() {
            $base = new BaseDatos() ;
            $resp = false ; 

            $consulta = "INSERT INTO viaje(idviaje, vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte) 
                    VALUES (" .
                        $this -> getIdViaje() . ",'".
                        $this -> getDestino() . "','" .
                        $this -> getCantMaxPasajeros() . "','" . 
                        $this -> getEmpresa()->getIdEmpresa() . "','" .
                        $this -> getResponsable()->getNroEmpleado() . "','" .     
                        $this -> getPrecioTicket(). "')" ;
            
            if($base -> Iniciar()) {
                if($base -> Ejecutar($consulta)) {
                    $resp =  true ;
                } else {
                    $this -> setmensajeoperacion($base -> getError()) ;  
                }
            } else {
                    $this -> setmensajeoperacion($base -> getError()) ;
            }
            return $resp ;
        }
        
        /**
         * Modifica los datos de un viaje, retorna true si se pudo y false en caso contrario
         * @return boolean 
         */
        public function modificar() {
            $resp = false ; 
            $base = new BaseDatos() ;
            $consulta = "UPDATE viaje SET 
                vdestino = '" . $this -> getDestino() .
                "' ,vcantmaxpasajeros = '" . $this -> getCantMaxPasajeros() .
                "' ,idempresa = '" . $this -> getEmpresa() -> getIdEmpresa() .
                "' ,rnumeroempleado = '" . $this -> getResponsable() -> getNroEmpleado() .
                "' ,vimporte = '" . $this -> getPrecioTicket() .
                "' WHERE idviaje =" . $this -> getIdViaje() ;

            if($base -> Iniciar()) {
                if($base -> Ejecutar($consulta)) {
                    $resp =  true ;
                } else {
                    $this -> setmensajeoperacion($base -> getError()) ;
                }
            } else {
                $this -> setmensajeoperacion($base -> getError()) ;
            }
            return $resp ;
        }
        
        /**
         * Elimina un viaje de la base de datos, retorna true si se pudo y false en caso contrario
         * @return boolean
         */
        public function eliminar() {
            $base = new BaseDatos() ;
            $resp = false ;

            if($base -> Iniciar()) {
                $consulta = "DELETE FROM viaje WHERE idviaje = " . $this -> getIdViaje() ;
                    if($base -> Ejecutar($consulta)) {
                        $resp = true ;
                    } else {
                        $this -> setmensajeoperacion($base -> getError()) ;
                    }
            } else {
                $this -> setmensajeoperacion($base -> getError()) ;
            }
            return $resp ; 
        }

        /* ------------------------------------------------------------------------- */

        /**
         * Vende un pasaje si hay asientos disponibles retorna el importe a pagar por el pasajero sino devuleve -1
         * @param object $pasajero
         * @return int
         */
        public function venderPasaje($pasajero) {
            $coleccPasajeros = $this -> getColeccPasajeros() ; 
            $cantPasajeros = count($coleccPasajeros) ;
            $vendido = false;

            $disponible = $this -> hayPasajeDisponible($cantPasajeros) ;
            if($disponible) {                 
                $coleccPasajeros[] = $pasajero ;
                $this->setColeccPasajeros($coleccPasajeros) ;
                $vendido = true ;
            }
            return $vendido ; 
        }

        /**
         * Retorna un booleano para determinar si hay pasajes disponibles 
         * @param int $cantPasajeros
         * @return boolean 
         */
        public function hayPasajeDisponible($cantPasajeros) {
            $cantMaxPasajeros = $this -> getCantMaxPasajeros() ; 
            $disponible = false ;
                if($cantPasajeros < $cantMaxPasajeros) {
                    $disponible = true ;
                }
            return $disponible ;
        }

        /**
         * Retorna el costo total del viaje
         * @return int  
         */
        public function gastoTotalViaje() {
            $dineroTotal = 0 ;
            $cantPasajeros = count($this->getColeccPasajeros());
            if($cantPasajeros > 0) {
                $dineroTotal = $cantPasajeros * $this->getPrecioTicket() ;
            }
            return $dineroTotal ; 
        } 

        /**
         * Consulta en la base de datos si existe un viaje con los datos pasados, retorna true si existe, false en caso contrario
         * @param string $destino
         * @param int $idEmpresa
         * @param object $responsable
         * @param int $cantMaxPasajeros
         * @param int $precioTicket
         * @return boolean
         */
        public function existeViaje($destino, $empresaId, $responsable, $cantMaxPasajeros, $precioTicket) {
            $resp = false;
            $base = new BaseDatos();
            $consulta = "SELECT * FROM viaje 
                        WHERE vdestino = '" . $destino . "' 
                        AND idempresa = " . $empresaId . " 
                        AND rnumeroempleado = '" . $responsable . "'
                        AND vcantmaxpasajeros = " . $cantMaxPasajeros . " 
                        AND vimporte = " . $precioTicket;
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
         * Recibe un objeto empresa, responsable o pasajero, retorna un array de los viajes asociados de dicha empresa o responsable, o un array de pasajeros asociados al viaje
         * @param object
         * @return array
         */
        public function estaAsociado($objeto) {
            $asociados = [];
            if(is_a($objeto, 'Empresa')) {
                $asociados = $this->listar("idempresa = " . $objeto->getIdEmpresa());
            } else if(is_a($objeto, 'Responsable')) {
                $asociados = $this->listar("rnumeroempleado = " . $objeto->getNroEmpleado());
            } else {
                // este objeto es un pasajero
                $asociados = $objeto->listar();
            }
            return $asociados;
        }

        /**
         * Recupera todos los pasajeros asociados a un viaje específico desde la base de datos.
         * Realiza un JOIN entre las tablas persona, pasajero y pasajero_viaje usando el número de documento.
         * Devuelve un array de objetos Pasajero con los datos completos de cada uno.
         *
         * @return array Colección de objetos Pasajero pertenecientes al viaje
         */
        public function pasajerosPorViaje() {
            $base = new BaseDatos();
            $coleccPasajeros = [];
            $idViaje = $this->getIdViaje();

            $consulta = "
                SELECT pe.nombre, pe.apellido, pe.nrodocumento, ps.ptelefono
                FROM pasajero_viaje pv
                JOIN pasajero ps ON pv.nrodocumento = ps.nrodocumento
                JOIN persona pe ON ps.nrodocumento = pe.nrodocumento
                WHERE pv.idviaje = $idViaje";

            if($base->Iniciar()) {
                if($base->Ejecutar($consulta)) {
                    while($row = $base->Registro()) {
                        $pasajero = new Pasajero();
                        $pasajero->cargar(
                            $row['nombre'],
                            $row['apellido'],
                            $row['nrodocumento'],
                            $row['ptelefono'],
                            $this
                        );
                        $coleccPasajeros[] = $pasajero;
                    }
                }
            }
            return $coleccPasajeros;
        }

        /**
         * Almacena en una cadena los datos de los pasajeros
         * @return array
         */
        public function datosPasajeros() {
            $cadena = "" ; 
            $coleccPasajeros = $this -> pasajerosPorViaje() ; 

            foreach($coleccPasajeros as $pasajero) {
                $cadena = $cadena . $pasajero ;
            }    
            return $cadena ; 
        }
        
        public function __toString() {
           $cadena = $this -> datosPasajeros() ; 

            return "\n" .
                "Id del viaje: " . $this -> getIdViaje() . "\n" . 
                "Destino: " . $this -> getDestino() . "\n" . 
                "Cantidad maxima de pasajeros: " . $this -> getCantMaxPasajeros() . "\n" .
                "Precio del ticket: " . $this -> getPrecioTicket() . "\n" .  
                "Empresa a cargo: " . $this-> getEmpresa() . "\n".
                "Datos del responsable: " . $this -> getResponsable(). "\n" .
                "Datos de los pasajeros: " . "\n" . ($cadena ? $cadena : "No hay pasajeros en el viaje"). "\n" ; 
        } 
    }