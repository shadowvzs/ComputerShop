<?php
deg($_FILES);
if (!empty($_FILES)) {
    $id = User::getUserId();
    if ($id > 0) {
        $path = "public/img/user/".$id.".jpg";
        if (file_exists($path)) {
            unlink ($path);
        }      
        if (move_uploaded_file($_FILES["pimage"]["tmp_name"], $path)) {
            $_SESSION['dashboard']['mesage'] = "Profile picture changed";
        }
    }else{
        $_SESSION['dashboard']['mesage'] = "You must login first...";
    }
}
redirect('/dashboard.php');
