<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= \Yii::t('app', '子单元题目列表');?>
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
        <li class="active"><?= \Yii::t('app', '题目管理');?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-primary" href="?r=topic/add-sub-unit-question&courseId=<?php echo $_GET['courseId'];?>&subUnitId=<?php echo $_GET['subUnitId'];?>"><i class="fa fa-plus"></i> 添加</a>
                        <a class="btn btn-default" href="?r=course/structure&type=2&id=<?=$_GET['courseId']?>"><i class="fa fa-arrow-circle-o-left"></i> <?= \Yii::t('app', '返回');?></a>
                    </div>
                    <div class="box-tools">

                    </div>
                </div>
                <!-- /.box-header -->
                <form role="form" id="myForm" action="" method="post" enctype="multipart/form-data">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th><?= \Yii::t('app', '题目ID');?></th>
                            <th><?= \Yii::t('app', '排序');?></th>
                            <th><?= \Yii::t('app', '题目跳出时间');?></th>
                            <th><?= \Yii::t('app', '题目名称');?></th>
                            <th><?= \Yii::t('app', '题目图片');?></th>
                            <th><?= \Yii::t('app', '题目类型');?></th>
                            <th><?= \Yii::t('app', '描述');?></th>
                            <th><?= \Yii::t('app', '操作');?></th>
                        </tr>

                        <?php foreach($question as $val){?>
                            <tr>
                                <td><?php echo $val['ID']?></td>
                                <td>
                                    <input style="width: 50px" type="hidden" name="topic_id[]" value="<?=$val['ID']?>">
                                    <input style="width: 50px" type="text" name="topic_order[]" value="<?=$val['Order']?>">
                                </td>
                                <td><?php echo $val['Min'].'分'.$val['Sec'].'秒'?></td>
                                <td><?php echo $val['Title']?></td>
                                <td>
                                    <a target="_blank" href="<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_unit_topic_img'].$val['Image']; ?>">
                                        <img width="30%" src="<?php if(!empty($val['Image'])) echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_unit_topic_img'].$val['Image']; ?>" alt="">
                                    </a>
                                </td>
                                <td><?php echo \common\enums\Topic::params('type')[$val['Type']]?></td>
                                <td><?php echo $val['PreviewIntro']?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-default" href="/index.php?r=topic/edit-unit-question&courseId=<?php echo $_GET['courseId'];?>&subUnitId=<?php echo $_GET['subUnitId'];?>&questionId=<?php echo $val['ID']?>"><i class="fa fa-edit"></i> <?=\Yii::t('app','修改')?></a>
                                        <a class="btn btn-default" href="javascript:void(0);" onclick="UTILITY.OPERATE.get('?r=topic/del-unit-question&courseId=<?php echo $_GET['courseId'];?>&subUnitId=<?php echo $_GET['subUnitId'];?>&questionId=<?php echo $val['ID']?>')"><i class="fa fa-trash-o"></i> <?=\Yii::t('app','删除')?></a>
                                    </div>
                                </td>
                            </tr>
                        <?php }?>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php if(!empty($question)){ ?>
                        <button type="submit" class="btn btn-primary">保存</button>
                    <?php } ?>
                </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->