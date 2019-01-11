<?php

ob_start();
session_start();
ini_set('max_execution_time', 100000);
require_once 'config/config.php';
require_once 'includes/gump.class.php';
require_once 'includes/MysqliDb.php';
require_once 'includes/common.php';


$sql = $_SESSION['export_query'];


$filename = "report";




$Connect = @mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't connect to MySQL:<br>" . mysql_error() . "<br>" . mysql_errno());
$Db = @mysql_select_db(DB_NAME, $Connect) or die("Couldn't select database:<br>" . mysql_error() . "<br>" . mysql_errno());
$result = @mysql_query($sql, $Connect) or die("Couldn't execute query:<br>" . mysql_error() . "<br>" . mysql_errno());

$file_ending = "xls";

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$filename.xls");
header("Pragma: no-cache");
header("Expires: 0");
$sep = "\t";
for ($i = 0; $i < mysql_num_fields($result); $i++) {
    echo mysql_field_name($result, $i) . "\t";
}
print("\n");

while ($row = mysql_fetch_row($result)) {
    $schema_insert = "";
    for ($j = 0; $j < mysql_num_fields($result); $j++) {
        if (!isset($row[$j]))
            $schema_insert .= "NULL" . $sep;
        elseif ($row[$j] != "")
            $schema_insert .= "$row[$j]" . $sep;
        else
            $schema_insert .= "" . $sep;
    }
    $schema_insert = str_replace($sep . "$", "", $schema_insert);
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= "\t";
    print(trim($schema_insert));
    print "\n";
}

exit();
