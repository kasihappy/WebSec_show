<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8">
  <script>
      window.alert = function()
      {
          confirm("你利用了祂们，成功从镜子里逃了出来");
          window.location.href="level4.php?input=";
      }
  </script>
    <style>
        #typewriter {
            overflow: hidden;
            white-space: nowrap;
            border-right: 2px solid black;
            animation: blink 500ms step-start infinite;
        }
    </style>
  <title>花神诞祭</title>
</head>
<body>
<?php
require 'config.php';
if (isset($_GET['thought'])) {
    if ($_GET['thought'] === 'clear') {
        $sql = "delete from thoughts";
    } else {
      $sql = "insert into thoughts values ('{$_GET['thought']}',1)";
    }

    $conn->query($sql);
}

?>
<h1 align='center'>花神诞祭</h1>
<p align='center' id="text1">这个镜子至少看起来正常了些，kasihappy如是安慰自己</p>
<p align='center' id="text2">主导者对自己的帮助好像受到了什么限制，难道祂也正在被什么东西影响着吗...</p>
<p align='center' id="text3">kasihappy谨慎地观察着镜子，<?php echo htmlspecialchars(urldecode($_GET['thought'])); ?>？他不愿去想</p>
<p align='center' id="text4">轻抚着镜子的边缘，kasihappy突然感觉一阵恍惚</p>
<p align='center' id="text5"></p>
<p align='center' id="text6"></p>
<center id="button-holder"></center>
<center class="box-container"></center>
<center><del id="text7"></del></center>
</body>
<script>
    var text1 = "这个镜子至少看起来正常了些，kasihappy如是安慰自己";
    var text2 = "主导者对自己的帮助好像受到了什么限制，难道祂也正在被什么东西影响着吗...";
    var text3 = "kasihappy谨慎地观察着镜子，<?php echo htmlspecialchars(urldecode($_GET['thought'])); ?>？他不愿去想";
    var text4 = "轻抚着镜子的边缘，kasihappy突然感觉一阵恍惚";
    var text5 = "‘当你凝视着深渊的时候，深渊也在凝视着你’，你清楚自己在做什么";
    var text6 = "你的身体越来越轻，穿越了一些结构化的东西，不知为何，祂们突然让你联想到Excel";
    var text7 = "这种漫无目的的彷徨仿佛持续了一个世纪，但你感觉你的思绪好像被记录到了什么地方";
    var text8 = "当你的注意力终于回到你的身体时，你突然发现镜中的你正在微笑的看着你，你很确定那是你的脸，但同样确定你没有在笑";
    var text9 = "还记得上个花神诞祭吗？花神通过另一个自己的告警摆脱无限的轮回";
    var text10 = "镜中人的思绪缓缓浮现在你的眼前....";
    var place1 = document.getElementById("text1");
    var place2 = document.getElementById("text2");
    var place3 = document.getElementById("text3");
    var place4 = document.getElementById("text4");
    var place5 = document.getElementById("text5");
    var place6 = document.getElementById("text6");

    function type() {
        var btn = document.createElement("button");
        btn.className = "next-stage";
        btn.style = "background-color: red";
        btn.innerText = "摇摇头，试图冷静下来";
        document.getElementById("button-holder").appendChild(btn);
        document.querySelector(".next-stage").onclick = function () {
            place1.innerHTML = "$@!##%&$!%@#$!@#!@$%^&!#$!$!@#$&)($@&@^";
            place2.innerHTML = ")(&#@^@(&*^$(@*$@^((&*@#!#!@*)(@&)(*@^#*^@*)^#";
            place3.innerHTML = "!#_!#{#}!!#)(&Q%*%*&!#_:}}{)_!#(&(&%^#!$&%&*!%^*&#%*&!#$%(*!#&(**!#";
            place4.innerHTML = ")_&(*@$%^*&@%$*&^@%*$&@)^$(*&$@@";
            setTimeout(function () {
                place1.innerHTML = text1;
                place2.innerHTML = text2;
                place3.innerHTML = text3;
                place4.innerHTML = text4;
                place5.innerHTML = '';
                place6.innerHTML = '';
                document.getElementById("button-holder").innerHTML = '';
            }, 900);

            setTimeout(function () {
                type();
            }, 1000);
        }
        var btn1 = document.createElement("button");
        btn1.className = "look-inside";
        btn1.style = "background-color: red";
        btn1.innerText = "揉揉眼，与镜中人对视";
        document.getElementById("button-holder").appendChild(btn1);
        document.querySelector(".look-inside").onclick = function () {
            place1.innerHTML = text5;
            place2.innerHTML = text6;
            place3.innerHTML = text7;
            place4.innerHTML = text8;
            place5.innerHTML = text9;
            place6.innerHTML = text10;
            document.getElementById("button-holder").innerHTML = '';
            var box = document.createElement("div");
            box.id='box';
            box.style = "width:300px; height:auto; border:1px solid #e5e5e5; background:#f1f1f1";
            document.querySelector(".box-container").appendChild(box);
            var oBox = document.getElementById("box");
            <?php
                $sql = "select * from thoughts";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      $content = $row['content'];
                      echo "oBox.innerHTML += '{$content}' + '<br/>';\n";
                    }
                }
            ?>
            document.getElementById("text7").innerText = "当你的思绪过多时，尝试集中注意力想着clear";
        }
    }

    type();

</script>

</html>




