<?php
//////////////////////////////////////////////////////////////////////
//
//      Projekt:   a other... old stuff :-)
//      Datei:     main.php
//      Version:   see $config['mainversion']
//      Datum:     21.02.2009
//      Author:    Martin
//      Descr.:    old....
//      license:   use it, but not comercial
//
//////////////////////////////////////////////////////////////////////
error_reporting(E_ALL);
ini_set('display_errors', 'on');
# you used it only on your own server/shell :-) no Problem
ini_set('max_execution_time', 0);
ini_set('memory_limit', '1500M');
@date_default_timezone_set(date_default_timezone_get());


if(!file_exists('./config.inc.php'))
  {
    exit("\nERROR, please set your Settings in config.inc.php\n");
  }
require_once './config.inc.php';

if(!file_exists($config['home'].'Filestuff.class.php'))
  {
    exit("\nERROR: File classes/Filestuff.class.php NOT found!\n");
  }
@require_once $config['home'].'Filestuff.class.php';


ob_implicit_flush(true);
@ob_end_flush();


$pfad = $config['home'].$config['googlefitdir'];
if(!is_dir($pfad))
  {
    die('dir not found: '.$pfad);
  }


# Started Programm with all required variables
# quick and dirty
function object2array($object) { return @json_decode(@json_encode($object),1); }

if(file_exists('./lastimport-time.txt'))
  {
    $laststart = file_get_contents('./lastimport-time.txt');
  }

$last = $laststart;
$i    = 0;
$fd   = opendir($pfad);
while($file = readdir($fd))
  {
    if(($file == '.') || ($file == '..'))
          {
            continue;
          }
    $content   = file_get_contents($pfad.$file);
        $movies    = simplexml_load_string($content);
        foreach($movies->Activities->Activity as $key => $values)
          {
            $xml_array = @object2array($values);
            if(!isset($xml_array['Lap']['@attributes']['StartTime']))
          {
            continue;
          }
        $id     = $xml_array['Id'];
        $start  = $xml_array['Lap']['@attributes']['StartTime'];
        $dauer  = round($xml_array['Lap']['TotalTimeSeconds']/60, 0);
        $distanz= round($xml_array['Lap']['DistanceMeters'], 0);
        if(($dauer >= 100) && ($distanz <= 1000))
          {
            if(($dauer >= $distanz) || ($dauer >= 555))
              {
                # it looks the timeframe is false
                echo "\n\nPlease verify the following entry, that you walked so long and fix it manually\nI import it....\n";
                echo "Duration OLD:    ".$dauer."\n";
                $dauer = $dauer / 60;
                echo "Duration NEW:     ".$dauer."\n";
                echo "Meters:           ".$distanz."\n";
                # yes, you can walked over 555 Minutes...
                sleep(5);
             }
          }
        $typ    = $xml_array['Notes'];
        $time     = date_parse($start);
        $unixtime = mktime($time['hour'], $time['minute'], $time['second'], $time['month'], $time['day'], $time['year']);
        if((isset($laststart)) && ($laststart >= $unixtime))
          {
            continue;
          }
        if(($dauer < $config['mindauer']) && ($distanz < $config['minmeters']))
          {
            continue;
          }
        if($last < $unixtime)
          {
            $last = $unixtime;
          }
        $return[$id] = array(
                                                 'eventType' => 'Exercise',
                                                 'duration' => $dauer,
                                                 'notes' => $distanz.'M '.$xml_array['Notes'],
                                                 'enteredBy' => 'Google-Fit',
                                                 'insulin' => '',
                                                 'carbs' => '',
                                                 'glucose' => '',
                                                 'NSCLIENT_ID' => 'Google-Fit',
                                                 'created_at' => $start
                                                 );
        $json[$id] = json_encode($return[$id]);
        # or use curl/wget/xxxx to send it to the ns-api
        $curl   = new FileStuff($config);
                  $curl->SetPostData($json[$id]);
        $send   = $curl->GetRemoteData($config['apiurl'].$config['apiadd']);
        if($send == 'ERROR')
          {
            echo "\n\nERROR:\n\n";
            print_r($curl->GetError());
            die();
          }
        else
          {
            # debug json string
            echo $i.":    ".$json[$id]."\ndone\n\n";
            $i++;
          }
      }
  }
if((!isset($last)) || ($i === 0))
  {
    $last = ''.time().'';
    $i    = '0 "no newer then lastimport-time.txt"';
  }
file_put_contents('./lastimport-time.txt', $last-100);
die("\n\n".'End imported '.$i.' "actions/laps/actions/walkes/xxx" :-)');

# End
