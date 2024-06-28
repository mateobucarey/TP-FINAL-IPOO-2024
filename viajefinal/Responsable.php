<?php


class Responsable extends Persona{
    private $numeroEmpleado;
    private $numeroLicencia;
    private $msjoperacion;

    public function __construct(){
        parent::__construct();
        $this->numeroEmpleado = 0;
        $this->numeroLicencia = 0;
    }

    public function cargar($nombre, $apellido, $nroDoc, $numeroLicencia = null){
        //Si borro los "= 0" sale el error que no es compatible con el método (error P1038), agregandolos aparentemente no afecta el funcionamiento del programa
        parent::cargar($nombre, $apellido, $nroDoc);
        $this->setNumeroLicencia($numeroLicencia);
    }

    public function getNumeroEmpleado()
    {
        return $this->numeroEmpleado;
    }

    public function setNumeroEmpleado($numeroEmpleado)
    {
        $this->numeroEmpleado = $numeroEmpleado;
    }

    public function getNumeroLicencia()
    {
        return $this->numeroLicencia;
    }

    public function setNumeroLicencia($numeroLicencia)
    {
        $this->numeroLicencia = $numeroLicencia;
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
        $mensaje = parent::__toString();
        $mensaje .= 
        "Número de empleado: " . $this->getNumeroEmpleado() . "\n" .
        "Número de licencia: " . $this->getNumeroLicencia() . "\n";
        return $mensaje;
    }

    public function insertar(){
        $base = new BaseDatos;
        $msj = false;
        if (parent::insertar()) {
            $consultaInsertar = 
            "INSERT INTO responsable(rnumerolicencia, rnrodocumento) VALUES (
                " . $this->getNumeroLicencia() . ",
                '" . $this->getNroDoc() . "')";
            if ($base->Iniciar()) {
                if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
                    $this->setNumeroEmpleado($id);
                    $msj = true;
                } else {
                    $this->setMsjoperacion($base->getError());
                }
            } else{
                $this->setMsjoperacion($base->getError());
            }
        }
        return $msj;
    }

    public function modificar(){
      $base = new BaseDatos;
      $msj = false;
      if (parent::modificar()) {
        $consultaModificar = 
        "UPDATE responsable
        SET rnumerolicencia = ". $this->getNumeroLicencia().", 
        WHERE rnumeroempleado = ". $this->getNumeroEmpleado();
        if($base->Iniciar()){
            if($base->Ejecutar($consultaModificar)){
                $msj=  true;
            }else{
                $this->setMsjoperacion($base->getError());
                
            }
        }else{
            $this->setMsjoperacion($base->getError());
            
        }
    }
    return $msj;
    }

    public function eliminar(){
        $base = new BaseDatos;
        $msj = false;
        $consultaEliminar = "DELETE FROM responsable WHERE rnumeroempleado = ". $this->getNumeroEmpleado();
        if ($base->Iniciar()) {
           
            if ($base->Ejecutar($consultaEliminar)) {
                if (parent::eliminar()) { //revisar si corresponde ese if
                    $msj = true;
                }
            } else {
                $this->setMsjoperacion($base->getError());
            }
        } else{
            $this->setMsjoperacion($base->getError());
        }
        return $msj;
    }

    
    public function buscar($numeroEmpleado){
        $base=new BaseDatos();
        $encontrado=false;
        $consulta="SELECT * FROM responsable WHERE rnumeroempleado=".$numeroEmpleado;
        if($base->iniciar()){            
            if($base->Ejecutar($consulta)){
                /*while*/ if($registro=$base->Registro()){
                    /*if(*/parent::Buscar($registro['rnrodocumento']);/*){*/
                        $this->setNumeroEmpleado($registro['rnumeroempleado']);
                        $this->setNumeroLicencia($registro['rnumerolicencia']);
                        $encontrado=true;
                    //}else{
                      //  $this->setMsjOperacion($base->getError());
                    //}
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
	    $arregloResponsables = null;
		$base=new BaseDatos();
		$consultaPersona="Select * from responsable ";
		 if ($condicion!=""){
		     $consultaPersona=$consultaPersona.' where '.$condicion;
		 }
		$consultaPersona.=" order by rnumeroempleado ";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){				
				$arregloResponsables= array();
				while($fila=$base->Registro()){
                    $numEmpleado=$fila['rnumeroempleado'];
					$numLicencia=$fila['rnumerolicencia'];
					$documento=$fila['rnrodocumento'];
                    $pasajero = new Responsable;
					$pasajero->setNumeroEmpleado($numEmpleado);
                    $pasajero->setNumeroLicencia($numLicencia);
					$pasajero->setNroDoc($documento);
					array_push($arregloResponsables,$pasajero);	
				}							
		 	} else {
		 		$this->setmsjOperacion($base->getError());		 		
			}
		} else {
		 	$this->setmsjOperacion($base->getError());		 	
		}	
		return $arregloResponsables;
	}
























}