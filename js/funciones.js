window.onload = function (){
    let busqueda = document.getElementById ('lupa');
    let filtro = document.getElementById ('header-buscar'); 
    
    if (busqueda != null){
        filtro.addEventListener ("keydown", function (event){
            if (event.key === "Enter"){
                window.location.href = 'productos.php?buscador='+filtro.value;
            }
        })
        busqueda.addEventListener ("click", () =>{
            window.location.href = 'productos.php?buscador='+filtro.value;
        });
    }
}


