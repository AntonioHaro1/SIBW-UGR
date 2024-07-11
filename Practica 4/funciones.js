
    var Escondido = true;
    var EscondidoNombreCompleto = true;
    var Escondidousuario = true;
    var Escondidoemail = true;
    var Escondidocontraseña = true;
    var EscondidoAñadirImagen = true;

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
        var nuevoComentario = document.getElementById("nuevoComentario").value;

        // comprobamos que no hay nada vacio si hay algo vacio sale de la funcion y no manda el comentario
        if (nuevoComentario === '') {
            Swal.fire({
                icon: 'error',
                text: 'Por favor, completa el campo',
            });
            return;
        }
        

        if (!logueado) {
            Swal.fire({
                icon: 'error',
                text: 'Por favor inicie sesión',
                showCancelButton: true,
                confirmButtonText: 'Iniciar sesión',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'login.php'; // Reemplaza con la URL de tu página de inicio de sesión
                }
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
    function BuscarComentario(id){
        // creamos una lista de palabras prohibidas, y extraemos el comentario
        var comentario = document.getElementById(id).value;


        PalabrasProhibidas.forEach(function(Palabra) {
            var palabrota = new RegExp('\\b' + Palabra.palabra + '\\b', 'gi');
    
            // Busca la palabra y si está, la reemplaza por asteriscos de la misma longitud que la palabra
            comentario = comentario.replace(palabrota, "*".repeat(Palabra.palabra.length));
        });


        // cambia el comentario para que salgan los asteriscos
        document.getElementById(id).value = comentario;
    }

    function abremodificarnombrecompleto(){
        if(EscondidoNombreCompleto){
            document.getElementById("FormularioNombrecompleto").style.display = "flex";
            EscondidoNombreCompleto = false;
        }else{
            document.getElementById("FormularioNombrecompleto").style.display = "none";
            EscondidoNombreCompleto = true;
        }

    }

    function abremodificarusuario(){
        if(Escondidousuario){
            document.getElementById("FormularioUsuario").style.display = "flex";
            Escondidousuario = false;
        }else{
            document.getElementById("FormularioUsuario").style.display = "none";
            Escondidousuario = true;
        }

    }

    function abremodificarcontraseña(){
        if(Escondidocontraseña){
            document.getElementById("Formulariocontraseña").style.display = "flex";
            Escondidocontraseña = false;
        }else{
            document.getElementById("Formulariocontraseña").style.display = "none";
            Escondidocontraseña = true;
        }

    }

    function abremodificaremail(){
        if(Escondidoemail){
            document.getElementById("Formularioemail").style.display = "flex";
            Escondidoemail = false;
        }else{
            document.getElementById("Formularioemail").style.display = "none";
            Escondidoemail = true;
        }

    }

    function comprobarCorreo(){
        var email = document.getElementById("email").value;
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
                text: 'Correo modificado',
            }).then((result) => {
                // Si el usuario hace clic en Aceptar, enviar el formulario y recargar la página
                // lo hago aqui para que compruebe todo antes de hacer el submit directamente
                if (result.isConfirmed) {
                    document.getElementById("postemail").submit();
                    }
            });
    }


    function comprobarNick(){
        var nick = document.getElementById("usuario").value;
        // comprobar la lista de usuarios y comprobar que no hay ningun usuario con ese nombre

        var Valido = true;
        for(var i = 0; i < usuarios.length; i++){
            var nickk = usuarios[i].username;

            if(nickk === nick){
                Valido = false;
                break;
            }
        }

            // si no es valido salta notificacion y no se manda el comentario
            if(!Valido){
                Swal.fire({
                    icon: 'error',
                    text: 'El nick ya esta escogido',
                });
                return;
            }

            // Notificacion de exito
            Swal.fire({
                icon: "success",
                text: 'Nick modificado',
            }).then((result) => {
                // Si el usuario hace clic en Aceptar, enviar el formulario y recargar la página
                // lo hago aqui para que compruebe todo antes de hacer el submit directamente
                if (result.isConfirmed) {
                    document.getElementById("postnick").submit();
                    }
            });
    }

    function comprobarNombreCompleto(){

            // Notificacion de exito
            Swal.fire({
                icon: "success",
                text: 'Nombre modificado',
            }).then((result) => {
                // Si el usuario hace clic en Aceptar, enviar el formulario y recargar la página
                // lo hago aqui para que compruebe todo antes de hacer el submit directamente
                if (result.isConfirmed) {
                    document.getElementById("postNombreCompleto").submit();
                    }
            });
    }

    function comprobarContraseña(){

        // Notificacion de exito
        Swal.fire({
            icon: "success",
            text: 'Contraseña modificada',
        }).then((result) => {
            // Si el usuario hace clic en Aceptar, enviar el formulario y recargar la página
            // lo hago aqui para que compruebe todo antes de hacer el submit directamente
            if (result.isConfirmed) {
                document.getElementById("postcontraseña").submit();
                }
        });
}

