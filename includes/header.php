<?php 
    $mod = $_REQUEST['mod']??'home';
    ?>
<header class="">
    <div class="container">
        <nav class="navegacion">
            <div class="content-logo">
                <a href="?"><img class="logo" src="assets/img/logo.webp" alt="Logo sembra"></a>
                <button id="toggleButton" class="boton-bars"><i class="fa-solid fa-bars"></i></button>
            </div>
            <div id="menu" class="menu hide">
                <a href="?mod=home" class="<?php echo ($mod=='home')?'active':''; ?>">Inicio</a>
                <a href="?mod=whoweare" class="<?php echo ($mod=='whoweare')?'active':''; ?>">Quienes somos</a>
                <!-- <a href="?mod=products" class="<?php echo ($mod=='products')?'active':''; ?>">Productos</a></li> -->
                <a href="?mod=gallery" class="<?php echo ($mod=='gallery')?'active':''; ?>">Productos</a>
                <a href="?mod=blog" class="<?php echo ($mod=='blog')?'active':''; ?>">Blog</a>
                <a href="?mod=recognitions" class="compras-cart">
                <span class="cartCounter">1</span>
                <i class="fa-solid fa-cart-shopping carrito-compras__blanco"></i></a>
                <a class="boton-menu" href="?mod=contactus">Contactanos</a>
            </div>
        </nav>
    </div>
</header>
<script src="assets/js/menu.js"></script>
<script>
    const cartCounter = document.querySelector('.cartCounter');
    
    // Verifica cuántos items hay en el carrito en localStorage
    const cart = JSON.parse(localStorage.getItem('cartElements')) || {};
    
    // Calcula la cantidad total de elementos en el carrito
    let totalItems = 0;
    for (const key in cart) {
        totalItems += cart[key];
    }
    
    if(totalItems>0){
        // Actualiza el contenido de cartCounter con la cantidad y cambia su estilo
        cartCounter.innerHTML = totalItems;
        cartCounter.style.display = 'flex';
    }else{
        cartCounter.innerHTML = totalItems;
    }
        
</script>
