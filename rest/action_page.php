<?php
	$email = $_POST['uname'];
	$passwort = $_POST['psw'];
			
	//Überprüfung des Passworts
	if ($email == 'admin' && $passwort == " "){
		include('admin_form.php');
	} else {
		header('Location: ../index.html');
    	exit();
	}
?>
