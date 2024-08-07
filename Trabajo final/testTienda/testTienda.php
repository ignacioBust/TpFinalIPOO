<?php
include_once "../ORM/BaseDatos.php";
include_once "../ORM/Item.php";
include_once "../ORM/Producto.php";
include_once "../ORM/Tienda.php";
include_once "../ORM/Venta.php";
include_once "../ORM/VentaCredito.php";
include_once "../ORM/ventaDebito.php";

include_once "../Transaccion/Titems.php";
include_once "../Transaccion/Tproducto.php";
include_once "../Transaccion/Ttienda.php";
include_once "../Transaccion/Tventa.php";
include_once "../Transaccion/TventaC.php";
include_once "../Transaccion/TventaD.php";




function menuOpciones(){
    echo "                MENÚ DE OPCIONES                                                                \n";
    echo"*************************************************************************************************\n";
    echo"*                1) Admistracion de Producto                                                    *\n";
    echo"*                2) Administracion de Tienda                                                    *\n";
    echo"*                3) Administracion de Ventas                                                    *\n";
    echo"*                4) Administracion de Items                                                     *\n";
    echo"*                5) Salir                                                                       *\n";
    echo"*************************************************************************************************\n";
    echo "\n";
    echo "Ingrese la opcion: ";
    $opcion = trim(fgets(STDIN));
    echo "\n";
    return $opcion;

}



function menuDeProducto(){
    
    echo "              OPCIONES DE PRODUCTO                   \n";
    echo "____________________________________________________\n";
    echo"|              1) Ingrear un Producto                |\n";
    echo"|              2) Modificar un Producto              |\n";
    echo"|              3) Mostrar Productos cargados         |\n";
    echo"|              4) Eliminar Productos                 |\n";
    echo"|              5)          Atras                     |\n";
    echo"|____________________________________________________|\n";
    echo "\n";
    echo "Ingrese la opcion: ";
    $opcion = trim (fgets(STDIN));
    echo "\n";
    return $opcion;
}


function menuDeTienda(){
    echo" ____________________________________________________\n";
    echo"|                                                    |\n";
    echo"|              1) Ingresar una Tienda                |\n";
    echo"|              2) Modificar una Tienda               |\n";
    echo"|              3) Mostrar  Tiendas Cargadas          |\n";
    echo"|              4) Eliminar una Tienda                |\n";
    echo"|              5)      Atras                         |\n";
    echo"|                                                    |\n";
    echo"|____________________________________________________|\n";
    echo "\n";
    echo "\nIngrese la opcion: ";
    $opcion = trim(fgets(STDIN));
    echo "\n";
    return $opcion;
}

function menuDeVenta(){
    echo "______________________________________________________________________\n";
    echo"|              1) Realizar una Venta                                   |\n";
    echo"|              2) Modificar una Venta                                  |\n";
    echo"|              3) Mostrar Ventas Realizadas                            |\n";
    echo"|              4) Buscar venta                                         |\n";
    echo"|              5) Eliminar una Venta                                   |\n";
    echo"|              6) Mostrar mayor importe de cada venta                  |\n";
    echo"|              7)          Atras                                       |\n";
    echo"|______________________________________________________________________|\n";
    echo "\n";
    echo "\nIngrese la opcion: ";
    $opcion = trim(fgets(STDIN));
    echo "\n";
    return $opcion;
}




function menuDeItems(){
    
    echo "              OPCIONES DE ITEMS                   \n";
    echo "_____________________________________________________\n";
    echo"|              1) Eliminar un Item                    |\n";
    echo"|              2) Mostrar Items Cargados              |\n";
    echo"|              3)          Atras                      |\n";
    echo"|_____________________________________________________|\n";
    echo "\n";
    echo "Ingrese la opcion: ";
    $opcion = trim (fgets(STDIN));
    echo "\n";
    return $opcion;
}






