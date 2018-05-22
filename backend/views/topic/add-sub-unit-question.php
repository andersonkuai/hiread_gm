<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo empty($question) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','子单元题目')?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?= \Yii::t('app', '主页');?></a></li>
        <li>
            <a href="?r=course/index">
            <?= \Yii::t('app', '课程管理');?>
            </a>
        </li>
        <li class="active">
            <a href="?r=course/index"><?= \Yii::t('app', '课程列表');?></a>
        </li>
        <li class="active">
            <a href="?r=course/structure&id=<?=$_GET['courseId'];?>">
                <?= \Yii::t('app', '课程结构');?>
            </a>
        </li>
        <li class="active">
            <a href="?r=topic/unit-index&courseId=<?php echo $courseId;?>&subUnitId=<?php echo $subUnitId?>">
                <?= \Yii::t('app', '题目管理');?>
            </a>
        </li>
        <li class="active">
            <?php echo empty($question) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?><?=\Yii::t('app','题目')?>
        </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="?r=topic/unit-index&courseId=<?php echo $courseId;?>&subUnitId=<?php echo $subUnitId?>"><i class="fa fa-arrow-circle-o-left"></i> <?=\Yii::t('app','返回')?></a>
                    </div>
                    <div class="box-tools">

                    </div>
                </div>
                <!-- /.box-header -->
                <form role="form" id="myForm" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="questionId" value="<?php if(!empty($question)){echo $question['ID'];}else{echo '';}?>">
                <div class="box-body table-responsive no-padding">
                    <table style="margin-bottom: 20px;background-color: #f5f3e5;" tab="0">
                        <tr>
                            <td>
                                <?= \Yii::t('app', '跳出题目时间');?>：
                            </td>
                            <td>
                                <input style="width: 50px" class="form" name="Min" type="text" value="<?php echo !empty($min) ? $min : '0'; ?>">分
                                <input style="width: 50px" class="form" name="Sec" type="text" value="<?php echo !empty($sec) ? $sec : '0'; ?>">秒
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '题目标题');?>：</td>
                            <td>
                                <input class="form" name="Title"  type="text" value="<?=!empty($question['Title'])?htmlspecialchars($question['Title']):'';?>">&nbsp;&nbsp;&nbsp;&nbsp;
                                <?= \Yii::t('app', '题目类型');?>：
                                <select name="Type" id="">
                                    <?php foreach (\common\enums\Topic::params('type') as $keyType=>$valType){ ?>
                                        <option value="<?= $keyType;?>" <?php if(!empty($question['Type']) && $question['Type'] == $keyType){echo 'selected';}?>><?= $valType;?></option>
                                    <?php }?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '题目图片');?>：</td>
                            <td>
                                <input class="form" name="Image" type="text" value="<?php echo !empty($question['Image'])? $question['Image'] : '' ?>">
                                <span  id="questionPicTr">
                                    <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadImg('unit_topic_img',this)" accept="image/*" />
                                    <span class="btn-upload" id="CoverImg_btn"></span>
                                </span>&nbsp;&nbsp;
                                <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('unit_topic_img',this)"><?= \Yii::t('app', '查看');?></a>
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '题目音频');?>：</td>
                            <td>
                                <input class="form" name="Audio" type="text" value="<?php echo !empty($question['Audio'])? $question['Audio'] : '' ?>">
                                <span  id="questionPicTr">
                                    <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('unit_topic_audio',this)" />
                                    <span class="btn-upload" id="CoverImg_btn"></span>
                                </span>&nbsp;&nbsp;
                                <a class="btn btn-sm btn-primary" href="##" onclick="playAudio('unit_topic_audio',this)"><?= \Yii::t('app', '试听');?></a>
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '题目描述音频');?>：</td>
                            <td>
                                <input class="form" name="QAudio" type="text" value="<?= !empty($question['QAudio'])? $question['QAudio'] : '' ?>">
                                <span  id="questionPicTr">
                                    <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('unit_question_des_audio',this)"  />
                                    <span class="btn-upload" id="CoverImg_btn"></span>
                                </span>&nbsp;&nbsp;
                                <a class="btn btn-sm btn-primary" href="##" onclick="playAudio('unit_question_des_audio',this)"><?= \Yii::t('app', '试听');?></a>
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '题目视频');?>：</td>
                            <td>
                                <input class="form" name="Video" type="text" value="<?php echo !empty($question['Video'])? $question['Video'] : '' ?>">
                                <span  id="questionPicTr">
                                    <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('unit_topic_video',this)" />
                                    <span class="btn-upload" id="CoverImg_btn"></span>
                                </span>&nbsp;&nbsp;
                                <a class="btn btn-sm btn-primary" href="##" onclick="playAudio('unit_topic_video',this)"><?= \Yii::t('app', '查看');?></a>
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '视频封面');?>：</td>
                            <td>
                                <input class="form" name="Poster" type="text" value="<?php echo !empty($question['Poster'])? $question['Poster'] : '' ?>">
                                <span  id="questionPicTr">
                                    <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('unit_topic_poster',this)" accept="image/*" />
                                    <span class="btn-upload" id="CoverImg_btn"></span>
                                </span>&nbsp;&nbsp;
                                <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('unit_topic_poster',this)"><?= \Yii::t('app', '查看');?></a>
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '音标');?>：</td>
                            <td>
                                <input class="form" name="SoundMark"  type="text" value="<?=!empty($question['SoundMark'])?htmlspecialchars($question['SoundMark']):'';?>">&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '中文注释');?>：</td>
                            <td>
                                <input class="form" name="CNMark"  type="text" value="<?=!empty($question['CNMark'])?htmlspecialchars($question['CNMark']):'';?>">&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '英文注释');?>：</td>
                            <td>
                                <input class="form" name="ENMark"  type="text" value="<?=!empty($question['ENMark'])?htmlspecialchars($question['ENMark']):'';?>">&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '例句');?>：</td>
                            <td>
                                <input class="form" name="Sample"  type="text" value="<?=!empty($question['Sample'])?htmlspecialchars($question['Sample']):'';?>">&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '例句音频');?>：</td>
                            <td>
                                <input class="form" name="SampleAudio" type="text" value="<?= !empty($question['SampleAudio'])? $question['SampleAudio'] : '' ?>">
                                <span  id="questionPicTr">
                                    <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('unit_SampleAudio',this)"  />
                                    <span class="btn-upload" id="CoverImg_btn"></span>
                                </span>&nbsp;&nbsp;
                                <a class="btn btn-sm btn-primary" href="##" onclick="playAudio('unit_SampleAudio',this)"><?= \Yii::t('app', '试听');?></a>
                            </td>
                        </tr>

                        <tr>
                            <td><?= \Yii::t('app', '题目描述');?>：</td>
                            <td>
                                <textarea name="PreviewIntro" id="" cols="50" rows="5"><?= !empty($question['PreviewIntro'])? $question['PreviewIntro'] : '' ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?= \Yii::t('app', '答案');?>：
                            </td>
                            <td>
                                <?php require ('answer.php')?>
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '题目解析');?>：</td>
                            <td>
                                <textarea name="Analysis" id="" cols="50" rows="5"><?= !empty($question['Analysis'])? $question['Analysis'] : '' ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '题目解析音频');?>：</td>
                            <td>
                                <input class="form" name="AAudio" type="text" value="<?= !empty($question['AAudio'])? $question['AAudio'] : '' ?>">
                                <span  id="questionPicTr">
                                    <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('unit_question_des_aaudio',this)" />
                                    <span class="btn-upload" id="CoverImg_btn"></span>
                                </span>&nbsp;&nbsp;
                                <a class="btn btn-sm btn-primary" href="##" onclick="playAudio('unit_question_des_aaudio',this)"><?= \Yii::t('app', '试听');?></a>
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '题目解析视频');?>：</td>
                            <td>
                                <input class="form" name="AVideo" type="text" value="<?= !empty($question['AVideo'])? $question['AVideo'] : '' ?>">
                                <span  id="questionPicTr">
                                    <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('unit_question_des_avideo',this)" />
                                    <span class="btn-upload" id="CoverImg_btn"></span>
                                </span>&nbsp;&nbsp;
                                <a class="btn btn-sm btn-primary" href="##" onclick="playAudio('unit_question_des_avideo',this)"><?= \Yii::t('app', '查看');?></a>
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '翻译');?>：</td>
                            <td>
                                <textarea name="Translate" id="" cols="50" rows="5"><?= !empty($question['Translate'])? $question['Translate'] : '' ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '提示信息');?>：</td>
                            <td>
                                <textarea name="Help" id="" cols="50" rows="5"><?= !empty($question['Help'])? $question['Help'] : '' ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '矩阵大小');?>：</td>
                            <td>
                                <?php
                                    if(!empty($question['Matrix'])){
                                        $matrixArray = explode('_',$question['Matrix']);
                                        if(!empty($matrixArray[0]) && !empty($matrixArray[1])){
                                            $matrixA = $matrixArray[0];
                                            $matrixB = $matrixArray[1];
                                        }
                                    }
                                ?>
                                <input style="width: 30px" name="MatrixA" id=""type="text" value="<?= !empty($matrixA)? $matrixA : '' ?>" />
                                *
                                <input style="width: 30px" name="MatrixB" id=""type="text" value="<?= !empty($matrixB)? $matrixB : '' ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '获得金币数量');?>：</td>
                            <td>
                                <input name="Gold" id=""type="text" value="<?= !empty($question['Gold'])? $question['Gold'] : 0 ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', '是否是练习题目');?>：</td>
                            <td>
                                <select name="IsTrain" id="">
                                    <option value="0" <?php if(isset($question['IsTrain']) && $question['IsTrain'] == 0) echo 'selected';?>>否</option>
                                    <option value="1" <?php if(isset($question['IsTrain']) && $question['IsTrain'] == 1) echo 'selected';?>>是</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?= \Yii::t('app', 'CCSS细项');?>：</td>
                            <td>
                                <input name="Category" id=""type="text" value="<?= !empty($question['Category'])? $question['Category'] : 0 ?>" />
                            </td>
                        </tr>
                    </table>
                </div>
                <input type="hidden" name="questionId" value="<?php echo !empty($question['ID']) ? $question['ID']: '';?>"/>
                <input name="<?= Yii::$app->request->csrfParam;?>" type="hidden" value="<?= Yii::$app->request->getCsrfToken();?>">
                <button style="margin-top: 20px" type="submit" class="btn btn-primary">提交</button>
                </form>
                <!-- /.box-body -->
                <div class="box-footer clearfix">

                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->
<script>
    $(document).ready(function() {
        $('#myForm').ajaxForm({
            dataType:"json",
            success:function(data){
                console.log(data);
                alert(data.msg);
                if(data.code == 1){
                    document.location.reload();
                }
            }
        });
    });
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
            case 'unit_topic_img'://泛读题目图片
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_unit_topic_img']; ?>' + imgName
                break;
            case 'unit_topic_poster'://单元视频封面
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_unit_topic_poster']; ?>' + imgName
                break;
            case 'extensive_answer_Pair1Img'://泛读配对图片
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_answer_Pair1Img']; ?>' + imgName
                break;
            case 'extensive_answer_Pair1Audio'://泛读配对音频
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_answer_Pair1Audio']; ?>' + imgName
                break;
            case 'extensive_answer_image'://泛读题目图片
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_answer_image']; ?>' + imgName
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
            case 'unit_topic_audio'://单元题目音频
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_unit_topic_audio']; ?>' + imgName
                break;
            case 'unit_question_des_audio'://单元题目描述音频
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_unit_question_des_audio']; ?>' + imgName
                break;
            case 'unit_topic_video'://单元题目视频
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_unit_topic_video']; ?>' + imgName
                break;
            case 'unit_SampleAudio'://单元例句音频
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_unit_SampleAudio']; ?>' + imgName
                break;
            case 'unit_question_des_aaudio'://题目解析音频
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_unit_question_des_aaudio']; ?>' + imgName
                break;
            case 'unit_question_des_avideo'://题目解析视频
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_unit_question_des_avideo']; ?>' + imgName
                break;
            default:
                href = '';
                break;
        }
        window.open(href);
    }
</script>