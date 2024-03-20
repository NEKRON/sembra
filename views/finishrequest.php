<div class="products__container">
    <div class="products__banner whoweare-banner">
        <img src="assets/img/comprar.webp">
        <div class="whoweare__banner--content" style="justify-content: center; text-align: center;align-items: center;display:flex;
            flex-direction: column;
            ">
            <h1 class="texto-blanco titulos">Mi Pedido</h1>
        </div>
    </div>
    <form class="finishBuy__container" method="post">
        <h2 class="finish__title">Ingresá tus datos personales</h2>
        <div class="form__item">
            <label for="name">Nombres y apellidos</label>
            <input type="text" name="name" required>
        </div>
        <div class="form__item">
            <label for="document">Número de documento: </label>
            <input type="text" name="document" required placeholder="NIF - NIE - CIF">
        </div>
        <div class="form__item">
            <label for="tel">Teléfono de Contacto</label>
            <input type="text" name="tel" required>
        </div>
        <div class="form__item">
            <label for="email">Correo Electrónico</label>
            <input type="text" name="email" required>
        </div>
        <div class="form__item">
            <label for="direction">Dirección de Entrega</label>
            <input type="text" name="direction" required>
        </div>
        <!-- <div class="form__item">
            <label for="comments">Comentarios</label>
            <input type="text" name="comments" required>
        </div> -->
        <div class="relative">
            <div class="loader">
                <div class="donut"></div>
            </div>
            <button type="submit" style="background:var(--doradoPrincipal);margin-top:0px !important;" class="payment__process btn btnProcess">Finalizar Compra</button>			
        </div>
    </form>
</div>
<style>
    .relative{
    position: relative;
    width: fit-content;
    height: fit-content;
    margin-left: auto;
    margin-top: 20px;
    }
    .loader{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1;
    background:#2222;
    display: flex;
    height: 100%;
    justify-content: center;
    border-radius: 20px;
    overflow: hidden;
    align-items: center;
    display: none;
    }
    .loader.active{
    display: flex;
    }
    @keyframes donut-spin {
    0% {
    transform: rotate(0deg);
    }
    100% {
    transform: rotate(360deg);
    }
    }
    .donut {
    display: inline-block;
    border: 4px solid rgba(0, 0, 0, 0.1);
    border-left-color: #FF7D55;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    animation: donut-spin 1.2s linear infinite;
    }
    .finishBuy__container{
    width: 100%;
    max-width: 1240px;
    margin: 0 auto;
    padding: 20px;
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
    }
    .finish__title{
    font-size: 1.6em;
    font-weight: 600;
    color: #555;
    margin-bottom: 40px;
    }
    .form__item{
    margin-top: 20px;
    width: 100%;
    display: grid;
    gap: 10px;
    grid-template-columns: 1fr;
    }
    .payment__process{
    margin-left: auto;
    margin-top: 40px;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    // Recupera los elementos de localStorage
    const cartElementsJSON = localStorage.getItem('cartElements');
    const cartElements = JSON.parse(cartElementsJSON) || {};
    
    // Escucha el evento de envío del formulario
    const uploadMyOrder = (mydata) => {
    	return new Promise((resolve,reject)=>{
    		var xhr = new XMLHttpRequest();
    		xhr.open('POST', 'admin/components/buynow.php', true);
    		xhr.onload = function() {
    			if (xhr.status >= 200 && xhr.status < 300) {
    			      // La solicitud fue exitosa
    				const response = xhr.response;
    				if(response){
    					console.log(response);
    					const res = JSON.parse(response);
    					if(res.success){
    						resolve();
    					}else{
    						reject();
    					}
    				}else{
    					reject (new Error('Error al intentar procesar tu compra.'));
    				}
    			} else {
    				reject (new Error('Error al intentar procesar tu compra.'));
    			}
    		};
    		xhr.onerror = function() {
    			reject (new Error('Error al intentar procesar tu compra.'));
    		};
    		xhr.send(mydata);
    	});
    }
    
    const form = document.querySelector('.finishBuy__container');
    form.addEventListener('submit', async (event) => {
        event.preventDefault(); // Evita el envío del formulario por defecto
    
        // Recopila los datos del formulario
        const formData = new FormData(form);
    
        // Agrega los elementos de localStorage a los datos del formulario
        formData.append('cartElements', JSON.stringify(cartElements));
    
        try {
        	$('.btnProcess').prop('disabled',true);
        	$('.loader').addClass('active');
        	await uploadMyOrder(formData);
        	Swal.fire({
        		icon: 'success',
        		title: 'Gracias!',
        		text: 'Su solicitud fue recibida correctamente, nos comunicaremos con usted a lo largo del día.',
        	}).then(()=>{
        		localStorage.removeItem('cartElements');
        		window.location.href='?mod=home';
        	});
        } catch (error) {
        	Swal.fire({
        		icon: 'error',
        		title: 'Ups!',
        		text: 'No pudimos completar tu pedido debido a un error de sistema, intenta nuevamente más tarde.',
        	});
        }finally{
        	$('.btnProcess').prop('disabled',false);
        	$('.loader').removeClass('active');
        }
    });
</script>
