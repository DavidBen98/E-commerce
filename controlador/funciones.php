<?php
    require_once "../inc/conn.php";
    require_once "config.php";

    define("PSW_SEMILLA","34a@$#aA9823$");

    define ("CONT_USUARIOS", "<div class='contenedor-btn'>        
                                <div id='btn-info-personal'>Datos personales</div>     
                                <div id='btn-compra-usuario'>Mis pedidos</div>
                                <div id='btn-favoritos'>Favoritos</div>
                                <div id='btn-consultas'>Historial de consultas</div>
                                <div id='btn-cerrar-sesion'>Cerrar sesión</div>
                            </div> "
    );

    function crear_barra_mobile() {
        global $user;
        global $perfil;
        $links=""; 

        if (isset($_GET["code"]) || isset($_SESSION["user_first_name"])){
            $links = " 
                <a href='informacionPersonal.php' title='Perfil'> <span>" 
                    . $_SESSION["user_first_name"] . $_SESSION["user_last_name"] .
                " </span> &nbsp;</a>
                <a href='../controlador/logout.php' id='cerrar' title='Cerrar sesión de usuario'> X </a>
            ";
        }
        else if (isset($_SESSION["nombre_tw"])){
            $links = "
                <a href='informacionPersonal.php' title='Perfil'> 
                    <span>" . preg_replace("([^A-Za-z0-9])", "", $_SESSION["nombre_tw"]) . " </span> &nbsp;
                </a>
                <a href='../controlador/logout.php' id='cerrar' title='Cerrar sesión de usuario'> X </a>
            ";
        }
        else if ($user=="") {
            $links = "
                <a href='login.php?reg=true' title='Crear una cuenta de usuario' id='btn-registrar'> Registrarse</a>
                <a href='login.php' title='Iniciar sesión' id='iniciarSesion'> Iniciar sesión</a>
            ";
        } else if($perfil=="E"){
            $links = "  
                <span title='Nombre de usuario' id='span'> {$_SESSION["nombre"]} </span>
                <a href='../controlador/cerrarSesion.php'  id='cerrar' title='Cerrar sesión de usuario'> X </a>
            ";
        } else if($perfil=="U"){
            $links = "
                <a href='informacionPersonal.php' title='Perfil'> <span> {$_SESSION["user"]} </span> &nbsp;</a>
                <a href='../controlador/cerrarSesion.php' id='cerrar' title='Cerrar sesión de usuario'> X </a>
            ";
        }
    
        $barra_superior ="
            <div id='mobile-perfil-usuario'>
                $links
            </div> 
        ";
                    
        return $barra_superior;
    }

    function crear_barra() {
        global $user;
        global $perfil;
        $links=""; 

        if (isset($_GET["code"]) || isset($_SESSION["user_first_name"])){
            $links = "  
                <a href='informacionPersonal.php' title='Perfil'> <span>" 
                    . $_SESSION["user_first_name"] . $_SESSION["user_last_name"] .
                " </span> &nbsp;</a>
                <a href='../controlador/logout.php' id='cerrar' title='Cerrar sesión de usuario'> X </a>
            ";
        }
        else if (isset($_SESSION["nombre_tw"])){
            $links = "
                <a href='informacionPersonal.php' title='Perfil'> 
                    <span>" . preg_replace("([^A-Za-z0-9])", "", $_SESSION["nombre_tw"]) . " </span> &nbsp;
                </a>
                <a href='../controlador/logout.php' id='cerrar' title='Cerrar sesión de usuario'> X </a>
            ";
        }
        else if ($user=="") {
            $links = "
                <a href='login.php?reg=true' title='Crear una cuenta de usuario' id='btn-registrar'> Registrarse</a>
                <a href='login.php' title='Iniciar sesión' id='iniciarSesion'> Iniciar sesión</a>
            ";
        } else if($perfil=="E"){
            $links = "
                <span title='Nombre de usuario' id='span'> {$_SESSION['nombre']}  </span>
                <a href='../controlador/cerrarSesion.php'  id='cerrar' title='Cerrar sesión de usuario'> X </a>
            ";
        } else if($perfil=="U"){
            $links = "
                <a href='informacionPersonal.php' title='Perfil'> <span> {$_SESSION['user']} </span> &nbsp;</a>
                <a href='../controlador/cerrarSesion.php' id='cerrar' title='Cerrar sesión de usuario'> X </a>
            ";
        }
    
        $barra_superior ="
            <div id='perfilUsuario'>
                $links
            </div> 
        ";
                    
        return $barra_superior;
    }

    function perfil_valido($opcion) {
        global $perfil; 

        switch($opcion){
            case 1: 
                $valido=($perfil=="E")? true:false; 
                break;
            case 2: 
                $valido=($perfil=="U")? true:false;
                break;	
            case 3: 
                $valido=($perfil=="")? true:false; 
                break;
            default:
                $valido=false;
        }           
        
        return $valido;  
    }
	
	function generar_clave_encriptada($password) {			
		$salt = PSW_SEMILLA;		 
		$psw_encript = hash("sha512", $salt.$password);				
		return $psw_encript; 
	}
    
    function obtener_ruta_portada($id){
        global $db;

        $stmt = $db->prepare("SELECT destination FROM imagen_productos WHERE id_producto = ? AND portada = 1");
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();

        $path = "";

        if (count($result) > 0) {
            $path = $result[0]["destination"];
        }

        return $path;
    }

    function crear_imagenes ($consulta){
		$i=0;	

		echo "
            <form action='listadoXLS.php' method='post' id='form-filtrado' class='form-prod' name='form-filtrado'>
			    <h1 class='h1'> Muebles Giannis - Catálogo </h1>";
        
            if (!$consulta){
                $i++;
                echo "<p>Lo sentimos, ha ocurrido un error inesperado </p>";
            }
            else if (isset($_GET["categoria"])){
                //subcategoria.php
                foreach ($consulta as $row) {
                    $path = $row["destination"];

                    $i++; 
                    echo "<div class='producto'>
                            <img src='../$path' class='img-cat' id='$i' alt='".ucfirst($row["nombre_subcategoria"])."' title='".ucfirst($row['nombre_subcategoria'])."'> 
                            <h2 class='tituloSubcat'>". ucfirst($row["nombre_subcategoria"])." </h2>
                        </div>
                    ";           
                };		
            }
            else{
                //productos.php
                foreach ($consulta as $row) {
                    $id = $row["id"];
                    $path = obtener_ruta_portada($id);

                    $i++; 
                    echo "
                        <div class='producto'>
                            <img src='../$path' class='img-cat' id='$i' alt='{$row["codigo"]}' title='". ucfirst($row["descripcion"])."'> 
                            <div class='caracteristicas'>
                                <h2 class='descripcion'>". ucfirst($row["descripcion"])." </h2>
                                <div class='descripcion-precio'>
                    ";

                    if ($row["descuento"] != 0){
                        $precio_descuento = $row["precio"] - ($row["precio"]*$row["descuento"]/100);
                        echo "<h3 class='precio'>
                                    $". $precio_descuento ." 
                                </h3>
                                <h3 class='precio' id='h3-precio'>
                                    $". ucfirst($row["precio"]).
                            " </h3>
                        ";
                    }
                    else{
                        echo "<h3 class='precio'> $". ucfirst($row["precio"])." </h3>";
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
                    
        echo "	
                </div>
            </form>
        ";	
	} 

    function generar_consulta($url, $busqueda = "", $orden = ""){
        if ($url === "productos"){
            //orden
            if ($orden == 2){
                $select = "SELECT c.nombre_categoria,descripcion, s.nombre_subcategoria, codigo, p.precio, p.id,p.descuento, SUM(dc.cantidad) as total_vendido";
                $inner_join = "
                    INNER JOIN categoria as c ON p.id_categoria = c.id_categoria
                    INNER JOIN subcategoria as s ON p.id_subcategoria = s.id_subcategoria
                    LEFT JOIN detalle_compra as dc ON p.id = dc.id_producto
                ";
            } else {
                $select = "SELECT c.nombre_categoria,descripcion, s.nombre_subcategoria, codigo, p.precio, p.id,p.descuento";
                $inner_join = "
                    INNER JOIN categoria as c ON p.id_categoria = c.id_categoria
                    INNER JOIN subcategoria as s ON p.id_subcategoria = s.id_subcategoria
                ";
            }

            $from = "FROM `producto` as p";

            $sql = $select. " ". $from . " " . $inner_join . " ";

            return $sql;

        } else if ($url === "buscador") {
            global $db;

            if (trim($busqueda) != ""){
                $busqueda = str_replace("%20", " ", $busqueda);
                $busqueda = ucfirst($busqueda);
                $palabras = explode (" ",$busqueda);			
    
                $sql = "SELECT c.nombre_categoria,descripcion, s.nombre_subcategoria, codigo, precio, p.id, p.descuento
                        FROM `producto` as p
                        INNER JOIN categoria as c ON p.id_categoria = c.id_categoria
                        INNER JOIN subcategoria as s ON p.id_subcategoria = s.id_subcategoria
                        WHERE nombre_categoria LIKE '%".$busqueda."%' 
                        OR nombre_subcategoria LIKE '%".$busqueda."%'
                        OR descripcion LIKE '%".$busqueda."%'
                ";
    
                foreach ($palabras as $palabra){
                    if (strlen($palabra) > 3){ //Si es una palabra mayor a 3 letras
                        $sql .= " OR nombre_categoria LIKE '%".$palabra."%'
                                  OR nombre_subcategoria LIKE '%".$palabra."%'
                                  OR descripcion LIKE '%".$palabra."%'
                        ";
                    }
                }
                
                $rs = $db->query($sql);

                return $rs;
            }
        } else if ($url === "subcategoria"){
            //ordeen
            if ($orden == 2){
                $select = "SELECT SUM(dc.cantidad) as total_vendido, p.`id`,p.`codigo`, p.`descripcion`, p.`descuento`, p.`precio`,p.`id_categoria`, p.`id_subcategoria`";
                $inner_join = "
                    INNER JOIN categoria as c ON p.id_categoria = c.id_categoria
                    INNER JOIN subcategoria as s ON p.id_subcategoria = s.id_subcategoria
                    LEFT JOIN detalle_compra as dc ON p.id = dc.id_producto
                ";
            } else {
                $select = "SELECT p.`id`,p.`codigo`, p.`descripcion`, p.`descuento`, p.`precio`,p.`id_categoria`, p.`id_subcategoria`";
                $inner_join = "
                    INNER JOIN subcategoria as s on p.id_subcategoria = s.id_subcategoria
                    INNER JOIN categoria as c on c.id_categoria = p.id_categoria
                ";
            }

            $from = "FROM producto as p";
            $sql = $select . " " . $from . " " . $inner_join . " ";

            return $sql;
        } else {
            $sql = "SELECT * FROM producto as p";

            return $sql;
        }

        return "";
    }

    function filtrar_productos ($sql,$where,$filtros){
        global $db;

        $rs = "";	
        $where_color = "";
        $where_marca = "";
        $where_sql = "";
        $order_by = "";
		$orden_mas_vendido = 0;

        //Color
        if (isset($filtros[0])){
            if (count($filtros[0]) == 1){
                $where_color .= " AND color = '" . $filtros[0][0]. "' ";
            }
            else{
				$where_color .= " AND ( ";
                for ($i=0; $i<count($filtros[0])-1; $i++){ 
                    $where_color .= " color = '". $filtros[0][$i] . "' OR " ;
                }
                $i = count($filtros[0])-1;
                $where_color .= " color = '". $filtros[0][$i] . "') ";
            }
        }

        //Marca
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

        //Precio
		if ($filtros[2] != null){
			$where_sql .= "AND precio >=". $filtros[2];
		}

        if ($filtros[3] != null){
            $where_sql .= " AND precio <= ". $filtros[3];
        }

        //Order by
        if(isset($filtros[4])){
            if ($filtros[4] == 0){
                $order_by = " ORDER BY precio asc ";
            }
            else if ($filtros[4] == 1) {
                $order_by = " ORDER BY precio desc ";
            }
            else {              
				$order_by = "GROUP BY p.id ORDER BY total_vendido DESC";
            }
        }
		
        //Se ordena el where
        if($where_color != "" && $where_marca != ""){
            $where_sql .=  $where_color . $where_marca;
        }
        else if ($where_color != ""){
            $where_sql .=  $where_color;
        }
        else{
            $where_sql .=  $where_marca;
        } 

        //Si se elige el orden mas vendido
        $sql = "$sql
                $where
                $where_sql
                $order_by
        ";  

        $rs = $db->query($sql);

        return $rs;
    }

    function mostrar_filtros ($filtros,$categoria,$subcategoria){
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
            $sql = "SELECT c.nombre_categoria
                    FROM `categoria` as c
                    WHERE c.id_categoria = :categoria
            ";

            $stmt = $db->prepare($sql);
            $stmt->bindValue(":categoria", $categoria, PDO::PARAM_INT);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                $cat = $resultado["nombre_categoria"];
            } else {
                $cat = "";
            }

            $filtro .= "<b>Categoría:</b> ". $cat . "<br>"; //Luego modificar
        }
        else if ($categoria != ""){
            $filtro .= "<b>Categoría:</b> ". $categoria . "<br>";
        }

        if (is_int($subcategoria)){
            $sql  = "SELECT s.nombre_subcategoria
                    FROM `subcategoria` as s
                    WHERE s.id_subcategoria = :subcategoria
            ";

            $stmt = $db->prepare($sql); // Preparar la consulta
            $stmt->bindValue(':subcategoria', $subcategoria, PDO::PARAM_INT); // Vincular el valor con un place holder
            $stmt->execute(); // Ejecutar la consulta

            $row = $stmt->fetch();
            $subcat = $row["nombre_subcategoria"];

            $filtro .= "<b>Subcategoría:</b> ". $subcat . "<br>"; //Luego modificar
        }
        else if ($subcategoria != ""){
            $filtro .= "<b>Subcategoría:</b> ". $subcategoria . "<br>"; //Luego modificar
        }

        if (isset($filtros[0])){
            if (count($filtros[0]) == 1){
                $filtro .= "<b>Color: </b>";
            }
            else{
                $filtro .= "<b>Colores: </b>";
            }
            for ($i=0; $i<count($filtros[0]); $i++){ 
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
            for ($i=0; $i<count($filtros[1]); $i++){ 
                if ($i == count($filtros[1])-1){
                    $filtro .= $filtros[1][$i] . "<br>"; 
                }
                else{
                    $filtro .= $filtros[1][$i] . " - "; 
                }
            }
        }

        if ($filtros[2]!= null){
            $filtro .= "<b>Mínimo:</b> $" . $filtros[2] . "<br> ";
        }

        if ($filtros[3]!= null){
            $filtro .= " <b>Máximo:</b> $" . $filtros[3];
        }

        return $filtro;
    }

    function cantidad_carrito(){ 
        if (isset($_SESSION["carrito"]) && isset($_SESSION["carrito"]["productos"])){
            return count($_SESSION["carrito"]["productos"]);
        }
        return 0;
    }

    function agregar_imagen_categorias (){
        global $db;

        $sql = "SELECT nombre_categoria, id_categoria
                FROM `categoria`
                WHERE activo = '1'
        "; 
        
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
      
        foreach ($result as $row){
            $id_categoria =  $row["id_categoria"];
            $nombre_categoria = $row["nombre_categoria"];

            $sql = "SELECT destination 
                    FROM imagen_categorias
                    WHERE id_categoria = :id_categoria
            ";

            $stmt_img = $db->prepare($sql);
            $stmt_img->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
            $stmt_img->execute();
            $result_img = $stmt_img->fetch(PDO::FETCH_ASSOC);
            $imagen_categoria = $result_img['destination'];

            echo " <div class='cards'> 
                        <div
                            class='card'
                            id='$id_categoria'
                            style='
                                background-image: url(../$imagen_categoria);
                            '
                        >
                            <div class='info_container'>
                                <div class='icon_container'>
                                    <svg
                                        xmlns='http://www.w3.org/2000/svg'
                                        viewBox='0 0 24 24'
                                        width='100%'
                                        height='100%'
                                        class='icon'
                                        stroke='currentColor'
                                        stroke-width='2'
                                    >
                                        <path
                                            stroke-linecap='round'
                                            stroke-linejoin='round'
                                            class='icon'
                                            d='M12 4v16m8-8H4'
                                        />
                                    </svg>
                                </div>

                                <div class='info'>
                                    <h2 class='img-titulo main'>".strtoupper($nombre_categoria) ."</h2>
            ";

            $sql1 = "SELECT nombre_subcategoria
                    FROM subcategoria
                    INNER JOIN categoria ON categoria.id_categoria = subcategoria.id_categoria
                    WHERE subcategoria.id_categoria = ? AND subcategoria.activo = ?
            ";

            $stmt_subcategoria = $db->prepare($sql1);
            $stmt_subcategoria->bindValue(1, $id_categoria, PDO::PARAM_INT);
            $stmt_subcategoria->bindValue(2, 1, PDO::PARAM_INT);
            $stmt_subcategoria->execute();
            $result_subcategoria = $stmt_subcategoria->fetchAll();

            echo "<p class='img-texto'>";
            $nombre_subcategoria = "";

            foreach ($result_subcategoria as $rowSub){
                $nombre_subcategoria .= $rowSub["nombre_subcategoria"] . " <br/> ";
            }

            echo "" .  ucwords($nombre_subcategoria) . "          
                            </p>     
                        </div>
                    </div>
                    </div>
                </div>
            ";
        }
    }  

    function crear_barra_lateral(){
        global $db;
    
        $arreglo_categorias = [];
        $arreglo_subcategorias = [];
        $formulario = "";
    
        if (isset($_GET["cate"]) && isset($_GET["sub"])){
            $categoria = $_GET["cate"];
            $subcategoria = $_GET["sub"];
            
            $formulario = "
                <form action='productos.php?cate=".$categoria."&sub=".$subcategoria."' method='post' id='datos'> 
                    <div class='btn-select'>
                        <label for='orden' class='label'> Ordenar por </label>
                        <select class='form-select' id='orden' name='orden' title='Ordenar elementos'> 
                            <option value='0'> Menor precio </option>
                            <option value='1'> Mayor precio </option>	
                            <option value='2'> Mas vendidos </option>
                        </select>
                    </div>
            ";
        } else {
            $categoria = "%";
            $subcategoria = "%";
        
            $sql  = "SELECT c.id_categoria, c.nombre_categoria, s.id_subcategoria, s.nombre_subcategoria
                    FROM categoria c
                    LEFT JOIN subcategoria s ON c.id_categoria = s.id_categoria
            ";
        
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $rs = $stmt->fetchAll();
        
            foreach ($rs as $row) {
                $arreglo_categorias[$row["nombre_categoria"]] = $row["id_categoria"];
                $arreglo_subcategorias[$row["nombre_categoria"]][$row["nombre_subcategoria"]] = $row["id_subcategoria"];
            }
        
            ksort($arreglo_categorias);
            
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
        
            foreach($arreglo_categorias as $indice => $valor){
                $formulario .=" <option value='$valor'> $indice </option>";
            }
        
            $formulario .= "</select>
                    </div>
                    <div id='subc' class='btn-select'>
                </div>
            ";
        }

        if ((isset($_GET["cate"]) && isset($_GET["sub"])) || isset($_GET["productos"]) || isset($_GET["buscador"])){         
            echo $formulario;
    
            $arreglo_colores = $arreglo_marcas = [];
    
            $inner_join = "INNER JOIN subcategoria as s on p.id_subcategoria = s.id_subcategoria
                           INNER JOIN categoria as c on c.id_categoria = p.id_categoria 
            ";
    
            $where_sql = "WHERE s.nombre_subcategoria like '$subcategoria' 
                        AND " . (isset($_GET["productos"]) || isset($_GET["buscador"]) ? "c.nombre_categoria like '$categoria'" : "c.id_categoria = '$categoria'
            ");
    
            $sql  = "SELECT p.color, p.marca, MIN(p.precio) as min_precio, MAX(p.precio) as max_precio
                    FROM `producto` as p
                    $inner_join
                    $where_sql
                    GROUP BY p.color, p.marca
            ";
    
            $rs = $db->query($sql); 

            $valor_minimo = $valor_maximo = "";
    
            foreach ($rs as $row) {
                $arreglo_colores[$row["color"]] = 0;
                $arreglo_marcas[$row["marca"]] = 0;
                $valor_minimo = $row["min_precio"];
                $valor_maximo = $row["max_precio"];
            }
    
            ksort($arreglo_colores);
            
            $html = "";
            $fieldset_class = "colores";
            $legend_title = "Colores";
            $input_name = "color";
    
            foreach($arreglo_colores as $indice => $valor){
                $id = str_replace(" ","",$indice);
                $html .= "<div class='$fieldset_class'>
                            <input type='checkbox' class='input' name='${input_name}[]' id='$id' title='$legend_title $indice' value='$indice'>
                            <label for='$id'> ".ucfirst($indice)."</label>
                        </div>
                ";
            }
    
            echo "<fieldset class='$fieldset_class contenedor'>
                    <legend class='ltitulo'><b>$legend_title</b></legend>
                    <div id='$fieldset_class' class='input'>
                        $html
                    </div>
                </fieldset>
            ";
    
            $html = "";
            $fieldset_class = "marcas";
            $legend_title = "Marcas";
            $input_name = "marca";
    
            foreach($arreglo_marcas as $indice => $valor){
                $id = str_replace(" ","",$indice);
                $html .= "<div class='$fieldset_class'>
                            <input type='checkbox' class='input' name='${input_name}[]' id='$id' title='$legend_title $indice' value='$indice'>
                            <label for='$id'> ".ucfirst($indice)."</label>
                        </div>
                ";
            }
    
            echo "<fieldset class='$fieldset_class contenedor'>
                    <legend class='ltitulo'><b>$legend_title</b></legend>
                    <div id='$fieldset_class' class='input'>
                        $html
                    </div>
                </fieldset>
            ";
    
            echo "
                    </div>	
                    </fieldset>
                    <fieldset id='min-max'>
                        <legend class='ltitulo'><b>Precios</b></legend> 
                        <div class='input-minmax'> 
                            <label for='valorMin' class='lmaxmin'>Mínimo -</label> 
                            <label for='valorMax' class='lmaxmin'>Máximo</label>			
                        </div>
                        <div class='input-minmax'>
                            <input type='number' name='valorMin' id='valorMin' title='Mínimo'  class='min-max' placeholder='$valor_minimo' min='$valor_minimo' max='$valor_maximo' value='' >
                            - 
                            <input type='number' name='valorMax' id='valorMax' title='Máximo' class='min-max' placeholder='$valor_maximo' min='$valor_minimo' max='$valor_maximo' value='' > 							
                        </div>
                    </fieldset>	
                    <p class='mensaje' id='mensaje'>
    
                    </p> 
                    <div id='botones' class='botones'>
                        <input type='submit'  id='filtros' class='btn' name='Aplicar filtros' title='Aplicar filtros' value='Aplicar filtros'>						
                    </div>
                </form>
            ";
        } else{
            echo $formulario;
           
            $arreglo_colores = $arreglo_marcas = [];
    
            $inner_join = "INNER JOIN subcategoria as s on p.id_subcategoria = s.id_subcategoria
                           INNER JOIN categoria as c on c.id_categoria = p.id_categoria 
            ";
    
            $where_sql = "WHERE s.nombre_subcategoria like '%' 
                        AND c.nombre_categoria like '%'
            ";
    
            $sql  = "SELECT p.color, p.marca, MIN(p.precio) as min_precio, MAX(p.precio) as max_precio
                    FROM `producto` as p
                    $inner_join
                    $where_sql
                    GROUP BY p.color, p.marca
            ";
    
            $rs = $db->query($sql); 

            $valor_minimo = $valor_maximo = "";
    
            foreach ($rs as $row) {
                $arreglo_colores[$row["color"]] = 0;
                $arreglo_marcas[$row["marca"]] = 0;
                $valor_minimo = $row["min_precio"];
                $valor_maximo = $row["max_precio"];
            }
    
            ksort($arreglo_colores);
            
            $html = "";
            $fieldset_class = "colores";
            $legend_title = "Colores";
            $input_name = "color";
    
            foreach($arreglo_colores as $indice => $valor){
                $id = str_replace(" ","",$indice);
                $html .= "<div class='$fieldset_class'>
                            <input type='checkbox' class='input' name='${input_name}[]' id='$id' title='$legend_title $indice' value='$indice'>
                            <label for='$id'> ".ucfirst($indice)."</label>
                        </div>
                ";
            }
    
            echo "<fieldset class='$fieldset_class contenedor'>
                    <legend class='ltitulo'><b>$legend_title</b></legend>
                    <div id='$fieldset_class' class='input'>
                        $html
                    </div>
                </fieldset>
            ";
    
            $html = "";
            $fieldset_class = "marcas";
            $legend_title = "Marcas";
            $input_name = "marca";
    
            foreach($arreglo_marcas as $indice => $valor){
                $id = str_replace(" ","",$indice);
                $html .= "<div class='$fieldset_class'>
                            <input type='checkbox' class='input' name='${input_name}[]' id='$id' title='$legend_title $indice' value='$indice'>
                            <label for='$id'> ".ucfirst($indice)."</label>
                        </div>
                ";
            }
    
            echo "<fieldset class='$fieldset_class contenedor'>
                    <legend class='ltitulo'><b>$legend_title</b></legend>
                    <div id='$fieldset_class' class='input'>
                        $html
                    </div>
                </fieldset>
            ";
    
            echo "
                    </div>	
                    </fieldset>
                    <fieldset id='min-max'>
                        <legend class='ltitulo'><b>Precios</b></legend> 
                        <div class='input-minmax'> 
                            <label for='valorMin' class='lmaxmin'>Mínimo -</label> 
                            <label for='valorMax' class='lmaxmin'>Máximo</label>			
                        </div>
                        <div class='input-minmax'>
                            <input type='number' name='valorMin' id='valorMin' title='Mínimo'  class='min-max' placeholder='$valor_minimo' min='$valor_minimo' max='$valor_maximo' value='' >
                            - 
                            <input type='number' name='valorMax' id='valorMax' title='Máximo' class='min-max' placeholder='$valor_maximo' min='$valor_minimo' max='$valor_maximo' value='' > 							
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
	}	

    function existe_email(){
        global $db;

        $red_social = $_SESSION["servicio"];

        if ($red_social == "Google"){
            $email = $_SESSION["user_email_address"];
            $where = "WHERE (u.email = :email)";
        }
        else{
            $where = "WHERE (u.email LIKE '%')";
        }

        $sql = "SELECT id_social, id_usuario
                FROM `usuario_rs` as rs
                INNER JOIN `usuario` as u ON rs.id_usuario = u.id  
                $where
        ";

        $stmt = $db->prepare($sql);

        if ($red_social == "Google"){
            $stmt->bindValue(':email', $email);
        }

        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();

        return $result ? true : false;
    }

    function existe_id_usuario(){    
        global $db;

        $red_social = $_SESSION["servicio"];

        if ($red_social == "Google"){
            $id = $_SESSION["id"]; 
        }
        else if ($red_social == "Twitter"){
            $id = $_SESSION["user_id"];
        }

        $sql = "SELECT COUNT(id_usuario)
                FROM `usuario_rs`
                WHERE id_social = :id_social AND servicio = :servicio
        ";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_social", $id, PDO::PARAM_INT);
        $stmt->bindParam(":servicio", $red_social, PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->fetchColumn();
        return ($count > 0);
    }

    function existe_nombre_usuario(){
        global $db;
    
        $red_social = $_SESSION["servicio"];
        $nombre_usuario = "";
    
        if ($red_social == "Google"){
            $nombre_usuario = $_SESSION["user_first_name"] . $_SESSION["user_last_name"];
        }
        else if ($red_social == "Twitter"){
            $nombre_usuario = $_SESSION["nombre_tw"];
            $nombre_usuario = preg_replace("([^A-Za-z0-9])", "", $nombre_usuario);
        }
    
        $sql = "SELECT id_social, id_usuario
                FROM `usuario_rs` as rs
                INNER JOIN `usuario` as u ON rs.id_usuario = u.id  
                WHERE nombre_usuario = :nombre_usuario AND servicio = :servicio
        ";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":nombre_usuario", $nombre_usuario, PDO::PARAM_STR);
        $stmt->bindParam(":servicio", $red_social, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return (count($result) > 0);
    }

    function obtener_marcas() {
        global $db;

        $sql = "SELECT DISTINCT marca FROM `producto` ORDER BY marca ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $marcas = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = str_replace(" ", "", $row["marca"]);
            $marcas[] = "
                <div class='marca'>
                    <input type='radio' class='input' name='marca' id='$id' title='Marca {$row["marca"]}' value='{$row["marca"]}'>
                    <label for='$id'>".ucfirst($row["marca"])."</label>
                </div>
            ";
        }

        return implode("", $marcas);
    }

    function obtener_materiales() {
        global $db;

        $sql = "SELECT DISTINCT material FROM `producto` ORDER BY material ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $materiales = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = str_replace(" ", "", $row["material"]);
            $materiales[] = "
                <div class='material'>
                    <input type='radio' class='input' name='material' id='$id' title='material {$row["material"]}' value='{$row["material"]}'>
                    <label for='$id'>".ucfirst($row["material"])."</label>
                </div>
            ";
        }

        return implode("", $materiales);
    }

    function obtener_colores() {
        global $db;
        $arreglo_colores = [];
    
        $stmt = $db->prepare("SELECT color FROM producto");
        $stmt->execute();
        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($rs as $row) {
            if (!in_array($row["color"], $arreglo_colores)) {
                $arreglo_colores[] = $row["color"];
            }
        }
    
        sort($arreglo_colores);
        $colores = "";
        foreach ($arreglo_colores as $indice) {
            $id = str_replace(" ", "", $indice);
            $colores .= "
                <div class='color'>
                    <input type='radio' class='input' name='color' id='$id' title='Color $indice' value='$indice'>
                    <label for='$id'>".ucfirst($indice)."</label>
                </div>
            ";
        }

        return $colores;
    }

    function obtener_categorias() {
        global $db; 
    
        // Prepara la consulta para traer los nombres y los IDs de las categorías activas
        $stmt = $db->prepare("SELECT nombre_categoria, id_categoria
            FROM categoria 
            WHERE activo = ?
            GROUP BY nombre_categoria"
        );
    
        // Ejecuta la consulta con un valor vinculado para evitar inyecciones SQL
        $stmt->execute([1]);
        $rs = $stmt->fetchAll();
    
        // Construye la lista de categorías
        $categorias = "<select id='categoria' class='hover' name='categoria'>";

        foreach ($rs as $row) {
            $categorias .= "<option value='{$row['id_categoria']}'>{$row['nombre_categoria']}</option>";
        }
        $categorias .= "</select>"; 
    
        return $categorias;
    }

    function obtener_categorias_inactivas(){
        global $db; 

        $categorias = "<select id='categoria' class='hover' name='catInactivas'>";
        $stmt = $db->prepare("SELECT nombre_categoria, id_categoria FROM categoria WHERE activo = 0 GROUP BY nombre_categoria");
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categorias .= "<option value='{$row["id_categoria"]}'>{$row["nombre_categoria"]}</option>";
        }

        $categorias .= "</select>";

        return $categorias;
    }

    function obtener_subcategorias(){
        global $db; 
    
        $sql = "SELECT nombre_subcategoria, id_subcategoria
                FROM `subcategoria` 
                WHERE activo = :activo
                GROUP BY nombre_subcategoria"; 
       
        $stmt = $db->prepare($sql); 
        $stmt->bindValue(':activo', 1, PDO::PARAM_INT); 
        $stmt->execute(); 
        
        //lista de subcategorias
        $subcategorias = "<select id='subcategoria' class='hover' name='subcategoria'>";
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $subcategorias .= "<option value='{$row['id_subcategoria']}'>{$row['nombre_subcategoria']}</option>";
        }
       
        $subcategorias .= "</select>"; 
    
        return $subcategorias;
    }

    function obtener_subcategorias_inactivas() {
        global $db; 
    
        $stmt = $db->prepare("SELECT nombre_subcategoria, id_subcategoria
                              FROM `subcategoria` 
                              WHERE activo = '0'
                              GROUP BY nombre_subcategoria
        ");

        $stmt->execute(); 
        $rs = $stmt->fetchAll();
        
        $subcategorias = " 
                <select id='subcategoria' class='hover' name='subInactivas'> 
        ";
        
        foreach ($rs as $row) {
            $subcategorias .= " <option value='{$row["id_subcategoria"]}'> {$row["nombre_subcategoria"]} </option> ";
        }
        
        $subcategorias .= " </select> "; 
    
        return $subcategorias;
    }

    function obtener_imagen_producto($id){
        global $db;

        $sql = "SELECT destination FROM imagen_productos 
                WHERE id_producto = :id AND portada = 1
                LIMIT 1
        ";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $path = $stmt->fetchColumn();

        return $path;
    }

    function obtener_producto($codigo){
        global $db;
    
        $sql = "SELECT *
            FROM `producto`
            WHERE codigo = :codigo
        ";
    
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
        $stmt->execute();
    
        return $stmt;
    }

    function obtener_consultas($id_usuario){
        global $db;
    
        $stmt = $db->prepare("SELECT c.texto, c.respondido
                FROM `consulta` as c INNER JOIN `usuario` as u ON (c.usuario_id = u.id)
                WHERE c.usuario_id= :idUsuario"
        );
    
        $stmt->bindParam(':idUsuario', $id_usuario, PDO::PARAM_INT);
    
        $stmt->execute();
    
        return $stmt;
    }

    function obtener_compras($id_usuario){
        global $db;
    
        $sql= "SELECT `descripcion`, `material`, `color`, `caracteristicas`, `marca` , p.`precio`,`codigo`,p.`id`
            FROM `compra` as c
            INNER JOIN `detalle_compra` as d on d.id_compra = c.id
            INNER JOIN `producto` as p on p.id = d.id_producto 
            INNER JOIN `usuario` as u on u.id = c.id_usuario
            WHERE c.id_usuario = :id_usuario
        "; 
    
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $rs;
    }

    function obtener_imagenes_subcategorias($categoria){
        global $db;

        if ($categoria !== ""){
            $sql = "SELECT destination, nombre_subcategoria 
                    FROM imagen_subcategorias as s
                    INNER JOIN subcategoria as sub ON s.id_subcategoria = sub.id_subcategoria
                    INNER JOIN categoria as c ON sub.id_categoria = c.id_categoria
                    WHERE c.id_categoria = :categoria AND sub.activo = 1
            ";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
            $stmt->execute();
            $rs = $stmt->fetchAll();

            return $rs;
        }

        return false;
    }

    function obtener_lista_carrito($productos) {
        global $db;

        $lista_carrito = array();
        foreach ($productos as $key => $cantidad) {
            $sql = $db->prepare("SELECT id, precio, codigo, descripcion, material, color, marca, stock, descuento, $cantidad AS cantidad
                                 FROM producto
                                 WHERE id=?
            ");
    
            $sql -> execute ([$key]);
            $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
        }
        
        return $lista_carrito;
    }

    function obtener_usuario($id){
        global $db;

        $sql = $db->prepare("SELECT nombre_usuario, perfil, nro_dni, nombre, apellido, email, provincia, ciudad, direccion, suscripcion
                            FROM `usuario`
                            WHERE id = :id
        ");

        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();
    
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function obtener_usuario_con_rs($id){
        global $db;

        $sql = "SELECT u.id
                FROM usuario as u
                INNER JOIN usuario_rs as rs ON rs.id = u.id
                WHERE rs.id_social = :id
        ";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function obtener_nombre_provincia($provincia){
        $provincias = [
            "02" => "Ciudad Autónoma de Buenos Aires",
            "06" => "Buenos Aires",
            "10" => "Catamarca",
            "14" => "Córdoba",
            "18" => "Corrientes",
            "22" => "Chaco",
            "26" => "Chubut",
            "30" => "Entre Ríos",
            "34" => "Formosa",
            "38" => "Jujuy",
            "42" => "La Pampa",
            "46" => "La Rioja",
            "50" => "Mendoza",
            "54" => "Misiones",
            "58" => "Neuquén",
            "62" => "Río Negro",
            "66" => "Salta",
            "70" => "San Juan",
            "74" => "San Luis",
            "78" => "Santa Cruz",
            "82" => "Santa Fe",
            "86" => "Santiago del Estero",
            "90" => "Tucumán",
            "94" => "Tierra del Fuego, Antártida e Islas del Atlántico Sur"
        ];
    
        if (array_key_exists($provincia, $provincias)){
            return $provincias[$provincia];
        } else{
            return "";
        }
    }

    function obtener_nombre_categoria($id) {
        global $db;
    
        $id = intval($id);
        if ($id <= 0) {
            return null;
        }
    
        $stmt = $db->prepare("SELECT nombre_categoria FROM categoria WHERE id_categoria = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        }
    
        return $result['nombre_categoria'];
    }

    function obtener_nombre_subcategoria($id){
        global $db;
    
        $sql = "SELECT nombre_subcategoria
                FROM subcategoria
                WHERE id_subcategoria = ?
        ";
    
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $nombre = $stmt->fetchColumn();
    
        return $nombre;
    }
    
    function insertar_usuario($nombre, $apellido, $email, $perfil, $existe){
        global $db;
    
        $nombre_usuario = $existe ? "$nombre$apellido" : "";
        $sql = "INSERT INTO usuario (nombre_usuario, nombre, apellido, email, perfil)
                VALUES (:nombre_usuario, :nombre, :apellido, :email, :perfil)
        ";
    
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':nombre_usuario', $nombre_usuario);
        $stmt->bindValue(':nombre', $nombre);
        $stmt->bindValue(':apellido', $apellido);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':perfil', $perfil);
        $stmt->execute();
    
        return $db->lastInsertId();
    }

    function insertar_usuario_rs ($id_usuario, $id, $servicio = 'Google'){
        global $db;

        $sql = "INSERT INTO usuario_rs (id_usuario, id_social, servicio) VALUES
                (?,?,?)
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id_usuario, $id, $servicio]);
    }

    function insertar_compra($id_usuario, $monto, $payment_id, $fecha, $estado, $email){
        global $db;
    
        $query = "INSERT INTO compra (id_usuario, total, id_transaccion, fecha, estado, email) 
                  VALUES (:id_usuario, :total, :id_transaccion, :fecha, :estado, :email)";
    
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->bindValue(':total', $monto);
        $stmt->bindValue(':id_transaccion', $payment_id);
        $stmt->bindValue(':fecha', $fecha);
        $stmt->bindValue(':estado', $estado);
        $stmt->bindValue(':email', $email);
    
        $stmt->execute();
    
        return $db->lastInsertId();
    }

    function insertar_detalle_compra($id_compra, $id_producto, $nombre, $precio_unitario, $cantidad){
        global $db;
    
        $sql = "INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad) 
                VALUES (:id_compra, :id_producto, :nombre, :precio, :cantidad)
        ";
    
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
        $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':precio', $precio_unitario, PDO::PARAM_STR);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
    
        return $stmt->execute();
    }

    function obtener_usuario_con_email($email){
        global $db;

        $stmt = $db->prepare("
            SELECT id_social, id_usuario
            FROM `usuario_rs` as rs
            INNER JOIN `usuario` as u ON rs.id_usuario = u.id  
            WHERE (u.email = :email)
        ");

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    function obtener_usuario_con_id_rs($id){
        global $db;

        $sql = "SELECT u.id
                FROM usuario as u 
                INNER JOIN usuario_rs as rs ON u.id = rs.id_usuario
                WHERE rs.id_social = :id
        ";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    function obtener_usuario_con_nombre_usuario($nombre_usuario){
        global $db;
    
        $stmt = $db->prepare("SELECT nombre_usuario FROM usuario WHERE nombre_usuario = :nombreUsuario");
        $stmt->bindValue(':nombreUsuario', $nombre_usuario, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result;
    }

    function obtener_favoritos($id_usuario) {
        global $db;

        $stmt = $db->prepare("
            SELECT `descripcion`, `material`, `color`, `caracteristicas`, `marca` , `precio`,`codigo`,p.`id`
            FROM `producto` as p 
            INNER JOIN `favorito` as f on p.id = f.id_producto 
            WHERE f.id_usuario = :idUsuario
        ");
        $stmt->bindParam(':idUsuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function eliminar_favorito($db, $id_producto, $id_usuario) {
        $id_usuario = intval($id_usuario);

        if (!isset($_SESSION["idUsuario"])){
            $sql = "SELECT id
                    FROM usuario
                    WHERE id_social = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id_usuario]);
            $row = $stmt->fetch();
            $id_usuario = $row["id"];
        }

        $sql = "DELETE FROM favorito
                WHERE (id_producto = ? AND id_usuario = ?)
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id_producto, $id_usuario]);

        return "ok";
    }

    function eliminar_direccion($direccion) {
        if (!file_exists($direccion)) {
            return false;
        }
        if (!is_dir($direccion)) {
            return unlink($direccion);
        }

        foreach (scandir($direccion) as $item) {
            if ($item == "." || $item == "..") {
                continue;
            }
            if (!eliminar_direccion($direccion . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        
        return rmdir($direccion);
    }

    function subir_imagen($imagen, $url, $destination){
        $imagen_name = $imagen["name"];
        $imagen_tmp = $imagen["tmp_name"];
        $imagen_error = $imagen["error"];
        $imagen_ext = strtolower(pathinfo($imagen_name, PATHINFO_EXTENSION));
    
        define("ALLOWED_EXTENSIONS", array("jpg", "jpeg", "png"));
    
        // Se comprueba si la extensión es válida
        if (!in_array($imagen_ext, ALLOWED_EXTENSIONS)) {
            return false;
        }
    
        // Se comprueba si la imagen se subió correctamente
        if ($imagen_error !== 0) {
            return false;
        }
    
        // Se determina la nueva ruta de destino
        if ($url === "veFuncProductoAlta.php"){
            $imagen_name_new = "portada." . $imagen_ext;
            mkdir($destination, 0777, true);
            $new_destination = $destination . $imagen_name_new;
        } else {
            $new_destination = $destination . "." . $imagen_ext;
        }

        if(move_uploaded_file($imagen_tmp, $new_destination)){
            $new_destination = str_replace("../", "", $new_destination);
            return $new_destination;
        } else {
            return false;
        }
    }
?>