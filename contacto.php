<!DOCTYPE html>
<?php  
    include("encabezado.php");
    include("pie.php");

	if (perfil_valido(1)) {
        header("location:ve.php");
    }  
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catato Hogar</title>
    <link type="text/css"  href="css/estilos.css" rel="stylesheet"/>
    <style>
		body{
			margin: 0;
		}
		
		main{
			padding:20px 0;
			background-color: #fef7f1;
		}

		.cont-con{
			padding-top: 10px;
			display:flex;
			flex-flow: column;
			justify-content: center;
			height: 420px;
			width: 380px;
			margin: 0 auto;
			border: 2px solid black;
			background-color: white;
			border-radius:5px;
		}

        .input{
			width: 90%;
			height: 50px;
			margin: auto;
			padding: 0 10px;
			font-size: 1.1em;
	    }

		.input::placeholder { 
			color: black;
			padding-left: 2px;
		 }

	    .txt-area{
		   height: 100px;
		   width: 90%;
		   background-color: white;
		   color: black;
		   padding: 0 10px;
		   font-size: 1.2em;
		   margin: auto;
	    }

		.cont-btn{
			display:flex;
			justify-content: flex-end;
			padding-right:10px;
			margin: auto;
		}
		
	    .btn-enviar{
		   height: 40px;
		   width:100px;
		   border: 2px solid black;
		   font-size:1.2em;
		   background-color: white;
		   border-radius: .1875rem;

	    }

		.btn-enviar:hover {
            background-color: #B2BABB ;
            transition: all 0.3s linear;
            color: white;
            cursor:pointer
        }

		#e_error{
			color: red;
			font-size: 0.8em;
		}
    </style>
	<script>
		function validar(){

            document.getElementById("e_error").innerHTML="";

			nombre = document.getElementById("nombre").value;
			apellido = document.getElementById("apellido").value;
			email = document.getElementById("email").value;
			txtIngresado = document.getElementById("txtIngresado").value;

			txtErrores = "";

			if( nombre == null || nombre.trim() == ""){
				txtErrores += "Debe ingresar su nombre";
			}
			else if( apellido == null || apellido.trim() == ""){
				txtErrores += "Debe ingresar su apellido";
			}
			else if( email == null || email.trim() == ""){
				txtErrores += "Debe ingresar su email";
			}
			else if( txtIngresado == null || txtIngresado.trim() == ""){
				txtErrores += "Debe ingresar una consulta";
			}

			let devolucion = false;
            
            if(txtErrores == ""){
				devolucion = true;
			}
  
            if (!devolucion){
                let error = document.getElementById("e_error");
                let hijo = document.createTextNode(txtErrores);
				error.appendChild(hijo);
            }

            return devolucion;
		}    
	</script>
</head>
<body>
	<header>
		<?php echo $encab;?>
	</header>

    <main>
		<form action="nuevo_contacto.php" method="post"> 
			<div class="cont-con">
				<input type="text" class="input" name="nombre" id="nombre" title="Nombre" value="" placeholder="Nombre" Maxlength="35" >
				<input type="text" class="input" name="apellido" id="apellido" title="Apellido" value="" placeholder="Apellido" >
				<input type="text" class="input" name="email" id="email" title="Email" value="" placeholder="Email" >
				<textarea id="txtIngresado" class="txt-area" name="txtIngresado" ></textarea>
				<p id="e_error">

                </p>
				<div class="cont-btn">
					<input type="submit" class="btn-enviar" name="enviar" id="enviar" title="Enviar" value="Enviar" onclick="javascript:return validar()"> <br>
				</div>
			</div>	
		</form>		 	 
	</main>
	
	<?php echo $pie;?>
	
</body>
</html>