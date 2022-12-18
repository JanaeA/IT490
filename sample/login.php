<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf=8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>        
        
    </head>
<?php
error_reporting(E_ALL);
//ini_set('display_errors', 'ON');

echo "<div class='container'><p>Attempting login.</p>>/div>";
require_once('rabbitmqphp_example/path.inc');
require_once('rabbitmqphp_example/get_host_info.inc');
require_once('rabbitmqphp_example/rabbitMQLib.inc');

$client = new rabbitMQClient("rabbitmqphp_example/testRabbitMQ.ini","testServer");
// $errorClient = new rabbitMQClient("rabbitmqphp_example/testRabbitMQ.ini","ErrorServer");
// $sampleRequest['type'] = "error";
// $sampleRequest['message'] = "User duplicate already logged in";
// $response = $client->publish($sampleRequest);


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
$userName = $request['username'];
//$request['bhocolate_bip_bookies'] = "chocolate";
$response = $client->send_request($request);
//$response = $client->publish($request);
echo "<div class='container'>";
echo "<p>client received response: </p>".PHP_EOL;
//print_r($response);
echo "<span>$response</span>";
echo "\n\n";
echo "<p>Respond from server: " .$argv[0] ." END</p>".PHP_EOL;
echo "</div>";

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

