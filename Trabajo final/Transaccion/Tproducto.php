<?php

include_once "../ORM/Producto.php";


class Tproducto{

    
   // alta
   
   /**
    * Crea un objeto Producto y lo inserta en la base de datos 
    * @param array $datosP
    * @return boolean $exito
    */


    public function insertarProducto($codigoBarra,$nombre,$marca,$color,$descripcion,$cantStock,$precio){
        $objProducto = new Producto();
        $exito = false;
        $objProducto -> cargar($codigoBarra,$nombre,$marca,$color,$descripcion,$cantStock,$precio);
        if($objProducto -> insertar()){
            $exito = true;
        }
        return $exito;
    }

    /**
     * Busca un Producto de la tienda 
     * @param string $codigobarra
     * @return object $objProducto
     */


    public function buscarProducto($codigoBarra){
        $objProducto = new Producto();
        $exito = $objProducto -> buscar($codigoBarra);
        if(!$exito){
            $objProducto = null;
        }

        return $objProducto;
    }


    public function buscarProductosCondicion($condicion){
      $objProducto = new Producto();
      $coleccionProductos = $objProducto -> listar($condicion);

      return $coleccionProductos;
    }


    // baja
    /**
     * Elimina un Producto de la tienda
     * @param string $codigobarra
     * @return boolean $exito
     */

     public function eliminarProducto($codigoBarra){
        $objProducto = new Producto();
        $exito = false;
        
            if($objProducto -> buscar($codigoBarra)){
              if($objProducto -> eliminar())
                $exito = true;
            }
        
        return $exito;
     }


     

      public function modificarStock($objProducto,$cantidadStock){
        $objProducto -> setCantStock($cantidadStock);
        $exito = $objProducto -> modificar();

        return $exito;
      }


      public function modificarNombre($objProducto,$nombreP){
        $objProducto -> setNombre($nombreP);
        $exito = $objProducto -> modificar();

        return $exito;
      }

      public function modificarMarca($objProducto,$marcaP){
        $objProducto -> setMarca($marcaP);
        $exito = $objProducto -> modificar();
        return $exito;
      }

      public function modificarColor($objProducto,$colorP){
        $objProducto -> setColor($colorP);
        $exito = $objProducto -> modificar();

        return $exito;
      }

      public function modificarDescripcion($objProducto,$descripcionP){
        $objProducto -> setDescripcion($descripcionP);
        $exito = $objProducto -> modificar();

        return $exito;
      }

      public function modificarPrecio($objProducto,$precioP){
        $objProducto -> setPrecio($precioP);
        $exito = $objProducto -> modificar();

        return $exito;

      }



      /**
       * Actualiza el valor de stock del producto según corresponda
       * @param int $cantidad
       * @param string $codigobarra
       * @return boolean $exito
       */

       public function actualizarStock($codigoBarra,$cantidad){
        $producto = $this -> buscarProducto($codigoBarra);
        $exito = false;
        if($producto!=null){
        $cantidadStock = $producto -> getCantStock();
        
        if($cantidad >0 ){
            $cantidadStock += $cantidad;
            $exito = true;
        } elseif($cantidad < 0 && $cantidadStock >= abs($cantidad)){
            $cantidadStock -= abs($cantidad) ;
            $exito = true;
        } else {
            $exito = false;
        }
        
        $this -> modificarStock($producto,$cantidadStock);


       }
       return $exito;
    }

}