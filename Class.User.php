
<?php

include_once('config/setup.php');
class User
{
    private $con;
    function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->con = $db;
        $this->con->exec("USE dbcamagru");
    }

    public function runQuery($sql)
    {
        $stmt = $this->con->prepare($sql);
        return $stmt;
    }

    public function register($uname,$umail,$upass)
    {
        try
        {
            $new_password = hash('whirlpool', $upass);
            $stmt = $this->con->prepare("INSERT INTO tblUsers(user_name,user_email,user_pass, active) VALUES(:uname, :umail, :upass, 0)");
            $stmt->bindparam(":uname", $uname);
            $stmt->bindparam(":umail", $umail);
            $stmt->bindparam(":upass", $new_password);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function tempReg($uname,$umail,$upass, $regKey)
    {
        try
        {
            $new_password = hash('whirlpool', $upass);
            $stmt = $this->con->prepare("INSERT INTO tblTemp(user_name,user_email,user_pass, regKey) VALUES(:uname, :umail, :upass, :regKey)");
            $stmt->bindparam(":uname", $uname);
            $stmt->bindparam(":umail", $umail);
            $stmt->bindparam(":upass", $new_password);
            $stmt->bindparam(":regKey", $regKey);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function login($uname, $email, $upass)
    {
        try
        {
            $new_password = hash('whirlpool', $upass);
            $stmt = $this->con->prepare("SELECT * FROM tblUsers WHERE (user_name=:uname OR user_email=:umail)");
            $stmt->bindparam(":uname", $uname);
            $stmt->bindparam(":umail", $email);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['user_name'] == $uname)
            {
                if ($new_password == $row['user_pass'])
                {
                    $_SESSION['user_session'] = $row['user_id'];
                    return TRUE;
                }
                else
                    return FALSE;
            }
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public function rand_key()
    {
        $key = '';
        $counter = 50;
        $keys = array_merge(range(0, 9), range('a', 'z'));
        while ($counter >= 0)
        {
            $key .= $keys[array_rand($keys)];
            $counter--;
        }
        return $key;
    }

    public function verify($email, $regKey)
    {
        try
        {
            $stmt = $this->con->prepare("SELECT * FROM tblTemp WHERE user_email='$email' AND regKey='$regKey'");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['user_email'] == $email && $row['regKey'] == $regKey)
            {
                $upass = $row['user_pass'];
                $uname = $row['user_name'];
                $stmt = $this->con->prepare("INSERT INTO tblUsers(user_name,user_email,user_pass) VALUES(:uname, :umail, :upass)");
                $stmt->bindparam(":uname", $uname);
                $stmt->bindparam(":umail", $email);
                $stmt->bindparam(":upass", $upass);
                $stmt->execute();
                return $stmt;
            }
            else
                echo "Error: Use the link from your email to verify the account";
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public function add_image($image,$date,$uid)
    {
        try
        {
            $stmt = $this->con->prepare("INSERT INTO tblimages(image, capture_date, user_id) VALUES(:img, :cdate, :user_id)");
            $stmt->bindparam(":img", $image);
            $stmt->bindparam(":cdate", $date);
            $stmt->bindparam(":user_id", $uid);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function loggedin()
    {
        if (isset($_SESSION['user_session']))
            return TRUE;
    }

    public function logout()
    {
        session_destroy();
        unset($_SESSION['user_session']);
        return TRUE;
    }

}

?>