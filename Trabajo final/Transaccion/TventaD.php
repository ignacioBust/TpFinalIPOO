<?php

include_once "Tventa.php";

class TventaD extends Tventa{



      // alta
   
   /**
    * Crea un objeto VentaD y lo inserta en la base de datos 
    * @param array $datosV
    * @return boolean $exito
    */


    public function insertarVentaD($fecha,$cliente,$tipoTarjeta,$bancoEmisor){
        $objVenta= new ventaDebito();
        $codigoV = null;
        $objVenta -> cargarD($fecha,$cliente,0,0,0,$tipoTarjeta,$bancoEmisor);

        if($objVenta -> insertar()){
            $codigoV = $objVenta -> getCodigoVenta();
        }
        return $codigoV;
    }


    /**
     * Busca una venta de la tienda 
     * @param int $codigo
     * @return object $objVenta
     */


     public function buscarVentaD($codigo){
        $objTitem = new Titems();
        $objVenta = new ventaDebito();
        $exito = $objVenta-> buscar($codigo);
        if(!$exito){
            $objVenta = null;
        }
        $colItems = $objTitem ->  mostrarItems("codigo= '$codigo'");
        if($colItems != null){
            $objVenta -> setColItems($colItems);
        }

        return $objVenta;
    }

     // baja
    /**
     * Elimina una venta de la tienda
     * @param int $codigo
     * @return boolean $exito
     */

     public function eliminarVentaD($codigo){
        $objVenta = new ventaDebito();
        $exito = false;
        if($objVenta-> buscar($codigo)){
            if($objVenta -> eliminar()){
                $exito = true;
            }
        }
        return $exito;
     }

     public function buscarVentasCondicion($condicion){
        $objTitem= new Titems();
        $objVentaD = new ventaDebito();
        $coleccionVentaD = $objVentaD -> listar($condicion);

        foreach ($coleccionVentaD as $ventaD){
            $codigo = $ventaD -> getCodigoVenta();
            $colItems = $objTitem ->  mostrarItems("codigo= '$codigo'");
            if($colItems != null){
                $ventaD -> setColItems($colItems);
            }
        }

        return $coleccionVentaD;
     }


     


      /**
       * modifica el tipo de tarjeta del cliente
       * @param object $objVenta
       * @param string $tipoTarjeta
       * @return boolean $exito
       */


       public function modifcarTipoTarjeta($objVenta,$tipoTarjeta){
        $objVenta -> setTipoTarjeta($tipoTarjeta);
        $exito = $objVenta -> modificar();

        return $exito;
       }

       /**
        * modificar el tipo de banco
        *@param object $objVenta
        *@param string $bancoEmisor
        *@return boolean $exito
        */

        public function modificarBancoEmisor($objVenta,$bancoEmisor){
            $objVenta -> setBancoEmisor($bancoEmisor);
            $exito = $objVenta -> modificar();

            return $exito;
        }




      
       /**
        * Calcula el importe final de las ventas contando con alguna caracteristica de la venta.
        * @param object $objVenta.
        * @return int $importeFinal.
        */


        public function darImpFinalVenta($objVenta){
            $importeP = 0;
            $importeF = 0;
        
                $importeP = $this -> importeParcialVenta($objVenta -> getColItems());
                
            
           
            return $importeP;

        }

}