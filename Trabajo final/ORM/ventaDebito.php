<?php

include_once "Venta.php";
include_once "BaseDatos.php";
class ventaDebito extends Venta{

    private $tipoTarjeta;
    private $bancoEmisor;

    
    public function __construct()
    {
        $this -> tipoTarjeta="";
        $this -> bancoEmisor="";
    }



    public function cargarD($fecha,$cliente,$codigoVenta, $descuento,$incremento, $tipoTarjeta,$bancoEmisor){
        parent::cargar($fecha,$cliente,$codigoVenta, $descuento,$incremento);
        $this -> setTipoTarjeta($tipoTarjeta);
        $this -> setBancoEmisor($bancoEmisor);
    }


    // metodo get 
    public function getTipoTarjeta(){
        return $this -> tipoTarjeta;
    }
    public function getBancoEmisor(){
        return $this -> bancoEmisor;
    }
    public function getMensajeOperacion()
    {
        return parent:: getMensajeOperacion();
    }

    //metodo set
    public function setTipoTarjeta($tipoTarjeta){
        $this -> tipoTarjeta = $tipoTarjeta;
    }

    public function setBancoEmisor($bancoEmisor){
        $this -> bancoEmisor  = $bancoEmisor;
    }
    public function setMensajeOperacion($mensajeOperacion)
    {
        parent::setMensajeOperacion($mensajeOperacion);
    }





    public function Buscar($codigo){
		$base=new BaseDatos();
		$consulta="Select * from ventadebito where codigo=".$codigo;
		$exito= false;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){	
				    parent::Buscar($codigo);
                    $this -> setTipoTarjeta($row2['red']);
                    $this -> setBancoEmisor($row2['bancoemisor']);
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
		$consulta="Select * from ventadebito ";
		if ($condicion!=""){
		    $consulta=$consulta.' where '.$condicion;
		}
		$consulta.=" order by codigo ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){				
			    $arregloVenta= [];
				while($row2=$base->Registro()){
					$objVenta = new ventaDebito();
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
		    $consultaInsertar="INSERT INTO ventadebito(codigo,red,bancoemisor)
				VALUES (".parent::getCodigoVenta().",'".$this->getTipoTarjeta()."','"  .$this->getBancoEmisor()."')";
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
	        $consultaModifica="UPDATE ventadebito SET red='".$this->getTipoTarjeta(). "',bancoemisor= '" . $this-> getBancoEmisor()."' WHERE codigo=". parent::getCodigoVenta();
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
        return parent::__toString() . "\n Tipo de Tarjeta: " . $this -> getTipoTarjeta() . "\nBanco Emisor: " . $this -> getBancoEmisor();
    }




}