<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-primary" href="?r=course/add-extensive&courseId=<?php echo $_GET['id'];?>"><i class="fa fa-plus"></i> 添加</a>
                        <a class="btn btn-default" href="?r=course/index"><i class="fa fa-arrow-circle-o-left"></i> <?= \Yii::t('app', '返回');?></a>
                    </div>
                    <div class="box-tools">

                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th><?= \Yii::t('app', '泛读ID');?></th>
                            <th><?= \Yii::t('app', '课程ID');?></th>
                            <th><?= \Yii::t('app', '泛读视频标题');?></th>
                            <th><?= \Yii::t('app', '视频');?></th>
                            <th><?= \Yii::t('app', '泛读视频封面');?></th>
                            <th><?= \Yii::t('app', 'OpenDay');?></th>
                            <th><?= \Yii::t('app', '操作');?></th>
                        </tr>

                        <?php foreach($extensive as $val){?>
                            <tr>
                                <td><?php echo $val['ID']?></td>
                                <td><?php echo $val['CourseId']?></td>
                                <td><?php echo $val['Title']?></td>
                                <td>
                                    <a target="_blank" href="<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_video'].$val['Video']; ?>">
                                        <?php echo $val['Video'];?>
                                    </a>
                                </td>
                                <td>
                                    <a target="_blank" href="<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_cover_img'].$val['Poster']; ?>">
                                        <img width="30%" src="<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_cover_img'].$val['Poster']; ?>" alt="">
                                    </a>
                                </td>
                                <td><?php if(!empty($val['OpenDay'])){echo date('Ymd',$val['OpenDay']);}else{echo 0;};?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-default" href="/index.php?r=course/edit-extensive&courseId=<?php echo $_GET['id'];?>&extensiveId=<?php echo $val['ID']?>"><i class="fa fa-edit"></i> <?=\Yii::t('app','修改')?></a>
                                        <a class="btn btn-default" href="/index.php?r=topic/extensive-index&courseId=<?php echo $_GET['id'];?>&extensiveId=<?php echo $val['ID']?>"><i class="fa fa-edit"></i> <?=\Yii::t('app','题目管理')?></a>
                                        <a class="btn btn-default" href="javascript:void(0);" onclick="UTILITY.OPERATE.get('?r=course/del-extensive&courseId=<?php echo $_GET['id'];?>&extensiveId=<?php echo $val['ID']?>');"><i class="fa fa-trash-o"></i> <?=\Yii::t('app','删除')?></a>
                                    </div>
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