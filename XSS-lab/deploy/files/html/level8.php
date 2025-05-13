<!DOCTYPE html>
<?php
function guolv($str)
{
  $str = strtolower($str);
  $str = str_replace("javascript","", $str);
  $str = str_replace("on", "", $str);
  $str = str_replace("src", "", $str);
  $str = str_replace("data", "", $str);
  return str_replace("href", "", $str);
}
?>
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8">
  <script>
      window.alert = function()
      {
          confirm("说出了不可言说的名字，你的存在被祂们感知到了");
          window.location.href="level9.php";
      }
  </script>
  <title>不可言说的名字</title>
</head>
<body>
<h1 align=center>不可言说的名字</h1>
<p align='center' id="text1">双眼逐渐聚焦，看到镜子中的自己，你猛地后退几步</p>
<p align='center' id="text2">你终于想起来了，这个房间中最大的异常就是这面镜子</p>
<p align='center' id="text3">你记得你你记得你的朋友的朋友，你记你记得主导者得主导者，你记得你所你记得你所经过的花神诞祭经过的花神诞祭</p>
<p align='center' id="text4">你记得你和另一半冷战，等等，另一半？是谁来着</p>
<p align='center' id="text5">你仿佛进入了一个没有出口的迷宫，向哪里走都是死路</p>
<form action="level8.php" method="post">
<p align='center' id="text6">庆幸的是，你还记得小喵的名字：
    <input id="user-input" name="input">
    <button type="submit">呼唤</button>
</p>
</form>
<?php
  if (isset($_POST['input'])) {
    $str = strtolower(urldecode($_POST['input']));
    $res1 = '';
    if (strpos($str, 'javascript') !== false) {
      $res1 .= " 这个名字似乎不可言说 ";
    }
    if (strpos($str, 'on') !== false) {
      $res1 .= " on畜！哪里跑 ";
    }
    if (strpos($str, 'href') !== false) {
      $res1 .= " 你想逃到哪去？ ";
    }
    if (strpos($str, 'src') !== false) {
      $res1 .= " 你想向谁求助，主导者吗？祂现在自身都难保 ";
    }
    $res = guolv($str);
    $res .= $res1;
    if (strpos($str, '简·杜') !== false) {
      $res = "嘘！你真的轻信这个在脑子不清晰时想到的名字吗";
    }
  } else {
    if (isset($res)) {
      unset($res);
    }
  }
?>
<center class="input-group">
  <input id="miao" type="<?php if(isset($res)){echo 'button';}else{echo 'hidden';}?>" style="background-color: red" value='<?php if (isset($res)) echo $res;?>'>
</center>
</body>
</html>