function muestraElementos($obj, $condicion)
{
    $coleccion = [];

    switch (get_class($obj)){
        case 'Tproducto':
            $coleccion = $obj -> buscarProductosCondicion($condicion);
            break;

        case 'Ttienda' : 
            $coleccion = $obj -> buscarTiendas($condicion);
            break;

        case 'Tventa':
            $coleccion = $obj -> buscarVentasCondicion($condicion);
            break;

        case 'TventaC':
            $coleccion = $obj -> buscarVentasCondicion($condicion);
            break;
        case 'TventaD':
            $coleccion = $obj -> buscarVentasCondicion($condicion);
            break;

        case 'Titems':
            $coleccion = $obj -> mostrarItems($condicion);
            break;
    }

    foreach ($coleccion as $elementos){
        echo "\n***************************************************\n";
        echo "\n" . print_r($elementos) ;
        echo "\n***************************************************\n";
    }


}


function insertarProducto($objProducto)
{
    echo "Ingrese el precio del Producto: ";
    $precio = trim(fgets(STDIN));
    echo "\nIngrese el código de barra: ";
    $codigoBarra = trim(fgets(STDIN));
    echo "\nIngrese el nombre del Producto: ";
    $nombreP = trim(fgets(STDIN));
    echo "\nIngrese la marca del Producto: ";
    $marcaP = trim(fgets(STDIN));
    echo "\nIngrese el Color del Producto: ";
    $colorP = trim(fgets(STDIN));
    echo "\nIngrese la descripcion del Producto: ";
    $descripcionP = trim(fgets(STDIN));
    echo "\nIngrese la cantidad de stock del Producto: ";
    $cantStock = trim(fgets(STDIN));
    
    $exito = $objProducto -> insertarProducto($codigoBarra,$nombreP,$marcaP,$colorP,$descripcionP,$cantStock,$precio);
    
    if($exito){
        echo "\nProducto insertado correctamente.";
    }else{
        echo "\nEl Producto no pudo ser insertado de manera correcta.";
    }
}



function modificarProducto($objProducto)
{
    $colProductos = $objProducto ->buscarProductosCondicion("");
    if(!empty($colProductos)){
        echo "Productos cargados en la BD: ";
        muestraElementos($objProducto, "");


        echo "\nCodigo de Barra de el producto a modificar: ";
        $codigoBarra = trim(fgets(STDIN));
        $objP = $objProducto -> buscarProducto($codigoBarra);
        if($objP !=null){
            echo "\nNuevo nombre de el producto: ";
            $nuevoNombre = trim(fgets(STDIN));
            echo "\nNueva marca del producto: ";
            $nuevaMarca = trim(fgets(STDIN));
            echo "\nNuevo Color del producto: ";
            $nuevoColor = trim(fgets(STDIN));
            echo "\nNueva descripcion del producto: ";
            $nuevaDescripcion = trim(fgets(STDIN));
            echo "\nNueva cantidad de stock: ";
            $nuevaCantStock = trim(fgets(STDIN));
            echo "\nNuevo Precio del Producto: ";
            $nuevoPrecio = trim(fgets(STDIN));

           $exitoMP= $objProducto -> modificarPrecio($objP,$nuevoPrecio);
           $exitoMM= $objProducto ->  modificarMarca($objP,$nuevaMarca);
            $exitoMC= $objProducto -> modificarColor($objP,$nuevoColor);
           $exitoMD= $objProducto -> modificarDescripcion($objP, $nuevaDescripcion);
           $exitoMN= $objProducto ->  modificarNombre($objP,$nuevoNombre);
           $exitoMSC= $objProducto -> modificarStock($objP, $nuevaCantStock);

            if($exitoMP && $exitoMM && $exitoMC && $exitoMD && $exitoMN && $exitoMSC){
                echo "\nProducto modificado correctamente. ";
            }
        } else{
            echo "\nEl producto no ha sido encontrado.";
        }
    }else{
        echo "\nSin productos cargado en la BD.";
    }
}


function eliminarProducto($objProducto)
{
    $coleccionP = $objProducto -> buscarProductosCondicion("");
    if(!empty($coleccionP)){
        echo "Productos cargados en la BD: ";
        muestraElementos($objProducto, "");
        echo "\nCodigo de Barra de el producto a eliminar: ";
        $codigoBarra = trim(fgets(STDIN));
        $objP=  $objProducto -> buscarProducto($codigoBarra);
        
        if($objP != null ){
            echo " ¿Esta seguro de que quiere eliminar este Producto seleccionado? (s/n): ";
            $respuesta = trim(fgets(STDIN));

            if($respuesta == "s"){
                
               $exitoB= $objProducto -> eliminarProducto($codigoBarra);
               
               if($exitoB ){
                echo "Se borro correctamente el producto de la base de datos.";
               }else{
                echo "No pudo borrarse el producto de la base de datos.";
               }
            }else{
                echo "Accion cancelada.";
            }
        }else{
            echo "\nEl Producto no fue encontrado con el codigo de barra ingresado.";
        }   
    }else{
        echo "Sin productos cargados en la base de datos.";
    }
}



