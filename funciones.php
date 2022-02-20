<?php
    require_once 'inc/conn.php';
    require_once 'config.php';

    define('PSW_SEMILLA','34a@$#aA9823$');

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
	
	function generar_clave_encriptada($password) {			
		$salt = PSW_SEMILLA;		 
		$psw_encript = hash('sha512', $salt.$password);				
		return $psw_encript; 
	}
    
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
                            <h2 class='tituloSubcat'>". ucfirst($row['nombre_subcategoria'])." </h2>
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

    function completarWhere ($select,$from,$innerJoin,$where,$filtros){
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
			$sql = $select . " " .
                   $from . " " .
                   $innerJoin . " " . 
				   "LEFT JOIN `detalle_compra` as `dc` ON `dc`.id_producto = `p`.codigo" . 
                   $where .
				   $where_sql .
                   "GROUP  BY p.`codigo`
					ORDER  BY SUM(dc.`cantidad`) DESC;";
		}
		else{
			$sql = "   $select
                        $from
                        $innerJoin
                        $where
                        $where_sql
                 	    $orderBy
            ";  
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

    function agregarImgCategorias (){
        global $db;
        $sql = "SELECT nombre_categoria, id_categoria
        FROM `categoria`"; 
        
        $rs = $db->query($sql);
      
        foreach ($rs as $row) { //categorias
            $idCat =  $row['id_categoria'];
            $nomCat = $row['nombre_categoria'];

            //agrega la imagen categoria y le pone el titulo 
            echo " <div class='categoria'>
                        <div class='cont-images'> 
                            <img src= 'images/categorias/$idCat.png' alt='$nomCat' class='img-cat'>
                            <div class='texto'>
                                <h2 class='img-titulo'>".strtoupper($nomCat) ."</h2>
            ";

            $sql1 = "SELECT nombre_subcategoria
            FROM `subcategoria`
            INNER JOIN `categoria` ON categoria.id_categoria = subcategoria.id_categoria
            WHERE subcategoria.id_categoria = '$idCat'";
            
            $rs1 = $db->query($sql1);

            echo "<p class='img-texto'>";
            $subcatNombre = " ";
            foreach ($rs1 as $row1){ //subcategorias
                $subcatNombre .= $row1['nombre_subcategoria'] . " <br> ";
            }
            //agrega las diferentes subcategorias que pertenecen a esa categoria
            echo "" .  ucwords($subcatNombre) . "          
                            </p>     
                        </div>
                    </div>
                </div>";
        }
    }  

    function crearBarraLateral(){
		global $db;

		$producto = "";

		if (isset($_GET['articulos'])){ //Si se ingresa desde imagenes
			$producto = $_GET['articulos'];
			$categoria = $_GET['cate'];
			$subcategoria = $_GET['sub']; 
			$form = "<form action='productos.php?articulos=".$producto."&cate=".$categoria."&sub=".$subcategoria."' method='post' id='datos'> 
						<div class='btn-select'>
							<label for='orden' class='label'> Ordenar por </label>
							<select class='form-select' id='orden' name='orden' title='Ordenar elementos'> 
								<option value='0'> Menor precio </option>
								<option value='1'> Mayor precio </option>	
								<option value='2'> Mas vendidos </option>
							</select>
						</div>";
		}
		else if (isset($_GET['productos']) || isset($_GET['buscador'])){ //Si se ingresa desde el nav ->productos o desde la barra de navegacion
			$arrCategorias = [];
			$arrSubcategorias = [];

			$sql  = "SELECT c.id_categoria,c.nombre_categoria,descripcion, material,color,caracteristicas,marca,stock, precio, s.nombre_subcategoria
			FROM `producto`
			INNER JOIN categoria as c ON producto.id_categoria = c.id_categoria
			INNER JOIN subcategoria as s ON producto.id_subcategoria = s.id_subcategoria";
			
			$rs = $db->query($sql);

			foreach ($rs as $row) {
				if(empty($arrCategorias[$row['nombre_categoria']])){
					$arrCategorias[$row['nombre_categoria']] = $row['id_categoria'];						
				}													
			}

			ksort($arrCategorias);
			$form = " 
				<form action='productos.php?productos=filtrado' method='post' id='datos'> 
					<div class='btn-select'>
						<label for='orden' class='label'> Ordenar por </label>
						<select class='form-select' name='orden' id='orden' title='Ordenar elementos'> 
							<option value='0'> Menor precio </option>
							<option value='1'> Mayor precio </option>	
							<option value='2'> Mas vendidos </option>
						</select>
					</div>
					<div class='btn-select'>
						<label for='categoria' class='label'> Categorías </label>
						<select class='form-select' id='categoria' name='categoria' title='Categorias'>";

			foreach($arrCategorias as $indice => $valor){
				$form .=" <option value='$valor'> $indice </option>";
			}

			$form .= "</select>
					</div>
					<div id='subc' class='btn-select'>
				</div>";
		}

		echo $form;

		$arrColores = [];
		$arrMarcas = [];
		$variable = substr($producto,0,4);
		
		$where_sql = " WHERE codigo like '$variable%'";
		
		$sql  = "SELECT id_categoria,descripcion, material,color,caracteristicas,marca,stock, precio, id_subcategoria
				FROM `producto`
				$where_sql";

		$rs = $db->query($sql); 

		foreach ($rs as $row) {
			if(empty($arrColores[$row['color']])){
				$arrColores[$row['color']] = 0;						
			}										
			if(empty($arrMarcas[$row['marca']])){
				$arrMarcas[$row['marca']] = 0;
			}					
		}
		
		$sql1 = "SELECT min(precio) 
						FROM `producto`
						$where_sql
						; ";
		$rs1 = $db->query($sql1);
		
		foreach ($rs1 as $row) {
			$valorMin = implode($row);
		}

		$sql2 = "SELECT max(precio) 
						FROM `producto`
						$where_sql
						; ";
		$rs2 = $db->query($sql2);
		
		foreach ($rs2 as $row) {
			$valorMax = implode($row);
		}
		
		ksort($arrColores);
		
			echo" <fieldset class='colores contenedor'>
						<legend class='ltitulo' for='colores'><b>Colores</b></legend>
						<div id='colores' class='input'>
			";
		
		foreach($arrColores as $indice => $valor){
			$id = str_replace(" ","",$indice);
			echo" 
				<div class='color'>	
					<input type='checkbox' class='input' name='color[]' id='$id' title='Color $indice' value='$indice'>													  																															
					<label for='$id' > ".ucfirst($indice)."</label>			
				</div>			
			";
		}
        echo "</div> 
        </fieldset>";

		ksort($arrMarcas);

		echo"<fieldset class='marcas contenedor'>					
				<legend class='ltitulo'><b>Marcas</b></legend>
				<div id='marcas' class='input'>
		";	

		foreach($arrMarcas as $indice => $valor){
			$id = str_replace(" ","",$indice);
			echo "				
					<div class='marca'>		
						<input type='checkbox' class='input' name='marca[]' id='$id' title='Marca $indice' value='$indice'>													  																															
						<label for='$id'> ".ucfirst($indice)."</label>	
					</div>				
				";
		}
		echo "</div>	
				</fieldset>
				<fieldset id='min-max'>
				    <legend class='ltitulo' style='padding-top:20px;'><b>Precios</b></legend>  
                    <label for='valorMin' class='lmaxmin' style='width: 50%; text-align: end;'>Mínimo -</label> 
                    <label for='valorMax' class='lmaxmin' style='width: 47%; padding-left: 3%;'>Máximo</label>			
					<div class='input-minmax'>
						<input type='number' name='valorMin' id='valorMin' style='text-align:center; height: 20px;' title='Mínimo'  class='min-max' placeholder='$valorMin' min='$valorMin' max='$valorMax' value='' >
						- 
						<input type='number' name='valorMax' id='valorMax' style='text-align:center; height: 20px;' title='Máximo' class='min-max' placeholder='$valorMax' min='$valorMin' max='$valorMax' value='' > 							
					</div>
				</fieldset>	
				<p id='e_error'>

				</p> 
				<div id='botones' class='botones'>
					<input type='submit'  id='filtros' class='btn' name='Aplicar filtros' title='Aplicar filtros' value='Aplicar filtros'>						
				</div>
			</form>";
	}	

    function existeEmail(){
        global $db;

        if ($redSocial == 'Google'){
            $email = $_SESSION['user_email_address'];
            $where = "WHERE (u.email = '$email')";
        }
        else{
            $where = "WHERE (u.email = '%')";
        }

        $sql = "SELECT id_social, id_usuario
                FROM `usuario_rs` as rs
                INNER JOIN `usuario` as u ON rs.id_usuario = u.id  
                $where";

        $resultado = $db->query($sql);

        $existe = false;
        foreach ($resultado as $r){
            $existe = true;
            break;
        }

        return $existe;
    }

    function existeIdUsuario (){    
        global $db;

        $redSocial = $_SESSION['servicio'];

        if ($redSocial == 'Google'){
            $id = $_SESSION['id']; 
        }
        else if ($redSocial == 'Twitter'){
            $id = $_SESSION['user_id'];
        }

        $sql = "SELECT id_social, id_usuario
                FROM `usuario_rs` as rs
                INNER JOIN `usuario` as u ON rs.id_usuario = u.id  
                WHERE id_social = '$id' AND servicio = '$redSocial'";

        $resultado = $db->query($sql);

        $existe = false;
        foreach ($resultado as $r){
            $existe = true;
            break;
        }

        return $existe;
    }

    function existeNombreUsuario (){
        global $db;

        $redSocial = $_SESSION['servicio'];

        if ($redSocial == 'Google'){
            $nombre = $_SESSION['user_first_name'];
            $apellido = $_SESSION['user_last_name'];
            $where = "WHERE nombreUsuario = '$nombre$apellido' AND servicio = '$redSocial'";
        }
        else if ($redSocial == 'Twitter'){
            $nombreUsuario = $_SESSION['nombre_tw'];
            $nombreUsuario = preg_replace('([^A-Za-z0-9])', '', $nombreUsuario);
            $where = "WHERE nombreUsuario = '$nombreUsuario' AND servicio = '$redSocial'";
        }

        $sql = "SELECT nombreUsuario
                FROM usuario
                $where";
        
        $result = $db->query($sql);

        $existe = false;
        foreach ($resultado as $r){
            $existe = true;
            break;
        }

        return $existe;
    }
?>