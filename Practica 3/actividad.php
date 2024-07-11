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
	$CorreosPosibles = null;

    $id = $_GET['id'];


	if($mysqli != null){
			$actividad = obtenerActividadPorId($id);
			$imagenes = obtenerImagenesId($id);
			$comentarios = obtenerComentariosId($id);
			$PalabrasProhibidas = obtenerPalabrasProhibidas();
			$CorreosPosibles = obtenerCorreosPosibles();
			
			$anuncios = obtenerAnunciosAleatorios(3);	
	}



	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		// Recibe los datos del formulario
		$id = $_POST["id"];
		$nombre = $_POST["nombre"];
		$comentario = $_POST["nuevoComentario"];
		$email = $_POST["email"];
		$fechaActual = date('Y-m-d');	
		$horaActual = date('H:i:s');
		
		insertarComentario($nombre,$email,$fechaActual,$horaActual,$comentario,$id);
	}

	echo $twig->render('actividad.html',['actividad' => $actividad, 'anuncios' => $anuncios, 'imagenes' => $imagenes, 'comentarios' => $comentarios, 'palabrasprohibidas' => $PalabrasProhibidas, 'correosposibles' => $CorreosPosibles]);	
?>