<?php
	require_once "/usr/local/lib/php/vendor/autoload.php";
	require_once "./bd.php";
	
	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader);

	session_start();
	
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

	// Inicializar la variable $logueado correctamente
	$logueado = false;
	$username = null;
	$email = null;
	$rol = null;

	if(isset($_SESSION['username'])){
	  $logueado = true;
	  $username = $_SESSION['username'];
	  $rol = $_SESSION['rol'];
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_POST['opcion'])){
			switch($_POST['opcion']){
				case 'AgregarComentarios':
					$id = $_POST["id"];
					$nick = $_SESSION['username'];
					$comentario = $_POST["nuevoComentario"];
					$email = getEmailPorUsuario($nick);
					$fechaActual = date('Y-m-d');	
					$horaActual = date('H:i:s');
					
					insertarComentario($nick,$email,$fechaActual,$horaActual,$comentario,$id);
					break;
				case 'modificarcomentario':
					$id = $_POST["idcomentario"];
					$idactividad = $_GET['id'];
					$comentariomodificado = $_POST["nuevoComentariomodificado"];

					editarComentario($id,$comentariomodificado);
					$comentarios = obtenerComentariosId($idactividad);
					
					break;
				case 'borrarcomentario':
					$id = $_POST["idcomentario"];
					$idactividad = $_GET['id'];

					borrarComentario($id);
					$comentarios = obtenerComentariosId($idactividad);
					
				break;
				case 'BorrarActividad':
					$id = $_POST['idActividad'];

					borrarActividad($id);
					header("Location: index.php");
				break;
				case 'añadirImagen':
					$idactividad = $_GET['id'];
					$descripcionImagen = $_POST["descripcion"];
					// Directorio donde se almacenarán las imágenes
					$directorio_destino = "ImagenesActividades/";
    
					// Ruta temporal del archivo subido
					$archivo_temporal = $_FILES["imagen"]["tmp_name"];
								
					// Nombre del archivo subido al metodo post
					$nombre_archivo = basename($_FILES["imagen"]["name"]);
							
					// Mover el archivo subido al directorio destino 
					$ruta_destino = $directorio_destino . $nombre_archivo;
					move_uploaded_file($archivo_temporal, $ruta_destino);

					insertarImagen($ruta_destino,$descripcionImagen, $idactividad);
					header("Location: actividad.php?id=" . $id);
					
				break;
			}
		}	
	}

	echo $twig->render('actividad.html',['actividad' => $actividad, 'anuncios' => $anuncios, 'imagenes' => $imagenes, 'comentarios' => $comentarios, 'palabrasprohibidas' => $PalabrasProhibidas, 'correosposibles' => $CorreosPosibles, 'username' => $username, 'logueado' => $logueado, 'rol' => $rol]);	
?>