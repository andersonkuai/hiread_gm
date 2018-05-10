<?php

if(YII_ENV == 1){
    //本地
    $static_dir = 'F:/project_svn/pc/www/static/';
    $static_hiread = 'http://kail-static.hiread.cn/';
    define('HIREADURL','http://kail.hiread.cn/');
}elseif(YII_ENV == 2){
    //测试服
    $static_dir = dirname(dirname(dirname(dirname(__FILE__)))).'/hiread/www/static/';
    $static_hiread = 'https://static.dev.hiread.cn/';
    define('HIREADURL','https://dev.hiread.cn/');
}elseif(YII_ENV == 3){
    //线上
    $static_dir = dirname(dirname(dirname(dirname(__FILE__)))).'/static/';
    $static_hiread = 'https://cdn1.hiread.cn/';
    define('HIREADURL','https://hiread.cn/');
}
return [
    //文件域名
    'static_hiread' => $static_hiread,

    //课程封面地址
    'CoverImg' => $static_dir.'/course/book/',
    'view_CoverImg' => 'course/book/',//查看目录
    //课程简介图片地址
    'DetailImg' => $static_dir.'/course/book/',
    'view_DetailImg' => 'course/book/',//查看目录
    //作者头像目录
    'Author' => $static_dir.'/course/book/',
    'view_Author' => 'course/book/',//查看目录
    //课程包地址
    'package' => $static_dir.'/course/book/',
    'view_package' => 'course/book/',//查看目录
    //每日朗读音频
    'read_audio' => $static_dir.'/course/book/',
    'view_read_audio' => 'course/book/',
    /**
     * 泛读
     */
    //泛读封面地址
    'Poster' => $static_dir.'/course/question/image/extensive/',
    'view_extensive_cover_img' => 'course/question/image/extensive/',//查看目录
    //泛读视频地址
    'extensive_video' => $static_dir.'/course/question/video/extensive/',
    'view_extensive_video' => 'course/question/video/extensive/',//查看目录
    //泛读题目图片
    'extensive_topic_img' => $static_dir.'/course/question/image/',
    'view_extensive_topic_img' => 'course/question/image/',//查看目录
    //泛读题目音频
    'extensive_topic_audio' => $static_dir.'/course/question/audio/',
    'view_extensive_topic_audio' => 'course/question/audio/',//查看目录
    //泛读题目描述音频文件
    'extensive_question_des_audio' => $static_dir.'/course/question/audio/',
    'view_extensive_question_des_audio' => 'course/question/audio/',//查看目录
    //泛读题目解析音频
    'extensive_question_des_aaudio' => $static_dir.'/course/answer/audio/',
    'view_extensive_question_des_aaudio' => 'course/answer/audio/',//查看目录
    //泛读题目解析视频
    'extensive_question_des_avideo' => $static_dir.'/course/answer/video/',
    'view_extensive_question_des_avideo' => 'course/answer/video/',//查看目录
    //泛读答案图片
    'extensive_answer_image' => $static_dir.'/course/answer/image/',
    'view_extensive_answer_image' => 'course/answer/image/',//查看目录
    //泛读答案配对图片
    'extensive_answer_Pair1Img' => $static_dir.'/course/answer/image/',
    'view_extensive_answer_Pair1Img' => 'course/answer/image/',//查看目录
    //泛读答案配对音频
    'extensive_answer_Pair1Audio' => $static_dir.'/course/answer/audio/',
    'view_extensive_answer_Pair1Audio' => 'course/answer/audio/',//查看目录
    /**
     * 精读
     */
    //题目图片
    'unit_topic_img' => $static_dir.'/course/question/image/',
    'view_unit_topic_img' => 'course/question/image/',//查看目录
    //题目音频
    'unit_topic_audio' => $static_dir.'/course/question/audio/',
    'view_unit_topic_audio' => 'course/question/audio/',//查看目录
    //题目描述音频
    'unit_question_des_audio' => $static_dir.'/course/question/audio/',
    'view_unit_question_des_audio' => 'course/question/audio/',//查看目录
    //题目视频地址
    'unit_topic_video' => $static_dir.'/course/question/video/',
    'view_unit_topic_video' => 'course/question/video/',//查看目录
    //视频封面
    'unit_topic_poster' => $static_dir.'/course/question/image/',
    'view_unit_topic_poster' => 'course/question/image/',//查看目录
    //例句音频
    'unit_SampleAudio' => $static_dir.'/course/question/audio/',
    'view_unit_SampleAudio' => 'course/question/audio/',//查看目录
    //题目解析音频
    'unit_question_des_aaudio' => $static_dir.'/course/answer/audio/',
    'view_unit_question_des_aaudio' => 'course/answer/audio/',//查看目录
    //题目解析视频
    'unit_question_des_avideo' => $static_dir.'/course/answer/video/',
    'view_unit_question_des_avideo' => 'course/answer/video/',//查看目录
];
