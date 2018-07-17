<?php
namespace backend\controllers;

use common\helpers\Func;
use common\models\GlobalStatistics;
use common\models\User;
use Yii;

class ImgController extends BaseController
{

    public function actionCreate(){
        if(!empty($_GET['name'])){
            $this->actionCreateDo();
        }
        return $this->display('index');
    }
    public function actionCreateDo(){
        $name = $_GET['name'];
        $course = $_GET['course'];
        $inBooks = $_GET['in_books'];
        $exBooks = $_GET['ex_books'];
        $read = $_GET['read'];
        $readAloud = $_GET['read_aloud'];
        $words = $_GET['words'];
        $min = $_GET['min'];
        $award = $_GET['award'];
        $en_award = $_GET['en_award'];
        $date = $_GET['date'];

        $fileName = $name.'_'.$course.'_'.$inBooks.'_'.$exBooks.'_'.$read.'_'.$readAloud.'_'.$words.'_'.$min.'_'.$award.'_'.$en_award.'_'.$date.'.jpeg';
        $dir = __DIR__.'/../web/static';

        //判断文件是否存在
        if(file_exists($dir.'/download/'.$fileName)) return $fileName;
        
        $image = imagecreatefromjpeg($dir."/graduate.jpg");
        $imageData = getimagesize($dir.'/graduate.jpg');
        $font1 = $dir.'/fonts/NewBaskervilleStd-BoldIt.otf';//英文字体
        $font2 = $dir.'/fonts/JDJLS.TTF';//中文字体
        $font3 = $dir.'/fonts/HYYanKaiW.ttf';//中文字体
        $width = imagesx($image);//图片宽度
        $textcolor1 = imagecolorallocate($image,0,0,0);//字体颜色
        $textcolor2 = imagecolorallocate($image,92,177,172);//字体颜色
        $fontSize1 = 110;//字体大小
        $fontSize2 = 50;
        $text = $name;
        $textInfo = imagettfbbox($fontSize1,0,$font1,$text);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = ceil(($width - $textWidth) / 2);//计算文字的水平位置
        //书写姓名
        imagefttext($image, $fontSize1,0,$x, 1250, $textcolor1, $font1, $text);

        //书写课程
        $str1 = '已顺利完成HiRead英文原版阅读"';
        $str2 = '"';
        $str = $str1.$course.$str2;
        $textInfo = imagettfbbox($fontSize2,0,$font3,$str);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = ceil(($width - $textWidth) / 2);//计算文字的水平位置
        imagefttext($image, $fontSize2,0,$x, 1450, $textcolor1,$font3, $str1);//1
        $textInfo = imagettfbbox($fontSize2,0,$font3,$str1);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = $x + $textWidth + 10;
        imagefttext($image, $fontSize2,0,$x, 1450, $textcolor2,$font3, $course);//2
        $textInfo = imagettfbbox($fontSize2,0,$font3,$course);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = $x + $textWidth;
        imagefttext($image, $fontSize2,0,$x, 1450, $textcolor1,$font3, $str2);//3

        //英文
        $str = 'has successfully completed the online HiRead course';
        $textInfo = imagettfbbox($fontSize2,0,$font1,$str);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = ceil(($width - $textWidth) / 2);//计算文字的水平位置
        imagefttext($image, $fontSize2,0,$x, 1550, $textcolor1,$font1, $str);

        //书写奖励
        $str1 = '并获得了"';
        $str2 = '"';
        $str = $str1.$award.$str2;
        $textInfo = imagettfbbox($fontSize2,0,$font3,$str);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = ceil(($width - $textWidth) / 2);//计算文字的水平位置
        imagefttext($image, $fontSize2,0,$x, 1650, $textcolor1,$font3, $str1);//1
        $textInfo = imagettfbbox($fontSize2,0,$font3,$str1);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = $x + $textWidth;
        imagefttext($image, $fontSize2,0,$x, 1650, $textcolor2,$font3, $award);//2
        $textInfo = imagettfbbox($fontSize2,0,$font3,$award);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = $x + $textWidth;
        imagefttext($image, $fontSize2,0,$x, 1650, $textcolor1,$font3, $str2);//3

        //英文
        $str = 'and is awarded the '.$en_award;
        $textInfo = imagettfbbox($fontSize2,0,$font1,$str);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = ceil(($width - $textWidth) / 2);//计算文字的水平位置
        imagefttext($image, $fontSize2,0,$x, 1750, $textcolor1,$font1, $str);

        //书写日期
        $str = $date;
        $textInfo = imagettfbbox($fontSize2,0,$font1,$str);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = ceil(($width - $textWidth) / 2);//计算文字的水平位置
        imagefttext($image, $fontSize2,0,$x, 1850, $textcolor1,$font1, $str);

        //数据
        $width = 780;
        //精读书本
        $str1 = '精读 ';
        $str2 = ' 本书';
        $str = $str1.$inBooks.$str2;
        $textInfo = imagettfbbox($fontSize2,0,$font3,$str);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = 117 + ceil(($width - $textWidth) / 2);//计算文字的水平位置
        imagefttext($image, $fontSize2,0,$x, 2250, $textcolor1,$font3, $str1);//1
        $textInfo = imagettfbbox($fontSize2,0,$font3,$str1);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = $x + $textWidth;
        imagefttext($image, $fontSize2,0,$x, 2250, $textcolor2,$font3, $inBooks);//2
        $textInfo = imagettfbbox($fontSize2,0,$font3,$inBooks);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = $x + $textWidth;
        imagefttext($image, $fontSize2,0,$x, 2250, $textcolor1,$font3, $str2);//3
        //泛读书本
        $str1 = '泛读 ';
        $str2 = ' 本书';
        $str = $str1.$exBooks.$str2;
        $textInfo = imagettfbbox($fontSize2,0,$font3,$str);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = 117 + ceil(($width - $textWidth) / 2);//计算文字的水平位置
        imagefttext($image, $fontSize2,0,$x, 2350, $textcolor1,$font3, $str1);//1
        $textInfo = imagettfbbox($fontSize2,0,$font3,$str1);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = $x + $textWidth;
        imagefttext($image, $fontSize2,0,$x, 2350, $textcolor2,$font3, $exBooks);//2
        $textInfo = imagettfbbox($fontSize2,0,$font3,$exBooks);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = $x + $textWidth;
        imagefttext($image, $fontSize2,0,$x, 2350, $textcolor1,$font3, $str2);//3
        //累计阅读字数
        $str1 = '累计阅读 ';
        $str2 = ' 字';
        $str = $str1.$read.$str2;
        $textInfo = imagettfbbox($fontSize2,0,$font3,$str);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = 117 + ceil(($width - $textWidth) / 2);//计算文字的水平位置
        imagefttext($image, $fontSize2,0,$x, 2450, $textcolor1,$font3, $str1);//1
        $textInfo = imagettfbbox($fontSize2,0,$font3,$str1);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = $x + $textWidth;
        imagefttext($image, $fontSize2,0,$x, 2450, $textcolor2,$font3, $read);//2
        $textInfo = imagettfbbox($fontSize2,0,$font3,$read);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = $x + $textWidth;
        imagefttext($image, $fontSize2,0,$x, 2450, $textcolor1,$font3, $str2);//3

        //坚持朗读天数
        $str1 = '坚持朗读 ';
        $str2 = ' 天';
        $str = $str1.$readAloud.$str2;
        $textInfo = imagettfbbox($fontSize2,0,$font3,$str);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = 1351 + ceil(($width - $textWidth) / 2);//计算文字的水平位置
        imagefttext($image, $fontSize2,0,$x, 2250, $textcolor1,$font3, $str1);//1
        $textInfo = imagettfbbox($fontSize2,0,$font3,$str1);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = $x + $textWidth;
        imagefttext($image, $fontSize2,0,$x, 2250, $textcolor2,$font3, $readAloud);//2
        $textInfo = imagettfbbox($fontSize2,0,$font3,$readAloud);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = $x + $textWidth;
        imagefttext($image, $fontSize2,0,$x, 2250, $textcolor1,$font3, $str2);//3
        //掌握词组个数
        $str1 = '掌握词组 ';
        $str2 = ' 个';
        $str = $str1.$words.$str2;
        $textInfo = imagettfbbox($fontSize2,0,$font3,$str);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = 1351 + ceil(($width - $textWidth) / 2);//计算文字的水平位置
        imagefttext($image, $fontSize2,0,$x, 2350, $textcolor1,$font3, $str1);//1
        $textInfo = imagettfbbox($fontSize2,0,$font3,$str1);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = $x + $textWidth;
        imagefttext($image, $fontSize2,0,$x, 2350, $textcolor2,$font3, $words);//2
        $textInfo = imagettfbbox($fontSize2,0,$font3,$words);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = $x + $textWidth;
        imagefttext($image, $fontSize2,0,$x, 2350, $textcolor1,$font3, $str2);//3
        //外教互动分钟数
        $str1 = '外教互动 ';
        $str2 = ' 分钟';
        $str = $str1.$min.$str2;
        $textInfo = imagettfbbox($fontSize2,0,$font3,$str);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = 1351 + ceil(($width - $textWidth) / 2);//计算文字的水平位置
        imagefttext($image, $fontSize2,0,$x, 2450, $textcolor1,$font3, $str1);//1
        $textInfo = imagettfbbox($fontSize2,0,$font3,$str1);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = $x + $textWidth;
        imagefttext($image, $fontSize2,0,$x, 2450, $textcolor2,$font3, $min);//2
        $textInfo = imagettfbbox($fontSize2,0,$font3,$min);//获取文字信息
        $textWidth = $textInfo['2'] - $textInfo['0'];//获取文字宽度
        $x = $x + $textWidth;
        imagefttext($image, $fontSize2,0,$x, 2450, $textcolor1,$font3, $str2);//3
        
        // ob_start();
        // header("Content-type: image/jpeg");
        // imagejpeg($image);
        imagejpeg($image,$dir.'/download/'.$fileName);
        imagedestroy($image);
        // exit;
        // ob_end_clean();
        return $fileName;
    }




}