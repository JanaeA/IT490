<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
    <body>
    <?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
$request = $_POST;
$request['type'] = "likeBand";
$request['likedBand'] = $_POST['bands'];
$theirFavBand = $_POST["bands"];
$request['email'] = $_POST['email'];
//$response = $client->send_request($request);

$to = "dg546@njit.edu";
$subject = "Your favorite band!!! $theirFavBand";
$txt = "Your favorite band has an upcoming event. Stay on the lookout";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8"."\r\n";

echo "<br> Your favorite band is $theirFavBand";
echo "<br>";
$success = mail($to, $subject, $txt, $headers);
if(!$success){
  print_r(error_get_last()['message']);
}

echo "Mail has been sent if (1), fail if (0) $success";

//$response = $client->publish($request);

//print_r($response);

// if ($response > 0){
//   echo "<h2>good shit you're in bro</h2>";

// }

// else if($response == 0){
//     print_r("We went wrong somewhere");
// }
?>
    </body>
</html>