<?php 
date_default_timezone_set('Europe/Madrid');
$fecha_proporcionada = date('Y-m-d h:i:s');
$fechaPortaFormateada = date('d/m/Y', strtotime($fecha_proporcionada));
 
 echo $fechaPortaFormateada;
?>