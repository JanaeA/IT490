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
//$request = array();
$request = $_POST;
$request['username'] = $_POST['userName'];
$request['type'] = "logout";
echo $request['username'];
//$request['bhocolate_bip_bookies'] = "chocolate";
$response = $client->send_request($request);
//$response = $client->publish($request);

echo "client received response: ".PHP_EOL;
print_r($response);
//echo $response;
echo "\n\n";
echo $argv[0]." END".PHP_EOL;

if ($response > 0){
  echo "<h2>good shit you're logging out (Response = $response)</h2>";
  header("refresh: 4, url=index.html");
  echo "<script type='text/Javascript'>
  sessionStorage.removeItem('login');
  alert('This is a test!');
  </script>";
  exit();
}
else if($response == 0){
  echo "<h2>why aren't we logging out (Response = $response)</h2>";
  header("refresh: 2, url=index.html");
  exit();
}
else{
  echo "<h2>Something fucked up, our response is negative, or we didn't get one back (Response = $response)</h2>";
  header("refresh: 5, url=index.html");
  exit();
}

?>