function iniciosesion(){
    var nick = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    // comprobar la lista de usuarios y comprobar que no hay ningun usuario con ese nombre

    var Valido = true;
    for(var i = 0; i < usuarios.length; i++){
        var nickk = usuarios[i].username;

        if(nickk == nick){
            Valido = false;
            break;
        }
    }

        // si no es valido salta notificacion y no se manda el comentario
        if(!Valido){
            Swal.fire({
                icon: 'error',
                text: 'El nick ya esta escogido',
            });
            return;
        }

        // Notificacion de exito
        Swal.fire({
            icon: "success",
            text: 'Nick modificado',
        }).then((result) => {
            // Si el usuario hace clic en Aceptar, enviar el formulario y recargar la página
            // lo hago aqui para que compruebe todo antes de hacer el submit directamente
            if (result.isConfirmed) {
                document.getElementById("postnick").submit();
                }
        });
}

function seleccionado(id, contador, permisoactual){

    var valoranterior = document.getElementById('rolSeleccionado' + contador).value

    if(id === 'usuario' && valoranterior !== 'usuario'){
        document.getElementById('usuario' + contador).className = "buttonSeleccionado";
        document.getElementById('moderador' + contador).className = "button";
        document.getElementById('gestor' + contador).className = "button";
        document.getElementById('super' + contador).className = "button";
        document.getElementById('rolSeleccionado' + contador).value = 'usuario';

    }else if(id === 'moderador' && valoranterior !== 'moderador'){
        document.getElementById('usuario' + contador).className = "button";
        document.getElementById('moderador' + contador).className = "buttonSeleccionado";
        document.getElementById('gestor' + contador).className = "button";
        document.getElementById('super' + contador).className = "button";
        document.getElementById('rolSeleccionado' + contador).value = 'moderador';

    }else if(id === 'gestor' && valoranterior !== 'gestor'){
        document.getElementById('usuario' + contador).className = "button";
        document.getElementById('moderador' + contador).className = "button";
        document.getElementById('gestor' + contador).className = "buttonSeleccionado";
        document.getElementById('super' + contador).className = "button";
        document.getElementById('rolSeleccionado' + contador).value = 'gestor';

    }else if(id === 'super' && valoranterior !== 'super'){
        document.getElementById('usuario' + contador).className = "button";
        document.getElementById('moderador' + contador).className = "button";
        document.getElementById('gestor' + contador).className = "button";
        document.getElementById('super' + contador).className = "buttonSeleccionado";
        document.getElementById('rolSeleccionado' + contador).value = 'super';

    }else{
        document.getElementById('usuario' + contador).className = "button";
        document.getElementById('moderador' + contador).className = "button";
        document.getElementById('gestor' + contador).className = "button";
        document.getElementById('super' + contador).className = "button";
        document.getElementById('rolSeleccionado' + contador).value = '';
    }

    
}

function postformulariopermiso(contador, rol, nick){

    var valor = document.getElementById("rolSeleccionado" + contador).value;

    if (valor === '') {        
        Swal.fire({
            icon: "error",
            text: "No ha seleccionado nigun permiso"
        }).then(() => {
            
        });
    }else{
        var auxsupers = supers;
        for (var i = 0; i < permisos.length; i++) {
            if(nick == permisos[i].username && permisos[i].rol == 'super' && valor != 'super' && valor != ''){
                auxsupers = supers-1;
            }  
        }

    console.log(auxsupers);
    
        Swal.fire({
            title: "¿Está seguro de cambiar sus permisos?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, cambiar permisos",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                if((auxsupers >= 1) ){
                    Swal.fire({
                        icon: "success",
                        text: "Permisos modificados exitosamente"
                    }).then(() => {
                        supers = supers-1;
                        document.getElementById("seleccionarRolForm" + contador).submit();
                    });
                }else{
                  Swal.fire({
                        icon: "error",
                        text: "No puede dejar al sistema sin usuarios supers"
                    }).then(() => {
                    });
                }

            }
        });
    }

}

function abremodificarcomentario(contador){

    document.getElementById("modificarcomentario" + contador).style.display = "flex";
    var comentario = document.getElementById('comentario' + contador).innerHTML;
    var nuevoComentarioModificado = document.getElementById('nuevoComentariomodificado' + contador);
    nuevoComentarioModificado.value = comentario    
}



function modificarcomentario(contador){

    document.getElementById("opcion" + contador).value = "modificarcomentario";
    console.log(document.getElementById("opcion" + contador).value);

        Swal.fire({
            title: "¿Está seguro de modificar el comentario?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "si, modificar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: "success",
                    text: 'Comentario modificado',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("modificarcomentario" + contador).submit();
                        }
                });
            }
        });
}

