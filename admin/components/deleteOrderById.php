<?php 
	session_start();

	if(isset($_SESSION['id'])){
    include_once '../includes/db.php';

    if($_SERVER["REQUEST_METHOD"] === "POST"){
			$data = json_decode(file_get_contents("php://input"), true);
    	if (isset($data["order_id"])) {
				$response = array();
				$orderId = $data["order_id"];
				
				$verif = $conn->query("SELECT id from ventas where order_id='$orderId'");
				if($verif->num_rows>0){
					$upd = $conn->query("DELETE from ventas where order_id='$orderId'");
					if($upd){
						$response = array('success' => true, 'message' => 'Eliminado.');
					}else{
						$response = array('success' => false, 'message' => 'No encontramos el pedido que buscabas eliminar, probablemente ya esté eliminado.');
					}
				}else{
					$response = array('success' => false, 'message' => 'No encontramos el pedido que buscabas eliminar, probablemente ya esté eliminado.');
				}
			}else{
				$response = array('success' => false, 'message' => 'No encontramos el pedido que buscabas eliminar, probablemente ya esté eliminado.');
			}
    	echo json_encode($response);
    }else{
    	die();
    }

	}else{
		die();
	}
?>