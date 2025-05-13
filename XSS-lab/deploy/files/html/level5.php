 <!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8">
  <script>
      window.alert = function()
      {
          confirm("你在准备的晚餐中添加了一些小惊喜，期待祂的发现");
          window.location.href="level6.php?input=打开手机";
      }
  </script>
  <title>仪式感</title>
</head>
<body>
<h1 align=center>仪式感</h1>
<p align='center' id="text1">祂说暂时原谅你了，“▮人总是这样，就是要我先道歉”，你愤愤地为自己感到不平</p>
<p align='center' id="text2">你又想起了和小喵在一起的日子，你们从不吵架，小喵有时佯装生气，你总是笑眯眯地去哄祂</p>
<p align='center' id="text3">除了分手那次</p>
<p align='center' id="text4">甩了甩头，你感觉有些不对劲，怎么今天总是想起小喵，明明都过去那么久了</p>
<p align='center' id="text5">回想起你现在的另一半，你觉得确实亏欠祂太多了，每天过着三点一线的社畜生活，好像很久没有和祂好好过日子了</p>
<p align='center' id="text6">下周是你们的结婚纪念日，你一直记得，只是这几年都太忙，只是陪祂简简单单吃了顿饭</p>
<p align='center' id="text7">要不今年给祂点惊喜吧，你想，生活总是需要一些事件作为仪式感嘛</p>
<center><button class="open-text" style="background-color: red">点餐</button></center>
<center class="box-container"></center>
<center class="input-container"><input id="input-text" type="hidden" value='<?php echo htmlspecialchars($_GET['input']);?>'></center>
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
            oBox.innerHTML = encodeHtmlEntities(oName.innerText + oText.value) + "<br/>" + "<span style='color: red'>还记得吗？小惊喜</span><br/>";
        }
        document.querySelector(".input-container").appendChild(btn);
    }
</script>
</html>




