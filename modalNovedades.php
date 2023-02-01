<?php
    $modalNovedades = "
        <div id='modal_novedades'>
            <form action='novedades.php' method='post' name='novedades' id='form_novedades'>
                <h1 class='modal_titulo'>Ingrese su email</h1>
                <input class='modal_input' type='text' name='email' id='email' required>
                <input type='submit' class='modal_submit btn' value='Suscribirme a las novedades'>
                <button class='cerrar_novedades' id='cerrar_novedades' value='Cerrar'> X </button>
            </form>
        </div>	
    ";
?>