<?php

session_start();
include_once('Class.User.php');
include_once('class.db.php');
$db = new CreateDb();
$db->createDB();
$db->TblUsers();
$db->TblImages();
$db->TblComments();
$db->TblLikes();
$db->TblTemp();
$user = new User();
if ($user->loggedin())
    header("location: welcome.php");
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

?>

<html>
    <head>
        <title>Camagru</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <section id="header">
            <form method="post" action="welcome.php">
            </form>
            <h1>Welcome Loyal User</h1>
        </section>
        <div class="container">
            <div class="form-container">
                    <div class="box">
                        <h1>Sign in</h1>
                        <?php
                            if (isset($error))
                            {
                                foreach ($error as $err)
                                {
                                    ?>
                                    <div class="alert">
                                        <?php echo $err; ?>
                                    </div>
                                    <?php
                                }
                            }
                        ?>
                        <form method="post" action="index.php">
                            <div class="form-group">
                                <input type="text" name="username" class="input" placeholder="Enter your username">
                            </div>
                            <div class="form-group">
                                <input type="password" name="passwd" class="form-control input" id="Password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="input button" name="submit" value="Sign in"><br />
                            </div>
                            <label>Don't have an account ! <a href="register.php">Sign Up</a></label>
                        </form>
                    </div>
            </div>
        </div>
        <footer id="footer">
            <p>All rights Reserved</p>
        </footer>
    </body>
</html>
