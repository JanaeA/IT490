<?php
error_reporting(E_ALL);
// ini_set('display_errors', 'ON');

echo "<p>Registration Page.?</p>";
require_once('rabbitmqphp_example/path.inc');
require_once('rabbitmqphp_example/get_host_info.inc');
require_once('rabbitmqphp_example/rabbitMQLib.inc');

$client = new rabbitMQClient("rabbitmqphp_example/testRabbitMQ.ini","testServer");
if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

//$request = array();
$request = $_POST;
$request['type'] = "register";
$request['username'] = $_POST['userName'];
$request['password'] = $_POST['password'];
//$request['register_chocolate_chip_cookies'] = "raisin";
$response = $client->send_request($request);
//$response = $client->publish($request);

echo "client received response: ".PHP_EOL;
print_r($response);


echo "\n\n";

if($response == 1){
  print_r("Registration is a success. Please login through the main page.");
  header("refresh: 5, url=index.html");
  exit();
}
else{
  print_r("Registration failed. The response was $response");
  header("refresh:3, url=index.html");
  exit();
}

?>
