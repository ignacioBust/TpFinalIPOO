<?php
include_once "../ORM/Venta.php";
include_once "Titems.php";


class Tventa{


      // alta
   
   /**
    * Crea un objeto Venta y lo inserta en la base de datos 
    * @param array $datosV
    * @return boolean $exito
    */


    public function insertarVenta($fecha,$cliente,$descuento,$incremento){
        $objVenta= new Venta();
        $codigoV = null;
        $objVenta -> cargar($fecha,$cliente,0,$descuento,$incremento);

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


     public function buscarVenta($codigo){
        
        $objVenta = new Venta();
        $exito = $objVenta-> buscar($codigo);
        if(!$exito){
            $objVenta = null;
        }
        $objTitem = new Titems();

        $colItems = $objTitem -> mostrarItems("codigo= '$codigo'");
        if($colItems != null){
        $objVenta -> setColItems($colItems);
        }



        return $objVenta;
    }
    public function buscarVentasCondicion($condicion){
       
        $objTitem = new Titems();
        $objVenta = new Venta();
        $objVentaC= new ventaCredito();
        $ObjVentaD = new ventaDebito();

        $colVentasC = $objVentaC -> listar("");
        $colVentasD = $ObjVentaD -> listar("");

        foreach($colVentasC as $ventaC){
            $codigoC []= $ventaC -> getCodigoVenta();
        }

        foreach($colVentasD as $ventaD){
            $codigoD []= $ventaD -> getCodigoVenta();
        }



        $ventasColeccion = $objVenta->listar($condicion);

        foreach ( $ventasColeccion as $venta){
            $codigoE []= $venta-> getCodigoVenta();
        }

        $codigosEfectivos = array_diff($codigoE,$codigoC,$codigoD);


        foreach($codigosEfectivos as $codigo){
            $ventaEncontrada= $this -> buscarVenta($codigo);
            if($venta !=null){
            $colItems = $objTitem -> mostrarItems("codigo='$codigo'");

            if($colItems !=null){
                $ventaEncontrada-> setColItems($colItems);
            }
            
        }


        $colVentaE[]= $ventaEncontrada;
            
        }


        
       /* foreach ($ventasColeccion as $venta) {
            
            
            $codigoV = $venta->getCodigoVenta();
            
            $colItems = $objTitem->mostrarItems("codigo= '$codigoV'");

            echo "\nLos Items son: " . print_r($colItems) ."\n";
            if ($colItems != null) {
                $venta->setColItems($colItems); // Asignamos los ítems a la instancia actual de venta
            }

            $colVentas [] = $venta;
        }*/
    
        return $colVentaE;
    }


     // baja
    /**
     * Elimina una venta de la tienda
     * @param int $codigo
     * @return boolean $exito
     */

     public function eliminarVenta($codigo){
        $objVenta = new Venta();
        $exito = false;
        if($objVenta-> buscar($codigo)){
            if($objVenta -> eliminar()){
                $exito = true;
            }
        }
        return $exito;
     }



     public function modificarFecha($objVenta, $fechaV){
        $objVenta -> setFecha($fechaV);
        $exito = $objVenta -> modificar();

        return $exito;
     }

      

      public function modificarCliente($objVenta,$cliente){
        $objVenta -> setCliente($cliente);
        $exito = $objVenta -> modificar();

        return $exito;
      }

      public function modificarImpFinalV($objVenta,$importeF){
        $objVenta -> setImporteFinal($importeF);
        $exito = $objVenta -> modificar();

        return $exito;
      }

      


      /**
       * Retorna el importe de la venta en base a la coleccion de items de la venta.
       * @param array $colItems.
       * @return int $importeParcial.
       */

       public function importeParcialVenta($colItems){
        
        $itemT = new Titems();
        $importeParcial = null;

        foreach ($colItems as $item){
            $importeParcial += $itemT -> darImporteItem($item);
           
        }

       
        


        return $importeParcial;
       }



       /**
        * Calcula el importe final de las ventas contando con alguna caracteristica de la venta.
        * @param object $objVenta.
        * @return int $importeFinal.
        */


        public function darImpFinalVenta($objVenta){
            
            
        
                $importeP = $this -> importeParcialVenta($objVenta->getColItems());
                
                $importeF = $importeP * 0.90;
            
           
            return $importeF;

        }
}