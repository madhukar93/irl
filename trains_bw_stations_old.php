<?php

function getTrains($source, $destination, $class, $day, $month){
// $source = $_GET['source'];
// $destination = $_GET['destination'];
// $class = $_GET['cl'];
// $day = $_GET['day'];
// $month = $_GET['month'];
error_reporting(0);
$data = array(
    'lccp_src_stncode' => $source,
    'lccp_dstn_stncode' => $destination,
    'lccp_classopt' => $class,
    'lccp_day' => $day,
    'lccp_month' => $month
);

# Create a connection
$url = 'www.indianrail.gov.in/cgi_bin/inet_srcdest_cgi_date.cgi';
$ch = curl_init($url);

# Form data string
$postString = http_build_query($data);

//echo $postString."<br>";
//echo "lccp_src_stncode=NDLS&lccp_dstn_stncode=HYB&lccp_classopt=SL&lccp_day=4&lccp_month=9<br>";

//SETTING HTTP HEADERS 
$header = array (	
			'Host: www.indianrail.gov.in',
			'Connection: keep-alive',
			'Content-Length: '.strlen($postString),
			'Cache-Control: max-age=0',
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
			'Origin: http://www.indianrail.gov.in',
			'User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36',
			'Content-Type: application/x-www-form-urlencoded',
			'Referer: http://www.indianrail.gov.in/know_Station_Code.html',
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

//FOR DEBUGGING CONNECTION :
//curl_setopt($ch, CURLOPT_VERBOSE, true);
// $verbose = fopen('php://temp', 'rw+');
// curl_setopt($ch, CURLOPT_STDERR, $verbose);
//# Get the response
//curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode("lccp_src_stncode_dis=ndls&lccp_dstn_stncode=HYB&lccp_classopt=SL&lccp_day=26&lccp_month=6"));

$result = curl_exec($ch);

curl_close($ch);

// if ($result === FALSE) {
//     printf("cUrl error (#%d): %s<br>\n", curl_errno($ch),
//            htmlspecialchars(curl_error($ch)));
// }

//FOR DISPLAYING VERBOSE LOG :
// rewind($verbose);
// $verboseLog = stream_get_contents($verbose);

// echo "<br><br>Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";

// $result;
error_reporting(E_ERROR | E_PARSE);
//echo $result;
$result = preg_replace( '/\s+/', ' ', $result );
$dom    = new DOMDocument('1.0', 'UTF-8');  
$dom->loadHTML($result);
if($dom)
{
		$xpath = new DOMXPath($dom);

		$q = '///*[contains(concat(" ", normalize-space(@class), " "), " table_border_both_left ")]';


		$nodes = $xpath->query($q);

		foreach($nodes as $node)	// DOMNodesList implements traversable 
    		$arr[] = $node; // EACH TABLE WITH CLASS table_border_both_left

		$nodes = $arr[0]->childNodes; // FIRST TABLE WITH CLASS table_border_both_left => its children(rows) 


		$arr = array();
    	foreach($nodes as $node)
    		$arr[] = $node;// EACH ROW

		//$nodes = $arr[2]->childNodes;  	// children of first row 
		// NEED arr[2] and onwards
		$data = array();

				
		for($i = 2, $j = 0; $i < count($arr); $i++, $j++){
			$nodes = $arr[$i]->childNodes; //arr[i] => row : tr ,childnodes are its children => td, I want input in td
			$data[$j][] = $arr[$i]->firstChild->firstChild->getAttribute('value');
			foreach($nodes as $node){
				//$inputNode = $xpath->query('input', $nodes);
				//echo $inputNode->getAttribute('value');
				if($node->nodeValue != ' ') // ctype_space() problematic,due non breaking whitespace i guess
				 	$data[$j][] = $node->nodeValue;	
			}
		}
		if(!empty($data))
			return json_encode($data);
		else
			return null;		

}
else
return null;
}