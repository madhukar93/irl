<?php

// $source = $_GET['source'];
// $destination = $_GET['destination'];
// $class = $_GET['cl'];
// $day = $_GET['day'];
// $month = $_GET['month'];
error_reporting(0);
$data = array(
    'lccp_src_stncode' => 'ndls',
    'lccp_dstn_stncode' => 'hyb',
    'lccp_classopt' => 'SL',
    'lccp_day' => '14',
    'lccp_month' => '11'
);

# Create a connection
$url = 'www.indianrail.gov.in/cgi_bin/inet_srcdest_cgi_date.cgi';
$ch = curl_init($url);

# Form data string
$postString = http_build_query($data);

echo $postString."<br>";
//echo "lccp_src_stncode=NDLS&lccp_dstn_stncode=HYB&lccp_classopt=SL&lccp_day=4&lccp_month=9<br>";

//SETTING HTTP HEADERS 
/*
POST http://www.indianrail.gov.in/cgi_bin/inet_srcdest_cgi_date.cgi HTTP/1.1
Host: www.indianrail.gov.in
User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36
Referer: http://www.indianrail.gov.in/know_Station_Code.html

lccp_src_stncode_dis=ndls&lccp_dstn_stncode=HYB&lccp_classopt=SL&lccp_day=4&lccp_month=11
*/
$header = array (   
            'Host: www.indianrail.gov.in',
            'Connection: keep-alive',
            'Content-Length: '.strlen($postString),
            'User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36',
            'Referer: http://www.indianrail.gov.in/know_Station_Code.html',
    );

# Setting options
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1); 
curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

//FOR DEBUGGING CONNECTION :
curl_setopt($ch, CURLOPT_VERBOSE, true);
$verbose = fopen('php://temp', 'rw+');
curl_setopt($ch, CURLOPT_STDERR, $verbose);
# Get the response
curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode("lccp_src_stncode_dis=ndls&lccp_dstn_stncode=HYB&lccp_classopt=SL&lccp_day=26&lccp_month=6"));

$result = curl_exec($ch);

curl_close($ch);

if ($result === FALSE) {
    printf("cUrl error (#%d): %s<br>\n", curl_errno($ch),
           htmlspecialchars(curl_error($ch)));
}

//FOR DISPLAYING VERBOSE LOG :
rewind($verbose);
$verboseLog = stream_get_contents($verbose);

echo "<br><br>Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";


error_reporting(E_ERROR | E_PARSE);
echo $result;
