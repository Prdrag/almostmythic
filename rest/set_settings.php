<?php
	$server = $_POST['server'];
	$guildname = $_POST['guildname'];
	$username = $_POST['username'];
	$abouttext = $_POST['abouttext'];
	$newstext = $_POST['newstext'];

	$settings = array();

	$settings['server'] = $server;
	$settings['abouttext'] = $abouttext;
	$settings['newstext'] = $newstext;
	$settings['guildname'] = $guildname;
	$settings['username'] = $username;

	$jsonObject = json_encode($settings, JSON_UNESCAPED_UNICODE);
	// echo json_encode($settings);
	file_put_contents('settings.json', $jsonObject);
	header('Location: action_page.php');
    exit();  
?>