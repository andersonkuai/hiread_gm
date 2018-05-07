<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= \Yii::t('app', '课程列表');?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?= \Yii::t('app', '主页');?></a></li>
        <li><a href="#"><?= \Yii::t('app', '课程管理');?></a></li>
        <li class="active"><?= \Yii::t('app', '课程列表');?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-primary" href="?r=course/add"><i class="fa fa-plus"></i> 添加</a>
                    </div>
                    <div class="box-tools">

                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th><?= \Yii::t('app', 'ID');?></th>
                            <th><?= \Yii::t('app', '课程名称');?></th>
                            <th><?= \Yii::t('app', '课程类别');?></th>
                            <th><?= \Yii::t('app', '课时');?></th>
                            <th><?= \Yii::t('app', '定价');?></th>
                            <th><?= \Yii::t('app', '售价');?></th>
                            <th><?= \Yii::t('app', '有效期');?></th>
                            <th><?= \Yii::t('app', '难度等级');?></th>
                            <th><?= \Yii::t('app', '适龄范围');?></th>
                            <th><?= \Yii::t('app', '精读书');?></th>
                            <th><?= \Yii::t('app', '泛读书');?></th>
                            <th><?= \Yii::t('app', '直播课');?></th>
                            <th><?= \Yii::t('app', '积分抵扣');?></th>
                            <th><?= \Yii::t('app', '操作');?></th>
                        </tr>

                        <?php foreach($orders as $val){?>
                            <tr>
                                <td><?php echo $val['CourseId']?></td>
                                <td><?php echo $val['ProdName']?></td>
                                <td><?php echo $val['CategoryName']?></td>
                                <td><?php echo $val['CourseTime']?></td>
                                <td><?php echo $val['Price']?></td>
                                <td><?php echo $val['DiscountPrice']?></td>
                                <td><?php echo $val['Expire']?></td>
                                <td><?php echo $val['Level']?></td>
                                <td><?php echo $val['MinAge'].'-'.$val['MaxAge']?></td>
                                <td><?php echo 0?></td>
                                <td><?php echo 0?></td>
                                <td><?php echo 0?></td>
                                <td><?php echo 0?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-default" href="/index.php?r=course/edit&id=<?php echo $val['CourseId']?>"><i class="fa fa-edit"></i> <?=\Yii::t('app','修改')?></a>
                                        <a class="btn btn-default" href="/index.php?r=course/structure&id=<?php echo $val['CourseId']?>"><i class="fa fa-edit"></i> <?=\Yii::t('app','课程结构')?></a>
                                    </div>
                                </td>
                            </tr>
                        <?php }?>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
<!--                    <div class="btn-group btn-group-sm" role="group">-->
<!--                        <button class="btn btn-default" onclick="UTILITY.CHECK.post('?r=user/status&status=0', '确定禁用？');">禁用</button>-->
<!--                        <button class="btn btn-default" onclick="UTILITY.CHECK.post('?r=user/status&status=10', '确定解禁？');">解禁</button>-->
<!--                    </div>-->
                    <?php echo $pageHtml;?>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->