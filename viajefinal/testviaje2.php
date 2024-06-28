<?php

include_once 'BaseDatos.php';
include_once 'Persona.php';
include_once 'Responsable.php';
include_once 'Pasajero.php';
include_once 'Empresa.php';
include_once 'Viaje.php';

do {
    echo "********************************\n";
    echo "-----Empresa de Transporte-----\n";
    echo "1. Menú Empresa\n";
    echo "2. Menú Viaje\n";
    echo "3. Salir\n";
    echo "----------------------\n";
    echo "Opcion: ";
    $opcionElegida = trim(fgets(STDIN));
    switch ($opcionElegida) {
        case 1:
            menuEmpresa();
            break;

        case 2:
            menuViaje();
            break;
        case 3:
            echo "Saliendo\n";
            break;

       
        default:
            echo "Opción no válida. Por favor, elige una opción válida.\n";
    }
} while ($opcionElegida != 4);

function menuEmpresa()
{
    do {
        echo "---------- Menú de EMPRESA ----------\n";
        echo "1- Insertar los datos de la empresa\n";
        echo "2- Modificar los datos de la empresa\n";
        echo "3- Eliminar los datos de la empresa\n";
        echo "4- Buscar una empresa\n";
        echo "5- Volver\n";
        echo "----------------------\n";
        echo "Opcion: ";
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case 1:
                ingresarEmpresa();
                break;

            case 2:
                modificarEmpresa();

                break;
            case 3:
                eliminarEmpresa();
                break;
            case 4:
                buscarEmpresa();
                break;
            case 5:
                
                break;
            default:
                echo "Opción no válida. Por favor, selecciona 1, 2, 3,4 o 5.\n";
                break;
        }
    } while ($opcion != 5);
}

function insertarEmpresa($nombreE, $direccionE)
{
    $empresa = new Empresa();
    $empresa->cargar($nombreE, $direccionE);
    return $empresa->insertar();
}

function ingresarEmpresa()
{ //la consigna habla de una sola empresa de viajes, asi que deberia añadir que si ya existe una no permitir añadir mas, solo modificar (?) >> No restringe si ya existe con el mismo nombre y dirección, el AUTO_INCREMENT de la BD no permite reutilizar un ID aunque se haya borrado.
    echo "\n------------------------------" . "\n";
    echo "Ingrese el nombre de la empresa: ";
    $nombreE = trim(fgets(STDIN));
    echo "Ingrese la dirección de la empresa: ";
    $direccionE = trim(fgets(STDIN));
    // $empresa = new Empresa();
    // $empresa->cargar($nombreE, $direccionE);
    // $empresa->insertar();
    $empresa = insertarEmpresa($nombreE, $direccionE);
    if ($empresa/*->insertar()*/) {
        echo "Empresa insertada correctamente.\n";
    } else {
        echo "Error al insertar la empresa: " . /*$empresa->getMsjOperacion() .*/ "\n";
    }
    echo "\n---------------------------------*" . "\n";
    // FUNCIONA PERO DUPLICA EMPRESA (EJEMPLO CARGO UNA EMPRESA Y SE CARGAN 2 IDENTICAS) >> ARREGLADO Y YA NO DUPLICA LA CARGA
}

function modificarEmpresa()
{
    echo "Ingrese el ID de la empresa a modificar: ";
    $id = trim(fgets(STDIN));
    $empresa = new Empresa();
    echo "\n---------------------------------*" . "\n";
    if ($empresa->buscar($id)) {
        echo "Empresa encontrada:\n" . $empresa;

        // Pregunta si deseas modificar el nombre de la empresa
        while (true) {
            echo "¿Deseas modificar el nombre de la empresa? (Sí/No): ";
            $modificarNombre = trim(fgets(STDIN));
            if (strtolower($modificarNombre) === 'si') {
                echo "Ingrese el nuevo nombre de la empresa: ";
                $nombreE = trim(fgets(STDIN));
                $empresa->setNombre($nombreE);
                $empresa->modificar();
                break;
            } elseif (strtolower($modificarNombre) === 'no') {
                break;
            } else {
                echo "Respuesta no válida. Por favor, ingresa 'Sí' o 'No'.\n";
            }
        }

        // Pregunta si deseas modificar la dirección de la empresa
        while (true) {
            echo "¿Deseas modificar la dirección de la empresa? (Sí/No): ";
            $modificarDireccion = trim(fgets(STDIN));
            if (strtolower($modificarDireccion) === 'si') {
                echo "Ingrese la nueva dirección de la empresa: ";
                $direccionE = trim(fgets(STDIN));
                $empresa->setDireccion($direccionE);
                $empresa->modificar();
                break;
            } elseif (strtolower($modificarDireccion) === 'no') {
                break;
            } else {
                echo "Respuesta no válida. Por favor, ingresa 'Sí' o 'No'.\n";
            }
        }
    }
}

