<?php
    include ('inc/session.php');
    require 'inc/conn.php';

    function crear_barra() {
        global $user;
        global $perfil;
        $links=''; 

        if ($user=='') {
            $links = "<a href='registro_usuario.php' title='Crear una cuenta de usuario' id='btn-registrar'> Registrarse</a>
                        <a href='login.php' title='Iniciar sesion' id='iniciarSesion'> Iniciar sesión</a>";
        } else if($perfil=='E'){
            $links = "  <span title='Nombre de usuario' id='span'> {$_SESSION['nombre']}  </span>
                        <a href='cerrar_sesion.php'  id='cerrar' title='Cerrar sesión de usuario'> X </a>";
        } 
        else if($perfil=='U'){
            $links = "<a href='informacion_personal.php' title='Perfil'> <span> {$_SESSION['nombre']} </span> &nbsp;</a>
                        <a href='cerrar_sesion.php' title='Cerrar sesión de usuario'> X </a>";
        }
                        
        $barra_sup ="<div id='barra_superior'>
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

    function crearListaCategorias(){ 
        global $db; 
        $nomCat = "";

        //trae los nombres de las categorias
        $sql = "SELECT nombre_categoria
                FROM `categoria` 
        "; 

        $rs = $db->query($sql); 

        //lista de categorias
        echo " 
                <label for='categoria'>CATEGORIA</label> <br>
                <select id='categoria' class='hover' name='categoria'> 
        ";       
        
        foreach ($rs as $row) {
            echo " <option value='{$row['nombre_categoria']}'> {$row['nombre_categoria']} </option> ";       
        } 
        echo " </select> "; 
    }

    function crearListaSubCat(){ 
        global $db; 
        $nomCat = "";

        //trae los nombres de las categorias
        $sql = "SELECT nombre_categoria
                FROM `categoria` 
        "; 

        $rs = $db->query($sql); 
                 
        foreach ($rs as $row) {
            $nomCat .= $row['nombre_categoria'] . ",";	
        }

        $arrNomCat = explode(",",$nomCat); 

        //lista subcategorias
        echo "  <label for='subcategoria'>SUBCATEGORIA</label> <br>
                <select name='subcategoria' class='hover'> 
        ";    
          
        foreach ($arrNomCat as $valor) {
            $nomCat = $valor;  

            $sql1 = "SELECT nombre_subcategoria
                    FROM `subcategoria`
                    WHERE nombre_categoria='$nomCat'
            "; 
            
            $rs1 = $db->query($sql1);

            foreach ($rs1 as $row1) {                         
                echo  " <option value='{$row1['nombre_subcategoria']}'> $nomCat - {$row1['nombre_subcategoria']} </option> ";                                    
            } 
        }
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

    function crearListas(){ 
        crearListaCategorias();
        crearListaSubCat();
    }   
?>