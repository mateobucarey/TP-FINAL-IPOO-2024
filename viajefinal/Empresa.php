<?php

include_once ('BaseDatos.php');

class Empresa{
    private $idEmpresa;
    private $nombre;
    private $direccion;
    private $msjoperacion;

    public function __construct(){
        // $this->idEmpresa = 0;
        $this->nombre = "";
        $this->direccion = "";
    }

    public function cargar($nombre, $direccion){  
        $this->setNombre($nombre);
        $this->setDireccion($direccion);
    }
    
    public function getIdEmpresa()
    {
        return $this->idEmpresa;
    }

    public function setIdEmpresa($idEmpresa)
    {
        $this->idEmpresa = $idEmpresa;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    public function getMsjoperacion()
    {
        return $this->msjoperacion;
    }

    public function setMsjoperacion($msjoperacion)
    {
        $this->msjoperacion = $msjoperacion;
    }

    public function __toString(){
        return
        "ID: " . $this->getIdEmpresa() . "\n" .
        "Nombre: " . $this->getNombre() . "\n" .
        "Dirección: " . $this->getDireccion() . "\n";
    }

    public function insertar(){
        $base = new BaseDatos;
        $msj = false;
        $consultaInsertar = 
        "INSERT INTO empresa(enombre, edireccion) VALUES ('".$this->getNombre()."','".$this->getDireccion()."')";
        if ($base->Iniciar()) {
            if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setIdEmpresa($id);
                $msj = true;
            } else {
                $this->setMsjoperacion($base->getError());
            }
        } else{ 
            $this->setMsjoperacion($base->getError());
        }
        return $msj;
    }

    public function modificar(){
        $base = new BaseDatos;
        $msj = false;
        $consultaModificar = 
        "UPDATE empresa 
        SET enombre = '".$this->getNombre()."', edireccion = '".$this->getDireccion()."' WHERE idempresa = ". $this->getIdEmpresa();
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
        "DELETE FROM empresa
        WHERE idempresa ='". $this->getIdEmpresa()."'";
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

    public function buscar($idEmpresa){
        $base=new BaseDatos();
        $encontrada=false;
        $consulta="SELECT * FROM empresa WHERE idempresa=".$idEmpresa;
        if($base->iniciar()){            
            if($base->Ejecutar($consulta)){
                /*while*/if ($registro=$base->Registro()){
                $this->setIdEmpresa($registro['idempresa']);
                $this->setNombre($registro['enombre']);
                $this->setDireccion($registro['edireccion']);
                    $encontrada=true;
                }
            }else{
                $this->setMsjOperacion($base->getError());
            }
        }else{
            $this->setMsjOperacion($base->getError());
        }
        return $encontrada;
    }

    public function listar($condicion){
	    $arregloEmpresas = null;
		$base=new BaseDatos();
		$consultaEmpresas="Select * from empresa ";
		 if ($condicion!=""){
		     $consultaEmpresas=$consultaEmpresas.' where '.$condicion;
		}
		$consultaEmpresas.=" order by idempresa ";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresas)){				
				$arregloEmpresas= array();
				while($fila=$base->Registro()){
				    $idEmpresa=$fila['idempresa'];
					$eNombre=$fila['enombre'];
					$eDireccion=$fila['edireccion'];
                    $empresa = new Empresa;
					$empresa->cargar($eNombre,$eDireccion);
					$empresa->setIdEmpresa($idEmpresa);
					array_push($arregloEmpresas,$empresa);	
				}							
		 	} else {
		 		$this->setmsjOperacion($base->getError());		 		
			}
		} else {
		 	$this->setmsjOperacion($base->getError());		 	
		}	
		return $arregloEmpresas;
	}







}