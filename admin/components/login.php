<?php 
	session_start();

	if(isset($_SESSION['id'])){
		die();
	}else{
		$username = $_POST['username']??'';
		$password = $_POST['password']??'';

		if($username!='' && $password!=''){
			include_once '../includes/db.php';

			$user = $conn->query("SELECT * from users where username='$username'");

			if($user->num_rows>0){
				$user = $user->fetch_assoc();

				if(password_verify($password, $user['password'])){
					$_SESSION['id'] = $user['id'];
					header('location:../panel/');
				}else{
					$_SESSION['error'] = 'Contraseña incorrecta.';
				header('location:../');
				}
			}else{
				$_SESSION['error'] = 'No encontramos un usuario con esos datos.';
				header('location:../');
			}
		}else{
			header('location:../');
		}
	}
?>