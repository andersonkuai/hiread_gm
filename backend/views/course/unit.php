<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-primary" href="?r=course/add-unit&courseId=<?php echo $_GET['id'];?>"><i class="fa fa-plus"></i> 添加</a>
                        <a class="btn btn-default" href="?r=course/index"><i class="fa fa-arrow-circle-o-left"></i> <?= \Yii::t('app', '返回');?></a>
                    </div>
                    <div class="box-tools">

                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <th><?= \Yii::t('app', '单元ID');?></th>
                            <th><?= \Yii::t('app', '课程ID');?></th>
                            <th><?= \Yii::t('app', '单元名称');?></th>
                            <th><?= \Yii::t('app', 'OpenDay');?></th>
                            <th><?= \Yii::t('app', '操作');?></th>
                        </tr>

                        <?php foreach($unit as $val){?>
                            <tr class="info" onclick="showSubUnit(this)">
                                <td><?php echo $val['ID']?></td>
                                <td><?php echo $val['CourseId']?></td>
                                <td><?php echo $val['Name']?></td>
                                <td><?php if(!empty($val['OpenDay'])){echo date('Ymd',$val['OpenDay']);}else{echo 0;};?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-default" href="/index.php?r=course/edit-unit&courseId=<?php echo $_GET['id'];?>&unitId=<?php echo $val['ID']?>"><i class="fa fa-edit"></i> <?=\Yii::t('app','修改')?></a>
                                        <a class="btn btn-default" href="/index.php?r=course/add-sub-unit&courseId=<?php echo $_GET['id'];?>&unitId=<?php echo $val['ID']?>"><i class="fa fa-plus"></i> <?=\Yii::t('app','添加子单元')?></a>
                                        <a class="btn btn-xs btn-default" href="/index.php?r=course/read&courseId=<?php echo $_GET['id'];?>&unitId=<?php echo $val['ID']?>"><i class="fa fa-edit"></i> <?=\Yii::t('app','每日朗读')?></a>
                                        <a class="btn btn-default" href="javascript:void(0);" onclick="UTILITY.OPERATE.get('?r=course/del-unit&courseId=<?php echo $_GET['id'];?>&unitId=<?php echo $val['ID']?>');"><i class="fa fa-trash-o"></i> <?=\Yii::t('app','删除')?></a>
                                    </div>
                                </td>
                            </tr>
                            <tr style="display: none">
                                <td colspan="5">
                                    <?php if(!empty($val['subUnit'])){?>
                                        <table class="table table-hover">
                                            <tr>
                                                <th>子单元ID</th>
                                                <th>子单元类型：</th>
                                                <th>单元名称：</th>
                                                <th>操作</th>
                                            </tr>
                                            <?php foreach ($val['subUnit'] as $k=>$v){?>
                                                <tr class="success">
                                                    <td><?=$v['ID']?></td>
                                                    <td><?=\common\enums\subUnit::params('type')[$v['Type']]?></td>
                                                    <td><?=$v['Name']?></td>
                                                    <td>
                                                        <a class="btn btn-xs btn-default" href="/index.php?r=course/edit-sub-unit&courseId=<?php echo $_GET['id'];?>&unitId=<?php echo $val['ID']?>&subUnitId=<?php echo $v['ID']?>"><i class="fa fa-edit"></i> <?=\Yii::t('app','修改')?></a>
                                                        <a class="btn btn-xs btn-default" href="/index.php?r=topic/unit-index&courseId=<?php echo $_GET['id'];?>&unitId=<?php echo $val['ID']?>&subUnitId=<?php echo $v['ID']?>"><i class="fa fa-edit"></i> <?=\Yii::t('app','题目管理')?></a>
                                                        <a class="btn btn-xs btn-default" href="/index.php?r=course/catalog&courseId=<?php echo $_GET['id'];?>&unitId=<?php echo $val['ID']?>&subUnitId=<?php echo $v['ID']?>"><i class="fa fa-edit"></i> <?=\Yii::t('app','课程目录')?></a>
                                                        <a class="btn btn-xs btn-default" href="/index.php?r=course/word&courseId=<?php echo $_GET['id'];?>&unitId=<?php echo $val['ID']?>&subUnitId=<?php echo $v['ID']?>"><i class="fa fa-edit"></i> <?=\Yii::t('app','视频词汇表')?></a>
                                                        <a class="btn btn-xs btn-default" href="javascript:void(0);" onclick="UTILITY.OPERATE.get('?r=course/del-sub-unit&courseId=<?php echo $_GET['id'];?>&unitId=<?php echo $val['ID']?>&subUnitId=<?php echo $v['ID']?>');"><i class="fa fa-trash-o"></i> <?=\Yii::t('app','删除')?></a>
                                                    </td>
                                                </tr>
                                            <?php }?>
                                        </table>
                                    <?php }?>
                                </td>
                            </tr>
                        <?php }?>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->
<script>
    //展示子单元
    function showSubUnit(obj) {
        $(obj).next().toggle();
    }
</script>