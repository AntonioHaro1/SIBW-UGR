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
        $stmt = $mysqli->prepare("SELECT * FROM Actividades WHERE idActividad = ?");
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
        } else {
            // La consulta no devolvió resultados
            return null;
        }

        // Cerrar la sentencia preparada
        $stmt->close();

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

        return $actividadades;
    
    }

    function obtenerImagenes() {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT * FROM Imagenes");
    

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
    
        return $imagenes;
    }
    



    function obtenerImagenesId($id) {
        global $mysqli;

        $stmt = $mysqli->prepare("SELECT * FROM Imagenes WHERE idActividad = ?");
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
    
        return $Comentarios;
    }
    

    function insertarComentario($nombre, $email, $fechaActual, $horaActual, $comentario, $id) {
        global $mysqli;

        $stmt = $mysqli->prepare("INSERT INTO Comentarios (idActividad, nombre, fecha, hora, comentario, email) VALUES (?, ?, ?, ?, ?, ?)");
    
        $stmt->bind_param("isssss", $id, $nombre, $fechaActual, $horaActual, $comentario, $email);
    
        if ($stmt->execute()) {
            header("Location: actividad.php?id=" . $id);
            exit();
        } else {
            echo "Error al agregar el comentario: " . $stmt->error;
        }
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
    
        return $PalabraProhibidas;
    }
    
    
    function obtenerCorreosPosibles(){
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT * FROM TerminacionesCorreo");

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

    
        return $CorreosPosibles;   
    }
    
?>