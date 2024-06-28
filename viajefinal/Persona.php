<?php
include_once ('BaseDatos.php');

class Persona{
    private $nombre;
    private $apellido;
    private $nroDoc;
    private $msjoperacion;

    public function __construct(){
        $this->nombre = "";
        $this->apellido = "";
        $this->nroDoc = "";
    }

    public function cargar($nombre, $apellido,$nroDoc){
        $this->setNombre($nombre);
        $this->setApellido($apellido);
        $this->setNrodoc($nroDoc);
    }
   
    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    public function getNroDoc()
    {
        return $this->nroDoc;
    }

    public function setNroDoc($nroDoc)
    {
        $this->nroDoc = $nroDoc;
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
        return "Nombre: " . $this->getNombre() . "\n" .
            "Apellido: " . $this->getApellido() . "\n".
            "Documento: " . $this->getNroDoc() . "\n";

    }

    public function insertar(){
        $base = new BaseDatos();
        $msj = false;
        $consultaInsertar = "INSERT INTO persona(nombre, apellido ,nrodocumento) VALUES (
            '"  . $this->getNombre() . "',
            '" . $this->getApellido() . "',
            '" . $this->getNroDoc() . "'
            )";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaInsertar)) {
                $msj = true;
            } else{
                $this->setMsjoperacion($base->getError());
            }
        } else {
            $this->setMsjoperacion($base->getError());
        }
        return $msj;
    }

    public function modificar(){
        $base = new BaseDatos;
        $msj = false;
        $consultaModificar = 
        "UPDATE persona 
        SET nombre = '" . $this->getNombre() . "',
        apellido = '" . $this->getApellido() . "' 
        WHERE nrodocumento = '" . $this->getNroDoc() . "'";
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

    public function eliminar(){
        $base = new BaseDatos;
        $msj = false;
        $consultaError = 
        "DELETE FROM persona
        WHERE nrodocumento = '". $this->getNroDoc()."'";
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

    public function buscar($nroDocumento){
        $base=new BaseDatos();
        $encontrado=false;
        $consulta="SELECT * FROM persona WHERE nrodocumento='".$nroDocumento."'";
        if($base->iniciar()){            
            if($base->ejecutar($consulta)){
                /*while*/ if($registro=$base->registro()){
                    $this->setNroDoc($registro['nrodocumento']);
                    $this->setNombre($registro['nombre']);
                    $this->setApellido($registro['apellido']);
                    $encontrado=true;
                }
            }else{
                $this->setMsjOperacion($base->getError());
            }
        }else{
            $this->setMsjOperacion($base->getError());
        }
        return $encontrado;
    }

    public function listar($condicion){
	    $arregloPersonas = null;
		$base=new BaseDatos();
		$consultaPersona="Select * from persona ";
		 if ($condicion!=""){
		     $consultaPersona=$consultaPersona.' where '.$condicion;
		}
		$consultaPersona.=" order by nrodocumento ";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){				
				$arregloPersonas= array();
				while($fila=$base->Registro()){
				    $nombre=$fila['nombre'];
					$apellido=$fila['apellido'];
					$documento=$fila['nrodocumento'];
                    $persona = new Persona;
					$persona->cargar($nombre,$apellido, $documento);
					$persona->setNroDoc($documento);
					array_push($arregloPersonas,$persona);	
				}							
		 	} else {
		 		$this->setmsjOperacion($base->getError());		 		
			}
		} else {
		 	$this->setmsjOperacion($base->getError());		 	
		}	
		return $arregloPersonas;
	}







}