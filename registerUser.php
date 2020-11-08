<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a New User Record into MySQL Database</title>
</head>
<body>
    <?php
        if (isset($POST['addUser'])) {
            $dbhost = 'localhost:3306';
            $dbuser = 'root';
            $dbpassword = 'COSC4343';
            $conn = mysql_connect($dbhost, $dbuser, $dbpassword);

            if (! $conn ) {
                die('Could not connect: ' . mysql_error());
            }

            $username = $_POST['username'];
            $password = $_POST['password'];
            $clearance = $_POST['clearance'];

            $clearance_array = array('T', 'S', 'C', 'U');

            if (!in_array($clearance, $clearance_array)) {
                throw new Exception('Clearance value should be T, S, C, or U');
            }

            $hashPassword = sha1($password);

            $sql = "INSERT INTO useraccounts " . 
            "(username, password, clearance) " . " VALUES " . 
            "('$username', '$hashPassword', '$clearance')";
            
            $retVal = mysql_query( $sql, $conn );
            if (! $retVal ) {
                die('Could not insert data: ' . mysql_error());
            }

            echo "Registered new user successfully";
            mysql_close($conn);
        }
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
</body>
</html>