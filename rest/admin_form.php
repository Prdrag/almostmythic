<?php
	//Get Data from roster.json
	$json_file = file_get_contents('settings.json');
	$json_a = json_decode($json_file, true);

	if ($json_a['server'] == ''){
		$server = 'blackhand';
	}
	else{
		$server = $json_a['server'];
	}
	if ($json_a['username'] == ''){
		$username = 'Bäronk';
	}
	else{
		$username = $json_a['username'];
	}
	if ($json_a['guildname'] == ''){
		$guildname = 'Almost mythic';
	}
	else{
		$guildname = $json_a['guildname'];
	}

	if ($json_a['abouttext'] == ''){
		$abouttext = '...';
	}
	else{
		$abouttext = $json_a['abouttext'];
	}

	if ($json_a['newstext'] == ''){
		$newstext = '...';
	}
	else{
		$newstext = $json_a['newstext'];
	}
?>
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" href="../assets/css/main.css" />
		<link rel="stylesheet" href="../assets/css/extension.css" />
	</head>
	<body>	
	<form action="set_settings.php" method="post" style="width:50%; margin: 40px auto">
		<h1>Einstellungen für Almost Mythic</h1>
		<label>Servername für den Import:</label>
		<input type="text" name="server" id="server" value="<?php echo $server;?>" class="shortfield"/><br/>	  
		<br>
		<label>Gildenname:</label>
		<input type="text" name="guildname" value="<?php echo $guildname;?>">
		<br>
		<label>Charaktername für den Progress:</label>
		<input type="text" name="username" value="<?php echo $username;?>">
		<br><br>
		<label>Über Uns Text:</label>
		<textarea name="abouttext" style="height: 400px"><?php echo $abouttext;?></textarea>
		<br><br>
		<label>News text:</label>
		<textarea name="newstext" style="height: 400px"><?php echo $newstext;?></textarea>
		<br><br>
		<input type="submit" value="Submit">
	</form>
	</body>
	</html>