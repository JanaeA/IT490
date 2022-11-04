<!DOCTYPE html>
<html>
<head></head>
    <body>
        <?php
        session_start();
        if (!isset($_SESSION['isLoggedIn'])) {
            echo "You weren't logged in! Go do it right..";
            header("refresh: 2, url=index.html");
            exit();
        }
        ?>
        <h1>Attempting to add the search events <?php $_POST['location']; ?>.</h1>

        <?php
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

        $eventRequest = $_POST;
        $eventRequest['type'] = "getEvents";
        $eventRequest['location'] = $_POST["location"];
        $theLocation = $_POST['location'];
        $eventResponse = $client->send_request($eventRequest);

        // print_r($eventResponse);
        // echo "Okay gamer mode";
        // foreach($eventResponse as $i => $i_value) {
        //   echo $i_value;
        //   echo $i_value->start_date;

        $testVar = json_decode($eventResponse, true);
        foreach($testVar["events_results"] as $key=> $value){
          $title = $testVar[$key]["title"];
          $start = $testVar[$key]["start_date"];
          $when = $testVar[$key]["when"];
          $address = $testVar[$key]["address"];
          $arrResponse = $testVar[$key];
         //print_r($key);
         
         //print_r($testVar["search_information"]);
         //print_r($value);
         print_r($value["title"]);
         echo " || ";
         print_r($value["date"]["when"]);
         echo " ==> ";
         print_r($value["address"][0]);
         echo "( ";
         print_r($value["address"][1]);
         echo " )";

         print_r($value[1]);
         //print_r($value["start_date"]);
         echo "<br/>";
          //print_r($arrResponse["title"]);

         
          //print_r($value["created_at"]);
          //print_r($value);
         // echo "$key\n";
          //echo "$value";
          //echo "$value\n";
          //echo "$testVar[$key]";
          //print_r("$title || $start || $when || $address donezies.\n\n\n $testVar[$key]");
      }
      echo "<br><br>";
        if ($eventResponse > 0){
            echo "You've searched $theLocation successfully!";
           // header("refresh: 5, url=successpage.php");
            //exit();
          
          }

          
          else if($eventResponse == 0){
              print_r("We went wrong somewhere. Printing response: $eventResponse");
              header("refresh: 3, url=successpage.php");
              exit();
          }


          ?>

          <form action="likesong.php" method="POST" id="likedsongform">
          <label for="bands">Choose a band to like:</label>
          <select name="bands">
            <?php foreach($testVar["events_results"] as $key=> $value): ?>
              <option value="<?= $value["title"];?>"><?= $value["title"];?></option>
              <?php endforeach; ?>
          </select>
          <input type="text" name="email" placeholder="Enter your email to be notified">
          <input type="submit" value="submit">
          </form>
    </body>
</html>
<script>
</script>
