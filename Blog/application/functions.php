<?php
function deg($var){
    echo'<pre>'.print_r($var, true).'</pre>';
}

function loadClass ($className){
    $classPath = 'application/classes/'.$className.'.php';
    if (file_exists($classPath)){
        include($classPath);
    }
}

function date2Mysql($date=null, $format = null) {
    if ($date) {
        return date($format ? $format : 'Y-m-d H:i:s',strtotime($date));
    }else{
        return date($format ? $format : 'Y-m-d H:i:s');
    }
}
function isPost(){
    return ($_SERVER['REQUEST_METHOD'] == 'POST');
}

function secretString(){ return 'asdasdas';}

function redirect($url) {
    header('Location: '.$url);
    exit;
}

function getParam($key, $default='') {
    return (isset($_GET[$key])) ? $_GET[$key] : $default;
}

function getSearchKey(){
    $key = trim(getParam('search_key'));
    if ($key === "") {return false;}
    return str_replace("*", "", $key);
}

function hightlightString($str, $key){
    return $key ? str_replace($key, '<span class="text-highlight">'.$key.'</span>', $str) : $str;
}

function convertLineBreaks($str) {
    return str_replace(PHP_EOL, '<br>', $str);
}

function uploadImg ($file, $name='default.jpg'){

    $target_file = UPLOAD_DIR.$name;
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return true;
    } else {
       return false;
    }
}

function createThumbnail($filename, $final_width, $final_height){
    
    $oldFilePath=UPLOAD_DIR.$filename;
    $newFilePath=UPLOAD_DIR.'thumb_'.$filename;
    
    $image = imagecreatefromjpeg($oldFilePath);
    list($width_orig, $height_orig) = getimagesize($oldFilePath);
    
    $ratio = $width_orig/$height_orig;
    
    $new_width = floor($final_height * $ratio);
    if ($new_width >= $final_width) {
        $new_height = $final_height;
        $diff_x = floor(($new_width - $final_width) / 2);
        $diff_y = 0;
    }else{
        $new_width = $final_width;
        $new_height = floor($new_width / $ratio);
        $diff_x = 0;
        $diff_y = floor(($new_height - $final_height) / 2);    
    }
    
    $thumb = imagecreatetruecolor( $final_width, $final_height );
    
    imagecopyresampled($thumb,
                       $image,
                       -$diff_x,
                       -$diff_y,
                       0,
                       0,
                       $new_width, $new_height,
                       $width_orig, $height_orig);
    imagejpeg($thumb, $newFilePath, 80);

}