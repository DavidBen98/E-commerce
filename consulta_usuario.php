<?php 
    include("encabezado.php"); 
    include("pie.php");
    include ("inc/conn.php");

    if (perfil_valido(3)) {
        header("location:index.php");
    }
    else if (perfil_valido(1)) {
        header("location:ve.php");
    } 
  
    $tabla = "<table> 
                    <thead> 
                        <tr>
                            <th>
                                Consulta
                            </th> 
                            <th>
                                Estado
                            </th>                            
                        </tr>
                    </thead>
            ";
                 
    global $db; 
    
    $mail =$_SESSION['email'];

    $sql= "SELECT c.texto, c.respondido
            FROM `consulta` as c INNER JOIN `usuario` as u ON (c.email = u.email)
            WHERE c.email='$mail'
    "; 

    $rs = $db->query($sql);

    $tabla .= "<tbody>";
    foreach ($rs as $row) { 
        $txt = "";                     
        if ($row['respondido']){
            $txt = "Ya fue respondido";
        }
        else{
            $txt = "Pendiente";
        }
        
        $tabla .= "
                    <tr>
                        <td>" .
                                ucfirst($row['texto']) . "
                        </td> 
                        <td> 
                            $txt
                        </td>                            
                    </tr>
        ";       
    };
    $tabla .= "</tbody>
            </table>";
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="css/estilos.css" rel="stylesheet"/>
    <title>Catato Hogar</title>   
    <style>
        main{
            display:flex;
            flex-wrap: wrap;
            justify-content:center;
        }
        table{
            border: 2px solid #000;
            width:600px;
            margin: 40px 0;
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

        .btn{
		   background-color: #D3D3D3;
		   height: 40px;
		   width:200px;
		   cursor:pointer;
		   font-size:1.2rem;
		   border-radius: 5px;
		}

		.btn:hover{
			background-color: #B2BABB ;
            transition: all 0.3s linear;
            color: white;
            cursor:pointer;
		}
    </style>
</head>
<body id="body">
    <header>
        <?php echo $encab; ?> 
    </header>

    <main>
        <?php echo $cont_usuarios;?>
        <?php echo $tabla;?>
    </main>

    <?php
        echo $pie;
    ?>
</body>
</html>