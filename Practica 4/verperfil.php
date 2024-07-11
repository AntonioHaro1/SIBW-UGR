<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once "./bd.php";

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  session_start();

  if(isset($_SESSION['username'])){
    $logueado = true;
    $username = $_SESSION['username'];
    $permiso =  $_SESSION['rol'];
    $usuario = getUsuario($username);
    $supers = getNumeroUsuariosSuper();

  }else{
    $logueado = false;
    $username = [];
    $permiso = [];
  }


	if($mysqli != null){
    $PalabrasProhibidas = obtenerPalabrasProhibidas();
    $CorreosPosibles = obtenerCorreosPosibles();
    $usuarios = getUsuariosNombres(); 
    $permisos = getUsuariosNombresPermisos();
    $comentarios = getComentarios();
    $nombresActividades = getActividadesNombres();
    $actividades = obtenerActividades();
 
}


  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['opcion'])) {
        switch($_POST['opcion']) {
            case 'nombrecompleto':
                $nick = $_SESSION['username'];
                $nuevonombre = $_POST['nombre'];
                editarNombreCompleto($nick,$nuevonombre);
                
                $usuario = getUsuario($username);
                break;
            case 'nombreusuario':
              $nick = $_SESSION['username'];
              $nuevonombre = $_POST['usuario'];
              
              editarNombre($nick,$nuevonombre);
                
              $_SESSION['username'] = $nuevonombre;
              $username = $_SESSION['username'];
              $permiso =  $_SESSION['rol'];
              $usuario = getUsuario($username);
              $usuarios = getUsuariosNombres();
              
                break;
            case 'contrasea':
              $nick = $_SESSION['username'];
              $contraseña = $_POST['contrasea'];
              
              editarContraseña($nick,$contraseña);
                
                $usuario = getUsuario($username);
                break;
            case 'email':
              $nick = $_SESSION['username'];
              $email = $_POST['email'];
              
              editarEmail($nick,$email);
                
                $usuario = getUsuario($username);
              break;
              case 'permiso':
                $nuevopermiso = $_POST['rolSeleccionado'];
                $nick = $_POST['nick'];

                if($nick == $_SESSION['username']){
                  $_SESSION['rol'] = $nuevopermiso;
                  $permiso =  $_SESSION['rol'];
                }




                editarPermisos($nick,$nuevopermiso);

                $permisos = getUsuariosNombresPermisos();                
                $supers = getNumeroUsuariosSuper();
                break;

        }
    }
  }

  echo $twig->render('ver_perfil.html', ['logueado' => $logueado, 'username' => $username, 'rol' => $permiso, 'usuario' => $usuario,'palabrasprohibidas' => $PalabrasProhibidas, 'correosposibles' => $CorreosPosibles, 'usuarios' => $usuarios, 'permisos' => $permisos, 'supers' => $supers, 'comentarios' => $comentarios, 'nombresActividades' => $nombresActividades, 'actividades' => $actividades]);
?>
