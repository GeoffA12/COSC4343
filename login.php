<?php
    if (isset($_POST['login'])) {
        $dbhost = 'localhost:3306';
        $dbuser = 'root';
        $dbpassword = 'COSC4343';
        $dbname = 'cosc4343';
        $conn = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);

        if ($conn -> connect_errno ) {
            echo 'Failed to connect to mysql: ' . $conn -> connect_error;
            die('Failed to connect to mysql');
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        $hashPassword = sha1($password);
        echo $username;

        echo $hashPassword;

        // $sql = "SELECT * FROM useraccounts WHERE username='$username' AND `password`='$hashPassword'";

        // $result = mysql_query($query);
        
        // if (!$result) {
        //     $message = 'Invalid query ' . mysql_error() . "\n";
        //     $message .= "Whole query: " . $query;
        //     echo $message;
        //     return;
        // } else {
        //     $row = mysql_fetch_assoc($result);
        //     echo $row['username'];
        //     echo $row['clearance'];
        // }
        // mysql_free_result($result);
        $conn -> close();
    } else {
        echo "Incorrect Path from form action";
    }
?>