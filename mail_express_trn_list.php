<?php
require_once("db.php");
$url = 'http://www.indianrail.gov.in/mail_express_trn_list.html';
$ch = curl_init($url);

set_time_limit(600);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
//echo $result;
error_reporting(E_ERROR | E_PARSE);
$dom    = new DOMDocument('1.0', 'UTF-8');  
$dom->loadHTML($result);
if($dom)
{
		$xpath = new DOMXPath($dom);


		$q = '///*[contains(concat(" ", normalize-space(@class), " "), " table_border ")]/tr';

        
		$nodes = $xpath->query($q);
		foreach($nodes as $tr){	// DOMNodesList implements traversable 
    		echo "<br>";
    		$tds = $tr->childNodes;
            $i = 0;
    		foreach($tds as $td){
    			$arr[$i]=$td->nodeValue;
                $i++;
    		}
            //var_dump($arr);
            //echo"<br><=====><br>";
            //echo ""
            mysqli_query($con,"INSERT INTO `irl`.`trains` (`TrainNo`, `TrainName`, `Origin`, `DepartureTime`, `Destination`, `ArrivalTime`) 
                                VALUES ('$arr[0]', '$arr[1]', '$arr[2]', '$arr[3]', '$arr[4]', '$arr[5]');") or die(mysqli_error($con));
    	}

}
else
echo "invalid DOMDocument <br>";
