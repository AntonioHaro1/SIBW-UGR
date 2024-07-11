
    var Escondido = true;
    /*  Booleano para escondido para saber si hay que abrir los comentarios y taparlos, y primera vez para poner el comentario de ejemplo*/
    function AbrirComentarios(){
        if(Escondido){
            // cambio las clases y los displays para abrir los comentarios
            document.getElementById("seccionComentarios").className = "ComentariosAbiertos";
            document.getElementById("botonComentarios").className = "BotonSimple2";
            document.getElementById("listaComentarios").style.display = "flex";
            document.getElementById("formularioComentario").style.display = "flex";
            document.getElementById("h3").style.display = "block";
            document.getElementById("h32").style.display = "block";
                    
            Escondido = false;
        }else{
            // cambio las clases y los displays para cerrar los comentarios
            document.getElementById("seccionComentarios").className = "Comentarios";
            document.getElementById("botonComentarios").className = "BotonSimple";
            document.getElementById("listaComentarios").style.display = "none";
            document.getElementById("formularioComentario").style.display = "none";
            document.getElementById("h3").style.display = "none";
            document.getElementById("h32").style.display = "none";
            Escondido = true;
        }
    }

    function agregarComentario() {
        // Obtener los valores de los campos de entrada
        var nombre = document.getElementById("nombre").value;
        var email = document.getElementById("email").value;
        var nuevoComentario = document.getElementById("nuevoComentario").value;

        // comprobamos que no hay nada vacio si hay algo vacio sale de la funcion y no manda el comentario
        if (nombre === '' || email === '' || nuevoComentario === '') {
            Swal.fire({
                icon: 'error',
                text: 'Por favor, completa todos los campos.',
            });
            return;
        }

        var Valido = false;
        for(var i = 0; i < terminaciones.length; i++){
            var terminacion = terminaciones[i].terminacion;
            var emailReg = new RegExp('.' + terminacion + "$");

            if(email.match(emailReg)){
                Valido = true;
                break;
            }
        }

                // si no es valido salta notificacion y no se manda el comentario
            if(!Valido){
                Swal.fire({
                    icon: 'error',
                    text: 'Por favor, introduzca un email valido',
                });
                return;
            }

            // Notificacion de exito
            Swal.fire({
                icon: "success",
                text: 'Comentario agregado',
            }).then((result) => {
                // Si el usuario hace clic en Aceptar, enviar el formulario y recargar la página
                // lo hago aqui para que compruebe todo antes de hacer el submit directamente
                if (result.isConfirmed) {
                    document.getElementById("formularioComentario").submit();
                    document.getElementById("nombre").value = "";
                    document.getElementById("email").value = "";
                    document.getElementById("nuevoComentario").value = "";
                    }
                });
            }


            // Funcion para buscar malos comentarios
            
    function BuscarComentario(){
        // creamos una lista de palabras prohibidas, y extraemos el comentario
        var comentario = document.getElementById("nuevoComentario").value;


        PalabrasProhibidas.forEach(function(Palabra) {
            var palabrota = new RegExp('\\b' + Palabra.palabra + '\\b', 'gi');
    
            // Busca la palabra y si está, la reemplaza por asteriscos de la misma longitud que la palabra
            comentario = comentario.replace(palabrota, "*".repeat(Palabra.palabra.length));
        });


        // cambia el comentario para que salgan los asteriscos
        document.getElementById("nuevoComentario").value = comentario;
    }
