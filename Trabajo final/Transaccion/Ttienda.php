<?php

include_once "../ORM/BaseDatos.php";
include_once "Tproducto.php";


class Ttienda{

 // alta
   
   /**
    * Crea un objeto Tienda y lo inserta en la base de datos 
    * @param array $datosT
    * @return boolean $exito
    */


    public function insertarTienda($cuit,$nombre,$direccion,$telefono){
        $objTienda = new Tienda();
        $exito = false;
        $objTienda -> cargar($nombre,$direccion,$telefono,$cuit);

        if($objTienda -> insertar()){
            $exito = true;
        }
        return $exito;
    }


    /**
     * Busca una Tienda  en la base de datos 
     * @param string $cuit
     * @return object $objTienda
     */


     public function buscarTienda($cuit){
        $colVentas=[];
        $objTienda = new Tienda();
        $objTproductos = new Tproducto();
        $objTventa = new Tventa();
        $objTventaC = new TventaC();
        $objTventaD = new TventaD();

        $exito = $objTienda -> buscar($cuit);

        $productos = $objTproductos -> buscarProductosCondicion("");
        $ventas = $objTventa -> buscarVentasCondicion("");
        $ventaC = $objTventaC -> buscarVentasCondicion("");
        $ventaD = $objTventaD -> buscarVentasCondicion("");

        if($ventas != null || $ventaC != null || $ventaD  != null){
          array_push($colVentas,$ventas,$ventaC,$ventaD);
        }


        $objTienda -> setColProductos($productos);
        $objTienda -> setColVentasRealizadas($colVentas);

        

        if(!$exito){
            $objTienda = null;
        }

        

        return $objTienda;
    }

    public function buscarTiendas($condicion){
      $colTiendas = [];
      $objTienda = new Tienda();
      $coleccionTienda = $objTienda->listar($condicion);
      $objTproductos = new Tproducto();
      $objTventa = new Tventa();
      $objTventaC = new TventaC();
      $objTventaD = new TventaD();
  
      foreach ($coleccionTienda as $tienda) {
          $productos = $objTproductos->buscarProductosCondicion(""); // Asumiendo que necesitas una condición específica
          $ventas = $objTventa->buscarVentasCondicion(""); // Asumiendo que necesitas una condición específica
          $ventaC = $objTventaC->buscarVentasCondicion(""); // Asumiendo que necesitas una condición específica
          $ventaD = $objTventaD->buscarVentasCondicion(""); // Asumiendo que necesitas una condición específica
  
          $colVentas = [];
  
          if ($ventas != null || $ventaC != null || $ventaD != null) {
              $colVentas = [
                  "Ventas Efectivo" => $ventas,
                  "Ventas Crédito" => $ventaC,
                  "Ventas Débito" => $ventaD
              ];
          }
  
          $tienda->setColProductos($productos);
          $tienda->setColVentasRealizadas($colVentas);
          $colTiendas[] = $tienda;
      }
  
      return $colTiendas;
  }

    // baja
    /**
     * Elimina una Tienda de la base de datos
     * @param string $cuit
     * @return boolean $exito
     */

     public function eliminarTienda($cuit){
        $objTienda = new Tienda();
        $exito = false;
        if($objTienda -> buscar($cuit)){
            if($objTienda -> eliminar()){
                $exito = true;
            }
        }
        return $exito;
     }


     


      public function modificarNombreT($objTienda, $nombre){
        $objTienda -> setNombre($nombre);
        $exito = $objTienda -> modificar();
        return $exito;

      }


      public function modificarDireccionT($objTienda,$direccion){
        $objTienda -> setDireccion($direccion);
        $exito = $objTienda -> modificar();
        return $exito;
      }


      public function modificarTelefonoT($objTienda, $telefono){
        $objTienda -> setTelefono($telefono);
        $exito = $objTienda-> modificar();
        return $exito;
      }






      /**
       * Recibe como paramatro  3 datos El método crea un nuevo objeto venta según el parámetro recibido y retorna el importe final de la venta que debe 
       * abonar el cliente según el tipo de venta.
       * @param array $arregloProducto.
       * @param string $tipoVenta.
       * @param array $infoVenta.
       * @return int $importeFinal.
       */

