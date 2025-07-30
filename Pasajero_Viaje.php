<?php 

    class Pasajero_Viaje {
        private $idViaje;
        private $pasajero;
        private $mensajeOperacion ;

        public function construct() {
            $this -> idViaje = 0 ; 
            $this -> pasajero = new Pasajero() ; 
            $this -> mensajeOperacion = "" ;  
        }

        public function getIdViaje() {
            return $this -> idViaje ; 
        }
        public function getPasajero() {
            return $this -> pasajero ; 
        }
        public function getMensajeOperacion() {
            return $this -> mensajeOperacion ; 
        }

        public function setIdViaje($idViaje) {
            $this -> idViaje = $idViaje ; 
        }
        public function setPasajero($pasajero) {
            $this -> pasajero = $pasajero ; 
        }
        public function setmensajeoperacion($mensajeOperacion) {
            $this -> mensajeOperacion = $mensajeOperacion ; 
        }

        /**
         * @param int $idViaje
         * @param int $pasajero
         * Carga el objeto con los valores que se pasan por parametro
         */
        public function cargar($idViaje, $pasajero) {
            $this->setIdViaje($idViaje);
            $this->setPasajero($pasajero);
        }

        /**
         * Recupera los datos de una relación pasajero-viaje, retorna true si existe, false en caso contrario
         * @param int $idViaje
         * @param int $nroDocPasajero
         * @return boolean
         */
        public function Buscar($idViaje, $nroDocPasajero) {
            $base = new BaseDatos();
            $consulta = "SELECT * FROM pasajero_viaje WHERE idviaje = " . $idViaje . " AND pdocumento = " . $nroDocPasajero;
            $resp = false;

            if($base->Iniciar()) {
                if($base->Ejecutar($consulta)) {
                    if($row = $base->Registro()) {
                        $this->setIdViaje($row['idviaje']);
                        $pasajero = new Pasajero();
                        $pasajero->buscar($row['nrodocumento']);
                        $this->setPasajero($pasajero);
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
            
            if($base->Iniciar()) {
                $consulta = "INSERT INTO pasajero_viaje (idviaje, nrodocumento) VALUES (
                '" . $this->getIdViaje() . "',
                '" . $this->getPasajero()->getNroDocumento() . "')";

                if($base->Ejecutar($consulta)) {
                    $resp = true;
                } else {
                    $this->setmensajeoperacion($base->getError());
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
            return $resp;
        }

        public function listar($condicion = "") {
            $coleccPasajeroViaje = [];
            $base = new BaseDatos();
            $consulta = "SELECT * FROM pasajero_viaje";

            if ($condicion != "") {
                $consulta .= " WHERE " . $condicion;
            }

            $consulta .= " ORDER BY idviaje";

            if($base->Iniciar()) {
                if($base->Ejecutar($consulta)) {
                    while ($row = $base->Registro()) {
                        $idViaje = $row['idviaje'];
                        $nroDocPasajero = $row['nrodocumento'];
                        $pasajero = new Pasajero();
                        $viaje = new Viaje();

                        if($pasajero->Buscar($nroDocPasajero) && $viaje->Buscar($idViaje)) {
                            $pasajeroViaje = new Pasajero_Viaje();
                            $pasajeroViaje->cargar($viaje, $pasajero);
                            $coleccPasajeroViaje[] = $pasajeroViaje;
                        }
                    }
                } else {
                    $this->setmensajeoperacion($base->getError());
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
            return $coleccPasajeroViaje;
        }

        public function eliminar($idViaje, $pDocumento) {
            $base = new BaseDatos();
            $resp = false;
            
            if($base->Iniciar()) {
                $consulta = "DELETE FROM pasajero_viaje WHERE idviaje = $idViaje AND nrodocumento = $pDocumento";
                if($base->Ejecutar($consulta)) {
                    $resp = true;
                } else {
                    $this->setmensajeoperacion($base->getError());
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
            return $resp;
        }
    }