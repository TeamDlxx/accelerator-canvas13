<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Dublin');
ob_start();
session_start();
$environment = "";
$host = "localhost";
$dbusername = "root";
$dbpwd = "";
$dbname = "canvas13";
$support_api_url = "http://localhost/client-support_feedback-web-app/";
$base_url = "http://localhost/accelerator13/";
if ($environment === "prod") {
    $dbusername = "mupcrtfurp";
    $dbpwd = "GSFAFnw88Q";
    $dbname = "mupcrtfurp";
    $support_api_url = "https://support.dynamitelifestyle.co.uk/";
    $base_url = "http://phpstack-365301-2031115.cloudwaysapps.com/";
}
$connection_string = mysqli_connect($host, $dbusername, $dbpwd, $dbname);
mysqli_select_db($connection_string, $dbname);
if (!$connection_string == true) {
    echo "connection not susccessful";
}
define('X-Api-Key', "Hastalavista3077131473");
define('api_base_url', $support_api_url);
$project_id = '122';
$base_url_admin = $base_url . "admin/";
$error_support = "Something went Wrong please Contact Support";

/********Website Settings */
include 'website_settings.php';
