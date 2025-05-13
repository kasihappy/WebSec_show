<?php
// 开启会话并销毁
session_start();
session_unset();
session_destroy();

// 重定向到登录页面
header("Location: login.html");
exit();
?>