// insertar una tienda a la base de datos

function insertTienda($objTtienda){
    echo "Cuit de la tienda: ";
    $cuit = trim(fgets(STDIN));
    echo "\nNombre de la tienda: ";
    $nombreT = trim(fgets(STDIN));
    echo "\nDireccion de la tienda: ";
    $direccionT = trim(fgets(STDIN));
    echo "\nTelefono de la tienda: ";
    $telefonoT = trim(fgets(STDIN));

    $exito= $objTtienda ->insertarTienda($cuit,$nombreT,$direccionT,$telefonoT);

    if($exito){
        echo "\nLa tienda fue ingresada con exito a la base de datos.";
    }else{
        echo "\nLa tienda no pudo ser ingresada a la base de datos.";
    }
}


function modificarTienda($objTtienda){
    $colTiendas = $objTtienda -> buscarTiendas("");
    if(!empty($colTiendas)){
        echo "\nTiendas cargadas en la base de datos: ";
        muestraElementos($objTtienda, "");
        
        echo "\nIngrese el cuit de la tienda a modificar: ";
        $cuit = trim(fgets(STDIN));
        $objT = $objTtienda -> buscarTienda($cuit);
        if($objT != null){
            echo "\nIngrese el nuevo nombre de la tienda: ";
            $nuevoNombre= trim(fgets(STDIN));
            echo "\nIngrese la nueva direccion de la tienda: ";
            $nuevaDireccion = trim(fgets(STDIN));
            echo "\nIngrese el nuevo telefono de la tienda: ";
            $nuevoTelefono= trim(fgets(STDIN));

            $exitoMN = $objTtienda -> modificarNombreT($objT,$nuevoNombre);
            $exitoMD= $objTtienda -> modificarDireccionT($objT,$nuevaDireccion);
            $exitoMT= $objTtienda -> modificarTelefonoT ($objT, $nuevoTelefono);

            if($exitoMN && $exitoMD && $exitoMT){
                echo "\nLa tienda fue modificada correctamente.";
            }else{
                echo "\nLa tienda no pudo ser modificada.";
            }
        }else{
            echo "\nLa tienda no fue encontrada.";
        }
    }else{
        echo "\nNo hay tiendas cargadas en la base de datos";
    }
}




function eliminarTiendas($objTtienda){
    $colTiendas = $objTtienda -> buscarTiendas("");

    if(!empty($colTiendas)){
        echo "\nTiendas cargadas en la base de datos: ";
        muestraElementos($objTtienda, "");
        echo "\n Ingrese el cuit de la tienda a eliminar: ";
        $cuit = trim(fgets(STDIN));
        $objT = $objTtienda -> buscarTienda($cuit);
        if($objT != null){
            echo "\n¿Esta seguro que quiere eliminar esta tienda de la base de datos?(s/n): ";
            $respuesta = trim(fgets(STDIN));
            if($respuesta == "s"){
                $exito = $objTtienda -> eliminarTienda($cuit);

                if($exito){
                    echo "\nLa tienda seleccionada fue borrada con exito de la base de datos.";
                }else{
                    echo "\nNo pudo borrarse la tienda seleccionada de la base de datos.";
                }
            }else{
                echo "\nAccion cancelada.";
            }
        }else{
            echo "\nLa tienda no fue encontrada en la base de datos.";
        }
    }else{
        echo "\nNo hay tiendas cargadas en la base de datos.";
    }
}


