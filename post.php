<?php
session_start();
require_once ('Class.User.php');
$user = new User();
if (isset($_POST['image'])) {
    $username = $_SESSION['user'];
    $name = "camagru_".rand(1000, 10000000)."_n.png";
    $img = $_POST['image'];
    $img = str_replace("data:image/png;base64,", '', $img);
    $img = str_replace(" ", '+', $img);
    $file = "img/" . $name . ".png";
    $success = file_put_contents($file, base64_decode($img));

    $dest = imagecreatefrompng($file);
    $src = imagecreatefrompng('http://vignette3.wikia.nocookie.net/disney/images/6/6b/Donald_Duck_transparent.png/revision/latest?cb=20130203061323');
    imagealphablending($src, true);
    imagesavealpha($src, true);
    imagecopy($dest, $src, 0, 0, 0, 0, 450, 400);
    header('Content-Type: image/png');
    imagepng($dest, $file);
    imagedestroy($dest);
    imagedestroy($src);

    $uid = $_SESSION['user_session'];
    $user->add_image($file, 'NOW()', $uid);

}