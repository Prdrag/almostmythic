<?php
	$email = $_POST['uname'];
	$passwort = $_POST['psw'];
			
	//Überprüfung des Passworts
	if ($email == 'admin' && $passwort == "!almost2017"){
		include('admin_form.php');
	} else {
		header('Location: ../index.html');
    	exit();
	}
?>