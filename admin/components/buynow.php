<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
    
// Recibe los datos del formulario y los elementos de localStorage
$name = $_POST['name']??'';
$document = $_POST['document']??'';
$tel = $_POST['tel']??'';
$email = $_POST['email']??'';
$direction = $_POST['direction']??'';
$comments = $_POST['comments']??'';
$cartElementsJSON = $_POST['cartElements']??'[]';
$cartElements = json_decode($cartElementsJSON, true);
  include_once '../includes/db.php';
  // Verifica si la conexión a la base de datos es exitosa
  if ($conn->connect_error) {
      die("Error en la conexión a la base de datos: " . $conn->connect_error);
  }

  $letters = '';
    $numbers = '';
    foreach (range('A', 'Z') as $char) {
      $letters .= $char;
    }
    for($i = 0; $i < 10; $i++){
      $numbers .= $i;
    }
    $orderId = substr(str_shuffle($letters), 0, 3).substr(str_shuffle($numbers), 0, 9);

  
  $verif = $conn->query("SELECT id,client_id from clientes where email='$email'");
  if($verif->num_rows>0){
    $clientId = $verif->fetch_assoc();
    $clientId = $clientId['client_id']??'';
  }else{
    $letters = '';
    $numbers = '';
    foreach (range('A', 'Z') as $char) {
      $letters .= $char;
    }
    for($i = 0; $i < 10; $i++){
      $numbers .= $i;
    }
    $clientId = substr(str_shuffle($letters), 0, 3).substr(str_shuffle($numbers), 0, 9);

    $conn->query("INSERT into clientes (client_id,nombre,documento,telefono,email,direccion,comentarios) values ($clientId,$name,$document,$tel,$email,$direction,$comments)");
  }
    
    $total = 0;
    $products = '';
    // Itera a través de los elementos del carrito y registra cada producto en una tabla de ventas
    foreach ($cartElements as $productId => $quantity) {
        // Inserta el producto en la tabla de ventas (ajusta el nombre de la tabla según tu base de datos)
        $sqlInsertVenta = "INSERT INTO ventas (order_id,client_id, prod_id, quantity) VALUES ($orderId,$clientId, $productId, $quantity)";
        $conn->query($sqlInsertVenta);

        $prods = $conn->query("SELECT * from products where id='$productId'");
        while($p = $prods->fetch_assoc()){
            $products .= 
                '<tr>
                    <td style="font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; width: 80%; padding-top: 10px; padding-bottom: 10px; font-size: 16px;">
                        '.utf8_encode(utf8_decode($p['name'])).' x'.$quantity.'
                    </td>
                    <td align="right" style="font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; width: 20%; text-align: right; font-size: 16px;">
                    €'.$p['price'].'</td>
                </tr>';

                $total+=$p['price'];
        }
    }
    
    date_default_timezone_set('Europe/Madrid');
    $fecha_proporcionada = date('Y-m-d h:i:s');
    $fechaPortaFormateada = date('d/m/Y', strtotime($fecha_proporcionada));
    $today = $fechaPortaFormateada;

    $mail = new PHPMailer(true);
    $mail2 = new PHPMailer(true);

    $html = 
    "<table style='width: 100%; font-family: Montserrat, -apple-system, Segoe UI, sans-serif;' cellpadding='0' cellspacing='0' role='presentation'>
      <tr>
        <td align='center' style='mso-line-height-rule: exactly; background-color: #eceff1; font-family: Montserrat, -apple-system, Segoe UI, sans-serif;'>
          <table class='sm-w-full' style='width: 600px;' cellpadding='0' cellspacing='0' role='presentation'>
            <tr>
              <td class='sm-py-32 sm-px-24' style='mso-line-height-rule: exactly; padding: 48px; text-align: center; font-family: Montserrat, -apple-system, Segoe UI, sans-serif;'>
              </td>
            </tr>
            <tr>
              <td align='center' class='sm-px-24' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly;'>
                <table style='width: 100%;' cellpadding='0' cellspacing='0' role='presentation'>
                  <tr>
                    <td class='sm-px-24' style='mso-line-height-rule: exactly; border-radius: 4px; background-color: #ffffff; padding: 48px; text-align: left; font-family: Montserrat, -apple-system, Segoe UI, sans-serif; font-size: 16px; line-height: 24px; color: #626262;'>
                      <p style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; margin-bottom: 0; font-size: 20px; font-weight: 600;'>Hola</p>
                      <p style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; margin-top: 0; font-size: 24px; font-weight: 700; color: #4b7a6d;'>".$name."!</p>
                      <p style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; margin: 0; margin-bottom: 24px;'>
                        Gracias por usar SembraBiojoyas.es. Este es el recibo de tu reciente transacción.<br/>
                        ID de Tu Pedido: ".$orderId."
                      </p>
                      <table style='width: 100%;' cellpadding='0' cellspacing='0' role='presentation'>
                        <tr>
                          <td style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; padding: 16px; font-size: 16px;'>
                            <table style='width: 100%;' cellpadding='0' cellspacing='0' role='presentation'>
                              <tr>
                                <td style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; font-size: 16px;'><strong>Total:</strong> €".$total."</td>
                              </tr>
                              <tr>
                                <td style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; font-size: 16px;'>
                                  <strong>A fecha de:</strong> ".$today."
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                      <table style='width: 100%;' cellpadding='0' cellspacing='0' role='presentation'>
                        <tr>
                          <td colspan='2' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly;'>
                            <table style='width: 100%;' cellpadding='0' cellspacing='0' role='presentation'>
                              <tr>
                                <th align='left' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; padding-bottom: 8px;'>
                                  <p style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly;'>Descripción</p>
                                </th>
                                <th align='right' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; padding-bottom: 8px;'>
                                  <p style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly;'>Total</p>
                                </th>
                              </tr>
                              ".$products."
                              <tr>
                                <td style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; width: 80%;'>
                                  <p align='right' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; margin: 0; padding-right: 16px; text-align: right; font-size: 16px; font-weight: 700; line-height: 24px;'>
                                    Total
                                  </p>
                                </td>
                                <td style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; width: 20%;'>
                                  <p align='right' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; margin: 0; text-align: right; font-size: 16px; font-weight: 700; line-height: 24px;'>
                                    €".$total."
                                  </p>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                      <table align='right' style='margin-left: auto; margin-right: auto; width: 100%; text-align: center;' cellpadding='0' cellspacing='0' role='presentation'>
                        <tr>
                          <td align='right' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly;'>
                            <table style='margin-top: 24px; margin-bottom: 24px;' cellpadding='0' cellspacing='0' role='presentation'>
                              <tr>
                                <td align='right' style='mso-line-height-rule: exactly; mso-padding-alt: 16px 24px; border-radius: 4px; background-color: #4b7a6d; font-family: Montserrat, -apple-system, Segoe UI, sans-serif;'>
                                  <a href='https://sembrabiojoyas.es' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; display: block; padding-left: 24px; padding-right: 24px; padding-top: 16px; padding-bottom: 16px; font-size: 16px; font-weight: 600; line-height: 100%; color: #ffffff; text-decoration: none;'>Ir a la página &rarr;</a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                      <p style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; margin-top: 6px; margin-bottom: 20px; font-size: 16px; line-height: 24px;'>
                        Gracias,
                        <br>el equipo de SembraBiojoyas
                      </p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; height: 20px;'></td>
            </tr>
            <tr>
              <td style='mso-line-height-rule: exactly; padding-left: 48px; padding-right: 48px; font-family: Montserrat, -apple-system, Segoe UI, sans-serif; font-size: 14px; color: #eceff1;'>
                <p style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; color: #263238;'>
                  El uso de este sitio web está sujeto a nuestros
                  <a href='https://sembrabiojoyas.es' class='hover-underline' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; color: #7367f0; text-decoration: none;'>Términos de Uso</a> y a la
                  <a href='https://sembrabiojoyas.es' class='hover-underline' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; color: #7367f0; text-decoration: none;'>Política de Privacidad</a>.
                </p>
              </td>
            </tr>
            <tr>
              <td style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; height: 16px;'></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>";

    //aqui escribe el cuerpo del mensaje para el administrador
    $html2 = 
    "<table style='width: 100%; font-family: Montserrat, -apple-system, Segoe UI, sans-serif;' cellpadding='0' cellspacing='0' role='presentation'>
      <tr>
        <td align='center' style='mso-line-height-rule: exactly; background-color: #eceff1; font-family: Montserrat, -apple-system, Segoe UI, sans-serif;'>
          <table class='sm-w-full' style='width: 600px;' cellpadding='0' cellspacing='0' role='presentation'>
            <tr>
              <td class='sm-py-32 sm-px-24' style='mso-line-height-rule: exactly; padding: 48px; text-align: center; font-family: Montserrat, -apple-system, Segoe UI, sans-serif;'>
              </td>
            </tr>
            <tr>
              <td align='center' class='sm-px-24' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly;'>
                <table style='width: 100%;' cellpadding='0' cellspacing='0' role='presentation'>
                  <tr>
                    <td class='sm-px-24' style='mso-line-height-rule: exactly; border-radius: 4px; background-color: #ffffff; padding: 48px; text-align: left; font-family: Montserrat, -apple-system, Segoe UI, sans-serif; font-size: 16px; line-height: 24px; color: #626262;'>
                      <p style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; margin-bottom: 0; font-size: 20px; font-weight: 600;'>Nuevo pedido</p>
                      <p style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; margin-top: 0; font-size: 24px; font-weight: 700; color: #4b7a6d;'>Comprador/a: ".$name."!</p>
                      <p style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; margin: 0; margin-bottom: 24px;'>
                        Gracias por usar SembraBiojoyas.es.<br/>Este es el recibo de una reciente transacción.
                        ID del Pedido: ".$orderId."<br/>
                        Estado: <span style='color:#4b7a6d;font-weight:600;'>Pendiente de revisión</span><br/><br/>
                        Datos del cliente:<br/>
                        Nombre: <span style='color:#4b7a6d;font-weight:600;'>".$name."</span><br/>
                        Teléfono: <span style='color:#4b7a6d;font-weight:600;'>".$tel."</span><br/>
                        Email: <span style='color:#4b7a6d;font-weight:600;'>".$email."</span><br/>
                        Dirección: <span style='color:#4b7a6d;font-weight:600;'>".$direction."</span><br/>
                        Comentarios: <span style='color:#4b7a6d;font-weight:600;'>".$comments."</span>
                      </p>
                      <table style='width: 100%;' cellpadding='0' cellspacing='0' role='presentation'>
                        <tr>
                          <td style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; padding: 16px; font-size: 16px;'>
                            <table style='width: 100%;' cellpadding='0' cellspacing='0' role='presentation'>
                              <tr>
                                <td style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; font-size: 16px;'><strong>Total:</strong> €".$total."</td>
                              </tr>
                              <tr>
                                <td style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; font-size: 16px;'>
                                  <strong>A fecha de:</strong> ".$today."
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                      <table style='width: 100%;' cellpadding='0' cellspacing='0' role='presentation'>
                        <tr>
                          <td colspan='2' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly;'>
                            <table style='width: 100%;' cellpadding='0' cellspacing='0' role='presentation'>
                              <tr>
                                <th align='left' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; padding-bottom: 8px;'>
                                  <p style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly;'>Descripción</p>
                                </th>
                                <th align='right' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; padding-bottom: 8px;'>
                                  <p style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly;'>Total</p>
                                </th>
                              </tr>
                              ".$products."
                              <tr>
                                <td style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; width: 80%;'>
                                  <p align='right' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; margin: 0; padding-right: 16px; text-align: right; font-size: 16px; font-weight: 700; line-height: 24px;'>
                                    Total
                                  </p>
                                </td>
                                <td style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; width: 20%;'>
                                  <p align='right' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; margin: 0; text-align: right; font-size: 16px; font-weight: 700; line-height: 24px;'>
                                    €".$total."
                                  </p>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                      <table align='right' style='margin-left: auto; margin-right: auto; width: 100%; text-align: center;' cellpadding='0' cellspacing='0' role='presentation'>
                        <tr>
                          <td align='right' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly;'>
                            <table style='margin-top: 24px; margin-bottom: 24px;' cellpadding='0' cellspacing='0' role='presentation'>
                              <tr>
                                <td align='right' style='mso-line-height-rule: exactly; mso-padding-alt: 16px 24px; border-radius: 4px; background-color: #4b7a6d; font-family: Montserrat, -apple-system, Segoe UI, sans-serif;'>
                                  <a href='https://sembrabiojoyas.es' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; display: block; padding-left: 24px; padding-right: 24px; padding-top: 16px; padding-bottom: 16px; font-size: 16px; font-weight: 600; line-height: 100%; color: #ffffff; text-decoration: none;'>Ir a la página &rarr;</a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                      <p style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; margin-top: 6px; margin-bottom: 20px; font-size: 16px; line-height: 24px;'>
                        Gracias,
                        <br>el equipo de SembraBiojoyas
                      </p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; height: 20px;'></td>
            </tr>
            <tr>
              <td style='mso-line-height-rule: exactly; padding-left: 48px; padding-right: 48px; font-family: Montserrat, -apple-system, Segoe UI, sans-serif; font-size: 14px; color: #eceff1;'>
                <p style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; color: #263238;'>
                  El uso de este sitio web está sujeto a nuestros
                  <a href='https://sembrabiojoyas.es' class='hover-underline' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; color: #7367f0; text-decoration: none;'>Términos de Uso</a> y a la
                  <a href='https://sembrabiojoyas.es' class='hover-underline' style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; color: #7367f0; text-decoration: none;'>Política de Privacidad</a>.
                </p>
              </td>
            </tr>
            <tr>
              <td style='font-family: Montserrat, sans-serif; mso-line-height-rule: exactly; height: 16px;'></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>";

    try {
        $mail->isSMTP(); 
        $mail->Host = 'mail.sembrabiojoyas.es'; 
        $mail->SMTPAuth = true;    
        $mail->Username = 'info@sembrabiojoyas.es';
        $mail->Password = 'kesiasembra';  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port = 465;
    
           // Correo para el comprador
          $mail->setFrom('info@sembrabiojoyas.es', 'Administracion SembraBiojoyas');
          $mail->addAddress($email, 'Comprador');
          $mail->isHTML(true);
          $mail->Subject = 'Resumen de tu pedido en SembraBiojoyas';
          $mail->Body    = $html;
          $mail->send();


          // Correo para el administrador

          $mail2->isSMTP(); 
          $mail2->Host = 'mail.sembrabiojoyas.es'; 
          $mail2->SMTPAuth = true;    
          $mail2->Username = 'info@sembrabiojoyas.es';
          $mail2->Password = 'kesiasembra';  
          $mail2->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
          $mail2->Port = 465;

          $mail2->setFrom('info@sembrabiojoyas.es', 'Administracion SembraBiojoyas');
          $mail2->addAddress('administracion@sembrabiojoyas.es', 'Administrador');
          $mail2->isHTML(true);
          $mail2->Subject = 'Nuevo pedido (#'.$orderId.') - Administracion SembraBiojoyas';
          $mail2->Body    = $html2;
          $mail2->send();

        $response = array('success' => true, 'message' => 'Compra exitosa');
        echo json_encode($response);
    } catch (Exception $e) {
        $response = array('success' => false, 'message' => "Error al intentar enviar el correo informativo: {$mail->ErrorInfo} {$mail2->ErrorInfo}");
        echo json_encode($response);
    }

?>