function eliminarEmpresa()
{ //No estoy seguro > NO FUNCIONA > ¿Funciona? > ¡Funcionó!
    echo "Ingrese el ID de la empresa para eliminar: ";
    $id = trim(fgets(STDIN));
    $empresa = new Empresa();
    if ($empresa->buscar($id)) {
        $empresa->eliminar();
        echo "Empresa eliminada con exito.\n";
    } else {
        echo "Error en la eliminacion: " . $empresa->getMsjOperacion() . "\n";
    }
    echo "\n--------------------------------------" . "\n";
}

function buscarEmpresa()
{
    echo "Ingrese el ID de la empresa a buscar: ";
    $id = trim(fgets(STDIN));
    $empresa = new Empresa();
    echo "\n---------------------------------*" . "\n";
    if ($empresa->buscar($id)) {
        echo "Empresa encontrada:\n" . $empresa;
        echo "\n---------------------------------*" . "\n";
    } else {
        echo "Empresa no encontrada." . "\n";
        echo "\n---------------------------------*" . "\n";
    }
}


function menuViaje()
{


    do {
        echo "************* Menú de VIAJES ************\n";
        echo "1. Ingresar un Viaje\n";
        echo "2. Modificar un Viaje\n";
        echo "3. Eliminar un Viaje\n";
        echo "4. Ver todos los viajes \n";
        echo "5. Panel de pasajero/s \n";
        echo "6. Panel de responsable/s \n";
        echo "7. VOLVER\n";
        echo "----------------------\n";
        echo "Opcion: ";
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case 1:
                añadirViaje();
                break;
            case 2:
                modificarViaje();
                break;
            case 3:
                eliminarViaje();
                break;

            case 4:

                
                $obP = new Viaje;
                $arrP = $obP->listar('');
                
                if (count($arrP) === 0) {
                    echo "No hay viajes registrados aún. \n";
                } else 
                
                {
                    echo "------------- Viaje ----------- \n";
                    foreach ($arrP as $via) {
                        echo $via;
                    }
                }
                break;    
            case 5:
                menuPasajero();
                break;
            case 6:
                menuResponsable();
                break;
            case 7:
                
                break;
            default:
                echo "Opción no válida, intente otra vez.\n";
                break;
        }
    } while ($opcion != 7);
}

function insertarViaje($destino, $cantMaxPasajeros, $objEmpresa, $objResponsable, $importe, $colPasajeros)
{
    $viaje = new Viaje;
    $viaje->cargar($destino, $cantMaxPasajeros, $importe, $objEmpresa, $objResponsable, $colPasajeros);
    $viajeInsertado = $viaje->insertar();
    foreach ($colPasajeros as $pasajero) {
        $pasajero->setObjViaje($viaje);
        $pasajero->modificar();
    };
    return $viajeInsertado;
}

