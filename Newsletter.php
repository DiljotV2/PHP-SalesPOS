<?php
    $mysqli = new mysqli("localhost","root","root","login");

        // Check connection
        if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
        }
        $heading = $_POST['newsletter_heading'];
        date_default_timezone_set('Australia/Melbourne');
        $news = $_POST['newsletter_text'];
        $date = date('Y-m-d');
        
        if(!empty($_POST['newsletter_heading']))
        {
            $sql = "INSERT INTO `newsletter` (`S.No.`, `Heading`, `News`, `Date`) VALUES (NULL, '".$heading."', '".$news."', '".$date."');";
            $result = $mysqli -> query($sql);
            echo $sql;
            //$result = $conn->query($sql);
            if(!$mysqli -> commit())
            {
                echo "commit unsuccessful";
            }
            else
            {
                header("refresh:4; url=Dashboard.php");
            }
        }

        $mysqli -> close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewLetter Editor</title>
</head>
<body>
    <form action="#" id = "newsletter" method = "POST">
    <label for="newsletter_heading">Heading</label><br>
    <input type="text" name = "newsletter_heading"><br>
    <label for="newletter_text">EDIT NEWSLETTER</label><br>
    <textarea rows="4" cols="50" name="newsletter_text" form="newsletter">Enter the latest news here</textarea><br>
    <input type="submit" value = "Update NewsLetter">
    </form>
</body>
</html>