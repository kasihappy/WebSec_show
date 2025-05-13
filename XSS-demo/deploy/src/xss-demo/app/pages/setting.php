<?php
require_once 'app/utils/doBeforePageStartsWithLogin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $configFile = 'app/utils/config.php';

    // 读取文件内容
    $fileContent = file_get_contents($configFile);
    
    // 使用正则表达式替换目标内容
    $newFileContent = preg_replace(
        '/\$reflect_xss_defense\s*=\s*\d+\s*;/', 
        '$reflect_xss_defense = '.$_POST['reflect'].";", 
        $fileContent
    );

    $newFileContent = preg_replace(
        '/\$store_xss_defense\s*=\s*\d+\s*;/', 
        '$store_xss_defense = '.$_POST['store'].";", 
        $newFileContent
    );

    $newFileContent = preg_replace(
        '/\$csp_xss_defense\s*=\s*\d+\s*;/', 
        '$csp_xss_defense = '.$_POST['csp'].";", 
        $newFileContent
    );
    
    // 将修改后的内容写回文件
    file_put_contents($configFile, $newFileContent);
    header("Location: pannel");
}
else { ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>对一些参数的设置</title>
</head>
<body>
    <h1>在这里你可以设置一些参数用于测试</h1>
    <form action="setting" method="POST">
        <label for="reflect">反射型XSS：</label>
        <select name="reflect" id="parameter">
            <option value="0">无防御（默认）</option>
            <option value="1">简易过滤script</option>
            <option value="2">无视大小写过滤</option>
            <option value="3">强制过滤script</option>
        </select>
        <br><br>
        <br><br>
        <label for="store">存储型XSS：</label>
        <select name="store" id="parameter">
            <option value="0">无防御（默认）</option>
            <option value="1">前端转义</option>
            <option value="2">后端转义</option>
        </select>
        <br><br>
        <br><br>
        <label for="csp">CSP防御</label>
        <select name="csp" id="parameter">
            <option value="0">关闭（默认）</option>
            <option value="1">启动</option>
            <option value="2">启动+报告</option>
        </select>
        <button type="submit">提交</button>
    </form>
</body>
</html>

<?php }?>