function ingresarVenta($objTtienda,$tipoVenta){
    $colProductos = [];
    $infoCliente=[];


    echo "\nEl objeto es: " . get_class($tipoVenta). "\n";

    // busco la tienda en donde voy a realizar la venta
    echo "Ingrese el cuit de la tienda en donde quiere realizar la venta: ";
    $cuit = trim(fgets(STDIN));
   $objTienda= $objTtienda -> buscarTienda($cuit);

   if($objTienda !=null){
    echo"\n********************************\n";
    echo "\n     La tienda fue encontrada.*";
    echo"\n********************************\n";

    // ingreso la cantidad de productos que voy a comprar
    echo "\n¿Cuantos productos va a comprar?: ";
    $cantP = trim(fgets(STDIN));

    // reitera hasta que termine de ingresar los productos
    for ($i=0 ; $i < $cantP ; $i++){
    echo "\nIngrese un codigo de barra del producto que quiere comprar: ";
    $codigoBarra = trim(fgets(STDIN));
    echo "\nIngrese la cantidad del producto que quiere comprar: ";
    $cantidad = trim(fgets(STDIN));

    $colProductos []= [
        "codigoBarra" => $codigoBarra,
        "cantidad" => $cantidad
    ];

    }
   

    if (get_class($tipoVenta) == "Tventa" ){
        echo "\nIngrese a E\n";
        echo "Ingrese el nombre y el apellido del cliente: ";
        $nombreCompleto = trim(fgets(STDIN));
        $infoCliente = ["nombreCompleto" => $nombreCompleto];

    } 
    elseif(get_class($tipoVenta)== "TventaC"){
        echo "\nIngrese C\n";
        echo "\nIngrese su nombre completo: ";
        $nombreCompleto = trim(fgets(STDIN));
        echo "\nIngrese nombre del titular de la tarjeta: ";
        $nombreTitular= trim(fgets(STDIN));
        echo "\nIngrese el numero de la tarjeta: ";
        $numeroTarjeta = trim(fgets(STDIN));
        echo "\nNombre de la empresa emisora de la tarjeta: ";
        $empresaEmisora = trim(fgets(STDIN));
        echo "\nIngrese la cantidad de cuotas en la que desea pagar: ";
        $cantidadCuotas = trim(fgets(STDIN));

        $infoCliente = [
            "nombreCompleto" => $nombreCompleto,
            "nombreTitular" => $nombreTitular,
            "numeroTarjeta" => $numeroTarjeta,
            "empresaEmisora" => $empresaEmisora,
            "cantidadCuotas" => $cantidadCuotas
        ];
    }elseif(get_class($tipoVenta) == "TventaD"){
        echo "\nIngrese a D\n";
        echo "\nIngrese el nombre y apellido del cliente: ";
        $nombreCompleto = trim(fgets(STDIN));
        echo "\nIngrese el tipo de el red de la tarjeta: ";
        $tipoTarjeta = trim(fgets(STDIN));
        echo "\nIngrese el banco emisor de la tarjeta: ";
        $bancoEmisor = trim(fgets(STDIN));

        $infoCliente =[
            "nombreCompleto" => $nombreCompleto,
            "tipoTarjeta" => $tipoTarjeta,
            "bancoEmisor" => $bancoEmisor
        ];
    }

    echo "\nVerifique la forma de pago(E/C/D): ";
    $formaPago = trim(fgets(STDIN));

    
    
    $ItemsVendidos= $objTtienda -> realizarVenta($colProductos,$infoCliente,$formaPago, $objTienda);

    if($ItemsVendidos != null){
        echo "\nEstos son los items que se pudieron vender: \n";
    print_r($ItemsVendidos);
    }else{
        echo "\nProducto insuficionete.\n";
    }

   } else{
    echo "\nLa tienda con ese cuit no se encuentra.";
   }
}


