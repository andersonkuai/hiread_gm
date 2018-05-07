<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= \Yii::t('app', '课程结构');?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?= \Yii::t('app', '主页');?></a></li>
        <li><a href="#"><?= \Yii::t('app', '课程管理');?></a></li>
        <li class="active"><?= \Yii::t('app', '课程结构');?></li>
    </ol>
</section>
<!-- Main content -->
<?php if(!empty($extensive)){ ?>
    <?php require_once('extensive.php');?>
<?php }elseif(!empty($unit)){ ?>
    <?php require_once('unit.php');?>
<?php }else{?>
    <section class="content">
        <div class="box-header with-border">
            <div class="btn-group btn-group-sm" role="group">
                <a class="btn btn-default" href="?r=course/index"><i class="fa fa-arrow-circle-o-left"></i> <?= \Yii::t('app', '返回');?></a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h3><?= \Yii::t('app', '抱歉，暂无课程结构');?></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <a href="?r=course/add-extensive&courseId=<?php echo $courseId;?>" class="btn btn-info">添加泛读</a>
                <a href="?r=course/add-unit&courseId=<?php echo $courseId;?>" class="btn btn-danger">添加单元</a>
            </div>
        </div>
    </section>
<?php }?>
<!-- /.content -->