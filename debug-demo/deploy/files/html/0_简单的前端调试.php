<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>点击计数器</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        button {
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: #45a049;
        }
        #counter, #result {
            margin: 20px;
            font-size: 24px;
        }
        #result {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>点击一千次获取flag</h1>
    <div id="counter">点击次数: 0</div>
    <button id="clickButton">点击我</button>
    <div id="result"></div>

    <script>
        // 初始化计数器
        let count = 0;
        const counterElement = document.getElementById('counter');
        const resultElement = document.getElementById('result');
        const clickButton = document.getElementById('clickButton');
        
        // 按钮点击事件处理
        clickButton.addEventListener('click', function() {
            // 计数器加1
            count++;
            
            // 更新显示
            counterElement.textContent = '点击次数: ' + count;
            
            // 检查是否超过1000
            if (count > 1000) {
                try {
                    // 请求 getflag.php
                    fetch('getflag.php')
                    .then(response => response.text())
                    .then(data => {
                        resultElement.textContent = `成功！Flag: ${data}`;
                    })
                } catch (error) {
                    resultElement.textContent = "错误：无法获取 Flag";
                }
            }
        });
    </script>
</body>
</html>