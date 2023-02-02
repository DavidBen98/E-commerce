<?php
    $modalNovedades = "
        <div id='modal_novedades'>
            <form action='server/novedades.php' onsubmit='return validarModal()' method='post' name='novedades' id='form_novedades'>
                <h1 class='modal_titulo'>Ingrese su email</h1>
                <input class='modal_input' type='text' name='email' id='email'>
                <div class='contenedor'>
                    <input type='submit' class='modal_submit btn' value='Suscribirme a las novedades'>
                </div>
                <button class='cerrar_novedades' id='cerrar_novedades' value='Cerrar'> X </button>
            </form>
        </div>	
    ";
?>