<!DOCTYPE html>
<?php
function guolv($str)
{
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
          confirm("你逐渐记起小喵的名字");
          window.location.href="level7.php?input=什么是吉巴欧萝卜先生";
      }
  </script>
  <title>独属于你的蒙娜丽莎</title>
</head>
<body>
<h1 align=center>独属于你的蒙娜丽莎</h1>
<p align='center' id="text1">祂惊讶地看着你，似乎惊讶到说不出话来，看到祂现在的状态，你很满意</p>
<p align='center' id="text2">这是你一生中最<del>快乐</del>的一天，你想，但是另一个身影始终浮现在你的脑海中</p>
<p align='center' id="text3">小喵...你又想起祂了，想起那场樱花树下的<del>告白</del></p>
<p align='center' id="text4">还记得那个夏天，祂穿着粉色的碎花短裙，你对祂伸出了手</p>
<p align='center' id="text5">你没有问祂接不接受比祂大的，你只记得祂的类型比较弱势，应该大小都能接受</p>
<p align='center' id="text6">祂叫什么来着？Ja...简·杜？</p>
<p align='center' id="text7">你的思绪又飘到奇怪的地方，不如问问吧</p>
<center><input class="open-text" type="button" style="background-color: red" value='<?php echo guolv(urldecode($_GET['input']));?>'></center>
<center class="box-container"></center>
<center class="input-container"><input id="input-text" type="hidden"></center>
</body>
<script>
    function encodeHtmlEntities(str) {
        return str.replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/\//g, '&#x2F;');
    }
    document.querySelector(".open-text").onclick = function () {
        var box = document.createElement("div");
        box.id='box';
        box.style = "width:250px; height:200px; border:1px solid #e5e5e5; background:#f1f1f1";
        var name = document.createElement("span");
        name.id = "name";
        name.innerText = "你: ";
        var input = document.getElementById('input-text');
        input.type = "text";
        document.querySelector(".input-container").innerHTML = '';
        document.querySelector(".box-container").appendChild(box);
        document.querySelector(".input-container").appendChild(name);
        document.querySelector(".input-container").appendChild(input);
        var btn = document.createElement("input");
        btn.id = "btn";
        btn.type = "button";
        btn.value = "发送信息";
        btn.onclick = function () {
            var oBox = document.getElementById("box");
            var oName = document.getElementById("name");
            var oText = document.getElementById("input-text");
            oBox.innerHTML = encodeHtmlEntities(oName.innerText + oText.value) + "<br/>" + "<span style='color: red'>......</span><br/>";
        }
        document.querySelector(".input-container").appendChild(btn);
    }
</script>
</html>