function añadirViaje()
{
    echo "\n---------------------------" . "\n";
    echo "Destino del viaje:";
    $destino = trim(fgets(STDIN));
    echo "Ingresar la cantidad máxima de pasajeros: ";
    $cantMaxPasajeros = trim(fgets(STDIN));
    echo "Ingrese documento de los pasajeros asignados al viaje: ";
    $colPasajeros = [];
    $i = 1;
    while ($i <= $cantMaxPasajeros) {
        echo "Pasajero $i (o ingresa 0 para omitirlo): ";
        $documentoPasajero = trim(fgets(STDIN));

        if ($documentoPasajero === '0') {
            break;
        }

        $pasajero = new Pasajero;
        if ($pasajero->buscar($documentoPasajero)) {
            // Verificar si el pasajero ya está en la colección
            $pasajeroDuplicado = false;
            foreach ($colPasajeros as $p) {
                if ($p->getNroDoc() === $pasajero->getNroDoc()) {
                    $pasajeroDuplicado = true;
                    break;
                }
            }

            if (!$pasajeroDuplicado) {
                echo "Pasajero encontrado:\n" . $pasajero;
                echo "\n---------------------------------\n";
                // $pasajero->modificar();
                array_push($colPasajeros, $pasajero);
                $i++;
            } else {
                echo "Este pasajero ya ha sido añadido previamente.\n";
            }
        } else {
            echo "Pasajero no encontrado, ingrese otro documento.\n";
            echo "\n---------------------------------\n";
        }
    }
    echo "Ingresar el ID de la empresa: ";
    $idEmpresa = trim(fgets(STDIN));
    $empresa = new Empresa();
    $empresa->buscar($idEmpresa);
    if ($empresa->buscar($idEmpresa)) {
        echo "Ingresar el Nro del Responsable a cargo: ";
        $nroEmpleado = trim(fgets(STDIN));
        $responsable = new Responsable();
        $responsable->buscar($nroEmpleado);
        if ($responsable->buscar($nroEmpleado)) {
            echo "Ingresar el valor del viaje: ";
            $importeV = trim(fgets(STDIN));
            $viaje = insertarViaje($destino, $cantMaxPasajeros, $empresa, $responsable, $importeV, $colPasajeros);
        } else {
            echo "No hay responsable con ese numero\n";
        }
    } else {
        echo "Empresa no existe\n";
    }

    //CREAR LISTAR, AGREGAR TODOS LOS LISTAR, SACAR DE PASAJERO Y RESPONSABLE

    if (isset($viaje)) {
        // if($responsable->buscar($nroEmpleado)){
        //     $viaje = new Viaje();
        //     $viaje->cargar($destino,$cantMaxPasajeros,$empresa,$responsable,$importeV);

        //     if ($viaje->insertar()) {
        echo "Viaje añadido con exito.\n";
    } else {
        echo "Error al añadir el Viaje" . /*$viaje->getMsjOperacion() .*/ "\n";
    }
    //     }else{
    //         echo $responsable->getMsjOperacion();
    //         echo "No se ha encontrado el responsable\n";
    //     }
    // }else{
    //     echo "No se ha encontrado la empresa\n";
    // }
    echo "\n---------------------------------------" . "\n";
}


function cambiarViaje($objViaje, $destino, $cantMaxPasajeros, $objEmpresa, $objResponsable, $importe, $colPasajeros)
{
    $viaje = $objViaje;
    $viaje->cargar($destino, $cantMaxPasajeros, $importe, $objEmpresa, $objResponsable, $colPasajeros);
    return $viaje->modificar();
}

