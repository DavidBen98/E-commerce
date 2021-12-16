
    function validarBarraLateral(){
        document.getElementById('e_error').innerHTML="";
        txtErrores = "";
        
        let minimo = document.getElementById("valorMin"); 
        let maximo = document.getElementById("valorMax");
        
        if(minimo.getAttribute('min') < minimo.getAttribute('min') || minimo.getAttribute('value') > maximo.getAttribute('max')){ 
            txtErrores += "El valor minimo tiene que estar entre " + minimo.getAttribute('min') + " y " + maximo.getAttribute('max');
        }
        else if(maximo.value < minimo.getAttribute('min') || maximo.value > maximo.getAttribute('max')){
            txtErrores += "El valor maximo tiene que estar entre " + minimo.getAttribute('min') + " y " + maximo.getAttribute('max');
        } 

        let devolucion = false;
        
        if(txtErrores == ""){
            devolucion = true;
        }

        if (!devolucion){
            let error = document.getElementById('e_error');
            let hijo = document.createTextNode(txtErrores);
            error.appendChild(hijo);
        }

        return devolucion;
    }
