<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8">
  <script>
      window.alert = function()
      {
          confirm("和睦的夫妻关系是完美人生的第一步");
          window.location.href="level5.php?input=";
      }
  </script>
  <title>冷战</title>
</head>
<body>
<h1 align=center>冷战</h1>
<p align='center' id="text1">“花车颠呀颠，纳西妲睁开眼”，你的脑海中不由自主地想起了这个句子</p>
<p align='center' id="text2">揉了揉昏沉的脑袋，你感觉舒服多了，这让你想起和初恋小喵相互依偎的日子</p>
<p align='center' id="text3">温暖的感觉让困意缓缓袭来，“哈~”，‘你’打了个哈欠</p>
<p align='center' id="text4">哈欠是会传染的，你不禁想到，“哈~”，你也打了个哈欠，揉了揉头发准备睡觉</p>
<p align='center' id="text5">当你坐在床上时，发现正对着一面镜子，你什么时候把镜子搬到这来了？你记不清</p>
<p align='center' id="text6">这是一个很大的全身镜，小喵每次出门都会在镜子面前搭配许久</p>
<p align='center' id="text7">你回想起现在的另一半，最近你们正在冷战，这样下去确实不是办法，夫妻和睦是很重要的，就像引号需要闭合</p>
<center><button class="open-text" style="background-color: red">打开手机</button></center>
<center class="box-container"></center>
<center class="input-container"><input id="input-text" type="hidden" value="<?php echo $_GET['input'];?>"></center>
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
            oBox.innerHTML = encodeHtmlEntities(oName.innerText + oText.value) + "<br/>" + "<span style='color: red'>▮▮▮：你谁啊？</span><br/>";
        }
        document.querySelector(".input-container").appendChild(btn);
    }
</script>
</html>