function modificarVenta($objTventa){

   $colVentas = $objTventa -> buscarVentasCondicion("");
    
   if(!empty($colVentas)){
   

    

        if(get_class($objTventa) == "Tventa"){
            echo "Ingrese el codigo de la venta que va a modificar: ";
            $codigo = trim(fgets(STDIN));
            $objVenta = $objTventa -> buscarVenta($codigo);
            if($objVenta != null){
            echo "\nIngrese la fecha nueva que quiere ingresar: ";
            $fechaNueva = trim(fgets(STDIN));
            echo "\nIngrese el nuevo nombre completo del cliente que quiere ingresar: ";
            $nombreCompleto = trim(fgets(STDIN));


            if($objTventa -> modificarFecha($objVenta,$fechaNueva) && $objTventa -> modificarCliente($objVenta,$nombreCompleto)){
                echo "\nLos datos fueron modificado correctamente.";
            }
        }
        } elseif(get_class($objTventa) == "TventaC"){
            echo "Ingrese el codigo de la venta que va a modificar: ";
            $codigo = trim(fgets(STDIN));
            $objVenta = $objTventa -> buscarVentaC($codigo);

            if($objVenta !=null){


            echo "\nIngrese la nueva fecha que quiere ingresar: ";
            $nuevaFecha = trim(fgets(STDIN));
            echo "\nIngrese nuevo nombre completo del cliente que quiere ingresar: ";
            $nombreCompleto = trim (fgets(STDIN));
            echo"\nIngrese el nuevo nombre del titular de la tarjeta: ";
            $nuevoTitular = trim(fgets(STDIN));
            echo "\nIngrese el nuevo numero de la tarjeta: ";
            $nuevoNumero = trim(fgets(STDIN));
            echo "\nIngrese la nuevo empresa emisora: ";
            $empresaEmisora = trim(fgets(STDIN));
            echo "\nIngrese la cantidad de cuotas nuevas que quiere modificar: ";
            $cantidadNueva = trim(fgets(STDIN));

            if($objTventa -> modificarFecha($objVenta, $nuevaFecha) && $objTventa -> modificarCliente($objVenta,$nombreCompleto) && $objTventa-> modificarNombreTitular($objVenta,$nuevoTitular) && $objTventa->modificarNumeroTarjeta($objVenta,$nuevoNumero)&& $objTventa -> modificarEmpresa($objVenta,$empresaEmisora) && $objTventa -> modificarCuotas($objVenta,$cantidadNueva)){
                echo "\nLos datos fueron modificado correctamente.\n";
            }
        }
        } elseif(get_class($objTventa) == "TventaD"){

            echo "Ingrese el codigo de la venta que va a modificar: ";
            $codigo = trim(fgets(STDIN));
            $objVenta = $objTventa -> buscarVentaD($codigo);

            if($objVenta != null){

            echo "\nIngrese la nueva fecha que quiere ingresar: ";
            $nuevaFecha = trim(fgets(STDIN));
            echo "\nIngrese nuevo nombre completo del cliente que quiere ingresar: ";
            $nombreCompleto = trim (fgets(STDIN));
            echo "\nIngrese el nuevo tipo de red de la tarjeta: ";
            $nuevoTipoRed = trim(fgets(STDIN));
            echo "\nIngrese el nuevo banco emisor: ";
            $nuevoBancoEmisor = trim(fgets(STDIN));

            if($objTventa -> modificarFecha($objVenta,$nuevaFecha) && $objTventa -> modificarCliente($objVenta,$nombreCompleto) && $objTventa -> modifcarTipoTarjeta($objVenta,$nuevoTipoRed) && $objTventa ->modificarBancoEmisor($objVenta, $nuevoBancoEmisor)){
                echo "\nLos datos fueron modificado correctamente.\n";
            }
        }
        }

       
    

   }else{
    echo "\nNo hay ventas cargadas.";
   }
}

function buscarVentaEspecifica($objTventa){
    $colVentas = $objTventa -> buscarVentasCondicion("");

    if(!empty($colVentas)){
        echo "Ventas cargadas en la base de datos: \n";
        muestraElementos($objTventa,"");
       
        echo "\nIngrese el codigo de la venta que de sea observar: ";
        $codigo = trim(fgets(STDIN));

        if(get_class($objTventa) == "Tventa"){
        $objVenta = $objTventa -> buscarVenta($codigo);

        }elseif(get_class($objTventa)== "TventaC"){
            $objVenta = $objTventa -> buscarVenta($codigo);

        }elseif(get_class($objTventa)== "TventaD"){
            $objVenta = $objTventa -> buscarVenta($codigo);
        }


        
        if($objVenta != null){
            echo "\nLa venta que se busco es: \n";
            echo $objVenta;
        }else {
            echo "\nLa venta no fue encontrada.";
        }
    }
}



