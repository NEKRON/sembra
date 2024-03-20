<?php 
	session_start();

	if(isset($_SESSION['id'])){
		$prodId = $_REQUEST['prodId']??'';

		if($prodId!=''){
			include_once '../includes/db.php';

			$product = $conn->query("SELECT * from products where id='$prodId'");

			if($product->num_rows>0){
				$product = $product->fetch_assoc();

				if($product['photo']!=''){
					unlink('../../assets/img/products/'.$product['photo']);
				}

				$delete = $conn->query("DELETE from products where id='$prodId'");

				if($delete){
					$_SESSION['success'] = 'El producto se eliminó correctamente.';
					header('location:../panel/?mod=products');
				}else{
					$_SESSION['error'] = 'Hubo un error de servidor, intenta nuevamente más tarde.';
					header('location:../panel/?mod=products');
				}
			}else{
				$_SESSION['error'] = 'El producto que buscababas ya no existe.';
				header('location:../panel/?mod=products');
			}
		}else{
			die();
		}
	}else{
		die();
	}
?>