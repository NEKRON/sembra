<?php 
    include_once 'admin/includes/db.php';
    $myprods = $conn->query("SELECT * from products order by id desc");
    if($myprods->num_rows > 0){
        $myprods = $myprods->fetch_all(MYSQLI_ASSOC); // Obtén todos los resultados en un array asociativo
    }else{
        $myprods = []; // Inicializa un array vacío si no hay resultados
    }
    ?>
<div class="products__container">
    <div class="products__banner whoweare-banner">
        <img src="assets/img/comprar.webp" alt="">
        <div class="whoweare__banner--content" style="justify-content: center; text-align: center;align-items: center;display:flex;
            flex-direction: column;
            ">
            <h1 class="titulos texto-blanco">Mi Pedido</h1>
        </div>
    </div>
    <div class="recognitions__container">
        <div class="recognitions">
            <h2 class="recognitions__title subtitulos">Productos agregados...</h2>
            <div class="product__list">
            </div>
            <div class="total__payment">
                <div class="payment__amount">
                    <p>Total</p>
                    <span class="totalAmount">0€ EUR</span>
                </div>
                <a href="?mod=finishrequest" class="payment__process btn">Confirmar</a>
            </div>
        </div>
    </div>
</div>

<section class="contacto">
    <img src="assets/img/granos.png" class="contact__side--img position-left" alt="">
    <img src="assets/img/granos.png" class="contact__side--img position-right" alt="">
    <h1 class="titulos">Contactanos</h1>
    <p class="contacto__subtitle">¡Te invitamos a ponerte en contacto con nosotros! Estamos aquí para responder a tus preguntas, ayudarte con tus pedidos y escuchar tus comentarios. <br> <br> Tu opinión es importante para nosotros.</p>
    <ul class="contacto__contact--menu">
        <li>
            <a href="https://www.instagram.com/sembra.biojoyas/" class="color-gold menu-text"><i class="fa-brands fa-instagram"></i> <span>@sembra.biojoyas</span>
            </a>
        </li>
        <li>
            <a href="mailto:silvia@sembrabiojoyas.es" class="color-green menu-text"><i class="fa-solid fa-envelope"></i> <span>administracion@sembrabiojoyas.es</span>
            </a>
        </li>
        <li>
            <a href="https://api.whatsapp.com/send?phone=34680997179" target="_blank" class="color-brown menu-text"><i class="fa-brands fa-whatsapp"></i> <span>+34 680 997 179</span>
            </a>
        </li>
    </ul>
    <div class="btn-container">
        <a href="?mod=contactus" class="boton-formulario__verde">Envía tus comentarios</a>
    </div>
</section>

<script>
    const cartElementsJSON = localStorage.getItem('cartElements');
    const cartElements = JSON.parse(cartElementsJSON) || {};

    if(Object.keys(cartElements).length){
        const products = <?php echo json_encode($myprods); ?>;
        
        const selectedProducts = products.map(product => {
            const productId = product.id;
            
            // Verifica si el producto está en el carrito
            if (cartElements[productId]) {
                // Agrega una propiedad 'selected' al producto para indicar que está seleccionado
                product.selected = true;
            } else {
                // Si el producto no está en el carrito, establece 'selected' en false
                product.selected = false;
            }
            
            return product;
            });
        
        const totalAmountElement = document.querySelector('.totalAmount');
        let totalAmount = 0;
        const productContainer = document.querySelector('.product__list');
        
        // Recorre los productos seleccionados y crea el HTML para cada uno
        selectedProducts.forEach(product => {
        const quantityInCart = cartElements[product.id] || 0; // Obtiene la cantidad del carrito desde 'cartElements' usando la ID del producto
        totalAmount += product.price * quantityInCart;
        
        if(quantityInCart>0){
            const productElement = document.createElement('div');
            productElement.classList.add('product');
        
            const productInfo = document.createElement('div');
            productInfo.classList.add('product__first--info');
        
            const productImage = document.createElement('img');
            productImage.classList.add('product__img');
            productImage.src = 'assets/img/products/' + product.photo; // Asume que tienes la ruta de la imagen en la propiedad 'image' del producto
        
            const productDetails = document.createElement('div');
            productDetails.classList.add('product__details');
        
            const productName = document.createElement('h4');
            productName.textContent = product.name; // Asume que tienes el nombre del producto en la propiedad 'name' del producto
        
            const productInfoText = document.createElement('p');
            productInfoText.classList.add('product__details--info');
            productInfoText.textContent = 'Medida: ' + ((product.medida)?product.medida:''); // Asume que tienes la medida en la propiedad 'medida' del producto
        
            const productQuantity = document.createElement('span');
            productQuantity.classList.add('product__details--span');
            productQuantity.textContent = 'Cantidad: ' + cartElements[product.id]; // Obtén la cantidad del carrito desde 'cartElements' usando la ID del producto
        
            productDetails.appendChild(productName);
            productDetails.appendChild(productInfoText);
            productDetails.appendChild(productQuantity);
        
            productInfo.appendChild(productImage);
            productInfo.appendChild(productDetails);
        
            const productPrice = document.createElement('div');
            productPrice.classList.add('product__last--info');
        
            const productPriceSpan = document.createElement('span');
            productPriceSpan.classList.add('product__price');
            productPriceSpan.textContent = product.price + '€'; // Asume que tienes el precio en la propiedad 'price' del producto
        
            const productDelete = document.createElement('span');
            productDelete.classList.add('product__delete');
            productDelete.innerHTML = '<i class="ri-close-line"></i>';
        
            // Agrega un evento clic al botón "Eliminar"
            productDelete.addEventListener('click', () => {
                // Elimina el div padre del botón "Eliminar"
                productContainer.removeChild(productElement);
        
                // Elimina el elemento del carrito (cartElements) usando la ID del producto
                const productId = product.id;
                delete cartElements[productId];
        
                // Actualiza la cantidad total
                totalAmount = 0;
                selectedProducts.forEach(selectedProduct => {
                    totalAmount += cartElements[selectedProduct.id] || 0;
                });
                totalAmountElement.textContent = totalAmount;
        
                // Guarda los cambios en localStorage
                localStorage.setItem('cartElements', JSON.stringify(cartElements));
            });
        
            productPrice.appendChild(productPriceSpan);
            productPrice.appendChild(productDelete);
        
            productPrice.appendChild(productPriceSpan);
            productPrice.appendChild(productDelete);
        
            productElement.appendChild(productInfo);
            productElement.appendChild(productPrice);
        
            productContainer.appendChild(productElement);
        }
            
        });
        const formattedTotalAmount = totalAmount.toFixed(2); // Ejemplo: dos decimales
        totalAmountElement.textContent = formattedTotalAmount + '€' + ' EUR';   
    }else{
      Swal.fire({
        icon: 'error',
        title: 'Ups!',
        text: 'Lo sentimos, no hay pedidos en tu carrito. una vez los agregues podrás acceder aquí.'
      }).then(()=>{
        window.location.href="?";
      });
    }

</script>
