<?php

session_start();
include_once('Class.User.php');
$user = new User();
if (isset($_POST['logout']))
{
    if ($user->logout()) {
        header('location: index.php');
    }
}


?>

<html>
    <head>
        <title>Welcome</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <section id="header">
            <form method="post" action="welcome.php">
                <input type="submit" name="logout" value="Logout">
            </form>
            <h1>Welcome Loyal User</h1>
        </section>
        <div class="row">
            <div class="col-md-2 right" id="side">
                <h1>Recent posts</h1>
                <?php
                    try {
                        $sql = "SELECT image FROM tblImages";
                        $stmt = $user->runQuery($sql);
                        $stmt->execute();
                        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    } catch (Exception $e) {
                        $error[] = $e->getMessage();
                    }
                    foreach ($row as $rw) {
                        echo '<div id="img_div"><div class="row">';
                        echo '<img src="' . $rw["image"] . '">';
                        echo '<p>' .'/* $rw["details"] */'. '</p></div>';
                        echo '<div class="row">Comment: <input type="text" id="comment"></input></div>';
                        echo '</div>';
                    }
                ?>
            </div>
            <div class="col-9" id="main">
                <div class="row">
                    <div id="camera">
                        <h1>capture an image</h1>
                        <video id="video">
                            <?php
                                $width = 900;
                                $height = 400;

                                //header('Content-Type: image/png');
                                $img = imagecreate($width, $height) or die("cannot initialize GD extension");
                                $canvas = imagecolorallocate($img, 245, 245, 245);

                                $img_a = imagecreatefrompng("http://vignette3.wikia.nocookie.net/disney/images/6/6b/Donald_Duck_transparent.png/revision/latest?cb=20130203061323");
                                imagecopyresampled($img, $img_a, 0, 0, 0, 0, 450, 400, 450, 400);

                                $img_b = imagecreatefrompng("http://pngimg.com/uploads/window/window_PNG17708.png");
                                imagecopyresampled($img, $img_b, 450, 0, 0, 0, 450, 400, 450, 400);



                                imagepng($img);
                            ?>
                        </video>
                    </div>
                    <div id="mix_img">
                        <h1>final image</h1>
                        <canvas id="canvas"></canvas>
                        <img id="photo" src="https://www.dreveterinary.com/lib/img/placeholder_large.png">
                        <span id="captured"></span>
                    </div>
                </div>
                <div class="row">
                    <form method="post">
                        <div class="col-6 capture">
                            <input id="capture" class="button" type="button" name="capture" value="Capture Image">
                        </div>
                        <div class="col-6 upload">
                            <input type="file">
                            <input class="button" type="button" name="upload" value="Upload Image">
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-2 img">
                        <img class="image" src="http://www.scri8e.com/stars/PNG_Clouds/zc06.png?filename=./zc06.png&w0=800&h0=289&imgType=3&h1=50&w1=140"/>
                    </div>
                    <div class="col-2 img">
                        <img class="image" src="http://home.aubg.edu/students/IAD150/1st%20project/images/tranpsparent3.png">
                    </div>
                    <div class="col-2 img">
                        <img class="image" src="https://gallery.yopriceville.com/var/albums/Frames/Pink_Diamond_Transparent_%20Frame_%20Gold_Heart.png?m=1399676400">
                    </div>
                    <div class="col-2 img">
                        <img class="image" src="http://pngimg.com/uploads/window/window_PNG17708.png">
                    </div>
                </div>
            </div>
        </div>
        <section id="footer">
            <p>All Rights reserved</p>
        </section>
        <script src="js/capture.js"></script>
        <script src="copy.js"></script>
    </body>
</html>

