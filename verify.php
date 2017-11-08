<?php
/*
session_start();
include_once('Class.User.php');
$user = new User();
else
{
    if (isset($_POST['submit']))
    {
        $pass = $_POST['passwd'];
        $email = $_POST['username'];
        $name = $_POST['username'];
        if ($user->login($name, $email, $pass)) {
            header("location: welcome.php");
        }
        else
            $error[] = "Wrong Username or Password";
    }
}
*/
?>

<html>
    <head>
        <title>Camagru Sign up</title>
        <link href="css/styles.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div id="header">
            <h3>Camagru > Sign up</h3>
        </div>

        <div id="wrap">
            <?php
                require_once ('Class.User.php');

                if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['regKey']) && !empty($_GET['regKey'])){
                    $email = $_GET['email'];
                    $regKey = $_GET['regKey'];
                    $user = new User();
                    if ($user->verify($email, $regKey))
                        echo '<div class="statusmsg">Your account has been activated, you can now login</div>';
                    else
                        echo '<div class="statusmsg">The url is either invalid or you already have activated your account.</div>';
                }else{
                    echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
                }
            ?>
            <label><a href="index.php">Sign in</a></label>
        </div>
    </body>
</html>