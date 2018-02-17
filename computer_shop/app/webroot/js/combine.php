<?php
@ob_start('ob_gzhandler');
header('Content-type: text/javascript');

$create_cache = false;
$cache = 'cache/'.md5($_GET['combine']).'.js';

function handle_javascript($parse) {
    $content = '';
    $assets = explode(',', $parse);
    foreach($assets as $asset) {
        $content .= file_get_contents($asset.'.js') . "\n";
    }
    return $content;
}

if(!file_exists($cache) || $create_cache == false) {
    $content = handle_javascript($_GET['combine']);
    if($create_cache == true) {
        $handle = fopen($cache, "w");
        fwrite($handle, $content);
        fclose($handle);
    }
    echo $content;
} else {
    echo file_get_contents($cache);
} 
?>