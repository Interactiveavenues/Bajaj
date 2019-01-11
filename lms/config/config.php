<?php
date_default_timezone_set("Asia/Kolkata");
$protocol ="http";

$urlmainparams = explode('/',$_SERVER['REQUEST_URI']);
$folderlocate = $urlmainparams[1];


if ($_SERVER['HTTP_HOST'] == 'localhost:8080' || $_SERVER['HTTP_HOST'] == 'localhost') {
    ini_set('display_errors', 1);
    $folderlocate = "chatbot/lms";
    error_reporting(E_ALL);
    define('DIR_PATH', $_SERVER['DOCUMENT_ROOT'] . '/'.$folderlocate.'/');
    define("MYWEBSITE", $protocol . "://" . $_SERVER['HTTP_HOST'] . "/".$folderlocate."/");
    define("VIEWWEBSITE", $protocol . "://" . $_SERVER['HTTP_HOST'] . "/cabtaxi");
    define("ERRORPAGE", MYWEBSITE . "error");
    define("ADMINMAIL", "admin@a.com ");
    define("MAILFROM", "xyz@a.com");
    define("MAILCC", "xyz@a.com");
    define("ORDERMAIL", "xyz@a.com"); // used now
    define("CUSTOMERCARE", "xyz@a.com"); // used now


    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_NAME", "mahindra_tractor");

	
}else {
    ini_set('display_errors', 0);
    
    error_reporting(0);
    define("MYWEBSITE", "http://livestaging.interactiveavenues.net/chatbot/lms/");
    define("VIEWWEBSITE", "http://" . $_SERVER['HTTP_HOST']);
    define("ERRORPAGE", MYWEBSITE . "error");
    define('DIR_PATH', $_SERVER['DOCUMENT_ROOT'] . '/chatbot/lms/');
    define("ADMINMAIL", "admin@xx.com ");
    define("MAILFROM", "xyz@a.com");
    define("MAILCC", "xyz@a.com");
    define("ORDERMAIL", "xyz@a.com"); // used now

    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "IAweb1807");
    define("DB_NAME", "mahindra_tractor");
    
    
}


define("HEADING", "Mahindra Tractor Chatbot");
define("METATITLE", "Mahindra Tractor Chatbot");
define("METAKEYWORD", "Mahindra Tractor Chatbot");
define("METADESC", "Mahindra Tractor Chatbot");


define("MOBILE", "91xxxxxxxx");
define("ACTLP", "MYACTLP");
define("TRANSIDLENGTH", "6");
define("GSTNO", "27AFWPA4667G1Z2");

?>
