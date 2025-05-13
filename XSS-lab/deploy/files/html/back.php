<?php
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);
$str = urldecode($data['input']);


echo json_encode(array('res'=>"var hello='$str'"));
