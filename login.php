<?php
    if (isset($_POST['login'])) {
        $dbhost = 'localhost:3306';
        $dbuser = 'root';
        $dbpassword = 'COSC4343';
        $dbname = 'cosc4343';
        $conn = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);

        if ($conn->connect_error) {
            echo 'Failed to connect to mysql: ' . $conn->connect_error;
            die('Failed to connect to mysql');
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        $hashPassword = sha1($password);
        echo $username;

        echo "<br>";
        echo $hashPassword;

        $sql = "SELECT * FROM useraccounts WHERE username='$username' AND `password`='$hashPassword'";
        // $sql = "SELECT * FROM useraccounts";
        echo $sql;

        if ($result = $conn->query($sql)) {
            printf("Select returned %d rows.\n", $result->num_rows);
            // while ($row = $result->fetch_assoc()) {
            //     echo "Username " . $row["username"] . "clearance: " . $row["clearance"];
            // }
            $userArray = $result->fetch_assoc();
            if (!$userArray) {
                echo "<h2>Invalid login</h2>";
            }
            else {
                echo $userArray["username"];
                echo "<br>";
                echo $userArray["clearance"];
            }
            $result->close();
        } else {
            print('Incorrect syntax, query failed.');
        }
        
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