function eliminarVenta( $objTventa){
    $colVentas = $objTventa -> buscarVentasCondicion("");

    if(!empty($colVentas)){
        echo "Ventas cargadas en la base de datos: ";
        muestraElementos($objTventa,"");

        echo "\nIngrese el codigo de la venta que desea eliminar: ";
        $codigo = trim(fgets(STDIN));
        $objVenta = $objTventa -> buscarVenta($codigo);

        if($objVenta != null){
            echo "\n¿Esta seguro de que quiere eliminar esta venta?(s/n): ";
            $respuesta = trim(fgets(STDIN));
            if($respuesta == "s"){
                if($objTventa instanceof Tventa){
                    $exito = $objTventa -> eliminarVenta($codigo);
                    if($exito){
                        echo "\nLa venta fue eliminada con exito.";
                    }else{
                        echo "\nNo pudo eliminarse la venta.";
                    }
                } elseif($objTventa instanceof TventaC){
                    $exito = $objTventa -> eliminarVentaC($codigo);
                    if($exito){
                        echo "\nLa venta fue eliminada con exito.";
                    }else{
                        echo "\nLa venta no pudo eliminarse.";
                    }
                }elseif ($objTventa instanceof TventaD){
                    $exito = $objTventa -> eliminarVentaD($codigo);
                    if($exito){
                        echo "\nLa venta fue eliminada con exito.";
                    }else{
                        echo "\nLa venta no pudo ser eliminada.";
                    }
                }
            }else{
                echo "\nAccion cancelada.";
            }
        }else{
            echo "\nNo fue encontrada la venta con el codigo ingresado.";
        }

    }else{
        echo "\nNo hay ventas cargadas en la base de datos.";
    }
}



function importeMayorDeCadaTipoVenta($objTtienda){
    echo "\nIngrese el cuit de la tienda: ";
    $cuit = trim(fgets(STDIN));
    $objTienda = $objTtienda -> buscarTienda($cuit);

    if($objTienda != null){
       $ventas= $objTtienda -> ventaMayorXtipoVenta($objTienda);
    }else{
        echo "\nNo se encontro la tienda con el cuit ingresado.";
    }

    print_r($ventas);
}



function EliminarItems($objTitems){
    $coleccionItems = $objTitems -> mostrarItems("");

    if(!empty($coleccionItems)){
        echo"\nItems cargados en la Base De Datos: \n";
        muestraElementos($objTitems,"");

        echo"\nIngrese el codigo de barra del item: ";
        $codigoB = trim (fgets(STDIN));
        echo "\nIngrese el codgio del item: ";
        $codigo = trim(fgets(STDIN));
        $objItem = $objTitems -> buscarItem($codigoB,$codigo);


        if($objItem != null){
            echo "\n¿Esta seguro de que quiere eliminar este item? (s/n): ";
            $respuesta = trim(fgets(STDIN));

            if($respuesta == "s"){
                $exito = $objTitems ->  eliminarItem($codigoB,$codigo);

                if($exito){
                    echo "\nEl Item fue eliminado con exito.";
                }else{
                    echo "\nEl Item no pudo ser eliminado.";
                }
            }else{
                echo "\nLa accion fue cancelada.";
            }
        }else{
            echo "\nNo se ha encontrado el item seleccionado.";
        }
    }else{
        echo "\nNo hay Items en la base de datos.";
    }
}








//------------------------------------ Menu---------------------

$objTtienda = new Ttienda();
$objTproducto = new Tproducto();
$objTitems = new Titems();
$objTventa = new Tventa();
$objTventaD = new TventaD();
$objTventaC = new TventaC();



echo "****************************";
echo "\nPROGRAMA\n";

$opcionM = menuOpciones();

