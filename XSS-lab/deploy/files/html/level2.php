<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8">
  <script>
      window.alert = function()
      {
          confirm("你掌握了向DOM求助的方法...");
          window.location.href="level3.php?thought=%e9%9a%be%e9%81%93%e8%bf%99%e9%9d%a2%e9%95%9c%e5%ad%90%e7%9a%84%e4%b8%bb%e4%ba%ba%e8%83%bd%e5%af%b9%e4%b8%bb%e5%af%bc%e8%80%85%e4%ba%a7%e7%94%9f%e5%a8%81%e8%83%81";
      }
  </script>
  <title>主导者和服从者</title>
</head>
<body>
<h1 align='center'>主导者和服从者</h1>
<p align='center'>这面镜子的反射似乎有些奇怪，这令他想起了一个字母圈朋友的故事</p>
<p align="center">很久以前，这个朋友还是一个服从者的时候，祂也遇到过一面这样的镜子</p>
<p align="center">kasihappy记得这个朋友跟自己说过，当时是主导者帮祂解决的</p>
<p align="center">也许找到主导者能够让这个瘆人的镜子消失，他想...</p>
<center><del>至少能让这个奇怪的<?php echo htmlspecialchars($_GET['keyword'])?>现象消失</del></center>
<p align="center">纠结许久，他还是准备向主导者发送求助信息   <button class="open-text" style="background-color: red">打开手机</button></p>
<center class="box-container"></center>
<center class="input-container"></center>
</body>
<script>
    document.querySelector(".open-text").onclick = function () {
        var box = document.createElement("div");
        box.id='box';
        box.style = "width:250px; height:200px; border:1px solid #e5e5e5; background:#f1f1f1";
        var name = document.createElement("span");
        name.id = "name";
        name.innerText = "kasihappy: ";
        var input = document.createElement("input");
        input.id = "input-text";
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
            oBox.innerHTML = oBox.innerHTML + oName.innerHTML + oText.value + "<br/>" + "<span style='color: red'>主导者：你逃不掉的...</span><br/>";
        }
        document.querySelector(".input-container").appendChild(btn);
    }
</script>
</html>




