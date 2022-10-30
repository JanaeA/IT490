#!/usr/bin/php
<?php
require_once('rabbitmqphp_example/path.inc');
require_once('rabbitmqphp_example/get_host_info.inc');
require_once('rabbitmqphp_example/rabbitMQLib.inc');
//include('DMZ_functions.php');
require_once('lastFM.php');

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
		return $bio;
	case "getSimilar":
		$apiKey = "f199b01d3295f26ab3086c39aeedde8e";
                $lastfm = new LastFM($apiKey);
                $similar = $lastfm->getSimilar($request['artist']);
                return $similar;

  }
  	
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}
//$apiKey = "f199b01d3295f26ab3086c39aeedde8e";
//$lastfm = new LastFM($apiKey);
$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>

