<?php

// include_once ('./Viaje.php');

class Pasajero extends Persona
{
    private $telefono;
    private $objViaje;
    private $msjoperacion;

    public function __construct()
    {
        parent::__construct();
        $this->telefono = 0;
        // $this->objViaje = 0;
    }

    public function cargar($nombre, $apellido, $nrodoc, $telefono = null, $objViaje = null)
    {   //Si borro los "= 0" sale el error que no es compatible con el método (error P1038), agregandolos aparentemente no afecta el funcionamiento del programa
        parent::cargar($nombre, $apellido, $nrodoc);
        $this->setTelefono($telefono);
        $this->setObjViaje($objViaje);
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function getObjViaje()
    {
        return $this->objViaje;
    }

    public function setObjViaje($objViaje)
    {
        $this->objViaje = $objViaje;
    }

    public function getMsjoperacion()
    {
        return $this->msjoperacion;
    }

    public function setMsjoperacion($msjoperacion)
    {
        $this->msjoperacion = $msjoperacion;
    }

    public function __toString()
    {
        $cadena = parent::__toString();
        $cadena .=  "Teléfono: " . $this->getTelefono() . "\n" .
            "Id de viaje: " . $this->getObjViaje()->getIdViaje() . "\n";
        return $cadena;
    }

    public function insertar()
    {
        $base = new BaseDatos;
        $msj = false;
        if (parent::insertar()) {
            $consultaInsertar =
                "INSERT INTO pasajero(pdocumento, ptelefono, idviaje)
            VALUES ('" . $this->getNroDoc() . "',
            " . $this->getTelefono() . ",
            " . $this->getObjViaje()->getIdViaje() . ")";
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaInsertar)) {
                    $msj = true;
                } else {
                    $this->setMsjoperacion($base->getError());
                }
            } else {
                $this->setMsjoperacion($base->getError());
            }
        }
        return $msj;
    }

    public function modificar()
    {
        $base = new BaseDatos;
        $msj = false;
        if (parent::modificar()) {
            $consultaModificar =
            "UPDATE pasajero SET 
            ptelefono=" . $this->getTelefono() . ",
            idviaje = " . $this->getObjViaje()->getIdViaje() .
            " WHERE pdocumento= '". $this->getNroDoc()."'";
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaModificar)) {
                    $msj =  true;
                } else {
                    $this->setMsjoperacion($base->getError());
                }
            } else {
                $this->setMsjoperacion($base->getError());
            }
        }
        return $msj;
    }

    public function eliminar()
    {
        $base = new BaseDatos;
        $msj = false;
        $consultaEliminar =
        "DELETE FROM pasajero WHERE pdocumento = '" . $this->getNroDoc() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaEliminar)) {
                if (parent::eliminar()) {
                    $msj = true;
                }
            } else {
                $this->setMsjoperacion($base->getError());
            }
        } else {
            $this->setMsjoperacion($base->getError());
        }
        return $msj;
    }

    public function buscar($nrodoc)
    {
        $base = new BaseDatos;
        $consultaBuscar = "SELECT * FROM pasajero WHERE pdocumento='" . $nrodoc . "'";
        $encontrado = false;
        if ($base->iniciar()) {
            if ($base->ejecutar($consultaBuscar)) {
                if ($registro = $base->registro()) {
                    parent::buscar($registro['pdocumento']);
                    $this->setTelefono($registro['ptelefono']);
                    $viaje = new Viaje;
                    $viaje->buscar($registro['idviaje']);
                    $this->setObjViaje($viaje);
                    $encontrado = true;
                }
            } else {
                $this->setMsjoperacion($base->getError());
            }
        } else {
            $this->setMsjoperacion($base->getError());
        }
        return $encontrado;
    }

    public function listar($condicion){
	    $arregloPasajeros = null;
		$base=new BaseDatos();
		$consultaPersona="Select * from pasajero ";
		if ($condicion!=""){
		    $consultaPersona=$consultaPersona.' where '.$condicion;
		}
		$consultaPersona.=" order by pdocumento ";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){				
				$arregloPasajeros= array();
				while($fila=$base->Registro()){
                    $telefono=$fila['ptelefono'];
                    $idviaje = new Viaje;
                    $idviaje->buscar($fila['idviaje']);					
					$documento=$fila['pdocumento'];
                    $pasajero = new Pasajero;
                    $persona = new Persona;
                    $persona->buscar($documento);
                    $pasajero->cargar($persona->getNombre(), $persona->getApellido(),$documento,$telefono,$idviaje);					
					array_push($arregloPasajeros,$pasajero);	
				}							
		 	} else {
		 		$this->setmsjOperacion($base->getError());		 		
			}
		} else {
		 	$this->setmsjOperacion($base->getError());		 	
		}	
		return $arregloPasajeros;
	}

    public function buscarViaje($idViaje)
    {
        $base = new BaseDatos;
        $consultaBuscar = "SELECT * FROM pasajero WHERE idviaje='".$idViaje."'";
        $encontrado = false;
        if ($base->iniciar()) {
            if ($base->ejecutar($consultaBuscar)) {
                if ($registro = $base->registro()) {
                    parent::buscar($registro['pdocumento']);
                    $this->setTelefono($registro['ptelefono']);
                    $viaje = new Viaje;
                    $viaje->buscar($registro['idviaje']);
                    $this->setObjViaje($viaje);
                    $encontrado = true;
                }
            } else {
                $this->setMsjoperacion($base->getError());
            }
        } else {
            $this->setMsjoperacion($base->getError());
        }
        return $encontrado;
    }


}
