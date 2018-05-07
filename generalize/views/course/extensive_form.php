<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo empty($extensive) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','泛读')?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?=\Yii::t('app','主页')?></a></li>
        <li><a href="#"><?=\Yii::t('app','课程结构')?></a></li>
        <li class="active"><?php echo empty($extensive) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','泛读')?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="?r=course/structure&id=<?php echo $_GET['courseId'];?>"><i class="fa fa-arrow-circle-o-left"></i> <?=\Yii::t('app','返回')?></a>
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
                                        <td><?= \Yii::t('app', '泛读标题');?>：</td>
                                        <td>
                                            <input class="form" name="Title" type="text" value="<?php echo empty($extensive) ? '' : $extensive['Title'];?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '视频');?>：</td>
                                        <td>
                                            <input class="form" name="Video" type="text" value="<?php echo empty($extensive) ? '' : $extensive['Video'];?>">
                                            <span  id="VideoTr">
                                                <input style="display: inline-block" class="fileupload" type="file" name="VideoSource" id="VideoSource" onchange="uploadExtensiveVideo(this)" />
                                                <span class="btn-upload"></span>
                                            </span>&nbsp;&nbsp;
                                            <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('Video',this)"><?= \Yii::t('app', '查看');?></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '视频封面');?>：</td>
                                        <td>
                                            <input class="form" name="Poster" type="text" value="<?php echo empty($extensive) ? '' : $extensive['Poster'];?>">
                                            <span  id="PosterPicTr">
                                                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="Poster_pic" onchange="uploadExtensiveVideoImg(this)" accept="image/*" />
                                                <span class="btn-upload" id="Poster_btn"></span>
                                            </span>&nbsp;&nbsp;
                                            <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('Poster',this)"><?= \Yii::t('app', '查看');?></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '开放日期');?>：</td>
                                        <td>
                                            <input class="form" name="OpenDay" type="text" value="<?php echo !empty($extensive['OpenDay']) ? date('Ymd',$extensive['OpenDay']) : 0 ;?>"> 格式：20180129，0:没有限制
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <?php if(!empty($extensive)){?>
                            <input type="hidden" name="extensiveId" value="<?php echo $extensive['ID']?>"/>
                        <?php }?>
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
                    location.href = location.href ;
                }
            }
        });
    });
    //查看文件
    function viewFile(action,obj) {
        //获取图片名称
        var imgName = $(obj).prev().prev().val()
        console.log(action);
        //获取查看目录
        var href = '';
        switch(action)
        {
            case 'Video'://泛读视频
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_video']; ?>' + imgName
                break;
            case 'Poster'://泛读视频封面
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_cover_img']; ?>' + imgName
                break;
            default:
                href = '';
                break;
        }
        window.open(href);
    }
</script>


<script>
    //上传视频
    function uploadExtensiveVideo(obj) {
        var fileDom = $(obj);
        var btn = fileDom.next();
        fileDom.wrap('<form action="index.php?r=course/uploadvideo&read_type=extensive" method="post" enctype="multipart/form-data"></form>');
        $(obj).parent().parent().find('form').ajaxSubmit({
            dataType:  'json',
            beforeSend: function() {
                var percentVal = '0%';
                btn.addClass('disabled').text("上传中...");
            },
            uploadProgress: function(event, position, total, percentComplete) {
                btn.addClass('disabled').text("上传中..."+percentComplete + '%');
            },
            success: function(data) {
                if(data.code == 1){
                    btn.addClass('disabled').html("<span style='color: #00aa00'>上传成功</span>");
                    $(obj).parent().parent().prev().val(data.pic)
                }else{
                    alert('上传失败');
                }
                fileDom.unwrap();
            },
            error:function(xhr){
                alert('上传失败');
                fileDom.unwrap();
            }
        });
    }
    //上传图片
    function uploadExtensiveVideoImg(obj) {
        var action = 'Poster';
        var fileDom = $(obj);
        var btn = fileDom.next();
        var url = "index.php?r=course/uploadimg&action="+action
        fileDom.wrap('<form action="'+url+'" method="post" enctype="multipart/form-data"></form>');
        $(obj).parent().parent().find('form').ajaxSubmit({
            dataType:  'json',
            beforeSend: function() {
                var percentVal = '0%';
                btn.addClass('disabled').text("上传中...");
            },
            uploadProgress: function(event, position, total, percentComplete) {
                btn.addClass('disabled').text("上传中..."+percentComplete + '%');
            },
            success: function(data) {
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
</script>