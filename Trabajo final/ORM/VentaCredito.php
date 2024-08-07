<?php
include_once "Venta.php";
include_once "BaseDatos.php";

class ventaCredito extends Venta{
    private $cantidadCuotas;
    private $nombreTitular;
    private $numeroTarjeta;
    private $empresa;
	



    public function __construct()
    {
        $this -> cantidadCuotas=0;
        $this -> nombreTitular = "";
        $this -> numeroTarjeta = 0;
        $this -> empresa = "";
    }


    public function cargarC($fecha,$cliente,$codigoVenta, $descuento,$incremento,$cantidadCuotas,$nombreTitular,$numeroTarjeta,$empresa){
        parent::cargar($fecha,$cliente,$codigoVenta, $descuento,$incremento);
        $this -> setCantidadCuotas($cantidadCuotas);
        $this -> setNombreTitular($nombreTitular);
        $this -> setNumeroTarjeta($numeroTarjeta);
        $this -> setEmpresa($empresa);
    }

    // metodo get
    public function getCantidadCuotas(){
        return $this -> cantidadCuotas;
    }
    public function getNombreTitular(){
        return $this -> nombreTitular;
    }
    public function getNumeroTarjeta(){
        return $this -> numeroTarjeta;
    }
    public function getEmpresa(){
        return $this -> empresa;
    }
	public function getMensajeOperacion(){
		return parent::getMensajeOperacion();
	}

    // metodo set
    public function setCantidadCuotas($cantidadCuotas){
        $this -> cantidadCuotas = $cantidadCuotas;
    }
    public function setNombreTitular($nombreTitular){
        $this -> nombreTitular = $nombreTitular;
    }
    public function setNumeroTarjeta($numeroTarjeta){
        $this -> numeroTarjeta = $numeroTarjeta;
    }
    public function setEmpresa($empresa){
        $this -> empresa = $empresa;
    }
	public function setMensajeOperacion($mensajeOperacion)
	{
		parent::setMensajeOperacion($mensajeOperacion);
	}



    public function Buscar($codigo){
		$base=new BaseDatos();
		$consulta="Select * from ventacredito where codigo=".$codigo;
		$exito= false;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){	
				    parent::Buscar($codigo);
				    $this -> setCantidadCuotas($row2['cuotas']);
                    $this -> setNombreTitular($row2['nombretitular']);
                    $this -> setNumeroTarjeta($row2['numerotarjeta']);
                    $this -> setEmpresa($row2['empresaemisora']);
					$exito= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $exito;
	}	


    public  function listar($condicion=""){
	    
		$base=new BaseDatos();
		$consulta="Select * from ventacredito ";
		if ($condicion!=""){
		    $consulta=$consulta.' where '.$condicion;
		}
		$consulta.=" order by numerotarjeta ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){				
			    $arregloVenta= [];
				while($row2=$base->Registro()){
					$objVenta = new ventaCredito();
					$objVenta->Buscar($row2['codigo']);
					array_push($arregloVenta,$objVenta);
				}
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }	
		 return $arregloVenta;
	}	



    public function insertar(){
		$base=new BaseDatos();
		$exito= false;
		
		if(parent::insertar()){
		    $consultaInsertar="INSERT INTO ventacredito(codigo,nombretitular,numerotarjeta,empresaemisora,cuotas)
				VALUES (".parent::getCodigoVenta().",'".$this->getNombreTitular()."','" . $this -> getNumeroTarjeta() . "','" . $this -> getEmpresa()  . "','"  .$this->getCantidadCuotas()."')";
		    if($base->Iniciar()){
		        if($base->Ejecutar($consultaInsertar)){
		            $exito=  true;
		        }	else {
		            $this->setmensajeoperacion($base->getError());
		        }
		    } else {
		        $this->setmensajeoperacion($base->getError());
		    }
		 }
		return $exito;
	}


    public function modificar(){
	    $exito =false; 
	    $base=new BaseDatos();
	    if(parent::modificar()){
	        $consultaModifica="UPDATE ventacredito SET nombretitular='".$this->getNombreTitular()."',numerotarjeta= '". $this -> getNumeroTarjeta(). "', empresaemisora='" . $this-> getEmpresa(). "',cuotas= '" . $this-> getCantidadCuotas()     ."' WHERE codigo=". parent::getCodigoVenta();
	        if($base->Iniciar()){
	            if($base->Ejecutar($consultaModifica)){
	                $exito=  true;
	            }else{
	                $this->setmensajeoperacion($base->getError());
	                
	            }
	        }else{
	            $this->setmensajeoperacion($base->getError());
	            
	        }
	    }
		
		return $exito;
    
    }



    public function eliminar(){
		$base=new BaseDatos();
		$exito=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM ventacredito WHERE codigo=".parent::getCodigoVenta();
				if($base->Ejecutar($consultaBorra)){
				    if(parent::eliminar()){
				        $exito=  true;
				    }
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $exito; 
	}



    public function __toString()
    {
        return parent::__toString() . 
		"\n\n Nombre Titular: " . $this -> getNombreTitular() . "\n Numero de Tarjeta: " . $this -> getNumeroTarjeta(). "\n Empresa: " . $this -> getEmpresa() . "\n cantidad de cuotas: " . $this -> getCantidadCuotas() . "\n";
    }
}