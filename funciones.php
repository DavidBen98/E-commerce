<?php
    require_once 'inc/conn.php';

    function crear_barra() {
        global $user;
        global $perfil;
        $links=''; 

        if (isset($_GET['code']) || isset($_SESSION['user_first_name'])){
            $links = "  <a href='informacionPersonal.php' title='Perfil'> <span>" 
                            . $_SESSION['user_first_name'] . $_SESSION['user_last_name'] .
                        " </span> &nbsp;</a>
                        <a href='logout.php' id='cerrar' title='Cerrar sesión de usuario'> X </a>";
        }
        else if (isset($_SESSION['nombre_tw'])){
            $links = "  <a href='informacionPersonal.php' title='Perfil'> 
                            <span>" . preg_replace('([^A-Za-z0-9])', '', $_SESSION['nombre_tw']) . " </span> &nbsp;
                        </a>
                        <a href='logout.php' id='cerrar' title='Cerrar sesión de usuario'> X </a>";
        }
        else if ($user=='') {
            $links = "<a href='login.php?reg=true' title='Crear una cuenta de usuario' id='btn-registrar'> Registrarse</a>
                        <a href='login.php' title='Iniciar sesión' id='iniciarSesion'> Iniciar sesión</a>";
        } else if($perfil=='E'){
            $links = "  <span title='Nombre de usuario' id='span'> {$_SESSION['nombre']}  </span>
                        <a href='cerrarSesion.php'  id='cerrar' title='Cerrar sesión de usuario'> X </a>";
        } else if($perfil=='U'){
            $links = "<a href='informacionPersonal.php' title='Perfil'> <span> {$_SESSION['user']} </span> &nbsp;</a>
                        <a href='cerrarSesion.php' id='cerrar' title='Cerrar sesión de usuario'> X </a>";
        }
    
        $barra_sup ="<div id='barra-superior'>
                        $links
                    </div> ";
                    
        return  $barra_sup;
    }

    function perfil_valido($opcion) {
        global $perfil; 

        switch($opcion){
            case 1: 
                $valido=($perfil=='E')? true:false; 
                break;
            case 2: 
                $valido=($perfil=='U')? true:false;
                break;	
            case 3: 
                $valido=($perfil=='')? true:false; 
                break;
            default:
                $valido=false;
        }           
        
        return $valido;  
    }

    define('PSW_SEMILLA','34a@$#aA9823$');	
	
	function generar_clave_encriptada($password) {			
		$salt = PSW_SEMILLA;		 
		$psw_encript = hash('sha512', $salt.$password);				
		return $psw_encript; 
	}
    
    $onclick1 = "window.location.href='informacionPersonal.php'";
    $onclick2 = "window.location.href='consultaUsuario.php'";
    $onclick3 = "window.location.href='cerrarSesion.php'";
    $onclick4 = "window.location.href='comprasUsuario.php'";
    $onclick5 = "window.location.href='favoritos.php'";

    $cont_usuarios = "  <div class='contenedor-btn'>        
                            <div onclick=$onclick1 style='border-top-left-radius:5px; border-top-right-radius:5px;'>Datos personales</div>     
                            <div onclick=$onclick4>Mis pedidos</div>
                            <div onclick=$onclick5>Favoritos</div>
                            <div onclick=$onclick2>Historial de consultas</div>
                            <div onclick=$onclick3 style='border-bottom: none; border-bottom-left-radius:5px; border-bottom-right-radius:5px;'>Cerrar sesión</div>
                        </div> 
    ";

    function mostrarInfoPersonal(){
        global $db; 
        $nombreUser = $_SESSION['user'];

        $sql= "SELECT nombreUsuario, perfil, nroDni, nombre, apellido, email, provincia, ciudad, direccion
                FROM `usuario`
                WHERE nombreUsuario='$nombreUser'
        ";  
    
        $rs = $db->query($sql);

        foreach ($rs as $row) {
            echo "<div class='contenedor-botones'> 
                                Nombre de usuario: {$row['nombreusuario']} <br>
                                Numero de DNI: {$row['nrodni']} <br>
                                Nombre: {$row['nombre']} <br>
                                Apellido: {$row['apellido']} <br>
                                Email: {$row['email']} <br>
                                Provincia: {$row['provincia']} <br>
                                Ciudad: {$row['ciudad']} <br>
                                Direccion: {$row['direccion']} <br>
                            </div>
            ";
        }
    }    

    function crearImagenes ($consulta){
		$i=0;	
		echo "<form action='listadoXLS.php' method='post' id='form-filtrado' class='form-prod' name='form-filtrado'>";
			echo "<h1 class='h1' style='display:none; width:100%; text-align:center; margin:0; padding-left: 100px;'> Muebles Giannis - Catálogo </h1>";
        
            if (!$consulta){
                $i++;
                echo "<p>Lo sentimos, ha ocurrido un error inesperado </p>";
            }
            else if (isset($_GET['categoria'])){
                foreach ($consulta as $row) {
                    $i++; 
                    echo "<div class='producto'>
                            <img src='images/{$row['codigo']}.png' class='img-cat' alt='{$row['codigo']}' title='".ucfirst($row['nombre_subcategoria'])."'> 
                            <p class='descripcion'>". ucfirst($row['nombre_subcategoria'])." </p>
                        </div>";           
                };		
            }
            else{
                foreach ($consulta as $row) {
                    $i++; 
                    echo "<div class='producto'>
                            <img src='images/{$row['codigo']}.png' class='img-cat' alt='{$row['codigo']}' title='". ucfirst($row['descripcion'])."'> 
                            <div class='caracteristicas'>
                                <p class='descripcion'>". ucfirst($row['descripcion'])." </p>
                                <p class='precio' style='text-align:center;'> $". ucfirst($row['precio'])." </p>
                            </div>
                        </div>";           
                };
            }

            if ($i == 0){
                echo "<p>No existe ningún resultado que coincida con la búsqueda ingresada </p>";
            }
                    
        echo "	</div>
            </form>
        ";	
	} 

    function completarWhere ($sql,$filtros){
        global $db;
        $rs = "";	
        $where_color = "";
        $where_sql = "";

        if (isset($filtros[0])){
            if (count($filtros[0]) == 1){
                $where_color .= " AND color = '" . $filtros[0][0]. "' ";
            }
            else{
				$where_color .= " AND ( ";
                for ($i=0;$i<count($filtros[0])-1;$i++){ 
                    $where_color .= " color = '". $filtros[0][$i] . "' OR " ;
                }
                $i = count($filtros[0])-1;
                $where_color .= " color = '". $filtros[0][$i] . "') ";
            }
        }

        $where_marca = "";
        if (isset($filtros[1])){
            if (count($filtros[1]) == 1){
                $where_marca .= " AND marca = '" . $filtros[1][0]. "' ";
            }
            else{
				$where_marca .= " AND ( ";
                for ($i=0;$i<count($filtros[1])-1;$i++){
                    $where_marca .= "  marca = '" . $filtros[1][$i]. "' OR ";
                }
                $i = count($filtros[1])-1;
                $where_marca .= " marca = '". $filtros[1][$i] . "') ";
            }
        }

		$where_precio=""; 

		if ($filtros[2] != null){
			$where_sql .= "AND precio >=". $filtros[2];
		}

        if ($filtros[3] != null){
            $where_sql .= " AND precio <= ". $filtros[3];
        }

        $orderBy = "";
		$orderMasVen = 0;

        if(isset($filtros[4])){
            if ($filtros[4] == 0){
                $orderBy = " ORDER BY precio asc ";
            }
            else if ($filtros[4] == 1) {
                $orderBy = " ORDER BY precio desc ";
            }
            else {              
				$orderMasVen++;
            }
        }
		
        if($where_color != "" && $where_marca != ""){
            $where_sql .=  $where_color . $where_marca;
        }
        else if ($where_color != ""){
            $where_sql .=  $where_color;
        }
        else{
            $where_sql .=  $where_marca;
        } 
		
		if($orderMasVen != 0){
			$sql = "SELECT `codigo`, `descripcion`,`precio`, SUM(`cantidad`)
					from `producto` 
					LEFT JOIN `pedido` ON `pedido`.producto_codigo = `producto`.codigo
					$where_sql
					GROUP  BY `codigo`
					ORDER  BY `cantidad` DESC;";
		}
		else{
			$sql .= " $where_sql
                 	    $orderBy";  
		}

        return $sql;       
    }

    function mostrarFiltros ($filtros,$categoria,$subcategoria){
        global $db;  
		$filtro = "";

        if ($filtros[4]!=null){
            if ($filtros[4] == 0){
                $filtro .= "<b>Orden: </b> Menor a mayor precio <br>";
            }
            else if ($filtros[4] == 1){
                $filtro .= "<b>Orden: </b> Mayor a menor precio <br>";
            }
            else{
                $filtro .= "<b>Orden: </b> Más vendidos <br>";
            }
        }

        if (is_int($categoria)){
            $sql  = "SELECT c.nombre_categoria
                    FROM `categoria` as c
                    WHERE c.id_categoria = '$categoria'";
            $resultado = $db->query($sql);
            
            foreach($resultado as $row){
                $cat = $row['nombre_categoria'];
            }
            $filtro .= "<b>Categoría:</b> ". $cat . "<br>";
        }
        else if ($categoria != ""){
            $filtro .= "<b>Categoría:</b> ". $categoria . "<br>";
        }

        if (is_int($subcategoria)){
            $sql  = "SELECT s.nombre_subcategoria
                    FROM `subcategoria` as s
                    WHERE s.id_subcategoria = '$subcategoria'";
            
            $resultado = $db->query($sql);

            foreach($resultado as $row){
                $subcat = $row['nombre_subcategoria'];
            }

            $filtro .= "<b>Subcategoría:</b> ". $subcat . "<br>";
        }
        else if ($subcategoria != ""){
            $filtro .= "<b>Subcategoría:</b> ". $subcategoria . "<br>";
        }

        if (isset($filtros[0])){
            if (count($filtros[0]) == 1){
                $filtro .= "<b>Color: </b>";
            }
            else{
                $filtro .= "<b>Colores: </b>";
            }
            for ($i=0;$i<count($filtros[0]);$i++){ 
                if ($i == count($filtros[0])-1){
                    $filtro .= $filtros[0][$i] . " <br>"; 
                }
                else{
                    $filtro .= $filtros[0][$i] . " - "; 
                }
            }
        }

        if (isset($filtros[1])){
            if (count($filtros[1]) == 1){
                $filtro .= "<b>Marca: </b>";
            }
            else{
                $filtro .= "<b>Marcas: </b>";
            }
            for ($i=0;$i<count($filtros[1]);$i++){ 
                if ($i == count($filtros[1])-1){
                    $filtro .= $filtros[1][$i] . "<br>"; 
                }
                else{
                    $filtro .= $filtros[1][$i] . " - "; 
                }
            }
        }

        if ($filtros[2]!= null){
            $filtro .= '<b>Mínimo:</b> $' . $filtros[2] . "<br> ";
        }

        if ($filtros[3]!= null){
            $filtro .= ' <b>Máximo:</b> $' . $filtros[3];
        }

        return $filtro;
    }

    function cantidadCarrito(){ 
        require_once 'config.php';

        $cantCarrito = 0;   
        if (isset($_SESSION['carrito'])){
            foreach ($_SESSION['carrito']['productos'] as $value){
                $cantCarrito += 1;
            }
        }

        return $cantCarrito;
    }
?>