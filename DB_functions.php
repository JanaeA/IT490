<?php

function doValidate($username, $sessionId) {
        $mydb = new mysqli('127.0.0.1','testUser','12345','sessions');

        if ($mydb->errno != 0)
        {
                echo "failed to connect to database: ". $mydb->error . PHP_EOL;
                exit(0);
        }

	$statement = "select * from sessions where user = '$username'";
	$response = $mydb->query($statement);

	while ($row = $response->fetch_assoc()) {
		if ($row["sessionId"] == $sessionId) {
			return 1; // user authenticated
		}
		echo "Wrong session key!";
		return 0;
	}
	echo "User session does not exist!";
	return 0;

}

function doRegister($username,$password)
{
	$mydb = new mysqli('127.0.0.1','testUser','12345','logininfo');

	if ($mydb->errno != 0)
	{
        	echo "failed to connect to database: ". $mydb->error . PHP_EOL;
        	exit(0);
	}

        $statement = "select * from login where user = '$username'";
        $response = $mydb->query($statement);

        while ($row = $response->fetch_assoc())
        {
		echo "Username is already in the table, pick a different username";
		$errorClient = new rabbitMQClient("rabbitmqphp_example/testRabbitMQ.ini","ErrorServer");
		$sampleRequest['type']="error";
		$sampleRequest['message']="User duplicate already loggedin";
		$errorResponse = $errorClient->publish($sampleRequest);
                return 0;
        }
	$hash = password_hash($password, PASSWORD_DEFAULT);
        $statement = "insert into login (user, password) values ('$username', '$hash')";
        $response = $mydb->query($statement);
        echo "successfully registered";
        return 1;

}

function doLogin($username,$password)
{
	$mydb = new mysqli('127.0.0.1','testUser','12345','logininfo');

	if ($mydb->errno != 0)
	{
        	echo "failed to connect to database: ". $mydb->error . PHP_EOL;
        	exit(0);
	}

        $statement = "select * from login where user = '$username'";
        $response = $mydb->query($statement);

        while ($row = $response->fetch_assoc())
        {
		echo "checking password for $username".PHP_EOL;
		// if ($row["password"] == $password)
		// old way before password hashing ^
		if (password_verify($password,$row["password"]))
                {
			echo "passwords match for $username".PHP_EOL;
			$timestamp = date('Y-m-d H:i;s');
			echo "Timestamp created:  $timestamp";
			$hash = password_hash($username, PASSWORD_DEFAULT);
			$statement = "insert into sessions (user, sessionId, time) values ('$username', '$hash', '$timestamp')";
		       	$response = $mydb->query($statement);

                        return 5; // passwords found to match
                }
                echo "Wrong password".PHP_EOL;
        }
        echo "Username not found".PHP_EOL;
        return 0; // Username not found
}

function doLogout($username) {
	$mydb = new mysqli('127.0.0.1','testUser','12345','logininfo');

        if ($mydb->errno != 0)
        {
                echo "failed to connect to database: ". $mydb->error . PHP_EOL;
                exit(0);
        }

	$statement = "delete from sessions where user='$username'";
	$response = $mydb->query($statement);
	echo "USER LOGOUT";
	return 1;
}

function addFriend($username1, $username2){
$mydb = new mysqli('127.0.0.1','testUser','12345','logininfo');

        if ($mydb->errno != 0)
        {
                echo "failed to connect to database: ". $mydb->error . PHP_EOL;
                exit(0);
        }

        $statement = "select * from friends where User1 = '$username1' and User2='$username2'";
        $response = $mydb->query($statement);

        while ($row = $response->fetch_assoc())
        {
		echo "checking status for $username1".PHP_EOL;
		if ($row["status"] == 0){
			
                        $statement = "update friends set status=1 where User1='$username1' and User2='$username2'";
			$response = $mydb->query($statement);
			return 1;
		}else if($row["status"]==1){
			echo"already friends";
			return 1;
		}

	}
	echo "Relationship Not Found";
        return 0;

}

function getFriends($username){
$mydb = new mysqli('127.0.0.1','testUser','12345','logininfo');
//	$response = "no friends";
        if ($mydb->errno != 0)
        {
                echo "failed to connect to database: ". $mydb->error . PHP_EOL;
                exit(0);
        }

        $statement = "select User2 from friends where User1 = '$username' and status=1";
       // $response = $mydb->query($statement);
  //      $response ->fetch_all(MYSQLI_ASSOC);
//	$response->free_result();
	//$mydb->close();
	$result=mysqli_query($mydb,$statement);
	echo "getFriends executed";
	$rows = array();
	while ($r = $result->fetch_assoc()) {
	
		$rows[]=$r;
	}
	echo $rows;	
	return json_encode($rows);

}

?>
