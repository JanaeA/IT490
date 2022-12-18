#!/usr/bin/php
<?php
require_once('rabbitmqphp_example/path.inc');
require_once('rabbitmqphp_example/get_host_info.inc');
require_once('rabbitmqphp_example/rabbitMQLib.inc');
include('DB_functions.php');

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
      return doLogin($request['username'],$request['password']);
    case "register":
      return doRegister($request['username'],$request['password']);
    case "validate_session":
	    return doValidate($request['username'],$request['sessionId']);
    case "logout":
	    return doLogout($request['username']);
    case "addFriend":
	    return addFriend($request['username'],$request['friendtoadd']);
    case "addReview":
	    return addReview($request['user'],$request['title'],$request['text']);
    case "getFriends":
	    return getFriends($request['username']);
    case "getReview":
	    return getReview($request['username']);

  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>

