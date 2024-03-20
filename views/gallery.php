<?php
    include_once 'admin/includes/db.php';
    $query = $_REQUEST['q'] ?? '';
    $filter = $_REQUEST['f'] ?? '';
    $and = "1=1"; // Cambié "and 1=1" a "1=1" ya que no es necesario especificar "and" al principio.
    
    if ($filter != '') {
      $and = 'type="' . $filter.'"'; // Corregí la concatenación de la variable $filter.
    }
    
    $sql = "SELECT * FROM products WHERE name LIKE '%" . $query . "%' AND $and ORDER BY RAND()";
    
    $myprods = $conn->query($sql);
    ?>
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
    <div class="products__banner whoweare-banner background" style="min-height:50vh;">
        <img src="assets/img/joyas.webp" alt="">
        <div class="whoweare__banner--content">
            <h1 class="titulos">Nuestras Joyas</h1>
            <p>Cada una de nuestras biojoyas son como nuestros clientes, únicos.
                Nuestras piezas están elaboradas de manera artesanal con elementos de la naturaleza de temporada. Así que antes de efectuar tu compra, nosotros te confirmaremos disponibilidad de productos.
            </p>
        </div>
    </div>
    <div class="gallery__joyas">
        <h4 class="title">Galería de Productos SembraBiojoyas</h4>
        <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;justify-content:space-between;">
            <div class="relative" style="flex:1;">
                <input class="searchInput" type="text" placeholder="Buscar algo..." value="<?php echo $query; ?>"/>
                <i class="fa-solid fa-search searchIcon"></i>
            </div>
            <div class="relative">
                <select class="searchFilter" style="flex:.1;padding:10px;border:none;outline:none;border:1px solid #0001;border-radius:10px;background:transparent;font-size:14px;">
                    <option value="">Filtrar por tipo de producto</option>
                    <option value="Anillos" <?php echo ($filter=="Anillos")?'selected':''; ?>>Anillos</option>
                    <option value="Pulseras" <?php echo ($filter=="Pulseras")?'selected':''; ?>>Pulseras</option>
                    <option value="Collares" <?php echo ($filter=="Collares")?'selected':''; ?>>Collares</option>
                    <option value="Pendientes" <?php echo ($filter=="Pendientes")?'selected':''; ?>>Pendientes</option>
                </select>
            </div>
        </div>
        <?php 
            if($myprods->num_rows>0){ ?>
        <div class="gallery__joyas-products">
            <?php 
                while($p = $myprods->fetch_assoc()){ ?>
            <?php 
                $img = utf8_encode(utf8_decode($p['photo']??''));
                ?>
            <div class="gallery__joyas-products--item">
                <div class="gallery__joyas-products--item__imgCont relative">
                    <span class="gallery__joyas-products--item__type"><?php echo $p['type']??''; ?></span>
                    <img class="gallery__joyas-products--item__img" src="assets/img/products/<?php echo $img; ?>"/>
                </div>
                <div class="gallery__joyas-products--item__title">
                    <h4 class="element__cart--title"><?php echo html_entity_decode(utf8_decode($p['name']??''), ENT_QUOTES, "UTF-8"); ?></h4>
                    <span class="gallery__joyas-products--item__title-price">
                    <?php echo $p['price']??0; ?> € EUR
                    </span>
                </div>
                <p class="gallery__joyas-products--item__description truncate2"><?php echo html_entity_decode(utf8_decode($p['description']??''), ENT_QUOTES, "UTF-8"); ?></p>
                <div class="gallery__joyas-products--item__button">
                    <a class="btn btn-primary gallery__joyas-products--item__button-element" onclick="addToCartWithId(<?php echo $p['id']; ?>)">Agregar al carrito</a>
                    <a class="btn btn-primary gallery__joyas-products--item__button-element2" onclick="viewProduct(<?php echo $p['id']; ?>)">Ver producto</a>
                </div>
            </div>
            <?php }
                ?>
        </div>
        <?php }else{ ?>
        <p class="noProducts">Lo sentimos, no hay productos disponibles...</p>
        <?php }
            ?>
    </div>
