<?php


class Viaje
{
    private $idViaje;
    private $destino;
    private $cantMaxPasajeros;
    private $objEmpresa;
    private $objResponsable;
    private $importe;
    private $msjoperacion;
    private $colObjPasajeros;

    public function __construct()
    {
        // $this->idViaje = 0;
        $this->destino = "";
        $this->cantMaxPasajeros = 0;
        // $this->objEmpresa = 0;
        // $this->objResponsable = 0;
        $this->importe = 0;
        $this->colObjPasajeros = [];
    }

    public function getIdViaje()
    {
        return $this->idViaje;
    }

    public function setIdViaje($idViaje)
    {
        $this->idViaje = $idViaje;
    }

    public function getDestino()
    {
        return $this->destino;
    }

    public function setDestino($destino)
    {
        $this->destino = $destino;
    }

    public function getCantMaxPasajeros()
    {
        return $this->cantMaxPasajeros;
    }

    public function setCantMaxPasajeros($cantMaxPasajeros)
    {
        $this->cantMaxPasajeros = $cantMaxPasajeros;
    }

    public function getObjEmpresa()
    {
        return $this->objEmpresa;
    }

    public function setObjEmpresa($objEmpresa)
    {
        $this->objEmpresa = $objEmpresa;
    }

    public function getObjResponsable()
    {
        return $this->objResponsable;
    }

    public function setObjResponsable($objResponsable)
    {
        $this->objResponsable = $objResponsable;
    }

    public function getImporte()
    {
        return $this->importe;
    }

    public function setImporte($importe)
    {
        $this->importe = $importe;
    }

    public function getMsjoperacion()
    {
        return $this->msjoperacion;
    }

    public function setMsjoperacion($msjoperacion)
    {
        $this->msjoperacion = $msjoperacion;
    }

    public function getColObjPasajeros()
    {
        return $this->colObjPasajeros;
    }

    public function setColObjPasajeros($colObjPasajeros)
    {
        $this->colObjPasajeros = $colObjPasajeros;

        return $this;
    }

    public function recorrerPasajeros()
    {
        $colPasajeros = $this->getColObjPasajeros();
        $mensaje = "";
        foreach ($colPasajeros as $pasajero){
         $mensaje .= $pasajero . "\n";                 
        }
        return $mensaje;
    }


    public function __toString()
    {
        return
            "Código del viaje: " . $this->getIdViaje() . "\n" .
            "Destino: " . $this->getDestino() . "\n" .
            "Cantidad máxima de pasajeros: " . $this->getCantMaxPasajeros() . "\n" .
            "Pasajeros: \n" . $this->recorrerPasajeros() . "\n" .
            "Empresa: \n" . $this->getObjEmpresa() . "\n" .
            "Número de Responsable: \n" . $this->getObjResponsable() . "\n" .
            "Importe del viaje: " . $this->getImporte() . "\n";
    }


    public function cargar($destino, $cantMaxPasajeros, $importe, $empresa, $responsable, $colObjPasajeros)
    {
        $this->setdestino($destino);
        $this->setcantMaxPasajeros($cantMaxPasajeros);
        $this->setimporte($importe);
        $this->setobjEmpresa($empresa);
        $this->setobjResponsable($responsable);
        $this->setColObjPasajeros($colObjPasajeros);
    }


