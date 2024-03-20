<?php
$prodId = $_REQUEST['prodId'] ?? '';

if ($prodId != '') {
    include_once '../includes/db.php';

    $prodId = mysqli_real_escape_string($conn, $prodId); // Evitar SQL injection

    $prod = $conn->query("SELECT * FROM products WHERE id='$prodId' LIMIT 1");

    if ($prod && $prod->num_rows > 0) {
        $prod = $prod->fetch_assoc();
        $response = array('success' => true, 'data' => $prod); // No es necesario json_decode aquí
    } else {
        $response = array('success' => false, 'message' => 'No encontramos el producto que buscabas.');
    }
} else {
    $response = array('success' => false, 'message' => 'No encontramos el producto que buscabas.');
}

echo json_encode($response); // Corregido json_encode en lugar de json_decode
?>