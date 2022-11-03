#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


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
    case "error":
      return doErrorLogging($request['message']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}
function doErrorLogging($message){
  $filename = "errorLogging.txt";
  $newline = "\n\n";
  $contents = "$message\r\n";
  
  if(!is_file($filename)){
    file_put_contents($filename, $contents, FILE_APPEND);
    echo "File $filename did not exist and has been created. $contents has been added to the file.";

  }
  else{
    file_put_contents($filename, $contents, FILE_APPEND);
    echo "File $filename has been created. $contents has been added to the file.";
  }
  return "Exiting the function";

}

$server = new rabbitMQServer("testRabbitMQ.ini","ErrorServer");

$server->process_requests('requestProcessor');
exit();
?>