       public function registrarVenta($arregloProducto,$tipoVenta,$infoVenta,$objTienda){
      

        if($tipoVenta == "E"){
            $objTVenta = new Tventa();
            $fecha = date("Y-m-d H:i:s");
           $codigo= $objTVenta -> insertarVenta($fecha,$infoVenta['nombreCompleto'],10,0);
           

           foreach($arregloProducto as $producto){
            $objItem = new Titems();
            $objItem -> insertarItems($producto['unProducto'],abs($producto['cantidad']),$producto['unProducto']-> getCodigoBarra(),$codigo);
          }
  
  
  
          $coleccionI = $objItem -> mostrarItems("codigo= '$codigo'");// busca una coleccion de items con ese codigo de venta
  
           
  
           
  
          $objVenta=  $objTVenta -> buscarVenta($codigo); // busca la venta con el codigo
           $objVenta -> setColItems($coleccionI);
    
           $importeFinal = $objTVenta -> darImpFinalVenta($objVenta); // calcula el importe final de la venta 
  
       

       
            
        }elseif($tipoVenta == "C"){
          echo "\nIngrese a la venta C\n";
            $objTVentaC = new TventaC();
            $fecha = date("Y-m-d H:i:s");
           $codigo= $objTVentaC -> insertarVentaC($fecha,$infoVenta['nombreCompleto'],0,10,$infoVenta['cantidadCuotas'],$infoVenta['nombreTitular'],$infoVenta['numeroTarjeta'],$infoVenta['empresaEmisora']);
           
           foreach($arregloProducto as $producto){
            $objItem = new Titems();
            $objItem -> insertarItems($producto['unProducto'],abs($producto['cantidad']),$producto['unProducto']-> getCodigoBarra(),$codigo);
          }
  
  
  
          $coleccionI = $objItem -> mostrarItems("codigo= '$codigo'");// busca una coleccion de items con ese codigo de venta
  
           
  
           
  
          $objVenta=  $objTVentaC -> buscarVentaC($codigo); // busca la venta con el codigo
           $objVenta -> setColItems($coleccionI);
    
           $importeFinal = $objTVentaC -> darImpFinalVenta($objVenta); // calcula el importe final de la venta 
  

        

       
        }elseif($tipoVenta == "D"){
            $objTVentaD = new TventaD();
            $fecha = date("Y-m-d H:i:s");
           $codigo =  $objTVentaD -> insertarVentaD($fecha,$infoVenta['nombreCompleto'],$infoVenta['tipoTarjeta'],$infoVenta['bancoEmisor']);

           foreach($arregloProducto as $producto){
            $objItem = new Titems();
            $objItem -> insertarItems($producto['unProducto'],abs($producto['cantidad']),$producto['unProducto']-> getCodigoBarra(),$codigo);
          }
  
  
  
          $coleccionI = $objItem -> mostrarItems("codigo= '$codigo'");// busca una coleccion de items con ese codigo de venta
  
           
  
           
  
          $objVenta=  $objTVentaD -> buscarVentaD($codigo); // busca la venta con el codigo
           $objVenta -> setColItems($coleccionI);
    
           $importeFinal = $objTVentaD -> darImpFinalVenta($objVenta); // calcula el importe final de la venta 
  
          
        
       


       
        }


        
        
      

        
      
      
      if($importeFinal > 0){
       $coleccionVentas=$objTienda -> getColVentasRealizadas(); // llama a una coleccion de ventas que se realizaron por la tienda
       array_push($coleccionVentas,$objVenta);// ingresa una nueva venta a la coleccion
       $objTienda -> setColVentasRealizadas($coleccionVentas); // actualiza la coleccion de ventas
      }


       return $importeFinal;
        

        
    }

