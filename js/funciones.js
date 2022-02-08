window.onload = function (){
    let busqueda = document.getElementById ('lupa');
    
    if (busqueda != null){
        busqueda.addEventListener ("click", () =>{
            let filtro = document.getElementById ('header-buscar').value;
            window.location.href = 'productos.php?buscador='+filtro;
        });
    }
}


