<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once "./bd.php";

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  $actividades = obtenerActividades();
  $imagenes = obtenerImagenes();
  $anuncios = obtenerAnunciosAleatorios(3);


  if ($actividades === null) {
    $actividades = array();
  }

  if ($imagenes === null) {
    $imagenes = array();
  }

  if ($anuncios === null) {
    $anuncios = array();
  }

  session_start();

  if(isset($_SESSION['username'])){
    $logueado = true;
    $username = $_SESSION['username'];
    $rol = $_SESSION['rol'];
  }else{
    $logueado = false;
    $username = [];
    $rol = [];
  }


  echo $twig->render('portada.html', ['actividades' => $actividades, 'imagenes' => $imagenes, 'anuncios' => $anuncios, 'logueado' => $logueado, 'username' => $username, 'rol' => $rol]);
?>
