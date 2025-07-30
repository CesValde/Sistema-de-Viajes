<?php

    class Empresa {
        private $idEmpresa ; 
        private $eNombre ; 
        private $eDireccion ;
        private $mensajeOperacion ; 

        public function __construct(
        ) { 
            $this -> idEmpresa = 0 ;
            $this -> eNombre = "" ;
            $this -> eDireccion =  "" ;
            $this -> mensajeOperacion = "" ;
        } 

        public function getIdEmpresa() {
            return $this -> idEmpresa ; 
        }
        public function getENombre() {
            return $this -> eNombre ; 
        }
        public function getEDireccion() {
            return $this -> eDireccion ; 
        }
        public function getMensajeOperacion() {
            return $this -> mensajeOperacion ; 
        }

        public function setIdEmpresa($idEmpresa) {
            $this -> idEmpresa = $idEmpresa ; 
        }
        public function setENombre($eNombre) {
            $this -> eNombre = $eNombre ; 
        }
        public function setEDireccion($eDireccion) {
            $this -> eDireccion = $eDireccion ; 
        } 
        public function setmensajeoperacion($mensajeOperacion) {
            $this -> mensajeOperacion = $mensajeOperacion ; 
        }

        /**
         * Carga el objeto con los valores que llegan por parametro
         * @param int $idEmpresa
         * @param string $eNombre, $eDireccion
         */
        public function cargar($idEmpresa, $eNombre, $eDireccion) {
            $this -> setIdEmpresa($idEmpresa) ; 
            $this -> setENombre($eNombre) ;
            $this -> setEDireccion($eDireccion) ; 
        }

        /**
         * Recupera los datos de una empresa por el idEmpresa, retorna true en caso de encontrar y cargar los datos, false en caso contrario 
         * @param int $idEmpresa
         * @return boolean
         */		
        public function Buscar($idEmpresa) {
            $base = new BaseDatos() ;
            $consultaEmpresa = "Select * from empresa where idempresa = " . $idEmpresa ;
            $resp = false;

            if($base -> Iniciar()){
                if($base -> Ejecutar($consultaEmpresa)) {
                    if($row = $base -> Registro()) {				
                        $this -> setIdEmpresa($idEmpresa) ;
                        $this -> setENombre($row['enombre']) ;
                        $this -> setEDireccion($row['edireccion']) ;
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
         * Lista las empresas de la base de datos y las retorna en un array
         * @param string $condicion
         * @return array,null
         */
        public function listar($condicion = "") {
            $coleccEmpresas = null ;
            $base = new BaseDatos() ;
            $consultaEmpresas = "Select * from empresa " ;

            if($condicion != "") {
                $consultaEmpresas = $consultaEmpresas . ' where ' . $condicion ;
            }
            $consultaEmpresas .= " order by enombre " ;
            if($base -> Iniciar()) {
                if($base -> Ejecutar($consultaEmpresas)) {				
                    $coleccEmpresas = [] ;
                    while($row = $base -> Registro()){
                        $idEmpresa = $row['idempresa'] ;
                        $eNombre = $row['enombre'] ;
                        $eDireccion = $row['edireccion'] ;
                        $empresa = new Empresa() ;
                        $empresa -> cargar($idEmpresa, $eNombre, $eDireccion) ;
                        $coleccEmpresas[] = $empresa ;
                    }
                } else {
                    $this -> setmensajeoperacion($base -> getError()) ;
                }
            } else {
                $this -> setmensajeoperacion($base -> getError()) ;
            }	
            return $coleccEmpresas ;
        }	
        
        /**
         * Inserta un objeto empresa en la base de datos, retorna true si se pudo y false en caso contrario
         * @return boolean
         */
        public function insertar() {
            $base = new BaseDatos() ;
            $resp = false ;
            $consulta = "INSERT INTO empresa(enombre, edireccion) 
                VALUES (
                '" . $this -> getENombre() . "',
                '" . $this -> getEDireccion() . "'
                )" ;
            
            if($base -> Iniciar()){
                $idInsertado = $base->devuelveIDInsercion($consulta);
                if($idInsertado !== null) {
                    $this->setIdEmpresa($idInsertado);
                    $resp = true;
                } else {
                    $this -> setmensajeoperacion($base -> getError()) ;  
                }
            } else {
                $this -> setmensajeoperacion($base -> getError()) ;
            }
            return $resp ;
        }
        
        /**
         * Modifica los datos de una empresa, retorna true si se pudo y false en caso contrario
         * @return boolean 
         */
        public function modificar() {
            $resp = false ; 
            $base = new BaseDatos();
            $consulta = 
                "UPDATE empresa SET 
                enombre =' " . $this -> getENombre() .
                " ', edireccion =' " . $this -> getEDireccion() .
                " ' WHERE idempresa =" . $this-> getIdEmpresa() ;

            if($base -> Iniciar()) {
                if($base -> Ejecutar($consulta)) {
                    $resp = true;
                } else {
                    $this -> setmensajeoperacion($base -> getError()) ;  
                }
            } else {
                $this -> setmensajeoperacion($base -> getError()) ;
            }
            return $resp ;
        }
        
        /**
         * Elimina una empresa de la base de datos, retorna true si se pudo y false en caso contrario
         * @return boolean
         */
        public function eliminar(){
            $base = new BaseDatos() ;
            $resp = false ;

            if($base -> Iniciar()) {
                $consulta = "DELETE FROM empresa WHERE idempresa = " . $this -> getIdEmpresa() ;
                if($base -> Ejecutar($consulta)) {
                    $resp = true ;
                } else {
                    $this -> setmensajeoperacion($base -> getError()) ;
                }
            } else {
                $this -> setmensajeoperacion($base -> getError()) ;
            }
            return $resp; 
        }

        /**
         * Consulta en la base de datos si existe una empresa con los datos pasados, retorna true si existe, false en caso contrario
         * @param string $nombre
         * @param string $direccion
         * @return boolean
         */
        public function existeEmpresa($nombre, $direccion) {
            $base = new BaseDatos();
            $resp = false;
            $consulta = "SELECT * FROM empresa WHERE enombre = '" . $nombre . "' AND edireccion = '" . $direccion . "'";
            
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
            return 
            "Id de la empresa: " . $this -> getIdEmpresa() . "\n" .
            "Nombre de la empresa: " . $this -> getENombre() . "\n" .
            "Direccion de la empresa: " . $this -> getEDireccion() . "\n" ;
        } 
    }