<?php
include_once("db-ecommerce.php");

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['existencia'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $precio = mysqli_real_escape_string($conn, $_POST['precio']);
    $existencia = mysqli_real_escape_string($conn, $_POST['existencia']);

    $query = "UPDATE productos SET nombre = '$nombre', precio = '$precio', existencia = '$existencia' WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $response = array(
            'success' => true,
            'message' => 'Producto actualizado exitosamente'
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Error al actualizar el producto'
        );
    }

    echo json_encode($response);
}

mysqli_close($conn);

?>