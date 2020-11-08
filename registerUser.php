<?php
    if (isset($_POST['addUser'])) {
        echo 'Correct path used';
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
        $clearance = $_POST['clearance'];

        $clearance_array = array('T', 'S', 'C', 'U');

        if (!in_array($clearance, $clearance_array)) {
            echo 'Clearance value not in array of values for acceptable clearance';
            die('Clearance value not in array of values for acceptable clearance');
        }

        $hashPassword = sha1($password);

        $sql = "INSERT INTO useraccounts " . 
        "(username, password, clearance) " . " VALUES " . 
        "('$username', '$hashPassword', '$clearance')";
        
        if ($result = $conn -> query($sql)) {
            echo "Returned rows are: " . $result -> num_rows;
            $result -> free_result();
        }
        $conn -> close();
    } else {
        echo "Incorrect Path from form action";
    }
?>