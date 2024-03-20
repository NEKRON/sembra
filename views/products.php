<?php 
    include_once 'admin/includes/db.php';
    
    $productsByType = [
    	"Anillos" => [],
    	"Pulsera" => [],
    	"Collares" => [],
    	"Pendientes" => []
    ];
    
    $products = $conn->query("SELECT * FROM products ORDER BY id DESC");
    
    if ($products->num_rows > 0) {
    	while ($product = $products->fetch_assoc()) {
    		$type = $product['type'];
    		$productsByType[$type][] = $product;
    	}
    
    	$anillos = $productsByType["Anillos"]??[];
    	$pulseras = $productsByType["Pulseras"]??[];
    	$collares = $productsByType["Collares"]??[];
    	$pendientes = $productsByType["Pendientes"]??[];
    } else {
    	$anillos = [];
    	$pulseras = [];
    	$collares = [];
    	$pendientes = [];
    }
    ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glider-js/1.7.8/glider.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/glider-js/1.7.8/glider.min.js"></script>
<div class="loader">
    <div class="lds-dual-ring"></div>
</div>
<div class="modal">
    <div class="closeModal"></div>
    <div class="modalContent">
        <div class="modalContent__header" style="display: flex; justify-content: center">
            <img src="" alt="" class="modalContent__element--img productIMG">
        </div>
        <div class="modalContent__cont">
            <div class="modal-division__description">
                <i class="ri-close-line closeModalBtn"></i>
            </div>
            <div class="detallesMovimiento">
                <div class="modalContent__description--element">
                    <div class="content-cod-name">
                        <a class="mas-info texto-dorado">Ver mas</a>
                        <h2 class="productName" style="margin:0;">Nombre del producto</h2>
                        <h4 class="productTags" style="margin:0">Tags del producto</h4>
                        <span class="productCod">COD</span>
                    </div>
                    <h3 class="medidas">Medidas: </h3>
                    <h3 class="this__element--title">Descripción: </h3>
                    <p class="this__element--description productDescription" style="font-size: 18px; font-weight: normal"></p>
                    <div class="upBtn">
                        <h4>Cantidad</h4>
                        <span class="downBtn-icon" onclick="downCant()">-</span>
                        <span class="productCant">1</span>
                        <span class="upBtn-icon" onclick="upCant()">+</span>
                    </div>
                </div>
                <!-- <div class="modalContent__img--container"> 	
                    <img src="assets/img/anillo5.jpg" alt="" class="modalContent__element--img">
                    </div> -->
                <div class="modalContent__footer">
                    <div class="price">
                        <p style="color:#fff;">Total: </p>
                        <p style="   font-size:30px; color:var(--verdePrincipal); font-weight: 700;"><span class="productPrice">0 </span>€</p>
                    </div>
                    <button class="btn btn-buynow addToCart">Agregar al carrito</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="products__container">
    <div class="products__banner" style="flex-direction: column;">
        <img src="assets/img/bannerNuestrasJoyas.webp" alt="">
        <h1 class="titulos">Nuestras Joyas</h1>
        <p class="p-productos">Cada una de nuestras biojoyas son como nuestros clientes, únicos. <br> Nuestras piezas están elaboradas de manera artesanal con elementos de la naturaleza de temporada. Así que antes de efectuar tu compra, nosotros te confirmaremos disponibilidad de productos.</p>
    </div>
    <div class="products__content">
        <div class="products__content--item bordes-totales">
            <img src="assets/img/anillos.webp" class="item--img">
            <div class="item__hide">
                <h2 class="item__hide--text">
                    Anillos
                </h2>
                <a class="btn btn-primary" href="#banner-anillos">Ver más</a>
            </div>
        </div>
        <div class="products__content--item bordes-totales">
            <img src="assets/img/pulsera3.webp" class="item--img">
            <div class="item__hide">
                <h2 class="item__hide--text">
                    Pulseras
                </h2>
                <a class="btn btn-secondary" href="#banner-pulseras">Ver más</a>
            </div>
        </div>
        <div class="products__content--item bordes-totales">
            <img src="assets/img/collar.webp" class="item--img">
            <div class="item__hide">
                <h2 class="item__hide--text">
                    Collares
                </h2>
                <a class="btn btn-danger" href="#banner-collares">Ver más</a>
            </div>
        </div>
        <div class="products__content--item bordes-totales">
            <img src="assets/img/pendientes.webp" class="item--img">
            <div class="item__hide">
                <h2 class="item__hide--text">
                    Pendientes
                </h2>
                <a class="btn btn-gray" href="#banner-pendientes">Ver más</a>
            </div>
        </div>
    </div>
    <div class="products__view" id="banner-anillos">
        <h2 class="titulos verde no-center texto-verde">Anillos...</h2>
        <!-- <div class="products__view--sliders">
            <div class="slider__double">
            
            	<div class="slider__items">
            		<div class="slider__items--item">
            			<img src="assets/img/anillos.jpg" />
            			<div class="slider__item--info">
            				<h4>Anillo Cebreado</h4>
            				<a href="#" class="btn btn-primary text-green">Ver más</a>
            			</div>
            		</div>
            		<div class="slider__items--item">
            			<img src="assets/img/anillo1.jpg" />
            			<div class="slider__item--info">
            				<h4>Anillo Cebreado</h4>
            				<a href="#" class="btn btn-primary text-green">Ver más</a>
            			</div>
            		</div>
            	</div>
            </div>
            
            <div class="banner__slider" style="min-height: 350px;">
            	<img src="assets/img/collar2.jpg" class="banner__slider--img" />
            	<div class="banner__slider--info">
            		<h3 class="banner__slider--title">30% de descuento en:</h3>
            		<p>Collares y pendientes</p>
            		<a href="#" class="btn btn-primary text-green">Ver productos</a>
            	</div>
            </div>
            </div> -->
        <?php 
            if(count($anillos)>0){ ?>
        <div class="products__big--slider">
            <i class="ri-arrow-right-line slider__controller glider1-arrow-right"></i>
            <i class="ri-arrow-left-line slider__controller glider1-arrow-left"></i>
            <div class="slider" id="glider1">
                <?php 
                    foreach ($anillos as $key => $value) { ?>
                <div class="slider__item" style="cursor: pointer !important;" onclick="viewProduct(<?php echo $value['id']; ?>)">
                    <?php 
                        $img = utf8_encode(utf8_decode($value['photo'])); 
                        ?>
                    <img class="slider__item--img" src="assets/img/products/<?php echo $img; ?>" />
                    <div class="slider__item--info">
                        <h4 style="font-weight: 600; text-align: center; font-size: 1.3rem; padding: 0 2rem"><?php echo $value['name']??''; ?></h4>
                        <!-- <a href="javascript:;" class="btn btn-primary text-green" onclick="viewProduct(<?php echo $value['id']; ?>)">Ver más</a> -->
                    </div>
                </div>
                <?php	}
                    ?>
            </div>
        </div>
        <?php	}else{ ?>
            <p class="w-full text-center p-2" style="background:#fa11;padding:20px;border-radius:10px;font-size:14px;">Lo sentimos, no hay anillos disponibles aún en nuestra galería.</p>
    <?php }
            ?>		
    </div>
    <div class="products__view" id="banner-pulseras">
        <h2 class="titulos texto-dorado" style="text-align: end;margin-top: 50px;">Pulseras...</h2>
        <!-- <div class="products__view--sliders noreverse">
            <div class="banner__slider gold">
            	<img src="assets/img/collar2.jpg" class="banner__slider--img" />
            	<div class="banner__slider--info">
            		<h3 class="banner__slider--title">30% de descuento en:</h3>
            		<p>Collares y pendientes</p>
            		<a href="#" class="btn btn-primary gold">Ver productos</a>
            	</div>
            </div>
            
            <div class="slider__double">
            	<div class="slider__items">
            		<div class="slider__items--item">
            			<img src="assets/img/anillos.jpg" />
            			<div class="slider__item--info gold">
            				<h4>Anillo Cebreado</h4>
            				<a href="#" class="btn btn-primary gold">Ver más</a>
            			</div>
            		</div>
            		<div class="slider__items--item">
            			<img src="assets/img/anillo1.jpg" />
            			<div class="slider__item--info gold">
            				<h4>Anillo Cebreado</h4>
            				<a href="#" class="btn btn-primary gold">Ver más</a>
            			</div>
            		</div>
            	</div>
            </div>
            </div> -->
        <?php 
            if(count($pulseras)>0){ ?>
        <div class="products__big--slider">
            <i class="ri-arrow-right-line slider__controller glider2-arrow-right gold"></i>
            <i class="ri-arrow-left-line slider__controller glider2-arrow-left gold"></i>
            <div class="slider" id="glider2">
                <?php 
                    foreach ($pulseras as $key => $value) { ?>
                <div class="slider__item" style="cursor: pointer !important;" onclick="viewProduct(<?php echo $value['id']; ?>)">
                    <img class="slider__item--img" src="assets/img/products/<?php echo $value['photo'] ?>" />
                    <div class="slider__item--info gold">
                        <h4 style="font-weight: 600; text-align: center; font-size: 1.3rem; padding: 0 2rem"><?php echo $value['name']??''; ?></h4>
                        <!-- <a href="javascript:;" class="btn btn-primary text-green gold" onclick="viewProduct(<?php echo $value['id']; ?>)">Ver más</a> -->
                    </div>
                </div>
                <?php	}
                    ?>
            </div>
        </div>
        <?php	}else{ ?>
            <p class="w-full text-center p-2" style="background:#fa11;padding:20px;border-radius:10px;font-size:14px;">Lo sentimos, no hay pulseras disponibles aún en nuestra galería.</p>
    <?php }
            ?>	
    </div>
    <div class="products__view" id="banner-collares">
        <h2 class="titulos texto-rojo phone-initial no-center" style="margin-top: 50px;">Collares...</h2>
        <!-- <div class="products__view--sliders">
            <div class="slider__double">
            	<i class="ri-arrow-right-line slider__controller red"></i>
            	<i class="ri-arrow-left-line slider__controller red"></i>
            	<div class="slider__items">
            		<div class="slider__items--item">
            			<img src="assets/img/anillos.jpg" />
            			<div class="slider__item--info red">
            				<h4>Anillo Cebreado</h4>
            				<a href="#" class="btn btn-primary red">Ver más</a>
            			</div>
            		</div>
            		<div class="slider__items--item">
            			<img src="assets/img/anillo1.jpg" />
            			<div class="slider__item--info red">
            				<h4>Anillo Cebreado</h4>
            				<a href="#" class="btn btn-primary red">Ver más</a>
            			</div>
            		</div>
            	</div>
            </div>
            
            <div class="banner__slider red">
            	<img src="assets/img/collar2.jpg" class="banner__slider--img" />
            	<div class="banner__slider--info">
            		<h3 class="banner__slider--title">30% de descuento en:</h3>
            		<p>Collares y pendientes</p>
            		<a href="#" class="btn btn-primary red">Ver productos</a>
            	</div>
            </div>
            </div> -->
        <?php 
            if(count($collares)>0){ ?>
        <div class="products__big--slider">
            <i class="ri-arrow-right-line slider__controller glider3-arrow-right red"></i>
            <i class="ri-arrow-left-line slider__controller glider3-arrow-left red"></i>
            <div class="slider" id="glider3">
                <?php 
                    foreach ($collares as $key => $value) { ?>
                <div class="slider__item" style="cursor: pointer !important;" onclick="viewProduct(<?php echo $value['id']; ?>)">
                    <img class="slider__item--img" src="assets/img/products/<?php echo $value['photo'] ?>" />
                    <div class="slider__item--info red">
                        <h4 style="font-weight: 600; text-align: center; font-size: 1.3rem; padding: 0 2rem"><?php echo $value['name']??''; ?></h4>
                        <!-- <a href="javascript:;" class="btn btn-primary text-green red" onclick="viewProduct(<?php echo $value['id']; ?>)">Ver más</a> -->
                    </div>
                </div>
                <?php	}
                    ?>
            </div>
        </div>
        <?php	}else{ ?>
            <p class="w-full text-center p-2" style="background:#fa11;padding:20px;border-radius:10px;font-size:14px;">Lo sentimos, no hay collares disponibles aún en nuestra galería.</p>
    <?php }
            ?>	
    </div>
    <div class="products__view" id="banner-pendientes">
        <h2 class="titulos texto-gris phone-initial" style="text-align: right !important;margin-top: 50px;">Pendientes...</h2>
        <!-- <div class="products__view--sliders noreverse">
            <div class="slider__double">
            	<i class="ri-arrow-right-line slider__controller gray"></i>
            	<i class="ri-arrow-left-line slider__controller gray"></i>
            	<div class="slider__items">
            		<div class="slider__items--item">
            			<img src="assets/img/anillos.jpg" />
            			<div class="slider__item--info gray">
            				<h4>Anillo Cebreado</h4>
            				<a href="#" class="btn btn-primary gray">Ver más</a>
            			</div>
            		</div>
            		<div class="slider__items--item">
            			<img src="assets/img/anillo1.jpg" />
            			<div class="slider__item--info gray">
            				<h4>Anillo Cebreado</h4>
            				<a href="#" class="btn btn-primary gray">Ver más</a>
            			</div>
            		</div>
            	</div>
            </div>
            </div> -->
        <?php 
            if(count($pendientes)>0){ ?>
        <div class="products__big--slider">
            <i class="ri-arrow-right-line slider__controller glider4-arrow-right gray"></i>
            <i class="ri-arrow-left-line slider__controller glider4-arrow-left gray"></i>
            <div class="slider" id="glider4">
                <?php 
                    foreach ($pendientes as $key => $value) { ?>
                <div class="slider__item" style="cursor: pointer !important;" onclick="viewProduct(<?php echo $value['id']; ?>)">
                    <img class="slider__item--img" src="assets/img/products/<?php echo $value['photo'] ?>" />
                    <div class="slider__item--info gray">
                        <h4 style="font-weight: 600; text-align: center; font-size: 1.3rem; padding: 0 2rem"><?php echo $value['name']??''; ?></h4>
                        <!-- <a href="javascript:;" class="btn btn-primary text-green gray" onclick="viewProduct(<?php echo $value['id']; ?>)">Ver más</a> -->
                    </div>
                </div>
                <?php	}
                    ?>
            </div>
        </div>
        <?php	}else{ ?>
            <p class="w-full text-center p-2" style="background:#fa11;padding:20px;border-radius:10px;font-size:14px;">Lo sentimos, no hay pendientes disponibles aún en nuestra galería.</p>
    <?php }
            ?>	
    </div>
    <br> <br>
    <section class="contacto">
        <img src="assets/img/granos.png" class="contact__side--img position-left" alt="">
        <img src="assets/img/granos.png" class="contact__side--img position-right" alt="">
        <h1 class="titulos">Contactanos</h1>
        <p class="contacto__subtitle">¡Te invitamos a ponerte en contacto con nosotros! Estamos aquí para responder a tus preguntas, ayudarte con tus pedidos y escuchar tus comentarios. <br> <br> Tu opinión es importante para nosotros.</p>
        <ul class="contacto__contact--menu">
            <li>
                <a href="https://www.instagram.com/sembra.biojoyas/" class="color-gold menu-text"><i class="fa-brands fa-instagram"></i> <span>#sembra.biojoyas</span>
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
</div>
<script>
    // Agregar un evento de clic a todos los elementos con clase 'closeModal' o 'closeModalBtn'
    const closeButtons = document.querySelectorAll('.closeModal, .closeModalBtn');
    var myCant = 0;
    var myPrice = 0;
    var myProdId = null;
    
    closeButtons.forEach((button) => {
    	button.addEventListener('click', (event) => {
           // Obtener el modal padre del botón clicado
    		const modal = event.target.closest('.modal');
    
           // Verificar si se encontró un modal padre
    		if (modal) {
               // Quitar la clase 'active' del modal padre
    			modal.classList.remove('active');
    		}
    	});
    });
    
    function getProductInfo(prodId){
    	return new Promise((resolve, reject)=>{
    		let product = new XMLHttpRequest();
    		product.open('POST', 'admin/components/getProductInfoById.php', true);
    		product.onload = ()=>{
    			if(product.readyState === XMLHttpRequest.DONE){
    				if(product.status === 200){
    					if(product.response){
    						const response = JSON.parse(product.response);
    						if(response.success){
    							resolve(response.data);
    						}else{
    							reject(response.message);
    						}
    					}else{
    						reject(product.response);
    					}
    				}else{
    					reject();
    				}
    			}
    		}
    		product.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    		product.send('prodId='+prodId);
    	});
    }
    var loader = document.querySelector('.loader');
    var modal = document.querySelector('.modal');
    var productName = document.querySelector('.productName');
    var productCod = document.querySelector('.productCod');
    var productIMG = document.querySelector('.productIMG');
    var productCant = document.querySelector('.productCant');
    var productTags = document.querySelector('.productTags');
    var medidas = document.querySelector('.medidas');
    var productDescription = document.querySelector('.productDescription');
    var productPrice = document.querySelector('.productPrice');
    
    function upCant() {
       myCant++;
       productCant.innerHTML = myCant;
        updateProductPrice();
    }
    
    function downCant() {
        if (myCant > 1) {
            myCant--;
            productCant.innerHTML = myCant;
            updateProductPrice();
        }
    }
    
    function updateProductPrice() {
        const total = myPrice * myCant;
        productPrice.innerHTML = total;
    }
    async function viewProduct(prodId){
    	try{
    		loader.classList.add('active');
    		const data = await getProductInfo(prodId);
    
    		productName.innerHTML = data.name;
    		productCod.innerHTML = data.cod;
    		productIMG.src='assets/img/products/'+data.photo;
    		productTags.innerHTML = data.tags;
    		medidas.innerHTML =  `Medidas: ${data.medidas}`;
    		productDescription.innerHTML =  data.description;
    		productPrice.innerHTML = data.price;
    		myCant = 1;
    		myPrice = data.price;
    		productCant.innerHTML = myCant;
    		myProdId = data.id;
    
    		modal.classList.add('active');
    	}catch(e){
    		Swal.fire({
    			icon: 'error',
    			title: 'Oops...',
    			text: e,
    		})
    		console.log(e);
    	}finally{
    		loader.classList.remove('active');
    	}
    }
    
    const addToCart = document.querySelector('.addToCart');
    
    addToCart.addEventListener('click',function(){
    	// Verifica si ya existe un carrito en localStorage
       const cart = JSON.parse(localStorage.getItem('cartElements')) || {};
    
       // Verifica si el producto ya está en el carrito
       if (cart[myProdId]) {
           // Si ya existe, aumenta la cantidad en 1 (o según sea necesario)
           cart[myProdId]+=myCant;
       } else {
           // Si no existe, inicializa la cantidad en 1
           cart[myProdId] = myCant;
       }
    
       // Guarda el carrito actualizado en localStorage
       localStorage.setItem('cartElements', JSON.stringify(cart));
       Swal.fire({
    		icon: 'success',
    		title: 'Perfecto!',
    		text: 'Has agregado tu producto al carrito correctamente!',
    	})
    });
    
    <?php 
        if(count($anillos)>0){ ?>
            new Glider(document.querySelector('#glider1'), {
                slidesToShow: 1,
                slidesToScroll: 1,
                draggable: true,
                dots: '.dots',
                arrows: {
                    prev: '.glider1-arrow-left',
                    next: '.glider1-arrow-right'
                },
                responsive: [
                {
                // screens greater than >= 600px
                breakpoint: 400,
                    settings: {
                // Set to `auto` and provide item width to adjust to viewport
                        slidesToShow: 1.2,
                        slidesToScroll: 1.2,
                        itemWidth: 150,
                        duration: 0.25
                    }
                },{
                // screens greater than >= 775px
                    breakpoint: 775,
                    settings: {
                // Set to `auto` and provide item width to adjust to viewport
                        slidesToShow: 2.5,
                        slidesToScroll: 2.5,
                        itemWidth: 150,
                        duration: 0.25
                    }
                },{
                // screens greater than >= 1200px
                    breakpoint: 1100,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        itemWidth: 150,
                        duration: 0.25
                    }
                }
                ]
            });
