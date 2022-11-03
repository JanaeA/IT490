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
        <h1>Attempting to add the user <?php $_POST['friend']; ?>.</h1>

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

        $frenRequest = $_POST;
        $frenRequest['type'] = "addFriend";
        $frenRequest['username'] = $_SESSION["username"];
        $frenRequest['friendtoadd'] = $_POST['friend'];
        $theFriend = $_POST['friend'];
        $frenResponse = $client->send_request($frenRequest);

        if ($response > 0){
            echo "You've added $theFriend successfully!";
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
