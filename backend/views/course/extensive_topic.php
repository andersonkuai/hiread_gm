<style charset="UTF-8">
    .row_bg:hover{
        background-color: #2e9ad0;
    }
</style>
<script type="text/javascript" src="/assets/upload/jquery.form.js"></script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= \Yii::t('app', '配置题目');?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?= \Yii::t('app', '主页');?></a></li>
        <li><a href="#"><?= \Yii::t('app', '课程管理');?></a></li>
        <li class="active"><?php echo empty($row) ? \Yii::t('app', '添加') :\Yii::t('app', '编辑')?><?= \Yii::t('app', '配置题目');?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="?r=course/index"><i class="fa fa-arrow-circle-o-left"></i> <?= \Yii::t('app', '返回');?></a>
                        <span class="btn btn-info"><?= \Yii::t('app', '泛读');?></span>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                    <div class="box-body">
                        <div class="row" style="border: solid 1px;border-radius:10px;margin-bottom: 10px;">
                            <div class="col-xs-1">
                                <?= \Yii::t('app', '课程id');?>
                            </div>
                            <div class="col-xs-1">
                                <?= \Yii::t('app', '泛读id');?>
                            </div>
                            <div class="col-xs-3">
                                <?= \Yii::t('app', '泛读视频标题');?>
                            </div>
                            <div class="col-xs-3">
                                <?= \Yii::t('app', '视频名称');?>
                            </div>
                            <div class="col-xs-3">
                                <?= \Yii::t('app', '泛读视频封面');?>
                            </div>
                            <div class="col-xs-1">
                                <?= \Yii::t('app', '操作');?>
                            </div>
                        </div>
                        <?php if (!empty($extensiveTopicList)){ ?>
                            <?php foreach ($extensiveTopicList as $k=>$v){ ?>
                                <div class="row row_bg" style="border: solid 1px;border-radius:10px;margin-bottom: 10px;">
                                    <div class="col-xs-1">
                                        <?= $v['CourseId']?>
                                    </div>
                                    <div class="col-xs-1">
                                        <?= $v['ID']?>
                                    </div>
                                    <div class="col-xs-3">
                                        <?= $v['Title']?>
                                    </div>
                                    <div class="col-xs-3">
                                        <?= $v['Video']?>
                                    </div>
                                    <div class="col-xs-3">
                                        <?= $v['Poster']?>
                                    </div>
                                    <div class="col-xs-1">
                                        <a href="##" onclick="showTopic(this)"><span class="fa fa-arrow-down"></span></a>
                                    </div>
                                </div>
                                <div class="row topic" style="display: none">
                                    <div class="col-xs-11 col-md-offset-1">
                                        <?php require('questions.php');?>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php }else{ ?>
                            <?= \Yii::t('app', '暂无泛读数据');?>
                        <?php } ?>
                    </div>
                    <!-- /.box-body -->
            </div>

        </div>
    </div>
</section>
<!-- /.content -->
<script type="text/javascript">
    //展示题目
    function showTopic(obj) {
        $(obj).parent().parent().next().toggle();
    }


</script>