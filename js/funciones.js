window.onload = function (){
    let filtro = document.getElementById ('header-buscar'); 
    let eliminarCarrito = document.getElementsByClassName('elim-prod');
    let agregarFavorito = document.getElementsByClassName ('fav-prod');
    let modificarCarrito = document.getElementsByClassName ('cant-compra');

    document.addEventListener('click', ev => {
        if (ev.target.matches('#inicio')){
            window.location.href = 'index.php';
        }
        else if (ev.target.matches('#lupa')){
            window.location.href = 'productos.php?buscador='+filtro.value;
        }
        else if (ev.target.matches('#nuevaConsulta')){
            window.location.href = 'contacto.php';
        }
        else if (ev.target.matches('.btnRedirigir')){
            window.location.href = 'pago.php';
        }
        else if (ev.target.matches('#cancelar')){
            window.location.href = 'informacionPersonal.php';
        }
        else if (ev.target.matches('#continuar')){
            window.location = "productos.php?productos=todos";
        }
        else if (ev.target.matches('#ocultar')){
            let mp = document.getElementsByClassName('mercadopago-button');

            for (let i=0; i < mp.length;i++){
                mp[i].style.visibility = 'hidden';
            }
        }
        else if (ev.target.matches('#btnInfoPersonal')){
            window.location.href='informacionPersonal.php';
        }
        else if (ev.target.matches('#btnCompraUsuario')){
            window.location.href='comprasUsuario.php';
        }
        else if (ev.target.matches('#btnFavoritos')){
            window.location.href='favoritos.php';
        }
        else if (ev.target.matches('#btnConsultas')){
            window.location.href='consultaUsuario.php';
        }
        else if (ev.target.matches('#btnCerrarSesion')){
            window.location.href='cerrarSesion.php';
        }
        else if (ev.target.matches('#procederCompra')){
            window.location.href='pago.php';
        }
        else if (ev.target.matches('#header-menu')){
            document.getElementById('mobile-header').style.display = 'flex';
            document.getElementById('cont-mobile-menu').style.display = 'flex';
            document.getElementById('container-header').style.display = 'none';
            document.getElementById('mobile-perfilUsuario').style.display = 'flex';

        }else if (ev.target.matches('#mobile-menu')){
            document.getElementById('mobile-header').style.display = 'none';
            document.getElementById('container-header').style.display = 'flex';
            document.getElementById('mobile-perfilUsuario').style.display = 'none';
            document.getElementById('cont-mobile-menu').style.display = 'none';
        }
	});

    document.addEventListener('keydown', ev => {
        if (ev.target.matches('#header-buscar')){
            if (ev.key === "Enter"){
                window.location.href = 'productos.php?buscador='+filtro.value;
            }
        }
    });

    // document.addEventListener('change', ev => {
    //     let id = ev.target.id;

    //     modificarProducto(id);
    // });
        
    let url = window.location.pathname;
    let imagenes = document.getElementsByClassName('img-cat'); //Imagenes de los productos

    if(url.indexOf('productos') !== -1) {
        $(imagenes).each ((index,imagen,array) => {
            imagen.addEventListener ('click', () => {
                let categoria = getQueryVariable ('cate');
                let subcategoria = getQueryVariable ('sub');
                let articulos = getQueryVariable ('articulos');
                let articulo = imagen.getAttribute('alt');

                if (categoria != false){
                    window.location = 'detalleArticulo.php?categoria='+categoria+'&subcategoria='+subcategoria+
                    '&articulos='+articulos+'&art='+articulo;
                }
                else{
                    window.location = 'detalleArticulo.php?art='+articulo;
                }
            })
        });
    }
    else if((url.indexOf('carritoCompras') !== -1) || (url.indexOf('comprasUsuario') !== -1)
    || (url.indexOf('favoritos') !== -1 )){
        $(imagenes).each ((index,imagen,array)=>{
            imagen.addEventListener ('click', () => {
                let articulo = imagen.getAttribute('alt');
                window.location = 'detalleArticulo.php?art='+articulo;
            });
        });

        let contenedorEnlaces = document.getElementsByClassName('cont-enlaces');

        for (j=0;j<imagenes.length;j++){
            let articulo = imagenes[j].getAttribute('alt');

            contenedorEnlaces[j].addEventListener ("click" , () => {
                window.location = 'detalleArticulo.php?art='+articulo;
            });
        }
    }
    else if(url.indexOf('subcategoria') !== -1){
        let categoria = getQueryVariable ('categoria');

        //Enviar a prod segun la subcategoria que se eligió
        $(imagenes).each ((index,imagen,array)=>{
            imagen.addEventListener ('click', () => {
                let img = imagen.getAttribute('alt');
                img = img.substring(0, 4);
                let title = imagen.getAttribute('title');
                window.location = 'productos.php?articulos='+img+'&cate='+categoria+'&sub='+title;
            });
        });
    }

    if (url.indexOf('carritoCompras') !== -1){
        for (let i=0; i<eliminarCarrito.length;i++){
            eliminarCarrito[i].addEventListener ("click", () => {
                let id = eliminarCarrito[i].value;
                eliminarProducto (id);
            });
        }

        for (let i=0; i<agregarFavorito.length;i++){
            agregarFavorito[i].addEventListener ("click", () => {
                let id = agregarFavorito[i].value;
                agregarFav (id);
            });
        }
    }
    else if (url.indexOf('favorito') !== -1){
        let agregarCarrito = document.getElementsByClassName('prod-fav');
        let eliminarFavorito = document.getElementsByClassName ('elim-fav');

        for (let i=0; i<agregarCarrito.length;i++){
            agregarCarrito[i].addEventListener ("click", () => {
                let id = agregarCarrito[i].value;
                agregarProducto (id);
            });
        }

        for (let i=0; i<eliminarFavorito.length;i++){
            eliminarFavorito[i].addEventListener ("click", () => {
                let id = eliminarFavorito[i].value;
                eliminarFav(id);
            })
        }
    }
}

