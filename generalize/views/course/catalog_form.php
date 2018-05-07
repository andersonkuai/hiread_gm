<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo empty($row) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','课程目录')?>
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
        <li class="active">
            <a href="?r=course/catalog&courseId=<?=$_GET['courseId'];?>&subUnitId=<?=$_GET['subUnitId'];?>">
                <?= \Yii::t('app', '课程目录');?>
            </a>
        </li>
        <li class="active"><?php echo empty($row) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?><?=\Yii::t('app','课程目录')?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="?r=course/catalog&courseId=<?=$_GET['courseId'];?>&subUnitId=<?=$_GET['subUnitId'];?>"><i class="fa fa-arrow-circle-o-left"></i> <?=\Yii::t('app','返回')?></a>
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
                                        <td><?= \Yii::t('app', '课程ID');?>：</td>
                                        <td>
                                            <?=$_GET['courseId']?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '子单元ID');?>：</td>
                                        <td>
                                            <?=$_GET['subUnitId']?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '目录名称');?>：</td>
                                        <td>
                                            <input type="text" name="Name" value="<?php if(!empty($row)) echo $row['Name'];?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '视频停留分钟数');?>：</td>
                                        <td>
                                            <input type="text" name="Min" value="<?php echo !empty($row['Min']) ? $row['Min'] : 0;?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '视频停留秒数');?>：</td>
                                        <td>
                                            <input type="text" name="Sec" value="<?php echo !empty($row['Sec']) ? $row['Sec'] : 0;?>">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <input type="hidden" name="catalogId" value="<?php echo !empty($row) ? $row['ID'] : '';?>"/>
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
                    location.reload();
                }
            }
        });
    });
    //添加子单元
    function addSubUnit(obj) {
        var dom = $(obj).parent().parent();
        var html = '<tr>' + dom.html() + '</tr>';
        dom.after(html)
    }
    //删除子单元
    function minusSubUnit(obj) {
        var dom = $(obj).parent().parent();
        dom.remove()
    }
</script>
