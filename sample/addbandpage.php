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
        <h1>Attempting to add the band <?php $_POST['bandAdd']; ?>.</h1>

        <?php
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

        $bandaddRequest = $_POST;
        $bandaddRequest['type'] = "addBand";
        $bandaddRequest['username'] = $_SESSION["username"];
        $bandaddRequest['bandtoAdd'] = $_POST['band'];
        $theBand = $_POST['band'];
        $bandResponse = $client->send_request($bandaddRequest);

        if ($response > 0){
            echo "You've added $theBand successfully!";
            header("refresh: 5, url=successpage.php");
            exit();
          
          }
          
          else if($response == 0){
              print_r("We went wrong somewhere. Printing response: $response");
              header("refresh: 3, url=successpage.php");
              exit();
          }
          ?>
        ?>

        
    </body>
</html>
<script>
    // function logoutFunction(){
    //     alert("We are trying to logout");
    // }
    //let logoutButton = document.getElementById("logoutButton");
    //logoutButton.addEventListener("click", logoutFunction);
    // let user = sessionStorage.getItem('login');
    // document.getElementById("theUserName").innerText = user;
    // //alert(user);
    // document.getElementById("theUser").value = user
    // document.getElementById("theUserTest").value = user;
</script>