while ($opcionM !=5){
    switch ($opcionM){
        case 1: 
            // opcion de producto
            $opcionProducto = menuDeProducto();
            while ($opcionProducto !=5){
                switch($opcionProducto){
                    case 1: 
                        // insertar producto
                        insertarProducto($objTproducto);
                        break;
                    case 2:
                        // modificar Producto
                        modificarProducto($objTproducto);
                        break;
                    case 3: 
                        // mostrar productos
                        if(empty($objTproducto -> buscarProductosCondicion(""))){
                            echo "No hay productos cargados en la base de datos actualmente.";
                        }else{
                            muestraElementos($objTproducto,"");
                        }
                        break;
                    case 4:
                        // eliminar un producto
                        eliminarProducto($objTproducto);
                        break;
                }
                $opcionProducto = menuDeProducto();
            }
            break;

        case 2:
            // opcion de Tienda
            $opcionTienda = menuDeTienda();
            while ($opcionTienda !=5){
                switch($opcionTienda){
                    case 1:
                        //insertar Tienda
                        insertTienda($objTtienda);
                        break;
                    case 2: 
                        // modificar una tienda+
                        modificarTienda($objTtienda);
                        break;
                    case 3:
                        // mostrar tiendas
                        if(empty($objTtienda -> buscarTiendas(""))){
                            echo "No hay tiendas cargadas en la base de datos actualmente.";
                        }else{
                            muestraElementos($objTtienda,"");
                        }
                        break;
                    case 4: 
                        // eliminar una tienda
                        eliminarTiendas($objTtienda);
                        break;
                }
                $opcionTienda = menuDeTienda();
            }
            break;
        case 3: 
            // opcion ventas
            $opcionVenta = menuDeVenta();
            while($opcionVenta !=7){
                switch($opcionVenta){
                    case 1: 
                        //realizar una venta
                        echo "\nIngrese la forma de pago (E/C/D): ";
                        $Pago = trim(fgets(STDIN));
                        
                        if($Pago == "E"){
                            echo "\nIngrese a efectivo\n";
                            $fP= new Tventa();
                            ingresarVenta($objTtienda,$fP);
                            
                        }
                        elseif($Pago == "C"){
                            echo "\nIngrese a credito\n";
                            $fP = new TventaC();
                            ingresarVenta($objTtienda,$fP);
                            
                        }
                        elseif($Pago == "D"){
                            echo "\INgrese  debito\n";
                            $fP = new TventaD();
                            ingresarVenta($objTtienda,$fP);
                            
                        }else{
                            echo "\nIngrese una forma de pago valida.";
                        }

                        break;
                    case 2:
                        // modificar una venta
                        echo "\nIngrese el tipo de venta que quiere modificar (E/C/D): ";
                        $tipoVenta = trim(fgets(STDIN));
                        if($tipoVenta =="E"){
                        modificarVenta($objTventa);
                        }elseif($tipoVenta == "C"){
                            modificarVenta($objTventaC);
                        }elseif($tipoVenta == "D"){
                            modificarVenta($objTventaD);
                        }
                        break;
                    case 3:
                        // mostrar las ventas realizdas
                        
                        muestraElementos($objTventa,"");
                        echo"\n";
                        muestraElementos($objTventaC,"");
                        echo "\n";
                        muestraElementos($objTventaD,"");
                        break;


                    case 4:
                        // buscar venta especifica 
                        echo "Que tipo de venta desea buscar (E/C/D): ";
                        $tipoV = trim(fgets(STDIN));
                        if($tipoV == "E"){
                            buscarVentaEspecifica($objTventa);
                        }
                        elseif($tipoV == "C"){
                            buscarVentaEspecifica($objTventaC);
                        }
                        elseif($tipoV == "D"){
                            buscarVentaEspecifica($objTventaD);
                        }
                        else{
                            echo "\nIngrese una forma de pago valida.";
                        }
                        
                        break;
                    case 5:
                        // eliminamos una venta
                        echo "\nIngrese el tipo de venta que quiere eliminar (E/C/D): ";
                        $tipoVenta = trim(fgets(STDIN));
                        if($tipoVenta == "E"){
                            eliminarVenta($objTventa);
                            
                        }elseif($tipoVenta== "C"){
                            eliminarVenta($objTventaC);
                        }else{
                            eliminarVenta($objTventaD);
                        }
                        break;
                    case 6:
                        // muestra la venta con mayor importe de cada tipo de venta
                        importeMayorDeCadaTipoVenta($objTtienda);
                        break;
                }
                $opcionVenta = menuDeVenta();
            }
            break;
        
        case 4:
            // opciones items
            $opcionItems = menuDeItems();
            while($opcionItems !=3){
                switch($opcionItems){
                    case 1:
                        // Eliminar Items
                        EliminarItems($objTitems);
                        break;
                    case 2:
                        // muestra los items cargados en la base de datos
                        muestraElementos($objTitems, "");
                        break;

                }
                $opcionItems = menuDeItems();
            }
            break;
    }

    $opcionM = menuOpciones();
}