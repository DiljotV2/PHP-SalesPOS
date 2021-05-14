<?php
        require "Credentials.php";
        $mysqli = new mysqli($host, $user, $password, $db);

        // Check connection
        if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
        }
        
        $uname = $_POST['username'];
        $password = $_POST['password'];
        if(!empty($_POST['username']))
        {
            $sql = "SELECT * FROM logindata where username = '" .$uname. "' and password = '". $password . "' limit 1";
            $result = $mysqli -> query($sql);
            echo $sql;
            //$result = $conn->query($sql);
             
            if ($result->num_rows > 0) {
                echo "Login Successful";
                header("refresh:2; url=Dashboard.php");
            }
            else{
                echo "Login Failed";
                header("refresh:2; url=Login.php");
            }

        }

        $mysqli -> close();

        /*$link = mysqli_init();
        $success = mysqli_real_connect(
        $link, 
        $host, 
        $user, 
        $password, 
        $db,
        $port
        );

        if(!$success){
            echo"noooo";
        }
        else{
            if(isset($_POST['username'])){
                $uname = $_POST['username'];
                $password = $_POST['password'];

                $sql = "Select * from logindata limit 1";
                echo $uname;
                $result = real_query($sql);
                echo $result;
                
                if($result)
                {
                    echo "we got something";
                }
                else{
                    echo "we dont";
                }
            }
            else{
               echo "nothing";
            }
        }
        */

        
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>WELCOME TO PHP SALES POS</h1>
    <h1>LOGIN PAGE</h1>
    
    <form action="#" method = "POST">
    <label for="username">Username</label>
    <input type="text" id = "username" name = "username"/>
    </br></br>
    <label for="password">Password</label>
    <input type="password" name = "password" id = "password">
    <br><br><br>
    <button name = "login" id = "login">Login</button>
    </form>
    <nav>
		<a href = "" id = "fPassword">Forgot Password?</a>
		<a href = "" id = "cAccound">Create Account</a>
	</nav>
</body>
</html>