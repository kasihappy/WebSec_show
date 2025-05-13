<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8">
  <script>
      window.alert = function()
      {
          confirm("镜子，反射，喔~");
          window.location.href="level2.php?keyword=反射";
      }
  </script>
  <title>镜子</title>
</head>
<body>
<h1 align=center>镜子</h1>
<?php
ini_set("display_errors", 0);
$str = $_GET["name"];
echo "<p align='center'>一天清晨，不知被什么东西吵醒的kasihappy揉了揉惺忪的睡眼</p>";
echo "<p align='center'>甩了甩头，他发现自己的面前出现了一面{$str}</p>";
echo "<p align='center'>镜子中倒映着他的影子</p>";
?>
<center><img src=level1.jpg></center>
</body>
</html>




