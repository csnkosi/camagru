<?php

session_start();
$uname = $_SESSION['username'];
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$regKey = $_SESSION['regKey'];

$to      = $email;
$subject = 'Camagru Signup Verification';
$message = '
 
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
------------------------
Username: '.$uname.'
Password: '.$password.'
------------------------
 
Please click this link to activate your account:
http://localhost:8080/camagru/verify.php?email='.$email.'&regKey='.$regKey.'
 
';

$headers = 'From:noreply@camagru.co.za' . "\r\n";
if (mail($to, $subject, $message, $headers))
    echo "sent \nPlease check your email for the completion of your registration.";
else
    echo "not sent";

?>

<html>
    <head>
        <title>Camagru-Account Verification</title>
    </head>
    <body>
        <p></p>
    </body>
</html>
