<?php
require_once('availability.php');
$day = $_GET['day'];
$month = $_GET['month'];
$lccp_trndtl=$_GET['lccp_trndtl'];
$name=$_GET['number'];
$num=$_GET['name'];
do{
	$av = getAvailability($day, $month, $lccp_trndtl,$name,$num);
 }while(is_null($av));

//var_dump($trains);
echo $av;