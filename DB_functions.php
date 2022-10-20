<?php

function doRegister($username,$password)
{
        $statement = "select * from testtable where username = '$username'";
        $response = $this->testdb->query($statement);

        while ($row = $response->fetch(assoc())
        {
                echo "Username is already in the table, pick a different username";
                return 0;
        }

        $statement = "insert into testtable (username, password) values ('$username', '$password')";
        $response = $this->testdb->query($statement);
        echo "successfully registered";
        return 1;

}

function doLogin($username,$password)
{
        $statement = "select * from testtable where username = '$username'";
        $response = $this->testdb->query($statement);

        while ($row = $response->fetch_assoc())
        {
                echo "checking password for $username".PHP_EOL;
                if ($row["password"] == $pw)
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
