<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo empty($row) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','文章主题')?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?=\Yii::t('app','主页')?></a></li>
        <li><a href="#"><?=\Yii::t('app','文章列表')?></a></li>
        <li class="active"><?php echo empty($row) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','文章主题')?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="?r=wx-article-theme/index"><i class="fa fa-arrow-circle-o-left"></i> <?=\Yii::t('app','返回')?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="myForm" action="" method="post">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label><?=\Yii::t('app','主题')?></label>
                                    <input class="form-control" name="theme"  type="text" value="<?php echo empty($row) ? '' : $row['theme'];?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label><?=\Yii::t('app','图片')?></label>
                                    <input class="form" name="img" type="text" value="<?php echo !empty($row['img'])? $row['img'] : '' ?>">
                                    <span  id="questionPicTr">
                                        <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadImg('wx_article_theme',this)" accept="image/*" />
                                        <span class="btn-upload" id="CoverImg_btn"></span>
                                    </span>&nbsp;&nbsp;
                                    <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('wx_article_theme',this)"><?= \Yii::t('app', '查看');?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <input type="hidden" name="id" value="<?php if(!empty($row)) echo $row['id']?>"/>
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
    //上传图片
    function uploadImg(action,obj) {
        var fileDom = $(obj);
        var btn = $(obj).next()
        var url = "index.php?r=wx-article/uploadimg&action="+action
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
            case 'wx_article_theme'://泛读配对音频
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_wx_article_theme']; ?>' + imgName
                break;
            default:
                href = '';
                break;
        }
        window.open(href);
    }
</script>