function borrarcomentario(contador){

    document.getElementById("opcion" + contador).value = "borrarcomentario";
    console.log(document.getElementById("opcion" + contador).value);

    Swal.fire({
        title: "¿Está seguro de borrar el comentario?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "si, borrar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: 'red'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: "success",
                text: 'Comentario borrado',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("modificarcomentario" + contador).submit();
                    }
            });
        }
    });
}

function añadirActividad(){

    Swal.fire({
        title: "¿Está seguro de añadir la actividad con estas caracteristicas?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "si, Añadir",
        cancelButtonText: "Cancelar",
        confirmButtonColor: 'green'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: "success",
                text: 'Actividad añadida',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("postAñadirActividad").submit();
                    }
            });
        }
    });
}

function borrarActividad(){

    Swal.fire({
        title: "¿Está seguro de borrar la actividad?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "si, Borrar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: 'red'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: "success",
                text: 'Actividad borrada',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("FormularioborrarActividad").submit();
                    }
            });
        }
    });
}

function modificarActividad(){

    Swal.fire({
        title: "¿Está seguro de modificar la actividad con estas caracteristicas?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "si, Modificar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: 'blue'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: "success",
                text: 'Actividad modificada',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("postmodificarActividad").submit();
                    }
            });
        }
    });
}

function cambiarimagen(){


    indice = (indice + 1) % Imagenes.length;
    console.log(Imagenes.length);
    console.log(indice);
            
    // Cambiar el source de la imagen
    document.getElementById("imagenUrl").src = Imagenes[indice].urlImagen;
    document.getElementById("imagenDescripcion").innerHTML = Imagenes[indice].descripcion;
}


function abririnsertarimagen(){
    if(EscondidoAñadirImagen){
        document.getElementById("postAñadirImagen").style.display = "grid";
        EscondidoAñadirImagen = false;
    }else{
        document.getElementById("postAñadirImagen").style.display = "none";
        EscondidoAñadirImagen = true;
    }
}


function aadirimagen(){

    Swal.fire({
        title: 'Ingrese una descripción',
        input: 'textarea',
        inputPlaceholder: 'Escriba una descripción...',
        showCancelButton: true,
        confirmButtonText: 'Enviar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            document.getElementById("descripcionimagen").value= result.value;
            
            Swal.fire({
                title: "¿Está seguro de subir la foto con esta descripcion?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Si",
                cancelButtonText: "Cancelar",
                confirmButtonColor: 'blue'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: "success",
                        text: 'Imagen añadida',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById("postAñadirImagen").submit();
                        }
                    });
                }
            });
        }
    });

}

function comprobarResgistro(){
    var nick = document.getElementById("username").value;
    // comprobar la lista de usuarios y comprobar que no hay ningun usuario con ese nombre

    var Valido = true;
    for(var i = 0; i < usuarios.length; i++){
        var nickk = usuarios[i].username;

        if(nickk === nick){
            Valido = false;
            break;
        }
    }

        if(!Valido){
            Swal.fire({
                icon: 'error',
                text: 'El nick ya esta escogido',
            });
            return;
        }

        var email = document.getElementById("correo").value;
        var ValidoC = false;
        for(var i = 0; i < terminaciones.length; i++){
            var terminacion = terminaciones[i].terminacion;
            var emailReg = new RegExp('.' + terminacion + "$");

            if(email.match(emailReg)){
                ValidoC = true;
                break;
            }
        }
            if(!Valido || !ValidoC){
                Swal.fire({
                    icon: 'error',
                    text: 'Por favor, introduzca un email valido',
                });
                return;
            }

            // Notificacion de exito
            Swal.fire({
                icon: "success",
                text: 'Usuario registrado',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("formregistro").submit();
                    }
            });

}


function busqueda() {
    // Captura el valor del campo de búsqueda
    var input = document.getElementById("searchInput");
    var filter = input.value.toUpperCase();

    // Obtiene la lista dentro de Boxactividades
    var actividades = document.getElementsByClassName("BoxActividades");
    
    // Itera sobre los elementos de la lista de actividades
    for (var i = 0; i < actividades.length; i++) {
        var boxes = actividades[i].getElementsByClassName("BoxActividadesBox");

        // Itera sobre los elementos de cada actividad y muestra u oculta según la búsqueda
        for (var j = 0; j < boxes.length; j++) {
            var titulo = boxes[j].getElementsByClassName("ActividadNombre")[0];
            var descripcion = boxes[j].getElementsByClassName("ActividadDescripcion")[0];

            // Comprueba si el título o la descripción coinciden con el filtro de búsqueda(lo que nosotros introducimos)
            if (titulo.innerHTML.toUpperCase().indexOf(filter) > -1 || descripcion.innerHTML.toUpperCase().indexOf(filter) > -1) {
                boxes[j].style.display = "";
            } else {
                boxes[j].style.display = "none";
            }
        }
    }
}
 