    /**
     * Recibe como parametro un arreglo asociativo con los productos a vender, la informacion del cliente y la forma de pago. 
     * Busca los productos  , verifica su stock y realiza el registro de la venta en caso de ser necesario. 
     * Retorna un objeto venta con los item correspondiente a aquellos productos que pudo vender
     * @param array $productos
     * @param array $infoCliente
     * @param string $formaPago
     * @param object $objTienda
     * @return object $objVenta
     */
    public function realizarVenta($productos,$infoCliente,$formaPago,$objTienda){
      $ultimaV = 0;
      $productosEncontrados= [];
      foreach ($productos as $producto){

        $objProducto = new Tproducto();
       $encontrado= $objProducto -> buscarProducto($producto['codigoBarra']); // busca el producto en base a su codigo de barra
       

       if($encontrado !=null){ // si lo encuentra lo guardad en un arreglo asociativo
        
       $exito =  $objProducto -> actualizarStock($producto['codigoBarra'],$producto['cantidad']); // verifica que el stock

       $coleccionProductos= $objTienda -> getColProductos();
       array_push($coleccionProductos,$encontrado);     // guardo el producto en el objeto tienda
       $objTienda -> setColProductos($coleccionProductos);

       if($exito){
        
        $productosEncontrados[]= [
          "unProducto" => $encontrado,
          "cantidad" => $producto['cantidad']
        ];
        }else{
          $productosEncontrados= null;
        }
       }

      
      }


      if(!empty($productosEncontrados)){
     $importeF =$this -> registrarVenta($productosEncontrados,$formaPago,$infoCliente, $objTienda);
     if($importeF > 0){
     $coleccionVR= $objTienda -> getColVentasRealizadas(); // llamamos a la coleccion de ventas que se registraron
      $ultimaVentaRegistrada = end($coleccionVR);// seleccionamos la ultima venta registrada

      if($ultimaVentaRegistrada instanceof Venta){
        $objTventa = new Tventa();
        $objTventa -> modificarImpFinalV($ultimaVentaRegistrada,$importeF);
      }
      elseif($ultimaVentaRegistrada instanceof ventaCredito){
        $objTventaC= new TventaC();
        $objTventaC -> modificarImpFinalV($ultimaVentaRegistrada,$importeF);
      }elseif($ultimaVentaRegistrada instanceof ventaDebito){
        $objTventaD = new TventaD();
        $objTventaD -> modificarImpFinalV($ultimaVentaRegistrada,$importeF);
          }
          $ultimaV = $ultimaVentaRegistrada -> getColItems();//retornamos la coleccion de items que se pudo vender en la ultimo objeto venta registrado
        }else{
          $ultimaV = null;
        }
      }

      return $ultimaV;
        
    }




    /**
     * recibe como parametro un tipo de venta y retorna una referencia a la venta con mayor importe realizada por la tienda
     * @param  $tipoVenta
     * @param object $objTienda
     * @return int $codigoVentaMayo
     */

     public function ventaMayorImporte($tipoVenta, $objTienda) {
      $colVentas = $objTienda->getColVentasRealizadas();
      
  
      $ventaMayorImporte = -INF; // inicializa con el valor más pequeño posible
      $codigoVentaMayorImporte = null; // Para almacenar el código de la venta con mayor importe
  
      foreach ($colVentas as $tipo => $ventas) { // Accede al tipo de venta específico
        foreach($ventas as $venta){
          
          if(is_a($venta,$tipoVenta)){
            $importeFinal = $venta->getImporteFinal();
            if($importeFinal > $ventaMayorImporte){
              $ventaMayorImporte = $importeFinal;
              $codigoVentaMayorImporte = $venta -> getCodigoVenta();
            }
          }
        }
          
      }
  
      return $codigoVentaMayorImporte;
  }



  public function ventaMayorXtipoVenta($objTienda){
    

    $ventasMayoritarias=[];

    $objVentaE = $this -> ventaMayorImporte("Venta",$objTienda);
    $objVentaC = $this -> ventaMayorImporte("VentaCredito",$objTienda);
    $objVentaD = $this -> ventaMayorImporte("ventaDebito",$objTienda);


    $ventasMayoritarias= [
      "MayoImporteEfectivo" => $objVentaE ,
      "MayorImporteCredito" => $objVentaC,
      "MayorImporteDebito" => $objVentaD
     
    ];

    return $ventasMayoritarias;
  }
}