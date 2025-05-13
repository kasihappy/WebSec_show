<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8">
  <script>
    function submit() {
        var data = {
            input: document.getElementById("submit-input").value
        }
        fetch('back.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
          setTimeout(function (){
              eval(data.res);
              document.getElementById("res").innerText = hello;
          }, 100);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
  </script>
  <title>勇者斗恶龙</title>
</head>
<body>
<h1 align=center>勇者斗恶龙</h1>
<p align='center' id="text1">借助小喵的力量，你成功跑了出来，报警！报警！</p>
<p align='center' id="text2">巨大的恐惧让你连手机都无法握稳，▮▮▮，简单的三个数字你却敲了好几遍才敲对</p>
<p align='center' id="text3">那种被盯上的感觉越来越强烈了，你夺门而出，死死地盯住家门，深怕有什么东西跑出来</p>
<p align='center' id="text4">突然，你感觉有什么东西拍着你的肩膀，“▮▮！▮▮！”，你触电般的向前扑去</p>
<p align='center' id="text5">回过头来，才发现是一个打着手电的民警，“同志，同志，没事吧”，民警关心地看着你</p>
<p align='center' id="text6">你大口喘着气，试图平息强烈的心跳</p>
<p align='center' id="text7">“同志，是你报的警吧，你的名字是什么？”</p>
<center class="input-group">
  <input class="choose" id="win" type="button" style="background-color: red" value='自我认知：kasihappy'>
  <input class="choose" id="lose" type="button" style="background-color: red" value='自我认知：我'>
  <input class="choose" id="bad" type="button" style="background-color: red" value='自我认知：无机生命'>
</center>
<center class="input-group1"></center>
<script>
    var choice = '';
    document.getElementById("win").onclick = function () {
        document.querySelector(".input-group").innerHTML = '';
        choice = '再次醒来，你已经在监狱中';
        window.alert = function()
        {
            confirm(choice);
            window.location.href="thank.php";
        }
        document.getElementById("text1").innerText = '“请你填写一下这个表格吧，我们会根据这个处理问题的”';
        document.getElementById("text2").innerText = '';
        document.getElementById("text3").innerText = '';
        document.getElementById("text4").innerText = '';
        document.getElementById("text5").innerText = '';
        document.getElementById("text6").innerText = '';
        document.getElementById("text7").innerText = '';
        document.querySelector(".input-group1").innerHTML = `
    您的妻子情况怎样？<br>
    <input type="radio" id="alive" name="wife" value="1">
    <label for="option1">她很好，我们刚刚才过了一个难忘的结婚纪念日</label><br>
    <input type="radio" id="dead1" name="wife" value="2">
    <label for="option2">她好像食物中毒了，警官，请您彻查我点餐的这家饭店！</label><br>
    <input type="radio" id="dead2" name="wife" value="3">
    <label for="option3">她和我一样，是个可怜人，我们都被感情所伤</label><br>
    据了解，您有个前女友，您知道她近况如何吗？<br>
    <input type="radio" id="alive" name="girl" value="1">
    <label for="option1">我不知道，我们好久没联系了</label><br>
    <input type="radio" id="dead1" name="girl" value="2">
    <label for="option2">我前段时间去拜访她的父母，才得知她不见了，我真的很担心她</label><br>
    <input type="radio" id="dead2" name="girl" value="3">
    <label for="option3">......，希望她的新生活能更好</label><br>
    您的诉求是什么？
    <input type="text" name="text" id="submit-input"> <button onclick=submit() type="submit">提交</button>`;
    }
    document.getElementById("lose").onclick = function () {
        document.querySelector(".input-group").innerHTML = '';
        choice = "‘你’获得了自由...";
        window.alert = function()
        {
            confirm(choice);
            window.location.href="thank.php";
        }
        document.getElementById("text1").innerText = '“请你填写一下这个表格吧，我们会根据这个处理问题的”';
        document.getElementById("text2").innerText = '';
        document.getElementById("text3").innerText = '';
        document.getElementById("text4").innerText = '';
        document.getElementById("text5").innerText = '';
        document.getElementById("text6").innerText = '';
        document.getElementById("text7").innerText = '';
        document.querySelector(".input-group1").innerHTML = `
    您的妻子情况怎样？<br>
    <input type="radio" id="alive" name="wife" value="1">
    <label for="option1">她很好，我们刚刚才过了一个难忘的结婚纪念日</label><br>
    <input type="radio" id="dead1" name="wife" value="2">
    <label for="option2">她好像食物中毒了，警官，请您彻查我点餐的这家饭店！</label><br>
    <input type="radio" id="dead2" name="wife" value="3">
    <label for="option3">她和我一样，是个可怜人，我们都被感情所伤</label><br>
    据了解，您有个前女友，您知道她近况如何吗？<br>
    <input type="radio" id="alive" name="girl" value="1">
    <label for="option1">我不知道，我们好久没联系了</label><br>
    <input type="radio" id="dead1" name="girl" value="2">
    <label for="option2">我前段时间去拜访她的父母，才得知她不见了，我真的很担心她</label><br>
    <input type="radio" id="dead2" name="girl" value="3">
    <label for="option3">......，希望她的新生活能更好</label><br>
    您的诉求是什么？
    <input type="text" name="text" id="submit-input"> <button onclick=submit() type="submit">提交</button>`;
    }
    document.getElementById("bad").onclick = function () {
        document.querySelector(".input-group").innerHTML = '';
        choice = "现在轮到祂了...";
        window.alert = function()
        {
            confirm(choice);
            window.location.href="thank.php";
        }
        document.getElementById("text1").innerText = '“请你填写一下这个表格吧，我们会根据这个处理问题的”';
        document.getElementById("text2").innerText = '';
        document.getElementById("text3").innerText = '';
        document.getElementById("text4").innerText = '';
        document.getElementById("text5").innerText = '';
        document.getElementById("text6").innerText = '';
        document.getElementById("text7").innerText = '';
        document.querySelector(".input-group1").innerHTML = `
    您的妻子情况怎样？<br>
    <input type="radio" id="alive" name="wife" value="1">
    <label for="option1">她很好，我们刚刚才过了一个难忘的结婚纪念日</label><br>
    <input type="radio" id="dead1" name="wife" value="2">
    <label for="option2">她好像食物中毒了，警官，请您彻查我点餐的这家饭店！</label><br>
    <input type="radio" id="dead2" name="wife" value="3">
    <label for="option3">她和我一样，是个可怜人，我们都被感情所伤</label><br>
    据了解，您有个前女友，您知道她近况如何吗？<br>
    <input type="radio" id="alive" name="girl" value="1">
    <label for="option1">我不知道，我们好久没联系了</label><br>
    <input type="radio" id="dead1" name="girl" value="2">
    <label for="option2">我前段时间去拜访她的父母，才得知她不见了，我真的很担心她</label><br>
    <input type="radio" id="dead2" name="girl" value="3">
    <label for="option3">......，希望她的新生活能更好</label><br>
    您的诉求是什么？
    <input type="text" name="text" id="submit-input"> <button onclick=submit() type="submit">提交</button>`;
    }
</script>
<center id="res"></center>
</body>
</html>
