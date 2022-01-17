<!DOCTYPE html>
<?php 
    include ('config.php');
    include("encabezado.php"); 
    include("pie.php"); 
    include ("inc/conn.php");

    if (perfil_valido(3)) {
        header("location:login.php");
    }
    else if (perfil_valido(1)) {
        header("location:ve.php");
    }
?>  
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="css/estilos.css" rel="stylesheet"/>
    <title>Catato Hogar</title>
    <style>
        main{
            display:flex;
            justify-content:center;
        }
        table{
            border: 2px solid #000;
            width:600px;
            margin-bottom: 40px;
        }
        th{
            border: 1px solid #000;
        }

        tr{
            height:30px;
        }

        td{
            border: 1px solid #000;
            text-align:center;
        }

        th{
            border: 2px solid #000;
        }

    </style>
    <script>
		function excel() {			
			document.getElementById("datos").method = "post";
			document.getElementById("datos").action = "carrito_xls.php";
			document.getElementById("datos").submit(); 
		}	
	</script>
</head>
<body id="body">

    <header>
        <?php
		    echo $encab;     
        ?>
    </header>
    
    <main>           
            <?php 
                $idUsuario =$_SESSION['idUsuario'];
                echo"<input type='hidden' name='idUsuario' id='idUsuario' value='$idUsuario'/>";
            ?>
       

        <table>
            <thead>
                <tr>
                    <th>
                        Producto 
                    </th>
                    <th>
                        Descripcion
                    </th>
                    <th>
                        Precio por unidad
                    </th>
                    <th>
                        Cantidad
                    </th>
                    <th>
                        Subtotal
                    </th>
                    
                </tr>
            </thead> 
                      
            <?php 
                global $db; 
                            
                $sql= "SELECT `precio_unidad`,`cantidad`,`producto_codigo`,p.descripcion, u.id
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
                            <?php echo "<img src='images/{$row['producto_codigo']}.png' alt='Codigo del producto:{$row['producto_codigo']}' style='width:200px;heigth:200px'  >"?>
                        </td>                          
                        <td>
                            <?php echo ucfirst($row['descripcion']);?> 
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

        <a href="carrito_xls.php" title='Excel de compras'>
            <img src='images/logo_excel.jpeg' title='Excel de compra.' alt="icono Excel." > 
        </a>              
    </main>

    
    <?php
        echo $pie;
    ?>
    
</body>
</html>