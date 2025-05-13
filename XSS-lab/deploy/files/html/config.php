<?php
$servername = "localhost";
$username = "kasihappy";
$password = "what_can_i_say";
$database = "kasilab";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("kasilabs ERROR: 数据库连接失败，失败原因为".$conn->connect_error);
}