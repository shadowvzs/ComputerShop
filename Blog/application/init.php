<?php
session_start();
error_reporting(E_ALL);
include ('functions.php');
spl_autoload_register('loadClass');

define('UPLOAD_DIR', 'public/img/articles/');