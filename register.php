<?php

session_start();
require_once ('Class.User.php');
$user = new User();
if ($user->loggedin())
    header("location: welcome.php");
else {
    if (isset($_POST['btn-signup'])) {
        $username = $_POST['uname'];
        $email = $_POST['mail'];
        $passwrd = $_POST['passwd'];
        $confirmpwd = $_POST['confirmpwd'];
        if ($username == "")
            $error[] = "Provide a username";
        else if ($email == "")
            $error[] = "Provide E-mail address";
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $error[] = "Provide A valid E-mail address";
        else if ($passwrd == "")
            $error[] = "Provide password";
        else if (strlen($passwrd) < 6)
            $error[] = "Password must be atleast 6 characters";
        else if (strcmp($passwrd, $confirmpwd) != 0)
            $error[] = "Password must match Password Confirmation";
        else {
            try {
                $sql = "SELECT user_name, user_email FROM tblUsers WHERE user_name=:uname OR user_email=:umail";
                $stmt = $user->runQuery($sql);
                $stmt->execute(array(':uname' => $username, ':umail' => $email));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row['user_name'] == $username)
                    $error[] = "Username already taken";
                else if ($row['user_email'] == $email)
                    $error[] = "E-mail is taken";
                else {
                    $regKey = $user->rand_key();
                    if ($user->tempReg($username, $email, $passwrd, $regKey)) {
                        $_SESSION['username'] = $username;
                        $_SESSION['email'] = $email;
                        $_SESSION['password'] = $passwrd;
                        $_SESSION['regKey'] = $regKey;
                        header('location: confirmreg.php');
                    }
                }
            } catch (Exception $e) {
                $error[] = $e->getMessage();
            }
        }
    }
}
?>

<html>
    <head>
        <title>Sign up</title>
        <link rel="stylesheet" href="css/styles.css" type="text/css"  />
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
                    <form method="post">
                        <h2>Sign up</h2>
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
                            else
                            {
                                ?>
                                <div class="alert">
                                    <?php echo "Provide details below!"; ?>
                                </div>
                                <?php
                            }
                        ?>
                        <div class="form-group">
                            <input type="text" class="form-control input" name="uname" placeholder="Enter Username" value="<?php if (isset($error)) echo $username;?>" />
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control input" name="mail" placeholder="Enter E-Mail" value="<?php if (isset($error)) echo $email;?>" />
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control input" name="passwd" placeholder="Enter Password" />
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control input" name="confirmpwd" placeholder="Re-Enter Password" />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="btn-signup" class="input button" value="Sign in"><br />
                        </div>
                        <br />
                        <label>have an account ! <a href="index.php">Sign In</a></label>
                    </form>
                </div>
            </div>
        </div>
        <footer id="footer">
            <p>All rights Reserved</p>
        </footer>
    </body>
</html>