</div>
<style>
    .gallery__joyas{
    width:100%;
    max-width:1280px;
    margin:0 auto;
    padding: 40px 10px;
    min-height:50vh;
    }
    .relative{
    position:relative;
    }
    .w-full{
    width:100%;
    }
    .title{
    font-size:24px;
    font-weight:600;
    color:var(--verdePrincipal);
    }
    .noProducts{
    font-size:14px;
    display:flex;
    width:100%;
    justify-content:center;
    padding:20px;
    margin-top:30px;
    }
    .searchInput{
    padding:10px;
    border:none;
    outline:none;
    border-radius:10px;
    width:100%;
    border:1px solid #0002;
    font-size:14px;
    /* box-shadow:0 0 5px #0002; */
    padding-left:30px;
    }
    .searchInput::placeholder{
    font-size:14px;
    }
    .searchIcon{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    left:10px;
    color:var(--doradoPrincipal);
    font-size:14px;
    cursor:pointer;
    }
    .gallery__joyas-products{
    width:100%;
    display:flex;
    flex-wrap:wrap;
    margin-top:25px;
    gap:15px;
    justify-content: center;
    }
    .gallery__joyas-products--item{
    display:flex;
    flex-direction:column;
    flex:1;
    max-width:350px;
    min-width:280px;
    transition:all .3s;
    }
    .gallery__joyas-products--item:hover{
    transform:scale(1.03);
    }
    .gallery__joyas-products--item__type{
    position:absolute;
    top:10px;
    right:-10px;
    padding:10px;
    padding-right:20px;
    font-size:10px;
    text-transform:uppercase;
    background:var(--verdePrincipal);
    color:#fff;
    border-radius:10px;
    font-weight: bold;
    }
    .gallery__joyas-products--item__imgCont{
    width:100%;
    overflow:hidden;
    }
    .gallery__joyas-products--item__img{
    width:100%;
    height: auto;
    object-fit:cover;
    border-radius:10px;
    }
    @media (min-width: 800px) {
    .gallery__joyas-products--item__img {
    height: 500px;
    }
    }
    .gallery__joyas-products--item__title{
    width:100%;
    padding:0 10px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    }
    .gallery__joyas-products--item__title-price{
    padding:.5rem;
    border-radius:5px;
    font-size:13px;
    color:var(--verdePrincipal);
    font-weight:bolder;
    background:#2221;
    text-align: center;
    }
    .gallery__joyas-products--item__description{
    font-size:12px;
    color:#555;
    padding:0 10px;
    }
    .truncate2{
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    }
    .gallery__joyas-products--item__button{
    padding:0 10px;
    width:100%;
    display:flex;
    justify-content:center;
    margin-top:15px;
    gap:15px;
    }
    .gallery__joyas-products--item__button-element{
    padding:10px;
    border-radius:5px;
    background:var(--verdePrincipal);
    color:#fff;
    font-size:12px;
    transition:all .3s;
    }
    .gallery__joyas-products--item__button-element:hover{
    box-shadow:0 0 15px var(--verdePrincipal);
    }
    .gallery__joyas-products--item__button-element2{
    padding:10px;
    border-radius:5px;
    background:#2221;
    font-size:12px;
    transition:all .3s;
    color:#222;
    }
    .gallery__joyas-products--item__button-element2:hover{
    box-shadow:0 0 15px #0002;
    font-weight: bold;
    }
</style>
<script>
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
    
      function addToCartWithId(id){
        const cart = JSON.parse(localStorage.getItem('cartElements')) || {};
        
          // Verifica si el producto ya está en el carrito
          if (cart[id]) {
              // Si ya existe, aumenta la cantidad en 1 (o según sea necesario)
              cart[id] += 1;
          } else {
              // Si no existe, inicializa la cantidad en 1
              cart[id] = 1;
          }
      
          // Guarda el carrito actualizado en localStorage
          localStorage.setItem('cartElements', JSON.stringify(cart));
          Swal.fire({
          icon: 'success',
          title: 'Listo!',
          text: 'Has agregado tu producto al carrito correctamente!',
        })
      }
      const searchInput = document.querySelector('.searchInput');
    const searchFilter = document.querySelector('.searchFilter');
    
    searchInput.addEventListener('change', function () {
    updateGalleryURL();
    });
    
    searchInput.addEventListener('keyup', function (e) {
    const val = searchInput.value;
    const keycode = e.keyCode || e.which;
    if (val === '' && keycode === 13) {
      updateGalleryURL();
    }
    });
    
    searchFilter.addEventListener('change', function () {
    updateGalleryURL();
    });
    
    function updateGalleryURL() {
    const val = searchInput.value;
    const filterVal = searchFilter.value;
    
    let url = '?mod=gallery';
    
    if (val && val !== '') {
      url += '&q=' + val;
    }
    
    if (filterVal && filterVal !== '') {
      url += '&f=' + filterVal;
    }
    
    window.location.href = url;
    }
</script>
