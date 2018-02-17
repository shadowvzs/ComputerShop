<?php
define('BLOG_PATH', 'application/blog/');
define('PAGE',isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'home');
define('PAGE_INDEX',isset($_GET['p']) ? intval($_GET['p']) : 0);
define('PER_PAGE', 5);  //lets show only 5 article per page :p

include ('application/init.php');

$pagePath = BLOG_PATH.'pages/'.PAGE.'.php';

$T = [];

function requireTemplate($T, $templatePath){
    $id = isset($_GET['id']) ? intval($_GET['id']) : -1;
    require BLOG_PATH.'templates/shared/main.php';
}

if (file_exists($pagePath)){
    require($pagePath);
    if (PAGE === "ajax") { die; }
     $templatePath = sprintf(BLOG_PATH.'templates/%s.php', PAGE);
} else {
    $templatePath = BLOG_PATH.'templates/page_not_found.php';
}

requireTemplate($T, $templatePath);