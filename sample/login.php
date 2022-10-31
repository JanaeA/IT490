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
echo "<p>GOT HERE</p>";
//$request = array();
$request = $_POST;
$request['type'] = "login";
$request['username'] = $_POST['userName'];
$request['password'] = $_POST['password'];
$userName = $request['username'];
//$request['bhocolate_bip_bookies'] = "chocolate";
$response = $client->send_request($request);
//$response = $client->publish($request);

echo "client received response: ".PHP_EOL;
print_r($response);
//echo $response;
echo "\n\n";
echo "<h1>help</h1>";
echo $argv[0]." END".PHP_EOL;

if ($response > 0){
  echo "<h2>good shit you're in bro (Response = $response)</h2>";
  echo "<script type='text/Javascript'>
  sessionStorage.setItem('login', '$userName');
  alert('This is a test!');
  </script>";
  session_start();
  $_SESSION['isLoggedIn'] = true;
  $_SESSION['username'] = $userName;
  header("refresh: 4, url=successpage.php");
  echo "<h5>I SHOULD BE EXECUTING</h5>";
  exit();
}
else if($response == 0){
  echo "<h2>your shit is wrong fam (Response = $response)</h2>";
  header("refresh: 2, url=register.html");
  exit();
}
else{
  echo "<h2>Something fucked up, our response is negative, or we didn't get one back (Response = $response)</h2>";
  header("refresh: 5, url=index.html");
  exit();
}

 ?>

