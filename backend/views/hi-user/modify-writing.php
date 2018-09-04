<!-- Content Header (Page header) -->
<style type="text/css">
    .student_img ul{
        display: flex;
    }
    .student_img ul li{
        flex: 1;
        list-style-type:none;
    }
    .student_img ul li img{
        width: 60%;
    }
</style>
<script type="text/javascript" src="/js/wangEditor.min.js"></script>
<section class="content-header">
    <h1>
        <?php echo \Yii::t('app','批改作文')?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?=\Yii::t('app','主页')?></a></li>
        <li><a href="#"><?=\Yii::t('app','用户管理')?></a></li>
        <li class="active"><?=\Yii::t('app','批改作文')?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="?r=hi-user/writing"><i class="fa fa-arrow-circle-o-left"></i> <?=\Yii::t('app','返回')?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="myForm" action="" method="post">
                    <div class="box-body">
                        <table class="table">
                            <tr>
                                <td width="10%">User: <?=$user_info->EnName;?></td>
                                <td >
                                    <?=\Yii::t('app','等级')?>： <?=$course->HLevel?>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">Question:</td>
                                <td>
                                    <?=$question['PreviewIntro']?>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">Student's answer:</td>
                                <td>
                                    <?=$writing['Answer']?>
                                    <br>
                                    <div class="student_img">
                                        <ul>
                                            <?php foreach ($img as $val): ?>
                                                <li><img src="<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_students_writing'].$val['image']?>"></li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">Correcting</td>
                                <td>
                                    <div id="editor">
                                        <?=empty($writing['Modify']) ? $writing['Answer'] : $writing['Modify'];?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">Topic:</td>
                                <td>
                                    <select onchange="showPoint()" name="type">
                                        <?php foreach (\Yii::$app->params['writing-type'] as $key => $val) { ?>
                                            <option <?php if($type == $key) echo 'selected';?> value="<?=$key?>"><?=$val?></option>
                                        <?php }?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">Score:</td>
                                <td>
                                    <div style="display:none;" id="informational">
                                        <?php foreach ($score_rule[1] as $k => $v): ?>
                                            <div>
                                                <b><?=$k?></b>
                                                <?php foreach ($v as $key => $val): ?>
                                                    <div>
                                                        <b>point<?=$key?></b>
                                                        <ol>
                                                            <?php foreach ($val as $value): ?>
                                                                <li><input onclick="computeTotal()" class="score informational" <?php if(in_array($value['id'],$user_score)) echo 'checked'?> type="radio" name="informational_point_<?=$k?>_<?=$key?>"  value="<?=$value['id']?>"><?=$value['name']?><?=$value['score']?></li>
                                                            <?php endforeach ?>
                                                        </ol>
                                                    </div>
                                                <?php endforeach ?>
                                            </div>
                                            <hr>
                                        <?php endforeach ?>
                                    </div>
                                    <div style="display:none;" id="argument">
                                        <?php foreach ($score_rule[2] as $k => $v): ?>
                                            <div>
                                                <b><?=$k?></b>
                                                <?php foreach ($v as $key => $val): ?>
                                                    <div>
                                                        <b>point<?=$key?></b>
                                                        <ol>
                                                            <?php foreach ($val as $value): ?>
                                                                <li><input onclick="computeTotal()" class="score argument" <?php if(in_array($value['id'],$user_score)) echo 'checked'?> type="radio" name="argument_point_<?=$k?>_<?=$key?>" value="<?=$value['id']?>"><?=$value['name']?><?=$value['score']?></li>
                                                            <?php endforeach ?>
                                                        </ol>
                                                    </div>
                                                <?php endforeach ?>
                                            </div>
                                            <hr>
                                        <?php endforeach ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%"></td>
                                <td>
                                    <span style="font-weight:bold;">Total Score:<span id="total_score"><?php echo !empty($total_score) ? $total_score : 0;?></span><span style="margin-left: 20px" id="total_des"><?php echo !empty($total_des) ? $total_des : '';?></span></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">Comments:</td>
                                <td>
                                    <textarea name="comment" id="comment" cols="100%" rows="4"><?php if(!empty($writing['Comment'])) echo $writing['Comment']?></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <input type="hidden" name="id" value="<?php if(!empty($row)) echo $row['id']?>"/>
                        <input name="<?= Yii::$app->request->csrfParam;?>" type="hidden" value="<?= Yii::$app->request->getCsrfToken();?>">
                        <!-- <button type="submit" class="btn btn-primary"><?=\Yii::t('app','提交')?></button> -->
                        <a onclick="submit()" class="btn btn-primary"><?=\Yii::t('app','提交')?></a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<!-- /.content -->
