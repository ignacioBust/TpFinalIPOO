<?php
include_once "BaseDatos.php";

class Producto {
    
    private $precio;
    private $codigoBarra;
    private $nombre;
    private $marca;
    private $color;
    private $descripcion;
    private $cantStock;
    private $mensajeOperacion;




    // metodo constructor que inicia los datos vacios
    public function __construct()
    {
        $this -> precio = 0;
        $this -> codigoBarra = "";
        $this -> nombre = "";
        $this -> marca = "";
        $this -> color = "";
        $this -> descripcion = "";
        $this -> cantStock = 0;
    }



    // metodo cargar 
    public function cargar($codigoBarra,$nombre,$marca,$color,$descripcion,$cantStock,$precio){
        $this -> setCodigoBarra($codigoBarra);
        $this -> setNombre($nombre);
        $this -> setMarca($marca);
        $this -> setColor($color);
        $this -> setDescripcion($descripcion);
        $this -> setCantStock($cantStock);
        $this -> setPrecio($precio);
    }


    // metodo get
    public function getPrecio(){
        return $this -> precio;
    }

    public function getCodigoBarra(){
        return $this -> codigoBarra;
    }

    public function getNombre(){
        return $this -> nombre;
    }

    public function getMarca(){
        return $this -> marca;
    }

    public function getColor(){
        return $this -> color;
    }

    public function getDescripcion(){
        return $this -> descripcion;
    }

    public function getCantStock(){
        return $this -> cantStock;
    }

    public function getMensajeOperacion(){
        return $this -> mensajeOperacion;
    }

    // metodo set

    public function setPrecio($precio){
        $this -> precio = $precio;
    }

    public function setCodigoBarra($codigoBarra){
        $this -> codigoBarra = $codigoBarra;
    }

    public function setNombre($nombre){
        $this -> nombre = $nombre;
    }

    public function setMarca($marca){
        $this -> marca = $marca;
    }

    public function setColor($color){
        $this -> color = $color;
    }

    public function setDescripcion($descripcion){
        $this -> descripcion = $descripcion;
    }

    public function setCantStock($cantStock){
        $this -> cantStock = $cantStock;
    }

    public function setMensajeOperacion($mensajeOperacion){
        $this -> mensajeOperacion = $mensajeOperacion;
    }

    /**
     * Recupera los datos de un producto por codigo de barra
     * @param string $codigoBarra
     * @return true en caso de encotrar los datos, false en caso contrario
     */


    public function buscar($codigoBarra){
        $base = new BaseDatos;
        $consultarBusqueda = "Select * from producto where codigobarra= " . $codigoBarra;
        $exito = false;
        if($base -> Iniciar()){
            if($base -> Ejecutar($consultarBusqueda)){
                if($row2 = $base -> Registro()){
                    $this -> setPrecio($row2['importe']);
                    $this -> setCodigoBarra($codigoBarra);
                    $this -> setNombre($row2['nombre']);
                    $this -> setMarca($row2['marca']);
                    $this -> setColor($row2['color']);
                    $this -> setDescripcion($row2['descripcion']);
                    $this -> setCantStock($row2['cantstock']);
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
        $consultaListar = "Select * from producto ";
        if($condicion !=""){
            $consultaListar .= ' where ' . $condicion;
        }
        $consultaListar .= " order by codigobarra ";

        if($base -> Iniciar()){
            if($base -> Ejecutar($consultaListar)){
                $arregloProductos = [];
                while ( $row2 = $base -> Registro()){
                    $precioP = $row2['importe'];
                    $codigoB = $row2['codigobarra'];
                    $nombreP = $row2['nombre'];
                    $marcaP = $row2['marca'];
                    $colorP = $row2['color'];
                    $descripcionP = $row2['descripcion'];
                    $cantidadStock = $row2['cantstock'];

                    $objProducto = new Producto();
                    $objProducto -> cargar($codigoB,$nombreP,$marcaP,$colorP,$descripcionP,$cantidadStock,$precioP);
                    array_push($arregloProductos,$objProducto);
                }
            } else {
                $this -> setMensajeOperacion($base -> getError());
            }
        }  else {
            $this -> setMensajeOperacion($base -> getError());
        }

        return $arregloProductos;
    }



    public function insertar(){
        $base = new BaseDatos();
        $exito = false;
        $consultaInsertar = "INSERT INTO producto(codigobarra,nombre,marca,color,descripcion,cantstock,importe) VALUES (" . $this -> getCodigoBarra() . ",'" . $this -> getNombre() . 
        "','" . $this -> getMarca() . "','" . $this -> getColor() . "','" . $this -> getDescripcion() . "','" . $this -> getCantStock() . "','" . $this -> getPrecio(). "')";

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
		$consultaModifica="UPDATE producto SET nombre='".$this->getNombre()."',marca='".$this->getMarca()."',color='". $this->getColor(). "', descripcion='" . $this -> getDescripcion() . 
        "', cantstock='". $this -> getCantStock() . "', importe= '" . $this -> getPrecio() . "' WHERE codigobarra = " . $this -> getCodigoBarra();
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
				$consultaBorra="DELETE FROM producto WHERE codigobarra=".$this->getCodigoBarra();
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













    // metodo toString

    public function __toString()
    {
        return " Codigo de Barra: " . $this -> getCodigoBarra() . "\n Nombre Producto: " . $this -> getNombre() .  "\n Marca: " . $this -> getMarca() . 
        "\n Color: " . $this -> getColor() . "\n Descripcion: " . $this -> getDescripcion() . "\n Cantidad de stock:  " . $this -> getCantStock() . "\nPrecio: " . $this -> getPrecio();
    }
}