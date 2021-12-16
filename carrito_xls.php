<?php
    header("Pragma: no-cache");
    header("Expires: 0");
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=carrito_compras.xls");
    header("Content-type: application/vnd.ms-excel");  
    require 'inc/conn.php';  	 	
    include("encabezado.php");    		
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">	
	<title>Catato Hogar</title>
</head>
<body>        
    <table>
        <thead>
            <tr>
                <th>Producto </th>
                <th>Descripcion</th>
                <th>Precio por unidad</th>
                <th>Cantidad</th>
                <th>Subtotal</th>                
            </tr>
        </thead>          
        <?php 
            global $db; 
            
            $idUsuario =$_SESSION['idUsuario'];
               
            $sql= "SELECT `precio_unidad`,`cantidad`,`producto_codigo`,`p`.descripcion, `u`.id
                FROM `pedido` as c INNER JOIN `usuario` as u ON (c.usuario_id=u.id)
                                    INNER JOIN `producto` as p on(c.producto_codigo=p.codigo)
                WHERE u.id=$idUsuario
            "; 
            
            $rs = $db->query($sql);
            $totPrecioUnid = 0;
            $totCant = 0;
            $totSubTotal = 0;
                 
        ?>                               
        <tbody>         
            <?php foreach ($rs as $row) {  ?>                                           
                <tr> 
                    <td>                                                      
                        <?php echo "{$row['producto_codigo']}"?>
                    </td>                         
                    <td>
                        <?php echo "{$row['descripcion']}";?> 
                    </td>
                    <td>
                        <?php echo "{$row['precio_unidad']}";?>        
                        <?php $totPrecioUnid += $row['precio_unidad']?>
                    </td>
                    <td>
                        <?php echo "{$row['cantidad']}";?>
                        <?php $totCant += $row['cantidad']?>
                    </td>
                    <td>
                        <?php 
                            $subTot = $row['precio_unidad'] * $row['cantidad'];
                            echo "$subTot";?>
                        <?php $totSubTotal += $row['precio_unidad'] * $row['cantidad'] ?>
                    </td>                           
                </tr>
            <?php } ?>                               
        </tbody>

        <tfoot>
            <tr> 
                <td colspan="2">                                                      
                    Totales: 
                </td>   
                <td>
                    <?php echo "$totPrecioUnid";?>
                </td>
                <td>
                    <?php echo "$totCant";?>
                </td>
                <td>
                    <?php echo "$totSubTotal";?>
                </td>                           
            </tr> 
        </tfoot>           
    </table> 	
</body>
</html>