<?php    }
    ?>
    
    <?php 
        if(count($pulseras)>0){ ?>
    new Glider(document.querySelector('#glider2'), {
    	slidesToShow: 1,
    	slidesToScroll: 1,
    	draggable: true,
    	dots: '.dots',
    	arrows: {
    		prev: '.glider2-arrow-left',
    		next: '.glider2-arrow-right'
    	},
    	responsive: [
    		{
    	// screens greater than >= 600px
    	breakpoint: 400,
    		settings: {
           // Set to `auto` and provide item width to adjust to viewport
    			slidesToShow: 1.2,
    			slidesToScroll: 1.2,
    			itemWidth: 150,
    			duration: 0.25
    		}
    	},{
         // screens greater than >= 775px
    		breakpoint: 775,
    		settings: {
           // Set to `auto` and provide item width to adjust to viewport
    			slidesToShow: 2.5,
    			slidesToScroll: 2.5,
    			itemWidth: 150,
    			duration: 0.25
    		}
    	},{
         // screens greater than >= 1200px
    		breakpoint: 1100,
    		settings: {
    			slidesToShow: 4,
    			slidesToScroll: 4,
    			itemWidth: 150,
    			duration: 0.25
    		}
    	}
    	]
    });
    <?php } ?>
    
    <?php 
        if(count($collares)>0){ ?>
    new Glider(document.querySelector('#glider3'), {
    	slidesToShow: 1,
    	slidesToScroll: 1,
    	draggable: true,
    	dots: '.dots',
    	arrows: {
    		prev: '.glider3-arrow-left',
    		next: '.glider3-arrow-right'
    	},
    	responsive: [
    		{
    	// screens greater than >= 600px
    	breakpoint: 400,
    		settings: {
           // Set to `auto` and provide item width to adjust to viewport
    			slidesToShow: 1.2,
    			slidesToScroll: 1.2,
    			itemWidth: 150,
    			duration: 0.25
    		}
    	},{
         // screens greater than >= 775px
    		breakpoint: 775,
    		settings: {
           // Set to `auto` and provide item width to adjust to viewport
    			slidesToShow: 2.5,
    			slidesToScroll: 2.5,
    			itemWidth: 150,
    			duration: 0.25
    		}
    	},{
         // screens greater than >= 1200px
    		breakpoint: 1100,
    		settings: {
    			slidesToShow: 4,
    			slidesToScroll: 4,
    			itemWidth: 150,
    			duration: 0.25
    		}
    	}
    	]
    });
    <?php } ?>

    
    <?php 
        if(count($pendientes)>0){ ?>
    new Glider(document.querySelector('#glider4'), {
    	slidesToShow: 1,
    	slidesToScroll: 1,
    	draggable: true,
    	dots: '.dots',
    	arrows: {
    		prev: '.glider4-arrow-left',
    		next: '.glider4-arrow-right'
    	},
    	responsive: [
    		{
    	// screens greater than >= 600px
    	breakpoint: 400,
    		settings: {
           // Set to `auto` and provide item width to adjust to viewport
    			slidesToShow: 1.2,
    			slidesToScroll: 1.2,
    			itemWidth: 150,
    			duration: 0.25
    		}
    	},{
         // screens greater than >= 775px
    		breakpoint: 775,
    		settings: {
           // Set to `auto` and provide item width to adjust to viewport
    			slidesToShow: 2.5,
    			slidesToScroll: 2.5,
    			itemWidth: 150,
    			duration: 0.25
    		}
    	},{
         // screens greater than >= 1200px
    		breakpoint: 1100,
    		settings: {
    			slidesToShow: 4,
    			slidesToScroll: 4,
    			itemWidth: 150,
    			duration: 0.25
    		}
    	}
    	]
    });
    <?php } ?>
</script>
