<!DOCTYPE html>

<html>
    <body>
    <?php 
error_reporting(E_ALL);
echo "<p>What is life</p>";
require_once('rabbitmqphp_example/path.inc');
require_once('rabbitmqphp_example/get_host_info.inc');
require_once('rabbitmqphp_example/rabbitMQLib.inc');

$client = new rabbitMQClient("rabbitmqphp_example/testRabbitMQ.ini","DMZServer");
if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}
echo "<p>GOT HERE</p>";
$request = $_POST;
$request['type'] = "getInfo";
$request['artist'] = $_POST['band'];
$response = $client->send_request($request);
//$response = $client->publish($request);

echo "client received response: ".PHP_EOL;
print_r($response);
echo "<h1>help</h1>";
echo $argv[0]." END".PHP_EOL;

if ($response > 0){
  echo "<h2>good shit you're in bro</h2>";

}

else if($response == 0){
    print_r("We went wrong somewhere");
}
?>

    <h2>The Real French Stuff</h2>
    <ul class="playlist">
        <?php foreach($response->track as $k=>$v): ?>
            <li>
                <a href='<?php echo $v->url; ?>'>
                    <img src="<?php echo $v->image[2]; ?>" alt="image">
                    <span class="info">
                        <span class="artist"> <?php echo $v->artist; ?> </span>
                        <span class="name"> <?php echo $v->name; ?> </span>
                    </span>
                 </a>
            </li>
            <?php endforeach; ?>
    </ul>
    </body>
</html>