<?php


define('DASHBOARD_PATH', 'application/dashboard/');

$page=isset($_GET['page']) ? trim(strtolower($_GET['page'])) : 'home';

include ('application/init.php');

$showUI=false;
if (!($page === "login" || $page === "reg")) {
    if (!User::isLogged()) {
        $page='logout';
    }else{ 
        $showUI=true; 
        
    }
}

$pagePath = DASHBOARD_PATH.'pages/'.$page.'.php';

$T = [$showUI];

function requireTemplate($T, $templatePath){
    $showUI=$T[0];
    $userLogged=false;
    require DASHBOARD_PATH.'templates/shared/main.php';
}

if (file_exists($pagePath)){
    $id=isset($_GET['id']) ? intval($_GET['id']) : -1;
    require($pagePath);
    $templatePath = DASHBOARD_PATH.'templates/'.$page.'.php';
} else {
    $templatePath = DASHBOARD_PATH.'templates/page_not_found.php';
}

requireTemplate($T, $templatePath);


