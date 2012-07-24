<?php
require_once '../lib/common.php';
header('Content-type', 'application/json; charset=utf-8');

$session->logout();
$ret = array("status" => "OK");

echo json_encode($ret);

?>
