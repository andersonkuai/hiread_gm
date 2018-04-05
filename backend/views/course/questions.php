<form role="form" id="myForm" action="" method="post" enctype="multipart/form-data">
<div class="row">
    <div class="col-xs-10">
        <?= \Yii::t('app', '跳出题目时间');?>：
        <input style="width: 50px" class="form" name="appearMin" type="text" value="<?php echo !empty($v['extensiveTopicList']['Min']) ? $v['extensiveTopicList']['Min'] : ''; ?>">分
        <input style="width: 50px" class="form" name="appearSec" type="text" value="<?php echo !empty($v['extensiveTopicList']['Sec']) ? $v['extensiveTopicList']['Sec'] : ''; ?>">秒
        <?php if(!empty($v['extensiveTopicList'])) { ?>
            <?php foreach ($v['extensiveTopicList']['Questions'] as $key=>$val){ ?>
                <table style="margin-bottom: 20px;background-color: #C6E746;" tab="<?=$key?>">
                    <tr>
                        <td><?= \Yii::t('app', '题目标题');?>：</td>
                        <td>
                            <input class="form" name="Title[]"  type="text" value="<?php echo empty($val) ? '' : $val['Title'];?>">&nbsp;&nbsp;&nbsp;&nbsp;
                            <?= \Yii::t('app', '题目类型');?>：
                            <select name="Type[]">
                                <?php foreach (\common\enums\Topic::params('type') as $key_t=>$val_t){ ?>
                                    <option value="<?= $key_t;?>" <?php if($key_t == $val['Type']) echo 'selected';?>><?= $val_t;?></option>
                                <?php }?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?= \Yii::t('app', '题目图片');?>：</td>
                        <td>
                            <input class="form" name="Image[]" type="text" value="<?php echo empty($val) ? '' : $val['Image'];?>">
                            <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadImg('extensive_topic_img',this)" accept="image/*" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
                            <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('extensive_topic_img',this)"><?= \Yii::t('app', '查看');?></a>
                        </td>
                    </tr>
                    <tr>
                        <td><?= \Yii::t('app', '题目音频');?>：</td>
                        <td>
                            <input class="form" name="Audio[]" type="text" value="<?php echo empty($val) ? '' : $val['Audio'];?>">
                            <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('extensive_topic_audio',this)" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
                            <a class="btn btn-sm btn-primary" href="##" onclick="playAudio('extensive_topic_audio',this)"><?= \Yii::t('app', '试听');?></a>
                        </td>
                    </tr>
                    <tr>
                        <td><?= \Yii::t('app', '题目描述音频');?>：</td>
                        <td>
                            <input class="form" name="QAudio[]" type="text" value="<?php echo empty($val) ? '' : $val['QAudio'];?>">
                            <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('extensive_question_des_audio',this)"  />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
                            <a class="btn btn-sm btn-primary" href="##" onclick="playAudio('extensive_question_des_audio',this)"><?= \Yii::t('app', '试听');?></a>
                        </td>
                    </tr>
                    <tr>
                        <td><?= \Yii::t('app', '答案');?>：</td>
                        <td>
                            <?php require ('answer.php')?>
                        </td>
                    </tr>
                    <tr>
                        <td><?= \Yii::t('app', '题目解析');?>：</td>
                        <td>
                            <textarea name="Analysis[]" id="" cols="50" rows="5"><?=$val['Analysis']?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td><?= \Yii::t('app', '题目解析音频');?>：</td>
                        <td>
                            <input class="form" name="AAudio[]" type="text" value="<?php echo empty($val) ? '' : $val['AAudio'];?>">
                            <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('extensive_question_des_aaudio',this)" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
                            <a class="btn btn-sm btn-primary" href="##" onclick="playAudio('extensive_question_des_aaudio',this)"><?= \Yii::t('app', '试听');?></a>
                        </td>
                    </tr>
                    <tr>
                        <td><?= \Yii::t('app', '题目解析视频');?>：</td>
                        <td>
                            <input class="form" name="AVideo[]" type="text" value="<?php echo empty($val) ? '' : $val['AVideo'];?>">
                            <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('extensive_question_des_avideo',this)" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
                            <a class="btn btn-sm btn-primary" href="##" onclick="playAudio('extensive_question_des_avideo',this)"><?= \Yii::t('app', '查看');?></a>
                        </td>
                    </tr>
                    <tr>
                        <td><?= \Yii::t('app', '翻译');?>：</td>
                        <td>
                            <textarea name="Translate[]" id="" cols="50" rows="5"><?php echo empty($val) ? '' : $val['Translate'];?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td><?= \Yii::t('app', '提示信息');?>：</td>
                        <td>
                            <textarea name="Help[]" id="" cols="50" rows="5"><?php echo empty($val) ? '' : $val['Help'];?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td><?= \Yii::t('app', '矩阵大小');?>：</td>
                        <td>
                            <?php
                                $Matrix = ['',''];
                                if(!empty($val['Matrix'])){
                                    $Matrix = explode('_',$val['Matrix']);
                                }
                            ?>
                            <input style="width: 30px" name="MatrixA[]" id=""type="text" value="<?=$Matrix[0]?>" />*<input style="width: 30px" name="MatrixB[]" id=""type="text" value="<?=$Matrix[1]?>" />
                        </td>
                    </tr>
                    <tr>
                        <td><?= \Yii::t('app', '获得金币数量');?>：</td>
                        <td>
                            <input name="Gold[]" id=""type="text" value="<?php echo empty($val) ? '' : $val['Gold'];?>" />
                        </td>
                    </tr>
                    <tr>
                        <td><?= \Yii::t('app', '是否是练习题目');?>：</td>
                        <td>
                            <select name="IsTrain[]" id="">
                                <option value="1" <?php echo $val['IsTrain'] == 1 ? 'selected ' : '';?>>是</option>
                                <option value="0" <?php echo $val['IsTrain'] == 0 ? 'selected ' : '';?>>否</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?= \Yii::t('app', 'CCSS细项');?>：</td>
                        <td>
                            <input name="Category[]" id=""type="text" value="<?php echo empty($val) ? '' : $val['Category'];?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a onclick="addData(this)" style="font-size: xx-large" class="fa fa-plus"></a>
                            <a onclick="minusData(this)" style="font-size: xx-large" class="fa fa-minus"></a>
                        </td>
                    </tr>
                </table>
            <?php } ?>
        <?php }else{ ?>
            <table style="margin-bottom: 20px;background-color: #C6E746;" tab="0">
                <tr>
                    <td><?= \Yii::t('app', '题目标题');?>：</td>
                    <td>
                        <input class="form" name="Title[]"  type="text" value="<?php echo empty($row) ? '' : $row['ProdName'];?>">&nbsp;&nbsp;&nbsp;&nbsp;
                        <?= \Yii::t('app', '题目类型');?>：
                        <select name="Type[]" id="">
                            <?php foreach (\common\enums\Topic::params('type') as $keyType=>$valType){ ?>
                                <option value="<?= $keyType;?>"><?= $valType;?></option>
                            <?php }?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?= \Yii::t('app', '题目图片');?>：</td>
                    <td>
                        <input class="form" name="Image[]" type="text" value="<?php echo empty($row) ? '' : $row['CoverImg'];?>">
                        <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadImg('extensive_topic_img',this)" accept="image/*" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
                        <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('extensive_topic_img',this)"><?= \Yii::t('app', '查看');?></a>
                    </td>
                </tr>
                <tr>
                    <td><?= \Yii::t('app', '题目音频');?>：</td>
                    <td>
                        <input class="form" name="Audio[]" type="text" value="<?php echo empty($row) ? '' : $row['CoverImg'];?>">
                        <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('extensive_topic_audio',this)" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
                        <a class="btn btn-sm btn-primary" href="##" onclick="playAudio('extensive_topic_audio',this)"><?= \Yii::t('app', '试听');?></a>
                    </td>
                </tr>
                <tr>
                    <td><?= \Yii::t('app', '题目描述音频');?>：</td>
                    <td>
                        <input class="form" name="QAudio[]" type="text" value="<?php echo empty($row) ? '' : $row['CoverImg'];?>">
                        <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('extensive_question_des_audio',this)"  />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
                        <a class="btn btn-sm btn-primary" href="##" onclick="playAudio('extensive_question_des_audio',this)"><?= \Yii::t('app', '试听');?></a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?= \Yii::t('app', '答案');?>：
                    </td>
                    <td>
                        <?php require('answer.php');?>
                    </td>
                </tr>
                <tr>
                    <td><?= \Yii::t('app', '题目解析');?>：</td>
                    <td>
                        <textarea name="Analysis[]" id="" cols="50" rows="5"></textarea>
                    </td>
                </tr>
                <tr>
                    <td><?= \Yii::t('app', '题目解析音频');?>：</td>
                    <td>
                        <input class="form" name="AAudio[]" type="text" value="<?php echo empty($row) ? '' : $row['CoverImg'];?>">
                        <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('extensive_question_des_aaudio',this)" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
                        <a class="btn btn-sm btn-primary" href="##" onclick="playAudio('extensive_question_des_aaudio',this)"><?= \Yii::t('app', '试听');?></a>
                    </td>
                </tr>
                <tr>
                    <td><?= \Yii::t('app', '题目解析视频');?>：</td>
                    <td>
                        <input class="form" name="AVideo[]" type="text" value="<?php echo empty($row) ? '' : $row['CoverImg'];?>">
                        <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('extensive_question_des_avideo',this)" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
                        <a class="btn btn-sm btn-primary" href="##" onclick="playAudio('extensive_question_des_avideo',this)"><?= \Yii::t('app', '查看');?></a>
                    </td>
                </tr>
                <tr>
                    <td><?= \Yii::t('app', '翻译');?>：</td>
                    <td>
                        <textarea name="Translate[]" id="" cols="50" rows="5"></textarea>
                    </td>
                </tr>
                <tr>
                    <td><?= \Yii::t('app', '提示信息');?>：</td>
                    <td>
                        <textarea name="Help[]" id="" cols="50" rows="5"></textarea>
                    </td>
                </tr>
                <tr>
                    <td><?= \Yii::t('app', '矩阵大小');?>：</td>
                    <td>
                        <input style="width: 30px" name="MatrixA[]" id=""type="text" />*<input style="width: 30px" name="MatrixB[]" id=""type="text" />
                    </td>
                </tr>
                <tr>
                    <td><?= \Yii::t('app', '获得金币数量');?>：</td>
                    <td>
                        <input name="Gold[]" id=""type="text" />
                    </td>
                </tr>
                <tr>
                    <td><?= \Yii::t('app', '是否是练习题目');?>：</td>
                    <td>
                        <select name="IsTrain[]" id="">
                            <option value="1">是</option>
                            <option value="0">否</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?= \Yii::t('app', 'CCSS细项');?>：</td>
                    <td>
                        <input name="Category[]" id=""type="text" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <a onclick="addData(this)" style="font-size: xx-large" class="fa fa-plus"></a>
                        <a onclick="minusData(this)" style="font-size: xx-large" class="fa fa-minus"></a>
                    </td>
                </tr>
            </table>
        <?php } ?>
    </div>
</div>

<input type="hidden" name="extensiveId" value="<?php echo $v['ID'];?>"/>
<input name="<?= Yii::$app->request->csrfParam;?>" type="hidden" value="<?= Yii::$app->request->getCsrfToken();?>">
<button style="margin-top: 20px" type="submit" onclick="submitQuestion(this)" class="btn btn-primary">提交</button>
</form>
<script>

</script>
<script>
    function addData(obj) {
        var dom = $(obj).parent().parent().parent().parent().parent().children('table').last()
        var id = parseInt(dom.attr('tab')) + 1;
        //获取当前table元素
        var tr = $(obj).parent().parent().parent().parent()


        //获取html标签
        var str = $(tr.find('ul').get(0)).parent().html()
        //ul标签
        var ul = tr.find('ul').get(0);
        var ulstr = ul.outerHTML;
        //替换name值
        var nameKey = $($(ul).find('input').get(0)).attr('name').slice(11,12)
        var grepVal = '\\['+nameKey+'\\]'
        var ul1 = ulstr.replace(new RegExp(grepVal,'gm'),'['+id+']');

        var str1 = tr.html().replace(str,ul1);



        var html = '<table tab="'+id+'" style="margin-bottom: 20px;background-color: #C6E746;">' + str1 + '</table>';
        tr.after(html);
    }
    function minusData(obj) {
        //获取当前tr元素
        var tr = $(obj).parent().parent().parent().parent()
        tr.remove();
    }
</script>

<script>
    //上传图片
    function uploadImg(action,obj) {
        var fileDom = $(obj);
        var btn = $(obj).next()
        var url = "index.php?r=course/uploadimg&action="+action
        fileDom.wrap('<form action="'+url+'" method="post" enctype="multipart/form-data"></form>');
        fileDom.parent().ajaxSubmit({
            dataType:  'json',
            beforeSend: function() {
                var percentVal = '0%';
                btn.addClass('disabled').text("上传中...");
            },
            uploadProgress: function(event, position, total, percentComplete) {
                btn.addClass('disabled').text("上传中..."+percentComplete + '%');
            },
            success: function(data) {
                console.log(data);
                if(data.code == 1){
                    btn.addClass('disabled').html("<span style='color: #00aa00'>上传成功</span>");
                    $(obj).parent().parent().prev().val(data.pic)
                }
                fileDom.unwrap();
            },
            error:function(xhr){
                alert('上传失败');
                fileDom.unwrap();
            }
        });
    }
    //上传文件
    function uploadFile(action,obj) {
        var fileDom = $(obj);
        var btn = $(obj).next()
        var url = "index.php?r=course/upload-file&action="+action
        fileDom.wrap('<form action="'+url+'" method="post" enctype="multipart/form-data"></form>');
        fileDom.parent().ajaxSubmit({
            dataType:  'json',
            beforeSend: function() {
                var percentVal = '0%';
                btn.addClass('disabled').text("上传中...");
            },
            uploadProgress: function(event, position, total, percentComplete) {
                btn.addClass('disabled').text("上传中..."+percentComplete + '%');
            },
            success: function(data) {
                console.log(data);
                if(data.code == 1){
                    btn.addClass('disabled').html("<span style='color: #00aa00'>上传成功</span>");
                    $(obj).parent().parent().prev().val(data.pic)
                }
                fileDom.unwrap();
            },
            error:function(xhr){
                alert('上传失败');
                fileDom.unwrap();
            }
        });
    }
    //查看文件
    function viewFile(action,obj) {
        //获取图片名称
        var imgName = $(obj).prev().prev().val()
        //获取查看目录
        var href = '';
        switch(action)
        {
            case 'extensive_topic_img'://泛读题目图片
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_topic_img']; ?>' + imgName
                break;
            case 'extensive_answer_image'://泛读答案图片
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_answer_image']; ?>' + imgName
                break;
            case 'extensive_answer_Pair1Img'://泛读配对图片
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_answer_Pair1Img']; ?>' + imgName
                break;
            case 'extensive_answer_Pair1Audio'://泛读配对音频
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_answer_Pair1Audio']; ?>' + imgName
                break;
            default:
                href = '';
                break;
        }
        window.open(href);
    }
    //播放音频
    function playAudio(action,obj) {
        //获取图片名称
        var imgName = $(obj).prev().prev().val()
        //获取查看目录
        var href = '';
        switch(action)
        {
            case 'extensive_topic_audio'://泛读题目音频
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_topic_audio']; ?>' + imgName
                break;
            case 'extensive_question_des_audio'://泛读题目描述音频
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_question_des_audio']; ?>' + imgName
                break;
            case 'extensive_question_des_aaudio'://题目解析音频
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_question_des_aaudio']; ?>' + imgName
                break;
            case 'extensive_question_des_avideo'://题目解析视频
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_question_des_avideo']; ?>' + imgName
                break;
            default:
                href = '';
                break;
        }
        window.open(href);
    }
    function submitQuestion(obj) {
        $(obj).parent().ajaxForm({
            dataType:"json",
            success:function(data){
                console.log(data);
                alert(data.msg);
                if(data.code == 1){
                }
            }
        });
    }
</script>
<script>
    function addAnswer(obj) {
        //获取当前table元素
        var tr = $(obj).parent().parent()
        //获取tab值
        var tab = $(obj).parent().parent().parent().parent().parent().parent().attr('tab')
        //获取html标签
        var str = tr.html();
        var nameKey = $($(obj).parent().parent().find('input').get(0)).attr('name').slice(10,13)
        var str1 = str.replace(new RegExp(nameKey,'gm'),tab);
        var html = '<ul style="margin-top: 20px;background-color: burlywood">' + str1 + '</ul>';
        tr.after(html)
    }
    function minusAnswer(obj) {
        //获取当前tr元素
        var tr = $(obj).parent().parent()
        tr.remove();
    }
</script>