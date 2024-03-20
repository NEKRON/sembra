<?php 
session_start();

if(isset($_SESSION['id'])){
    include_once '../includes/db.php';

    if(isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['comment'])){

        $name = $_POST['name']??'';
        $lastname = $_POST['lastname']??'';
        $email = $_POST['email']??'';
        $comment = $_POST['comment']??'';
                // Insertar los datos en la base de datos
        $query = "INSERT INTO opinions (name, lastname, email, comment) 
        VALUES ('$name', '$lastname', '$email', '$comment')";
        $result = $conn->query($query);

        if($result){
         $_SESSION['success'] = 'Recibimos tu opinion correctamente, gracias!';
         header('location:../../?mod=opinions');
     } else {
         $_SESSION['error'] = 'Hubo un error al intentar subir tu opinion, intentalo denuevo más tarde.';
         header('location:../../?mod=opinions');
     }
 } else {
     $_SESSION['error'] = 'Faltan campos en el formulario.';
     header('location:../../?mod=opinions');
 }
} else {
    die();
}
?>




