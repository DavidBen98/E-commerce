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
                 
    global $db;
    
    if (isset($_SESSION['idUsuario'])){ //si se inició sesion desde una cuenta nativa
        $id_usuario = $_SESSION['idUsuario'];
    }
    else if (isset($_SESSION['id'])){ //Si se inicio sesion desde Google
        $id_usuario = $_SESSION['id'];
    }
    else if (isset($_SESSION["user_id"])){ //Si se inicio sesion desde twitter
        $id_usuario = $_SESSION["user_id"];
    }

    if (!isset($_SESSION['idUsuario'])){
        $sql = "SELECT u.id
                FROM usuarios as u
                INNER JOIN usuarios_rs as rs ON rs.id = u.id
                WHERE rs.id_social = $id_usuario
        ";

        $rs = $db->execute($sql);

        foreach ($rs as $row){
            $id_usuario = $row['id'];
        }
    }

    $sql= "SELECT `descripcion`, `material`, `color`, `caracteristicas`, `marca` , `precio`,`codigo`,p.`id`
            FROM `producto` as p 
            INNER JOIN `favorito` as f on p.id = f.id_producto 
            WHERE f.id_usuario = '$id_usuario'
    "; 

    $rs = $db->query($sql);

    $div = "<div class='consulta'>
                <div class='renglon' style='border-bottom:1px solid #858585; height:40px;'>      
                    <p style='height:40px; width:100%; font-size:1.3rem;padding:0;margin:0;display: flex; justify-content: center;align-items: center;'>
                        <b>Favoritos</b>
                    </p>
                </div>            
    ";
    $i = 0;

    foreach ($rs as $row){
        $i++;
    }

    $rs = $db->query($sql);

    $selectNumero = 1; 
    if ($i == 0){
                $div .= "<div style='width:30%;'></div>
                            <div style='margin:10px; width:50%;'> Aún no hay productos favoritos</div>
                <div style='width:60%;'></div>";

        $div .= "<div class='continuar'>
                        <button type='button' class='btn-final' id='continuar' style='margin-left:40px;'>
                            Continúa comprando
                        </button>
                </div>";

        if (isset($_GET['elim'])){
            $div .= "<div class='mensaje'>¡El producto se ha eliminado correctamente!</div>";
        }
        $div .= "</div>";    
    }
    else{
        foreach ($rs as $row) { 
            $descripcion = $row['descripcion'];
            $material = $row['material'];
            $color = $row['color'];
            $caracteristicas = $row['caracteristicas'];
            $marca = $row['marca'];
            $precio = $row['precio'];
            $codigo = $row['codigo'];
            $id = $row['id'];
    
            $div.= "<div class='contenedor'>
                        <div class='descripcion'> 
                            <div class='principal'>                                                                                          
                                <img src='images/$codigo.png' class='productos' alt='Codigo del producto:$codigo'>
                                    <div class='titulo'>
                                        <p style='color:#000; margin-top:10px;'>$descripcion</p> 
                                        <p style='font-size:16px;'>$marca</p> 
                                        <div class='elim-fav'>
                                            <div class='elim-producto' style='width:45%; padding-right: 8px; border-right: 1px solid #D3D3D3;' >
                                                <img src='images/eliminar.png' style='width:20px; height:20px; margin-right:1px;' alt='Eliminar producto'>
                                                <a id='elim-prod-$selectNumero' class='elim-prod' onclick='eliminarFavorito($id)'> Eliminar producto</a>
                                            </div>
                                            <div class='elim-producto' style='text-align:end;'>
                                                <img src='images/carrito.png' style='width:20px; height:20px; margin-right:1px;' alt='Agregar al carrito'>
                                                <a id='agregar-fav-$selectNumero' class='fav-prod' onclick='agregarProducto($id)'> Agregar al carrito</a>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class='secundario'>
                                    <p class='definir'> 
                                        <b>Color:</b>
                                    </p> 
                                    <p class='caract'> $color </p>
                                    <p class='definir'> 
                                        <b>Material:</b>
                                    </p> 
                                    <p class='caract'>$material</p>
                                    <p class='definir'> 
                                        <b>Precio:</b>
                                    </p> 
                                    <p>$$precio</p>
                            </div>                                            
                        </div>
                    </div>
            ";
        
            $selectNumero++;
        }
        if (isset($_GET['elim'])){
            $div .= "<div class='mensaje'>¡El producto se ha eliminado correctamente!</div>";
        }
        $div .= "</div>";
    }
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="css/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="images/logo_sitio.png">
    <title>Muebles Giannis</title> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script>
        window.onload = function (){
            let continuar = document.getElementById('continuar');

            continuar.addEventListener("click", () => {
                window.location = "productos.php?productos=todos";
            });  
        }
          
		function agregarProducto (id){
			var param = {
				id: id
			};

			$.ajax({
				data: param,
				url: "agregarCarrito.php",
				method: "post",
				success: function(data) {
					var datos = JSON.parse(data);

					if (datos['ok']){
						let cantCarrito = document.getElementById('num-car');
						cantCarrito.innerHTML = datos.numero;

						let pExito = document.getElementsByClassName('parrafo-exito');

						if (pExito[0] == null){
							var contenedor = document.getElementsByClassName('consulta');
							var parrafo = document.createElement("p");
							parrafo.setAttribute("class","parrafo-exito");
							var contenido = document.createTextNode("¡Se ha añadido el producto de manera exitosa!");

							parrafo.appendChild(contenido);
							contenedor[0].appendChild(parrafo);
						}
					}
				}
			});			
		}  

        function eliminarFavorito (id){
			var param = {
				id: id
			};

			$.ajax({
				data: param,
				url: "eliminarFavorito.php?id="+id,
				method: "post",
				success: function(data) {
                    console.log(data);
					if (data == 'ok'){
                        window.location.href = 'favoritos.php?elim=ok';
					}
				}
			});			
		}
    </script>
    <style>
        main{
            display:flex;
            flex-wrap: wrap;
            justify-content:start;
        }

        .contenedor{
            display: flex;
            justify-content:space-between;
            flex-wrap:wrap;
            align-items:center;
            border-bottom: 1px solid #D3D3D3;
            width:100%;
            height:180px;
            padding:10px 0;
            margin: 0 10px;
        }

        .contenedor-btn{
            width:100%;
            background-color: white;
            border-radius: 5px;
            text-align:center;
            border: 1px solid #000;
            transition: all 0.3s linear;
        }

        .contenedor-btn div{
            width:100%;
            text-align:center;
            border-bottom: 1px solid #d3d3d3;
            transition: all 0.3s linear;
            padding: 10px 0;
        }

        .contenedor-btn div:hover{
            cursor: pointer;
            background-color: rgba(147, 81, 22,0.2);
            transition: all 0.3s linear;
        }

        .consulta{
            width:75%;
            background-color:white;
            display:flex;
            flex-wrap:wrap;
            justify-content: center;
            border-radius:5px;
            border: 1px solid black;
            margin-bottom: 30px;
            padding: 0 10px;
        }

        .renglon{
            width:100%;
            display:flex;
            justify-content:center;
            margin:0;
        }

        .productos{
            width: 160px;
            height:160px;
            padding-right: 10px;
            object-fit: contain;
        }

        .descripcion{
            width:100%;
            height:90%;
            display:flex;
            justify-content:start;
        }

        .precio{
            width:250px;
            height: 100%;
            display: flex;
            align-content: center;
            flex-wrap:wrap;
            justify-content:space-between;
            border-left: 1px solid #D3D3D3;
        }

        .precio p{
            width:45%;
            font-size: 1rem;
            height: 30px;
            margin: 0;
        }

        .precio div{
            width:45%;
            font-size: 1rem;
            height: 30px;
            margin: 0;
        }

        .cont-btn{
            display:flex;
            justify-content:space-between;
            margin: 0 10px;
            height: 60px;
            border-bottom: 1px solid #D3D3D3;
            padding-top: 10px;
        }

        .checkout{
            width:200px;
        }

        .principal{
            width:65%;
            display:flex;
            justify-content:start;
            flex-wrap:wrap;
            height: 160px;
        }

        .principal p{
            width:200px;
            margin: 0;
            text-align:start;
            height: auto;
        }

        .secundario{
            width:45%;
            display:flex;
            flex-wrap:wrap;
            align-content:start;
        }

        .secundario p{
            margin: 10px 0;
            color: #000;
            text-align:start;
            font-size: 1rem;
        }

        .definir{
            width:30%;
        }

        .caract{
            width:70%;
        }

        .mercadopago-button{
            height:40px;
            width: 250px;
            font-weight: 700;
        }

        .mercadopago-button:hover{
            background: #099;
            transition: all 0.3s linear;
        }

        .titulo{
            width:255px;
            height: auto;
        }

        .contenedor-botones{
            justify-content: end;
            flex-wrap: wrap;
            padding-bottom: 10px;
            width:20%;
            display:block;
            margin: 0 20px 20px 10px;
        }

        .botones{
            height:100%;
            width:250px;
            margin: 0 10px;

        }

        .botones .checkout {
            height: 20%;
        }

        .continuar{
            height: 20%;
        }

        .btn-final{
            margin-top:10px;
        }

        .totales{
            display:flex;
            width:250px;
            margin: 0;
            justify-content:center;
        }

        .subtotal{
            background-color: #E9E9E9;
            font-size: 0.75rem;
        }

        .total{
            background-color: #D3D3D3;
        }

        .txt-totales{
            display:flex;
            align-items:center;
            width: 50%;
            font-family: museosans500,arial,sans-serif;
            padding-left: 10px;
            margin: 0;
            color: #000;
        }

        .continuar button{
            width:250px;
            height: 40px;
            background: rgba(147, 81, 22,0.5);
            border-radius: 5px;
            border: none;
            font-weight: 700;
            cursor: pointer;
        }

        .continuar button:hover{
            background-color: rgba(147, 81, 22,1);
            transition: all 0.3s linear;
            color: white;
            cursor:pointer;
        }

        .cant-compra{
            padding: 5px 10px;
        }

        .elim-fav{
            display:flex;
            justify-content:space-between;
            width:100%;
            text-align:start;
            margin-top:20px;
            font-size: 0.75rem;
            align-items:center;
        }

        .elim-producto{
            color: #858585;
            display: flex;
            align-items: center;
        } 
        
        .fav-prod{
            padding-left: 2px;
            transition: all 0.5s linear;
            color: #858585;
        }

        .elim-prod{
            transition: all 0.5s linear;
            color: #858585;
        }

        .fav-prod:hover, .elim-prod:hover{
            color: #000;
            transition: all 0.5s linear;
            font-size: 0.8rem;
            cursor: pointer;
        }

        .mensaje{
            width:100%;
            margin: 10px;
            text-align: center;
            background-color: #000;
            color: white;
            border-radius:5px;
            padding: 10px 0;
            font-size: 1.1rem;
        }

        .mensaje a{
            text-decoration: underline;
            color: white;
            transition: all 0.5s linear;
        }

        .mensaje a:hover{
            font-size:1.2rem;
            transition: all 0.5s linear;
        }

        .parrafo-exito{
            background-color: #099;
			width:100%;
			padding: 5px 0;
			color: white;
			margin-top: 20px;
			border-radius: 5px;
			text-align:center;
		}
    </style>
</head>
<body id="body">
    <header>
        <?php echo $encab; ?> 
    </header>

    <main>
        <?php 
            echo "<div class='contenedor-botones'>
                    $cont_usuarios
                  </div>";

            echo $div;
        ?>  
    </main>

    <?php
        echo $pie;
    ?>
</body>
</html>