<?php 
    include_once 'admin/includes/db.php';
    $opinions = $conn->query("SELECT * from opinions order by id desc LIMIT 6");
    ?>
<div class="products__container">
    <div class="products__banner whoweare-banner">
        <img src="assets/img/bisutexEsposicion.webp">
        <div class="whoweare__banner--content">
            <h1 class="titulos texto-dorado">Nuestro Blog</h1>
            <p>Sembra BioJoyas en Bisutex: Del 14 al 17 de septiembre, descubre elegancia sostenible en Madrid. Únete a la belleza con conciencia ambiental. ¡Visítanos en el stand!.</p>
            <br> <br>
            <a href="#blog" class="boton-blog boton-dorado">Ver más</a>
        </div>
    </div>
    <div class="blog__container" id="blog">
        <div class="blog__content" id="bisutex">
            <div class="blog__cont">
                <div class="blog-item">
                    <img src="assets/img/bisutexEsposicion.webp" class="blog__item--img" alt="">
                    <div class="blog__item-description--container">
                        <div class="blog__item--description">
                            <h3 class="subtitulos no-center texto-dorado">Bisutex Madrid</h3>
                            <span class="texto-verde no-center">Desde el 14 de Septiembre hasta el 17 de Septiembre</span> 
                            <br><br>
                            <p class="no-center"> <span style="font-weight: bold">Sembra BioJoyas en Bisutex: Elegancia Sostenible en el Corazón de Madrid</span>  
                                <br> <br>
                                En la Feria Bisutex, que se celebrará del 14 al 17 de septiembre en Madrid, Sembra BioJoyas se enorgullece de presentar una colección única que fusiona la belleza de las joyas con la sostenibilidad ambiental. 
                                <br><br>
                                Nuestros productos, elaborados con materiales naturales y técnicas de producción respetuosas con el medio ambiente, capturan la esencia de la naturaleza en cada detalle. <br> <br>
                                Para esta exposición, hemos creado un espacio ecoamigable que refleja nuestra filosofía. Utilizaremos materiales reciclados y sostenibles en la decoración y la presentación de productos. Nuestro objetivo es transmitir la importancia de la sostenibilidad en la joyería y cómo podemos lograr la belleza consciente sin comprometer nuestro planeta.
                                <br><br>
                                Te invitamos a visitarnos en Bisutex en el <span style="font-weight: bold;">Pabellon 4 - 4A44 Expositor desde las 10:00 AM</span> y descubrir cómo la elegancia y la sostenibilidad pueden coexistir en armonía.							
                            </p>
                        </div>
                        <div class="blog__item--btns">
                            <div>
                                <!-- <a href="#">Ver más</a> -->
                            </div>
                            <div class="btns--icons">
                                <i class="ri-share-forward-fill share"></i>
                                <i class="ri-heart-fill heart"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="blog-item">
                    <img src="assets/img/valencia.jpg" class="blog__item--img" alt="">
                    <div class="blog__item-description--container">
                    	<div class="blog__item--description">
                    		<h3 class="blog__item--title">
                    			Nuestro Blog
                    			<span>Nuestro Blog</span>
                    		</h3>
                    		<p class="blog__item--description-element">
                    			Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quidem aut delectus quod quibusdam, nemo placeat iusto, cumque! Ut quasi porro ab perferendis autem amet nulla dolorem reiciendis laborum quibusdam. Soluta.
                    		</p>
                    	</div>
                    	<div class="blog__item--btns">
                    		<div>
                    			<a href="#">Ver más</a>
                    		</div>
                    		<div class="btns--icons">
                    			<i class="ri-share-forward-fill share"></i>
                    			<i class="ri-heart-fill heart"></i>
                    		</div>
                    	</div>
                    </div>
                    </div> -->
                <!-- <div class="blog-item">
                    <img src="assets/img/shane-rounce-DNkoNXQti3c-unsplash.jpg" class="blog__item--img" alt="">
                    <div class="blog__item-description--container">
                    	<div class="blog__item--description">
                    		<h3 class="blog__item--title">
                    			Nuestro Blog
                    			<span>Nuestro Blog</span>
                    		</h3>
                    		<p class="blog__item--description-element">
                    			Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quidem aut delectus quod quibusdam, nemo placeat iusto, cumque! Ut quasi porro ab perferendis autem amet nulla dolorem reiciendis laborum quibusdam. Soluta.
                    		</p>
                    	</div>
                    	<div class="blog__item--btns">
                    		<div>
                    			<a href="#">Ver más</a>
                    		</div>
                    		<div class="btns--icons">
                    			<i class="ri-share-forward-fill share"></i>
                    			<i class="ri-heart-fill heart"></i>
                    		</div>
                    	</div>
                    </div>
                    </div> -->
            </div>
            <div class="blog__aside">
                <h3 class="texto-verde">Opiniones</h3>
                <div class="blog__aside--opinions">
                    <?php 
                        if($opinions->num_rows>0){ ?>
                    <?php while ($value = $opinions->fetch_assoc()){ ?>
                    <div class="aside__opinion" style="position: relative;">
                        <img src="assets/img/default.webp" class="opinion--img" />
                        <div class="opinion--description">
                            <h4 style="display:flex;flex-direction: column;"><?php echo $value['name'].' '.$value['lastname']; ?><span style="font-size: 10px;"><?php echo $value['email']; ?></span></h4>
                            <p class="truncate">
                                <?php echo $value['comment']; ?>
                            </p>
                            <p style="font-size:10px;color:#999;position:absolute;top: 2px;right: 7px;"><?php echo formatDate($value['created_at']); ?></p>
                        </div>
                    </div>
                    <?php } ?>
                    <?php	} else{ ?>
                    <div class="aside__opinion">
                        <img src="assets/img/mujerPlaya.webp" class="opinion--img" />
                        <div class="opinion--description">
                            <h4>Nuestro blog</h4>
                            <p class="">
                                Aún no hay opiniones de los usuarios. Cuando las haya, apareceran aquí.
                            </p>
                        </div>
                    </div>
                    <?php	}
                        ?>
                </div>
            </div>
        </div>
    </div>
    <section class="contacto">
        <img src="assets/img/granos.webp" class="contact__side--img position-left" alt="">
        <img src="assets/img/granos.webp" class="contact__side--img position-right" alt="">
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
</div>
<script>
    // Obtén todos los elementos con la clase 'truncate'
    	const truncates = document.querySelectorAll('.truncate');
    
    // Define la longitud máxima del texto truncado
    	const maxLength = 70;
    
    // Función para truncar el texto
    	function truncateText(text, maxLength) {
    		if (text.length <= maxLength) {
    			return text;
    		} else {
    			return text.slice(0, maxLength) + '...';
    		}
    	}
    
    // Itera sobre los elementos con la clase 'truncate'
    	truncates.forEach((element) => {
    		const text = element.innerHTML;
    		const truncatedText = truncateText(text, maxLength);
    		element.innerHTML = truncatedText;
    	});
</script>
