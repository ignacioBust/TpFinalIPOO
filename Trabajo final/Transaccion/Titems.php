<?php

include_once "../ORM/BaseDatos.php";
include_once "Tproducto.php";



class Titems{



    /**
    * Crea un objeto item y lo inserta en la base de datos 
    * @param array $datoI
    * @return boolean $exito
    */


    public function insertarItems($unProducto,$cantidad,$codigoBarra,$codigoV){
        $objItems = new Item();
        $exito = false;
        $objItems -> cargar($unProducto,$cantidad,$codigoBarra,$codigoV);
        

        if($objItems -> insertar()){
            $exito = true;
        }
        return $exito;
    }

    /**
     * Busca un Item de la tienda 
     * @param string $codigobarra
     * @return object $objItem
     */


     public function buscarItem($codigoBarra,$codigo){
        $objItem = new Item();
        $exito = $objItem -> buscar($codigoBarra,$codigo);
        if(!$exito){
            $objItem = null;
        }

        return $objItem;
    }
    /**
       * devuelve un arreglo  de Objetos Items con respecto a la condicion recibidad
       * @param $condicion
       * @return array $objItems
       */

       public function mostrarItems($condicion){
        $colItems = [];
        $objItem = new Item();
        $coleccionitems = $objItem -> listar($condicion);
        $objTproducto = new Tproducto();

        foreach ($coleccionitems as $item){
            $producto= $objTproducto -> buscarProducto($item -> getCodigoBarra());
            if($producto !=null){
                $item -> setProducto($producto);
                $colItems []= $item;
            }
        }

        
        return $coleccionitems;
       }


      // baja
    /**
     * Elimina un Item de la tienda
     * @param string $codigobarra
     * @return boolean $exito
     */

     public function eliminarItem($codigoBarra,$codigo){
        $objItem = new Item();
        $exito = false;
        if($objItem -> buscar($codigoBarra,$codigo)){
            if($objItem -> eliminar()){
                $exito = true;
            }
        }
        return $exito;
     }


     

      

      public function modificarProductos($objItem,$producto){
        $objItem -> setProducto($producto);
        $exito = $objItem -> modificar();

        return $exito;
      }




      public function modificarCodigo($objItem,$codigo){
        $objItem -> setCodigo($codigo);
        $exito = $objItem -> modificar();

        return $exito;

      }





      public function modificarCodigoBarra($objItem,$codigobarra){
        $objItem -> setCodigoBarra($codigobarra);
        $exito = $objItem -> modificar();

        return $exito;
      }




      public function modificarCantidad($objItem,$cantidad){
        $objItem -> setCantidad($cantidad);
        $exito = $objItem -> modificar();

        return $exito;
      }

      public function modificarImporte($objItem,$importe){
        $objItem -> setImporte($importe);
        $exito = $objItem -> modificar();

        return $exito;
      }


      

      


      /**
       * Retornar el importe parcial del item basado en la cantidad por el precio
       * @param object $objItem
       * @return int $importeItem
       */

       public function darImporteItem($objItem){
        $importeParcial= 0;
        
            $cantidad = $objItem-> getCantidad();
            $precio = $objItem-> getProducto()->getPrecio();
            $importeParcial = $cantidad * $precio;
            

            $this-> modificarImporte($objItem,$importeParcial);
        

        


        return $importeParcial;
       }
}