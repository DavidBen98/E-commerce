<?php   
    include("pie.php");
    include ("inc/conn.php");
	include('config.php');
	require_once('vendor/autoload.php');

    if ($perfil == "E"){ 
        header("location:ve.php");
    }

    $auth = new TwitterAuth($cliente);

    //Si se valida el token al iniciar sesion con Google
    if (isset($_GET["code"])) {
		$token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
		if (!isset($token['error'])) {
			$google_client->setAccessToken($token['access_token']);
	
			$_SESSION['access_token'] = $token['access_token'];
	
			$google_service = new Google_Service_Oauth2($google_client);
	
			$data = $google_service->userinfo->get();
	
			if (!empty($data['given_name'])) {
				$_SESSION['user_first_name'] = $data['given_name'];
			}
	
			if (!empty($data['family_name'])) {
				$_SESSION['user_last_name'] = $data['family_name'];
			}
	
			if (!empty($data['email'])) {
				$_SESSION['user_email_address'] = $data['email'];
			}

            if (!empty($data['id'])) {
				$_SESSION['id'] = $data['id'];
			}

		}
	}

    include("encabezado.php"); 

    //Hacer funciones: existeUsuario y existeEmail

    //Si se inicio sesion con Google
    if (isset($_GET["code"])) {
        //Ver si ese usuario está registrado
        $id = $_SESSION['id']; 
        $email = $_SESSION['user_email_address'];

        $sql = "SELECT id_social, id_usuario
                FROM `usuario_rs` as rs
                INNER JOIN `usuario` as u ON rs.id_usuario = u.id  
                WHERE (id_social = '$id' OR u.email = '$email')";

        $resultado = $db->query($sql);
        $i = 0;
        foreach ($resultado as $r){
            $i++;
        }

        //Si ese id que devuelve Google no existe y tampoco existe el email
        if ($i == 0){
            $nombre = $_SESSION['user_first_name'];
            $apellido = $_SESSION['user_last_name'];

            $sql = "SELECT nombreUsuario
                    FROM usuario
                    WHERE nombreUsuario = '$nombre$apellido'";
            
            $result = $db->query($sql);

            foreach ($result as $r){
                $i++;
            }

            //Si no existe una persona con ese nombre de usuario
            if ($i == 0){
                $sql = "INSERT INTO usuario (nombreUsuario, nombre, apellido, email, perfil) VALUES
                ('$nombre$apellido','$nombre', '$apellido', '$email', 'U')";
            }
            else{
                $sql = "INSERT INTO usuario (nombre, apellido, email, perfil) VALUES
                ('$nombre', '$apellido', '$email', 'U')";
            }
            
            $db->query($sql);

            $usuario_id = $db->lastInsertId(); //ID de la tabla usuario
            $_SESSION['idUsuario'] = $usuario_id;

            $sql = "INSERT INTO usuario_rs (id_usuario, id_social, servicio) VALUES
            ('$usuario_id', '$id', 'Google')";

            $db->query($sql);
        }
        else{
            $resultado = $db->query($sql);

            foreach($resultado as $row){
                $_SESSION['idUsuario'] = $row['id_usuario'];
            }
        }

    }//Si se inicio sesion con Twitter
    else if (isset($_SESSION["user_id"])){
        $id = $_SESSION['user_id']; 

        $sql = "SELECT id_social
                FROM `usuario_rs` as rs
                INNER JOIN `usuario` as u ON rs.id_usuario = u.id  
                WHERE (id_social = '$id')";

        $resultado = $db->query($sql);
        $i = 0;
        foreach ($resultado as $r){
            $i++;
        }

        //Si ese id que devuelve Twitter no existe
        if ($i == 0){
            $nombreUsuario = $_SESSION['nombre_tw'];
            $nombreUsuario = preg_replace('([^A-Za-z0-9])', '', $nombreUsuario);
            $sql = "SELECT nombreUsuario
                    FROM usuario
                    WHERE nombreUsuario = '$nombreUsuario'";

            $result = $db->query($sql);

            foreach ($result as $r){
                $i++;
            }

            //Si no existe una persona con ese nombre de usuario
            if ($i == 0){
                $sql = "INSERT INTO usuario (nombreUsuario, perfil) VALUES
                ('$nombreUsuario', 'U')";
            }
            else{
                $nombreUsuario = $_SESSION['arroba_tw'];

                $sql = "SELECT nombreUsuario
                    FROM usuario
                    WHERE nombreUsuario = '$nombreUsuario'";

                $result = $db->query($sql);
                $i=0;

                foreach ($result as $r){
                    $i++;
                }
                //Si no existe una persona con el nombre de usuario = arroba de twitter
                if ($i == 0){
                    $sql = "INSERT INTO usuario (nombreUsuario, perfil) VALUES
                            ('$nombreUsuario', 'U')";
                }
                //Sino unir el nombre y el arroba y ver si existe algun usuario con ese nombre de usuario
                //En el caso de que exista un usuario con nombre+arroba probar con arroba+nombre
                //Sino ver algo para hacer por defecto
            }
            
            $db->query($sql);

            $usuario_id = $db->lastInsertId(); //ID de la tabla usuario

            $sql = "INSERT INTO usuario_rs (id_usuario, id_social, servicio) VALUES
            ('$usuario_id', '$id', 'Twitter')";

            $db->query($sql);    
        }
    }
    
    function agregarImgCategorias (){
        global $db;
        $sql = "SELECT nombre_categoria, id_categoria
        FROM `categoria`"; 
        
        $rs = $db->query($sql);
      
        foreach ($rs as $row) { //categorias
            $idCat =  $row['id_categoria'];
            $nomCat = $row['nombre_categoria'];

            //agrega la imagen categoria y le pone el titulo 
            echo " <div class='categoria'>
                        <div class='cont-images'> 
                            <img src= 'images/categorias/$idCat.png' alt='$nomCat' class='img-cat'>
                            <div class='texto'>
                            <p class='img-titulo'>".
                                strtoupper($nomCat) .
                            "</p>";

            $sql1 = "SELECT nombre_subcategoria
            FROM `subcategoria`
            INNER JOIN `categoria` ON categoria.id_categoria = subcategoria.id_categoria
            WHERE subcategoria.id_categoria = '$idCat'";
            
            $rs1 = $db->query($sql1);

            echo "<p class='img-texto'>";
            $subcatNombre = " ";
            foreach ($rs1 as $row1){ //subcategorias
                $subcatNombre .= $row1['nombre_subcategoria'] . " <br> ";
            }
            //agrega las diferentes subcategorias que pertenecen a esa categoria
            echo "" .  ucwords($subcatNombre) . "          
                            </p>     
                        </div>
                    </div>
                </div>";
        }
    }  
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="css/estilos.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="js/funciones.js"></script>
    <title>Catato Hogar</title>
    <style>
        #main{
            background-color: #fef7f1;
            padding-top: 30px;
        }

        .categorias {
            display: flex;
            flex-wrap: wrap;
            padding-left:15%;
            padding-right:15%;
        }

        .categoria{
            display:flex;
            justify-content:center;
            width:50%;
            height:400px;
            align-items:center;
        }

        .cont-images img{
            border-radius: 5px;
            transition: all 0.5s linear;
            width: 300px;
            height: 300px;
        }    

        .cont-images{
            position: relative;
            display: inline-block;
            text-align: center;
            cursor: pointer;
        }

        .texto{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #ecab0f;
            opacity:0;
        }

        .img-titulo{
            display:flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2em;
            background-color: rgba(0,0,0,0.45);
            border-radius:5px;
            width:180px;
            height:40px;
        }

        .img-texto{
            background-color: rgba(0,0,0,0.45);
            border-radius:5px;
            width:160px;
            margin:auto;
        }
    </style>
    <script>
        function ponerMouse(texto,imagen){
            texto.style.transition = "opacity 0.4s linear";
            texto.style.opacity = "1";
            imagen.style.transform="scale(0.9)";
            imagen.style.borderRadius= "10px";
        }

        window.onload = function() {
           let img_cat = document.getElementsByClassName('img-cat');
           let txt_cat = document.getElementsByClassName('texto');
           let main = document.getElementById('main');
 
            for (i=0;i<img_cat.length;i++){
                let img = img_cat[i];
                let txt = txt_cat[i];

                img.addEventListener ("mouseover", () => {ponerMouse(txt,img);});
                img.addEventListener ("mouseout", ()=>{img.style.transform="scale(1)";
                                                       txt.style.opacity = "0";;}
                                     ); 
                txt.addEventListener ("mouseover", () => {ponerMouse(txt,img);});
            };

            let imagenes = document.getElementsByClassName('cont-images');
            for (j=0;j<imagenes.length;j++){
                let imagen = img_cat[j].getAttribute('alt');
                imagenes[j].addEventListener("click", () => {
                    window.location = 'subcategoria.php?categoria='+imagen;
                });
            };
        };
    </script>
</head>
<body id="body">
    <header> 
        <?php echo $encab;  ?>
    </header>

    <main id='main'>
        <form class="categorias">
            <?php agregarImgCategorias(); ?>
        </form>
    </main>
    <?php
        echo $pie;
    ?>   
</body>
</html>