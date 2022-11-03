<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
    <body>
    <?php 
error_reporting(E_ALL);
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
$headers = "From: dg546@njit.edu" ."\r\n" . "CC : whoelse@example.com";

mail($to, $subject, $txt, $headers);
//$response = $client->publish($request);

echo "client received response: ".PHP_EOL;
//print_r($response);
echo $argv[0]." END".PHP_EOL;

// if ($response > 0){
//   echo "<h2>good shit you're in bro</h2>";

// }

// else if($response == 0){
//     print_r("We went wrong somewhere");
// }
?>
    </body>
</html>