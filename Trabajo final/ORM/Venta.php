<?php
include_once "BaseDatos.php";

class Venta{
    private $fecha;
    private $cliente;
    private $codigoVenta;
    private $colItems;
    private $descuento;
    private $incremento;
    private $importeFinal;
    private $mensajeOperacion;



    public function __construct()
    {
        $this -> fecha = "";
        $this -> cliente = "";
        $this -> codigoVenta = 0;
        $this -> colItems = [];
        $this -> descuento = 0;
        $this -> incremento = 0;
        $this -> importeFinal = 0;
    }

    public function cargar($fecha,$cliente,$codigoVenta, $descuento,$incremento){
        $this -> setFecha($fecha);
        $this -> setCliente($cliente);
        $this -> setCodigoVenta($codigoVenta);
        $this -> setDescuento($descuento);
        $this -> setIncremento($incremento);
    }


    // metodo get
    public function getFecha(){
        return $this -> fecha;
    }
    public function getCliente(){
        return $this -> cliente;
    }
    public function getCodigoVenta(){
        return $this -> codigoVenta;
    }
    public function getColItems(){
        return $this -> colItems;
    }
    public function getDescuento(){
        return $this -> descuento;
    }
    public function getIncremento(){
        return $this -> incremento;
    }
    public function getImporteFinal(){
        return $this -> importeFinal;
    }
    public function getMensajeOperacion(){
        return $this -> mensajeOperacion;
    }


    // metodo set

    public function setFecha($fecha){
        $this -> fecha = $fecha;
    }

    public function setCliente($cliente){
        $this -> cliente = $cliente;
    }

    public function setCodigoVenta($codigoVenta){
        $this -> codigoVenta = $codigoVenta;
    }

    public function setColItems($colItems){
        $this -> colItems = $colItems;
    }

    public function setDescuento($descuento){
        $this -> descuento = $descuento;
    }

    public function setIncremento($incremento){
        $this -> incremento = $incremento;
    }

    public function setImporteFinal($importeFinal){
        $this -> importeFinal = $importeFinal;
    }

    public function setMensajeOperacion($mensajeOperacion){
        $this -> mensajeOperacion = $mensajeOperacion;
    }




    
    /**
     * Recupera los datos de una venta por codigo de venta
     * @param int $codigo
     * @return true en caso de encotrar los datos, false en caso contrario
     */


     public function buscar($codigo){
        $base = new BaseDatos;
        $consultarBusqueda = "Select * from venta where codigo= " . $codigo;
        $exito = false;
        if($base -> Iniciar()){
            if($base -> Ejecutar($consultarBusqueda)){
                if($row2 = $base -> Registro()){
                    $this -> setCodigoVenta($codigo);
                    $this -> setFecha($row2['fecha']);
                    $this -> setCliente($row2['denominacioncliente']);
                    $this -> setDescuento($row2['descuento']);
                    $this -> setIncremento($row2['incremento']);
                    $this -> setImporteFinal($row2['importefinal']);
                    $exito = true;
                }
            } else{
                $this -> setMensajeOperacion($base -> getError());
            }
        } else {
            $this -> setMensajeOperacion($base -> getError());
        }

        return $exito;
    }


    
    public function listar($condicion=""){
        $base = new BaseDatos();
        $consultaListar = "Select * from venta ";
        if($condicion !=""){
            $consultaListar .= ' where ' . $condicion;
        }
        $consultaListar .= " order by codigo ";
        
        if($base -> Iniciar()){
            if($base -> Ejecutar($consultaListar)){
                $arregloVenta = [];
                while ( $row2 = $base -> Registro()){
                    $codigoV = $row2['codigo'];
                    $fechaV = $row2['fecha'];
                    $clienteV = $row2['denominacioncliente'];
                    $descuentoV = $row2['descuento'];
                    $incrementoV = $row2['incremento'];
                    $importeFinal = $row2['importefinal'];

                    $objVenta = new Venta();
                    $objVenta-> cargar($fechaV,$clienteV,$codigoV,$descuentoV,$incrementoV);
                    $objVenta -> setImporteFinal($importeFinal);
                    array_push($arregloVenta,$objVenta);
                }
            } else {
                $this -> setMensajeOperacion($base -> getError());
            }
        }  else {
            $this -> setMensajeOperacion($base -> getError());
        }

        return $arregloVenta;
    }




    public function insertar(){
        $base = new BaseDatos();
        $exito = false;
        $consultaInsertar = "INSERT INTO venta(fecha,denominacioncliente,descuento,incremento,importefinal) VALUES (" . $this -> getFecha() . ",'" . $this -> getCliente() . 
        "','" . $this -> getDescuento() . "','" . $this -> getIncremento() . "','" . $this -> getImporteFinal(). "')";

        if($base -> Iniciar()){
            if($codigo = $base -> devuelveIDInsercion($consultaInsertar)){
                $this -> setCodigoVenta($codigo);
                $exito = true;
            } else {
                $this -> setMensajeOperacion($base -> getError());
            }
        } else {
            $this -> setMensajeOperacion($base -> getError());
        }
        return $exito;
    }


    public function modificar(){
	    $exito =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE venta SET fecha='".$this->getFecha()."',denominacioncliente='".$this->getCliente()."',descuento='". $this->getDescuento(). "', incremento='" . $this -> getIncremento() . 
        "', importefinal='". $this -> getImporteFinal() .  "' WHERE codigo=" . $this -> getCodigoVenta();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $exito=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $exito;
	}



    
    public function eliminar(){
		$base=new BaseDatos();
		$exito=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM venta WHERE codigo=".$this->getCodigoVenta();
				if($base->Ejecutar($consultaBorra)){
				    $exito=  true;
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
        return 
        "\n\n* Codigo de Venta: " . $this -> getCodigoVenta() . 
        "\n\n* Fecha de Venta: " . $this -> getFecha() . 
        "\n\n* Cliente: " . $this -> getCliente() . 
        "\n\n* Descuento: " . $this -> getDescuento() . 
        "\n\n* Incremento: " . $this -> getIncremento() . 
        "\n\n* Importe Final: " . $this -> getImporteFinal() . 
        "\n\n* Coleccion de Items: " . print_r($this -> getColItems()) ."\n"; 
        

    }






}