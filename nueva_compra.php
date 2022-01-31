<?php 
    include ('config.php');
    require 'funciones.php';  
    require 'inc/conn.php';

    // global $perfil;

    // if ($perfil == "E"){
    //     header("location:ve.php");
    // }  
    // $msjError = "";
    
    // $codProducto =(isset($_POST['codImg']) && !empty($_POST['codImg']))? trim($_POST['codImg']):"";
    // $precio =(isset($_POST['precio']) && !empty($_POST['precio']))? trim($_POST['precio']):"";
    // $usuarioId = $_SESSION['idUsuario'];
    
    // if( $precio == "" && !is_numeric($precio)){
    //     $precio .= "Ha ocurrido un error inesperado";
    // }else if( $codProducto == "" ){
    //     $codProducto .= "Ha ocurrido un error inesperado"; 
    // }
    // else{  
    //     global $db;
          
    //     $sql = "SELECT `producto_codigo`
    //             FROM pedido
    //             WHERE producto_codigo = '$codProducto' AND usuario_id = '$usuarioId' AND estado = 'pendiente'";
        
    //     $rs = $db->query($sql);             
    //     $i = 0;
    //     foreach ($rs as $row){
    //         $i++;
    //     }

    //     //Si el usuario no tiene un pedido pendiente con ese producto
    //     if ($i == 0){
    //         $sql  = "INSERT INTO `pedido`( `precio_unidad`, `producto_codigo`, `usuario_id`) VALUES 
    //                 ('$precio','$codProducto','$usuarioId')
    //         "; 
            
    //         $rs = $db->query($sql);             
    //     }
        
        
    //     //EL STOCK SE ACTUALIZA AUTOMATICAMENTE CUANDO SE REALIZA LA COMPRA, OSEA CUANDO ESTADO PASA DE PENDIENTE A REALIZADO
    //     // $sql2 ="UPDATE `producto` 
    //     //         SET `stock`=(stock - $cantidad)
    //     //         WHERE `codigo`='$codProducto' 
    //     // ";  
    //     //$rs2 = $db->query($sql2);   
                            
    //     header("location:carrito_compras.php");          
    //} 
?>