function modificarViaje()
{
    echo "Ingrese el ID del Viaje a modificar: ";
    $idViaje = trim(fgets(STDIN));
    $viaje = new Viaje();
    echo "\n------------------------------------------" . "\n";
    if ($viaje->buscar($idViaje)) {
        echo "Viaje encontrado:\n" . $viaje;
        echo "\n------------------------------" . "\n";
        echo "Ingrese el nuevo destino: ";
        $destino = trim(fgets(STDIN));
        echo "Ingrese la nueva cantidad maxima de pasajeros: ";
        $cantMaxPasajeros = trim(fgets(STDIN));
        echo "¿Desea incluir pasajeros? Si/No: ";
        $incluirPasajeros = trim(fgets(STDIN));
        if ($incluirPasajeros == "si") {
            echo "Ingrese documento de los pasajeros asignados al viaje: ";
            $colPasajeros = [];
            $i = 1;
            do {
                echo "Pasajero " . $i . ": ";
                $documentoPasajero = trim(fgets(STDIN));
                $pasajero = new Pasajero;
                if ($pasajero->buscar($documentoPasajero)) {
                    echo "Pasajero encontrado:\n" . $pasajero;
                    echo "\n---------------------------------*" . "\n";
                    $pasajero->setObjViaje($viaje);
                    $pasajero->modificar();
                    array_push($colPasajeros, $pasajero);
                    $i++;
                } else {
                    echo "Pasajero no encontrado, ingrese otro documento." . "\n";
                    echo "\n---------------------------------*" . "\n";
                }
            } while ($i <= $cantMaxPasajeros);
        } else {
            $colPasajeros = [];
        }
        echo "Ingrese el nuevo numero de empleado del Responsable: ";
        $nroEmpleado = trim(fgets(STDIN));
        $responsable = new Responsable;
        if ($responsable->buscar($nroEmpleado)) {
            echo "Responable seleccionado: \n" . $responsable;
            echo "Ingrese el ID de la empresa: ";
            $idEmpresa = trim(fgets(STDIN));
            $empresa = new Empresa;
            if ($empresa->buscar($idEmpresa)) {
                echo "Empresa seleccionada :\n" . $empresa;
                echo "Ingrese el nuevo costo: ";
                $importe = trim(fgets(STDIN));
                $modificacion = cambiarViaje($viaje, $destino, $cantMaxPasajeros, $empresa, $responsable, $importe, $colPasajeros);
                if ($modificacion) {
                    echo "\n------------------------------------------" . "\n";
                    echo "Viaje modificado con exito.\n" .
                        "\n------------------------------------------" . "\n" .
                        $viaje;
                }
            } else {
                echo "Empresa no existe\n";
            }
        } else {
            echo "no hay responsable con ese numero\n";
        }
    }
    echo "\n--------------------------------------" . "\n";

 
}

function eliminarViaje()
{
    echo "Ingrese el ID del Viaje a eliminar: ";
    $idViaje = trim(fgets(STDIN));
    $viaje = new Viaje();

    if ($viaje->buscar($idViaje)) {
        $viaje->eliminar();
        echo "Viaje eliminado correctamente.\n";
    } else {
        echo "El Viaje no existe\n";
    }
    echo "\n--------------------------------------" . "\n";
}

function menuPasajero()
{


    do {
        echo "************* Menú de PASAJEROS ************\n";
        echo "1. Ingresar un pasajero\n";
        echo "2. Modificar un pasajero\n";
        echo "3. Eliminar un pasajero\n";
        echo "4. Ver datos de un pasajero \n";
        echo "5. VOLVER \n";
        echo "----------------------\n";
        echo "Opcion: ";
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case 1:
                añadirPasajero();
                break;
            case 2:
                modificarPasajero();
                break;
            case 3:
                eliminarPasajero();
                break;
            case 4:
                mostrarPasajero();
                break;
            case 5:
                echo "Saliendo\n";
                break;
            default:
                echo "Opción no válida, intente otra vez.\n";
                break;
        }
    } while ($opcion != 5);
}

function incorporarPasajero($objPasajero, $nombre, $apellido, $dni, $telefono, $objViaje)
{
    $pasajero = $objPasajero;
    $pasajero->cargar($nombre, $apellido, $dni, $telefono, $objViaje);
    return $pasajero->insertar();
}

function añadirPasajero()
{
    echo "\n---------------------------" . "\n";
    echo "Ingresa el nombre del pasajero: ";
    $nombre = trim(fgets(STDIN));
    echo "Ingresa el apellido del pasajero: ";
    $apellido = trim(fgets(STDIN));
    echo "Ingresa el número de documento del pasajero: ";
    $documento = trim(fgets(STDIN));
    echo "Ingresa el número de teléfono del pasajero: ";
    $telefono = trim(fgets(STDIN));
    echo "Ingresa el id de viaje del pasajero: ";
    $idViaje = trim(fgets(STDIN));

    $objViaje = new Viaje;
    
    if ($objViaje->buscar($idViaje)) {
        $pasajero = new Pasajero();
        $incorporacion = incorporarPasajero($pasajero, $nombre, $apellido, $documento, $telefono, $objViaje);
        if ($incorporacion) {
            echo "\n Pasajero cargado\n" . $pasajero;
        } else {
            echo "No se ha podido añadir el pasajero \n";
        }
    } else {
        $pasajero = new Pasajero();
        echo "No existe un viaje con ese id\n";
        echo "El pasajero será cargado sin un viaje asignado";
        $objViaje->setIdViaje("null");
        $incorporacion = incorporarPasajero($pasajero, $nombre, $apellido, $documento, $telefono, $objViaje);
    }
    echo "\n---------------------------" . "\n";
}

