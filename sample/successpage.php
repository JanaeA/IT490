<!DOCTYPE html>
<html>
<head></head>
    <body>
        <?php
        echo '<h1>Hello World</h1>'; 
        session_start();
        if (!isset($_SESSION['isLoggedIn'])) {
            echo "You weren't logged in! Go do it right..";
            header("refresh: 2, url=index.html");
            exit();
        }
        ?>

        <h1>We have successfully logged in.</h1>
        <p>Well, damn. Never expected to get this far, tbh.</p>

        <h2>User Profile Page: Put Username Here <span id="theUserName"></span></h2>
        <?php 
        print_r($_SESSION["username"]);
        ?>
        <form name="frmUser" method="post" action="logout.php" id="theForm" >
            <label for="logoutButton">Click me and we will logout.</label>
            <input type="button" name="logout" value="Logout" id="logoutButton">
            <input type="submit" name="submit" value="Submit" class="full-width ">
            <input type="input" name="userName" value="" id="theUser" >
            <input type="input" name="username" value="" id="theUserTest">
        </form>


        <br>
        <br>
        <br>
        </div>
        <div class="search-container">
    	<form action="searchpage.php" method="POST">
      	<input type="text" placeholder="Search for bands!" name="band">
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
    let user = sessionStorage.getItem('login');
    document.getElementById("theUserName").innerText = user;
    //alert(user);
    document.getElementById("theUser").value = user
    document.getElementById("theUserTest").value = user;
</script>
