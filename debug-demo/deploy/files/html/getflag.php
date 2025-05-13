<?php

$flag = file_get_contents('/flag');
if ($flag === false) {
    die('Error: Could not read flag file');
}
echo htmlspecialchars($flag, ENT_QUOTES, 'UTF-8');
?>