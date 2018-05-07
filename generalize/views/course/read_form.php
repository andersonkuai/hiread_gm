<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo empty($row) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','每日朗读')?>
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
            <a href="?r=course/read&courseId=<?=$_GET['courseId'];?>&unitId=<?=$_GET['unitId'];?>">
                <?= \Yii::t('app', '每日朗读列表');?>
            </a>
        </li>
        <li class="active"><?php echo empty($row) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?><?=\Yii::t('app','每日朗读')?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="?r=course/read&courseId=<?=$_GET['courseId'];?>&unitId=<?=$_GET['unitId'];?>"><i class="fa fa-arrow-circle-o-left"></i> <?=\Yii::t('app','返回')?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="myForm" action="" method="post">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-8">
                                <table style="margin-bottom: 30px">
                                    <tr>
                                        <td><?= \Yii::t('app', '课程ID');?>：</td>
                                        <td>
                                            <?=$_GET['courseId']?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '单元ID');?>：</td>
                                        <td>
                                            <?=$_GET['unitId']?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '名称');?>：</td>
                                        <td>
                                            <input type="text" name="Name" value="<?php if(!empty($row)) echo $row['Name'];?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '章节');?>：</td>
                                        <td>
                                            <input type="text" name="Chapter" value="<?php if(!empty($row)) echo $row['Chapter'];?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '页码');?>：</td>
                                        <td>
                                            <input type="text" name="Page" value="<?php if(!empty($row)) echo $row['Page'];?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '段落');?>：</td>
                                        <td>
                                            <input type="text" name="Segment" value="<?php if(!empty($row)) echo $row['Segment'];?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '音频');?>：</td>
                                        <td>
                                            <input class="form" name="AudioUrl" type="text" value="<?php echo !empty($row['AudioUrl'])? $row['AudioUrl'] : '' ?>">
                                            <span  id="questionPicTr">
                                                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('read_audio',this)" />
                                                <span class="btn-upload" id="CoverImg_btn"></span>
                                            </span>&nbsp;&nbsp;
                                            <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('read_audio',this)"><?= \Yii::t('app', '试听');?></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '必读内容');?>：</td>
                                        <td>
                                            <textarea name="Content" id="" cols="40" rows="5"><?php echo !empty($row['Content'])? $row['Content'] : '' ?></textarea>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <input type="hidden" name="id" value="<?php echo !empty($row) ? $row['ID'] : '';?>"/>
                        <input name="<?= Yii::$app->request->csrfParam;?>" type="hidden" value="<?= Yii::$app->request->getCsrfToken();?>">
                        <button type="submit" class="btn btn-primary"><?=\Yii::t('app','提交')?></button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<!-- /.content -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#myForm').ajaxForm({
            dataType:"json",
            success:function(data){
                alert(data.msg);
                if(data.code == 1){
                    location.reload();
                }
            }
        });
    });
    //添加子单元
    function addSubUnit(obj) {
        var dom = $(obj).parent().parent();
        var html = '<tr>' + dom.html() + '</tr>';
        dom.after(html)
    }
    //删除子单元
    function minusSubUnit(obj) {
        var dom = $(obj).parent().parent();
        dom.remove()
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
            case 'read_audio'://每日朗读音频
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_read_audio']; ?>' + imgName
                break;
            default:
                href = '';
                break;
        }
        window.open(href);
    }
</script>
