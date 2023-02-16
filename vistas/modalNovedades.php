<?php
    $modal_novedades = "
        <div id='modal-novedades'>
            <form action='../controlador/novedades.php' onsubmit='return validarModal()' method='post' name='novedades' id='form-novedades'>
                <h1 class='modal-titulo'>Ingrese su email</h1>
                <label for='modal-email' style='display:none;'>Email</label> 
                <input class='modal-input' type='text' name='modal-email' id='modal-email'>
                <label for='pagina-actual' style='display:none;'>Url</label> 
                <input class='modal-input' type='text' name='modal-url' value='{$_SERVER['REQUEST_URI']}' id='pagina-actual'>
                <div class='contenedor cont-modal' id='cont-modal'>
                    <input type='submit' class='modal-submit btn' value='Suscribirme a las novedades'>
                </div>
                <button class='cerrar-novedades' id='cerrar-novedades' value='Cerrar'> X </button>
            </form>
    ";

    $modal_novedades_error = "";

    if (isset($_GET["sus"])){
        $modal_novedades_error =  "
            <div id='suscripcion'>
                <div id='cont-sus'>
                    <h1> Suscripción realizada con éxito </h1>
                    <p> Ahora el email ingresado estará al tanto de todas nuestras novedades! </p>
                    <button class='cerrar-novedades btn' value='Aceptar'> Aceptar </button>
                    <button class='cerrar-novedades' id='cerrar-novedades' value='Cerrar'> X </button>
                </div>
            </div>
        ";
    } else if (isset($_GET["suserror"])){
        if ($_GET["suserror"] === "1"){
            $modal_novedades_error =  "
                <div id='suscripcion'>
                    <div id='cont-sus'>
                        <h1> Error en la suscripción: el email ingresado no es correcto </h1>
                        <p> El email ingresado no es correcto, asegúrese de que completó el campo correctamente </p>
                        <button class='cerrar-novedades btn' value='Aceptar'> Aceptar </button> 
                        <button class='cerrar-novedades' id='cerrar-novedades' value='Cerrar'> X </button>
                    </div>
                </div>
            ";
        } else {
            $modal_novedades_error =  "
                <div id='suscripcion'>
                    <div id='cont-sus'>
                        <h1> Error en la suscripción </h1>
                        <p> El email ingresado no se encuentra registrado en nuestro sitio</p>
                        <button class='cerrar-novedades btn' value='Aceptar'> Aceptar </button>
                        <button class='cerrar-novedades' id='cerrar-novedades' value='Cerrar'> X </button>
                    </div>
                </div>
            ";
        }
    }

    $modal_novedades .= "</div>";
?>