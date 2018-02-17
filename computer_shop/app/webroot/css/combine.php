<?php
session_start();
@ob_start('ob_gzhandler');
header('Content-type: text/css');

$create_cache = false;

function minify($css) {
    $css = preg_replace( '#\s+#', ' ', $css );
    $css = preg_replace( '#/\*.*?\*/#s', '', $css );
    $css = str_replace( '; ', ';', $css );
    $css = str_replace( ': ', ':', $css );
    $css = str_replace( ' {', '{', $css );
    $css = str_replace( '{ ', '{', $css );
    $css = str_replace( ', ', ',', $css );
    $css = str_replace( '} ', '}', $css );
    $css = str_replace( ';}', '}', $css );
    
    $trimmed_css = trim($css);
    if (isset($_GET['portal_theme']) && $_GET['portal_theme'] != '') {
        $trimmed_css = theme($trimmed_css, $_GET['portal_theme']);
    }
    
    return $trimmed_css;
}

function theme($css, $theme){
    $variables = urldecode($theme);
    $fields = json_decode($variables, true);
    foreach ($fields as  $key => $field) {
        $css = @str_replace('#'.$key, '#'.$field, $css);
    }
    return $css;
}

function handle_css($parse) {
    $content = '';
    $assets = explode(',', $parse);
    foreach($assets as $asset) {
        $content .= @file_get_contents($asset.'.css') . "\n";
    }
    return minify($content);
}

$cache_params = '';
foreach($_GET as $param) {
    $cache_params .= $param;
}
$cache = 'cache/'.md5($cache_params).'.css';

if($create_cache == false) {
    echo handle_css($_GET['combine']);
} else {
    if(!file_exists($cache)) {
        $content = handle_css($_GET['combine']);
        $handle = fopen($cache, "w");
        fwrite($handle, $content);
        fclose($handle);
    } else {
        $content = file_get_contents($cache);
    }
    echo $content;
}
?>