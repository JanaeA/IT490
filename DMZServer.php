#!/usr/bin/php
<?php
require_once('rabbitmqphp_example/path.inc');
require_once('rabbitmqphp_example/get_host_info.inc');
require_once('rabbitmqphp_example/rabbitMQLib.inc');
//include('DMZ_functions.php');
require_once('lastFM.php');
require_once('serp.php');

function requestProcessor($request)
{
 // $apiKey = "f199b01d3295f26ab3086c39aeedde8e"
 // $lastfm = new LastFM($apiKey);
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {	
 	case "search":
		return doSearch($request['artist']);
	case "getInfo":
		$apiKey = "f199b01d3295f26ab3086c39aeedde8e";
		$lastfm = new LastFM($apiKey);
		$bio = $lastfm->getInfo($request['artist']);
		return print_r($bio, true);;
	case "getSimilar":
		$apiKey = "f199b01d3295f26ab3086c39aeedde8e";
                $lastfm = new LastFM($apiKey);
                $similar = $lastfm->getSimilar($request['artist']);
		return print_r($similar, true);;
	case "getEvents":
		$apiKey = "896b862ddd4b636adb811cd50570873a70a9a3cdd4849f50eeb06fcc22620cc9";
		$serp = new Serp($apiKey);
		$events = $serp->getEvents($request['location']);
		return print_r($events, true);

  }
  	
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}
//$apiKey = "f199b01d3295f26ab3086c39aeedde8e";
//$lastfm = new LastFM($apiKey);
$server = new rabbitMQServer("testRabbitMQ.ini","DMZServer");

$server->process_requests('requestProcessor');
exit();
?>

