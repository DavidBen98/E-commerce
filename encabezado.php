<?php   
    include_once ("funciones.php");
    $cantCarrito = cantidadCarrito();

    if (perfil_valido(1)){
        // <li><a href='consultas.php'>Consultas</a></li>
        // <li><a href='ventas.php'>Ventas</a></li>
        // <li><a href='usuarios.php'>Usuarios</a></li>
        $encabezado =  " <div id='logo'>
                            <a href='index.php' id='link-logo'> 
                                <h1><i id='titulo-principal' title='Logo del comercio'>Muebles Giannis</i></h1>
                            </a>
                        </div>
                        <div id='buscar'>
                            <input type='text' id='header-buscar' title='Barra de navegación' placeholder='Buscar por producto, marca, categoría...'>
                                <button id='lupa' title='lupa-buscar'>
                                    <img src='images/lupa.png' title='lupa-buscar' alt='Lupa de buscar'  style='width:20px;' height='20' id='perfil'>
                                </button>
                        </div>
                        <div>
                            <img src='images/menu.png' alt='Lupa de buscar' class='header-menu'>
                        </div>
                        "
                        .
                            crear_barra() . "
                    
                        <nav id='navigation'>
                            <ul>
                                <li><a href='veABMProducto.php'>Productos</a></li>
                                <li><a href='veABMCategoria.php'>Categorías</a></li>
                                <li><a href='veABMSubcategoria.php'>Subcategorías</a></li>
                            </ul>
                        </nav> 
        ";
    }
    else {
        $encabezado = "
                        <div id='html-slot'>
                            <span>¡Envíos a todo el país!</span>
                        </div>  
                        <div id='container-header'>
                            <div id='logo'>
                                <a href='index.php' id='link-logo'> 
                                    <h1><i id='titulo-principal' title='Logo del comercio'>Muebles Giannis</i></h1>
                                </a>
                            </div>
                            <div id='buscar'>
                                <input type='text' id='header-buscar' title='Barra de navegación' placeholder='Buscar por producto, marca, categoría...'>
                                <button id='lupa' title='Buscar'>
                                    <img src='images/lupa.png' alt='Lupa de buscar' style='width:20px;' height='20' id='perfil'>
                                </button>
                            </div>"
                            .   crear_barra() . 
                "               
                            <div>
                                <a href='favoritos.php' title='Favoritos' class='header-img' id='usu-fav'>
                                    <img src='images/favoritos.png' alt='Favoritos' style='width:30px;' height='30'>
                                </a>
                                <a href='carritoCompras.php' title='Carrito de compras' class='header-img' id='usu-car'>
                                    <img src='images/carrito.png' alt='Carrito de compras' style='width:30px;' height='30'>
                                    <span id='num-car'>$cantCarrito</span>
                                </a>
                                <div>
                                    <img src='images/menu.png' alt='Lupa de buscar' class='header-menu'>
                                </div>
                            </div>
                        </div>     
                        <nav id='navigation'>
                            <ul>
                                <li><a href='index.php'>Inicio</a></li>
                                <li><a href='productos.php?productos=todos'>Productos</a></li> 
                                <li><a href='contacto.php'>Contacto</a></li>
                            </ul>
                        </nav>
        ";
    }
?>