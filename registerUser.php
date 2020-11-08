<!DOCTYPE html>
<html>
<head>
    <title>Add a New User Record into MySQL Database</title>
</head>
<body>
    <?php
        if (isset($POST['addUser'])) {
            echo 'Correct path used';
            $dbhost = 'localhost:3306';
            $dbuser = 'root';
            $dbpassword = 'COSC4343';
            $dbname = 'cosc4343';
            $conn = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);

            if ($conn -> connect_errno ) {
                echo 'Failed to connect to mysql: ' . $conn -> connect_error;
            }

            $username = $_POST['username'];
            $password = $_POST['password'];
            $clearance = $_POST['clearance'];

            $clearance_array = array('T', 'S', 'C', 'U');

            if (!in_array($clearance, $clearance_array)) {
                echo 'Clearance value not in array of values for acceptable clearance';
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
    ?>

    <form method ="post" action ="<?php $PHP_SELF ?>">
        <table width="600" border ="0" cellspacing="1" cellpadding="2">
            <tr>
                <td width = "250">Username</td>
                <td>
                    <input name ="username" type="text" id="username">
                </td>
            </tr>

            <tr>
                <td width = "250">Password</td>
                <td>
                    <input name ="password" type="password" id="password">
                </td>
            </tr>

            <tr>
                <td width = "250">Clearance of T, S, C, or U</td>
                <td>
                    <input name ="clearance" type="text" id="clearance">
                </td>
            </tr>
            
            <tr>
                <td width = "250">Create User</td>
                <td>
                    <input name ="addUser" type="submit" id="addUser" value="Create User">
                </td>
            </tr>
        </table>
    </form>
    <?php
        }
    ?>
</body>
</html>