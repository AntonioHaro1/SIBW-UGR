<?php
    global $mysqli;
    $mysqli = obtenerConexionBD();

    function obtenerConexionBD(){

        $mysqli = new mysqli("database", 'antonio', 'SIBW', 'SIBW');

        if ($mysqli->connect_errno) 
        {
              echo ("Fallo al conectar: " . $mysqli->connect_error);
        }
        
        return $mysqli;
    }



    function obtenerActividadPorId($id){
        global $mysqli;
        // Preparar la consulta SQL con una sentencia preparada
        $stmt = $mysqli->prepare("SELECT * FROM Actividades WHERE id = ?");
        $stmt->bind_param("i", $id); 
        $stmt->execute();

        // Manejar errores de consulta
        if ($stmt->error) {
            die("Error al ejecutar la consulta: " . $stmt->error);
        }

        // Obtener resultados de la consulta
        $result = $stmt->get_result();

        // Procesar resultados de la consulta
        if ($result->num_rows > 0) {
            $actividad = $result->fetch_assoc();
            return $actividad;
            $stmt->close();
        } else {
            // La consulta no devolvió resultados
            return null;
            $stmt->close();
        }

    }

    function obtenerActividades(){
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT * FROM Actividades");

        $stmt->execute();

        // Manejar errores de consulta
        if (!$stmt) {
            die("Error al ejecutar la consulta: " . $mysqli->error);
        }

        $result = $stmt->get_result();
        $actividadades = array();

        //preparamos los resultados
        while($actividad = $result->fetch_assoc()){
            $actividadades[] = $actividad;
        }

           
        $stmt->close();

        return $actividadades;

    }

    function obtenerImagenes() {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT * FROM imagenes");
    

        $stmt->execute();
    
        // Manejar errores de consulta
        if (!$stmt) {
            die("Error al ejecutar la consulta: " . $mysqli->error);
        }
    
        $result = $stmt->get_result();
    
        $imagenes = array();
    
        //ARRAY para las imágenes
        while ($imagen = $result->fetch_assoc()) {
            $imagenes[] = $imagen;
        }
               
        $stmt->close();

        return $imagenes;
    }
    



    function obtenerImagenesId($id) {
        global $mysqli;
        
        $stmt = $mysqli->prepare("SELECT * FROM imagenes WHERE idActividad = ?");
        $stmt->bind_param("i", $id); // "i" indica que $id es un entero
        
        $stmt->execute();
        
        // Manejar errores de consulta
        if (!$stmt) {
            die("Error al ejecutar la consulta: " . $mysqli->error);
        }
        
        $result = $stmt->get_result();
        
        $imagenes = array();
        
        //ARRAY para las imágenes
        while ($imagen = $result->fetch_assoc()) {
            $imagenes[] = $imagen;
        }       

        $stmt->close();

        return $imagenes;
    }
        

    function obtenerAnunciosAleatorios($cantidad) {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT * FROM Anuncios ORDER BY RAND() LIMIT ?");
    
        $stmt->bind_param("i", $cantidad); 
    
        $stmt->execute();
    
        // Manejar errores de consulta
        if (!$stmt) {
            die("Error al ejecutar la consulta: " . $mysqli->error);
        }
    
        $result = $stmt->get_result();
    
        $anuncios = array();
    
        while ($anuncio = $result->fetch_assoc()) {
            $anuncios[] = $anuncio;
        }
           
        $stmt->close();
    
        return $anuncios;
    }
    

    function obtenerComentariosId($idActividad) {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT * FROM Comentarios WHERE idActividad = ?");
    

        $stmt->bind_param("i", $idActividad); 
    
        $stmt->execute();

        if (!$stmt) {
            die("Error al ejecutar la consulta: " . $mysqli->error);
        }
    
        $result = $stmt->get_result();
    
        $Comentarios = array();
    
        // Obtener los comentarios
        while ($Comentario = $result->fetch_assoc()) {
            $Comentarios[] = $Comentario;
        }

           
        $stmt->close();
    
        return $Comentarios;
    }
    

    function insertarComentario($nombre, $email, $fechaActual, $horaActual, $comentario, $id) {
        global $mysqli;

        $stmt = $mysqli->prepare("INSERT INTO Comentarios (idActividad, nombre, fecha, hora, comentario, email, modificado) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $modificado = 0;
        $stmt->bind_param("isssssi", $id, $nombre, $fechaActual, $horaActual, $comentario, $email, $modificado);
    
        if ($stmt->execute()) {
            header("Location: actividad.php?id=" . $id);
            $stmt->close();
            exit();
        } else {
            echo "Error al agregar el comentario: " . $stmt->error;
        }

           
        $stmt->close();
    }
    

    function obtenerPalabrasProhibidas() {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT * FROM PalabrasProhibidas");
    
        $stmt->execute();
    
        if (!$stmt) {
            die("Error al ejecutar la consulta: " . $mysqli->error);
        }
 
        $result = $stmt->get_result();
    
        $PalabraProhibidas = array();
    
        // Obtener las palabras prohibidas
        while ($Palabra = $result->fetch_assoc()) {
            $PalabraProhibidas[] = $Palabra;
        }
        $stmt->close();

        return $PalabraProhibidas;
    }
    
    
    function obtenerCorreosPosibles(){
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT * FROM TerminacionesCorreos");

        $stmt->execute();
    
        // Manejar errores de consulta
        if (!$stmt) {
            die("Error al ejecutar la consulta: " . $mysqli->error);
        }
    
        $CorreosPosibles = array();
        $result = $stmt->get_result();

        while ($Correo = $result->fetch_assoc()) {
            $CorreosPosibles[] = $Correo;
        }
   
        $stmt->close();
    
        return $CorreosPosibles;   
    }

    
    function CheckLogin($nombre,$contraseña){
        global $mysqli;

        // Consulta preparada
        $stmt = $mysqli->prepare('SELECT * FROM usuarios WHERE username = ?');
        $stmt->bind_param("s", $nombre); // "s" para cadenas
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
           
            $user = $result->fetch_assoc();
            
            // Verifico la contraseña
            if (password_verify($contraseña, $user['password'])) {
                   
                $stmt->close();
                return true;
            }
        }
           
        $stmt->close();
        return false;
    }

    // no se usa actualmente
    function CheckUsernameEmail($nick,$email){
        global $mysqli;

        // Consulta preparada
        $stmt = $mysqli->prepare('SELECT * FROM usuarios WHERE username = ?');
        $stmt->bind_param("s", $nick); // "s" para cadenas
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
           
            $user = $result->fetch_assoc();
 
                return true;
        }


        $stmt = $mysqli->prepare('SELECT * FROM usuarios WHERE email = ?');
        $stmt->bind_param("s", $email); // "s" para cadenas
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
           
            $user = $result->fetch_assoc();
 
                return true;
        }

        return false;
    }

    function CheckUsername($nick){
        global $mysqli;

        // Consulta preparada
        $stmt = $mysqli->prepare('SELECT * FROM usuarios WHERE username = ?');
        $stmt->bind_param("s", $nick); 

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
           
            $user = $result->fetch_assoc();
 
                return true;
        }

        return false;
    }

     // solo se usa si ya ha sido comprobado el login
     function getUsuarios(){
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT * FROM usuarios");
    

        $stmt->execute();
    
        // Manejar errores de consulta
        if (!$stmt) {
            die("Error al ejecutar la consulta: " . $mysqli->error);
        }
    
        $result = $stmt->get_result();
    
        $usuarios = array();
    
        //ARRAY para las imágenes
        while ($usuario = $result->fetch_assoc()) {
            $usuarios[] = $usuario;
        }
    
        return $usuarios;
    }


     // solo se usa si ya ha sido comprobado el login
     // devuelve solo los nicks de los usuarios
     function getUsuariosNombres(){
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT username FROM usuarios");
    

        $stmt->execute();
    
        // Manejar errores de consulta
        if (!$stmt) {
            die("Error al ejecutar la consulta: " . $mysqli->error);
        }
    
        $result = $stmt->get_result();

        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
        return $usuarios;
    
    }

     // solo se usa si ya ha sido comprobado el login
     // devuelve sus nicks tanto sus permisos
     function getUsuariosNombresPermisos(){
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT username, rol FROM usuarios");
    

        $stmt->execute();
    
        // Manejar errores de consulta
        if (!$stmt) {
            die("Error al ejecutar la consulta: " . $mysqli->error);
        }
    
        $result = $stmt->get_result();

        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
        return $usuarios;
    
    }

    // obtiene cuantos usuarios actualmente tienen los permisos de super
    function getNumeroUsuariosSuper(){
        global $mysqli;
    
        $stmt = $mysqli->prepare("SELECT COUNT(*) as count FROM usuarios WHERE rol = 'super'");
    
        $stmt->execute();
        
        // Manejar errores de consulta
        if (!$stmt) {
            die("Error al ejecutar la consulta: " . $mysqli->error);
        }
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
    
        return $count;
    }
    

    // Obtiene el usuario a partir de su nombre
    function getUsuario($nombre){
        global $mysqli;

        $stmt = $mysqli->prepare('SELECT * FROM usuarios WHERE username = ?');
        $stmt->bind_param("s", $nombre); // "s" para indicar que $nombre es una cadena (VARCHAR)
        $stmt->execute();

        // Manejar errores de consulta
        if ($stmt->error) {
            die("Error al ejecutar la consulta: " . $stmt->error);
        }

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $usuario = $result->fetch_assoc();
            return $usuario;
        } else {
            return null;
        }

        $stmt->close();
    }


    // añade un usuario a la base de datos con la contraseña hasheada
    function añadirusuario($nick,$contraseña,$email,$rol,$nombre){
        global $mysqli;

        $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

        $stmt = $mysqli->prepare("INSERT INTO usuarios (username, password, email, rol, nombre_completo) 
        VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param("sssss", $nick, $contraseña_hash, $email, $rol, $nombre);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        }

        $stmt->close();

    }
    
    // obtiene el email segun el nick
    function getEmailPorUsuario($nick) {
        global $mysqli;
        
        $stmt = $mysqli->prepare("SELECT email FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $nick); 
        $stmt->execute();
       
        $stmt->bind_result($email);
    
        $stmt->fetch();
    
        $stmt->close();
    
        return $email;
    }

    // edita el nombre
    function editarNombre($nick, $nuevonombre){
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $nick);
        $stmt->execute();
        $resultado = $stmt->get_result();
       
        if ($resultado->num_rows === 1) {

            $fila = $resultado->fetch_assoc();
            $idUsuario = $fila['id'];

            $stmt = $mysqli->prepare("UPDATE usuarios SET username = ? WHERE id = $idUsuario");
            $stmt->bind_param("s", $nuevonombre); 
            $stmt->execute();

            if ($stmt->execute()) { 
            } else {
                echo "Error al actualizar el nombre.";
            }
        } else {
            echo "No se encontró ningún usuario con ese nombre de usuario.";
        }
    }

    // editar el nombre completo
    // buscamos con el antiguo nick y ponemos el nuevo
    function editarNombreCompleto($nick, $nuevonombre){
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $nick); 
        $stmt->execute();
        $resultado = $stmt->get_result();
       
        if ($resultado->num_rows === 1) {

            $fila = $resultado->fetch_assoc();
            $idUsuario = $fila['id'];

            $stmt = $mysqli->prepare("UPDATE usuarios SET nombre_completo = ? WHERE id = $idUsuario");
            $stmt->bind_param("s", $nuevonombre); 
            $stmt->execute();

            if ($stmt->execute()) { 
            } else {
                echo "Error al actualizar el nombre.";
            }
        } else {
            echo "No se encontró ningún usuario con ese nombre de usuario.";
        }
    }
    // editar contraseña
    function editarContraseña($nick, $contraseña){
        global $mysqli;

        $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);
        
        $stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $nick); 
        $stmt->execute();
        $resultado = $stmt->get_result();
       
        if ($resultado->num_rows === 1) {

            $fila = $resultado->fetch_assoc();
            $idUsuario = $fila['id'];

            $stmt = $mysqli->prepare("UPDATE usuarios SET password = ? WHERE id = $idUsuario");
            $stmt->bind_param("s", $contraseña_hash); 
            $stmt->execute();

            if ($stmt->execute()) { 
            } else {
                echo "Error al actualizar la contraseña.";
            }
        } else {
            echo "No se encontró ningún usuario con ese nombre de usuario.";
        }
    }

    // editar el email
    function editarEmail($nick, $email){
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $nick); 
        $stmt->execute();
        $resultado = $stmt->get_result();
       
        if ($resultado->num_rows === 1) {

            $fila = $resultado->fetch_assoc();
            $idUsuario = $fila['id'];

            $stmt = $mysqli->prepare("UPDATE usuarios SET email = ? WHERE id = $idUsuario");
            $stmt->bind_param("s", $email); 
            $stmt->execute();


            if ($stmt->execute()) { 
            } else {
                echo "Error al actualizar el email.";
            }
        } else {
            echo "No se encontró ningún usuario con ese nombre de usuario.";
        }
    }

    // edita los permisos de un usuario
    function editarPermisos($nick, $nuevopermiso){
        global $mysqli;
        
        $stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $nick); 
        $stmt->execute();
        $resultado = $stmt->get_result();
       
        if ($resultado->num_rows === 1) {

            $fila = $resultado->fetch_assoc();
            $idUsuario = $fila['id'];

            $stmt = $mysqli->prepare("UPDATE usuarios SET rol = ? WHERE id = $idUsuario");
            $stmt->bind_param("s", $nuevopermiso); 
            $stmt->execute();

            if ($stmt->execute()) { 
            } else {
                echo "Error al actualizar el rol.";
            }
        } else {
            echo "No se encontró ningún usuario con ese nombre de usuario.";
        }
    }
    // editar comentario
    function editarComentario($id, $nuevocomentario){
        global $mysqli;

        $stmt = $mysqli->prepare("UPDATE Comentarios SET comentario = ?, modificado = ? WHERE idComentario = ?");
        $modificado = 1;
        $stmt->bind_param("sii", $nuevocomentario, $modificado, $id);
        
        if ($stmt->execute()) {
            $stmt->close();
            return;
        } else {
            echo "Error al actualizar el comentario: " . $stmt->error;
            $stmt->close();
            return;
        }
    }
    // borrar comentario
    function borrarComentario($id){
        global $mysqli;

        $stmt = $mysqli->prepare("DELETE FROM Comentarios WHERE idComentario = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $stmt->close();
            return;
        } else {
            echo "Error al borrar el comentario: " . $stmt->error;
            $stmt->close();
            return;
        }
    }
    // obtener comentarios
    function getComentarios(){
        global $mysqli;
    
        $stmt = $mysqli->prepare("SELECT * FROM Comentarios");

        $stmt->execute();

        if (!$stmt) {
            die("Error al ejecutar la consulta: " . $mysqli->error);
        }

        $result = $stmt->get_result();
        $comentarios = array();

        while($comentario = $result->fetch_assoc()){
            $comentarios[] = $comentario;
        }

           
        $stmt->close();

        return $comentarios;

    }
    

    // obtiene los nombres de las actividades
    function getActividadesNombres(){
        global $mysqli;
    
        $stmt = $mysqli->prepare("SELECT id,titulo FROM Actividades");

        $stmt->execute();

        if (!$stmt) {
            die("Error al ejecutar la consulta: " . $mysqli->error);
        }

        $result = $stmt->get_result();
        $nombresActividades = array();

        while($actividad = $result->fetch_assoc()){
            $nombresActividades[] = $actividad;
        }

           
        $stmt->close();

        return $nombresActividades;

    }
    
    // modificamos las actividad
    function  modificarActividad($id,$titulo,$precio,$fecha,$duracion,$descripcion){
        global $mysqli;

        $stmt = $mysqli->prepare("UPDATE Actividades SET titulo = ?, precio = ?, fecha = ?, duracion = ?, descripcion = ? WHERE id = ?");
        $modificado = 1;
        $stmt->bind_param("sssssi", $titulo, $precio, $fecha, $duracion, $descripcion,$id);
        
        if ($stmt->execute()) {
            $stmt->close();
            return;
        } else {
            echo "Error al actualizar el comentario: " . $stmt->error;
            $stmt->close();
            return;
        }
    }

    // insertamos la actividad
    function insertarActividad($titulo, $precio, $fecha, $duracion, $descripcion, $ruta, $descripcionImg) {
        global $mysqli;

        $stmt = $mysqli->prepare("INSERT INTO Actividades (titulo, precio, fecha, duracion, descripcion) VALUES (?, ?, ?, ?, ?)");
    
        $stmt->bind_param("sssss", $titulo, $precio, $fecha, $duracion, $descripcion);
    
        if ($stmt->execute()) {
            $inserted_id = $stmt->insert_id; // obtenemos el id insertado

            $principal = 1; // principal = 1 significa que la imagen sera portada

            $stmt = $mysqli->prepare("INSERT INTO imagenes (principal, idActividad, descripcion, urlImagen) VALUES (?, ?, ?, ?)");
            
            $stmt->bind_param("iiss", $principal, $inserted_id, $descripcionImg, $ruta);
            
            if ($stmt->execute()) {
            } else {
                echo "Error al insertar la imagen: " . $stmt->error;
                $stmt->close();
                return;
            }


            return $inserted_id; // Devolver el ID insertado
        } else {
            echo "Error al insertar la actividad: " . $stmt->error;
            $stmt->close();
            return false;
        }
    }

    // borramos actividad
    function borrarActividad($id){
        global $mysqli;
    
        $stmt = $mysqli->prepare("DELETE FROM Comentarios WHERE idActividad = ?");
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            echo "Error al borrar los comentarios: " . $stmt->error;
            $stmt->close();
            return;
        }
        $stmt->close();
 
        $stmt = $mysqli->prepare("DELETE FROM imagenes WHERE idActividad = ?");
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            echo "Error al borrar las imágenes: " . $stmt->error;
            $stmt->close();
            return;
        }
        $stmt->close();
    
        $stmt = $mysqli->prepare("DELETE FROM Actividades WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $stmt->close();
            return;
        } else {
            echo "Error al borrar la actividad: " . $stmt->error;
            $stmt->close();
            return;
        }
    }

    // insertamos imagen    
    function insertarImagen($ruta_destino,$descripcionImagen, $idactividad) {
        global $mysqli;

            $principal = 0;

            $stmt = $mysqli->prepare("INSERT INTO imagenes (principal, idActividad, descripcion, urlImagen) VALUES (?, ?, ?, ?)");
            
            $stmt->bind_param("iiss", $principal, $idactividad, $descripcionImagen, $ruta_destino);
            
            if ($stmt->execute()) {
            } else {
                echo "Error al insertar la imagen: " . $stmt->error;
            }

            $stmt->close();
            return;
            
        }
    

    


  

    
?>