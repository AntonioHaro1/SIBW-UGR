<?php
    session_start();    
	require_once "/usr/local/lib/php/vendor/autoload.php";
	require_once "./bd.php";
	
	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader);

    	
    $login = false;

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		// Recibe los datos del formulario
		$username = $_POST["username"];
		$contraseña = $_POST["password"];
        $rol = [];
        
        if(checkLogin($username,$contraseña)){

            $_SESSION['username'] = $username;
            $usuario = getUsuario($username);
            if($usuario){
                $_SESSION['rol'] = $usuario['rol'];

                header("Location: index.php");
                exit;
            }
        }else{
            echo "<script>
        alert('Usuario/Contraseña incorrecta');
            </script>";

    


        }

	}
	echo $twig->render('login.html', ['login' => $login] );	
?>