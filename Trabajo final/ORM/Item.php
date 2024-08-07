<?php

include_once "BaseDatos.php";
class Item{
    private $producto;
    private $cantidad;
    private $codigoBarra;
    private $importe;
    private $codigo;
    private $mensajeOperacion;


    public function __construct()
    {
        $this -> producto= new Producto();
        $this -> cantidad = 0;
        $this -> codigoBarra="";
        $this -> importe = 0;
        $this -> codigo = 0;

    }


    public function cargar($producto,$cantidad,$codigoBarra,$codigo){
        $this -> setProducto($producto);
        $this -> setCantidad($cantidad);
        $this -> setCodigoBarra($codigoBarra);
        $this -> setCodigo($codigo);
    }



    // metodo get
    public function getProducto(){
        return $this -> producto;
    }
    public function getCantidad(){
        return $this -> cantidad;
    }
    public function getImporte(){
        return $this -> importe;
    }
    public function getCodigo(){
        return $this -> codigo;
    }
    public function getCodigoBarra(){
        return $this -> codigoBarra;
    }
    public function getMensajeOperacion(){
        return $this -> mensajeOperacion;
    }


    // metodo set

    public function setProducto($producto){
        $this -> producto = $producto;
    }

    public function setCantidad($cantidad){
        $this -> cantidad = $cantidad;
    }
    public function setImporte($importe){
        $this -> importe = $importe;
    }
    public function setCodigo($codigo){
        $this -> codigo = $codigo;
    }
    public function setCodigoBarra($codigoBarra){
        $this -> codigoBarra = $codigoBarra;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this -> mensajeOperacion = $mensajeOperacion;
    }


    public function buscar($codigoBarra,$codigo){
        $base = new BaseDatos;
        $consultarBusqueda = "Select * from item where codigobarra= " . $codigoBarra ." AND codigo=" . $codigo;
        $exito = false;
        if($base -> Iniciar()){
            if($base -> Ejecutar($consultarBusqueda)){
                if($row2 = $base -> Registro()){
                    $this -> setCodigoBarra($codigoBarra);
                    $this -> setCantidad($row2['cantidad']);
                    $this -> setCodigo($codigo);
                    $this -> setImporte($row2['importe']);
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
        $consultaListar = "Select * from item ";
        if($condicion !=""){
            $consultaListar .= ' where ' . $condicion;
        }
        $consultaListar .= " order by codigo ";

        if($base -> Iniciar()){
            if($base -> Ejecutar($consultaListar)){
                $arregloItems= [];
                while ( $row2 = $base -> Registro()){
                    $producto = $this -> getProducto();
                    $codigoB = $row2['codigobarra'];
                   $cantidad = $row2['cantidad'];
                   $codigoI = $row2 ['codigo'];
                   $importe = $row2['importe'];
                   $objItems = new Item();
                   $objItems -> cargar($producto,$cantidad,$codigoB,$codigoI);
                   $objItems -> setImporte($importe);
                    array_push($arregloItems,$objItems);
                }
            } else {
                $this -> setMensajeOperacion($base -> getError());
            }
        }  else {
            $this -> setMensajeOperacion($base -> getError());
        }

        return $arregloItems;
    }



    public function insertar(){
        $base = new BaseDatos();
        $exito = false;
        $consultaInsertar = "INSERT INTO item(codigobarra,cantidad,codigo,importe) VALUES (" . $this -> getCodigoBarra() . ",'" . $this -> getCantidad() . 
        "','" . $this -> getCodigo() .  "','" . $this -> getImporte(). "')";

        if($base -> Iniciar()){
            if($base -> Ejecutar($consultaInsertar)){
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
		$consultaModifica="UPDATE item SET codigobarra='".$this->getCodigoBarra()."',cantidad='".$this->getCantidad()."',codigo='". $this->getCodigo().  "', importe= '" . 
        $this -> getImporte() . "' WHERE codigobarra=" . $this -> getCodigoBarra() . " AND codigo= ". $this -> getCodigo();
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
				$consultaBorra="DELETE FROM item WHERE codigobarra=".$this->getCodigoBarra() ." AND codigo= ". $this -> getCodigo();
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
        return "\n\nProducto: " . $this -> getProducto() . 
        "\n\n Codigo de Barra: " . $this -> getCodigoBarra() . 
        "\n\n Cantidad: " . $this -> getCantidad() . 
        "\n\n Codigo: " . $this -> getCodigo() . 
        "\n\n Importe: " . $this -> getImporte();
    }



}