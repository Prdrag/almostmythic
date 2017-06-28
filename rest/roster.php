<?php
  $settings = file_get_contents('settings.json');
  $settings_file = json_decode($settings, true);
  $server = $settings_file['server'];
  $guildname = $settings_file['guildname'];

  //Get Data from Armory
  $requestURL = 'https://eu.api.battle.net/wow/guild/blackhand/almost%20mythic?fields=members&locale=en_US&apikey=wb9rb9bxp2w53hvp2mn5gvc4a5rzm7v4';
  $curl = curl_init();
  curl_setopt_array($curl, array(
  CURLOPT_URL => $requestURL,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);


  curl_close($curl);

  if ($err) {
      return "cURL Error #:" . $err;
  } else {
      $inhalt = json_decode($response, true);
  }

  class Member {
    public $name;
    public $class;
    public $level;
    public $thumbnail;
    public $spec;
    public $role;
    // public $ilvl;
  }

    function rank_name($rank_name){
      switch ($rank_name) {
        case 0:
          return 'Gildenmeister';
          break;
        case 1:
          return 'Offizier';
          break;
        case 2:
          return 'Offizier Twink';
          break;
        case 3:
          return 'Raidmember';
          break;
        case 4:
          return 'Anwärter';
          break;
        case 5:
          return 'MVP';
          break;
        case 6:
          return 'Twink';
          break;
        case 7:
          return 'Friend';
          break;
        default:
          return '';
          break;
      }
    }
    function class_name($class_name){
      switch ($class_name) {
        case 1:
          return 'warrior';
          break;
        case 2:
          return 'paladin';
          break;
        case 3:
          return 'hunter';
          break;
        case 4:
          return 'rogue';
          break;
        case 5:
          return 'priest';
          break;
        case 6:
          return 'deathknight';
          break;
        case 7:
          return 'shaman';
          break;
        case 8:
          return 'mage';
          break;
        case 9:
          return 'warlock';
          break;
        case 10:
          return 'monk';
          break;
        case 11:
          return 'druid';
          break;
        case 12:
          return 'demonhunter';
          break;        
        default:
          return '';
          break;
      }

    }

    function wow_items($name){
        $url2 = 'https://eu.api.battle.net/wow/character/blackhand/'.$name.'?fields=items&locale=de_DE&apikey=ep33rug24j2ua8kqw6jyutspycjx6q5n';
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url2,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => "HEAD",
        CURLOPT_NOBODY => false,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);


        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            $items_json = json_decode($response, true);
        }
        return ($items_json);
    }

    function checkRank($rank){
        switch ($rank) {
          case 0:
            return true;
            break;
          case 1:
            return true;
            break;
          case 2:
            return false;
            break;
          case 3:
            return true;
            break;
          case 4:
            return true;
            break;
          case 5:
            return true;
            break;
          case 6:
            return false;
            break;
          case 7:
            return false;
            break;
          default:
            return false;
            break;
        }
    }


  $roster=array();
  $guildmember = array();
  // print_r($output);

  foreach ($inhalt['members'] as $member) {
    $rank = $member['rank'];
    $checked_rank = checkRank($rank);
    if ($checked_rank == true) {
      if ($member['character']['level'] == 110){
        $m=new Member();

        $m->classid=$member['character']['class'];
        $m->name=$member['character']['name'];
                // $char_item = wow_items($m->name);
                // $ilvl_json = $char_item;
                // $ilvl_array = $ilvl_json['items']['averageItemLevel'];


        $m->class=class_name($member['character']['class']);    
        $m->level=$member['character']['level'];  
        $m->rang=rank_name($member['rank']);
        $m->thumbnail=$member['character']['thumbnail'];
        if ($member['character']['spec'] == null){
            $m->spec = "---";
            $m->role = "---";
        }
        else{
            $m->spec = $member['character']['spec']['name'];
            $m->role = $member['character']['spec']['role'];
        }

        // $m->ilvl= $ilvl_array;
        $guildmember[]=$m;
        // echo $m;
        // print_r($m);
      }
    }
  }
  $roster['timestamp'] = $inhalt['lastModified'];
  // $roster['message'] = ('{"status": "ok", "message": "roster has been updated"}');
  $roster['members'] = $guildmember;
  $jsonObject = json_encode($roster);
  file_put_contents('roster.json', $jsonObject);
  header('Content-Type: application/json');
  echo ($jsonObject); 
?>
