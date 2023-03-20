<?php
include_once("db-ecommerce.php");

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['existencia'])) {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $precio = mysqli_real_escape_string($conn, $_POST['precio']);
    $existencia = mysqli_real_escape_string($conn, $_POST['existencia']);

    $query = "INSERT INTO productos (nombre, precio, existencia) VALUES ('$nombre', '$precio', '$existencia')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $response = array(
            'success' => true,
            'message' => 'Producto creado exitosamente'
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Error al crear el producto'
        );
    }

    echo json_encode($response);
}

mysqli_close($conn);

?>