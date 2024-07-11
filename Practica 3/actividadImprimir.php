<?php
	require_once "/usr/local/lib/php/vendor/autoload.php";
	require_once "./bd.php";
	
	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader);
	
	$actividad = null;
	$anuncios = null;
	$imagenes = null;
	$comentarios = null;
	$PalabrasProhibidas = null;

    $id = $_GET['id'];

  	$mysqli = obtenerConexionBD();

	if($mysqli != null){
		$actividad = obtenerActividadPorId( $id);
	}else{
		echo "No se pudo conectar con la base de datos";
	}

	echo $twig->render('actividad_imprimir.html',['actividad' => $actividad]);	
?>