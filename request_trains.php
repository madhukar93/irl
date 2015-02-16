<?php
require_once('trains_bw_stations.php');
$source = $_GET['source'];
$destination = $_GET['destination'];
$class = $_GET['cl'];
$day = $_GET['day'];
$month = $_GET['month'];

do{
	$trains = getTrains($source, $destination, $class, $day, $month);
}while(is_null($trains));

//var_dump($trains);
echo $trains;