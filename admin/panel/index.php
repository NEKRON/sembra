
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sembra | Admin Dashboard</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets/css/style.css">
    <?php 
    session_start();
    if(!(isset($_SESSION['id']))){
        header('location:../');
    }

    $mod = $_REQUEST['mod']??'panel';
    include_once '../includes/db.php';
    ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="
https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.min.css
" rel="stylesheet">
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container" style="max-width:none !important;">
        <div class="navigation">
            <ul>
                <li>
                    <a href="../../">
                        <span class="icon">
                            <img src="../../assets/img/logo.png" style="width: 60px;object-fit: cover;" alt="">
                        </span>
                        <span class="title">Sembra App</span>
                    </a>
                </li>

                <li>
                    <a href="?mod=panel">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Panel de Control</span>
                    </a>
                </li>

                <li>
                    <a href="?mod=products">
                        <span class="icon">
                            <ion-icon name="bag-outline"></ion-icon>
                        </span>
                        <span class="title">Productos</span>
                    </a>
                </li>

                <li>
                    <a href="?mod=orders">
                        <span class="icon">
                            <ion-icon name="folder-outline"></ion-icon>
                        </span>
                        <span class="title">Pedidos</span>
                    </a>
                </li>

                <li>
                    <a href="?mod=clients">
                        <span class="icon" style="display:flex;justify-content:center;align-items:center;">
                            <i class="ri-account-box-line" style="font-size:26px;"></i>
                        </span>
                        <span class="title">Clientes</span>
                    </a>
                </li>

                <!-- <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="cart-outline"></ion-icon>
                        </span>
                        <span class="title">Nuevas Ventas</span>
                    </a>
                </li> -->

                <li>
                    <a href="../../">
                        <span class="icon">
                            <ion-icon name="home"></ion-icon>
                        </span>
                        <span class="title">Volver al sitio</span>
                    </a>
                </li>

                <li>
                    <a href="../components/logout.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Cerrar Sesión</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div>
            </div>
            <!-- ========================= Main ==================== -->
            <?php 
            function formatDate($mysqlTimestamp) {
                // Convierte la fecha MySQL en un objeto DateTime
                $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $mysqlTimestamp);

                // Formatea la fecha como desees, por ejemplo, en formato "d/m/Y H:i:s"
                $formattedDate = $dateTime->format('d/m/Y H:i:s');

                return $formattedDate;
            }


            if($mod=='panel'){
                include_once './modules/panel.php';
            }else if($mod=='products'){
                include_once './modules/products.php';
            }else if($mod=='detailsOrder'){
                include_once './modules/detailsOrder.php';
            }else if($mod=='newproduct'){
                include_once './modules/newproduct.php';
            }else if($mod=="orders"){
                include_once './modules/orders.php';
            }else if($mod=="clients"){
                include_once './modules/clients.php';
            }
            ?>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

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