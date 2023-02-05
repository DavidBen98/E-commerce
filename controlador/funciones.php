<?php
    if (str_contains($_SERVER["REQUEST_URI"],"controlador")){
        require_once '../inc/conn.php';
    } else{
        require_once 'inc/conn.php';
    }
    require_once 'config.php';

    define('PSW_SEMILLA','34a@$#aA9823$');

    define ('CONT_USUARIOS', "<div class='contenedor-btn'>        
                                <div id='btnInfoPersonal'>Datos personales</div>     
                                <div id='btnCompraUsuario'>Mis pedidos</div>
                                <div id='btnFavoritos'>Favoritos</div>
                                <div id='btnConsultas'>Historial de consultas</div>
                                <div id='btnCerrarSesion'>Cerrar sesión</div>
                            </div> "
    );

    function crear_barra_mobile() {
        global $user;
        global $perfil;
        $links=''; 

        if (isset($_GET['code']) || isset($_SESSION['user_first_name'])){
            $links = "  <a href='informacionPersonal.php' title='Perfil'> <span>" 
                            . $_SESSION['user_first_name'] . $_SESSION['user_last_name'] .
                        " </span> &nbsp;</a>
                        <a href='controlador/logout.php' id='cerrar' title='Cerrar sesión de usuario'> X </a>";
        }
        else if (isset($_SESSION['nombre_tw'])){
            $links = "  <a href='informacionPersonal.php' title='Perfil'> 
                            <span>" . preg_replace('([^A-Za-z0-9])', '', $_SESSION['nombre_tw']) . " </span> &nbsp;
                        </a>
                        <a href='controlador/logout.php' id='cerrar' title='Cerrar sesión de usuario'> X </a>";
        }
        else if ($user=='') {
            $links = "<a href='login.php?reg=true' title='Crear una cuenta de usuario' id='btn-registrar'> Registrarse</a>
                        <a href='login.php' title='Iniciar sesión' id='iniciarSesion'> Iniciar sesión</a>";
        } else if($perfil=='E'){
            $links = "  <span title='Nombre de usuario' id='span'> {$_SESSION['nombre']}  </span>
                        <a href='controlador/cerrarSesion.php'  id='cerrar' title='Cerrar sesión de usuario'> X </a>";
        } else if($perfil=='U'){
            $links = "<a href='informacionPersonal.php' title='Perfil'> <span> {$_SESSION['user']} </span> &nbsp;</a>
                        <a href='controlador/cerrarSesion.php' id='cerrar' title='Cerrar sesión de usuario'> X </a>";
        }
    
        $barraSuperior ="<div id='mobile-perfilUsuario'>
                        $links
                    </div> ";
                    
        return  $barraSuperior;
    }

    function crear_barra() {
        global $user;
        global $perfil;
        $links=''; 

        if (isset($_GET['code']) || isset($_SESSION['user_first_name'])){
            $links = "  <a href='informacionPersonal.php' title='Perfil'> <span>" 
                            . $_SESSION['user_first_name'] . $_SESSION['user_last_name'] .
                        " </span> &nbsp;</a>
                        <a href='controlador/logout.php' id='cerrar' title='Cerrar sesión de usuario'> X </a>";
        }
        else if (isset($_SESSION['nombre_tw'])){
            $links = "  <a href='informacionPersonal.php' title='Perfil'> 
                            <span>" . preg_replace('([^A-Za-z0-9])', '', $_SESSION['nombre_tw']) . " </span> &nbsp;
                        </a>
                        <a href='controlador/logout.php' id='cerrar' title='Cerrar sesión de usuario'> X </a>";
        }
        else if ($user=='') {
            $links = "<a href='login.php?reg=true' title='Crear una cuenta de usuario' id='btn-registrar'> Registrarse</a>
                        <a href='login.php' title='Iniciar sesión' id='iniciarSesion'> Iniciar sesión</a>";
        } else if($perfil=='E'){
            $links = "  <span title='Nombre de usuario' id='span'> {$_SESSION['nombre']}  </span>
                        <a href='controlador/cerrarSesion.php'  id='cerrar' title='Cerrar sesión de usuario'> X </a>";
        } else if($perfil=='U'){
            $links = "<a href='informacionPersonal.php' title='Perfil'> <span> {$_SESSION['user']} </span> &nbsp;</a>
                        <a href='controlador/cerrarSesion.php' id='cerrar' title='Cerrar sesión de usuario'> X </a>";
        }
    
        $barraSuperior ="<div id='perfilUsuario'>
                        $links
                    </div> ";
                    
        return  $barraSuperior;
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
		$pswEncript = hash('sha512', $salt.$password);				
		return $pswEncript; 
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
    
    function obtenerRutaPortada($id){
        global $db;

        $sql = "SELECT * FROM imagen_productos 
        WHERE id_producto = $id AND portada=1";

        $result = $db -> query($sql);

        $path = '';

        foreach ($result as $r){
            $path = $r['destination'];
        }

        return $path;
    }

    function crearImagenes ($consulta){
		$i=0;	

		echo "<form action='listadoXLS.php' method='post' id='form-filtrado' class='form-prod' name='form-filtrado'>
			    <h1 class='h1'> Muebles Giannis - Catálogo </h1>";
        
            if (!$consulta){
                $i++;
                echo "<p>Lo sentimos, ha ocurrido un error inesperado </p>";
            }
            else if (isset($_GET['categoria'])){
                //subcategoria.php
                foreach ($consulta as $row) {
                    $path = $row['destination'];

                    $i++; 
                    echo "<div class='producto'>
                            <img src='$path' class='img-cat' id='$i' alt='".ucfirst($row['nombre_subcategoria'])."' title='".ucfirst($row['nombre_subcategoria'])."'> 
                            <h2 class='tituloSubcat'>". ucfirst($row['nombre_subcategoria'])." </h2>
                        </div>
                    ";           
                };		
            }
            else{
                //productos.php
                foreach ($consulta as $row) {
                    $id = "'".$row['id'] . "'";
                    $path = obtenerRutaPortada($id);

                    $i++; 
                    echo "<div class='producto'>
                            <img src='$path' class='img-cat' id='$i' alt='{$row['codigo']}' title='". ucfirst($row['descripcion'])."'> 
                            <div class='caracteristicas'>
                                <h2 class='descripcion'>". ucfirst($row['descripcion'])." </h2>
                                <div class='descripcionPrecio'>";
                                    if ($row['descuento'] != 0){
                                        $precioDescuento = $row['precio'] - ($row['precio']*$row['descuento']/100);
                                        echo "<h3 class='precio'>
                                                 $". $precioDescuento ." 
                                              </h3>
                                              <h3 class='precio' id='h3Precio'>
                                                 $". ucfirst($row['precio']).
                                            " </h3>
                                        ";
                                    }
                                    else{
                                        echo "<h3 class='precio'> $". ucfirst($row['precio'])." </h3>";
                                    }
                    echo"       </div>
                            </div>
                        </div>
                    ";           
                };
            }

            if ($i == 0){
                echo "
                    <div id='producto-vacio'>
                        <p> No existe ningún resultado que coincida con la búsqueda ingresada </p>
                        <a href='index.php'>Regresar al inicio </a>
                    </div>
                "; 
                
            }
                    
        echo "	</div>
            </form>
        ";	
	} 

    function completarWhere ($select,$from,$innerJoin,$where,$filtros){
        global $db;
        $rs = "";	
        $whereColor = "";
        $whereSql = "";

        if (isset($filtros[0])){
            if (count($filtros[0]) == 1){
                $whereColor .= " AND color = '" . $filtros[0][0]. "' ";
            }
            else{
				$whereColor .= " AND ( ";
                for ($i=0;$i<count($filtros[0])-1;$i++){ 
                    $whereColor .= " color = '". $filtros[0][$i] . "' OR " ;
                }
                $i = count($filtros[0])-1;
                $whereColor .= " color = '". $filtros[0][$i] . "') ";
            }
        }

        $whereMarca = "";
        if (isset($filtros[1])){
            if (count($filtros[1]) == 1){
                $whereMarca .= " AND marca = '" . $filtros[1][0]. "' ";
            }
            else{
				$whereMarca .= " AND ( ";
                for ($i=0;$i<count($filtros[1])-1;$i++){
                    $whereMarca .= "  marca = '" . $filtros[1][$i]. "' OR ";
                }
                $i = count($filtros[1])-1;
                $whereMarca .= " marca = '". $filtros[1][$i] . "') ";
            }
        }

		$wherePrecio=""; 

		if ($filtros[2] != null){
			$whereSql .= "AND precio >=". $filtros[2];
		}

        if ($filtros[3] != null){
            $whereSql .= " AND precio <= ". $filtros[3];
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
		
        if($whereColor != "" && $whereMarca != ""){
            $whereSql .=  $whereColor . $whereMarca;
        }
        else if ($whereColor != ""){
            $whereSql .=  $whereColor;
        }
        else{
            $whereSql .=  $whereMarca;
        } 

		if($orderMasVen != 0){
			$sql = $select . " " .
                   $from . " " .
                   $innerJoin . " " . 
				   "LEFT JOIN `detalle_compra` as `dc` ON `dc`.id_producto = `p`.codigo" . 
                   $where .
				   $whereSql .
                   "GROUP  BY p.`codigo`
					ORDER  BY SUM(dc.`cantidad`) DESC;
            ";
		}
		else{
			$sql = "$select
                    $from
                    $innerJoin
                    $where
                    $whereSql
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
                    WHERE c.id_categoria = '$categoria'
            ";
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
                    WHERE s.id_subcategoria = '$subcategoria'
            ";
            
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
                FROM `categoria`
                WHERE activo = '1'
        "; 
        
        $rs = $db->query($sql);
      
        foreach ($rs as $row) { //categorias
            $idCat =  $row['id_categoria'];
            $nomCat = $row['nombre_categoria'];

            //agrega la imagen categoria y le pone el titulo 
            // echo " <div class='categoria'>
            //             <div class='cont-images'> 
            //                 <img src= 'images/categorias/$idCat.png' alt='$nomCat' class='img-cat'>
            //                 <div class='texto'>
            //                     <h2 class='img-titulo'>".strtoupper($nomCat) ."</h2>
            // ";

            $sql = "
                SELECT * 
                FROM imagen_categorias
                WHERE id_categoria = '$idCat'
            ";
            
            $result = $db->query($sql);

            foreach ($result as $r){
                $imgCat = $r['destination'];
            }

            echo " <div class='cont-images'> 
                        <img src= '$imgCat' alt='$nomCat' class='img-cat'>
                        <div class='texto'>
                            <h2 class='img-titulo'>".strtoupper($nomCat) ."</h2>
            ";

            $sql1 ="SELECT nombre_subcategoria
                    FROM `subcategoria`
                    INNER JOIN `categoria` ON categoria.id_categoria = subcategoria.id_categoria
                    WHERE subcategoria.id_categoria = '$idCat'
            ";
            
            $rs1 = $db->query($sql1);

            echo "<p class='img-texto'>";
            $subcatNombre = "";
            foreach ($rs1 as $row1){ //subcategorias
                $subcatNombre .= $row1['nombre_subcategoria'] . " <br> ";
            }

            //agrega las diferentes subcategorias que pertenecen a esa categoria
            // echo "" .  ucwords($subcatNombre) . "          
            //                 </p>     
            //             </div>
            //         </div>
            //     </div>
            // ";

            echo "" .  ucwords($subcatNombre) . "          
                            </p>     
                        </div>
                </div>
            ";
        }
    }  

    function crearBarraLateral(){
		global $db;

		$producto = "";

		if (isset($_GET['articulos'])){ //Si se ingresa desde subcategorias
			$producto = $_GET['articulos'];
			$categoria = $_GET['cate'];
			$subcategoria = $_GET['sub']; 
			$formulario = "<form action='productos.php?articulos=".$producto."&cate=".$categoria."&sub=".$subcategoria."' method='post' id='datos'> 
						<div class='btn-select'>
							<label for='orden' class='label'> Ordenar por </label>
							<select class='form-select' id='orden' name='orden' title='Ordenar elementos'> 
								<option value='0'> Menor precio </option>
								<option value='1'> Mayor precio </option>	
								<option value='2'> Mas vendidos </option>
							</select>
						</div>
            ";
		}
		else if (isset($_GET['productos']) || isset($_GET['buscador'])){ //Si se ingresa desde el nav ->productos o desde la barra de navegacion
			$arrCategorias = [];
			$arrSubcategorias = [];
            $categoria = "%";
            $subcategoria = "%";

			$sql  = "SELECT c.id_categoria,c.nombre_categoria,descripcion, material,color,caracteristicas,marca,stock, precio, s.nombre_subcategoria
                    FROM `producto`
                    INNER JOIN categoria as c ON producto.id_categoria = c.id_categoria
                    INNER JOIN subcategoria as s ON producto.id_subcategoria = s.id_subcategoria
            ";
			
			$rs = $db->query($sql);

			foreach ($rs as $row) {
				if(empty($arrCategorias[$row['nombre_categoria']])){
					$arrCategorias[$row['nombre_categoria']] = $row['id_categoria'];						
				}													
			}

			ksort($arrCategorias);
			$formulario = " 
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
						<select class='form-select' id='categoria' name='categoria' title='Categorias'>
            ";

			foreach($arrCategorias as $indice => $valor){
				$formulario .=" <option value='$valor'> $indice </option>";
			}

			$formulario .= "</select>
					</div>
					<div id='subc' class='btn-select'>
				</div>
            ";

		}

		echo $formulario;

		$arrColores = [];
		$arrMarcas = [];
		//$variable = substr($producto,0,4);
		
		//$whereSql = " WHERE codigo like '$variable%'";
        $innerJoin = " INNER JOIN subcategoria as s on p.id_subcategoria = s.id_subcategoria
					   INNER JOIN categoria as c on c.id_categoria = p.id_categoria 
        ";

		$whereSql = " WHERE s.nombre_subcategoria like '$subcategoria' AND c.nombre_categoria like '$categoria'";

		$sql  = "SELECT p.id_categoria, p.id_subcategoria,descripcion, material,color,caracteristicas,marca,stock, precio
				FROM `producto` as p
                $innerJoin
				$whereSql
        ";

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
                 FROM `producto` as p
                 $innerJoin
                 $whereSql
		";

		$rs1 = $db->query($sql1);
		
		foreach ($rs1 as $row) {
			$valorMin = implode($row);
		}

		$sql2 = "SELECT max(precio) 
                FROM `producto` as p
                $innerJoin
                $whereSql
		";

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
				    <legend class='ltitulo'><b>Precios</b></legend>  
                    <label for='valorMin' class='lmaxmin'>Mínimo -</label> 
                    <label for='valorMax' class='lmaxmin'>Máximo</label>			
					<div class='input-minmax'>
						<input type='number' name='valorMin' id='valorMin' title='Mínimo'  class='min-max' placeholder='$valorMin' min='$valorMin' max='$valorMax' value='' >
						- 
						<input type='number' name='valorMax' id='valorMax' title='Máximo' class='min-max' placeholder='$valorMax' min='$valorMin' max='$valorMax' value='' > 							
					</div>
				</fieldset>	
				<p class='mensaje' id='mensaje'>

				</p> 
				<div id='botones' class='botones'>
					<input type='submit'  id='filtros' class='btn' name='Aplicar filtros' title='Aplicar filtros' value='Aplicar filtros'>						
				</div>
			</form>
        ";
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
                $where
        ";

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
                WHERE id_social = '$id' AND servicio = '$redSocial'
        ";

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
                $where
        ";
        
        $result = $db->query($sql);

        $existe = false;
        foreach ($resultado as $r){
            $existe = true;
            break;
        }

        return $existe;
    }

    function obtenerMarcas() {
        global $db;

		$arrMarcas = [];

        $sql  = "SELECT marca
				FROM `producto` as p
        ";

		$rs = $db->query($sql); 

		foreach ($rs as $row) {										
			if(empty($arrMarcas[$row['marca']])){
				$arrMarcas[$row['marca']] = 0;
			}					
		}

		ksort($arrMarcas);

        $marcas = '';

		foreach($arrMarcas as $indice => $valor){
			$id = str_replace(" ","",$indice);
			$marcas .= "				
					<div class='marca'>		
						<input type='radio' class='input' name='marca' id='$id' title='Marca $indice' value='$indice'>													  																															
						<label for='$id'> ".ucfirst($indice)."</label>	
					</div>				
			";
		}

        return $marcas;
    }

    function obtenerMateriales() {
        global $db;

		$arrMateriales = [];

        $sql  = "SELECT material
				FROM `producto` as p
        ";

		$rs = $db->query($sql); 

		foreach ($rs as $row) {										
			if(empty($arrMateriales[$row['material']])){
				$arrMateriales[$row['material']] = 0;
			}					
		}

		ksort($arrMateriales);

        $materiales = '';

		foreach($arrMateriales as $indice => $valor){
			$id = str_replace(" ","",$indice);
			$materiales .= "				
					<div class='material'>		
						<input type='radio' class='input' name='material' id='$id' title='Material $indice' value='$indice'>													  																															
						<label for='$id'> ".ucfirst($indice)."</label>	
					</div>				
			";
		}

        return $materiales;
    }

    function obtenerColores() {
        global $db;

        $arrColores = [];

        $sql  = "SELECT color
				FROM `producto` as p
        ";

		$rs = $db->query($sql); 

		foreach ($rs as $row) {
			if(empty($arrColores[$row['color']])){
				$arrColores[$row['color']] = 0;						
			}													
		}

        ksort($arrColores);
		
		$colores = " 
            <fieldset class='colores contenedor'>
                <legend class='ltitulo' for='colores'><b>Colores</b></legend>
                <div id='colores' class='input'>
		";
		
		foreach($arrColores as $indice => $valor){
			$id = str_replace(" ","",$indice);
			$colores .=" 
				<div class='color'>	
					<input type='checkbox' class='input' name='color[]' id='$id' title='Color $indice' value='$indice'>													  																															
					<label for='$id' > ".ucfirst($indice)."</label>			
				</div>			
			";
		}
        $colores .= "</div> 
        </fieldset>";

        return $colores;
    }

    function obtenerCategorias(){
        global $db; 

        //trae los nombres de las categorias
        $sql = "SELECT nombre_categoria, id_categoria
                FROM `categoria` 
                WHERE activo = '1'
                GROUP BY nombre_categoria 
        "; 
    
        $rs = $db->query($sql); 
    
        //lista de categorias
        $listas = " 
                <select id='categoria' class='hover' name='categoria'> 
        ";
    
        $nomCat = "";
        
        foreach ($rs as $row) {
            $listas .= " <option value='{$row['id_categoria']}'> {$row['nombre_categoria']} </option> ";
            $nomCat .= $row['nombre_categoria'] . ",";	
        }
    
        $arrNomCat = explode(",",$nomCat); 
    
        $listas .= " </select> "; 

        return $listas;
    }

    function obtenerCategoriasInactivas(){
        global $db; 

        //trae los nombres de las categorias
        $sql = "SELECT nombre_categoria, id_categoria
                FROM `categoria` 
                WHERE activo = '0'
                GROUP BY nombre_categoria 
        "; 
    
        $rs = $db->query($sql); 
    
        //lista de categorias
        $listas = " 
                <select id='categoria' class='hover' name='catInactivas'> 
        ";
    
        $nomCat = "";
        
        foreach ($rs as $row) {
            $listas .= " <option value='{$row['id_categoria']}'> {$row['nombre_categoria']} </option> ";
            $nomCat .= $row['nombre_categoria'] . ",";	
        }
    
        $arrNomCat = explode(",",$nomCat); 
    
        $listas .= " </select> "; 

        return $listas;
    }

    function obtenerSubcategorias(){
        global $db; 

        //trae los nombres de las categorias
        $sql = "SELECT nombre_subcategoria, id_subcategoria
                FROM `subcategoria` 
                WHERE activo = '1'
                GROUP BY nombre_subcategoria 
        "; 
    
        $rs = $db->query($sql); 
    
        //lista de categorias
        $listas = " 
                <select id='subcategoria' class='hover' name='subcategoria'> 
        ";
    
        $nomCat = "";
        
        foreach ($rs as $row) {
            $listas .= " <option value='{$row['id_subcategoria']}'> {$row['nombre_subcategoria']} </option> ";
            $nomCat .= $row['nombre_subcategoria'] . ",";	
        }
    
        $arrNomCat = explode(",",$nomCat); 
    
        $listas .= " </select> "; 

        return $listas;
    }

    function obtenerSubcategoriasInactivas(){
        global $db; 

        //trae los nombres de las categorias
        $sql = "SELECT nombre_subcategoria, id_subcategoria
                FROM `subcategoria` 
                WHERE activo = '0'
                GROUP BY nombre_subcategoria 
        "; 
    
        $rs = $db->query($sql); 
    
        //lista de categorias
        $listas = " 
                <select id='subcategoria' class='hover' name='subInactivas'> 
        ";
    
        $nomCat = "";
        
        foreach ($rs as $row) {
            $listas .= " <option value='{$row['id_subcategoria']}'> {$row['nombre_subcategoria']} </option> ";
            $nomCat .= $row['nombre_subcategoria'] . ",";	
        }
    
        $arrNomCat = explode(",",$nomCat); 
    
        $listas .= " </select> "; 

        return $listas;
    }

    function obtenerImagenProducto($id){
        global $db;

        $sql = "SELECT * FROM imagen_productos 
                WHERE id_producto = $id AND portada=1
        ";

        $rs = $db->query($sql); 

        foreach ($rs as $r){
            $path = $r['destination'];
        }

        return $path;
    }

    function obtenerProducto($codigo){
        global $db;

        $sql = "SELECT *
			FROM `producto`
			WHERE codigo = '$codigo'
	    ";

        $rs = $db->query($sql);

        return $rs;
    }

    function obtenerConsultas($idUsuario){
        global $db;

        $sql= "SELECT c.texto, c.respondido
            FROM `consulta` as c INNER JOIN `usuario` as u ON (c.usuario_id = u.id)
            WHERE c.usuario_id='$idUsuario'
        "; 

        $rs = $db->query($sql);

        return $rs;
    }

    function obtenerCompras($idUsuario){
        global $db;

        $sql= "SELECT `descripcion`, `material`, `color`, `caracteristicas`, `marca` , p.`precio`,`codigo`,p.`id`
            FROM `compra` as c
            INNER JOIN `detalle_compra` as d on d.id_compra = c.id
            INNER JOIN `producto` as p on p.id = d.id_producto 
            INNER JOIN `usuario` as u on u.id = c.id_usuario
            WHERE c.id_usuario = '$idUsuario'
        "; 

        $rs = $db->query($sql);

        return $rs;
    }

    function obtenerImagenesSubcategorias($categoria){
        global $db;

        $sql = "SELECT destination, nombre_subcategoria 
                FROM imagen_subcategorias as s
                INNER JOIN subcategoria as sub ON s.id_subcategoria = sub.id_subcategoria
                INNER JOIN categoria as c ON sub.id_categoria = c.id_categoria
                WHERE c.nombre_categoria = '$categoria'
        ";

        $rs = $db->query($sql);

        return $rs;
    }

    function obtenerProductoConCantidad($id, $cantidad){
        global $db;

        $sql = $db->prepare(
            "SELECT id, precio, codigo, descripcion, material, color, marca, stock, descuento, $cantidad AS cantidad
            FROM producto
            WHERE id=?"
        );

        $sql -> execute ($id);

        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    function obtenerUsuario ($id){
        global $db;

        $sql= "SELECT nombreUsuario, perfil, nroDni, nombre, apellido, email, provincia, ciudad, direccion
            FROM `usuario`
            WHERE id='$id'
        "; 
 
        $rs = $db->query($sql);

        return $rs;
    }

    function obtenerUsuarioConRS ($id){
        global $db;

        $sql = "SELECT u.id
                FROM usuario as u
                INNER JOIN usuarios_rs as rs ON rs.id = u.id
                WHERE rs.id_social = $id
        ";

        $rs = $db->execute($sql);
        return $rs;

    }
    
    function insertarUsuario ($nombre, $apellido, $email, $perfil, $existe){
        global $db;

        //Si no existe una persona con ese nombre de usuario
        if (!$existe){
            $sql = "INSERT INTO usuario (nombreUsuario, nombre, apellido, email, perfil) VALUES
                    ('$nombre$apellido','$nombre', '$apellido', '$email', $perfil)
            ";
        } else {
            $sql = "INSERT INTO usuario (nombre, apellido, email, perfil) VALUES
                    ('$nombre', '$apellido', '$email', $perfil)
            ";
        }

        $db->query($sql);

        return $db->lastInsertId();
    }

    function insertarUsuarioRS ($idUsuario, $id){
        global $db;

        $sql = "INSERT INTO usuario_rs (id_usuario, id_social, servicio) VALUES
                ('$idUsuario', '$id', 'Google')
        ";

        $db->query($sql);
    }

    function insertarCompra($idUsuario,$monto,$paymentId,$fecha,$estado, $email){
        global $db;

        $sql = "INSERT INTO `compra`(`id_usuario`,`total`, `id_transaccion`, `fecha`, `estado`, `email`) 
                VALUES ('$idUsuario','$monto','$paymentId','$fecha','$estado', '$email')
        ";

        $rs = $db->query($sql);

        $idCompra = $db->lastInsertId();

        return $idCompra;
    }

    function insertarDetalleCompra($idCompra,$idProducto,$nombre,$precioUnitario,$cantidad){
        global $db;

        $sql = "INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad) VALUES
            ('$idCompra','$idProducto','$nombre','$precioUnitario','$cantidad')
        ";

        $rs = $db->query($sql);
    }

    function seleccionarUsuarioConEmail($email){
        global $db;

        $sql = "SELECT id_social, id_usuario
                FROM `usuario_rs` as rs
                INNER JOIN `usuario` as u ON rs.id_usuario = u.id  
                WHERE (u.email = '$email')
        ";

        $rs = $db->query($sql);
        return $rs;
    }

    function seleccionarUsuarioConId($id){
        global $db;

        $sql = "SELECT u.id
                FROM usuario as u 
                INNER JOIN usuario_rs as rs ON u.id = rs.id_usuario
                WHERE rs.id_social = '$id'
        ";

        $rs = $db->query($sql); 
        
        return $rs;
    }

    function seleccionarUsuarioConNombreUsuario($nombreUsuario){
        global $db;

        $sql = "SELECT nombreUsuario
                FROM usuario
                WHERE nombreUsuario = '$nombreUsuario'
        ";

        $rs = $db->query($sql);
        return $rs;
    }

    function obtenerFavoritos($idUsuario){
        global $db;

        $sql= "SELECT `descripcion`, `material`, `color`, `caracteristicas`, `marca` , `precio`,`codigo`,p.`id`
                FROM `producto` as p 
                INNER JOIN `favorito` as f on p.id = f.id_producto 
                WHERE f.id_usuario = '$idUsuario'
        "; 

        $rs = $db->query($sql);
        return $rs;
    }

    function deleteDir($dir) {
        if (!file_exists($dir)) {
            return false;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!deleteDir($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        
        return rmdir($dir);
    }

    function subirImagen($imagen, $url, $destination){
        $imagen_name = $imagen['name'];
        $imagen_tmp = $imagen["tmp_name"];
        $imagen_error = $imagen['error'];
        $imagen_ext = explode('.',$imagen_name);
        $imagen_ext = strtolower(end($imagen_ext));
        $allowed = array('jpg', 'jpeg', 'png');

        //Se podrian dividir los errores segun extensión o si falló el upload de la imagen
        if(in_array($imagen_ext, $allowed)){
            if($imagen_error === 0){
                
                if ($url === 'veCategoriaModif.php' || $url === 'veCategoriaAlta.php' || $url === 'veSubcategoriaAlta.php'){
                    $destination .= '.'.$imagen_ext;
                } else if ($url === 'veProductoAlta.php'){

                }

                if(move_uploaded_file($imagen_tmp, $destination)){
                    $destination = str_replace("../","",$destination);
                    return $destination;
                }else{
                    return false;
                }
            }   
        } else {
            return false;
        }
    }
?>