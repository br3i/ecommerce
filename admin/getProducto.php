<?php

include_once("db-ecommerce.php");
$id = (int) $_POST['id'];

// Conexión a la base de datos
$con = mysqli_connect($host, $user, $pass, $db);

if (!$con) {
    exit("Error de conexión: " . mysqli_connect_error());
}

$query = "SELECT * FROM productos WHERE id = ?";

$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Verifica si la consulta ha obtenido resultados
if (mysqli_num_rows($result) > 0) {
    // Asigna los valores a variables
    $row = mysqli_fetch_assoc($result);
    $nombre = $row['nombre'];
    $precio = $row['precio'];
    $existencia = $row['existencia'];

    // Crea un objeto JSON con los datos del producto
    $data = array("nombre" => $nombre, "precio" => $precio, "existencia" => $existencia);

    // Imprime el objeto JSON
    echo json_encode($data);
} else {
    // En caso de no obtener resultados, envía un mensaje de error
    echo json_encode(array("error" => "No se encontró el producto"));
}

mysqli_stmt_close($stmt);

?>