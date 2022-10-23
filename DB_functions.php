<?php

function doRegister($username,$password)
{
	$mydb = new mysqli('127.0.0.1','testUser','12345','logininfo');

	if ($mydb->errno != 0)
	{
        	echo "failed to connect to database: ". $mydb->error . PHP_EOL;
        	exit(0);
	}

        $statement = "select * from login where user = '$username'";
        $response = $this->testdb->query($statement);

        while ($row = $response->fetch(assoc()))
        {
                echo "Username is already in the table, pick a different username";
                return 0;
        }

        $statement = "insert into login (user, password) values ('$username', '$password')";
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
                if ($row["password"] == $password)
                {
                        echo "passwords match for $username".PHP_EOL;
                        return 1; // passwords found to match
                }
                echo "Wrong password".PHP_EOL;
        }
        echo "Username not found".PHP_EOL;
        return 0; // Username not found
}
?>
