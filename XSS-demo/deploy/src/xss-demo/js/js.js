window.onload = function() {
    // 生成0~9的随机数
    var randomNumber = Math.floor(Math.random() * 10);

    // 生成图片路径
    var imagePath = "../img/code_" + randomNumber + ".png";

    // 生成html标签并设置src属性
    var imgElement = document.createElement("img");
    imgElement.src = imagePath;

    // 将img标签插入文档
    document.getElementById("captcha-img").appendChild(imgElement);

    // set input captcha id
    document.getElementById("captcha-id").value = randomNumber;
}

