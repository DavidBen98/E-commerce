<?php
    $modal_novedades = "
        <div id='modal-novedades'>
            <form action='../controlador/novedades.php' onsubmit='return validarModal()' method='post' name='novedades' id='form-novedades'>
                <h1 class='modal-titulo'>Ingrese su email</h1>
                <input class='modal-input' type='text' name='modal-email' id='modal-email'>
                <div class='contenedor cont-modal' id='cont-modal'>
                    <input type='submit' class='modal-submit btn' value='Suscribirme a las novedades'>
                </div>
                <button class='cerrar-novedades' id='cerrar-novedades' value='Cerrar'> X </button>
            </form>
        </div>	
    ";
?>