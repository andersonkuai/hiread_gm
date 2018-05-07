<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= \Yii::t('app', '每日朗读');?>
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
        <li class="active"><?= \Yii::t('app', '每日朗读');?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-primary" href="?r=course/add-read&courseId=<?php echo $_GET['courseId'];?>&unitId=<?php echo $_GET['unitId'];?>"><i class="fa fa-plus"></i> 添加</a>
                        <a class="btn btn-default" href="?r=course/structure&type=2&id=<?php echo $_GET['courseId'];?>"><i class="fa fa-arrow-circle-o-left"></i> <?= \Yii::t('app', '返回');?></a>
                    </div>
                    <div class="box-tools">

                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th><?= \Yii::t('app', 'ID');?></th>
                            <th><?= \Yii::t('app', '课程id');?></th>
                            <th><?= \Yii::t('app', '单元id');?></th>
                            <th><?= \Yii::t('app', '名称');?></th>
                            <th><?= \Yii::t('app', '章节');?></th>
                            <th><?= \Yii::t('app', '页码');?></th>
                            <th><?= \Yii::t('app', '段落');?></th>
                            <th><?= \Yii::t('app', '音频');?></th>
                            <th><?= \Yii::t('app', '必读内容');?></th>
                            <th><?= \Yii::t('app', '操作');?></th>
                        </tr>

                        <?php foreach($catalog as $val){?>
                            <tr>
                                <td><?php echo $val['ID']?></td>
                                <td><?php echo $_GET['courseId']?></td>
                                <td><?php echo $val['UnitID']?></td>
                                <td><?php echo $val['Name']?></td>
                                <td><?php echo $val['Chapter']?></td>
                                <td><?php echo $val['Page']?></td>
                                <td><?php echo $val['Segment']?></td>
                                <td>
                                    <a target="_blank" href="<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_read_audio'].$val['AudioUrl']; ?>">
                                        <?php echo $val['AudioUrl']?>
                                    </a>
                                </td>
                                <td><?php echo $val['Content']?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-default" href="/index.php?r=course/edit-read&id=<?php echo $val['ID']?>&courseId=<?php echo $_GET['courseId']?>&unitId=<?php echo $_GET['unitId']?>"><i class="fa fa-edit"></i> <?=\Yii::t('app','修改')?></a>
                                        <a class="btn btn-xs btn-default" href="javascript:void(0);" onclick="UTILITY.OPERATE.get('?r=course/del-read&courseId=<?php echo $_GET['courseId'];?>&unitId=<?php echo $_GET['unitId']?>&id=<?php echo $val['ID']?>');"><i class="fa fa-trash-o"></i> <?=\Yii::t('app','删除')?></a>
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
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->