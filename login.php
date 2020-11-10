<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="checkCaptchaForm.js"></script>
    <title>User Login Script</title>
</head>
<?php
    include 'redirect.php';
    if (isset($_POST['login'])) {
        session_start();
        if ($_POST['captcha'] != $_POST['digit']) {
            echo "Sorry, the CAPTCHA code was entered incorrectly!";
            die("Sorry, the CAPTCHA code was entered incorrectly!");
        }
        session_destroy();

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

        $sql = "SELECT * FROM useraccounts WHERE username='$username' AND `password`='$hashPassword'";

        if ($result = $conn->query($sql)) {
            $userRow = $result->fetch_assoc();
            if (!$userRow) {
                echo "<h2>Invalid Login Credentials.</h2>";
            } else {
                $clearanceLevel = $userRow["clearance"];
                switch ($clearanceLevel) {
                    case 'T':
                        $url = $baseUrl . '/TopSecret.html';
                        redirect($url);
                        break;
                    case 'S':
                        $url = $baseUrl . '/Secret.html';
                        redirect($url);
                        break;
                    case 'C':
                        $url = $baseUrl . '/Confidential.html';
                        redirect($url);
                        break;
                    case 'U':
                        $url = $baseUrl . '/Unclassified.html';
                        redirect($url);
                        break;
                    default:
                        echo "Unknown clearance user logged in.";
                }
                
            }
            $result->close();
        } else {
            print('Incorrect syntax, query failed.');
        }
        $conn -> close();
    }
?>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return checkCaptchaForm(this);">
        <table width="600" border ="1" cellspacing="1" cellpadding="2">
            <tr>
                <p>
                    <img src="/captcha.php" width="120" height="30" border="1" alt="CAPTCHA">
                </p>
                <p>
                    <input type="text" size="6" maxlength="5" name="captcha" value="">
                    <br>
                    <small>Copy the digits from the image into this box</small>
                </p>
            </tr>
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
                <td width = "250">Sign In</td>
                <td>
                    <input name ="login" type="submit" id="login" value="Sign In">
                </td>
            </tr>
        </table>
    </form>
    
</body>
</html>