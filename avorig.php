<?php

//require_once('pretty_print_json.php');

$url = 'www.indianrail.gov.in/cgi_bin/inet_accavl_cgi1.cgi';
$ch = curl_init($url);

$postFields = array (
	'lccp_conc'=>'ZZZZZZ',
	'lccp_quota'=>'GN',
	'lccp_day'=>'12',
	'lccp_month'=>'8',
	'lccp_classopt'=>'SL',
	'lccp_class1'=>'SL',
	'lccp_class2'=>'ZZ',
	'lccp_class3'=>'ZZ',
	'lccp_class4'=>'ZZ',
	'lccp_class5'=>'ZZ',
	'lccp_class6'=>'ZZ',
	'lccp_class7'=>'ZZ',
	'lccp_class8'=>'ZZ',
	'lccp_class9'=>'ZZ',
	'lccp_cls10'=>'ZZ',
	'lccp_age'=>'ADULT_AGE',
	'lccp_trndtl'=>'12722NZM HYB 0YYYYYYYA'

);

if (isset($_GET['lccp_trndtl'])){
		$postFields = array (
			'lccp_conc'=>'ZZZZZZ',
			'lccp_quota'=>'GN',
			'lccp_day'=>$_GET['day'],
			'lccp_month'=>$_GET['month'],
			'lccp_classopt'=>'SL',
			'lccp_class1'=>'SL',
			'lccp_class2'=>'ZZ',
			'lccp_class3'=>'ZZ',
			'lccp_class4'=>'ZZ',
			'lccp_class5'=>'ZZ',
			'lccp_class6'=>'ZZ',
			'lccp_class7'=>'ZZ',
			'lccp_class8'=>'ZZ',
			'lccp_class9'=>'ZZ',
			'lccp_cls10'=>'ZZ',
			'lccp_age'=>'ADULT_AGE',
			'lccp_trndtl'=>$_GET['lccp_trndtl']

		);
}

# Form data string
$postString = http_build_query($postFields);

$header = array (	
			'Host: www.indianrail.gov.in',
			'Connection: keep-alive',
			'Content-Length: '.strlen($postString), // MUST BE LENGTH OF POST STRING
			'Cache-Control: max-age=0',
			'Accept: text/html',
			'Origin: http://www.indianrail.gov.in',
			'User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537',
			'Content-Type: application/x-www-form-urlencoded', 
			'Referer: http://www.indianrail.gov.in/cgi_bin/inet_srcdest_cgi_date.cgi', // DIFFERENT 
			'Accept-Encoding: ',
			'Accept-Language: en-US,en;q=0.8'
	);


# Setting options
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1); 
curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1); 
// curl_setopt($ch, CURLOPT_VERBOSE, true);
// $verbose = fopen('php://temp', 'rw+');
// curl_setopt($ch, CURLOPT_STDERR, $verbose);

// USE ZZ FOR DEFAULT
$result = curl_exec($ch);
//echo $result;
curl_close($ch);
// if ($result === FALSE) {
//     printf("cUrl error (#%d): %s<br>\n", curl_errno($ch),
//            htmlspecialchars(curl_error($ch)));
// }

// rewind($verbose);
// $verboseLog = stream_get_contents($verbose);

// echo "<br><br>Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";

//echo $result;
error_reporting(E_ERROR | E_PARSE);
$dom    = new DOMDocument('1.0', 'UTF-8');  
$dom->loadHTML($result);
if($dom)
{
		$xpath = new DOMXPath($dom);


		$q = '///*[contains(concat(" ", normalize-space(@class), " "), " table_border ")]';


		$nodes = $xpath->query($q);

		foreach($nodes as $node){
    		$arr[] = $node;
}
		
		//foreach ($nodes as $node) 
	    //	echo $arr[0]->nodeValue."<br>";

		$nodes = $arr[1]->childNodes;

		$arr = array();
    	foreach($nodes as $node)
    		$arr[] = $node;// gives tbody
    	//====for value 
    	$nodes = $arr[0]->childNodes;
    	$arr = array();
    	foreach($nodes as $node)
    		$arr[] = $node;// gives tr
    	//var_dump($arr);

		$data = array();
				
		for($i = 1, $j = 0; $i < count($arr); $i++, $j++){
			$nodes = $arr[$i]->childNodes; 
			foreach($nodes as $node){
				if(!ctype_space($node->nodeValue)){
				 	$data[$j][] = $node->nodeValue;	
				 }
			}
		}
  	//var_dump($data); 
    $json =  json_encode($data);    	
   	echo $json;
		

}
else
echo "invalid DOMDocument <br>";
