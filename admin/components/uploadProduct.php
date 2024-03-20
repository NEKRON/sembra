<?php 
session_start();

if(isset($_SESSION['id'])){
    include_once '../includes/db.php';

    if(isset($_POST['nombre']) && isset($_POST['codigo']) && isset($_POST['tipo']) &&
       isset($_POST['stock']) && isset($_POST['precio']) && isset($_FILES['foto']) ){

        $nombre = $_POST['nombre'];
        $codigo = $_POST['codigo'];
        $tipo = $_POST['tipo'];
        $tags = $_POST['tags']??'';
        $medidas = $_POST['medidas']??'';
        $descripcion = $_POST['descripcion']??'';
        $stock = $_POST['stock'];
        $precio = $_POST['precio'];

        // Subir la foto
        if($_FILES['foto']['error'] === 0){
            $nombreOriginal = $_FILES['foto']['name'];
            $horaActual = time();
            $nombreUnico = $horaActual . '_' . $nombreOriginal;
            $rutaDestino = '../../assets/img/products/' . utf8_encode(utf8_decode($nombreUnico));

            if(move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)){
                // Insertar los datos en la base de datos
                $query = "INSERT INTO products (name, cod, type, tags, medidas, description, stock, price, photo) 
                          VALUES ('$nombre', '$codigo', '$tipo', '$tags', '$medidas', '$descripcion', '$stock', '$precio', '$nombreUnico')";
                $result = $conn->query($query);

                if($result){
                	$_SESSION['success'] = 'Se subió el nuevo producto correctamente.';
                	header('location:../panel/?mod=products');
                } else {
                	$_SESSION['error'] = 'Hubo un error al insertar el producto en la base de datos.';
                	header('location:../panel/?mod=newproduct');
                }
            } else {
            	$_SESSION['error'] = 'Error al subir la foto.';
            	header('location:../panel/?mod=newproduct');
            }
        } else {
        	$_SESSION['error'] = 'Error al subir la foto.';
        	header('location:../panel/?mod=newproduct');
        }
    } else {
    	$_SESSION['error'] = 'Faltan campos en el formulario.';
    	header('location:../panel/?mod=newproduct');
    }
} else {
    die();
}
?>




