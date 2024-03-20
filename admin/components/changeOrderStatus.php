<?php
session_start();

if (isset($_SESSION['id'])) {
	include_once '../includes/db.php';

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$data = json_decode(file_get_contents("php://input"), true);

		if (isset($data["order_id"])) {
			$orderId = $data["order_id"];
			$response = array();
			$verif = $conn->query("SELECT id,status from ventas where order_id='$orderId'");
			if ($verif->num_rows > 0) {
				$order = $verif->fetch_assoc();
				$estado = $order["status"];

				switch($order["status"]){
					case "pending" : $estado = "preparing"; break;
					case "preparing" : $estado = "incoming"; break;
					case "incoming" : $estado = "delivered"; break;
					case "delivered" : $estado = "pending"; break;
					default : $estado = "Finalizado"; break;
				};

				$upd = $conn->query("UPDATE ventas SET status = '$estado' WHERE order_id = '$orderId'");
				if ($upd) {
					$response = array('success' => true, 'message' => 'Edición completada.', 'newstatus' => $estado);
				} else {
					$response = array('success' => false, 'message' => 'No encontramos el pedido que buscabas modificar, probablemente fue eliminado.');
				}
			} else {
				$response = array('success' => false, 'message' => 'No encontramos el pedido que buscabas modificar, probablemente fue eliminado.');
			}

			echo json_encode($response);
		} else {
			die();
		}
	} else {
		die();
	}

} else {
	die();
}
?>