function cambiarPasajero($objPasajero, $nombre, $apellido, $telefono, $objViaje)
{
    $pasajero = $objPasajero;
    $pasajero->setNombre($nombre);
    $pasajero->setApellido($apellido);
    $pasajero->setTelefono($telefono);
    $pasajero->setObjViaje($objViaje);

    return $pasajero->modificar();
}

function modificarPasajero()
{
    echo "Ingrese el documento del pasajero a modificar: ";
    $documentoPasajero = trim(fgets(STDIN));
    $pasajero = new Pasajero;
    echo "\n---------------------------------*" . "\n";
    if ($pasajero->buscar($documentoPasajero)) {
        echo "Pasajero encontrado:\n" . $pasajero;
        echo "\n---------------------------------*" . "\n";
        echo "Ingresa el nombre del pasajero: ";
        $nombre = trim(fgets(STDIN));
        echo "Ingresa el apellido del pasajero: ";
        $apellido = trim(fgets(STDIN));
        echo "Ingresa el número de teléfono del pasajero: ";
        $telefono = trim(fgets(STDIN));
        echo "Ingresa el id de viaje del pasajero: ";
        $idViaje = trim(fgets(STDIN));
        $objViaje = new Viaje;
        if ($objViaje->buscar($idViaje)) {
            $modificacion = cambiarPasajero($pasajero, $nombre, $apellido, $telefono, $objViaje);
            if ($modificacion) {
                echo "\nPasajero modificado\n" . $pasajero;
            }
        } else {
            echo "El viaje no existe." . "\n";
            echo "El pasajero fue modificado sin un viaje asignado";
            $objViaje->setIdViaje("null");
            $modificacion = cambiarPasajero($pasajero, $nombre, $apellido, $telefono, $objViaje);
        }
    } else {
        echo "El pasajero no existe." . "\n";
    }
    echo "\n---------------------------------*" . "\n";
}

function borrarPasajero($dni)
{
    $pasajero = new Pasajero();
    $pasajero->buscar($dni);
    return $pasajero->eliminar();
}

function eliminarPasajero()
{
    echo "Ingrese el documento del pasajero a eliminar: ";
    $documentoPasajero = trim(fgets(STDIN));
    $pasajero = borrarPasajero($documentoPasajero);
    if ($pasajero/*->buscar($documentoPasajero)*/) {
        // $pasajero->eliminar();
        echo "Pasajero eliminado correctamente.\n";
    } else {
        echo "El pasajero no existe\n";
    }
    echo "\n--------------------------------------" . "\n";
}


function mostrarPasajero()
{
    echo "Ingrese el documento del pasajero a mostrar: ";
    $documentoPasajero = trim(fgets(STDIN));
    $pasajero = new Pasajero();
    echo "\n---------------------------------*" . "\n";
    if ($pasajero->buscar($documentoPasajero)) {
        echo "Pasajero encontrado:\n" . $pasajero;
        echo "\n---------------------------------*" . "\n";
    } else {
        echo "Pasajero no encontrado." . "\n";
        echo "\n---------------------------------*" . "\n";
    }
}


