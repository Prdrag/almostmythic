<?php
  $settings = file_get_contents('settings.json');
  $settings_file = json_decode($settings, true);
  $server = $settings_file['server'];
  $username = $settings_file['username'];

  $url = 'https://eu.api.battle.net/wow/character/'.rawurlencode($server).'/'.rawurlencode($username).'?fields=progression&locale=de_DE&apikey=wb9rb9bxp2w53hvp2mn5gvc4a5rzm7v4';
  $data=file_get_contents($url);
  $json=json_decode($data, TRUE);
  // echo $url;

  //Get Data from progress.json
  $json_file = file_get_contents('progress.json');
  $json_a = json_decode($json_file, true);

  //Get both Timestamps
  $last_timestamp = $json_a['timestamp'];
  $current_timestamp = $json['lastModified'];
  @$update = $_GET["forceupdate"];

  //checktimestamps an do an update
  if (($last_timestamp !== $current_timestamp) OR ($update === 'true')){
    class Progress {
      public $name;
      public $id;
      public $nhc=0;
      public $hc=0;
      public $m=0;
      public $bosses=0;
    }

    $prog_complete = array();
    $prog = array();

    foreach ($json['progression']['raids'] as $raid) {
      $p=new Progress();
      $p->name=rawurlencode($raid['name']);
      $p->id=$raid['id'];

      if ($raid['id'] == 8025 OR $raid['id'] == 8026 OR $raid['id'] == 8440 OR $raid['id'] == 8524){
        foreach ($raid['bosses'] as $boss) {
          if ($boss['normalKills']>0) {$p->nhc=$p->nhc+1;}
          if ($boss['heroicKills']>0) {$p->hc=$p->hc+1;}
          if ($boss['mythicKills']>0) {$p->m=$p->m+1;}
        }
        switch($raid['id']) {
          case 8025:  //Nachtfestung
            $p->bosses=10;
            $prog[]=$p;
            break;
          case 8026:  //Smaragdgrüne Apltraum
            $p->bosses=7;
            $prog[]=$p;
            break;
          case 8440:  //TOF
            $p->bosses=3;
            $prog[]=$p;
            break;
          case 8524:  //tos
            $p->bosses=9;
            $prog[]=$p;
            break;
        }
      }
    }

    $prog_complete['timestamp'] = $json['lastModified'];
    $prog_complete['raids'] = $prog;
    $jsonObject = json_encode($prog_complete);
    file_put_contents('progress.json', $jsonObject);
    echo $jsonObject;
    // header('Location: ../index.html');
    // exit();
  }
  else{
    //Status Code for response
    echo ('{"status": "nok", "error": "Timestamp has not changed"}');
  }
?>