<script type="text/javascript">
    var E = window.wangEditor
    var editor = new E('#editor')
    // 或者 var editor = new E( document.getElementById('editor') )
    // 自定义配置颜色（字体颜色、背景色）
    editor.customConfig.colors = [
        '#000000',
        '#eeece0',
        '#1c487f',
        '#4d80bf',
        '#c24f4a',
        '#8baa4a',
        '#7b5ba1',
        '#46acc8',
        '#f9963b',
        '#ff0000',
        '#ffffff',
    ]
    editor.customConfig.uploadImgServer = '/index.php?r=hi-user/upload-modify-img' // 上传图片到服务器
    // editor.customConfig.uploadImgShowBase64 = true   // 使用 base64 保存图片
    editor.create()
    //获取已选中的得分点
    function getAlCheck()
    {
        var pointName = [];
        var scorePoint = $('select[name=type]').val();//得分项类型
        var input = $('.score');
        var res = input.length;
        var checked = [];
        for (var i = res - 1; i >= 0; i--) {
            if(scorePoint == 1){
                if(!$(input[i]).hasClass('informational')) continue;
            }else{
                if(!$(input[i]).hasClass('argument')) continue;
            }
            if(pointName.indexOf($(input[i]).attr('name')) == -1){
                pointName.push($(input[i]).attr('name'));
            }
        }
        for(i in pointName){
            checked.push($('input:radio[name="'+pointName[i]+'"]:checked').val());
        }
        return checked;
    }
    //提交
    function submit()
    {
        var total_score = $('#total_score').html();
        var checked = getAlCheck();
        var comment = $('#comment').val();
        var scorePoint = $('select[name=type]').val();//得分项类型
        var correcting = editor.txt.html();
        var url = '?r=hi-user/modify-writing';
        var postData = {
            'type':scorePoint,
            'checked':checked,
            'modify':correcting,
            'comment':comment,
            'id':<?=$_GET['id']?>,
            'uid':<?=$_GET['uid']?>,
            'tid':<?=$writing['Tid']?>,
            'score':total_score,
        };
        $.post( url, postData, function(data){
            alert(data.msg);
            if( data.code == 1 ){
                window.location.href = window.location.href;
            }else{
                alert(data.msg);
            }
        }, 'json');
    }
    $(document).ready(function() {
        //显示得分项
        var scorePoint = $('select[name=type]').val();
        if(scorePoint == 1){
            $('#informational').show();
        }else{
            $('#argument').show();
        }
    });
    function showPoint(){
        var type = $('select[name=type]').val();
        if(type == 1){
            $('#informational').show();
            $('#argument').hide();
        }else{
            $('#argument').show();
            $('#informational').hide();
        }
        computeTotal();
    }
    function computeTotal(){
        var checked = getAlCheck();
        var url = '?r=hi-user/compute-total-score';
        var data = {
            'checked':checked,
        }
        $.post( url, data, function(data){
            console.log(data);
            if( data.code == 1 ){
                $('#total_score').html(data.data.total_score);
                $('#total_des').html(data.data.total_des);
            }else{
                $('#total_score').html(0);
                $('#total_des').html('');
            }
        }, 'json');
    }
</script>