<?php
    require 'inc/conn.php';

    function crear_barra() {
        global $user;
        global $perfil;
        $links=''; 

        if (isset($_GET['code']) || isset($_SESSION['user_first_name'])){
            $links = "  <a href='informacion_personal.php' title='Perfil'> <span>" 
                            . $_SESSION['user_last_name'] . ", ". $_SESSION['user_first_name'] . 
                        " </span> &nbsp;</a>
                        <a href='logout.php' title='Cerrar sesión de usuario'> X </a>";
        }
        else if (isset($_SESSION['nombre_tw'])){
            $links = "  <a href='informacion_personal.php' title='Perfil'> 
                            <span>" . preg_replace('([^A-Za-z0-9])', '', $_SESSION['nombre_tw']) . " </span> &nbsp;
                        </a>
                        <a href='logout.php' title='Cerrar sesión de usuario'> X </a>";
        }
        else if ($user=='') {
            $links = "<a href='login.php?reg=true' title='Crear una cuenta de usuario' id='btn-registrar'> Registrarse</a>
                        <a href='login.php' title='Iniciar sesión' id='iniciarSesion'> Iniciar sesión</a>";
        } else if($perfil=='E'){
            $links = "  <span title='Nombre de usuario' id='span'> {$_SESSION['nombre']}  </span>
                        <a href='cerrar_sesion.php'  id='cerrar' title='Cerrar sesión de usuario'> X </a>";
        } else if($perfil=='U'){
            $links = "<a href='informacion_personal.php' title='Perfil'> <span> {$_SESSION['user']} </span> &nbsp;</a>
                        <a href='cerrar_sesion.php' title='Cerrar sesión de usuario'> X </a>";
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
    $onclick1 = "window.location.href='informacion_personal.php'";
    $onclick2 = "window.location.href='consulta_usuario.php'";
    $onclick3 = "window.location.href='cerrar_sesion.php'";

    $cont_usuarios = "  <div class='contenedor-botones'>        
                            <button class='btn' onclick=$onclick1>Informacion personal</button>                                        
                            <button class='btn' onclick=$onclick2>Historial de consultas</button>
                            <button class='btn' onclick=$onclick3>Cerrar sesion</button>
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
		echo "<form action='listado_xls.php' method='post' id='form-filtrado' class='form-prod' name='form-filtrado'>";
		
        if (!$consulta){
            $i++;
			echo "<p>Lo sentimos, ha ocurrido un error inesperado </p>";
		}
        else if (isset($_GET['cat']) && $_GET['cat'] != 'productos'){

			foreach ($consulta as $row) {
				$i++; 
				echo "<div class='producto'>
						<img src='images/{$row['codigo']}.png' class='img-cat' alt='{$row['codigo']}' title=''> 
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

		if (isset($filtros[2]) && isset($filtros[3])){
			$where_sql .= "AND precio >= $filtros[2] AND precio <= $filtros[3] ";
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
?>