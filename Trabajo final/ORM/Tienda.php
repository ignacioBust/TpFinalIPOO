<?php
include_once "BaseDatos.php";

class Tienda{
    private $nombre;
    private $direccion;
    private $telefono;
    private $colProductos;
    private $colVentasRealizadas;
    private $cuit;
    private $mensajeOperacion;




    public function __construct()
    {
        $this -> nombre = "";
        $this -> direccion = "";
        $this -> telefono = 0;
        $this -> colProductos= [];
        $this -> colVentasRealizadas = [];
        $this -> cuit = "";
    }


    public function cargar ($nombre,$direccion,$telefono,$cuit){
        $this -> setNombre($nombre);
        $this -> setDireccion($direccion);
        $this -> setTelefono($telefono);
        $this -> setCuit($cuit);
    }


    // metodo get
    public function getNombre(){
        return $this -> nombre;
    }
    public function getDireccion(){
        return $this -> direccion;
    }
    public function getTelefono(){
        return $this -> telefono;
    }
    public function getColProductos(){
        return $this -> colProductos;
    }
    public function getColVentasRealizadas(){
        return $this -> colVentasRealizadas;
    }
    public function getCuit(){
        return $this -> cuit;
    }
    public function getMensajeOperacion(){
        return $this -> mensajeOperacion;
    }


    // metodo set
    public function setNombre($nombre){
        $this -> nombre = $nombre;
    }
    public function setDireccion($direccion){
        $this -> direccion = $direccion;
    }
    public function setTelefono($telefono){
        $this -> telefono = $telefono;
    }
    public function setColProductos($colProductos){
        $this -> colProductos = $colProductos;
    }
    public function setColVentasRealizadas($colVentasRealizadas){
        $this -> colVentasRealizadas = $colVentasRealizadas;
    }
    public function setCuit($cuit){
        $this -> cuit = $cuit;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this -> mensajeOperacion = $mensajeOperacion;
    }


    public function buscar($cuit){
        $base = new BaseDatos;
        $consultarBusqueda = "Select * from tienda where cuit= " . $cuit;
        $exito = false;
        if($base -> Iniciar()){
            if($base -> Ejecutar($consultarBusqueda)){
                if($row2 = $base -> Registro()){
                    $this -> setCuit($cuit);
                    $this -> setNombre($row2['nombre']);
                    $this -> setDireccion($row2['direccion']);
                    $this -> setTelefono($row2['telefono']);
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
        $consultaListar = "Select * from tienda ";
        if($condicion !=""){
            $consultaListar .= ' where ' . $condicion;
        }
        $consultaListar .= " order by cuit ";

        if($base -> Iniciar()){
            if($base -> Ejecutar($consultaListar)){
                $arregloTienda= [];
                while ( $row2 = $base -> Registro()){
                    $cuitT = $row2['cuit'];
                    $nombreT = $row2 ['nombre'];
                    $direccionT = $row2 ['direccion'];
                    $telefonoT = $row2 ['telefono'];
                    $objTienda = new Tienda();
                    $objTienda -> cargar($nombreT,$direccionT,$telefonoT,$cuitT);
                    
                    array_push($arregloTienda,$objTienda);
                }
            } else {
                $this -> setMensajeOperacion($base -> getError());
            }
        }  else {
            $this -> setMensajeOperacion($base -> getError());
        }

        return $arregloTienda;
    }


    
    public function insertar(){
        $base = new BaseDatos();
        $exito = false;
        $consultaInsertar = "INSERT INTO tienda(cuit,nombre,direccion,telefono) VALUES (" . $this -> getCuit() . ",'" . $this -> getNombre() . 
        "','" . $this -> getDireccion() .  "','" . $this -> getTelefono(). "')";

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
		$consultaModifica="UPDATE tienda SET nombre='".$this->getNombre()."',direccion='".$this->getDireccion(). "', telefono= '" . 
        $this -> getTelefono() . "' WHERE cuit=" . $this -> getCuit();
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
				$consultaBorra="DELETE FROM tienda WHERE cuit=".$this->getCuit();
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
        return "\n\nNombre: " . $this -> getNombre() . 
        "\n\n Direccion: " . $this -> getDireccion() . 
        "\n\n Telefono: " . $this -> getTelefono() . 
        "\n\n coleccion Productos: " . print_r($this -> getColProductos()) . 
        "\n\n coleccion de ventas: " . print_r($this -> getColVentasRealizadas()) . 
        "\n\n Cuit: " . $this -> getCuit();
    }








}