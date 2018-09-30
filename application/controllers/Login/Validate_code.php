<?php
class Validate_code extends CI_Controller {
    public function create() {
//        //session_start();
//        header("Content-type: image/PNG");
//        $width = 60;
//        $height = 20;
//        $linesize = 4;
//        $code = '';
//        $code_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
//            'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
//        $image = imagecreate($width, $height);
//        $gray = imagecolorallocate($image, 200, 200, 200);
//        $white = imagecolorallocate($image, 255, 255, 255);
//        $black = imagecolorallocate($image, 0, 0, 0);
//        imagefill($image,0, 0, $gray);//填充背景色
//        imagerectangle($image, 0, 0, $width - 1, $height - 1, $black);//画边框
//        for ($i = 0; $i < $linesize; $i++)
//            imageline($image, rand(0, $width / 2), rand(0, $height / 2), rand($width / 2, $width), rand($height / 2, $height), $white);
//        for ($i = 0; $i < 4; $i++) {
//            $code .= $code_array[rand(0,36)];
//        }
//        $_SESSION['validate_code'] = $code;
//        imagestring($image, 4, 5, 2, $code, $black);
//        imagejpeg($image);
//        //imagedestroy($image);//释放图片所占内存



        $img_w = 70;
        $img_h = 22;
        $char_len = 4;	//初始化验证码码值的长度
        $font = 5;		//初始化验证码码值的字体大小

        //生成验证码数组
        $char = array_merge(range('A', 'Z'), range('a', 'z'), range(1,9));
        //随机获取$char_len个码值的键
        $rand_keys = array_rand($char, $char_len);
        //var_dump($rand_keys);
        //打乱随机获取的码键值的数组
        shuffle($rand_keys);
        //根据键获取对应的码值键的数组
        $code = '';
        foreach($rand_keys as $keys) {
            $code .= $char[$keys];
        }
        $_SESSION['validate_code'] = strtoupper($code);
        //生成画布
        $img = imagecreatetruecolor($img_w, $img_h);
        //为画布分配颜色
        $bg_color = imagecolorallocate($img, 0xcc, 0xcc, 0xcc);
        //设置画布背景色
        imagefill($img, 0, 0, $bg_color);
        //为验证码图片生成多个干扰点
        for($i = 0; $i < 300; $i++) {
            //随机为画布分配颜色
            $color = imagecolorallocate($img, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0,255));
            //在img图像上随机绘制一个点
            imagesetpixel($img, mt_rand(0, $img_w), mt_rand(0, $img_h), $color);
        }
        //为验证码边框分配颜色
        $rect_color = imagecolorallocate($img, 0xff, 0xff, 0xff);
        //绘制验证码图片边框
        imagerectangle($img, 0, 0, $img_w - 1, $img_h - 1, $rect_color);
        //设定字符串颜色
        $str_color = imagecolorallocate($img, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0,255));
        //根据设定的字体获取单个字符的宽和高
        $font_w = imagefontwidth($font);
        $font_h = imagefontheight($font);
        //验证码的码值总宽度
        $str_w = $font_w * $char_len;
        //将码值写入验证码图片中
        imagestring($img, $font, ($img_w - $str_w) / 2, ($img_h - $font_h) / 2, $code, $str_color);
        //设置输出验证码的格式
        header('Content-Type: image/png');
        //输出验证码
        imagepng($img);
        //销毁画布
        imagedestroy($img);

    }
}