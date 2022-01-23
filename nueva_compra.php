<?php 
    include ('config.php');
    require 'funciones.php';  
    require 'inc/conn.php';

    global $perfil;
    if ($perfil == "E"){
        header("location:ve.php");
    }  
    $msjError = "";
    
    $cantidad =(isset($_POST['cantidad']) && !empty($_POST['cantidad']))? trim($_POST['cantidad']):"";
    $codProducto =(isset($_POST['codImg']) && !empty($_POST['codImg']))? trim($_POST['codImg']):"";
    //$usuarioId = $_SESSION['idUsuario']; 
    $precio =(isset($_POST['precio']) && !empty($_POST['precio']))? trim($_POST['precio']):"";
    
    // if( $cantidad == "" && !is_numeric($cantidad)){
    //     $msjError .= "Debe seleccionar el numero de unidades"; 
    // }else if( $precio == "" && !is_numeric($precio)){
    //     $precio .= "Ha ocurrido un error inesperado";
    // }else if( $codProducto == "" ){
    //     $codProducto .= "Ha ocurrido un error inesperado"; 
    // }
    // else{  
        global $db;
          
        // $sql  = "INSERT INTO `pedido`( `precio_unidad`, `cantidad`, `producto_codigo`, `usuario_id`) VALUES 
        //         ('$precio','$cantidad','$codProducto','$usuarioId')
        // "; 
        
        // $rs = $db->query($sql);             
        
        // $sql2 ="UPDATE `producto` 
        //         SET `stock`=(stock - $cantidad)
        //         WHERE `codigo`='$codProducto' 
        // ";  
        
        // $rs2 = $db->query($sql2);   
                            
        header("location:carrito_compras.php");          
   // } 
?>