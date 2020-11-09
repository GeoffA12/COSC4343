<?php
    if (isset($_POST['login'])) {
        $baseUrl = 'http://104.131.161.220/COSC4343';
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
        echo $sql;

        if ($result = $conn->query($sql)) {
            printf("Select returned %d rows.\n", $result->num_rows);
            $userArray = $result->fetch_assoc();
            if (!$userArray) {
                $url = $baseUrl . '/badLogin.html';
                redirect($url);
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
        $conn -> close();
    } else {
        echo "Incorrect Path from form action";
    }

    function redirect($url, $statusCode = 303) {
        header('Location: ' . $url, true, $statusCode);
        exit();
    }
?>