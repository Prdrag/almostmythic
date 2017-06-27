<?php
	$settings = file_get_contents('settings.json');
	$settings_file = json_decode($settings, true);
	$server = $settings_file['server'];
	$guildname = $settings_file['guildname'];

	// $server = 'UnGoro';
	// $guild = 'Less QQ more PewPew';

	//Get Data from Armory
	$url = 'https://www.warcraftlogs.com/v1/reports/guild/'.rawurlencode($guildname).'/'.rawurlencode($server).'/EU?start=1462125214112&api_key=c83b428b99eb354b1b75d4c4f33080ea';
	// $url = 'https://www.warcraftlogs.com:443/v1/reports/guild/Less%20QQ%20more%20PewPew/UnGoro/EU?start=1462125214112&api_key=c83b428b99eb354b1b75d4c4f33080ea';
	$data=file_get_contents($url);
	$json=json_decode($data, TRUE);
	echo $url;

	//Get Data from roster.json
	$json_file = file_get_contents('logs.json');
	$json_a = json_decode($json_file, true);

	$jsonObject = json_encode($json);
	file_put_contents('logs.json', $jsonObject);
	echo ($jsonObject);
	// Status Code for response    
	// header('Location: ../index.html?update=OK');
	// exit();  
?>