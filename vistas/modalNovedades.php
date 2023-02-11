<?php
    $modal_novedades = "
        <div id='modal_novedades'>
            <form action='../controlador/novedades.php' onsubmit='return validarModal()' method='post' name='novedades' id='form_novedades'>
                <h1 class='modal_titulo'>Ingrese su email</h1>
                <input class='modal_input' type='text' name='modal_email' id='modal_email'>
                <div class='contenedor cont_modal' id='cont_modal'>
                    <input type='submit' class='modal_submit btn' value='Suscribirme a las novedades'>
                </div>
                <button class='cerrar_novedades' id='cerrar_novedades' value='Cerrar'> X </button>
            </form>
        </div>	
    ";
?>