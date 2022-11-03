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
        $frenRequest['type'] = "getFriends";
        $frenRequest['username'] = $_SESSION["username"];
        $frenResponse = $client->send_request($frenRequest);

        // $bandRequest = $_POST;
        // $bandRequest['type'] = "getBands";
        // $bandRequest['username'] = $_SESSION["username"];
        // $bandResponse = $client->send_request($bandRequest);
        //$response = $client->publish($request);
        ?>

        <h1>We have successfully logged in.</h1>
        <h2>User Profile Page <br> Welcome To Our Site, User:  <?php print_r($_SESSION["username"]); ?></h2>
        <form name="frmUser" method="post" action="logout.php" id="theForm" >
            <label for="logoutButton">Click me and we will logout.</label>
            <input type="button" name="logout" value="Logout" id="logoutButton">
            <input type="submit" name="submit" value="Submit" class="full-width ">
        </form>
        <br>
        <br>
        </div>

        <div>
        <p>Current Friends: <?php print_r(var_dump(json_decode($frenResponse)));?></p>
        <p> <?php print_r($frenResponse);?></p>
        <br><br>
        <p>Current Favorite Bands: <?php // print_r($bandResponse)?></p>
        </div>

        <div class="search-container">
            <p>Attempt to search for bands here</p>
    	<form action="searchpage.php" method="POST">
      	<input type="text" placeholder="Search for bands!" name="band">
      	<input type="submit" value="submit">
    	</form>

        <div class="search-container">
            <p>Attempt to add friends here, woo!</p>
    	<form action="friendpage.php" method="POST">
      	<input type="text" placeholder="Add a friend!" name="friend">
      	<input type="submit" value="submit">
    	</form>

        <div class="search-container">
            <p>Add your favorite band here!</p>
    	<form action="bandadd.php" method="POST">
      	<input type="text" placeholder="Add a favorite band!" name="bandAdd">
      	<input type="submit" value="submit">
    	</form>

        <div class="search-container">
            <p>Look for nearby concerts!</p>
    	<form action="searchconcert.php" method="POST">
      	<input type="text" placeholder="Your Location" name="location">
      	<input type="submit" value="submit">
    	</form>

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
