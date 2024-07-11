<?php
	require_once "/usr/local/lib/php/vendor/autoload.php";
	require_once "./bd.php";
	
	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader);

	session_start();
	
	$actividad = null;
	$imagenes = null;
    $id = $_GET['id'];
	
	if($mysqli != null){
			$actividad = obtenerActividadPorId($id);
			$imagenes = obtenerImagenesId($id);
	}

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

        $id = $_POST["id"];
		$titulo = $_POST["titulo"];
		$precio = $_POST["precio"];
        $fecha = $_POST["fecha"];
        $duracion = $_POST["duracion"];
        $descripcion = $_POST["descripcion"];

        modificarActividad($id,$titulo,$precio,$fecha,$duracion,$descripcion);
        $actividad = obtenerActividadPorId($id);
        header("Location: actividad.php?id=" . $id);
    }

	echo $twig->render('editarActividad.html',['actividad' => $actividad,  'imagenes' => $imagenes, 'logueado' => $logueado, 'username' => $username]);	
?>