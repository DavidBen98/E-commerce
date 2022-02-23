<?php   
	include('config.php');
    include("pie.php");
    include ("inc/conn.php");
	require_once('vendor/autoload.php');

    if ($perfil == "E"){ 
        header("location:ve.php");
    }

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

            $_SESSION['servicio'] = 'Google';
		}
	}

    include("encabezado.php"); 

    //Si se inicio sesion con Google
    if (isset($_GET["code"])) {
        $nombre = $_SESSION['user_first_name'];
        $apellido = $_SESSION['user_last_name'];
        $email = $_SESSION['user_email_address'];

        $existe = existeIdUsuario();

        if (!$existe){
            $existe = existeEmail();
        }

        //Si ese id que devuelve Google no existe y tampoco existe el email
        if (!$existe){
            $existe = existeNombreUsuario();
            
            //Si no existe una persona con ese nombre de usuario
            if (!$existe){
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
            $sql = "SELECT id_social, id_usuario
                    FROM `usuario_rs` as rs
                    INNER JOIN `usuario` as u ON rs.id_usuario = u.id  
                    WHERE (u.email = '$email')";

            $resultado = $db->query($sql);

            foreach($resultado as $row){
                $_SESSION['idUsuario'] = $row['id_usuario'];
            }
        }
    }//Si se inicio sesion con Twitter
    else if (isset($_SESSION["user_id"])){
        $id = $_SESSION['user_id'];
        $_SESSION['servicio'] = 'Twitter';
        $_SESSION['perfil'] = 'U'; 

        $existe = existeIdUsuario();

        //Si ese id que devuelve Twitter no existe
        if (!$existe){
            $nombreUsuario = $_SESSION['nombre_tw'];
            $nombreUsuario = preg_replace('([^A-Za-z0-9])', '', $nombreUsuario);
            
            $existe = existeNombreUsuario();

            //Si no existe una persona con ese nombre de usuario
            if (!$existe){
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
                //TODO: Sino unir el nombre y el arroba y ver si existe algun usuario con ese nombre de usuario
                //En el caso de que exista un usuario con nombre+arroba probar con arroba+nombre
                //Sino ver algo para hacer por defecto
            }
            
            $db->query($sql);

            $usuario_id = $db->lastInsertId(); //ID de la tabla usuario

            $sql = "INSERT INTO usuario_rs (id_usuario, id_social, servicio) VALUES
                    ('$usuario_id', '$id', 'Twitter')";

            $db->query($sql);  
            
            $_SESSION['id_tw'] = $usuario_id;
        }
        else{
            $sql = "SELECT u.id
                    FROM usuario as u 
                    INNER JOIN usuario_rs as rs ON u.id = rs.id_usuario
                    WHERE rs.id_social = '$id'";
            
            $rs = $db->query($sql);

            foreach ($rs as $row){
                $_SESSION['id_tw'] = $row['id'];
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="images/logo_sitio.png">
    <title>Muebles Giannis</title>
    <style>
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
            color: white;
            opacity:0;
        }

        .img-titulo{
            display:flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: normal;
            background-color: rgba(0,0,0,0.8);
            border-radius:5px;
            width:180px;
            height:40px;
        }

        .img-texto{
            background-color: rgba(0,0,0,0.8);
            border-radius:5px;
            width:160px;
            margin:auto;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="js/funciones.js"></script>
    <script>
        document.addEventListener ('DOMContentLoaded', () => {
            let imgCat = document.getElementsByClassName('img-cat');
            let txtCat = document.getElementsByClassName('texto');

            for (i=0;i<imgCat.length;i++){
                let img = imgCat[i];
                let txt = txtCat[i];

                img.addEventListener ("mouseover", () => {ponerMouse(txt,img);});
                img.addEventListener ("mouseout", ()=>{img.style.transform="scale(1)";
                                                    txt.style.opacity = "0";}
                                    ); 
                txt.addEventListener ("mouseover", () => {ponerMouse(txt,img);});
            };

            let imagenes = document.getElementsByClassName('cont-images');
            for (j=0;j<imagenes.length;j++){
                let imagen = imgCat[j].getAttribute('alt');
                imagenes[j].addEventListener("click", () => {
                    window.location = 'subcategoria.php?categoria='+imagen;
                });
            }
        });
    </script>
</head>
<body id="body">
    <header> 
        <?= $encab; ?>
    </header>

    <main id='main' class='main'>

        <form class="categorias">
            <?= agregarImgCategorias(); ?>
        </form>

    </main>

    <footer id='pie'>
		<?= $pie; ?> 
	</footer>  
</body>
</html>