//INDEX
const ponerMouse = (texto,imagen) => {
    texto.style.transition = "opacity 0.4s linear";
    texto.style.opacity = "1";
    imagen.style.transform="scale(0.9)";
    imagen.style.opacity="1";
}

//CARRITO COMPRAS
const excel = () => {			
    document.getElementById("datos").method = "post";
    document.getElementById("datos").action = "carritoXLS.php";
    document.getElementById("datos").submit(); 
}	

//UTILIZADAS EN CARRITO COMPRAS
const agregarFav = (id) => {
        let param = {
            id: id
        };

        $.ajax({
            data: param,
            url: "agregarFavorito.php?id="+id,
            method: "post",
            success: function(data) {
                if (data == 'ok'){
                    window.location.href = 'carritoCompras.php?fav=ok#mensaje';
                }
                else{
                    window.location.href = 'carritoCompras.php?fav=false#mensaje';
                }
            }
        });			
}

const eliminarProducto = (id) => {
    let param = {
        id: id
    };

    $.ajax({
        data: param,
        url: "eliminarCarrito.php",
        method: "post",
        success: function(data) {
            let datos = JSON.parse(data);

            if (datos['ok']){
                let cantCarrito = document.getElementById('num-car');
                cantCarrito.innerHTML = datos.numero;

                if (location.hash == '#mensaje'){
                    location.reload();
                }
                else{
                    window.location.href = 'carritoCompras.php?elim=ok#mensaje';
                }
            }
        }
    });			
}
/*
* 
*/
//Recibe el id de la cantidad cambiada
const modificarProducto = (id) => {
    let cantElemento = document.getElementById(id).value;
    let prodCambiado = id.slice(5);
    let subtotal = document.getElementById('subtotal');

    let producto = document.getElementsByClassName('elim-prod')[prodCambiado-1].value;

    let precioProdAnterior = document.getElementById('precioS-'+prodCambiado).textContent;
    precioProdAnterior = precioProdAnterior.trim().slice(1); //le saco $
    let precioUnitario = document.getElementById('precioU-'+prodCambiado).textContent; 
    precioUnitario = precioUnitario.trim().slice(1); //obtengo precio unitario de ese producto

    let nuevoPrecioProducto = parseInt(cantElemento) * parseInt(precioUnitario); 
    let precioSubtotal = document.getElementById('precioS-'+prodCambiado); //obtengo el lugar donde tengo que poner el precio actualizado
    precioSubtotal.innerHTML= "<b>$" + nuevoPrecioProducto + "</b>";

    let totalAnterior = document.getElementById('total');
    let sumaTotal = parseInt(totalAnterior.textContent.trim().slice(1));

    sumaTotal = sumaTotal + nuevoPrecioProducto - precioProdAnterior;

    subtotal.innerHTML = "$ " + sumaTotal;
    totalAnterior.innerHTML = "<b>$ " + sumaTotal + "</b>";

    let param = {
        id: producto,
        cantidad: cantElemento,
    };

    $.ajax({
        data: param,
        url: "modificarCarrito.php",
        method: "post",
        success: function(data) {
            let datos = JSON.parse(data);

            if (datos['ok']){
                let cantCarrito = document.getElementById('num-car');
                cantCarrito.innerHTML = datos.numero;
            }
        }
    });	
}

