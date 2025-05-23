<?php
    $string = "abcdefghijklmnopqrstuvwxyz0123456789";
    $str = "";
    for($i=0;$i<4;$i++){
        $pos = rand(0,35);
        $str .= $string[$pos];
    }
    session_start();
    $_SESSION['img_number'] = $str;
    $_SESSION['img_id_0'] = $_SESSION['img_id_1'] ?? '';
    $_SESSION['img_id_1'] = md5(uniqid(rand(), true));
    $img_handle = Imagecreate(80, 20);  //图片大小80X20
    $back_color = ImageColorAllocate($img_handle, 255, 255, 255); //背景颜色（白色）
    $txt_color = ImageColorAllocate($img_handle, 0,0, 0);  //文本颜色（黑色）
    
    //加入干扰线
    for($i=0;$i<3;$i++)
    {
        $line = ImageColorAllocate($img_handle,rand(0,255),rand(0,255),rand(0,255));
        Imageline($img_handle, rand(0,15), rand(0,15), rand(100,150),rand(10,50), $line);
    }
    //加入干扰象素
    for($i=0;$i<200;$i++) 
    {
        $randcolor = ImageColorallocate($img_handle,rand(0,255),rand(0,255),rand(0,255));
        Imagesetpixel($img_handle, rand()%100 , rand()%50 , $randcolor);
    }
    Imagefill($img_handle, 0, 0, $back_color);             //填充图片背景色
    ImageString($img_handle, 28, 10, 0, $str, $txt_color);//水平填充一行字符串
    ob_clean();   // ob_clean()清空输出缓存区    
    header("Content-type: image/png"); //生成验证码图片    
    Imagepng($img_handle);//显示图片
?>