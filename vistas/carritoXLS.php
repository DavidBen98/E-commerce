<?php
    header("Pragma: no-cache");
    header("Expires: 0");
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=carrito_compras.xls");
    header("Content-type: application/vnd.ms-excel");  
    require "../inc/conn.php";  	 	
    include "encabezado.php";    		
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">	
	<title>Muebles Giannis</title>
</head>
<body>
    <?php 
        echo "<table>
                    <thead>
                        <caption><b>Carrito de compras<b></caption>
                        <tr>
                            <th>Producto </th>
                            <th>Descripción</th>
                            <th>Precio por unidad</th>
                            <th>Precio con descuento</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>                
                        </tr>
                    </thead> 
        ";         
 
        $productos = isset ($_SESSION["carrito"]["productos"]) ? $_SESSION["carrito"]["productos"] : null;
        $listaCarrito = array();
        $productosAgregados = 0;

        if ($productos != null){
            foreach ($productos as $key => $cantidad){
                $listaCarrito[] = obtener_producto_con_cantidad([$key], $cantidad);
            }
            $productosAgregados = count($listaCarrito);
        }

        $totPrecioUnid = 0; 
        $totPrecioDesc = 0;
        $totCantidad = 0;
        $totSubTotal = 0;
        $total = 0;

        foreach($listaCarrito as $producto){
            $subtotal = 0;
            $subcategoria = $producto["nombre_subcategoria"];
            $descripcion = ucfirst($producto["descripcion"]);
            $cantidad = intval($producto["cantidad"]);
            $precio = intval($producto["precio"]);
            $descuento = intval($producto["descuento"]);
            $precioDescuento = $precio - (($precio * $descuento) /100);
            $subtotal += $cantidad * $precioDescuento; 
            $total += $subtotal;             
                            
            echo "<tbody>                                        
                    <tr>
                        <td>
                            $subcategoria
                        </td>                     
                        <td>
                            $descripcion
                        </td>
                        <td>
                            $precio     
                        </td>
                        <td>
                            $precioDescuento
                        </td>
                        <td>
                            $cantidad
                        </td>
                        <td>
                            $subtotal
                        </td>                           
                    </tr>
            ";

            $totPrecioUnid += $precio;
            $totPrecioDesc += $precioDescuento;
            $totCantidad += $cantidad;
            $totSubTotal += $subtotal;
        }      

        echo "                              
            </tbody>

            <tfoot>
                <tr> 
                    <td colspan='2'>                                                      
                        <b>Totales: </b>
                    </td>   
                    <td>
                        <b>$totPrecioUnid</b>
                    </td>
                    <td>
                        <b>$totPrecioDesc</b>
                    </td>
                    <td>
                        <b>$totCantidad</b>
                    </td>
                    <td>
                        <b>$totSubTotal</b>
                    </td>                           
                </tr> 
            </tfoot>           
        </table> ";
    ?>	
</body>
</html>