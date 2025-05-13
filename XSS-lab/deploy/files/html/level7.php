<!DOCTYPE html>
<?php
function guolv($str)
{
  $str = strtolower($str);
  $str = str_replace("<script","????", $str);
  return str_replace("on", "??", $str);
}
?>
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8">
  <script>
      window.alert = function()
      {
          confirm("你很庆幸自己还记得这些");
          window.location.href="level8.php";
      }
  </script>
  <title>吉巴欧萝卜先生</title>
</head>
<body>
<h1 align=center>吉巴欧萝卜先生</h1>
<p align='center' id="text1">你对小喵的记忆逐渐清晰，你看了看手机，小喵的头像依旧是灰色</p>
<p align='center' id="text2">好像有什么人在一点一点提醒你，你看向卧室里的那面镜子，镜子中的你同样看向你自己</p>
<p align='center' id="text3">你感觉自己好像忘记了什么，<span style="color: red">一个，一个</span>非常重要的东西，它似乎能够链接到神奇的地方</p>
<p align='center' id="text4">无数记忆在你的脑内涌现，你感到精神开始过热。你回想起第一个掰手指数数的下午，第一次签署虚伪的协议，你为什么记得这些？</p>
<center class="input-group">
  <input id="again" type="button" style="background-color: red" value='请别再继续问'>
  <input id="continue" type="button" style="background-color: red" value='怀念灰质的国度'>
</center>
</body>
<script>
  document.getElementById("again").onclick = function () {
      document.getElementById("text1").innerText = '';
      document.getElementById("text2").innerText = '';
      document.getElementById("text3").innerText = '';
      document.getElementById("text4").innerText = '';
      var span = document.createElement('span');
      span.innerText = "你还记得祂吗？";
      span.style = "color: red";
      document.getElementById("text1").appendChild(span);
  }
  document.getElementById("continue").onclick = function () {
      document.getElementById("text1").innerText = '记住这些没用的东西让你感觉活着，但看到这个问题，你好像已经行于Ⅸ的命途【死亡】';
      document.getElementById("text2").innerText = '“提问吧，我会让你回忆起来”，你感觉有人在你耳边低语';
      document.getElementById("text3").innerText = '';
      document.getElementById("text4").innerText = '';
      document.querySelector(".input-group").innerHTML = '<input class="open-text" type="button" style="background-color: red" value=\'<?php echo guolv(urldecode($_GET['input']));?>\'>';
      document.querySelector('.open-text').onclick = function () {
          document.getElementById("text1").innerText = '这不好笑，朋友';
          document.getElementById("text1").style = 'color: red';
          document.getElementById("text2").innerText = '';
          document.getElementById("text3").innerText = '';
          document.getElementById("text4").innerText = '';
      }
  }
</script>
</html>
