<?php

include_once "../ORM/BaseDatos.php";
include_once "Tventa.php";


class TventaC extends Tventa{

     // alta
   
   /**
    * Crea un objeto VentaCredito y lo inserta en la base de datos 
    * @param array $datosV
    * @return boolean $exito
    */


    public function insertarVentaC($fecha,$cliente,$descuento,$incremento,$cantCuotas,$nombreTitular,$numeroTarjeta,$empresa){
        $objVenta= new ventaCredito();
        $codigoV = null;
        $objVenta -> cargarC($fecha,$cliente,0,$descuento,$incremento,$cantCuotas,$nombreTitular,$numeroTarjeta,$empresa);

        if($objVenta -> insertar()){
            $codigoV = $objVenta -> getCodigoVenta();
        }
        return $codigoV;
    }


    /**
     * Busca una ventaCredito de la tienda 
     * @param int $codigo
     * @return object $objVenta
     */


     public function buscarVentaC($codigo){
        $objVenta = new ventaCredito();
        $objItem = new Titems();
        $exito = $objVenta-> buscar($codigo);
        if(!$exito){
            $objVenta = null;
        }
        $colItems = $objItem -> mostrarItems("codigo= '$codigo'");
        if($colItems != null){
            $objVenta -> setColItems($colItems);
        }

        return $objVenta;
    }


    public function buscarVentasCondicion($condicion){
        $objTitem = new Titems();
        $objVentaC = new ventaCredito();
        $coleccionVentasC = $objVentaC -> listar($condicion);

        foreach($coleccionVentasC as $ventaC){
            $codigo= $ventaC -> getCodigoVenta();
            $colItems = $objTitem -> mostrarItems("codigo= '$codigo'");
            if($colItems !=null){
                $ventaC -> setColItems($colItems);
            }
        }

        return $coleccionVentasC;
    }


     // baja
    /**
     * Elimina una ventaCredito de la tienda
     * @param int $codigo
     * @return boolean $exito
     */

     public function eliminarVentaC($codigo){
        $objVenta = new ventaCredito();
        $exito = false;
        if($objVenta-> buscar($codigo)){
            if($objVenta -> eliminar()){
                $exito = true;
            }
        }
        return $exito;
     }


     

      /**
       * modifica la cantidad de cuotas en la que va a pagar
       * @param object $objVenta
       * @param int $cantCuotas
       * @return boolean $exito
       */

      public function modificarCuotas($objVenta,$cantCuotas){
        $objVenta -> setCantidadCuotas($cantCuotas);
        $exito = $objVenta -> modificar();

        return $exito;
      }

      /**
       * modifica el nombre del titular
       * @param object $objVenta
       * @param string $nomTitular
       * @return boolean $exito
       */
      public function modificarNombreTitular($objVenta,$nomTitular){
        $objVenta -> setNombreTitular($nomTitular);
        $exito = $objVenta -> modificar();

        return $exito;
      }
      /**
       * modifica el numero de la tarjeta del titular
       * @param object $objVenta
       * @param int $numTarjeta
       * @return boolean $exito
       */

      public function modificarNumeroTarjeta($objVenta,$numTarjeta){
        $objVenta ->setNumeroTarjeta($numTarjeta);
        $exito = $objVenta -> modificar();

        return $exito;
      }

      /**
       * Cambia la empresa de la tarjeta
       * @param object $objVenta
       * @param string $empresa
       * @return boolean $exito
       */

       public function modificarEmpresa($objVenta, $empresa){
        $objVenta -> setEmpresa($empresa);
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
        
                $importeP = parent::importeParcialVenta($objVenta->getColItems());
                echo "la venta es : " .get_class($objVenta);
                if($objVenta -> getCantidadCuotas()>=3){
                $importeF = $importeP * 1.10;
                
                }else{
                    $importeF = $importeP;
                }

           
            return $importeF;

        }

}