<?php
  require_once "./bd.php";
header('Content-Type: application/json');

if (isset($_GET['titulo'])) {
    $titulo = $_GET['titulo'];
    $titulosActividades = getActividadesNombresSimilitud($titulo); 

    echo json_encode(['results' => $titulosActividades]);
} else {
    echo json_encode(['error' => 'No se proporcionó ningún título']);
}
?>