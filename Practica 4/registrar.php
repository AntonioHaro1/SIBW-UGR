<?php
	require_once "/usr/local/lib/php/vendor/autoload.php";
	require_once "./bd.php";
	
	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader);
	

	// Recibe los datos del formulario
	$nombre = null;
	$contraseña = null;
	$nick = null;
	$email = null;
	$rol = null;
	

	if($mysqli != null){
		$PalabrasProhibidas = obtenerPalabrasProhibidas();
		$CorreosPosibles = obtenerCorreosPosibles();
		$usuarios = getUsuariosNombres(); 
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		// Recibe los datos del formulario
		$nombre = $_POST["nombre"];
        $contraseña = $_POST["password"];
		$nick = $_POST["username"];
		$email = $_POST["correo"];
		$rol = "usuario";

		session_start();
		$_SESSION['username'] = $nick;
		$_SESSION['rol'] = $rol;
		añadirusuario($nick,$contraseña,$email,$rol,$nombre);
		header("Location: index.php");
		/*
		if(!CheckUsernameEmail($nick,$email)){
			session_start();
			$_SESSION['username'] = $nick;
			$_SESSION['rol'] = $rol;
			añadirusuario($nick,$contraseña,$email,$rol,$nombre);

    	} else {
        // Mostrar ventana emergente con mensaje
		echo "<script>alert('El nombre de usuario \"$nick\" o el correo \"$email\" ya está en uso. Por favor, elige otro.');</script>";
		}
		*/
	}

	echo $twig->render('registrar.html', ['palabrasprohibidas' => $PalabrasProhibidas, 'correosposibles' => $CorreosPosibles, 'usuarios' => $usuarios]);	
?>