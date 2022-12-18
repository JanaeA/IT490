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
// require_once('/usr/share/php/libphp-phpmailer/src/PHPMailer.php');
// require_once('/usr/share/php/libphp-phpmailer/src/SMTP.php');
// require_once('/usr/share/php/libphp-phpmailer/src/Exception.php');
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
$client = new rabbitMQClient("rabbitmqphp_example/testRabbitMQ.ini","testServer");
if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

// creating 
$request = $_POST;
// $request['type'] = "likeBand"; //not needed until implement recommendation / add to profile page
$request['likedBand'] = $_POST['bands'];
$request['phonenumber'] = "9739809244"; // hard-coded due to SMS API limitations, buy a real provider
$request['email'] = $_POST['email'];

$theirFavBand = $_POST["bands"];
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

mail("dorongriffintann@gmail.com", $subject, $txt, $headers);

echo "<br><br>Mail has been sent if (1), fail if (0) $success";

function SMSSend(){
$service_plan_id = "bcc030066aac41bdb63399c0f3f8cc2c";
$bearer_token = "b561237e93cf43538fb96135028ccf8c";

//Any phone number assigned to your API
$send_from = "12064743796";
//May be several, separate with a comma ,
$recipient_phone_numbers = "19739809244"; 
$message = "Hey hey! You signed up for something musical, pretend I'm telling you all about it because without paying for a subscription, I can't send custom messages outside this dummy number";
//$message = "Test message to {$recipient_phone_numbers} from {$send_from}";

// Check recipient_phone_numbers for multiple numbers and make it an array.
if(stristr($recipient_phone_numbers, ',')){
  $recipient_phone_numbers = explode(',', $recipient_phone_numbers);
}else{
  $recipient_phone_numbers = [$recipient_phone_numbers];
}

// Set necessary fields to be JSON encoded
$content = [
  'to' => array_values($recipient_phone_numbers),
  'from' => $send_from,
  'body' => $message
];

$data = json_encode($content);

$ch = curl_init("https://us.sms.api.sinch.com/xms/v1/{$service_plan_id}/batches");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BEARER);
curl_setopt($ch, CURLOPT_XOAUTH2_BEARER, $bearer_token);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$result = curl_exec($ch);

if(curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    echo $result;
}
curl_close($ch);
}
SMSSend();

echo "SMS Sent?";
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