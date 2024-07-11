<?php
	require_once "/usr/local/lib/php/vendor/autoload.php";
	require_once "./bd.php";
	
	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader);

	session_start();

	// Inicializar la variable $logueado correctamente
	$logueado = false;
	$username = null;
	$email = null;

	if(isset($_SESSION['username'])){
	  $logueado = true;
	  $username = $_SESSION['username'];
	  $rol = $_SESSION['rol'];
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$titulo = $_POST["titulo"];
		$precio = $_POST["precio"];
        $fecha = $_POST["fecha"];
        $duracion = $_POST["duracion"];
        $descripcion = $_POST["descripcion"];
        $descripcionActividad = $_POST["descripcionImg"];

        // Directorio donde se almacenarán las imágenes
        $directorio_destino = "ImagenesActividades/";
    
        // Ruta temporal del archivo subido al metodo post
        $archivo_temporal = $_FILES["imagen"]["tmp_name"];
            
        // Nombre del archivo subido 
        $nombre_archivo = basename($_FILES["imagen"]["name"]);
        
        // Mover el archivo subido al directorio destino
        $ruta_destino = $directorio_destino . $nombre_archivo;
        move_uploaded_file($archivo_temporal, $ruta_destino);

        $id = insertarActividad($titulo,$precio,$fecha,$duracion,$descripcion, $ruta_destino,$descripcionActividad);
        $actividad = obtenerActividadPorId($id);
        header("Location: actividad.php?id=" . $id);
    }

	echo $twig->render('AñadirActividad.html',['logueado' => $logueado, 'username' => $username]);	
?>