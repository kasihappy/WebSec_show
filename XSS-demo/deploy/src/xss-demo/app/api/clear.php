<?php
require_once 'app/utils/doBeforePageStartsWithoutLogin.php';

$sql = "TRUNCATE TABLE posts";
$result = $db->query($sql);

header("Location: pannel");