function menuResponsable()
{


    do {
        echo "************* Menú de RESPONSABLE ************\n";
        echo "1. Ingresar un responsable\n";
        echo "2. Modificar un responsable\n";
        echo "3. Eliminar un responsable\n";
        echo "4. Ver datos de un responsable \n";
        echo "5. VOLVER \n";
        echo "----------------------\n";
        echo "Opcion: ";
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case 1:
                añadirResponsable();
                break;
            case 2:
                modificarResponsable();
                break;
            case 3:
                eliminarResponsable();
                break;
            case 4:
                mostrarResponsable();
                break;
            case 5:
                
                break;
            default:
                echo "Opción no válida, intente otra vez.\n";
                break;
        }
    } while ($opcion != 5);
}

function incorporarResponsable($objResponsable, $nombre, $apellido, $nroDoc, $numeroLicencia)
{
    $responsable = $objResponsable;
    $responsable->cargar($nombre, $apellido, $nroDoc, $numeroLicencia);
    return $responsable->insertar();
}

function añadirResponsable()
{
    echo "\n---------------------------" . "\n";
    $responsable = new Responsable();
    echo "Ingresa el nombre del responsable: ";
    $nombre = trim(fgets(STDIN));
    echo "Ingresa el apellido del responsable: ";
    $apellido = trim(fgets(STDIN));
    echo "Ingresa el número de documento del responsable: ";
    $documento = trim(fgets(STDIN));
    echo "Ingresa el número de licencia del responsable: ";
    $licencia = trim(fgets(STDIN));
    $incorporacion = incorporarResponsable($responsable, $nombre, $apellido, $documento, $licencia);
    if ($incorporacion) {
        echo "\nResponsable cargado\n" . $responsable;
    } else {
        echo "No se ha podido añadir el responsable \n";
    }
    echo "\n---------------------------" . "\n";
}

function cambiarResponsable($objResponsable, $nombre, $apellido, $numeroLicencia)
{
    $responsable = $objResponsable;
    $responsable->setNombre($nombre);
    $responsable->setApellido($apellido);
    $responsable->setNumeroLicencia($numeroLicencia);
    return $responsable->modificar();
}

function modificarResponsable()
{
    echo "Ingrese el número de empleado del responsable a modificar: ";
    $numeroResponsable = trim(fgets(STDIN));
    $responsable = new Responsable;
    echo "\n---------------------------------*" . "\n";
    if ($responsable->buscar($numeroResponsable)) {
        echo "Responsable encontrado:\n" . $responsable;
        echo "\n---------------------------------*" . "\n";
        echo "Ingresa el nombre del responsable: ";
        $nombre = trim(fgets(STDIN));
        echo "Ingresa el apellido del responsable: ";
        $apellido = trim(fgets(STDIN));
        echo "Ingresa el número de licencia del responsable: ";
        $licencia = trim(fgets(STDIN));
        $modificacion = cambiarResponsable($responsable, $nombre, $apellido, $licencia);
        if ($modificacion) {
            echo "\nResponsable modificado\n" . $responsable;
        }
    } else {
        echo "El responsable no existe." . "\n";
    }
    echo "\n---------------------------------*" . "\n";
}

function borrarResponsable($numeroResponsable)
{
    $responsable = new Responsable();
    $responsable->buscar($numeroResponsable);
    return $responsable->eliminar();
}

function eliminarResponsable()
{
    echo "Ingrese el número de empleado del responsable a eliminar: ";
    $numeroResponsable = trim(fgets(STDIN));
    $responsable = borrarResponsable($numeroResponsable);
    if ($responsable/*->buscar($documentoPasajero)*/) {
        // $pasajero->eliminar();
        echo "Responsable eliminado correctamente.\n";
    } else {
        echo "El responsable no existe\n";
    }
    echo "\n--------------------------------------" . "\n";
}


function mostrarResponsable()
{
    echo "Ingrese el número de empleado del responsable a mostrar: ";
    $numeroResponsable = trim(fgets(STDIN));
    $responsable = new Responsable();
    echo "\n---------------------------------*" . "\n";
    if ($responsable->buscar($numeroResponsable)) {
        echo "Responable encontrado:\n" . $responsable;
        echo "\n---------------------------------*" . "\n";
    } else {
        echo "Responable no encontrado." . "\n";
        echo "\n---------------------------------*" . "\n";
    }
}