//UTILIZADAS EN DETALLE ARTICULO
const agregarFavorito = (id) => {
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        let regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    let param = {
        id: id
    };

    $.ajax({
        data: param,
        url: "agregarFavorito.php?id="+id,
        method: "post",
        success: function(data) {
            let url = window.location.href.split('?')[0];
            let categoria = getParameterByName ('categoria');
            let subcategoria = getParameterByName ('subcategoria');
            let articulos = getParameterByName ('articulos');
            let articulo = getParameterByName('art');
            let parrafo = document.getElementsByClassName('parrafo-exito');
            let mensaje = document.getElementsByClassName('mensaje');

            if (mensaje[0] != null){
                mensaje[0].style.display = 'block';
            } 

            if (parrafo[0] != null){
                parrafo[0].style.display = 'none';
            } 

            if (data == 'ok'){
                if (categoria != ""){
                    window.location.href = url+'?categoria='+categoria+'&subcategoria='+subcategoria+
                    '&articulos='+articulos+'&art='+articulo+'&fav=ok'+'#mensaje';
                }
                else{
                    window.location.href = url+'?art='+articulo+'&fav=ok'+'#mensaje';
                }
            }
            else if(data == 'login') {
                window.location.href = 'login.php';
            }
            else{
                if (categoria != ""){
                    window.location.href = url+'?categoria='+categoria+'&subcategoria='+subcategoria+
                    '&articulos='+articulos+'&art='+articulo+'&fav=false'+'#mensaje';
                }
                else{
                    window.location.href = url+'?art='+articulo+'&fav=false'+'#mensaje';
                }
            }
        }
    });			
}

//DETALLE ARTICULO y FAVORITOS
const agregarProducto = (id) => {
    let param = {
        id: id
    };

    $.ajax({
        data: param,
        url: "agregarCarrito.php",
        method: "post",
        success: function(data) {
            let datos = JSON.parse(data);

            if (datos['ok']){
                let cantCarrito = document.getElementById('num-car');
                cantCarrito.innerHTML = datos.numero;

                let pExito = document.getElementsByClassName('parrafo-exito');

                if (pExito[0] == null){
                    let mensaje = document.getElementsByClassName('mensaje');

                    if (mensaje[0] != null){
                        mensaje[0].style.display = 'none';
                    } 

                    let contenedor = document.getElementById('cont-descripcion');//Si se ejecuta en carrito compras
                    let favoritos = false;
                    if (contenedor == null){
                        favoritos = true;
                        contenedor = document.getElementById('consulta'); //Si se ejecuta en favoritos
                    }

                    let parrafo = document.createElement("p");
                    let carrito = document.createElement("a");

                    parrafo.setAttribute("class","parrafo-exito");
                    parrafo.setAttribute("id","parrafo-exito");
                    carrito.setAttribute("class","carrito-compras");
                    carrito.setAttribute("href","carritoCompras.php");
                    carrito.innerHTML = 'carrito de compras';

                    let contenido = document.createTextNode("¡Se ha añadido el producto al ");
                    let cont_final = document.createTextNode("!");

                    parrafo.appendChild(contenido);
                    parrafo.appendChild(carrito);
                    parrafo.appendChild(cont_final);
                    contenedor.appendChild(parrafo);
                    window.location.hash = '#parrafo-exito'; //solo
                }
            }
        }
    });			
}		

