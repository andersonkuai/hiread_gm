<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo empty($subUnit) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','子单元')?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?=\Yii::t('app','主页')?></a></li>
        <li><a href="#"><?=\Yii::t('app','课程结构')?></a></li>
        <li class="active"><?php echo empty($subUnit) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','子单元')?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="?r=course/structure&type=2&id=<?php echo $_GET['courseId'];?>"><i class="fa fa-arrow-circle-o-left"></i> <?=\Yii::t('app','返回')?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="myForm" action="" method="post">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-8">
                                单元ID：<?php echo $unit['ID'];?>&nbsp;&nbsp;&nbsp;单元名称：<?php echo $unit['Name'];?>
                                <table style="margin-bottom: 30px">
                                    <tr>
                                        <td><?= \Yii::t('app', '子单元名称');?>：</td>
                                        <td>
                                            <input class="form" name="Name" type="text" value="<?php echo empty($subUnit) ? '' : $subUnit['Name'];?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '子单元类型');?>：</td>
                                        <td>
                                            <select name="Type" id="">
                                                <?php foreach (\common\enums\subUnit::params('type') as $key_t=>$val_t){ ?>
                                                    <option value="<?= $key_t;?>" <?php if(!empty($subUnit['Type']) && $key_t == $subUnit['Type']) echo 'selected';?>><?= $val_t;?></option>
                                                <?php }?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <?php if(!empty($subUnit)){?>
                            <input type="hidden" name="subUnitId" value="<?php echo $subUnit['ID']?>"/>
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
//    function uploadExtensiveVideo(obj) {
//        var fileDom = $(obj);
//        var btn = fileDom.next();
//        fileDom.wrap('<form action="index.php?r=course/uploadvideo&read_type=extensive" method="post" enctype="multipart/form-data"></form>');
//        $(obj).parent().parent().find('form').ajaxSubmit({
//            dataType:  'json',
//            beforeSend: function() {
//                var percentVal = '0%';
//                btn.addClass('disabled').text("上传中...");
//            },
//            uploadProgress: function(event, position, total, percentComplete) {
//                btn.addClass('disabled').text("上传中..."+percentComplete + '%');
//            },
//            success: function(data) {
//                if(data.code == 1){
//                    btn.addClass('disabled').html("<span style='color: #00aa00'>上传成功</span>");
//                    $(obj).parent().parent().prev().val(data.pic)
//                }else{
//                    alert('上传失败');
//                }
//                fileDom.unwrap();
//            },
//            error:function(xhr){
//                alert('上传失败');
//                fileDom.unwrap();
//            }
//        });
//    }
    //上传图片
//    function uploadExtensiveVideoImg(obj) {
//        var action = 'Poster';
//        var fileDom = $(obj);
//        var btn = fileDom.next();
//        var url = "index.php?r=course/uploadimg&action="+action
//        fileDom.wrap('<form action="'+url+'" method="post" enctype="multipart/form-data"></form>');
//        $(obj).parent().parent().find('form').ajaxSubmit({
//            dataType:  'json',
//            beforeSend: function() {
//                var percentVal = '0%';
//                btn.addClass('disabled').text("上传中...");
//            },
//            uploadProgress: function(event, position, total, percentComplete) {
//                btn.addClass('disabled').text("上传中..."+percentComplete + '%');
//            },
//            success: function(data) {
//                if(data.code == 1){
//                    btn.addClass('disabled').html("<span style='color: #00aa00'>上传成功</span>");
//                    $(obj).parent().parent().prev().val(data.pic)
//                }
//                fileDom.unwrap();
//            },
//            error:function(xhr){
//                alert('上传失败');
//                fileDom.unwrap();
//            }
//        });
//    }
</script>