<?php
include_once("db-ecommerce.php");

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $query = "DELETE FROM productos WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $response = array(
            'success' => true,
            'message' => 'Producto eliminado exitosamente'
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Error al eliminar el producto'
        );
    }

    echo json_encode($response);
}

mysqli_close($conn);

?>