//UTILIZADAS EN FAVORITOS
const agregarProductoCompra = (id) => {
    let param = {
        id: id
    };

    $.ajax({
        data: param,
        url: "agregarCarrito.php",
        method: "post",
        success: function(data) {
            let datos = JSON.parse(data);

            if (datos['ok']){
                let cantCarrito = document.getElementById('num-car');
                cantCarrito.innerHTML = datos.numero;

                let pExito = document.getElementsByClassName('parrafo-exito');

                if (pExito[0] == null){

                    let mensaje = document.getElementsByClassName('mensaje');

                    if (mensaje[0] != null){
                        mensaje[0].style.display = 'none';
                    } 

                    let contenedor = document.getElementsByClassName('consulta');
                    let parrafo = document.createElement("p");
                    let carrito = document.createElement("a");

                    parrafo.setAttribute("class","parrafo-exito");
                    carrito.setAttribute("class","carrito-compras");
                    carrito.setAttribute("href","carritoCompras.php");
                    carrito.innerHTML = 'carrito de compras';

                    let contenido = document.createTextNode("¡Se ha añadido el producto al ");
                    let cont_final = document.createTextNode("!");

                    parrafo.appendChild(contenido);
                    parrafo.appendChild(carrito);
                    parrafo.appendChild(cont_final);
                    contenedor[0].appendChild(parrafo);
                }
            }
        }
    });			
}  

const eliminarFav = (id) => {
    let param = {
        id: id
    };

    $.ajax({
        data: param,
        url: "eliminarFavorito.php?id="+id,
        method: "post",
        success: function(data) {
            if (data == 'ok'){
                if (location.hash == '#mensaje'){
                    location.reload();
                }
                else{
                    window.location.href = 'favoritos.php?elim=ok#mensaje';
                }
            }
        }
    });			
}

//INFORMACION PERSONAL
const modDatos = (provincia) => {
    let input = document.getElementsByClassName('dato');
    let confirmar = document.getElementById('confirmar');
    let cancelar = document.getElementById('cancelar');
    let modificar = document.getElementById('modificarDatos');
    let mensaje = document.getElementById ('mensaje');
    let descripcion = document.getElementsByClassName('descripciones');

    if (input[0].readOnly){
        for (let i=0; i< input.length; i++){
            if (i !== 4){
                input[i].readOnly = false;
                input[i].style.border = '1px solid #000';
                input[i].style.borderRadius = '5px';
            }
        }

        confirmar.style.display = 'block';
        cancelar.style.display = 'block';
        modificar.style.display = 'none';

        for (let i=0; i<descripcion.length;i++){
            descripcion[i].style.border = 'none';
        }

        if (mensaje != null){
            mensaje.style.display = 'none';
        }

        descripcion[5].style.display='none';
        descripcion[6].style.display='flex';
        let selectProvincia = document.getElementById('provincia');
        selectProvincia.style.display = 'block';
        document.getElementById('prov').style.display = 'none';

        for (let i=0; i<selectProvincia.length;i++){
            if (selectProvincia[i].innerHTML == provincia){
                selectProvincia[i].selected = true;
            }
        }

        descripcion[7].style.display='none';
        descripcion[8].style.display='flex';

        actualizarCiudad();
        let inputCiudad = document.getElementById('inputCiudad');
        inputCiudad.style.display = 'none';

        let direccion = document.getElementsByClassName('dato');
        direccion = direccion[7].value;

        //Se utiliza auxDireccion porque algunas ciudades empiezan con numero, ej: 25 de mayo, 9 de julio...
        let auxDireccion = direccion.substring(4,direccion.length);
        let numeroDesde = auxDireccion.search(/[1-9]/);
        let numeroHasta = direccion.indexOf(',', numeroDesde);
        let numero = direccion.substring (numeroDesde+4, numeroHasta-1);
        let calle = direccion.substring (0,numeroDesde+3);
        let piso = direccion.substring(numeroHasta+2, direccion.length);

        let inputDireccion = document.getElementById('direccion');
        let inputCalle = document.getElementById('inputCalle');
        let inputNumero = document.getElementById('inputNumero');
        let inputPiso = document.getElementById('inputPiso');
        let divDireccion = document.getElementsByClassName('direccion');
        divDireccion = divDireccion[0];
        divDireccion.style.display = 'flex';
        inputDireccion.style.display = 'none';

        inputCalle.value = calle;
        inputNumero.value = numero;
        inputPiso.value = piso;
    }
    else{
        if (window.hash == '#mensaje'){
            window.location = 'informacionPersonal.php';
        }
        else{
            location.reload();
        }
    }
}

