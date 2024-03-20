<!DOCTYPE html>
<html lang="es">
    <head>
        <?php 
            session_start();
            function formatDate($mysqlTimestamp) {
                    // Convierte la fecha MySQL en un objeto DateTime
                    $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $mysqlTimestamp);
            
                    // Formatea la fecha como desees, por ejemplo, en formato "d/m/Y H:i:s"
                    $formattedDate = $dateTime->format('d/m/Y H:i:s');
            
                    return $formattedDate;
                }
            ?>
        <?php include_once 'includes/head.php'; ?>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <?php 
            include_once 'includes/header.php';
            ?>
        <?php 
            $mod = $_REQUEST['mod']??'home';
            
            if($mod=='home'){
                include_once 'views/home.php';
            }else if($mod=='products'){
                include_once 'views/products.php';
            }else if($mod=='whoweare'){
                include_once 'views/whoweare.php';
            }else if($mod=='blog'){
                include_once 'views/blog.php';
            }else if($mod=='gallery'){
                include_once 'views/gallery.php';
            }else if($mod=='contactus'){
                include_once 'views/contactus.php';
            }else if($mod=='finishrequest'){
                include_once 'views/finishrequest.php';
            } else if($mod=='recognitions') {
                include_once 'views/recognitions.php';
            }
            else{
                include_once 'views/404.php';
            }
            ?>
        <?php  
            include_once 'includes/footer.php';
            ?>
        <?php 
            if(isset($_SESSION['error'])){ ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?php echo $_SESSION['error']??''; ?>',
            })
        </script>   
        <?php
            unset($_SESSION['error']);
            }
            ?>
        <?php 
            if(isset($_SESSION['success'])){ ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Perfecto!',
                text: '<?php echo $_SESSION['success']??''; ?>',
            })
        </script>   
        <?php
            unset($_SESSION['success']);
            }
            ?>
    </body>
</html>
