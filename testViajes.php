<?php

use LDAP\Result;
use LDAP\ResultEntry;

    include_once "Persona.php";
    include_once "Empresa.php" ;
    include_once "Pasajero.php" ; 
    include_once "Responsable.php" ; 
    include_once "Viaje.php" ; 
    include_once "Pasajero_Viaje.php";
    include_once "BaseDatos.php" ; 

    /**
     * Método que convierte arrays u objetos en cadenas de texto
     */
    function arrayString($array){
        $cadena = "" ;
        foreach($array as $value){
            $stringObj = $value -> __toString();
            $cadena.= "$stringObj \n";
        }
        return $cadena ;
    }

    /**
     * Despliega el menu de opciones
     * @return string
     */
    function menu() {
        // string $opcion

        echo "\n" ; 
        echo "Ingrese una opcion: " . "\n" ; 
        echo "1. Empresas" . "\n" ;
        echo "2. Responsables" . "\n" ;
        echo "3. Viajes" . "\n" ;
        echo "4. Pasajeros" . "\n" ;
        echo "5. Salir del sistema" . "\n" ;
        echo "Ingrese opcion: " ; 
        $opcion = trim(fgets(STDIN)) ;
        echo "\n" ;
            while($opcion < 1 || $opcion > 5) {
                echo "Ingrese una opcion correcta" . "\n" ; 
                echo "\n" ;  
                echo "1. Empresas" . "\n" ;
                echo "2. Responsables" . "\n" ;
                echo "3. Viajes" . "\n" ;
                echo "4. Pasajeros" . "\n" ;
                echo "5. Salir del sistema" . "\n" ;
                echo "Ingrese opcion: " ; 
                $opcion = trim(fgets(STDIN)) ;
                echo "\n" ; 
            }
        return $opcion ;
    }

    /**
     * Despliega el submenu de opciones
     * @return string
     */
    function menuEmpresa() {
        // string $opcion

        echo "\n" ; 
        echo "Ingrese una opcion: " . "\n" ; 
        echo "1. Crear empresa" . "\n" ;
        echo "2. Modificar empresa" . "\n" ;
        echo "3. Eliminar empresa" . "\n" ;
        echo "4. Ver empresas" . "\n" ;
        echo "5. Volver al menu" . "\n" ;
        echo "Ingrese opcion: " ; 
        $opcion = trim(fgets(STDIN)) ;
        echo "\n" ;
            while($opcion < 1 || $opcion > 5) {
                echo "Ingrese una opcion correcta" . "\n" ; 
                echo "\n" ;  
                echo "Ingrese una opcion: " . "\n" ; 
                echo "1. Crear empresa" . "\n" ;
                echo "2. Modificar empresa" . "\n" ;
                echo "3. Eliminar empresa" . "\n" ;
                echo "4. Ver empresas" . "\n" ;
                echo "5. Volver al menu" . "\n" ;
                echo "Ingrese opcion: " ; 
                $opcion = trim(fgets(STDIN)) ;
                echo "\n" ; 
            }
        return $opcion ;
    }

    /**
     * Despliega el submenu de opciones
     * @return string
     */
    function menuResponsable() {
        // string $opcion

        echo "\n" ; 
        echo "Ingrese una opcion: " . "\n" ; 
        echo "1. Crear responsable" . "\n" ;
        echo "2. Modificar responsable" . "\n" ;
        echo "3. Eliminar responsable" . "\n" ;
        echo "4. Ver responsables" . "\n" ;
        echo "5. Volver al menu" . "\n" ;
        echo "Ingrese opcion: " ; 
        $opcion = trim(fgets(STDIN)) ;
        echo "\n" ;
            while($opcion < 1 || $opcion > 5) {
                echo "Ingrese una opcion correcta" . "\n" ; 
                echo "\n" ;  
                echo "1. Crear responsable" . "\n" ;
                echo "2. Modificar responsable" . "\n" ;
                echo "3. Eliminar responsable" . "\n" ;
                echo "4. Ver responsables" . "\n" ;
                echo "5. Volver al menu" . "\n" ;
                echo "Ingrese opcion: " ; 
                $opcion = trim(fgets(STDIN)) ;
                echo "\n" ; 
            }
        return $opcion ;
    }

    /**
     * Despliega el submenu de opciones
     * @return string
     */
    function menuViaje() {
        // string $opcion

        echo "\n" ; 
        echo "Ingrese una opcion: " . "\n" ; 
        echo "1. Crear viaje" . "\n" ;
        echo "2. Modificar viaje" . "\n" ;
        echo "3. Eliminar viaje" . "\n" ;
        echo "4. Ver viajes" . "\n" ;
        echo "5. Volver al menu" . "\n" ;
        echo "Ingrese opcion: " ; 
        $opcion = trim(fgets(STDIN)) ;
        echo "\n" ;
            while($opcion < 1 || $opcion > 5) {
                echo "Ingrese una opcion correcta" . "\n" ; 
                echo "\n" ;  
                echo "1. Crear viaje" . "\n" ;
                echo "2. Modificar viaje" . "\n" ;
                echo "3. Eliminar viaje" . "\n" ;
                echo "4. Ver viajes" . "\n" ;
                echo "5. Volver al menu" . "\n" ;
                echo "Ingrese opcion: " ; 
                $opcion = trim(fgets(STDIN)) ;
                echo "\n" ; 
            }
        return $opcion ;
    }

    /**
     * Despliega el submenu de opciones
     * @return string
     */
    function menuPasajero() {
        // string $opcion

        echo "\n" ; 
        echo "Ingrese una opcion: " . "\n" ; 
        echo "1. Crear pasajero" . "\n" ;
        echo "2. Modificar pasajero" . "\n" ;
        echo "3. Eliminar pasajero" . "\n" ;
        echo "4. Ver pasajeros" . "\n" ;
        echo "5. Volver al menu" . "\n" ;
        echo "Ingrese opcion: " ; 
        $opcion = trim(fgets(STDIN)) ;
        echo "\n" ;
            while($opcion < 1 || $opcion > 5) {
                echo "Ingrese una opcion correcta" . "\n" ; 
                echo "\n" ;  
                echo "1. Crear pasajero" . "\n" ;
                echo "2. Modificar pasajero" . "\n" ;
                echo "3. Eliminar pasajero" . "\n" ;
                echo "4. Ver pasajeros" . "\n" ;
                echo "5. Volver al menu" . "\n" ;
                echo "Ingrese opcion: " ; 
                $opcion = trim(fgets(STDIN)) ;
                echo "\n" ; 
            }
        return $opcion ;
    }

    /**
     * Valida si es un nombre valido
     * @param string $nombre
     * @return string
     */
    function validarNombre($nombre) {
        while(!preg_match('/^[\p{L}]+(?:\s[\p{L}]+)*$/u', $nombre) || $nombre == "") {
            echo "Error!!". "\n". "Ingrese un valor correcto: " ; 
            $nombre = trim(fgets(STDIN)) ;
        }
        $nombre = strtoupper($nombre);
        return $nombre ;
    }

    /**
     * Valida si es un apellido valido
     * @param string $apellido
     * @return string
     */
    function validarDireccion($direccion) {
        while(!preg_match('/^[a-zA-Z0-9\s]+$/', $direccion)) {
            echo "Error!!". "\n". "Ingrese una direccion valida: " ; 
            $direccion = trim(fgets(STDIN)) ;
        }
        $direccion = strtoupper($direccion);
        return $direccion ;
    }

    /**
     * Valida si es un numero valido
     * @param int $numero
     * @return int
     */
    function validarNumero($numero) {
        while(!ctype_digit($numero) || $numero == "") {
            echo "Error!!". "\n". "Ingrese un numero valido: " ; 
            $numero = trim(fgets(STDIN)) ;    
        }
        return $numero ; 
    }

    do {
        /* Despliega el menu principal */
        $opcion = menu() ; 
        switch($opcion) {
            case 1:  
                /* Despliega el menu para la seccion de empresas */
                $opcionEmpresa = menuEmpresa() ; 
                while($opcionEmpresa <> 5) {
                    switch($opcionEmpresa) {
                        case 1: 
                            /* Crear una empresa */                      
                            echo "Ingrese nombre de la empresa: " ; 
                            $eNombre = validarNombre(trim(fgets(STDIN)));
                            echo "Ingrese direccion de la empresa: " ; 
                            $eDireccion = validarDireccion(trim(fgets(STDIN)));
                            $empresa = new Empresa() ;
                            $existe = $empresa->existeEmpresa($eNombre, $eDireccion);
                            if(!$existe) {
                                $empresa->cargar(0, $eNombre, $eDireccion) ; 
                                $empresa->insertar() ; 
                            } else {
                                echo "La empresa ya existe \n";
                            }
                        break ; 
                        case 2: 
                            /* Modificar una empresa */
                            echo "Ingrese el id de la empresa a modificar: " ; 
                            $idEmpresa = validarNumero(trim(fgets(STDIN)));
                            $empresa = new Empresa() ;
                            $encontro = $empresa->Buscar($idEmpresa) ;
                            if($encontro) {
                                echo "Ingrese nuevo nombre de la empresa: " ; 
                                $eNombre = validarNombre(trim(fgets(STDIN)));
                                echo "Ingrese nueva direccion de la empresa: " ; 
                                $eDireccion = validarDireccion(trim(fgets(STDIN)));
                                $existe = $empresa->existeEmpresa($eNombre, $eDireccion);
                                if(!$existe) {
                                    $empresa->cargar($idEmpresa, $eNombre, $eDireccion) ; 
                                    $modifico = $empresa->modificar(); 
                                    if($modifico) {
                                        echo "La empresa fue modificada \n" ; 
                                    } else {
                                        echo "Error! La empresa no fue modificada \n" ;
                                    } 
                                } else {
                                    echo "La empresa ya existe \n";
                                }
                            } else {
                                echo "La empresa no fue encontrada \n" ;
                            }
                        break ; 
                        case 3:
                            /* Eliminar una empresa */
                            echo "Ingrese el id de la empresa a eliminar: " ; 
                            $idEmpresa = validarNumero(trim(fgets(STDIN)));
                            $empresa = new Empresa() ;
                            $encontro = $empresa -> Buscar($idEmpresa) ;
                            if($encontro) {
                                $viaje = new Viaje();
                                // valido si hay una empresa asociada a el viaje
                                $viajesAsociados = $viaje->estaAsociado($empresa);
                                if(count($viajesAsociados) > 0) {
                                    echo "ERROR!!! No se puede eliminar la empresa, tiene viajes asociados!!! \n";
                                } else {
                                    $borrado = $empresa -> eliminar() ;
                                    if($borrado) {
                                        echo "La empresa fue eliminada \n" ; 
                                    } else {
                                        echo "Error!! La empresa no fue eliminada \n" ;
                                    }
                                }
                            } else {
                                echo "La empresa no fue encontrada \n" ; 
                            }
                        break ;
                        case 4: 
                            /* ver las empresas */
                            $empresa = new Empresa() ;
                            $coleccEmpresas = $empresa -> listar() ;
                            if(count($coleccEmpresas) > 0 ){
                                echo arrayString($coleccEmpresas) ;
                            } else {
                                echo "No hay empresas para mostrar \n"; 
                            }   
                        break ; 
                    }
                    $opcionEmpresa = menuEmpresa() ;
                }
            break ;
            case 2:
                /* Despliega el menu para la seccion de responsable */
                $opcionResponsable = menuResponsable() ; 
                while($opcionResponsable <> 5) {
                    switch($opcionResponsable) {
                        case 1: 
                            /* Crear reponsable */
                            echo "Ingrese dni del responsable: " ; 
                            $dni = validarNumero(trim(fgets(STDIN)));     
                            echo "Ingrese nro de licencia del responsable: " ; 
                            $rNroLicencia = validarNumero(trim(fgets(STDIN)));                           
                            echo "Ingrese nombre del responsable: " ; 
                            $rNombre = validarNombre(trim(fgets(STDIN)));
                            echo "Ingrese apellido del responsable: " ;
                            $rApellido = validarNombre(trim(fgets(STDIN)));
                            $responsable = new Responsable() ; 
                            $existe = $responsable->existePersona($rNombre, $rApellido, $rNroLicencia, null);
                            if(!$existe) {
                                $responsable -> cargarResp($dni, $rNombre, $rApellido, 0, $rNroLicencia) ; 
                                $responsable -> insertar() ; 
                            } else {
                                echo "El responsable ya existe \n";
                            }
                        break ;
                        case 2: 
                            /* Modificar reponsable */
                            echo "Ingrese el nro de empleado del responsable a modificar: " ; 
                            $rNroEmpleado = validarNumero(trim(fgets(STDIN)));
                            $responsable = new Responsable() ;
                            $encontro = $responsable -> Buscar($rNroEmpleado) ; 
                                if($encontro) {
                                    echo "Ingrese nuevo nro de licencia del responsable: " ; 
                                    $rNroLicencia = validarNumero(trim(fgets(STDIN)));
                                    echo "Ingrese nuevo nombre del responsable: " ; 
                                    $rNombre = validarNombre(trim(fgets(STDIN)));
                                    echo "Ingrese nuevo apellido del responsable: " ;
                                    $rApellido = validarNombre(trim(fgets(STDIN)));
                                    $existe = $responsable->existePersona($rNombre, $rApellido, $rNroLicencia, null);
                                    if(!$existe) {
                                        $responsable -> cargarResp(0, $rNombre, $rApellido, $rNroEmpleado, $rNroLicencia) ; 
                                        $modifico = $responsable -> modificar() ; 
                                        if($modifico) {
                                            echo "El responsable fue modificado \n" ; 
                                        } else {
                                            echo "Error! el responsable no fue modificado \n" ;
                                        } 
                                    } else {
                                        echo "El responsable ya existe \n";
                                    }
                                } else {
                                    echo "El responsable no fue encontrado \n" ; 
                                }
                        break ; 
                        case 3: 
                            /* eliminar reponsable */
                            echo "Ingrese el nro de empleado del responsable a eliminar: " ; 
                            $rNroEmpleado = validarNumero(trim(fgets(STDIN))) ;
                            $responsable = new Responsable();
                            $encontro = $responsable -> Buscar($rNroEmpleado) ; 
                            if($encontro) {
                                $viaje = new Viaje();
                                $viajesAsociados = $viaje->estaAsociado($responsable);
                                if(count($viajesAsociados) > 0) {
                                    // valido si hay un responsable asociado a el viaje
                                    echo "ERROR!!! No se puede eliminar el responsable, tiene viajes asociados!!! \n";
                                } else {
                                    $borrado = $responsable -> eliminar() ; 
                                    if($borrado) {
                                        echo "El responsable fue eliminado \n" ; 
                                    } else {
                                        echo "Error! el responsable no fue eliminado \n" ;
                                    }
                                } 
                            } else {
                                echo "El responsable no fue encontrado \n";
                            }
                        break ; 
                        case 4: 
                            /* ver los responsables */                           
                            $responsable = new Responsable() ;
                            $coleccResponsables = $responsable -> listar();
                            if(count($coleccResponsables) > 0 ){
                                echo arrayString($coleccResponsables) ;
                            } else {
                                echo "No hay responsables para mostrar \n"; 
                            }
                        break ; 
                    }
                    $opcionResponsable = menuResponsable() ;
                }
            break ; 
            case 3: 
                /* Despliega el menu para la seccion de viaje */
                $opcionViaje = menuViaje() ; 
                while($opcionViaje <> 5) {
                    switch($opcionViaje) {
                        case 1: 
                            /* Crear viaje */
                            $responsable = new Responsable() ;
                            $coleccResponsables = $responsable -> listar();
                            if(count($coleccResponsables) > 0 ){
                                echo arrayString($coleccResponsables) ;
                            } else {
                                echo "No hay responsables para mostrar \n"; 
                            }
                            echo "Ingrese el numero de empleado del responsable a cargo: ";
                            $rNroEmpleado = validarNumero(trim(fgets(STDIN))) ;
                            $responsable = new Responsable();
                            $existe = $responsable->buscar($rNroEmpleado);
                            if($existe) {
                                $empresa = new Empresa() ;
                                $coleccEmpresas = $empresa -> listar() ;
                                if(count($coleccEmpresas) > 0 ){
                                    echo arrayString($coleccEmpresas) ;
                                } else {
                                    echo "No hay empresas para mostrar \n"; 
                                } 
                                echo "Ingrese el ID de la empresa a cargo: ";
                                $idEmpresa = validarNumero(trim(fgets(STDIN))) ;
                                $empresa = new Empresa(); 
                                $existe = $empresa->Buscar($idEmpresa);
                                if($existe) {
                                    echo "Ingrese el destino: ";
                                    $destino = validarNombre(trim(fgets(STDIN))) ;
                                    echo "Ingrese cantidad maxima de pasajeros: ";
                                    $cantMaxPasajeros = validarNumero(trim(fgets(STDIN))) ;
                                    echo "Ingrese el precio del ticket: ";
                                    $precioTicket = validarNumero(trim(fgets(STDIN))) ;
                                    $coleccPasajeros = (new Pasajero()) -> listar();
                                    $viaje = new Viaje();
                                    $existe = $viaje->existeViaje($destino, $idEmpresa, $responsable, $cantMaxPasajeros, $precioTicket);
                                    if(!$existe) {
                                        $viaje->cargar(0, $destino, $cantMaxPasajeros, $empresa, $coleccPasajeros, $responsable, $precioTicket);
                                        $viaje->insertar();
                                    } else {
                                        echo "El viaje ya existe \n";
                                    }
                                } else {
                                    echo "La empresa no existe, creacion del viaje cancelada \n";
                                }                          
                            } else {
                                echo "El responsable no existe, creacion de viaje cancelada \n";
                            }
                        break ; 
                        case 2: 
                            /* Modificar viaje */
                            $viaje = new Viaje() ;
                            $coleccViajes = $viaje -> listar();
                            if(count($coleccViajes) > 0 ){
                                echo arrayString($coleccViajes) ;
                            } else {
                                echo "No hay viajes para mostrar \n" ; 
                            }
                            echo "Ingrese el id del viaje a modificar: ";
                            $idViaje = validarNumero(trim(fgets(STDIN))) ;
                            $viaje = new Viaje();
                            $existe = $viaje->Buscar($idViaje);
                            if($existe) {
                                $responsable = new Responsable() ;
                                $coleccResponsables = $responsable -> listar();
                                if(count($coleccResponsables) > 0 ){
                                    echo arrayString($coleccResponsables) ;
                                } else {
                                    echo "No hay responsables para mostrar \n"; 
                                }
                                echo "Ingrese el nuevo numero de empleado del responsable a cargo: ";
                                $rNroEmpleado = validarNumero(trim(fgets(STDIN))) ;
                                $responsable = new Responsable();
                                $existe = $responsable->buscar($rNroEmpleado);
                                if($existe) {
                                    $empresa = new Empresa() ;
                                    $coleccEmpresas = $empresa -> listar() ;
                                    if(count($coleccEmpresas) > 0 ){
                                        echo arrayString($coleccEmpresas) ;
                                    } else {
                                        echo "No hay empresas para mostrar \n"; 
                                    } 
                                    echo "Ingrese el nuevo ID de la empresa a cargo: ";
                                    $idEmpresa = validarNumero(trim(fgets(STDIN))) ;
                                    $empresa = new Empresa(); 
                                    $existe = $empresa->Buscar($idEmpresa);
                                    if($existe) {
                                        echo "Ingrese el nuevo destino: ";
                                        $destino = validarNombre(trim(fgets(STDIN))) ;
                                        echo "Ingrese nueva cantidad maxima de pasajeros: ";
                                        $cantMaxPasajeros = validarNumero(trim(fgets(STDIN))) ;
                                        echo "Ingrese el nuevo precio del ticket: ";
                                        $precioTicket = validarNumero(trim(fgets(STDIN))) ;
                                        $coleccPasajeros = (new Pasajero()) -> listar();
                                        $existe = $viaje->existeViaje($destino, $idEmpresa, $responsable, $cantMaxPasajeros, $precioTicket);
                                        if(!$existe) {
                                            $viaje->cargar($idViaje, $destino, $cantMaxPasajeros, $empresa, $coleccPasajeros, $responsable, $precioTicket);
                                            $viaje->modificar();
                                        } else {
                                            echo "El viaje ya existe \n";
                                        }                                       
                                    } else {
                                        echo "La empresa no fue encontrada \n";
                                    }
                                } else {
                                    echo "El responsable no fue encontrado \n";
                                }
                            } else {
                                echo "El viaje no fue encontrado \n";
                            }
                        break ; 
                        case 3: 
                            /* Eliminar viaje */
                            $viaje = new Viaje() ;
                            $coleccViajes = $viaje -> listar();
                            if(count($coleccViajes) > 0 ){
                                echo arrayString($coleccViajes) ;
                            } else {
                                echo "No hay viajes para mostrar \n" ; 
                            }
                            echo "Ingrese codigo del viaje a eliminar: " ; 
                            $idViaje = validarNumero(trim(fgets(STDIN)));
                            $viaje = new Viaje() ; 
                            $encontro = $viaje -> buscar($idViaje) ; 
                            if($encontro) {
                                $pasajero = new Pasajero();
                                $pasajerosAsociados = $viaje->estaAsociado($pasajero);
                                if(count($pasajerosAsociados) > 0) {
                                    // valido si hay pasajeros asociados a el viaje
                                    echo "ERROR!!! No se puede eliminar el viaje, tiene pasajeros asociados!!! \n";
                                } else {
                                    $borrado = $viaje -> eliminar() ;  
                                    if($borrado) {
                                        echo "El viaje fue eliminado \n" ; 
                                    } else {
                                        echo "Error! el viaje no fue eliminado \n" ;
                                    }
                                }
                            } else {
                                echo "El viaje no fue encontrado \n";
                            }
                        break ;
                        case 4: 
                            /* Ver viajes */
                            $viaje = new Viaje() ;
                            $coleccViajes = $viaje -> listar();
                            if(count($coleccViajes) > 0 ){
                                echo arrayString($coleccViajes) ;
                            } else {
                                echo "No hay viajes para mostrar \n" ; 
                            }
                        break ; 
                    }
                    $opcionViaje = menuViaje() ;
                }
            break ; 
            case 4:   
                /* Despliega el menu para la seccion de pasajero */
                $opcionPasajero = menuPasajero() ; 
                while($opcionPasajero <> 5) {
                    switch($opcionPasajero) {
                        case 1:
                            /* Crear pasajero */
                            $viaje = new Viaje() ;
                            $coleccViajes = $viaje -> listar();
                            if(count($coleccViajes) > 0 ){
                                echo arrayString($coleccViajes) ;
                            } else {
                                echo "No hay viajes para mostrar \n" ; 
                            }
                            echo "Ingrese id de viaje: ";
                            $idViaje = validarNumero(trim(fgets(STDIN)));
                            $viaje = new Viaje();
                            $existeViaje = $viaje->Buscar($idViaje);
                            if($existeViaje) {
                                echo "Ingrese nombre del pasajero: ";
                                $nombrePasaj = validarNombre(trim(fgets(STDIN)));
                                echo "Ingrese apellido del pasajero: ";
                                $apellPasaj = validarNombre(trim(fgets(STDIN)));
                                echo "Ingrese dni del pasajero: ";
                                $dni = validarNumero(trim(fgets(STDIN)));
                                echo "Ingrese numero de telefono del pasajero: ";
                                $numeroTelef = validarNumero(trim(fgets(STDIN)));
                                $pasajero = new Pasajero();
                                $persona = new Persona();
                                // Verifico si el pasajero ya existe en la base de datos
                                $existePasajero = $pasajero->Buscar($dni);
                                if(!$existePasajero) {
                                    $vendido = $viaje->venderPasaje($pasajero);
                                    if($vendido) {
                                        // Verifico que el pasajero no esté en el viaje
                                        if(!$persona->existePasajeroEnViaje($dni, $idViaje)) {
                                            echo "Pasaje Vendido!\n";
                                            $pasajero->cargar($nombrePasaj, $apellPasaj, $dni, $numeroTelef, $viaje);
                                            $pasajero->insertar();
                                            $pasajeroViaje = new Pasajero_Viaje();
                                            $pasajeroViaje->cargar($idViaje, $pasajero);
                                            $pasajeroViaje->insertar();
                                        } else {
                                            echo "Ya has comprado un boleto para este viaje.\n";
                                        }
                                    } else {
                                        echo "No hay pasajes disponibles para este viaje.\n";
                                    }
                                } else {
                                    if(!$persona->existePasajeroEnViaje($dni, $idViaje)) {
                                        $pasajeroViaje = new Pasajero_Viaje();
                                        $pasajeroViaje->cargar($idViaje, $pasajero);
                                        $pasajeroViaje->insertar();
                                        echo "Pasaje Vendido!\n";
                                    } else {
                                        echo "El pasajero ya está registrado en este viaje.\n";
                                    }
                                }
                            } else {
                                echo "El viaje no fue encontrado, creación del pasajero cancelada.\n";
                            }
                        break;
                        case 2: 
                            /* Modificar pasajero */
                            echo "Ingrese numero de documento del pasajero a modificar: ";
                            $dni = validarNumero(trim(fgets(STDIN))) ;
                            $pasajero = new Pasajero();
                            $existe = $pasajero->Buscar($dni);
                            if($existe) {
                                echo "Ingrese id de viaje: " ; 
                                $idViaje = trim(fgets(STDIN)) ;
                                $viaje = new Viaje() ;
                                $existe = $viaje->Buscar($idViaje) ;
                                if($existe) {
                                    echo "Ingrese nuevo nombre del pasajero: ";
                                    $nombrePasaj = validarNombre(trim(fgets(STDIN))) ;
                                    echo "Ingrese nuevo apellido del pasajero: ";
                                    $apellPasaj = validarNombre(trim(fgets(STDIN))) ;
                                    echo "Ingrese nuevo numero de telefono del pasajero: ";
                                    $numeroTelef = validarNumero(trim(fgets(STDIN))) ;
                                    $pasajero = new Pasajero();
                                    $existe = $pasajero->existePersona($nombrePasaj, $apellPasaj, $dni, $idViaje);
                                    if(!$existe) {
                                        $pasajero->cargar(0, $nombrePasaj, $apellPasaj, $dni, $numeroTelef, $viaje);
                                        $pasajero->modificar();
                                    } else {
                                        echo "El pasajero ya existe en ese viaje \n";
                                    }
                                } else {
                                    echo "El viaje no fue encontrado \n";
                                }
                            } else {
                                echo "El pasajero no fue encontrado \n";
                            }
                        break ; 
                        case 3: 
                            /* Eliminar pasajero */
                            echo "Ingrese el numero de documento del pasajero a eliminar: " ; 
                            $dni = validarNumero(trim(fgets(STDIN))) ;
                            $pasajero = new Pasajero() ; 
                            $encontro = $pasajero -> Buscar($dni) ; 
                            if($encontro) {
                                $borrado = $pasajero -> eliminar() ; 
                                if($borrado) {
                                    echo "El pasajero fue eliminado \n" ; 
                                } else {
                                    echo "Error! el pasajero no fue eliminado \n" ;
                                }  
                            } else {
                                echo "El pasajero no fue encontrado \n";
                            }
                        break ;
                        case 4: 
                            /* Ver pasajeros */
                            $pasajero = new Pasajero() ;
                            $coleccPasajeros = $pasajero -> listar() ;
                            if(count($coleccPasajeros) > 0 ){
                                echo arrayString($coleccPasajeros) ;
                            } else {
                                echo "No hay pasajeros para mostrar \n" ; 
                            }
                        break ; 
                    } 
                    $opcionPasajero = menuPasajero() ; 
                }   
            break ; 
        }
    } while($opcion <> 5) ;