const actualizarCiudad = (ciudad) => {
    let prov = "prov=" + $('#provincia').val();
    let ciu = "ciudad=" + $('#inputCiudad').val();

    $.ajax ({
        type: "POST",
        url: "rellenarSelect.php",
        data: prov + "&" + ciu,
        success: function (datos){
            let contenedorCiudad = document.getElementById('contenedorCiudad');
            let renglonCiudad = document.getElementById ('renglonCiudad');

            if (contenedorCiudad != null){
                renglonCiudad.removeChild(contenedorCiudad);
            }
            let div = document.createElement('div');
            div.setAttribute('id','contenedorCiudad');
            div.innerHTML = datos;
            renglonCiudad.appendChild(div);

            let selectCiudad = document.getElementById('ciu');
            if (selectCiudad != null){
                let contenedor = document.getElementById('contenedorCiudad');
                contenedor.style.width = "48%";
                selectCiudad.style.display = 'block';
            }  
            else{
                let input = document.getElementsByClassName('dato');
                if (!input[0].readOnly){
                    let contenedor = document.getElementById('contenedorCiudad');
                    contenedor.style.width = '50%';
                }
            }          
        }
    });
}	

//LOGIN
const validarLogin = () => {
    document.getElementById('e_error').innerHTML="";

    nombreUser = document.getElementById('nombreUsuario').value;
    psw = document.getElementById('psw').value;
    
    txtErrores = "";

    if(nombreUser == null || nombreUser.trim() == ""){
        txtErrores += "Debe ingresar el nombre de usuario";
    }     
    else if(psw == null || psw.trim() == ""){
        txtErrores += "Debe ingresar la contraseña";
    }          
    
    let devolucion = false;
    
    if(txtErrores == ""){
        devolucion = true;
    }

    if (!devolucion){
        let error = document.getElementById('e_error');
        error.style.display = 'block';
        let hijo = document.createTextNode(txtErrores);
        error.appendChild(hijo);
    }

    return devolucion;
}

//CONTACTO
const validarContacto = () => {
    document.getElementById("e_error").innerHTML="";

    let exito = document.getElementsByClassName('parrafo-exito');
    if (exito[0] != null){
        exito[0].style.display = 'none';
    }

    nombre = document.getElementById("nombre").value;
    apellido = document.getElementById("apellido").value;
    email = document.getElementById("email").value;
    txtIngresado = document.getElementById("txtIngresado").value;

    txtErrores = "";

    if( nombre == null || nombre.trim() == ""){
        txtErrores = "Debe ingresar su nombre";
    }
    else if( apellido == null || apellido.trim() == ""){
        txtErrores = "Debe ingresar su apellido";
    }
    else if( email == null || email.trim() == ""){
        txtErrores = "Debe ingresar su email";
    }
    else if( txtIngresado == null || txtIngresado.trim() == ""){
        txtErrores = "Debe ingresar una consulta";
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

//PRODUCTOS
const actualizarSubcategoria = () => {
    $.ajax ({
        type: "POST",
        url: "rellenarSelect.php",
        data: "categoria= " + $('#categoria').val (),
        success: function (r){
            $('#subc').html (r);
        }
    });
}

const getQueryVariable = (variable) => {
    let query = window.location.search.substring(1);
    let vars = query.split("&");
    for (let i=0; i < vars.length; i++) {
        let pair = vars[i].split("=");
        if(pair[0] == variable) {
            return pair[1];
        }
    }
    
    return false;
}