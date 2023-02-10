<?php   
	require_once "../controlador/config.php";
    include "../inc/conn.php";
	require_once "../vendor/autoload.php";
    include "pie.php";
    include "modalNovedades.php";

    if ($perfil == "E"){ 
        header("location:veABMProducto.php");
    }

    //Si se valida el token al iniciar sesion con Google
    if (isset($_GET["code"])) {
		$token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

		if (!isset($token["error"])) {
			$google_client->setAccessToken($token["access_token"]);
	
			$_SESSION["access_token"] = $token["access_token"];
	
			$google_service = new Google_Service_Oauth2($google_client);
	
			$data = $google_service->userinfo->get();
	
			if (!empty($data["given_name"])) {
				$_SESSION["user_first_name"] = $data["given_name"];
			}
	
			if (!empty($data["family_name"])) {
				$_SESSION["user_last_name"] = $data["family_name"];
			}
	
			if (!empty($data["email"])) {
				$_SESSION["user_email_address"] = $data["email"];
			}

            if (!empty($data["id"])) {
				$_SESSION["id"] = $data["id"];
			}

            $_SESSION["servicio"] = "Google";
		}
	}

    include("encabezado.php"); 

    //Si se inicio sesion con Google
    if (isset($_GET["code"])) {
        $nombre = $_SESSION["user_first_name"];
        $apellido = $_SESSION["user_last_name"];
        $email = $_SESSION["user_email_address"];

        $existe = existeIdUsuario();

        if (!$existe){
            $existe = existeEmail();
        }

        //Si ese id que devuelve Google no existe y tampoco existe el email
        if (!$existe){
            $existe = existeNombreUsuario();

            $idUsuario = insertarUsuario($nombre, $apellido, $email, "U", $existe); //ID de la tabla usuario
            $_SESSION["idUsuario"] = $idUsuario;
            $id = $_SESSION["id"];

            insertarUsuarioRS($idUsuario, $id);
        }
        else{
            $resultado = seleccionarUsuarioConEmail($email);

            foreach($resultado as $row){
                $_SESSION["idUsuario"] = $row["id_usuario"];
            }
        }
    }

    /*
    Si se inicio sesion con Twitter
    No se va a utilizar - API de pago
    else if (isset($_SESSION["user_id"])){
        $id = $_SESSION["user_id"];
        $_SESSION["servicio"] = "Twitter";
        $_SESSION["perfil"] = "U"; 

        $existe = existeIdUsuario();

        //Si ese id que devuelve Twitter no existe
        if (!$existe){
            $nombreUsuario = $_SESSION["nombre_tw"];
            $nombreUsuario = preg_replace("([^A-Za-z0-9])", "", $nombreUsuario);
            
            $existe = existeNombreUsuario();

            //Si no existe una persona con ese nombre de usuario
            if (!$existe){
                $sql = "INSERT INTO usuario (nombreUsuario, perfil) VALUES
                        ('$nombreUsuario', 'U')
                ";
            }
            else{
                $nombreUsuario = $_SESSION["arroba_tw"];

                $result = seleccionarUsuarioConNombreUsuario($nombreUsuario);
                $i=0;

                foreach ($result as $r){
                    $i++;
                }
                //Si no existe una persona con el nombre de usuario = arroba de twitter
                if ($i == 0){
                    $sql = "INSERT INTO usuario (nombre_usuario, perfil) VALUES
                            ('$nombreUsuario', 'U')
                    ";
                }
                //TODO: Sino unir el nombre y el arroba y ver si existe algun usuario con ese nombre de usuario
                //En el caso de que exista un usuario con nombre+arroba probar con arroba+nombre
                //Sino ver algo para hacer por defecto
            }
            
            $db->query($sql);

            $idUsuario = $db->lastInsertId(); //ID de la tabla usuario

            $sql = "INSERT INTO usuario_rs (id_usuario, id_social, servicio) VALUES
                    ('$idUsuario', '$id', 'Twitter')
            ";

            $db->query($sql);  
            
            $_SESSION["id_tw"] = $idUsuario;
        }
        else{         
            $rs = seleccionarUsuarioConId($id);

            foreach ($rs as $row){
                $_SESSION["id_tw"] = $row["id"];
            }
        }
    } */

    $suscripcion="";

    if (isset($_GET["sus"])){
        $suscripcion = "
            <div id='suscripcion'>
                <div id='cont-sus'>
                    <h1> Suscripción realizada con éxito </h1>
                    <p> Ahora el email ingresado estará al tanto de todas nuestras novedades! </p>
                    <button class='cerrar_novedades btn' value='Aceptar'> Aceptar </button>
                    <button class='cerrar_novedades' id='cerrar_novedades' value='Cerrar'> X </button>
                </div>
            </div>
        ";
    } else if (isset($_GET["error"])){
        if ($_GET["error"] === "1"){
            $suscripcion = "
                <div id='suscripcion'>
                    <div id='cont-sus'>
                        <h1> Error en la suscripción: el email ingresado no es correcto </h1>
                        <p> El email ingresado no es correcto, asegúrese de que completó el campo correctamente </p>
                        <button class='cerrar_novedades btn' value='Aceptar'> Aceptar </button> 
                        <button class='cerrar_novedades' id='cerrar_novedades' value='Cerrar'> X </button>
                    </div>
                </div>
            ";
        } else {
            $suscripcion = "
                <div id='suscripcion'>
                    <div id='cont-sus'>
                        <h1> Error en la suscripción </h1>
                        <p> El email ingresado no se encuentra registrado en nuestro sitio</p>
                        <button class='cerrar_novedades btn' value='Aceptar'> Aceptar </button>
                        <button class='cerrar_novedades' id='cerrar_novedades' value='Cerrar'> X </button>
                    </div>
                </div>
            ";
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="../assets/css/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="../images/iconos/logo_sitio.png">
    <title>Muebles Giannis</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@200;400;500;600;700;800;900&display=swap");

        #main{
            padding: 1.5% 0;
        }

        .categorias {
            width: 100%;
            /* height: 100vh; */
            font-family: "Inter", sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .cont-images img{
            transition: all 0.5s linear;
            width: 200px;
            height: 500px;
            opacity: 0.7;
            object-fit:cover;
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
            width:180px;
            height:40px;
            color: white;
            border-radius: 5px;
        }

        .img-texto{
            background-color: rgba(0,0,0,0.8);
            min-width:160px;
            margin:auto;
            color: white;
            text-align: center;
            border-radius: 5px;
            font-size: 18px;
            font-weight: 200;
            color: white;
            padding: 2%;
        }

        .contenedor{
            width:100%;
            display: flex;
            flex-wrap: wrap;
        }

        .btn{
            margin: auto;
        }

        .cards {
            display: flex;
            border-radius: 1rem;
            overflow: hidden;
            gap: 10px;
        }

        .card {
            height: 500px;
            width: 150px;
            background-size: cover;
            background-position: center;
            opacity: 0.8;
            background-color: #000;
            transition: all 0.5s ease-in-out;
            border-radius: 1rem;
        }

        .card:hover {
            opacity: 1;
            cursor: pointer;
        }

        .active {
            transition: all 0.5s ease-in-out;
            height: 500px;
            width: 700px;
            opacity: 1;
        }

        .icon_container {
            width: 100px;
            transition: all 0.5s ease-in-out;
        }

        .icon {
            stroke: #fff;
            opacity: 1;
        }

        .info_container {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .active .info_container {
            background-image: linear-gradient(
            90deg,
            rgba(0, 0, 0, 0.6) 0%,
            rgba(255, 255, 255, 0) 100%
            );
            border-radius: 20px;
        }

        .info {
            display: none;
            opacity: 0;
            transition: all 0.5s ease-in-out;
            padding: 10px 15px;
        }

        .active .info {
            display: flex;
            flex-direction: column;
            opacity: 1;
            transition: all 0.5s ease-in-out;
        }

        .active .icon_container {
            width: 60px;
            transition: all 0.5s ease-in-out;
        }

        @media screen and (max-width: 1120px) {
            .categorias{
                grid-template-columns: repeat(4, 1fr);
            }            
        }

        @media screen and (max-width: 860px) {
            .categorias{
                grid-template-columns: repeat(3, 1fr);
            }            
            
            .img-cat{
                height:400px;
            }
        }

        @media screen and (max-width: 620px) {
            .categorias{
                grid-template-columns: 1fr;
            }            
            
            .img-cat{
                height:300px;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="../js/funciones.js"></script>
    <script>
        document.addEventListener ("DOMContentLoaded", () => {
            // Eliminar eventos de clic
            const cards = document.querySelectorAll(".card");
            // Añadimos un evento en cada click
            cards.forEach((card) => {
                card.addEventListener("click", () => {
                    if (card.classList.contains("active")) {
                        card.classList.toggle("active");
                    } else {
                        cards.forEach((card) => {
                            card.classList.remove("active");
                        });
                        
                        card.classList.add("active");
                        card.addEventListener("click", () => {
                            window.location = "subcategoria.php?categoria="+card.id;
                        });
                    }
                })
            });
        });
    </script>
</head>
<body id="body">
    <header> 
        <?= $encabezado; ?>
        <?= $encabezado_mobile; ?>
    </header>

    <main id="main" class="main">

        <form class="categorias">
            <?= agregarImgCategorias(); ?>
        </form>

        <?= $modalNovedades; ?>
        <?= $suscripcion; ?>
    </main>

    <footer id="pie">
		<?= $pie; ?> 
	</footer>  
</body>
</html>