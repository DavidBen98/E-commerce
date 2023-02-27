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
        $lista_carrito = array();
        $productos_agregados = 0;

        if ($productos != null){
            $lista_carrito[] = obtener_lista_carrito($productos);
            $productos_agregados = count($lista_carrito);
        }

        $total_precio_unidad = 0; 
        $total_precio_descuento = 0;
        $total_cantidad = 0;
        $total_subtotal = 0;
        $total = 0;

        foreach($lista_carrito as $producto){
            $subtotal = 0;
            $subcategoria = $producto["nombre_subcategoria"];
            $descripcion = ucfirst($producto["descripcion"]);
            $cantidad = intval($producto["cantidad"]);
            $precio = intval($producto["precio"]);
            $descuento = intval($producto["descuento"]);
            $precio_descuento = $precio - (($precio * $descuento) /100);
            $subtotal += $cantidad * $precio_descuento; 
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
                            $precio_descuento
                        </td>
                        <td>
                            $cantidad
                        </td>
                        <td>
                            $subtotal
                        </td>                           
                    </tr>
            ";

            $total_precio_unidad += $precio;
            $total_precio_descuento += $precio_descuento;
            $total_cantidad += $cantidad;
            $total_subtotal += $subtotal;
        }      

        echo "                              
            </tbody>

            <tfoot>
                <tr> 
                    <td colspan='2'>                                                      
                        <b>Totales: </b>
                    </td>   
                    <td>
                        <b>$total_precio_unidad</b>
                    </td>
                    <td>
                        <b>$total_precio_descuento</b>
                    </td>
                    <td>
                        <b>$total_cantidad</b>
                    </td>
                    <td>
                        <b>$total_subtotal</b>
                    </td>                           
                </tr> 
            </tfoot>           
        </table> ";
    ?>	
</body>
</html>