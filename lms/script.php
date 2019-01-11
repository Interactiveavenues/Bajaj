<?php ob_start(); session_start();
require_once 'config/config.php';
require_once 'includes/MysqliDb.php';
require_once 'includes/common.php';

$data = $_POST['imgBase64'];

list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);

$imgname = date('Ymd_his').rand(1111,9999).'.png';
file_put_contents(DIR_PATH.'images/profiles/'.$imgname, $data);

echo $imgname; 