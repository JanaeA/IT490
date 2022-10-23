<?php
error_reporting(E_ALL);
//ini_set('display_errors', 'ON');

echo "<p>What is life</p>";
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
$argv = "pain";
//$request = array();
$request = $_POST;
$request['type'] = "login";
$request['username'] = $_POST['userName'];
$request['password'] = $_POST['password'];
//$request['bhocolate_bip_bookies'] = "chocolate";
$response = $client->send_request($request);
//$response = $client->publish($request);

echo "client received response: ".PHP_EOL;
print_r($response);
//echo $response;
echo "\n\n";
echo "<h1>help</h1>";
echo $argv[0]." END".PHP_EOL;

if ($response == 5){
  header("refresh: 4, url=index.html");
  echo "good shit you're in bro";
  exit();
}
else if($response == 0){
  echo "your shit is wrong fam";
  header("refresh: 2, url=register.html");
  exit();
}

?>

