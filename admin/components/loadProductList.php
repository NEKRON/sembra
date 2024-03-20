<?php
// Recupera los datos de carrito de la solicitud POST
$cartElementsJSON = $_POST['cartElements'];
$cartElements = json_decode($cartElementsJSON, true);

if ($cartElements && is_array($cartElements)) {
    // Incluye el archivo de configuración de la base de datos (asegúrate de que esto sea correcto)
    include_once '../includes/db.php';

    // Realiza una consulta SQL para seleccionar todos los productos
    $query = "SELECT * FROM products";
    $result = $conn->query($query);

    if ($result) {
        $products = array(); // Crear un array para almacenar los datos de los productos

        while ($row = $result->fetch_assoc()) {
            $products[] = $row; // Agregar cada producto al array de productos
        }

        // Devuelve los productos como una respuesta JSON al frontend
        $response = array('success' => true, 'products' => $products);
        echo json_encode($response);
    } else {
        // Manejar errores si la consulta SQL falla
        $response = array('success' => false, 'message' => 'Error en la consulta SQL: ' . $conn->error);
        echo json_encode($response);
    }

    // Cierra la conexión a la base de datos
    $conn->close();
} else {
    $response = array('success' => false, 'message' => 'No se encontraron datos de carrito válidos');
    echo json_encode($response);
}
?>