    public function insertar()
    {
        $base = new BaseDatos;
        $msj = false;
        $consultaInsertar =
            "INSERT INTO viaje (vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte)
        VALUES ('" . $this->getDestino() . "','" . $this->getCantMaxPasajeros() . "','" . $this->getObjEmpresa()->getIdEmpresa() . "','" . $this->getObjResponsable()->getNumeroEmpleado() . "','" . $this->getImporte() . "')";
        if ($base->Iniciar()) {
            if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setIdViaje($id);
                $msj = true;
            } else {
                $this->setMsjoperacion($base->getError());
            }
        } else {
            $this->setMsjoperacion($base->getError());
        }
        return $msj;
    }

    public function modificar()
    {
        $base = new BaseDatos;
        $msj = false;
        $consultaModificar =
            "UPDATE viaje SET 
        vdestino = '" . $this->getDestino() . "', 
        vcantmaxpasajeros = " . $this->getCantMaxPasajeros() . ",
        idempresa = " . $this->getObjEmpresa()->getIdEmpresa() . ",
        rnumeroempleado = " . $this->getObjResponsable()->getNumeroEmpleado() . ",
        vimporte = " . $this->getImporte() . " WHERE idviaje = '" . $this->getIdViaje() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaModificar)) {
                $msj = true;
            } else {
                $this->setMsjoperacion($base->getError());
            }
        } else {
            $this->setMsjoperacion($base->getError());
        }
        return $msj;
    }

    public function eliminar()
    {
        $base = new BaseDatos;
        $msj = false;
        $consultaError =
            "DELETE FROM viaje WHERE idviaje = '" . $this->getIdViaje() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaError)) {
                $msj = true;
            } else {
                $this->setMsjoperacion($base->getError());
            }
        } else {
            $this->setMsjoperacion($base->getError());
        }
        return $msj;
    }



    public function buscar($idViaje)
    {
        $base = new BaseDatos();
        $encontrado = false;
        $consulta = "SELECT * FROM viaje WHERE idviaje=" . "'$idViaje'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                // $empresa=new Empresa();
                // $responsable=new Responsable();
                /*while*/
                if ($registro = $base->Registro()) {
                    $this->setIdViaje($registro['idviaje']);
                    $this->setDestino($registro['vdestino']);
                    $this->setCantMaxPasajeros($registro['vcantmaxpasajeros']);
                    $empresa = new Empresa;
                    $empresa->buscar($registro['idempresa']);
                    $this->setObjEmpresa($empresa);
                    $responsable = new Responsable;
                    $responsable->buscar($registro['rnumeroempleado']);
                    $this->setObjResponsable($responsable);
                    $this->setImporte($registro['vimporte']);
                    $pasajero= new Pasajero;
                    $pasajero->buscar($registro['idviaje']);
                    $encontrado = true;
                }
            } else {
                $this->setMsjOperacion($base->getError());
            }
        } else {
            $this->setMsjOperacion($base->getError());
        }
        return $encontrado;
    }

    public function listar($condicion)
    {

        $arregloViajes = null;
        $base = new BaseDatos();
        $consultaPersona = "Select * from viaje ";
         if ($condicion!=""){
             $consultaPersona=$consultaPersona.' where '.$condicion;
         }
        $consultaPersona .= " order by idviaje ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersona)) {
                $arregloViajes = array();
                $listaPasajeros = [];
                while ($fila = $base->Registro()) {
                    $idViaje = $fila['idviaje'];
                    $destino = $fila['vdestino'];
                    $cantMaxPasajeros = $fila['vcantmaxpasajeros'];
                    $idempresa = $fila['idempresa'];
                    $numEmpleado = $fila['rnumeroempleado'];
                    $importe = $fila['vimporte'];
                    $viaje = new Viaje;
                    $viaje->setIdViaje($idViaje);
                    $viaje->setdestino($destino);
                    $viaje->setcantMaxPasajeros($cantMaxPasajeros);
                    $viaje->setimporte($importe);
                    $empresa = new Empresa;
                    $empresa->buscar($idempresa);
                    $empresa->listar('');
                    $viaje->setobjEmpresa($empresa);
                    $responsable = new Responsable;
                    $responsable->buscar($numEmpleado);
                    $responsable->listar('');
                    $viaje->setobjResponsable($responsable);

                    $pasajeros = new Pasajero;
                    $listadoPasajeros = $pasajeros->listar("idviaje=" . "'$idViaje'");    
                    $viaje->setColObjPasajeros($listadoPasajeros);            

                    array_push($arregloViajes, $viaje);
                }
            } else {
                $this->setmsjOperacion($base->getError());
            }
        } else {
            $this->setmsjOperacion($base->getError());
        }
        return $arregloViajes;
    }



    public function contarPasajeros()
    {
        $colPasajeros = $this->colObjPasajeros;
        $excede = false;
        if (count($colPasajeros) < $this->getCantMaxPasajeros()) {
            $excede = true;
        }
        return $excede;
    }
}
