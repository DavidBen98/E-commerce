<?php
    require_once 'inc/conn.php';
    require_once 'config.php';

    define('PSW_SEMILLA','34a@$#aA9823$');

    define ('CONT_USUARIOS', "<div class='contenedor-btn'>        
                                <div id='btnInfoPersonal' style='border-top-left-radius:5px; border-top-right-radius:5px;'>Datos personales</div>     
                                <div id='btnCompraUsuario'>Mis pedidos</div>
                                <div id='btnFavoritos'>Favoritos</div>
                                <div id='btnConsultas'>Historial de consultas</div>
                                <div id='btnCerrarSesion' style='border-bottom: none; border-bottom-left-radius:5px; border-bottom-right-radius:5px;'>Cerrar sesión</div>
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
    
        $barra_sup ="<div id='mobile-perfilUsuario'>
                        $links
                    </div> ";
                    
        return  $barra_sup;
    }

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
    
        $barra_sup ="<div id='perfilUsuario'>
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
			    <h1 class='h1' style='display:none; width:100%; text-align:center; margin:0; padding-left: 100px;'> Muebles Giannis - Catálogo </h1>";
        
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
                                <div style='display:block; justify-content:center; align-items:center;'>";
                                    if ($row['descuento'] != 0){
                                        $precio_descuento = $row['precio'] - ($row['precio']*$row['descuento']/100);
                                        echo "<h3 class='precio'>
                                                 $". $precio_descuento ." 
                                              </h3>
                                              <h3 class='precio' style='font-size:0.8rem; text-decoration: line-through; margin:0;'>
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
                    <div style='display:flex; flex-wrap: wrap; justify-content: center; align-content:center; min-height: 250px'>
                        <p style='width: 100%; text-align:center; max-height: 40px'> No existe ningún resultado que coincida con la búsqueda ingresada </p>
                        <a href='index.php' style='text-decoration: underline;'>Regresar al inicio </a>
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
					ORDER  BY SUM(dc.`cantidad`) DESC;
            ";
		}
		else{
			$sql = "$select
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
            // echo " <div class='categoria'>
            //             <div class='cont-images'> 
            //                 <img src= 'images/categorias/$idCat.png' alt='$nomCat' class='img-cat'>
            //                 <div class='texto'>
            //                     <h2 class='img-titulo'>".strtoupper($nomCat) ."</h2>
            // ";

            $image_path = 'images/categorias/'.$idCat;
            $extensions = array('.jpg', '.jpeg', '.png');
            $src = '';
            foreach ($extensions as $ext) {
                if (file_exists($image_path . $ext)) {
                    $src = $image_path . $ext;
                    break;
                }
            }

            echo " <div class='cont-images'> 
                        <img src= '$src' alt='$nomCat' class='img-cat'>
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
            $subcatNombre = " ";
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
		
		//$where_sql = " WHERE codigo like '$variable%'";
        $innerJoin = " INNER JOIN subcategoria as s on p.id_subcategoria = s.id_subcategoria
					   INNER JOIN categoria as c on c.id_categoria = p.id_categoria 
        ";

		$where_sql = " WHERE s.nombre_subcategoria like '$subcategoria' AND c.nombre_categoria like '$categoria'";

		$sql  = "SELECT p.id_categoria, p.id_subcategoria,descripcion, material,color,caracteristicas,marca,stock, precio
				FROM `producto` as p
                $innerJoin
				$where_sql
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
                 $where_sql
		";

		$rs1 = $db->query($sql1);
		
		foreach ($rs1 as $row) {
			$valorMin = implode($row);
		}

		$sql2 = "SELECT max(precio) 
                FROM `producto` as p
                $innerJoin
                $where_sql
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

    function obtenerSubcategorias(){
        global $db; 

        //trae los nombres de las categorias
        $sql = "SELECT nombre_subcategoria, id_subcategoria
                FROM `subcategoria` 
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

    function obtenerImagenes($tabla){

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

    function uploadImage($imagen, $url, $destination){
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